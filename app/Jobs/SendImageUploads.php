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
//ini_set('max_execution_time', 300);
class SendImageUploads implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
        public $user = array();
        public $name= '';
        public $email= '';
        public $phone= '';
        public $caption= '';
 
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uploadDetails)
    {
        
        $this->uploads = $uploadDetails;
        $this->name = $uploadDetails['realname'];
        $this->email = $uploadDetails['email'];
        $this->phone = $uploadDetails['phone'];
        $this->caption = $uploadDetails['caption'];
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
        $data['phone'] = $this->phone;
        $data['caption'] = $this->caption;
        $admin_mail = ENV('ADMIN_EMAIL','mike@newtechweb.com');
        $subject = 'Visitor Uploaded Image';
        Mail::send('Site.image_upload_email', $data, function($message) use ($admin_mail,$subject) {
            $message->from($this->email,$this->name)->to($admin_mail)->subject($subject);
        });
        /*Mail::send('Site.image_upload_email', $data, function($message) use ($admin_mail,$subject) {
            $message->from($this->email,$this->name)->to($admin_mail)->replyTo($this->email, $this->name)->subject($subject);
        });*/
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
        $values = $this->uploads;
        $user_mail = $this->email;
        $LogObj = new Logger('SendImageUploads');
        $LogObj->pushHandler(new StreamHandler(storage_path('logs/emailstatus.log')), Logger::INFO);
        $LogObj->info('Email:'.$user_mail .', Error message: '.$errormessage);   
    }
}
