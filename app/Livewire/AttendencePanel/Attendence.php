<?php

namespace App\Livewire\AttendencePanel;

use Livewire\Component;
use App\Models\Attendence as AttendenceModel;
use App\Models\User;
use App\Models\RolePermissionMap;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
class Attendence extends Component
{
    public $currentusrpermissions = [];
    public $rows = [];
    public $datepicker;
    public $statusdd = [];
    public $enter_time = [];
    public $exit_time = [];
    public $error;
    public function view()
    {
        $this->rows = AttendenceModel::whereDate('created_at', $this->datepicker)
                                    ->with('user')->get();

        foreach ($this->rows as $row) {
            $this->statusdd[$row->id] = $row->attendence_status;
            $this->enter_time[$row->id] = $row->enter_time;
            $this->exit_time[$row->id] = $row->exit_time;
        }

    }
    public function addusers()
    {
        if(!in_array('edit',$this->currentusrpermissions))
        {
            $this->error = 'You dont have permission to edit attendence';
            return;
        }
        $users = User::all();
        foreach($users as $user)
        {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $attendence = AttendenceModel::whereDate('created_at',$date->toDateString())->where('user_id',$user->id)->count();
                if($attendence == 0)
                {
                        $insertatten = new AttendenceModel();
                        $insertatten->user_id = $user->id;
                        $insertatten->enter_time = '00:00:00';
                        $insertatten->exit_time = '00:00:00';
                        $insertatten->attendence_status = 'Absent';
                        $insertatten->created_at = $date;
                        $insertatten->updated_at = $date;
                        
                        $insertatten->save();
                }
            }
        }
    }
    public function mount()
    {
        $this->permissions();
        if(!in_array('view',$this->currentusrpermissions))
        {
            $this->error = 'You dont have permission to view attendence';
            return;
        }
        $this->datepicker = Carbon::today()->toDateString();
        $this->addusers();
        $this->view();

    }
    public function dateselect()
    {
        
        $this->view();
    }
    public function update($id)
    {
        if(!in_array('edit',$this->currentusrpermissions))
        {
            $this->error = 'You dont have permission to update attendence';
            return;
        }
        $attendence = AttendenceModel::findOrFail($id);
        $attendence->attendence_status = $this->statusdd[$id]; // get value for that row
        $attendence->enter_time = $this->enter_time[$id];
        $attendence->exit_time = $this->exit_time[$id];
        $attendence->save();
    }
    public function permissions()
    {
        $this->currentusrpermissions = RolePermissionMap::where('role_id', Auth::user()->role_id)
        ->whereRelation('permissionrelation', 'module', 'attendence')
        ->get()
        ->pluck('permissionrelation.action')  // now works on the collection
        ->flatten()                           // flatten in case of multiple relations
        ->toArray();
    }
    public function render()
    {
        
        return view('livewire.attendence-panel.attendence');
    }
}
