<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;
use Hash;
use Session;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];
    
	public function saveRegisterUser(array $Inputarr){
		$chk_users = $this::where('email',$Inputarr['user_email'])->get();
		//echo '<pre>'; print_r($chk_users[0]['id']);die;
		$date = $Inputarr["date"]; 
		$month = $Inputarr["month"]; 
		$year = $Inputarr["year"]; 
		$dobval = $date.'-'.$month.'-'.$year;
		$dob =date("Y-m-d", strtotime($dobval));
		if($chk_users->isEmpty()){ 
			$this->name = $Inputarr["first_name"]; 
			$this->email = $Inputarr["user_email"];  
			$this->password = Hash::make($Inputarr["user_password"]);
			$this->user_type = 3;
			$this->fname = $Inputarr["first_name"]; 
			$this->gender = $Inputarr["gender"]; 
			$this->dob = $dob;
			$this->grade = $Inputarr["grade_level"]; 
			$this->parent_firstname = $Inputarr["parent_first_name"]; 
			$this->parent_lastname = $Inputarr["parent_last_name"]; 
			$this->address = $Inputarr["address"]; 
			$this->city = $Inputarr["city"]; 
			$this->state = $Inputarr["state"]; 
			$this->zip = $Inputarr["zip_code"]; 
			$this->country = $Inputarr["country"];
			$this->home_phone = $Inputarr["home_phone"]; 
			$this->work_phone = $Inputarr["other_phone"]; 
			$this->parent_email = $Inputarr["parent_email"]; 
			$this->basketball_exp = $Inputarr["session_before"]; 
			$this->basketball_exp_desc = $Inputarr["other_session"]; 
			$this->basketball_skill = $Inputarr["rating"];
			if(Session::get('affcode')!='') {
				$this->affiliate_reference_code =Session::get('affcode');	
			}
			$this->save();
			$user_id = $this->id;
			return $user_id;
		} else{
			return $user_id = $chk_users[0]['id'];
		} 
	}
	
	public function getUser($user_id){
		$username = DB::table($this->table)->where('id',$user_id)->first();
		return $username;
	}
	
	public function getUserDetails(array $requestArr){
		$userDetails = DB::table($this->table)->where('email',$requestArr['email'])->where('user_type',3)->first();
		if(!empty($userDetails)) {
			if(Hash::check($requestArr['password'], $userDetails->password)){
				return $userDetails;
			}else{
				return 'out';
			}
		}else {
			return 'no_user';
		}
		
	}
	
	public function getUsername($email){
		$username = DB::table($this->table)->select('name')->where('email',$email)->first();
		return $username;
	}
	
	public function getUserInfo($email){
		$userInfo = DB::table($this->table)->where('email',$email)->first();
		return $userInfo;
	}
	
	public function updateUserPassword(array $requestArr){
		DB::table($this->table)->where('id',$requestArr['user_id'])
			->update(['password' =>Hash::make($requestArr['password'])]);
		return true;
	}
	
	public function updateUserNameWithAll(array $requestArr){//echo '<pre>'; print_r($requestArr);die;
		DB::table($this->table)->where('id',$requestArr['id'])
			->update(['name' =>$requestArr['user_name'],'fname' =>$requestArr['fname'],'gender' =>$requestArr['gender'],'dob' =>$requestArr['dob'],'grade' =>$requestArr['grade'],'parent_firstname' =>$requestArr['parent_firstname'],'parent_lastname' =>$requestArr['parent_lastname'],'address' =>$requestArr['address'],'city' =>$requestArr['city'],'state' =>$requestArr['state'],'zip' =>$requestArr['zip'],'country' =>$requestArr['country'],'home_phone' =>$requestArr['home_phone'],'parent_email' =>$requestArr['parent_email'],'basketball_exp' =>$requestArr['session_before'],'basketball_exp_desc' =>$requestArr['other_session'],'basketball_skill' =>$requestArr['rating']]);
		return true;
	}
	
	public function updateUserEmailWithAll(array $requestArr){
		DB::table($this->table)->where('id',$requestArr['id'])
			->update(['email' =>$requestArr['user_email'],'fname' =>$requestArr['fname'],'gender' =>$requestArr['gender'],'dob' =>$requestArr['dob'],'grade' =>$requestArr['grade'],'parent_firstname' =>$requestArr['parent_firstname'],'parent_lastname' =>$requestArr['parent_lastname'],'address' =>$requestArr['address'],'city' =>$requestArr['city'],'state' =>$requestArr['state'],'zip' =>$requestArr['zip'],'country' =>$requestArr['country'],'home_phone' =>$requestArr['home_phone'],'parent_email' =>$requestArr['parent_email'],'basketball_exp' =>$requestArr['session_before'],'basketball_exp_desc' =>$requestArr['other_session'],'basketball_skill' =>$requestArr['rating']]);
		return true;
	}
	
	public function updateProfile(array $requestArr){
		DB::table($this->table)->where('id',$requestArr['id'])
			->update(['fname' =>$requestArr['fname'],'gender' =>$requestArr['gender'],'dob' =>$requestArr['dob'],'grade' =>$requestArr['grade'],'parent_firstname' =>$requestArr['parent_firstname'],'parent_lastname' =>$requestArr['parent_lastname'],'address' =>$requestArr['address'],'city' =>$requestArr['city'],'state' =>$requestArr['state'],'zip' =>$requestArr['zip'],'country' =>$requestArr['country'],'home_phone' =>$requestArr['home_phone'],'parent_email' =>$requestArr['parent_email'],'basketball_exp' =>$requestArr['session_before'],'basketball_exp_desc' =>$requestArr['other_session'],'basketball_skill' =>$requestArr['rating']]);
		return true;
	}
	
	public function updateUserPwd(array $requestArr){
		DB::table($this->table)->where('id',$requestArr['id'])
			->update(['password' =>Hash::make($requestArr['new_password'])]);
		return true;
	}
	
	public function getCampDetails(){
		if($_SESSION['cur_user_id']!=''){
			$user_id = $_SESSION['cur_user_id'];
		}else{
			$campDetails =array();
			return $campDetails;
		}
		$campDetails = DB::table('tbl_roster as r')
            ->join('tbl_camp as c', 'c.id', '=', 'r.camp_id')
            ->join('tbllocation as l', 'l.id', '=', 'c.LocationId')
            ->join('tbl_country as Co', 'Co.country_id', '=', 'l.Country')
            ->select('r.id','r.last_update','r.group_discount','r.group_id','r.amount_paid','c.id as c_id','c.camp_focus','c.startdate','c.enddate','c.starttime','c.endtime','c.cost','c.contact','l.Location','l.Address','l.City','Co.country_name', 'r.is_cancelled as cancelcamp')
            ->where('r.user_id','=' ,$user_id)
            ->get();
		return $campDetails;
	}
	
	public function getGroupDetails(){
		$groupDetails = DB::table('tbl_group as tg')
            ->join('tbl_group_invites as gi', 'gi.group_id', '=', 'tg.group_id')
            ->join('tbl_camp as c', 'c.id', '=', 'tg.camp_id')
            ->join('tbllocation as l', 'l.id', '=', 'c.LocationId')
            ->join('tbl_country as Co', 'Co.country_id', '=', 'l.Country')
            ->select('tg.group_id','tg.group_code','c.camp_focus','c.startdate','c.enddate','c.cost','c.contact','l.Location','l.Address','l.City','Co.country_name')
            ->where('tg.user_id','=' ,$_SESSION['cur_user_id'])
            ->groupBy('tg.group_id')
            ->orderBy('tg.group_id','asc')
            ->get();
			//echo '<pre>'; print_r($groupDetails);die;
		return $groupDetails;
	}
	
	public function getGroupInviteCount($group_id){
		$groupDetails = DB::table('tbl_group_invites')
						->where('group_id','=' ,$group_id)
						->count();
	return $groupDetails;
	}
	
	public function getUser_name($userId)
	{
		$user = DB::table($this->table)->where('id', $userId)->get();
		if(count($user) > 0)
		{
			return $user[0]->name;
		}
	}
	
	public function isRegistered($userEmail)
	{
		return DB::table($this->table)->where('email', $userEmail)->count();
	}
	
	public function getOrderProductDetails($user_id){
		
		$productDetails = DB::table('tbl_order as or')
            ->join('tbl_order_item as oi', 'oi.od_id', '=', 'or.od_id')
            ->join('tbl_product as p', 'p.pd_id', '=', 'oi.pd_id')
            ->select('or.od_id', 'or.od_date','or.od_wa_cost','or.user_id','oi.pd_id','oi.od_qty','oi.od_size','oi.od_color','p.pd_name','p.pd_category','p.pd_thumbnail','p.pd_price')
            ->where('or.user_id','=' ,$user_id)
            ->orderBy('or.od_id','desc')
            ->get();
			//echo '<pre>'; print_r($productDetails);die;
		return $productDetails;
	}
    public function uploadPhotos(array $requestArr, $image)
    {
        return DB::table('image_gallery')->insert(
            ['realname' => $requestArr['realname'], 'email' => $requestArr['email'], 'phone' => $requestArr['phone'], 'image' => $image, 'caption' => $requestArr['caption']]
        );

    }

    /**
    * This function is used to edit the ccamp in user camp registration
    * @param int $userId, array $data 
    * return bool
    */
    public function editCampChildDetails($user_id, $data) {
        $checkMail = DB::table($this->table)->where([
            ['email','=',$data['user_email']],
            ['id','<>',$user_id],
        ])->get();
        $date = $data["date"]; 
        $month = $data["month"]; 
        $year = $data["year"]; 
        $dobval = $date.'-'.$month.'-'.$year;
        $data['dob'] = date("Y-m-d", strtotime($dobval));
        if($checkMail->isEmpty()){ 
            DB::table($this->table)->where('id',$user_id)
                ->update(['name' =>$data['student_name'],'email' =>$data['user_email'],'gender' =>$data['gender'],'dob' =>$data['dob'],'grade' =>$data['grade_level'],'parent_firstname' =>$data['parent_first_name'],'parent_lastname' =>$data['parent_last_name'],'address' =>$data['address'],'city' =>$data['city'],'state' =>$data['state'],'zip' =>$data['zip_code'],'country' =>$data['country'],'home_phone' =>$data['home_phone'],'work_phone' =>$data['other_phone'],'parent_email' =>$data['parent_email'],'basketball_exp' =>$data['session_before'],'basketball_exp_desc' =>$data['other_session'],'basketball_skill' =>$data['rating']]);
            if (!empty($data['hearabout'])) {
                DB::table('tbl_roster')->where('id',$data['roster_id'])->update(['hear' =>$data['hearabout']]);
            }
            return true;
        } else {
            return false;
        }
    }
}
