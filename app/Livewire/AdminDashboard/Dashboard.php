<?php

namespace App\Livewire\AdminDashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Lead;
use App\Models\Attendence;
use Carbon\Carbon;
class Dashboard extends Component
{
    public $userscount = 0;
    public $presentusers = 0;
    public $absentusers = 0;
    public $lateusers = 0;
    public $leaveusers = 0;
    public $pendingleads = 0;
    public $successleads = 0;
    public $rejectedleads = 0;
    public $wirelessleads = 0;
    public $gsmleads = 0;
    public $fiberleads = 0;
    public $paidleads = 0;
    public $paidamount = 0;
    public $attendencepercentage = 0;
    public $startDate;
    public $endDate;

    public function filter()
    {
        $this->pendingleads = Lead::where('status',0)->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->count();
        $this->successleads = Lead::where('status',1)->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->count();
        $this->paidleads = Lead::where('status',2)->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->count();
        $this->rejectedleads = Lead::where('status',3)->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->count();
        $this->wirelessleads = Lead::whereRelation('package','package_type','wireless')->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->count();
        $this->gsmleads = Lead::whereRelation('package','package_type','gsm')->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->count();
        $this->fiberleads = Lead::whereRelation('package','package_type','fiber')->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->count();
        $this->paidamount = Lead::where('status',2)->withSum('package', 'commission')->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])
            ->get()
            ->sum('package_sum_commission');

    }
    public function mount()
    {
        $this->startDate = now()->subDays(7)->format('Y-m-d');
        $this->endDate   = now()->format('Y-m-d');
        $this->userscount = User::count();
        $this->presentusers  = Attendence::whereDate('created_at',Carbon::today()->toDateString())->where('attendence_status','Present')->count();
        $this->absentusers = Attendence::whereDate('created_at',Carbon::today()->toDateString())->where('attendence_status','Absent')->count();
        $this->lateusers = Attendence::whereDate('created_at',Carbon::today()->toDateString())->where('attendence_status','Late')->count();
        $this->leaveusers = Attendence::whereDate('created_at',Carbon::today()->toDateString())->where('attendence_status','Leave')->count();

        $this->pendingleads = Lead::where('status',0)->count();
        $this->successleads = Lead::where('status',1)->count();
        $this->paidleads = Lead::where('status',2)->count();
        $this->rejectedleads = Lead::where('status',3)->count();
        $this->wirelessleads = Lead::whereRelation('package','package_type','wireless')->count();
        $this->gsmleads = Lead::whereRelation('package','package_type','gsm')->count();
        $this->fiberleads = Lead::whereRelation('package','package_type','fiber')->count();
        $this->paidamount = Lead::where('status',2)->withSum('package', 'commission')
            ->get()
            ->sum('package_sum_commission');
        $this->attendencepercentage = ($this->presentusers / $this->userscount)*100;
        

    }
    public function render()
    {
        return view('livewire.admin-dashboard.dashboard');
    }
}
