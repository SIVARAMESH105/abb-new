<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class States extends Model
{
    protected $table = 'tbl_state_codes';
    protected $primaryKey = 'state_id';
    protected $fillable = ['title'];
    public $timestamps = false;
	
	public function getStateDetails($cid){
		if($cid !=''){
			$state_details = DB::table('tbl_state_codes')->select('state_id','state_code','state_name','country_id')->where('status',1)->where('country_id',$cid)->get();
			return $state_details;
		}else{
			$state_details = DB::table('tbl_state_codes')->select('state_id','state_code','state_name','country_id')->where('status',1)->where('country_id',1)->get();
			return $state_details;
		}
		
	}
	
	public function getStateCode($id)
	{
		$stateCode = DB::table($this->table)->select('state_code')->where('state_id', '=', $id)->get();
		return $stateCode[0]->state_code;
	}
	/*To get the Active State On schdule page*/
	public function getActiveStateCamp()
	{
		
		return $active_camps_states = DB::table('tbl_camp')
			->join("tbllocation", "tbllocation.Id", "=", "tbl_camp.LocationId")
            ->join("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State")
            ->select(DB::raw('DISTINCT(tbllocation.State) as state_id, tbl_state_codes.state_name'))
            ->where("tbl_camp.status", "=", 1)
			->orderBy("tbl_state_codes.state_id")
			->get();
	}

				  

}
