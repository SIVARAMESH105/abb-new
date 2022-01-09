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
		
		$page_details = DB::table('tbl_cms_content')->select('title','content','content1','content2','content3','content4','content5','content6','sidebar','page_type','image1','image2','image3','image4','image5','image6','meta','meta_title')->where('title', $page_name)->get();       
		return $page_details;  
	}  

	public function getSearchDetails($searchValue){
		
		$page_details =DB::table('tbl_cms_content')->where('content', 'like', '%'.$searchValue.'%')->get();
		return $page_details;
	}

}
