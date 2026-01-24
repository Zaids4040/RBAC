<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RolePermissionMap;
use Illuminate\Support\Facades\Auth;
class PanelManager extends Component
{

    public $currentusrpermissions = [];
    public $panelnames = [
        'admin_dashboard'=>['dashboard','Admin Dashboard','fas fa-chart-line'],
        'user_dashboard'=>['usrdashboard','User Dashboard','fas fa-chart-line'],
        'users'=>['users','Users','fas fa-users'],
        'roles'=>['roles','Roles','fas fa-user-tag'],
        'packages'=>['packagepanel','Package','fas fa-money-bill-wave'],
        'leads'=>['leadspanel','All Submission','fas fa-list-alt'],
        'attendence'=>['attendence','Attendence','fas fa-calendar-check'],
        'accounts'=>['accounts','Accounts','fas fa-calendar-check'],
        'emailconfig'=>['emailconfig','Email Configuration','fas fa-email']
    ];
    public $currentpanel = 'dashboard';
    
    protected $listeners = ['switchattendence' => 'switchtoattendence'];
    public function switchpanel($panel)
    {
        $this->currentpanel = $panel;
    }
    public function switchtoattendence()
    {
        $this->currentpanel = 'attendence';
    }
    public function permissions()
    {
       $this->currentusrpermissions = RolePermissionMap::where('role_id', Auth::user()->role_id)
        ->with('permissionrelation')
        ->get()
        ->pluck('permissionrelation')          // pehle relation collection ko le lo
        ->flatten(1)                           // flatten one level
        ->pluck('module')                      // phir module nikal lo
        ->unique()
        ->toArray();

    }
    public function render()
    {
        $this->permissions();
        if(count($this->currentusrpermissions) < 2)
        {
            $this->currentpanel = $this->panelnames[$this->currentusrpermissions[0]][0];
        }
        return view('livewire.panel-manager');
    }
}
