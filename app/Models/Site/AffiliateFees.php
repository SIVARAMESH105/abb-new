<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class AffiliateFees extends Model
{
	protected $table = 'tbl_affiliate_fees';
    protected $primaryKey = 'id';
    protected $fillable = ['affiliate_id','camp_id','user_id','roster_id','amount','is_paid','created_at','modified_by','updated_at'];
   // public $timestamps = false;
	
	/*
		*This function is used to store the affilite register user
		*@param array $inputData
		*return int insertId
	*/
	public function saveAffiliateFees($inputData){
		$this->affiliate_id = $inputData["affiliateId"]; 
		$this->camp_id = $inputData["camp_id"]; 
		$this->user_id = $inputData["user_id"];
		$this->roster_id = $inputData["rosterId"];
		$amount = ($inputData['cost']*$inputData['affiliateCommission'])/100;
		$this->amount = $amount;
		$this->is_paid = '0';
		$date = date("Y-m-d H:i:s");
		$this->created_at = $date; 
		$this->save();
		return $this->id;
	}
}
