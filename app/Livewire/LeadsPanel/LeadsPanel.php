<?php

namespace App\Livewire\LeadsPanel;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Lead;
use App\Models\RolePermissionMap;
use App\Models\Leadsdocument;
use App\Models\Package;
use Livewire\WithFileUploads;
use App\Jobs\SendEmail;
use ZipArchive;
use Illuminate\Support\Facades\Auth;
class LeadsPanel extends Component
{
    use WithFileUploads;
    public $currentusrpermissions = [];

    public $leads = [];
    public $leadmodal = false;
    public $name;
    public $phone;
    public $locationlink;
    public $emirateid = [];
    public $package;
    public $statusdd = -1;
    public $usersdd = -1;
    public $editid = 0;
    public $remarkstxt = [];
    public $packages = [];
    public $users = [];
    public $userid;
    public $error;
    public $columndd = 'accnumber';
    public $searchtxt;
    public $accountxt = [];
    public function permissions()
    {
        $this->currentusrpermissions = RolePermissionMap::where('role_id', Auth::user()->role_id)
        ->whereRelation('permissionrelation', 'module', 'leads')
        ->get()
        ->pluck('permissionrelation.action')  // now works on the collection
        ->flatten()                           // flatten in case of multiple relations
        ->toArray();
    }
    public function view()
    {
        if (!in_array('view', $this->currentusrpermissions)) {
            $this->error = 'You don’t have permission to view leads';
            return;
        }
        
        $query = Lead::with('user');

        if ($this->statusdd != -1) {
            $query->where('status', $this->statusdd);
        }
        if ($this->usersdd != -1) {
            $query->where('user_id', $this->usersdd);
        }
        if($this->searchtxt != '' && $this->columndd)
        {
            if($this->columndd == 'package_id')
            {
                $query->whereRelation('package','name','like','%'. $this->searchtxt .'%');    
            }
            else
            {
                $query->where($this->columndd,'like', '%'. $this->searchtxt .'%');
            }
            
        }

        $this->leads = $query->get();
    }

    private function resetInput()
    {
        $this->name = '';
        $this->phone = '';
        $this->locationlink = '';
        $this->emirateid = null;
        $this->package = null;
        $this->leadmodal = false;
        $this->editid = 0;
    }
    public function updateremarks($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->note = $this->remarkstxt[$id];
        $lead->save();
        SendEmail::dispatch(Auth::user()->name,$lead->name,$lead->phone,$lead->status,$this->remarkstxt[$id]);
    }
    public function updateStatus($id, $status)
    {
        if(!in_array('edit',$this->currentusrpermissions))
        {
            $this->error = 'You dont have permission view leads';
            return;
        }
        $lead = Lead::findOrFail($id);
        $lead->status = $status;
        $lead->save();
    }
    public function closemodal()
    {
        $this->leadmodal = false;
    }
    public function edit($id)
    {
        if(!in_array('edit',$this->currentusrpermissions))
        {
            $this->error = 'You dont have permission view leads';
            return;
        }
        $leads = Lead::with('package')->findOrFail($id);

        $this->name = $leads->name;
        $this->phone = $leads->phone;
        $this->locationlink = $leads->locationlink;
        $this->editid = $id;
        $this->userid = $leads->user_id;
        $this->package = $leads->package_id;
        $this->leadmodal = true;
        
    }
   
    public function save()
    {
        if(!in_array('create',$this->currentusrpermissions))
        {
            $this->error = 'You dont have permission create leads';
            return;
        }
        if ($this->editid != 0) {
            if(!in_array('edit',$this->currentusrpermissions))
            {
                $this->error = 'You dont have permission edit leads';
                return;
            }
            // Update existing
            $lead = Lead::findOrFail($this->editid);

            if ($this->emirateid) {
                $documents = Leadsdocument::where('lead_id',$lead->id)->get();
                foreach($documents as $docs)
                {
                    if ($docs->path && Storage::disk('public')->exists($docs->path)) {
                        Storage::disk('public')->delete($docs->path);
                    }
                }   
            }
        }
        else
        {
            $lead = new Lead();
        }
        $lead->name = $this->name;
        $lead->phone = $this->phone;
        $lead->locationlink = $this->locationlink;
        $lead->package_id = $this->package;
        $lead->user_id = $this->userid;
        $lead->status = 0;
        $lead->save();
        if ($this->emirateid) {
            foreach ($this->emirateid as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . Str::random(10) . '.' . $extension;
                $path = $file->storeAs('emirates_id', $filename, 'public');
                $document = new Leadsdocument();
                $document->lead_id = $lead->id;
                $document->path = $path;
                $document->save();
            }
        }
        

        $this->resetInput();
        $this->view();
    }
    public function openmodal()
    {
        $this->reset(['leadmodal','name','phone','locationlink','package','editid','userid']);
        $this->emirateid = [];
        $this->leadmodal = true;
    }
    public function delete($id)
    {
        if(!in_array('delete',$this->currentusrpermissions))
        {
            $this->error = 'You dont have permission view leads';
            return;
        }
        $lead = Lead::findOrFail($id);

        $documents = Leadsdocument::where('lead_id',$lead->id)->get();
        foreach($documents as $docs)
        {
            if ($docs->path && Storage::disk('public')->exists($docs->path)) {
                Storage::disk('public')->delete($docs->path);
            }
            $docs->delete();
        }

        $lead->delete();
        $this->view();
    }
    public function downloadZip($id)
    {
        $documents = Leadsdocument::where('lead_id', $id)->get();

        if ($documents->isEmpty()) {
            abort(404, 'No documents found');
        }

        $zipFileName = 'lead_documents_'.$id.'.zip';
        $zipPath = storage_path('app/public/'.$zipFileName);

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {

            foreach ($documents as $doc) {
                // full file path
                $filePath = storage_path('app/public/'.$doc->path);

                if (file_exists($filePath)) {
                    // second param = name inside zip
                    $zip->addFile($filePath, basename($doc->path));
                }
            }

            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
    public function users_list()
    {
        $this->users = User::all();
    }
    public function accountupdate($id)
    {
        $leads = Lead::findOrFail($id);
        $leads->accountnum = $this->accountxt[$id];
        $leads->save();
    }
    public function mount()
    {
        $this->permissions();
        if(!in_array('view',$this->currentusrpermissions))
        {
            $this->error = 'You dont have permission visit this page';
            return;
        }
        $this->users_list();
        $this->packages = Package::all();
        $this->view();
        foreach($this->leads as $lead)
        {
            $this->remarkstxt[$lead->id] = $lead->note;
            $this->accountxt[$lead->id] = $lead->accountnum;
        }
        
    }
    public function render()
    {
        return view('livewire.leads-panel.leads-panel');
    }
}
