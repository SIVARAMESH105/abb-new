<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class Groups extends Model
{
    protected $table = 'tbl_group';
    protected $primaryKey = 'group_id';
    protected $fillable = ['title'];
	public $timestamps = false;
	 
	public function saveGroup($user_id,$camp_id,$group_code){
		$this->camp_id = $camp_id; 
		$this->user_id = $user_id; 
		$this->group_code = $group_code; 
		$this->save();
		$group_id = $this->group_id;
		return $group_id;
	}
	
	public function chkGroupCode($group_code,$camp_id){
		$group_details = $this::where('group_code',$group_code)->where('camp_id',$camp_id)->first();
		if ($group_details == '') {
			return 'no';
		}
		return $group_details->group_id;
	}
	
	public function getGroupVal($g_id){
		$group_details = $this::where('group_id',$g_id)->first();
		return $group_details;
	}
	
	public function getGroupDetails($g_id){
		$invities = DB::table('tbl_group_invites')->where('group_id', $g_id)->get();
		if (count($invities) > 0) {
			$userObj = new Users();
			$invites = array();
			foreach($invities as $invity){
				$groupCode = DB::table($this->table)->select('group_code')->where('group_id', $invity->group_id)->get();
				$invity->group_code = $groupCode[0]->group_code;
				$invity->user_name = $userObj->getUser_name($invity->user_id);
				$invity->register = $userObj->isRegistered($invity->email);
				$invites[] = $invity;
			}
			return $invities;
		}
	}
	
	
}
