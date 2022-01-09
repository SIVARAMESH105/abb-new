<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;
use Image;


class ManageCms extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_cms_content';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];
    public $timestamps = false;
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function linkPageTitle()
	{
		return '<a href="editCms/'.$this->id.'">'.$this->title.'</a>';
	}
	
	public function getPage($id)
	{
		$fields = $this->getPageFields($id);
		$page = DB::table('tbl_cms_content')->select(DB::raw($fields), 'title')->where('id', $id)->get();
		return $page;
	}
	
	public function getPageFields($id)
	{
		$pageFields = DB::table('tbl_cms_fields')->select('column_name')->where('page_id', $id)->get();
		$fields = array();
		foreach($pageFields as $pageField)
		{
			$fields[] = $pageField->column_name;
		}
		$fields = implode(" , ", $fields);
		return $fields;
	}
	
	public function getFieldTypes($id)
	{
		$pageFields = DB::table('tbl_cms_fields')->select('column_name', 'column_type')->where('page_id', $id)->get();
		$fieldTypes = array();
		foreach($pageFields as $pageField)
		{
			$fieldTypes[$pageField->column_name] = $pageField->column_type;
		}
		return $fieldTypes;
	}
	
	public function updatePage($request, $id)
	{
		$data = array();
		/* $pageImageFields = $this->getPageImageFields($id);
		foreach($pageImageFields as $imageField)
		{
			if($request->hasFile($pageFields))
			{
				if($request->file($pageFields)->isValid())
				{
					$fileName = time().'_'.$request->file($pageFields)->getClientOriginalName();
					$request->file($pageFields)->move("uploads/images/cms", $fileName);
					$data[$pageFields] = $fileName;
				}
			}
			else
			{
				
			}
		} */
		if($request->input('meta_val') !=''){
			$updateMetaVal = DB::table('tbl_cms_content')->where('id', $id)->update(array('meta' => $request->input('meta_val')));
		}
		
		$images =  request()->file('feature_image');
		if(!empty($images)) {
			$path = public_path()."/uploads/images/cms";
			if (!file_exists($path)) {
	    		mkdir($path, 0777, true);
			}
			
			$f_name = $images->getClientOriginalName();
			$fileName = str_replace(" ", "-", $f_name);
			$filePath = $path;
			$images->move($filePath,$fileName);
			$updateImg = DB::table('tbl_cms_content')->where('id', $id)->update(array('image1' => $images->getClientOriginalName()));
            
            // FOR RESIZE THE UPLOAD IMAGE


            // $fileName = str_replace(" ", "-", $f_name);
            // $thumb = Image::make($images->getRealPath())->resize(Null, 265, function ($constraint) {
            //         $constraint->aspectRatio();
            //     })->save(public_path('uploads/images/cms/'.$fileName));
            // $updateImg = DB::table('tbl_cms_content')->where('id', $id)->update(array('image1' => $fileName));               
        }
		
		foreach($request->input() as $column => $val)
		{
			$data[$column] = $val;
		}
		
		unset($data['_token']);
		unset($data['update']);
		$update = DB::table('tbl_cms_content')->where('id', $id)->update($data);
		return true;
	}
	
	public function getPageImageFields($id) 
	{
		$pageImageFields = DB::table('tbl_cms_fields')->select('column_name')->where('page_id', $id)->where('column_type', 'upload')->get();
		$imageFields = array();
		foreach($pageImageFields as $pageImageField)
		{
			$imageFields[] = $pageImageField->column_name;
		}
		return $imageFields;
	}
	
	
	public function getImgName($id)
	{
		$page = DB::table('tbl_cms_content')->select('image1')->where('id', $id)->get();
		return $page;
	}
	
	public function getMetaVal($id)
	{
		$page = DB::table('tbl_cms_content')->select('meta')->where('id', $id)->get();
		return $page;
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