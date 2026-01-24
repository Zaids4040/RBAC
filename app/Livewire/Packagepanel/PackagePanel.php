<?php

namespace App\Livewire\PackagePanel;

use Livewire\Component;
use App\Models\Package;
use App\Models\RolePermissionMap;
use Illuminate\Support\Facades\Auth;
use Exception;
class PackagePanel extends Component
{
    public $currectuserpermission = [];
    public $packagemodal = false;

    public $editid = 0;
    public $name;
    public $amount;
    public $contract;
    public $dis_price;
    public $dis_month;
    public $packagetype;
    public $companyname;
    public $description;
    public $commission;
    public $active_ch = false;
    public $error;
    public $data = [];
    public $creditcommission;
    public $rules = [
        'name' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'contract' => 'required|string',
        'dis_price' => 'nullable|numeric',
        'dis_month' => 'nullable|integer',
        'packagetype' => 'required|string|max:15',
        'companyname' => 'required|string|max:10',
        'description' => 'required|string|max:555',
        'commission' => 'required|numeric',
    ];

    public $error_msg;

    public function permissions()
    {
        $this->currectuserpermission = RolePermissionMap::whereRelation('permissionrelation','module','packages')->get()->pluck('permissionrelation.action')->flatten()->toArray();
    }
    public function savedata()
    {
        try
        {
            $this->validate();
            if($this->editid == 0)
            {
                if(!in_array('create',$this->currectuserpermission))
                {
                    $this->error = 'You dont have permission to create any package';
                    return;
                }
                $package = new Package();
            }
            else
            {
                if(!in_array('edit',$this->currectuserpermission))
                {
                    $this->error = 'You dont have permission to edit any package';
                    return;
                }
                $package = Package::findOrFail($this->editid);
            }
            
            $package->name = $this->name;
            $package->amount = $this->amount;
            $package->contact_month = $this->contract;
            $package->dis_amount = $this->dis_price;
            $package->dis_month = $this->dis_month;
            $package->package_type = $this->packagetype;
            $package->package_company = $this->companyname;
            $package->description = $this->description;
            $package->commission = $this->commission;
            $package->status = $this->active_ch;
            $package->creditcommission = $this->creditcommission;
            $package->save();
            $this->reset();
        }
        catch(Exception $e)
        {
            $this->error_msg = 'Something Went Worng Please Try Again Later';
        }
    }
    public function view_data()
    {
        if(!in_array('view',$this->currectuserpermission))
        {
            $this->error = 'You dont have permission to view any recorde';
            return;
        }
        $this->data = Package::all();
    }
    public function deletepackage($id)
    {
        if(!in_array('delete',$this->currectuserpermission))
        {
            $this->error = 'You dont have permission to delete any package';
            return;
        }
        $package = Package::findOrFail($id);
        if($package->lead()->exists())
        {
            $this->error_msg = 'Delete all the leads linked from this package first';
        }
        else
        {
            $package->delete();
        }
    }
    public function editopenmodal($id)
    {
        $this->reset();
        $package = Package::findOrFail($id);
        $this->name = $package->name;
        $this->amount = $package->amount;
        $this->contract = $package->contact_month;
        $this->dis_price = $package->dis_amount;
        $this->dis_month = $package->dis_month;
        $this->packagetype = $package->package_type;
        $this->companyname = $package->package_company;
        $this->description = $package->description;
        $this->commission = $package->commission;
        $this->creditcommission = $package->creditcommission;
        $this->active_ch = $package->status == 1 ? true : false;
        $this->editid = $package->id;
        $this->packagemodal = true;


    }
    public function openmodal()
    {
        if(!in_array('create',$this->currectuserpermission) && !in_array('edit',$this->currectuserpermission))
        {
            $this->error = 'You dont have permission to create any package';
            return;
        }
        $this->reset();
        $this->packagemodal = true;
    }
    public function closemodal()
    {
        $this->packagemodal = false;
    }

    public function render()
    {
        $this->permissions();
        $this->view_data();
        return view('livewire.packagepanel.package-panel');
    }
}
