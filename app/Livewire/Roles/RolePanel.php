<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermissionMap;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RolePanel extends Component
{
    public $currentusrpermissions = [];
    public $currentuserlevel;

    public $rolemodal = false;
    public $permissions = [];
    public $name;
    public $description;
    public $level;
    public $modal_Save_btn_txt = 'Save Role';
    public $editid = 0;
    public $selectedPermissions = []; // checkbox values
    public $panelnames = [
            'users' => 'User Management',
            'roles' => 'Roles Management',
            'dashboard' => 'Dashboard'
        ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
        'level' => 'nullable|integer'
    ];

    public $roles_count = 0;
    public $error = '';
    public $success_msg = '';

    public $roles_rows = [];

    public function openrolemodal()
    {
        $permissions_data = Permission::all();
        $groupedPermissions = [];

        foreach ($permissions_data as $perm) {

            // Kisi bhi module ka final naam decide karo
            $moduleName = $this->panelnames[$perm->module] ?? ucfirst($perm->module);

            // Pehli baar group create karne ki zarurat hai?
            if (!isset($groupedPermissions[$moduleName])) {
                $groupedPermissions[$moduleName] = [];
            }

            // Action add karein
            $groupedPermissions[$moduleName][] = [$perm->action,$perm->id];
        }

        $this->permissions = $groupedPermissions;
        
        
        $this->rolemodal = true;
    }
    public function closerolemodal()
    {
        $this->reset(['name','description','level','selectedPermissions']);
        $this->editstatus = 0;
        $this->rolemodal = false;
    }
    public function permissions()
    {
        $this->currentusrpermissions = RolePermissionMap::where('role_id', Auth::user()->role_id)
        ->whereRelation('permissionrelation', 'module', 'roles')
        ->get()
        ->pluck('permissionrelation.action')  // now works on the collection
        ->flatten()                           // flatten in case of multiple relations
        ->toArray();
    }
    public function saverole()
    {
        DB::beginTransaction();
        try
        {
            $this->validate();
            if($this->editid == 0)
            {
                $role = new Role();
            }
            else
            {
                RolePermissionMap::where('role_id',$this->editid)->delete();
                $role = Role::findOrFail($this->editid);
            }

            $role->name = $this->name;
            $role->description = $this->description;
            $role->level = $this->level;
            $role->save();

            $role_id = $role->id;

            $premission_ids = array_map('intval', array_values($this->selectedPermissions));

            foreach($premission_ids as $premid)
            {
                $premsave = new RolePermissionMap();
                $premsave->role_id = $role_id;
                $premsave->permission_id = $premid;
                $premsave->save();
            }   
            
            $this->success_msg = $this->editid == 0 
            ? 'Role Saved Successfully' 
            : 'Role Edited Successfully';

            // Reset only input fields, not success_msg
            $this->reset(['name', 'description', 'selectedPermissions', 'editid','rolemodal']);
            $this->resetValidation();   // clears validation errors
            DB::commit();
            $this->dispatchBrowserEvent('tooltip-shown');
        }
        catch(\Exception $e)
        {
            $this->error = 'Some Thing Went Worng Please Try Again Later';
            DB::rollBack();
        }
    }
    public function editrole($id)
    {
        $role = Role::findOrfail($id);
        
        $this->name = $role->name;
        $this->description = $role->description;
        $this->level = $role->level;
        $this->selectedPermissions = RolePermissionMap::where('role_id',$id)->pluck('permission_id')->toArray();
        $this->modal_Save_btn_txt = 'Edit Role';
        $this->editid = $id;
        $this->openrolemodal();

    }
    public function deleterole($id)
    {
        DB::beginTransaction();
        try
        {
            RolePermissionMap::where('role_id',$id)->delete();
            Role::findOrfail($id)->delete();
            $this->success_msg = 'Role Deleted Successfully';
            DB::commit();
            $this->dispatchBrowserEvent('tooltip-shown');
        }
        catch(\Exception $e)
        {
            $this->error = 'Some Thing Went Worng Please Try Again Later';
            DB::rollBack();
        }
        
        
    }
    public function render()
    {
        $this->currentuserlevel = Role::where('id', Auth::user()->role_id)->pluck('level')->first();
        $this->permissions();
        $this->roles_rows = Role::withCount('users')->get();
        $this->roles_count = Role::count();
        return view('livewire.roles.role-panel');
    }
}
