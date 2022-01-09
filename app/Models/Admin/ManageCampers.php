<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;

class ManageCampers extends Model
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
    protected $fillable = ['name', 'tshirtsize', 'gender', 'dob', 'grade', 'parent_firstname', 'parent_lastname', 'address', 'city', 'state', 'zip', 'country', 'home_phone', 'work_phone', 'parent_email', 'basketball_exp', 'basketball_exp_desc', 'basketball_skill'];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public static function countryList()
	{	
		return ['' => 'Other', 'AR' => 'Argentina', 'AU' => 'Australia', 'AT' => 'Austria', 'BS' => 'Bahamas', 'BE' => 'Belgium', 	'BM' => 'Bermuda', 'BR' => 'Brazil', 'BG' => 'Bulgaria', 'CA' => 'Canada', 'CL' => 'Chile', 'CN' => 'China', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'FR' => 'France', 	'DE' => 'Germany', 'GR' => 'Greece', 'GD' => 'Grenada', 'GT' => 'Guatemala', 'HK' => 'Hong Kong S.A.R., China', 	'HU' => 'Hungary', 'IN' => 'India', 'ID' => 'Indonesia', 'IE' => 'Ireland', 'IL' => 'Israel', 'IT' => 'Italy', 'JP' => 'Japan', 'KW' => 'Kuwait', 'LB' => 'Lebanon', 'LT' => 'Lithuania', 'MY' => 'Malaysia', 'MX' => 'Mexico', 'NL' => 'Netherlands', 'NZ' => 'New Zealand', 'NG' => 'Nigeria', 'PE' => 'Peru', 'PH' => 'Philippines', 'PL' => 'Poland', 	'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RO' => 'Romania', 'RU' => 'Russia', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'SP' => 'Serbia', 'SG' => 'Singapore', 'ZA' => 'South Africa', 'KR' => 'South Korea', 	'ES' => 'Spain', 'CH' => 'Switzerland', 'TW' => 'Taiwan', 'TR' => 'Turkey', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates',	'GB' => 'United Kingdom', 'US' => 'United States', 'VN' => 'Vietnam'];
	}

	public function getCamperDetails(){
		$campers = DB::table('tbl_roster as tr')
				->join('users as u', 'u.id', '=', 'tr.user_id')
				->join('tbl_order_camp as tc', 'tc.roster_id', '=', 'tr.id')
				->select('tr.id as tid','u.id as uid','u.name', 'u.fname','u.email', 'u.gender','u.dob', 'u.grade', 'u.basketball_skill', 'u.parent_firstname', 'u.parent_lastname', 'u.parent_email', 'u.home_phone', 'u.work_phone', 'tr.amount_paid', 'u.address', 'u.city', 'u.state', 'u.zip', 'tr.last_update', 'tr.tshirtsize')
				->groupBy('u.email')
				->get();
		return $campers;
	}
	
	public function deleteCamper($ros_id){
		DB::table('tbl_roster')->where('id',$ros_id)->delete();
		return 'ok';
	}
	
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
	public function tshirtSize() {
		return $this->belongsTo('App\Models\Admin\tshirtSize', 'tshirtsize');
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
