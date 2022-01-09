<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;
use Mail;

class SendGroupInvitationEmail implements ShouldQueue
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
    public function __construct($data,$reg_username,$campDetails,$group_code)
    {
        $this->data = $data;
        $this->campDetails = $campDetails;
		$this->reg_username = $reg_username;
		$this->group_code = $group_code;
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
		foreach($data['campDetails'] as $camp_val){
			if($data['group_camp'] == $camp_val->id){
				$data['campDetails'] = $camp_val;
			}
		}
		$data['reg_username'] = $this->reg_username;
		$data['group_code'] = $this->group_code;
		$contactName = 'Admin_basket';
		#$contactEmail = 'info@advantagebasketball.com';
		$contactEmail = 'mike@newtechweb.com';
		$subject = 'Group invitation';
		
		$i=0;
		foreach($data['grpemail'] as $details){
			$user_mail = $details;
			if(!empty($data['username'][$i])){
				$data['user_name'] = $data['username'][$i];
				if($user_mail !=''){
					Mail::send('Site.email_group_invitation', $data, function($message) use ($user_mail,$subject) {
						$message->to($user_mail)->subject($subject);
					});
				}
			}
			$i++;
		}
		return true;
    }
}
