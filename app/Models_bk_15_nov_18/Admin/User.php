<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ManageCoaches;
use DB;
use Hash;

class User extends Model {

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/
	protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['name'];
	
	public function updateProfile($inputData = array(), $id) {
		$user_details = user::find($id);
		$user_details->id = $id;
		$user_details->name = $inputData['username'];
		$user_details->email = $inputData['useremail'];
		$user_details->save();
		return $user_details->id;
	}
	
	function updatePass($inputData = array(), $id) {
		$user = user::find($id);
		if(Hash::check($inputData['current_password'], $user->password)) {
			$user->password = Hash::make($inputData['new_password']);
			$user->save();
			return $user->id;
		}
	}
	
	public function insertCoach($inputData)
	{
		$name = $inputData['first_name'].' '.$inputData['last_name'];
		$password = Hash::make($inputData['password']);
		$userId = DB::table($this->table)->insertGetId(['name' => $name, 'email' => $inputData['username'], 'password' => $password, 'user_type' => '2']);
		return $userId;
	}
	
	public function updateCoach($inputData)
	{
		$coach = ManageCoaches::find($inputData['id']);
		$user = user::find($coach->user_id);
		$user->name = $inputData['first_name'].' '.$inputData['last_name'];
		$user->email = $inputData['username'];
		if($inputData['password'] != $user->password) {
			$user->password = Hash::make($inputData['password']);
		}
		$user->save();
	}
	
	public function getUser($id)
	{
		return user::find($id);
	}
	
	public function checkUsernameAvail($username)
	{
		echo $count = DB::table($this->table)->where('email', $username)->count(); exit;
	}
	
	public function getUsername($userId)
	{
		$user = DB::table($this->table)->where('id', $userId)->get();
		if(count($user) > 0)
		{
			return $user[0]->name;
		}
	}
	
	public function isRegistered($userEmail, $groupId)
	{
		$user = DB::table($this->table)->select('id')->where('email', $userEmail)->get();
		if(count($user) > 0)
		{
			$userId = $user[0]->id;
			return DB::table('tbl_roster')->where(array('user_id' => $userId, 'group_id' => $groupId))->count();
		}
	}
	
	public function updateCamperDetail(array $Inputarr){
		$user_details = user::find($Inputarr['id']);
		if(!empty($user_details)){
			$user_details->name = $Inputarr["name"]; 
			$user_details->fname = $Inputarr["fname"]; 
			$user_details->gender = $Inputarr["gender"]; 
			$user_details->dob = $Inputarr["dob"];
			$user_details->grade = $Inputarr["grade"]; 
			$user_details->parent_firstname = $Inputarr["parent_firstname"]; 
			$user_details->parent_lastname = $Inputarr["parent_lastname"]; 
			$user_details->address = $Inputarr["address"]; 
			$user_details->city = $Inputarr["city"]; 
			$user_details->state = $Inputarr["state"]; 
			$user_details->zip = $Inputarr["zip"]; 
			$user_details->country = $Inputarr["country"];
			$user_details->home_phone = $Inputarr["home_phone"]; 
			$user_details->work_phone = $Inputarr["work_phone"]; 
			$user_details->parent_email = $Inputarr["parent_email"]; 
			$user_details->basketball_exp = $Inputarr["basketball_exp"]; 
			$user_details->basketball_exp_desc = $Inputarr["basketball_exp_desc"]; 
			$user_details->basketball_skill = $Inputarr["basketball_skill"];
			$user_details->save();
			return 'ok';
		}else{
			return 'no';
		}
		
	}
}
?>