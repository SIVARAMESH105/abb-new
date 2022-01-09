<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;
use Hash;
use Session;

class Cards extends Model
{
    protected $table = 'tbl_card_details';
    protected $primaryKey = 'id';
    protected $fillable = ['card_camp_id','card_user_id','card_roster_id','last_four_digit','payment_type','created_at'];
	
	/**
		* This function is used to store the card details for credit card
		* @param array $inputData 
		* return inserted id
    */
	public function storeDetails($inputData) {
		$insertId = DB::table($this->table)->insertGetId($inputData);
		return $insertId;
	}

	/**
		* This function is used to get the card details
		* @param array $inputData 
		* return inserted id
    */
	public function getDetails($inputData) {
		$getCard = DB::table($this->table)->where(array('card_camp_id'=>$inputData['campId'],'card_roster_id'=>$inputData['rosterId']))->first();
		return $getCard;
	}
}
