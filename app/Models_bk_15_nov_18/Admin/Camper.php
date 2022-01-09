<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;

class Camper extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_roster';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['name', 'fname', 'tshirtsize', 'gender', 'dob', 'grade', 'parent_firstname', 'parent_lastname', 'address', 'city', 'state', 'zip', 'country', 'home_phone', 'work_phone', 'parent_email', 'basketball_exp', 'basketball_exp_desc', 'basketball_skill'];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function mergeRosterName()
	{
		return '<a href="manageCampers/'.$this->id.'/edit">'.$this->name.' '.$this->fname.'</a>';
	}
	
	public function getCamperUserDetails($campId){
		//echo $campId;die;
		//$campId = 3614;
		$camper_user = DB::table('tbl_roster as tr')
				->join('users as u', 'u.id', '=', 'tr.user_id')
				->select('tr.id as tid','u.id as uid','u.name', 'u.fname','u.email', 'u.gender','u.dob', 'u.grade', 'u.basketball_skill', 'u.parent_firstname', 'u.parent_lastname', 'u.parent_email', 'u.home_phone', 'u.work_phone', 'tr.amount_paid', 'u.address', 'u.city', 'u.state', 'u.zip', 'tr.last_update', 'tr.tshirtsize')
				->where('tr.camp_id','=' ,$campId)
				->get();
		//echo '<pre>'; print_r($camper_user);die;
		return $camper_user;
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
