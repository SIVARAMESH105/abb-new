<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class ManageFlyers extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_flyer';
    protected $primaryKey = 'flyer_id';
    public $timestamps = false;
    protected $fillable = ['flyer_title', 'flyer_desc', 'flyer_pdf'];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {	#Deleting uploaded respective file while deleting the record from crud
            \Storage::disk('flyer')->delete($obj->flyer_pdf);
        });
    }
	
	public function getPdfLink()
	{
		$pdfIconSrc = asset('public/images/pdf.jpeg');
		$pdfUrl = asset('public/uploads/pdf/flyers/'.$this->flyer_pdf);
		return '<a href="'.$pdfUrl.'" target="_blank"><img src="'.$pdfIconSrc.'" width="22" height="22" border="0"></a>';
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
	public function setFlyerPdfAttribute($value) {	#function name should defind in camelcase with respective DB field
        $attribute_name = "flyer_pdf";
        $disk = "flyer";
        $destination_path = "";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
