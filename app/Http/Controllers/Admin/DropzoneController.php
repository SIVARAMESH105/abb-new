<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Auth;
use App\Models\Admin\VideoGallery;
use App\Models\Admin\ImageGallery;
use Image;
use FileImage;

class DropzoneController extends Controller
{
	public function __construct()
    {   
        $this->imageModel = new ImageGallery();
        $this->videoModel = new VideoGallery();
    }
	
    public function dropzoneUpload(Request $request) {
		$data['imageName']='';
        if($request->has('file')) {
            try{

                $imageName = Auth::id().'_'.$request->file('file')->getClientOriginalName();
                $destinationPath = public_path('/uploads/tempfeatureimages/');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $request->file('file')->move( $destinationPath, $imageName );
                $data['imageName'] = $imageName;
				//store image gallary
				$image = $request->file('file');
				$filename    = $image->getClientOriginalName();
				$extensionName = $image->getClientOriginalExtension(); 
				$encryptedName = md5($filename. microtime()).'.'.$extensionName;
				$imagePath =  $destinationPath.$imageName;
				$extensions = array("jpeg","jpg","png","gif","bmp","tiff","tif");
				if(in_array($extensionName,$extensions)) {
					$image_resize = Image::make($imagePath);             
					$image_resize->save(public_path('/uploads/images/gallery-photos/' .$encryptedName));
					$image_resize->resize(150, 150);
					$image_resize->save(public_path('/uploads/images/gallery-photos/thumb/' .$encryptedName));
					$realname=Auth::user()->name;
					$email=Auth::user()->email;
					$phone=Auth::user()->home_phone;
					$caption="Dummy Caption";
					$insertArray = array("realname"=>$realname, "email" =>$email, "phone"=>$phone, "caption"=>$caption);
					$imageStore = $this->imageModel->imageGallaryStore($insertArray, $encryptedName);
				} else {
					//$diskVideoStore=$this->videoModel->setVideoAttribute($encryptedName);
					//store video gallary
					$videoDestinationPath = public_path("/uploads/videos/");
					if (!file_exists($videoDestinationPath)) {
						mkdir($videoDestinationPath, 0777, true);
					}
					copy($destinationPath.$imageName,$videoDestinationPath.$encryptedName);
					$title = $this->generateRandomString();
					$videoInsertArray = array("title"=>$title, "video"=>$encryptedName);
					$videoStore = $this->videoModel->videoGallaryStore($videoInsertArray);
				}
	    	}
	    	catch(\Exception $e) {
	    		
	    	}
            return $data;
        }
    }
	
	private function generateRandomString($length = 10) {
		$characters = 'advantagebasketball';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}