<?php

namespace App\Livewire\EmailConfigure;

use Livewire\Component;
use App\Models\Emailconfig;

class EmailConfigure extends Component
{
    public $config_name;
    public $smtp_host;
    public $smtp_port;
    public $encryption;
    public $username;
    public $smtp_password;
    public $from_name;
    public $from_email;
    public $emailConfigId;
    public $email_data;
    public function save()
    {
        
    }
    public function view()
    {
        $this->email_data = Emailconfig::all();
        
    }
    public function render()
    {
        return view('livewire.email-configure.email-configure');
    }
}
