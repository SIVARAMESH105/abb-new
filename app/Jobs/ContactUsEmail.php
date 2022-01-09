<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;
use Mail;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ContactUsEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
        public $data = array();
        public $name = '';
        public $userEmailId = '';
        
 
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($contactUs)
    { 
        $this->data = $contactUs;
        

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {  
        $values = $this->data;
        $this->name = $values['realname'];
        $userEmailId = $values['email'];
        
        $admin_mail = "mike1@newtechweb.com";
        $subject = 'Advantage Basketball Contact Form Submission';
        Mail::send('Site.contact_email', $values, function($message) use ($userEmailId,$admin_mail,$subject) {
            $message->from($userEmailId, $this->name)->to($admin_mail)->subject($subject);
        });
        // Mail::send('Site.contact_email', $values, function($message) use ($userEmailId,$admin_mail,$subject) {
        //     $message->from($userEmailId, $this->name)->to($admin_mail)->replyTo($userEmailId, $this->name)->subject($subject);
        // });
        return true; 
           
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed($exception)
    {
        $errormessage = $exception->getMessage();
        $values = $this->data;
        $user_mail = $values['email'];
        $LogObj = new Logger('ContactUsEmail');
        $LogObj->pushHandler(new StreamHandler(storage_path('logs/emailstatus.log')), Logger::INFO);
        $LogObj->info('Email:'.$user_mail .', Error message: '.$errormessage);
        
        
    }
}
