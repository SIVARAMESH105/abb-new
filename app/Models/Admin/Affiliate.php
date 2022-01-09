<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Affiliate extends Model
{
	protected $table = 'tbl_affiliate_users';
    protected $primaryKey = 'id';
    protected $fillable = ['name','email','address'];
   // public $timestamps = false;
	
	
	/*
		*This function is used to store the affilite register user
		*@param array $inputData
		*return int insertId
	*/
	public function saveAffiliate($inputData){
		$this->name = $inputData["name"]; 
		$this->address = $inputData["address"]; 
		$this->email = $inputData["email"];
		$this->phone = $inputData["phone"];
        $this->URL_links = $inputData["URL_links"]; 
		$this->commission_percentage = $inputData["commission_percentage"]; 
		$this->affiliated_code = uniqid();
		$this->save();
		return $this->id;
	}
	
	/*
		*This function is used to check email is already exist
		*@param string $email
		*return int count
	*/
	public function checkEmail($email) {
		$count = DB::table($this->table)->where("email", $email)->count();
		return $count;
	}
	
	/*
		*This function is used to check email is already exist except update Id
		*@param string $email, int $id
		*return int count
	*/
	public function checkEmailExceptEditId($email, $id) {
		$count = DB::table($this->table)->where("email", $email)->where("id", '!=', $id)->count();
		return $count;
	}
	
	/*
		*This function is used to get result by Id
		*@param int $id
		*return result object
	*/
	public function getResultById($id) {
		$result = DB::table($this->table)->where("id", $id)->first();
		return $result;
	}
	
	/*
		* This function is used to update 
		* @param array $inputData
		* return 
	*/
	public function updateAffiliate($inputData) {
		$update = DB::table($this->table)->where("id", $inputData['editId'])->update(["name"=>$inputData['name'],"address"=>$inputData['address'],"phone"=>$inputData['phone'],"email"=>$inputData['email'],"URL_links"=>$inputData['URL_links'],"commission_percentage"=>$inputData['commission_percentage']]);
	
	}
	
	/*
		* This function is used to update userId reference
		* @param int $userId,$affId
		* return
	*/
	public function updateAffiliateUserIdById($userId, $affId) {
		$update = DB::table($this->table)->where("id", $affId)->update(["userId"=>$userId, "is_approved"=>'1']);
	}

    /*
        * This function is used to get list of affiliate report
        * 
        * return object
    */
    public function getAffiliateReportList() {
        $getAffiliateReportListSql = DB::table('tbl_affiliate_fees')
                    ->leftjoin('tbl_affiliate_users', 'tbl_affiliate_fees.affiliate_id', '=', 'tbl_affiliate_users.id')
                    ->leftjoin('tbl_camp', 'tbl_affiliate_fees.camp_id', '=', 'tbl_camp.id')
                    ->select('tbl_affiliate_fees.id', 'tbl_affiliate_fees.created_at', 'tbl_affiliate_users.name', 'tbl_affiliate_users.URL_links','tbl_affiliate_users.commission_percentage', 'tbl_camp.camp_focus', 'tbl_affiliate_fees.amount', 'tbl_affiliate_fees.is_paid')
                    ->where('tbl_affiliate_users.is_approved', '=', '1')
                    ->get();
        return $getAffiliateReportListSql;
    }

    /*
    * Change affiliate commission payment status
    * 
    * return bool
    */
    public function ajaxAffiliatePaymentStatus($data) {
        $affiliateFeesId = $data['id'];
        $paymentStatus = $data['paymentStatus'];
        $updatePaymentStatus = DB::table('tbl_affiliate_fees')->where("id", $affiliateFeesId)->update(["is_paid"=>$paymentStatus]);
        return $updatePaymentStatus;
    }


    /*
    * This function is used to get commission of affiliate
    * 
    * return object
    */
    public function getPaidAndDueAmount() {
        $getCommission['due'] = DB::table('tbl_affiliate_fees')
                    ->select(DB::raw('SUM(tbl_affiliate_fees.amount) as dueamount'))
                    ->where('tbl_affiliate_fees.is_paid', '=', '0')
                    ->get();
        $getCommission['paid'] = DB::table('tbl_affiliate_fees')
                    ->select(DB::raw('SUM(tbl_affiliate_fees.amount) as paidamount'))
                    ->where('tbl_affiliate_fees.is_paid', '=', '1')
                    ->get();
        return $getCommission;
    }

    /**
    * This function is used to get affiliate mail details to send payment success mail notification
    *
    * @param array $data
    * return object
    **/
    public function getaffiliateMailDetails($data) {
        $affiliateId = $data['id'];
        $affiliateMailDetails = DB::table('tbl_affiliate_fees')
                    ->leftjoin('tbl_affiliate_users', 'tbl_affiliate_fees.affiliate_id', '=', 'tbl_affiliate_users.id')
                    ->leftjoin('tbl_camp', 'tbl_affiliate_fees.camp_id', '=', 'tbl_camp.id')
                    ->select('tbl_affiliate_users.email', 'tbl_affiliate_users.name', 'tbl_camp.camp_focus', 'tbl_affiliate_fees.amount')
                    ->where([
                        ['tbl_affiliate_fees.id', '=', $affiliateId]
                    ])->get();
        return $affiliateMailDetails;
    }
	
}
