<?php

namespace App\Livewire\Accounts;

use Livewire\Component;
use App\Models\Package;
use App\Models\Lead;
use App\Models\User;
use App\Models\Account;
use App\Models\Attendence;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class Accounts extends Component
{
    public $creditcommission = 0;
    public $debitcommission = 0;
    public $grossprofit = 0;
    public $expences = 0;
    public $totalsalariespaid = 0;
    public $netprofit = 0;
    public $startDate;
    public $endDate;
    public $passwordmodal = false;
    public $password;
    public $verify = 0;
    public $creditmodal = false;
    public $paytype;
    public $amount;
    public $due = 0;
    public $userdd = -1;
    public $users = [];
    public $userddshow = false;
    public $months = [ "January","February","March","April","May","June","July","August","September","October","November","December"];
    public $monthdd;
    public $years;
    public $yeardd;
    public $total_salary;
    public $latedd = 3;
    public $deductdd = 1;
    public $lateredd;
    public $deductredd = 0;
    public $deductremaininglate = 0;
    public $totlate;
    public $totabsent;
    public $totleave;
    public $totpresent;
    public $lateded = 0;
    public $absentded;
    public $perdaysal;
    public $records = [];
    public $paytypesel = -1;
    public $usersel = -1;
    public $note;
    public function filter()
    {
        $sumofcredits = Account::where('type',0)->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->get()->sum('amount');
        $sumofdebit = Account::where('type',1)->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->get()->sum('amount');
        $this->creditcommission = Lead::whereIn('status', [1,2])->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->withSum('package', 'creditcommission')->get()->sum('package_sum_creditcommission');
        $this->debitcommission = Lead::where('status',2)->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->withSum('package','commission')->get()->sum('package_sum_commission');
        $this->grossprofit = ($this->creditcommission - $this->debitcommission) - $sumofdebit;
        $this->expences = $sumofdebit;
        $this->totalsalariespaid = Account::where('type',2)->sum('amount');//User::whereIn('salary_type', [0, 1])->whereBetween('created_at',[$this->startDate . ' 00:00:00',$this->endDate . ' 23:59:59'])->sum('salary');
        $this->netprofit = $this->grossprofit - $this->totalsalariespaid;
        $this->due = $this->creditcommission - $sumofcredits;
        $this->view();
    }
    public function deleteaccounts($id)
    {
        Account::findOrFail($id)->delete();
        $this->filter();
    }
    public function view()
    {
        $query = Account::with('user')->whereBetween('created_at',[$this->startDate.' 00:00:00',$this->endDate.' 23:59:59']);
        if($this->paytypesel != -1)
        {
            $query->where('type',$this->paytypesel);
        }
        if($this->usersel != -1)
        {
            $query->where('user_id_salary_pay',$this->usersel);
        }
        
        
        $this->records = $query->get();
        
        
    }
    public function checkpass()
    {
        if (Hash::check($this->password, Auth::user()->password)) {
            $this->passwordmodal = false;
            $this->verify = 1;
            $this->filter();
            $this->view();
        }
        else
        {
            $this->passwordmodal = true;
        }
    }
    public function mount()
    {
        if($this->verify == 1)
        {
            $this->filter();
            $this->view();
        }
        else
        {
            $this->reset();
        }
        $this->users = User::whereIn('salary_type',[0,1])->get();
        $currentYear = date('Y');
        for ($i = -1; $i <= 10; $i++) {
            $this->years[] = $currentYear + $i;
        }
        $this->monthdd = (Carbon::now()->month)-1;
        $this->yeardd = Carbon::now()->year;
        $this->startDate = now()->subDays(7)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->passwordmodal = true;
    }
    public function showuser()
    {
        if($this->paytype == 2)
        {
            $this->userddshow = true;
        }
        else
        {
            $this->userddshow = false;
        }
        
    }
    function getDayName($datetime) {
        // Convert string to timestamp
        $timestamp = strtotime($datetime);

        // Get full day name
        return date('l', $timestamp); // 'l' (lowercase L) gives full day name
    }
    public function usrsalaryupdate()
    {
        if($this->monthdd != -1 && $this->userdd != -1)
        {   
            $user = User::findOrFail($this->userdd);
            $month = $this->monthdd;
            $currentYear = $this->yeardd;
            
            $daysInMonth = Carbon::create(
                $this->yeardd,
                $this->monthdd,
                1
            )->daysInMonth;
            $present = 0;
            $absent = 0;
            $leave = 0;
            $late = 0; 
            $attendance = Attendence::where('user_id', $this->userdd)
                ->where('attendence_status', '!=', 'Leave')
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)      
                ->get();
            foreach($attendance as $atten)
            {
                    if($atten->attendence_status == 'Present' || $this->getDayName($atten->created_at) == 'sunday')
                    {
                        $present++;    
                    }
                    else if($atten->attendence_status == 'Leave')
                    {
                        $leave++;
                    }
                    else if($atten->attendence_status == 'Late')
                    {
                        $late++;
                    }
                    else if($atten->attendence_status == 'Absent')
                    {
                        $absent++;    
                    }
            }
            $perday_salary = $user->salary/$daysInMonth;
            $this->perdaysal = $perday_salary;
            $deductsalary_forabsent = number_format(($perday_salary*$absent),2,'.','');
            if($this->latedd != 0 && $this->deductdd != 0)
            {
                $counter = 0;
                while($late%$this->latedd != 0)
                {
                    $late--;
                    $counter++;                    
                }
                $this->lateredd = $counter;
                $finallates = ($late/$this->latedd)*$this->deductdd;
                $deductsalary_forlate = number_format(($finallates*$perday_salary),2,'.','');
                $this->lateded = number_format($deductsalary_forlate,2,'.','');
                $this->total_salary = number_format(($user->salary)-($deductsalary_forlate+$deductsalary_forabsent+$this->deductremaininglate),2,'.','');
            }
            else
            {
                $this->total_salary = number_format(($perday_salary*($present+$leave+$late+$absent))-($deductsalary_forabsent),2,'.','');
            }
            $this->absentded = $deductsalary_forabsent;
            $this->totlate = $late;
            $this->totabsent = $absent;
            $this->totpresent = $present;
            $this->totleave = $leave;
            $this->amount = number_format($this->total_salary, 2,'.','');
            if($this->lateredd == 2)
            {
                $this->deductredd = 0.5;
                $this->remainingded();
            }
        }
    }
    public function remainingded()
    {
        $user = User::findOrFail($this->userdd);
        $remainglateded = number_format($this->deductredd*$this->perdaysal,2,'.','');
        $this->deductremaininglate = $remainglateded;
        $this->total_salary = number_format($user->salary - ($this->lateded+$this->absentded+$remainglateded),2,'.','');
        $this->amount = number_format($this->total_salary, 2,'.','');
    }
    public function save()
    {
        $account = new Account();
        $account->type = $this->paytype;
        $account->amount = $this->amount;
        $account->note = $this->note;
        $account->usr_id = Auth::user()->id;
        $account->user_id_salary_pay = $this->userdd != -1 ? $this->userdd : 0 ;
        $account->save();
        $this->filter();
        $this->closemodal();
    }
    public function opencreditmodal()
    {
        $this->reset(['paytype','amount']);
        $this->creditmodal = true;
    }
    public function closemodal()
    {
        $this->creditmodal = false;
    }
    public function render()
    {
        return view('livewire.accounts.accounts');
    }
}
