<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;

class ManageCountry extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_country';
    protected $primaryKey = 'country_id';
    protected $fillable = ['country_name', 'country_code'];
    public $timestamps = false;
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function countryList()
	{
		$countries = DB::table($this->table)->get();
		return $countries;
	}
	
	public function getCountryCode($id)
	{
		$countryCode = DB::table($this->table)->select('country_code')->where('country_id', '=', $id)->get();
		if(count($countryCode) > 0) {
			return $countryCode[0]->country_code;
		}
	}
	
	public static function countryStaticList()
	{	
		return ['' => 'Other', 'AR' => 'Argentina', 'AUS' => 'Australia', 'AT' => 'Austria', 'BS' => 'Bahamas', 'BE' => 'Belgium', 	'BM' => 'Bermuda', 'BR' => 'Brazil', 'BG' => 'Bulgaria', 'CA' => 'Canada', 'CL' => 'Chile', 'CN' => 'China', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'FR' => 'France', 	'DE' => 'Germany', 'GR' => 'Greece', 'GD' => 'Grenada', 'GT' => 'Guatemala', 'HK' => 'Hong Kong S.A.R., China', 	'HU' => 'Hungary', 'IN' => 'India', 'ID' => 'Indonesia', 'IE' => 'Ireland', 'IL' => 'Israel', 'IT' => 'Italy', 'JP' => 'Japan', 'KW' => 'Kuwait', 'LB' => 'Lebanon', 'LT' => 'Lithuania', 'MY' => 'Malaysia', 'MX' => 'Mexico', 'NL' => 'Netherlands', 'NZ' => 'New Zealand', 'NG' => 'Nigeria', 'PE' => 'Peru', 'PH' => 'Philippines', 'PL' => 'Poland', 	'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RO' => 'Romania', 'RU' => 'Russia', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'SP' => 'Serbia', 'SG' => 'Singapore', 'ZA' => 'South Africa', 'KR' => 'South Korea', 	'ES' => 'Spain', 'CH' => 'Switzerland', 'TW' => 'Taiwan', 'TR' => 'Turkey', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates',	'GB' => 'United Kingdom', 'US' => 'United States', 'VN' => 'Vietnam'];
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
