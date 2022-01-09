<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cmsfornt extends Model
{
    //
	protected $table = 'tbl_cms_content';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];
    public $timestamps = false;
	
	public function getPageDetails($page_name){
		
		$page_details = DB::table('tbl_cms_content')->select('title','content','sidebar','page_type','image1','meta')->where('title', $page_name)->get();
		return $page_details;
	}
}
