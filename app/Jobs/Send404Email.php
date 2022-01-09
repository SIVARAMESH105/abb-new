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

class Send404Email implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
        public $data = array();
        public $name = '';
        public $email = '';
        public $website ='';
        public $errorIssue ='';
 
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($page404Details)
    { 
        $this->data = $page404Details;
        $this->name = $page404Details['realname'];
        $this->email = $page404Details['email'];
        $this->website = $page404Details['URL'];
        $this->errorIssue = $page404Details['ErrorIssue'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {  
        $data['realname'] = $this->name;
        $data['email'] = $this->email;
        $data['website'] = $this->website;
        $data['errorIssue'] = $this->errorIssue;
        $userEmailId = $this->email;
        $admin_mail = "mike1@newtechweb.com";
        $subject = 'Advantage Basketball 404 Error Response';
        Mail::send('Site.404_email', $data, function($message) use ($userEmailId,$admin_mail,$subject) {
            $message->from($userEmailId,$this->name)->to($admin_mail)->subject($subject);
        });
       // Mail::send('Site.404_email', $data, function($message) use ($userEmailId,$admin_mail,$subject) {
            //$message->from($userEmailId,$this->name)->to($admin_mail)->replyTo($userEmailId, $this->name)->subject($subject);
       // });        return true; 
           
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
        $LogObj = new Logger('Send404Email');
        $LogObj->pushHandler(new StreamHandler(storage_path('logs/emailstatus.log')), Logger::INFO);
        $LogObj->info('Email:'.$user_mail .', Error message: '.$errormessage);
        
        
    }
}
