<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CancelCampRegistraionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $data = array();
    public $username = '';
    public $pass = '';
    
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data['name'] = $this->data['username'];
        $data['email'] = $this->data['useremail'];
        $data['campname'] = $this->data['campname'];
        $data['location'] = $this->data['location'];
        $data['canceldate'] = $this->data['canceldate'];
        $admin_mail= ENV('ADMIN_EMAIL','mike@newtechweb.com'); 
        $subject = 'Cancelled camp registeration!';
        //Email to admin
        Mail::send('emailTemplates.userCancelCampEmail', $data, function($message) use ($admin_mail,$subject) {
            $message->from($this->data['useremail'],ucfirst($this->data['username']))->to($admin_mail)->subject($subject);
        });
        //Email to customer
        $data['userflog'] = 1;
        Mail::send('emailTemplates.userCancelCampEmail', $data, function($message) use ($admin_mail,$subject) {
            $message->from($admin_mail)->to($this->data['useremail'])->subject($subject);
        });
        return true; 
    }
    
    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        $logObj = new Logger('Cancelled camp registration');
        $logObj->pushHandler(new StreamHandler(storage_path('logs/email.log')), Logger::INFO);
        $logObj->info($exception->getMessage());
    }
}
