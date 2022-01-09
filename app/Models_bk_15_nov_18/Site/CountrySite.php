<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class CountrySite extends Model
{
    //
	protected $table = 'tbl_country';
    protected $primaryKey = 'country_id';
    protected $fillable = ['title'];
    public $timestamps = false;
	
	public function getCountryDetails(){
		
		$country_details = DB::table('tbl_country')->select('country_id','country_code','country_name')->orderBy('country_id','asc')->get();
		return $country_details;
	}
	
	public static function countryList()
	{	
		return ['US' => 'United States', 'AR' => 'Argentina', 'AUS' => 'Australia', 'AT' => 'Austria', 'BS' => 'Bahamas', 'BE' => 'Belgium', 	'BM' => 'Bermuda', 'BR' => 'Brazil', 'BG' => 'Bulgaria', 'CA' => 'Canada', 'CL' => 'Chile', 'CN' => 'China', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'FR' => 'France', 	'DE' => 'Germany', 'GR' => 'Greece', 'GD' => 'Grenada', 'GT' => 'Guatemala', 'HK' => 'Hong Kong S.A.R., China', 	'HU' => 'Hungary', 'IN' => 'India', 'ID' => 'Indonesia', 'IE' => 'Ireland', 'IL' => 'Israel', 'IT' => 'Italy', 'JP' => 'Japan', 'KW' => 'Kuwait', 'LB' => 'Lebanon', 'LT' => 'Lithuania', 'MY' => 'Malaysia', 'MX' => 'Mexico', 'NL' => 'Netherlands', 'NZ' => 'New Zealand', 'NG' => 'Nigeria', 'PE' => 'Peru', 'PH' => 'Philippines', 'PL' => 'Poland', 	'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RO' => 'Romania', 'RU' => 'Russia', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'SP' => 'Serbia', 'SG' => 'Singapore', 'ZA' => 'South Africa', 'KR' => 'South Korea', 	'ES' => 'Spain', 'CH' => 'Switzerland', 'TW' => 'Taiwan', 'TR' => 'Turkey', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates',	'GB' => 'United Kingdom',  'VN' => 'Vietnam', '' => 'Other'];
	}
	
}
