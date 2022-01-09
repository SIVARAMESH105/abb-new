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

class CommissionPaidStatusForAffiliator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $data = array();
    
    
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
        $user_mail = $this->data->email;
        $data['name'] = $this->data->name;
        $data['camp_focus'] = $this->data->camp_focus;
        $data['amount'] = $this->data->amount;
        $subject = 'Affiliate Commission Payment Success';
        Mail::send('emailTemplates.affiliateCommissionPaymentSuccess', $data, function($message) use ($user_mail,$subject) {
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
        $logObj = new Logger('Affiliate Commission Payment Success');
        $logObj->pushHandler(new StreamHandler(storage_path('logs/email.log')), Logger::INFO);
        $logObj->info($exception->getMessage());
    }
}
