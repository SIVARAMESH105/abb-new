<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;

class ManageSliderCaption extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_slider_caption';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['captions'];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function insert($caption)
    {
        $captionId = DB::table($this->table)->insertGetId(['caption' => $caption]);
        return $captionId;
       
    }
	public function getSliderCaptionDetails(){
		$sliders =DB::table('tbl_slider_caption')->get();
        return $sliders;
	}
	
    public function editSliderCaptionDetails($id){
        $sliders =DB::table('tbl_slider_caption')->where('id', $id)->get();
        return $sliders;
    }

    public function updateSliderCaption($caption,$id){
        DB::table('tbl_slider_caption')->where('id', $id)->update(['caption' => $caption]);;
        return 'ok';
    }
	
	
    public function deleteSliderCaption($id){
        DB::table('tbl_slider_caption')->where('id',$id)->delete();
        return 'ok';
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
