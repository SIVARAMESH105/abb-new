<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class Affiliate extends Model
{
	protected $table = 'tbl_affiliate_users';
    protected $primaryKey = 'id';
    protected $fillable = ['name','email','address','URL_links'];
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
		$this->affiliated_code = $this->generateRandomString();
		$this->save();
		return $this->id;
	}
	
	/*
		* This function is used to check email is already exist
		* @param string $email
		* return int count
	*/
	public function checkEmail($email) {
		$count = DB::table($this->table)->where("email", $email)->count();
		return $count;
	}

	/*
		* This function is used to get the result by using Id
		* @param int auth id
		* retrun result
	*/
	public function getAffiliateById($id) {
		$result = DB::table($this->table)->select('userId','name','email','affiliated_code')->where('userId', $id)->first();
		return $result;
	}

	/*
		* This function is used to get the result by using Id
		* @param int auth id
		* retrun result
	*/
	public function getAffiliateByCode($code) {
		$result = DB::table($this->table)->select('id','commission_percentage')->where('affiliated_code', $code)->first();
		return $result;
	}

	/*
		* This function is used to genarate ramdom string
		* @param int $length
		* return string
	*/
	private function generateRandomString($length = 6) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	} 	
	
	/*
        * This function is used to get list of affiliate report for affiliate dashboard
        * 
        * return object
    */
    public function getAffiliateReportList($id) {
        $getAffiliateReportListSql = DB::table('tbl_affiliate_fees')
                    ->leftjoin('tbl_affiliate_users', 'tbl_affiliate_fees.affiliate_id', '=', 'tbl_affiliate_users.id')
                    ->leftjoin('tbl_camp', 'tbl_affiliate_fees.camp_id', '=', 'tbl_camp.id')
                    ->select('tbl_affiliate_fees.id', 'tbl_affiliate_fees.created_at', 'tbl_affiliate_users.URL_links','tbl_affiliate_users.commission_percentage', 'tbl_camp.camp_focus', 'tbl_affiliate_fees.amount', 'tbl_affiliate_fees.is_paid')
                    ->where([
                        ["tbl_affiliate_users.userId", '=', $id],
                        ["tbl_affiliate_users.is_approved", '=', '1']
                    ])
                    ->get();
        return $getAffiliateReportListSql;
    }

    /*
    * This function is used to get commission of affiliate
    * 
    * return object
    */
    public function getPaidAndDueAmount($id) {
        $getCommission['due'] = DB::table('tbl_affiliate_fees')
                    ->leftjoin('tbl_affiliate_users', 'tbl_affiliate_fees.affiliate_id', '=', 'tbl_affiliate_users.id')
                    ->select(DB::raw('SUM(tbl_affiliate_fees.amount) as dueamount'))
                    ->where([
                        ["tbl_affiliate_users.userId", '=', $id],
                        ['tbl_affiliate_fees.is_paid', '=', '0']
                    ])->get();
        $getCommission['paid'] = DB::table('tbl_affiliate_fees')
                    ->leftjoin('tbl_affiliate_users', 'tbl_affiliate_fees.affiliate_id', '=', 'tbl_affiliate_users.id')
                    ->select(DB::raw('SUM(tbl_affiliate_fees.amount) as paidamount'))
                    ->where([
                        ["tbl_affiliate_users.userId", '=', $id],
                        ['tbl_affiliate_fees.is_paid', '=', '1']
                    ])->get();
        return $getCommission;
    }

    /**
    	* This function is used to get commission of affiliate
    	* @param int $authId
    	* return object
    **/
    public function getReferenceUsers($authId) {
    	$getAffiliate = $this->getAffiliateById($authId);
    	$affCode = $getAffiliate->affiliated_code;
    	$result = DB::table('users')->select('id','name','email','user_type','home_phone','created_at')->where(array('affiliate_reference_code'=>$affCode, 'user_type'=>3))->get();
    	return $result;
    }
	
}
