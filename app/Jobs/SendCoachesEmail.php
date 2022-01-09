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
//ini_set('max_execution_time', 300);
class SendCoachesEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
		
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    { 	
		$coach_details = DB::table('tbl_coach')
		->select('tbl_coach.email', 'tbl_coach.first_name', 'tbl_coach.id')
		->where('tbl_coach.email','!=','')
        ->get(); 
		//echo '<pre>'; print_r($coach_details);die;
		//$contactName = Config::get('site_settings.contact_name');
		$contactName = 'Admin_basket';
		#$contactEmail = 'info@advantagebasketball.com';
		$contactEmail = 'mike@newtechweb.com';
		$subject = 'Coach invitation';
		
		foreach($coach_details as $details){ //echo '<pre>'; print_r($details->first_name);
			$data['username'] = $details->first_name;
			$user_mail = $details->email;
			Mail::send('Admin.email_allcoaches', $data, function($message) use ($user_mail,$subject) {
				$message->to($user_mail)->subject($subject);
			});	
		}
		return true;
		
	}
}
