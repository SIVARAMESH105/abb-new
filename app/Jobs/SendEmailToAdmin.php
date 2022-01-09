<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;
use Mail;

class SendEmailToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	public $data = array();
	public $username = '';
	
	
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
        $data['address'] = $this->data['address'];
        $data['phone'] = $this->data['phone'];
        $data['email'] = $this->data['email'];
        $admin_mail = ENV('ADMIN_EMAIL','mike@newtechweb.com');
        $subject = 'Affiliate Register';
        Mail::send('Site.affiliate_register_email', $data, function($message) use ($admin_mail,$subject) {
            $message->from($this->data['email'],$this->data['name'])->to($admin_mail)->subject($subject);
        });
        return true; 
    }
}
