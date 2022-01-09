<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;
use Mail;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class SendEmailToCustomer implements ShouldQueue
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
		$data['shipping_first_name'] = $this->data['shipping_first_name'];
        $data['shipping_last_name'] = $this->data['shipping_last_name'];
        $data['shipping_address'] = $this->data['shipping_address'];
        $data['shipping_address2'] = $this->data['shipping_address2'];
        $data['shipping_phone'] = $this->data['shipping_phone'];
        $data['shipping_work_phone'] = $this->data['shipping_work_phone'];
        $data['shipping_city'] = $this->data['shipping_city'];
        $data['shipping_state'] = $this->data['shipping_state'];
        $data['shipping_postal_code'] = $this->data['shipping_postal_code'];
        $data['shipping_country'] = $this->data['shipping_country'];
        $data['shipping_email'] = $this->data['shipping_email'];
        $data['tracking_url'] = $this->data['tracking_url'];
        $data['tracking_number'] = $this->data['tracking_number'];
        $data['stateCode'] = $this->data['stateCode'];
        $admin_mail = ENV('ADMIN_EMAIL','mike@newtechweb.com');
        $subject = 'Order Shipped Details';
        Mail::send('emailTemplates.orderShippedEmail', $data, function($message) use ($admin_mail,$subject) {
            $message->from($admin_mail)->to($this->data['shipping_email'])->subject($subject);
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
        $logObj = new Logger('Order shipped failed');
		$logObj->pushHandler(new StreamHandler(storage_path('logs/email.log')), Logger::INFO);
		$logObj->info($exception->getMessage());
    }
}
