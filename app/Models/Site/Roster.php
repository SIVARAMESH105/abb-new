<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class Roster extends Model
{
    protected $table = 'tbl_roster';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];
    public $timestamps = false;
	
	public function saveRoster(array $Inputarr,$user_id){
		$startdate = explode("-", $Inputarr["startdate"]); 
		$Esdate=date("Y-m-j", mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]));
		$today = date("Y-m-d");
		$EarlyBirdDate  =  date("Y-m-d", strtotime ( '-'.$Inputarr["EarlyBirdDays"].' day' . $Esdate ));
		if($EarlyBirdDate > $today){
			$cost = $Inputarr["cost"]-$Inputarr["EarlyBirdDiscount"];
		}else{
			$cost = $Inputarr["cost"];
		}
		$this->camp_id = $Inputarr["camp_id"]; 
		$this->user_id = $user_id; 
		$this->amount_paid = $cost; 
		$this->hear = $Inputarr["hearabout"]; 
		$this->last_update = date("Y-m-d");
		$this->save();
		$Roster_id = $this->id;
		return $Roster_id;
	} 
	
	public function getRegisterCampDetails($roster_id){
		$camp_details = DB::table('tbl_roster')
						->select('tbl_roster.*')
						->where('id',$roster_id)
						->first();
		return $camp_details;
	}
	
	public function updateGroupRoster($roster_id,$group_id){
		$camp_details = DB::table('tbl_roster')->where('id',$roster_id)->update(['group_discount' => 'yes','group_id' => $group_id]); 
		return $camp_details;
	}
	
	public function getRosterId($camp_id){
		$roster_id = DB::table('tbl_roster')
						->select('id')
						->where('camp_id',$camp_id)
						->orderby('id','desc')
						->first();
						
		return $roster_id;
	}
	
	public function getRosterDetails($roster_id){
		$roster_details = DB::table('tbl_roster')
						->select('tbl_roster.*')
						->where('id',$roster_id)
						->get();
		return $roster_details->toArray();
	}

	/*
		** This function is used to update the roster for cancel camp 
		** @param int $rosterId
		** return true
	*/
	public function updateCancelCamp($rosterId) {
		$updateRoster = DB::table('tbl_roster')->where('id',$rosterId)->update(['is_cancelled' => 1,'is_cancel_date'=>date('Y-m-d H:i:s')]);
		return $updateRoster;
	}

    /**
    ** This function is used to update the roster payment status paid if camp registration payment done
    ** @param int $rosterId
    ** return true
    */
    public function updateRosterPaymentStatus($rosterId) {
        $updatePaymentStatus = DB::table('tbl_roster')->where('id',$rosterId)->update(['status' => 'Paid']);
        return $updatePaymentStatus;
    }
}
