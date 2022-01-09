<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;
use Mail;

class SendForgotPasswordEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	public $data = array();
	public $username = '';
	
	
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$username)
    {
        $this->data = $data;
		$this->username = $username;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$data = $this->data;
		$data['username'] = $this->username;
		$data['email'] = $data['email'];
		//echo "<pre>"; print_r($data); exit;
		$user_mail= $data['email'];
		$contactName = 'Admin_basket';
		#$contactEmail = 'info@advantagebasketball.com';
		$contactEmail = 'mike@newtechweb.com';
		$subject = 'Forgot Password';
		
		Mail::send('Site.email_forgot_password', $data, function($message) use ($user_mail,$subject) {
			$message->to($user_mail)->subject($subject);
		});
		
		return true;
    }
}
