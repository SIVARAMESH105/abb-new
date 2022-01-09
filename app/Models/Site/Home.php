<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class Home extends Model
{
    //protected $table = 'tbl_state_codes';
    //protected $primaryKey = 'state_id';
    //protected $fillable = ['title'];
    //public $timestamps = false;
	
	public function contact($request){
		//echo "<pre>"; print_r($request); exit;
		$to = $request['recipient'];
		$from = $request['email'];
	}

}
