<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;

class VideoGallery extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_videos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'video', 'image','transcript','video_alt_text', 'order'];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	
	public function displayPoster()
	{
		$posterImage = "";
        if ($this->image){
            $posterImage = $this->image;
	    } else {
            $posterImage = "Noimage.png";
        }
        return '<img src="'.url('/public/uploads/videos/posters/'.$posterImage).'" width="100px">';
    }
    public function activeStatus()
    {
        $checkMessage = "";
        if ($this->status == 1) {
            $checkMessage = "checked";
        }
        $activeStatus = '<input type="checkbox" '.$checkMessage.' title="Click to set Active/Inactive" onclick="statusCheck('.$this->id.')" id="video_status_'.$this->id.'">';
        return $activeStatus;
    }
    public function changeStatus($id, $videostatus)
    {
        $update = DB::table($this->table)->where('id', $id)->update(array('status'=>$videostatus));
        
    }

	public function getLists()
    {
        $lists = DB::table($this->table)->where('status', 1)->get();
		return $lists;
        
    }
	
	public function getListsById($id)
    {
        $lists = DB::table($this->table)->where(array('status'=>1,'id'=>$id))->first();
		return $lists;
        
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
	public function setVideoAttribute($value) {	#function name should defind in camelcase with respective DB field
        $attribute_name = "video";
        $disk = "videos";
        $destination_path = "";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
	
	public function setImageAttribute($value) {	#function name should defind in camelcase with respective DB field
        $attribute_name = "image";
        $disk = "videoPosters";
        $destination_path = "";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
	
	public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {	#Deleting uploaded respective file while deleting the record from crud
            \Storage::disk('videos')->delete($obj->video);
            \Storage::disk('videoPosters')->delete($obj->image);
            \Storage::disk('videoTranscript')->delete($obj->transcript);

        });
    }
	
	/*
		* To store video gallary during location add
		* 
		* 
	*/
	public function videoGallaryStore($inputData) {
	
		$id = DB::table($this->table)->insertGetId(['title' => $inputData['title'], 'video'=>$inputData['video'],'transcript'=>$inputData['transcript']]);
		return $id;
	}

    /*
        * For Transcript file upload need a function
        
    */


    public function setTranscriptAttribute($value) { #function name should defind in camelcase with respective DB field
        $attribute_name = "transcript";
        $disk = "videoTranscript";
        $destination_path = "";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
