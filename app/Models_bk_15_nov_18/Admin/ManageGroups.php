<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\Models\Admin\ManageCamps;
use App\Models\Admin\ManageStates;
use App\Models\Admin\User;
use DB;

class ManageGroups extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_group';
    protected $primaryKey = 'group_id';
    public $timestamps = false;
    protected $fillable = [];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	
	public function getCampName()
	{
		$campObj = new ManageCamps();
		$campDetails = $campObj->getCamp($this->camp_id);
		if(count($campDetails) > 0)
		{
			return '<a href="groupDetails/'.$this->camp_id.'">'.$campDetails[0]->camp_focus.'</a>';
		}
	}
	
	public function getCity()
	{
		$campObj = new ManageCamps();
		$campDetails = $campObj->getCamp($this->camp_id);
		if(count($campDetails) > 0)
		{
			return $campDetails[0]->City;
		}
	}
	
	public function getState()
	{
		$campObj = new ManageCamps();
		$campDetails = $campObj->getCamp($this->camp_id);
		if(count($campDetails) > 0)
		{
			$stateObj = new ManageStates();
			return $stateObj->getStateName($campDetails[0]->State);
		}
	}
	
	public function getCampStartDate()
	{
		$campObj = new ManageCamps();
		$campDetails = $campObj->getCamp($this->camp_id);
		if(count($campDetails) > 0)
		{
			return $campDetails[0]->startdate;
		}
	}
	
	public function getNumberOfGroups()
	{
		return DB::table($this->table)->where('camp_id', '=', $this->camp_id)->count();
	}
	
	public function getGroupDetails($campId)
	{	
		$invities = DB::table('tbl_group_invites')->where('camp_id', $campId)->get();
		if(count($invities) > 0)
		{
			$userObj = new User();
			$invites = array();
			foreach($invities as $invity)
			{
				$groupCode = DB::table($this->table)->select('group_code')->where('group_id', $invity->group_id)->get();
				$invity->group_code = $groupCode[0]->group_code;
				$invity->user_name = $userObj->getUsername($invity->user_id);
				$invity->register = $userObj->isRegistered($invity->email, $invity->group_id);
				$invites[] = $invity;
			}
			//echo "<pre>"; print_r($invities); exit;
			return $invities;
		}
	}
	
	public function getGroupOrganizerName($groupCode)
	{
		$organizerName = DB::table($this->table)->select('users.name')->join('users','tbl_group.user_id','=','users.id')->where(['tbl_group.group_code' => $groupCode])->get();
		if(count($organizerName) > 0)
		{
			return $organizerName[0]->name;
		}
	}
	
	public function updateInvity($inputData)
	{
		$update = DB::table('tbl_group_invites')->where('id', $inputData['id'])->update(
					['first_name' => $inputData['firstName'], 'last_name' => $inputData['lastName'], 'email' => $inputData['email']]
					);
	}
	
	public function deleteInvity($id)
	{
		DB::table('tbl_group_invites')->where('id', '=', $id)->delete();
	}

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
	
	public function camp() {
		return $this->belongsTo('App\Models\Admin\ManageCamps', 'camp_id');
	}

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
