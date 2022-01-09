<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class GroupInvites extends Model
{
    protected $table = 'tbl_group_invites';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];
	public $timestamps = false;
	 
	public function saveGroupInvites($group_camp_id,$user_email,$first_name,$last_name,$user_id,$group_id){
		$this->user_id = $user_id;
		$this->group_id = $group_id; 
		$this->camp_id = $group_camp_id; 
		$this->first_name = $first_name; 
		$this->last_name = $last_name; 
		$this->email = $user_email; 
		$this->save();
		$invite_id = $this->id;
		return $invite_id;
	}
	
	public function deleteGroupInvite($g_id,$id,$camp_id){
		DB::table($this->table)->where('id',$id)->where('camp_id',$camp_id)->where('group_id',$g_id)->delete();
		return 'ok';
	}
	
	public function getGroupInvite($id){
		$invite_val = DB::table($this->table)->where('id',$id)->first();
		return $invite_val;
	}
	
	public function updateUserGroupInvite(array $inputArr){
		DB::table($this->table)->where('id',$inputArr['cur_id'])->update(['first_name' => $inputArr['firstname'],'last_name' => $inputArr['lastname'],'email' => $inputArr['grpemail'],]);
		return 'ok';
	}
}
