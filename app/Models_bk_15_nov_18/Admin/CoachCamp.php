<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;
use DB;

class CoachCamp extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_coachcamp';
    protected $primaryKey = 'Id';
	
    public $timestamps = false;
    // protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */	
	public function getCampCoach($campId) {
		$campCoach = DB::table('tbl_coachcamp')->select('id', 'coach_id', 'camp_id')->where('camp_id', $campId)->get();
		$campCoach = $campCoach->toArray();
		return $campCoach;
	}
	
	public function updateCampCoach($inputData = array()) {
		$coachInfo = CoachCamp::where('camp_id', $inputData['id'])->count();
		if($coachInfo > 0) {
			$coachUpdate = DB::table('tbl_coachcamp')->where('camp_id', $inputData['id'])->update(['coach_id' => $inputData['coachAssign']]);
		} else {
			$coachInsert = DB::table('tbl_coachcamp')->insert(['coach_id' => $inputData['coachAssign'], 'camp_id' => $inputData['id'], 'last_update' => Carbon::now()]);
		}
	}
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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
