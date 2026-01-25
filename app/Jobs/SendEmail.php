<?php

namespace App\Jobs;

use App\Models\Emailconfig;
use App\Models\Emailsetting;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class SendEmail implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels; // ✅ Add Dispatchable & InteractsWithQueue
    public $addedby;
    public $leadname;
    public $leadphone;
    
    /**
     * Create a new job instance.
     */
    public function __construct($addedby,$leadname,$leadphone,)
    {
        $this->addedby = $addedby;
        $this->leadname = $leadname;
        $this->leadphone = $leadphone;
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email_config = Emailconfig::first();

        $emailSettings = Emailsetting::where('email_setting', 'Submission Email')
            ->with('users')
            ->get();

        $mail = new PHPMailer(true);

        try {
            // 🔹 SMTP CONFIG — ONLY ONCE
            $mail->isSMTP();
            $mail->Host       = $email_config->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $email_config->username;
            $mail->Password   = $email_config->password;
            $mail->SMTPSecure = $email_config->encryption;
            $mail->Port       = $email_config->port;

            $mail->setFrom($email_config->from_email, $email_config->from_name);
            $mail->isHTML(true);
            $mail->SMTPKeepAlive = true;

            foreach ($emailSettings as $setting) {

                foreach ($setting->users as $user) {

                    try {
                        $mail->clearAddresses(); // 🔥 IMPORTANT
                        $mail->addAddress($user->email);

                        $mail->Subject = 'New Submission Notification';

                        $mail->Body = '
                            <h3>New Submission</h3>
                            <p><strong>Added By:</strong> '.$this->addedby.'</p>
                            <p><strong>Lead Name:</strong> '.$this->leadname.'</p>
                            <p><strong>Lead Phone:</strong> '.$this->leadphone.'</p>
                        ';

                        $mail->AltBody =
                            'New Submission'."\n".
                            'Added By: '.$this->addedby."\n".
                            'Lead Name: '.$this->leadname."\n".
                            'Lead Phone: '.$this->leadphone;

                        $mail->send();

                    } catch (Exception $e) {
                        logger()->error('Mail failed for '.$user->email.' : '.$e->getMessage());
                    }
                }
            }

            $mail->smtpClose();

        } catch (Exception $e) {
            logger()->critical('SMTP config failed: '.$e->getMessage());
        }
    }
}
