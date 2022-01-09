<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrderOneOnOne extends Model
{
    protected $table = 'tbl_order_one_on_one';
	protected $primaryKey = 'od_id';
	//protected $fillable = ['last_recurring_date'];
    public $timestamps = false;
	
	public function saveOrderTrainingDetails($parent_first_name, $parent_last_name, $playername, $gender, $address, $city, $state, $phone, $zip_code, $team_name, $user_email, $time_mon, $time_tue, $time_wed, $time_thur, $transaction_id, $user_id, $od_id){
		$this->od_id	= $od_id;
		$this->od_user_id 	= $user_id;
		$this->parent_first_name 	= $parent_first_name;
		$this->parent_last_name 	= $parent_last_name;
		$this->player_name 	= $playername;
		$this->gender 	= $gender;
		$this->address 	= $address;
		$this->city 	= $city;
		$this->state 	= $state;
		$this->phone 	= $phone;
		$this->zipcode 	= $zip_code;
		$this->team_name 	= $team_name;
		$this->email 	= $user_email;
		$this->schedule_mon 	= $time_mon;
		$this->schedule_tue 	= $time_tue;
		$this->schedule_wed 	= $time_wed;
		$this->schedule_thur 	= $time_thur;
		$this->transaction_id 	= $transaction_id;
		$this->status 		=  1;
		$this->save();
		return $this->od_id;
	}

	public function updateRecurringPayment($transaction_id)
	{
		DB::table($this->table)->where('transaction_id', $transaction_id)->update(array('last_recurring_date' => date('Y-m-d')));
	}

	public function updateSubscriptionId($transaction_id, $subscription_id)
	{
		DB::table($this->table)->where('transaction_id', $transaction_id)->update(array('subscription_id' => $subscription_id));
	}
}
