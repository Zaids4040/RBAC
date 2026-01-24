<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\Role;
use App\Models\User;
use App\Models\RolePermissionMap;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserPanel extends Component
{

    public $currentusrpermissions = [];
    public $currentuserlevel;
    public $usermodal = false;
    public $roles = [];

    public $name;
    public $email;
    public $phone;
    public $role;
    public $salarytype = -1;
    public $salary = 0;
    public $leave;
    public $password;
    public $fingerdata;
    public $password_confirmation;

    public $success_msg;
    public $userid = 0;
    public $users =  [];
    public $error;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'phone' => 'required|string|max:255',
        'role' => 'required|integer',          
        'salarytype' => 'required|integer',      
        'salary' => 'nullable|integer',
        'leave' => 'nullable|integer',
    ];
    public function permissions()
    {
        $this->currentusrpermissions = RolePermissionMap::where('role_id', Auth::user()->role_id)
        ->whereRelation('permissionrelation', 'module', 'users')
        ->get()
        ->pluck('permissionrelation.action')  // now works on the collection
        ->flatten()                           // flatten in case of multiple relations
        ->toArray();
    }
    public function savemodal()
    {
        if($this->userid == 0)
        {
            if(!in_array('create', $this->currentusrpermissions))
            {
                $this->error = 'You dont have permission to create any user';
                $this->usermodal = false;
                return;
            }
           
            $this->rules['password'] = 'required|string|max:255|confirmed';
            $this->validate();
            $user = new User();
            $user->password = $this->password;
        }
        else
        {
            if(!in_array('edit', $this->currentusrpermissions))
            {
                $this->error = 'You dont have permission to edit any user';
                $this->usermodal = false;
                return;
            }
            
            $this->validate();
            $user = User::findOrFail($this->userid);
            if($this->password != '')
            {
                $user->password = $this->password;
            }
        }
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->role_id = $this->role;
        $user->salary_type = $this->salarytype;
        $user->paid_leaves_monthly = $this->leave;
        $user->salary = $this->salary;
        $user->fingerprint = $this->fingerdata;
        $user->save();
        $this->reset(['name','email','phone','role','salarytype','leave','fingerdata','password','userid','salary','usermodal','password_confirmation']);

        $this->success_msg = $this->userid == 0 ? 'User Saved Successfully' : 'User Updated Successfully';

    }
    public function edituser($id)
    {
        if(!in_array('edit', $this->currentusrpermissions))
        {
            $this->error = 'You dont have permission to edit any user';
            return;
        }
        if(in_array('edit_high', $this->currentusrpermissions))
        {
            $this->roles = Role::all();
        }
        
        $users = User::findOrFail($id);
        $this->name = $users->name;
        $this->email = $users->email;
        $this->phone = $users->phone;
        $this->role = $users->role_id;
        $this->salarytype = $users->salary_type;
        $this->salary = $users->salary;
        $this->leave = $users->paid_leaves_monthly;
        $this->fingerprint = $users->fingerprint;
        $this->password = '';
        $this->userid = $users->id;
        $this->usermodal = true;

    }
    public function deleteusr($id)
    {
        if(!in_array('delete', $this->currentusrpermissions))
        {
            $this->error = 'You dont have permission to delete any user';
            return;
        }
        User::findOrFail($id)->delete();
    }
    public function openusrmodal()
    {
        $this->reset();
        $this->role = 0;
        $this->usermodal = true;
    }
    public function closemodal()
    {
        $this->usermodal = false;
    }
    public function loadRoles()
    {
        if(in_array('create_high', $this->currentusrpermissions)) {
            $this->roles = Role::all();
        }
        elseif(in_array('edit_high', $this->currentusrpermissions) && $this->userid > 0) {
            $this->roles = Role::all();
        }
        else {
            $this->roles = Role::where('level', '>=', $this->currentuserlevel)->get();
        }
    }

    public function render()
    {
        $this->currentuserlevel = Role::where('id', Auth::user()->role_id)->pluck('level')->first();
        $this->permissions();
        if(in_array('create_high',$this->currentusrpermissions))
        {
            $this->roles = Role::all();
        }
        else if(in_array('edit_high',$this->currentusrpermissions) && $this->userid >0 )
        {
            $this->roles = Role::all();
        }
        else
        {
            $this->roles = Role::where('level','>=',$this->currentuserlevel)->get();
        }
        if(in_array('view_high',$this->currentusrpermissions))
        {
            $this->users = User::with('role')->get();    
        }
        else
        {
            $this->users = User::with('role')->whereRelation('role','level','>=',$this->currentuserlevel)->get();
        }
        
        return view('livewire.users.user-panel');
    }
}
