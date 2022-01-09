<?php

namespace App\Http\Controllers\Admin;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ImageGallery;
use App\Models\Admin\User;
use Illuminate\Http\Request;

// VALIDATION: change the requests to match your own file names if you need form validation
#use App\Http\Requests\ManageImagesRequest as StoreRequest;
#use App\Http\Requests\ManageImagesRequest as UpdateRequest;
#use Auth;
use DataTables;

class ImageGalleryCrudController extends CrudController
{
    
    public function __construct()
    {   
        $this->imageModel = new ImageGallery();
    }
        
    public function imagesList(){
        return view('Admin.images_list');
    }
    
    public function getImagesList(Request $request){
        $imageDetails = $this->imageModel->getImageList();

        return DataTables::of($imageDetails)
            ->addColumn('image', function($imageDetails){
                return '<img src="'.asset('public/uploads/images/gallery-photos/thumb/'.$imageDetails->image).'" alt="dummy-user" width="100px" height="100px">';
            })->addColumn('status', function($imageDetails){
                $status = '';
                if ($imageDetails->status == 1) {
                    $status = 'checked';
                }
                return '<input type="checkbox"  title="Click to set Active/Inactive"  id="imagestatus'.$imageDetails->id.'" '.$status.' onclick="imageStatus('.$imageDetails->id.')"/>';
            })->rawColumns(['image', 'status'])   
           ->make(true);
    }
    
    public function imageStatus($id, $imagestatus){
        $this->imageModel->imageStatus($id, $imagestatus);
    }
	
	
	
    
}
