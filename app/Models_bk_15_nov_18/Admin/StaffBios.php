<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Image;
use DB;

class StaffBios extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_staffbios';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['name', 'lft', 'short_desc', 'content'];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function displayPhoto()
	{
		return '<img src="'.url('/public/uploads/images/staffbios/'.$this->image).'" width="70px" height="80px">';
	}
    public function displayThumbnail()
    {
        return '<img src="'.url('/public/uploads/images/staffbios/thumb/'.$this->thumbnail).'" width="70px" height="80px">';
    }

    public function displayLink()
    {
        return '<a href="'.url('admin/staffbios/'.$this->id.'/edit').'">'.$this->name.'</a>';
    }
	
    /* Function present only when creating thumbnail image from main image */ 
  public function thumbnail($request, $requestType, $id)
	{
        if($request->hasFile('thumbnail'))
        {   
            $NewThumbName = $request->file('thumbnail')->getClientOriginalName();
            $extensionName = $request->file('thumbnail')->getClientOriginalExtension();
            $hashEncrypt = md5($NewThumbName . microtime()).'.'.$extensionName;
            $thumb = Image::make($request->file('thumbnail')->getRealPath())->resize(150, 150)->save(public_path('uploads/images/staffbios/thumb/'.$hashEncrypt));
            if($requestType == 'update')
            {
                $id = $request->all()['id'];
                $getStaff = DB::table($this->table)->where('id', $id)->get();
                if(count($getStaff) > 0) {
                    \File::delete(public_path('uploads/images/staffbios/thumb/'.$getStaff[0]->thumbnail));
                }
            }
            $updateThumb = DB::table($this->table)->where('id', $id)->update(['thumbnail' => $hashEncrypt]);
        }
		
	} 

    public function mainPhoto($request, $requestType, $id) 
    {
        if ($request->hasFile('image')) 
        {
            $data = getimagesize($request->file('image'));
            $width = $data[0];
            $height = $data[1];
            $newPhotoName = $request->file('image')->getClientOriginalName();
            $extensionName = $request->file('image')->getClientOriginalExtension();
            $encryptedName = md5($newPhotoName . microtime()).'.'.$extensionName;
            $largePhoto = Image::make($request->file('image')->getRealPath());
            if ($height > 480 && $width > 650) {
                $largePhoto->resize(650, 480, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else if ($height > 480 && $width < 650) {
                $largePhoto->resize(Null, 480, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else if ($width > 650 && $height < 480) {
                $largePhoto->resize(650, Null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $largePhoto->save(public_path('uploads/images/staffbios/'.$encryptedName)); 
            if($requestType == 'update')
            {
                $id = $request->all()['id'];
                $getStaffPhoto = DB::table($this->table)->where('id', $id)->get();
                if(count($getStaffPhoto) > 0) {
                    $oldPhoto = $getStaffPhoto[0]->image;
                    \File::delete(public_path('uploads/images/staffbios/'.$oldPhoto));  
                }
            }
            $updateLargePhoto = DB::table($this->table)->where('id', $id)->update(['image' => $encryptedName]);
        }
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
	// public function setImageAttribute($value) {	#function name should defind in camelcase with respective DB field
 //        $attribute_name = "image";
 //        $disk = "staffbios";
 //        $destination_path = "";
 //        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
 //    }
    // public function setThumbnailAttribute($value) {        
    //     $image = $value;
    //     $img = \Image::make($image->getRealPath())->resize(150, 150);
    //     $attribute_name = "thumbnail";
    //     $disk = "staffbiosThumb";
    //     $destination_path = "";
    //     $this->uploadFileToDisk($img, $attribute_name, $disk, $destination_path);
    // }
	
	public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {	#Deleting uploaded respective file while deleting the record from crud
            \Storage::disk('staffbios')->delete($obj->image);
            \Storage::disk('staffbiosThumb')->delete($obj->thumbnail);
        });
    }
}
