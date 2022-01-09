<?php

namespace App\Http\Controllers\Site;

use Illuminate\Support\Facades\Auth;
use App\Jobs\SendImageUploads;
use App\Models\Site\CountrySite;
use App\Models\Site\States;
use App\Models\Site\Camps;
use App\Models\Site\Roster;
use App\Models\Site\Users;
use App\Models\Site\Campcart;
use App\Models\Site\Cmsfornt;
use App\Models\Site\Home;
use App\Models\Site\Staff;
use App\Models\Site\Videos;
use App\Models\Site\Images;
use App\Models\Site\Store;
use App\Models\Site\Locations;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendForgotPasswordEmail;
use App\Jobs\Send404Email;
use App\Jobs\ContactUsEmail;
use App\Jobs\EmployeeApplyEmail;
use App\Http\Requests\ContactUsRequest;
use App\Http\Requests\EmployeeApplyRequest;
use Carbon\Carbon;
use Image;
use App\Http\Requests\ImageGalleryRequest as ImageGalleryRequest;
use DB;

session_start();

class HomeController extends Controller
{

    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 
	public function __construct()
    {
        //$this->middleware('auth');
    }
	
    /**
     * Show the application Homepage.
     *
     * @return homepage 
     */
    public function homePage(){	
        
        if(!empty($_SESSION['cur_user_id'])) {
            $userObj = new Users();
            $data['user_name'] = $userObj->getUser($_SESSION['cur_user_id']);  
            return view('Site/homepage', $data);               
        } else {
            return view('Site/homepage');    
        }
    }
	/**
     * Show the application Homepage.
     *
     * @return homepage 
     */
    public function page($pageName){
		
		$cmsObj = new Cmsfornt();
		$data['pageContent'] = $cmsObj->getPageDetails($pageName);        
        $data['hearabout']= array('Refer from a friend'=>'Refer from a friend','Search engines'=>'Search engines','Link from another website'=>'Link from another website','Magazine article'=>'Magazine article','Newspaper'=>'Newspaper','Other'=>'Other');
		switch($pageName) {
			case 'staff':
				$staffObj = new Staff();
				$data['staffBioInfo'] = $staffObj->getStaffDetails();
				return view('Site/staff', $data);
				break;
			case 'login':
				return view('Site/login');
				break;
			case 'forgotPassword':
				return view('Site/forgot_password');
				break;
			case 'videos':
				$vidoesObj = new Videos();
				$data['videos'] = $vidoesObj->getVideos();
				return view('Site/videos', $data);
				break;
            case 'photos':
                $imagesObj = new Images();
                $data['images'] = $imagesObj->getImages();
                return view('Site/images', $data);
                break;
			case 'store':
				$storeObj = new Store();
				$data['storeInfo'] = $storeObj->getStoreDetails();
				return view('Site/store', $data);
				break;				
			case 'one-on-one':
				if(!empty($_SESSION['cur_user_id'])){
				$userObj = new Users();
				$data['user_details'] = $userObj->getUser($_SESSION['cur_user_id']);
				}else{
				$_SESSION['cur_user_id'] = '';
				$data['user_details'] = array();
				}
				return view('Site/one-on-one', $data);
				break;
			case 'schedule':
				$cid = '';
				$statesObj = new States();
				//$data['state_details'] = $statesObj->getStateDetails($cid);
				$data['state_details'] = $statesObj->getActiveStateCamp();
				$countryObj = new CountrySite();
				$data['country_details'] = $countryObj->getCountryDetails($cid);
				$campsObj = new Camps();
				$data['camp_details'] = $campsObj->getCampDetails($cid);
			    $data['camp_startdate'] = $campsObj->getCampsStartDate();
				return view('Site/schedule',$data);
				break;
			default:
                if (count($data['pageContent']) == 0) {
                    $pageName = "404";
                    $data['pageContent'] = $cmsObj->getPageDetails($pageName);
                }
				return view('Site/'.$data['pageContent'][0]->page_type, $data);
		}
    }
	public function registerPage($cid){
		$countryObj = new CountrySite();
		$sid = '';
		$data['country_details'] = $countryObj->countryList($sid);
		$data['camp_id'] = $cid;
		$campsObj = new Camps();
		$data['camp_details'] = $campsObj->getRegisterCampDetails($cid,'registerpage');
		
		if(!empty($_SESSION['cur_user_id'])){
			$userObj = new Users();
			$data['user_details'] = $userObj->getUser($_SESSION['cur_user_id']);
		}else{
			$_SESSION['cur_user_id'] = '';
			$data['user_details'] = array();
		}
		//echo '<pre>'; print_r($data['user_details']);die;
		if($data['camp_details'][0]->Country == 1){
			$data['countrysele']= 'US';
		}else{
			$data['countrysele']= 'AUS';
		}
		$data['month_values']= array('1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December');
		$data['hearabout']= array('Refer from a friend'=>'Refer from a friend','Search engines'=>'Search engines','Link from another website'=>'Link from another website','Magazine article'=>'Magazine article','Newspaper'=>'Newspaper','Other'=>'Other');
		return view('Site/registerform',$data);
	}
	 
	public function countrySort($cid){
		$cmsObj = new Cmsfornt();
		$data['pageContent'] = $cmsObj->getPageDetails('schedule');
        $statesObj = new States();
		$data['state_details'] = $statesObj->getStateDetails($cid);
		$countryObj = new CountrySite();
		$data['country_details'] = $countryObj->getCountryDetails($cid);
		$campsObj = new Camps();
		$data['camp_details'] = $campsObj->getCampDetails($cid);
		return view('Site/schedule',$data);
	}
	
	public function registerStateSort($sid,$cid){
		$campsObj = new Camps();
		$data['camp_details'] = $campsObj->getStateCampDetails($sid);
		$cmsObj = new Cmsfornt();
		$data['pageContent'] = $cmsObj->getPageDetails('schedule');
        $statesObj = new States();
		$data['state_details'] = $statesObj->getStateDetails($cid);
		$countryObj = new CountrySite();
		$data['country_details'] = $countryObj->getCountryDetails($cid);
		return view('Site/schedule',$data);
	}
	
	public function sortMonth($mid,$cid){
		$campsObj = new Camps();
		$data['camp_details'] = $campsObj->getsortMonth($mid,$cid);
		$cmsObj = new Cmsfornt();
		$data['pageContent'] = $cmsObj->getPageDetails('schedule');
        $statesObj = new States();
		$data['state_details'] = $statesObj->getStateDetails($cid);
		$countryObj = new CountrySite();
		$data['country_details'] = $countryObj->getCountryDetails($cid);
		return view('Site/schedule',$data);
	}
	
	public function submitContact(ContactUsRequest $request) {
		// $homeObj = new Home();
		// $contact = $homeObj->contact($_POST);
		//print_r($request->all());die;
		$job = (new ContactUsEmail($request->all()))
					->delay(Carbon::now()->addSeconds(5));
		dispatch($job);

		return redirect('Contact_thanks');
	}
	
	public function registerSave(Request $request){
		if(!isset($_SESSION['camps'])) {
		$_SESSION['camps'] = array();
		}
		$existCampId = false;
		foreach ($_SESSION['camps'] as $campIds){
			if (isset($campIds['camp_id']) && $campIds['camp_id'] == $request->input('camp_id')){
				$existCampId = true;
				break;
			}
		}
		if(!$existCampId){
			if($_SESSION['cur_user_id'] == ''){
				$register_users = new Users();
				$user_id = $register_users->saveRegisterUser($request->all());
			}else{
				$user_id = $_SESSION['cur_user_id'];
			}
			$register = new Roster();
			$roster_id = $register->saveRoster($request->all(),$user_id);
			$campcart = new Campcart();
			$camp_cart_id = $campcart->saveCampcart($request->all(),$roster_id);
			$_SESSION['roster_id'][]['id'] = $roster_id;
			$_SESSION['user_id'] = $user_id;
			$_SESSION['camps'][]['camp_id'] = $request->input('camp_id');
			if($camp_cart_id != ''){ 
				$rosterObj = new Roster();
				$last_amount = $rosterObj->getRegisterCampDetails($roster_id);
				foreach($_SESSION['camps'] as $campId){
					$campsObj = new Camps();
					$campDetails[] = $campsObj->getRegisterCampDetails($campId['camp_id'],'saveregister'); 
					$campDetails[count($campDetails)-1]->total_amount = $last_amount->amount_paid;
					$campDetails[count($campDetails)-1]->student_name =$request->input('first_name');
				}
				$_SESSION['camp_cart_id'] = $camp_cart_id;
				$_SESSION['camp_details'] = $campDetails;
					return redirect('cart/cartPage');
			}else{
				$_SESSION['camp_cart_id'] = '';
				$_SESSION['camp_details'] = array();
				return redirect('cart/cartPage');
			}
		}else{
		return redirect('camp/register/'.$request->input('camp_id'))->with('error', 'Already this camp registerd.')->withInput();
		}
	}
	
	/* public function loginUser(Request $request){ 
		$userObj = new Users();
		$user_details = $userObj->getUserDetails($request->all());
		if ($user_details == 'out') {
			return redirect ('login')->with(array('error'=>'Password does not match'));
		}else if ($user_details == 'no_user') {
			return redirect ('login')->with(array('error'=>'Sorry user not avaliable'));
		}
		else {
			$user = Auth::user();
			$id = Auth::id();
			$_SESSION['cur_user_id'] = $user_details->id;
			return redirect ('')->with(array('status'=>'Login Successfully'));
		}
	} */
	
	public function forgotPassword(Request $request){
		$userObj = new Users();
		$user_details = $userObj->getUsername($request->input('email'));
		$job = (new SendForgotPasswordEmail($request->all(),$user_details->name))
					->delay(Carbon::now()->addSeconds(5));
		dispatch($job);
		return redirect ('forgotPassword')->with(array('status'=>'Email Sent Successfully'));
	}
	
	public function resetPwd($email){
		$userObj = new Users();
		$data['user_details'] = $userObj->getUserInfo(base64_decode($email));
		return view('Site/reset_password',$data);
	}
	
	public function updatePassword(Request $request){ 
		$userObj = new Users();
		$user_details = $userObj->updateUserPassword($request->all());
		return redirect ('')->with(array('status'=>'Password successfully changed'));
	}

    public function uploadPhotos(ImageGalleryRequest $request)
    {   
        $image       = $request->file('basketimages');
        $filename    = $image->getClientOriginalName();
        $extensionName = $image->getClientOriginalExtension();
        $encryptedName = md5($filename. microtime()).'.'.$extensionName;
        $image_resize = Image::make($image->getRealPath());              
        $image_resize->save(public_path('/uploads/images/gallery-photos/' .$encryptedName));
        $image_resize->resize(150, 150);
        $image_resize->save(public_path('/uploads/images/gallery-photos/thumb/' .$encryptedName));
        $userObj = new Users();
        $user_details = $userObj->uploadPhotos($request->all(), $encryptedName);     
        if($user_details) {
           dispatch(new SendImageUploads($request->all()));
        }
        return back()->with('success','Image Uploaded successfully');

    }

    /*404 email sending method*/
    public function page404(Request $request){
		
		$job = (new Send404Email($request->all()))
					->delay(Carbon::now()->addSeconds(5));
		dispatch($job);
		return redirect('404_thanks');
	}

	/* Employee Applied Action */
	public function empApply(EmployeeApplyRequest $request){

		$job = (new EmployeeApplyEmail($request->all()))
					->delay(Carbon::now()->addSeconds(5));
		dispatch($job);
		return redirect('Employ_thanks');

	}

	/*Shedule Ajax method*/
	public function ajaxGetCity(){
		//echo "ashdg";die;
		$state_id = (!empty($_GET['stateId'])) ? $_GET['stateId'] :'';
		$locationObj = new Locations();
		$city_details = $locationObj->getCityDetails($state_id);

		$data = json_encode($city_details);
		
		return $data;

	}

	/* Month List*/
	public function ajaxMonthList(){
		$data['state_id'] = $_GET['stateId'];
		$data['city_id']  = $_GET['cityId'];

		$campsObj = new Camps();
		$month_details = $campsObj->getMonth($data);

		$months = json_encode($month_details);

		return $months;

	}

	/* Camp by location */
	public function ajaxGetCamps(){
		$data['state_id'] = $_GET['stateId'];
		$data['city_id']  = $_GET['cityId'];
		$data['month']  = $_GET['month']; 
	
		$dbstarttime= 'tbl_camp.starttime';
        $data['date']= $_GET['month'];
        $campsObj = new Camps();
		$camp_details = $campsObj->campDetails($data);
       
        $camps = json_encode($camp_details);

        return $camps;
	}
	
	/*single camp detail page*/
	public function campDetail(Request $request){
		$campId     = $request->id;
		$LocationId = $request->locationId;

		$camp_details = DB::table("tbl_camp")
		    ->join("tbllocation", "tbllocation.Id", "=", "tbl_camp.LocationId")
            ->join("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State")
            ->select("tbl_camp.*",DB::raw("DATE_FORMAT(tbl_camp.startdate, '%M %d, %Y') as startCamp"),DB::raw("DATE_FORMAT(tbl_camp.enddate, '%M %d, %Y') as endCamp"), "tbllocation.*", "tbl_state_codes.state_id", "tbl_state_codes.state_name")
			->where([
			    ["tbl_camp.id", "=", $campId],
			    ["tbl_camp.LocationId", "=", $LocationId],
			])
            ->first();

          return view('Site/camp',compact('camp_details'));
	}
}
