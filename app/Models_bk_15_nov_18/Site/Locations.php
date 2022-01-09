<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Locations extends Model
{
    protected $table = 'tbllocation';
    protected $primaryKey = 'id';
    public $timestamps = false;
	
	public function getCityDetails($stateId){
		if($stateId !=''){
			$city_details = DB::table('tbllocation')
			->join("tbl_camp", "tbllocation.Id", "=", "tbl_camp.LocationId")
            ->select("tbllocation.City")
			->where([
			    ["tbllocation.State", "=", $stateId],
			    ["tbl_camp.status", "=", 1],
			])
			->whereDate('tbl_camp.startdate', '>', Carbon::now())
            ->groupBy("tbllocation.City")
			->get();
			return $city_details;
		}
	}	
}
