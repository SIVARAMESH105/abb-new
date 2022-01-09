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

	public function updateFeatureImage($id,$column)
	{
		$updateFeatureImage = DB::table('tbl_cms_content')->where('id', $id)->update(array($column => ''));
		return true;  
		
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
			$date = date("YmdHis");
			$path = public_path()."/uploads/images/cms";
			if (!file_exists($path)) {
	    		mkdir($path, 0777, true);
			}
			
			$f_name = $date.$images->getClientOriginalName();
			$fileName = str_replace(" ", "-", $f_name);
			$filePath = $path;
			$images->move($filePath,$fileName);
			$updateImg = DB::table('tbl_cms_content')->where('id', $id)->update(array('image1' => $fileName));



            
            // FOR RESIZE THE UPLOAD IMAGE


            // $fileName = str_replace(" ", "-", $f_name);
            // $thumb = Image::make($images->getRealPath())->resize(Null, 265, function ($constraint) {
            //         $constraint->aspectRatio();
            //     })->save(public_path('uploads/images/cms/'.$fileName));
            // $updateImg = DB::table('tbl_cms_content')->where('id', $id)->update(array('image1' => $fileName));               
        }

        $imageOne =  request()->file('img_image1');
        $imageTwo =  request()->file('img_image2');
        $imageThree =  request()->file('img_image3');
        $imageFour =  request()->file('img_image4');
        $imageFive =  request()->file('img_image5');
        $imageSix =  request()->file('img_image6');


        
		if(!empty($imageOne)) {

			$date = date("YmdHis");
			$path = public_path()."/uploads/images/cms";
			if (!file_exists($path)) {
	    		mkdir($path, 0777, true);
			}
			
			$f_nameOne = $date.$imageOne->getClientOriginalName();
			$fileNameOne = str_replace(" ", "-", $f_nameOne);
			$filePathOne = $path;
			$imageOne->move($filePathOne,$fileNameOne);
			$request->merge(['image1' => $fileNameOne]);
            $bannerImageOne = $request->input('image1');
			$updateImgOne = DB::table('tbl_cms_content')->where('id', $id)->update(array('image1' => $bannerImageOne));
		}

		if(!empty($imageTwo)) {
			$date = date("YmdHis");
			$path = public_path()."/uploads/images/cms";
			if (!file_exists($path)) {
	    		mkdir($path, 0777, true);
			}
			
			$f_nameTwo = $date.$imageTwo->getClientOriginalName();
			$fileNameTwo = str_replace(" ", "-", $f_nameTwo);
			$filePathTwo = $path;
			$imageTwo->move($filePathTwo,$fileNameTwo);
			$request->merge(['image2' => $fileNameTwo]);
            $bannerImageTwo = $request->input('image2');
			$updateImgTwo = DB::table('tbl_cms_content')->where('id', $id)->update(array('image2' => $bannerImageTwo));
		}

		if(!empty($imageThree)) {
			$date = date("YmdHis");
			$path = public_path()."/uploads/images/cms";
			if (!file_exists($path)) {
	    		mkdir($path, 0777, true);
			}
			
			$f_nameThree = $date.$imageThree->getClientOriginalName();
			$fileNameThree = str_replace(" ", "-", $f_nameThree);
			$filePathThree = $path;
			$imageThree->move($filePathThree,$fileNameThree);
			$request->merge(['image3' => $fileNameThree]);
            $bannerImageThree = $request->input('image3');
			$updateImgThree = DB::table('tbl_cms_content')->where('id', $id)->update(array('image3' => $bannerImageThree));
		}

		if(!empty($imageFour)) {
			$date = date("YmdHis");
			$path = public_path()."/uploads/images/cms";
			if (!file_exists($path)) {
	    		mkdir($path, 0777, true);
			}
			
			$f_nameFour = $date.$imageFour->getClientOriginalName();
			$fileNameFour = str_replace(" ", "-", $f_nameFour);
			$filePathFour = $path;
			$imageFour->move($filePathFour,$fileNameFour);
			$request->merge(['image4' => $fileNameFour]);
            $bannerImageFour = $request->input('image4');
			$updateImgFour = DB::table('tbl_cms_content')->where('id', $id)->update(array('image4' => $bannerImageFour));
		}

		if(!empty($imageFive)) {
			$date = date("YmdHis");
			$path = public_path()."/uploads/images/cms";
			if (!file_exists($path)) {
	    		mkdir($path, 0777, true);
			}
			
			$f_nameFive = $date.$imageFive->getClientOriginalName();
			$fileNameFive = str_replace(" ", "-", $f_nameFive);
			$filePathFive = $path;
			$imageFive->move($filePathFive,$fileNameFive);
			$request->merge(['image5' => $fileNameFive]);   
            $bannerImageFive = $request->input('image5');
			$updateImgFive = DB::table('tbl_cms_content')->where('id', $id)->update(array('image5' => $bannerImageFive));
		}

		if(!empty($imageSix)) {
			$date = date("YmdHis");
			$path = public_path()."/uploads/images/cms";
			if (!file_exists($path)) {
	    		mkdir($path, 0777, true);
			}
			
			$f_nameSix = $date.$imageSix->getClientOriginalName();  
			$fileNameSix = str_replace(" ", "-", $f_nameSix);
			$filePathSix = $path;
			$imageSix->move($filePathSix,$fileNameSix);  
			$request->merge(['image6' => $fileNameSix]);  
            $bannerImageSix = $request->input('image6');
			$updateImgSix = DB::table('tbl_cms_content')->where('id', $id)->update(array('image6' => $bannerImageSix));
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
		$page = DB::table('tbl_cms_content')->select('image1','id')->where('id', $id)->get();
		return $page;
	}
	
	public function getMetaVal($id)
	{
		$page = DB::table('tbl_cms_content')->select('meta')->where('id', $id)->get();
		return $page;
	}
	public function getMetaTitleVal($id)
	{
		$page = DB::table('tbl_cms_content')->select('meta_title')->where('id', $id)->get();
		return $page;
	}

	public function getPageType($id)     
	{
		$page = DB::table('tbl_cms_content')->select('page_type')->where('id', $id)->get();
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