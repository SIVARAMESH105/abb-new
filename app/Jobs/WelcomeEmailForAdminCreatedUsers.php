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

class WelcomeEmailForAdminCreatedUsers implements ShouldQueue
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
		$data['name'] = $this->data['name'];
		$data['email'] = $this->data['email'];
		$data['password'] = $this->data['password'];
		$user_mail= $this->data['email'];
		$subject = 'Welcome to Advantage Basket Ball!';
		Mail::send('emailTemplates.welcomeEmailForAdminCreatedUsers', $data, function($message) use ($user_mail,$subject) {
			$message->to($user_mail)->subject($subject);
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
        $logObj = new Logger('Welcome admin created users');
		$logObj->pushHandler(new StreamHandler(storage_path('logs/email.log')), Logger::INFO);
		$logObj->info($exception->getMessage());
    }
}
