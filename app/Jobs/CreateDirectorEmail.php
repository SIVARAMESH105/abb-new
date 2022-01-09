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

class CreateDirectorEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
        public $data = array();
        public $email = '';
 
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($directorDetails)
    { 
        $this->data = $directorDetails;
        $this->email = $directorDetails['email'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() 
    {  
        $data['directorDetails'] = $this->data;
        $to_mail = $this->email;
        $admin_mail = ENV('ADMIN_EMAIL','mike@newtechweb.com');
        $subject = 'Advantage Basketball New Director Created';
        Mail::send('Admin.email_create_director', $data, function($message) use ($to_mail,$admin_mail,$subject) {
            $message->from($admin_mail)->to($to_mail)->subject($subject);
        });
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
        $LogObj = new Logger('CreateDirectorEmail');
        $LogObj->pushHandler(new StreamHandler(storage_path('logs/emailstatus.log')), Logger::INFO);
        $LogObj->info('Email:'.$user_mail .', Error message: '.$errormessage);
        
        
    }
}
