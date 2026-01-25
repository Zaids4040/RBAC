<?php

namespace App\Livewire\EmailConfigure;

use Livewire\Component;
use App\Models\Emailconfig;
use App\Models\Role;
use App\Models\Emailsetting;
use App\Models\RolePermissionMap;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailConfigure extends Component
{
    public $currentusrpermissions = [];
    public $config_name;
    public $smtp_host;
    public $smtp_port;
    public $encryption;
    public $username;
    public $smtp_password;
    public $from_name;
    public $from_email;
    public $test_email;
    public $emailConfigId = 0;
    public $email_data = [];
    public $error;
    public $emailmodal = false;
    public $emailtestmsg;
    public $emailsettingmodal = false;
    public $roledd;
    public $emaildd;
    public $roles = [];
    public $emails = ['Submission Email','Submission Upgrade Email'];
    public $email_settins = [];
    public function openEmailSetupModal()
    {
        $this->roles = Role::all();
        $this->viewemailsettings();
        $this->emailsettingmodal = true;
    }
    public function closeEmailsettingModal()
    {
        $this->reset();
    }
    public function addemailsetting()
    {
        $email = new Emailsetting();
        $email->role_id = $this->roledd;
        $email->email_setting = $this->emaildd;
        $email->save();
        $this->viewemailsettings();
    }
    public function deleteemailsettings($id)
    {
        Emailsetting::findOrFail($id)->delete();
        $this->viewemailsettings();
    }
    public function viewemailsettings()
    {
        $this->email_settins = Emailsetting::with('role')->get();
    }
    public function editEmailConfig($id)
    {
        $emailconfig = Emailconfig::findOrFail($id);
        $this->config_name = $emailconfig->config_name;
        $this->smtp_host = $emailconfig->host;
        $this->smtp_port = $emailconfig->port;
        $this->encryption = $emailconfig->encryption;
        $this->username = $emailconfig->username;
        $this->smtp_password = $emailconfig->password;
        $this->from_name = $emailconfig->from_name;
        $this->from_email = $emailconfig->from_email;
        $this->emailConfigId = $emailconfig->id;
        $this->emailmodal = true;
    }
    public function permissions()
    {
        $this->currentusrpermissions = RolePermissionMap::where('role_id',Auth::user()->role_id)
        ->whereRelation('permissionrelation','module','emailconfig')
        ->get()
        ->pluck('permissionrelation.action')
        ->flatten()
        ->toArray();
    }
    public function testmail()
    {
      
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = $this->smtp_host;
            $mail->SMTPAuth   = true;
            $mail->Username   =  $this->username;
            $mail->Password   = $this->smtp_password;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom($this->from_email, $this->from_name);
            $mail->addAddress($this->test_email);

            $mail->isHTML(true);
            $mail->Subject = 'Test Email';
            $mail->Body    = 'Hello! This is test email';

            if($mail->send())
            {
                $this->emailtestmsg = 1;
            }
            
        } catch (Exception $e) {
            $this->emailtestmsg = "Email error: {$mail->ErrorInfo}";
        }
    }
    public function openEmailModal()
    {
        $this->emailmodal = true;
    }
    public function closeEmailModal()
    {
        $this->emailmodal = false;
    }
    public function save()
    {
        if($this->emailConfigId != 0)
        {
            $emailconfig = Emailconfig::findOrFail($this->emailConfigId);
        }
        else
        {
            $emailconfig = new Emailconfig();    
        }
        $emailconfig->config_name = $this->config_name;
        $emailconfig->host = $this->smtp_host;
        $emailconfig->port = $this->smtp_port;
        $emailconfig->encryption = $this->encryption;
        $emailconfig->username = $this->username;
        $emailconfig->password = $this->smtp_password;
        $emailconfig->from_name = $this->from_name;
        $emailconfig->from_email = $this->from_email;
        if($emailconfig->save())
        {
            $this->emailmodal = false;
            $this->view();
        }
        else
        {
            $this->error = 'Something went worng';
        }
        $this->reset();
    }
    public function deleteEmailConfig($id)
    {
        Emailconfig::findOrFail($id)->delete();
        $this->view();
    }
   
    public function view()
    {
        $this->email_data = Emailconfig::all();
        
    }
    public function render()
    {
        $this->permissions();
        $this->view();
        return view('livewire.email-configure.email-configure');
    }
}
