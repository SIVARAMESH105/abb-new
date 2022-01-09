<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class GeoLocatedPages extends Model {

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

	protected $table = 'tbl_geo_pages';
	protected $primaryKey = 'id';
    public $timestamps = false;
	protected $fillable = ['location_id', 'title', 'content', 'image', 'video'];
}
?>