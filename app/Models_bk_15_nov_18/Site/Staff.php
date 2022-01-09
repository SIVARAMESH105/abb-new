<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class Staff extends Model
{
    protected $table = 'tbl_staffbios';
	
	public function getStaffDetails(){
		$staff = DB::table($this->table)->orderBy('lft')->get();
		return $staff;
	}

}
