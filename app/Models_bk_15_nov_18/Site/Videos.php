<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class Videos extends Model
{
    protected $table = 'tbl_videos';
	
	public function getVideos(){
		$videos = DB::table($this->table)->where('status',1)->orderBy('order', 'asc')->get();
		return $videos;
	}

}
