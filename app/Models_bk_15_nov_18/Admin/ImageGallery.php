<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;

class ImageGallery extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'image_gallery';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['realname', 'email', 'phone', 'caption', 'image'];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getImageList(){      
        $images = DB::table('image_gallery')
                    ->select('id','realname','email','phone','image','caption', 'status');
       /* $images = DB::table('image_gallery')
                    ->select('realname','email','phone','image','caption', 'status')->orderBy('id', 'asc')->get();*/             
        return $images;
    }
    public function imageStatus($id, $imagestatus)
    {
        $update = DB::table('image_gallery')->where('id', $id)->update(array('status'=>$imagestatus));
        
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
}
