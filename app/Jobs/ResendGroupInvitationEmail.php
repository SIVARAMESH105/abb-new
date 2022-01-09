<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;
use Mail;

class ResendGroupInvitationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	public $data = array();
	public $campDetails = array();
	public $reg_username = '';
	public $group_code = '';
	
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$campDetails)
    {
        $this->data = $data;
        $this->campDetails = $campDetails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$data = $this->data;
		$data['campDetails'] = $this->campDetails;
		$username = (object)array('name' => $data['username']);
		$data['reg_username'] = $username->name;
		$data['group_code'] = $data['groupCode'];
		$contactName = 'Admin_basket';
		#$contactEmail = 'info@advantagebasketball.com';
		$contactEmail = 'mike@newtechweb.com';
		$subject = 'Group invitation';
		$user_mail = $data['email'];
		if(!empty($data['firstName'])){
			$data['user_name'] = $data['firstName'];
			Mail::send('Site.email_group_invitation', $data, function($message) use ($user_mail,$subject) {
			$message->to($user_mail)->subject($subject);
			});
		}
		return true;
    }
}
