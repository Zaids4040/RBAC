<?php

namespace App\Livewire\UserDashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\Package;
use App\Models\Lead;
use App\Models\User;
use App\Models\RolePermissionMap;
use App\Models\Leadsdocument;
use App\Models\Attendence;
use App\Models\Emailsetting;
use App\Models\Emailconfig;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendEmail;

class UsrDashboard extends Component
{
    use WithFileUploads;

    public $name;
    public $phone;
    public $locationlink;
    public $emirateid = [];
    public $package;
    public $leadmodal = false;
    public $company;
    public $packagetype;
    public $packages = [];
    public $leads = [];
    public $selectdays = 7;
    public $statusdd = -1;
    public $total_leads = 0;
    public $success_leads = 0;
    public $pending_leads = 0;
    public $rejected_leads = 0;
    public $paid_leads = 0;
    public $totalcommission = 0;
    public $pendingcommission = 0;
    public $successcommission = 0;
    public $paidcommission = 0;
    public $error;
    public $totalpresent;
    public $totalabsent;
    public $totalleaves;
    public $totallates;
    public $startDate;
    public $endDate;
    public $emailtxt;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:100',
        'locationlink' => 'required|string|max:1000',
        'emirateid' => 'required|array',
        'emirateid.*' => 'file|mimes:jpg,jpeg,png,pdf|max:15120',
        'package' => 'required|numeric',
        'emailtxt' => 'required|email'
    ];
    public function openmodal()
    {        
        $this->leadmodal = true;
    }
    public function selectedDaysCount()
    {
        if (!$this->startDate || !$this->endDate) {
            return 0;
        }

        $start = Carbon::parse($this->startDate);
        $end   = Carbon::parse($this->endDate);

        // inclusive count (start + end day included)
        $this->selectdays =  $start->diffInDays($end) + 1;
    }

    public function attendence_calculate()
    {
        $query = Attendence::where('user_id', Auth::id());

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ]);
        }

        $this->totalpresent = (clone $query)->where('attendence_status','Present')->count();
        $this->totalabsent  = (clone $query)->where('attendence_status','Absent')->count();
        $this->totalleaves  = (clone $query)->where('attendence_status','Leave')->count();
        $this->totallates   = (clone $query)->where('attendence_status','Late')->count();
    }

    public function packagefilter()
    {
        if($this->company != null && $this->packagetype != null)
        {
            $this->packages = Package::where('package_type',$this->packagetype)->where('package_company',$this->company)->where('status',1)->get();
        }   
    }
    public function closemodal()
    {
        $this->leadmodal = false;
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        try
        {
            $leads = new Lead();
            $leads->name = $this->name;
            $leads->phone = $this->phone;
            $leads->locationlink = $this->locationlink;
            $leads->package_id = $this->package;
            $leads->email = $this->emailtxt;
            $leads->user_id = Auth::user()->id;
            $leads->status = 0;
            $leads->save();
            $lead_id = $leads->id;

            foreach ($this->emirateid as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . Str::random(10) . '.' . $extension;
                $path = $file->storeAs('emirates_id', $filename, 'public');
                $document = new Leadsdocument();
                $document->lead_id = $lead_id;
                $document->path = $path;
                $document->save();
            }
            DB::commit();
            SendEmail::dispatch(Auth::user()->name,$this->name,$this->phone);
            $this->reset();
            $this->startDate = now()->subDays(7)->format('Y-m-d');
            $this->endDate   = now()->format('Y-m-d');
            $this->cards();
            $this->view();
            $this->attendence_calculate();
            $this->selectedDaysCount();
        }
        catch(Exception $e)
        {
            DB::rollBack();
            $this->error = $e->getMessage();
        }
    }
    public function view()
    {
        $query = Lead::with('package');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ]);
        }

        if ($this->statusdd != -1) {
            $query->where('status', $this->statusdd);
        }

        $this->leads = $query->get();
    }

    public function cards()
    {
        $userId = Auth::id();

        $baseQuery = Lead::where('user_id', $userId);

        // ✅ Date range filter
        if ($this->startDate && $this->endDate) {
            $baseQuery->whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ]);
        }

        // --- Lead Counts ---
        $this->total_leads     = (clone $baseQuery)->count();
        $this->success_leads   = (clone $baseQuery)->where('status', 1)->count();
        $this->pending_leads   = (clone $baseQuery)->where('status', 0)->count();
        $this->paid_leads      = (clone $baseQuery)->where('status', 2)->count();
        $this->rejected_leads  = (clone $baseQuery)->where('status', 3)->count();
        
        // --- Commission ---
        $this->totalcommission = (clone $baseQuery)
            ->where('status', '!=', 3)
            ->withSum('package', 'commission')
            ->get()
            ->sum('package_sum_commission');

        $this->pendingcommission = (clone $baseQuery)
            ->where('status', 0)
            ->withSum('package', 'commission')
            ->get()
            ->sum('package_sum_commission');

        $this->successcommission = (clone $baseQuery)
            ->where('status', 1)
            ->withSum('package', 'commission')
            ->get()
            ->sum('package_sum_commission');

        $this->paidcommission = (clone $baseQuery)
            ->where('status', 2)
            ->withSum('package', 'commission')
            ->get()
            ->sum('package_sum_commission');

            $this->view();
            $this->attendence_calculate();
            $this->selectedDaysCount();
    }

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = now()->format('Y-m-d');

        $this->cards();
        $this->view();
        $this->attendence_calculate();
        $this->selectedDaysCount();
    }


    public function render()
    {
        return view('livewire.user-dashboard.usr-dashboard');
    }
}
