<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;
use Hash;
use Session;

class Wallet extends Model
{
    protected $table = 'tbl_user_wallet_reference';
    protected $primaryKey = 'id';
    protected $fillable = ['uw_camp_id','uw_user_id','uw_roster_id','uw_amount','uw_created_at'];
	
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
		$getWallet = DB::table($this->table)->where(array('uw_camp_id'=>$inputData['campId'],'uw_roster_id'=>$inputData['rosterId']))->first();
		return $getWallet;
	}

	/**
		* This function is used to get the card details
		* @param array $inputData 
		* return inserted id
    */
	public function getDetailsByUserId($userId) {
		$getWallet = DB::table('tbl_user_wallet')->where('user_id',$userId)->sum('wallet_amount');
		return $getWallet;
	}

	/**
    * This function is used to check the user already exist in wallet table
    * @param int $userId 
    * return user details object
    */
    public function checkWalletExistence($userId) {
        $checkExist = DB::table('tbl_user_wallet')->where('user_id',$userId)->get();
        return $checkExist;
    }

    /**
	* This function is used to store the card details for credit card
	* @param array $inputData 
	* return inserted id
    */
	public function storeWalletDetails($inputData) {
		$insertId = DB::table('tbl_user_wallet')->insertGetId($inputData);
		return $insertId;
	}

    /**
    * This function is used to update the wallet balance for the user already exist in wallet table
    * @param array $inputData 
    * return bool    
    */
    public function updateWalletDetails($inputData) {
        $id = $inputData['id'];
        $walletAmount = $inputData['wallet_amount'];
        $updatedAt = $inputData['updated_at'];
        $updateWalletBalance = DB::table('tbl_user_wallet')
                                ->where('id',$id)
                                ->update([
                                    'wallet_amount' => $walletAmount,
                                    'updated_at' => $updatedAt
                                ]);
        return $updateWalletBalance;
    }
}
