<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;
use DateTime;
use Carbon\Carbon;

class SliderCaption extends Model
{
    protected $table = 'tbl_slider_caption';
    protected $primaryKey = 'id';
    protected $fillable = ['caption'];
    public $timestamps = false;
	
    /* Get Camp Ajax detail */
    public function getSliderCaptionDetails(){
		$sliders =DB::table('tbl_slider_caption')->get();
        return $sliders;
	}
   
}
