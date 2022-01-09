<?php

namespace App\Http\Controllers\Site;

use Illuminate\Support\Facades\Auth;
use App\Models\Site\SliderCaption;
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
use App\Models\Admin\ManageLocations;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Image;
use DB;



class PagesController extends Controller
{

    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 
	public function __construct()
    {
       $this->loc = new Locations(); 
       $this->manageLoc = new ManageLocations(); 
    }
	
    /**
     * Show the application Homepage.
     *
     * @return homepage 
     */
    public function getPage($slug)
	{
		$data['title'] = "Locations";
		//$preg_match = preg_match('!\d+!', $slug, $matches);
		//$locId = $matches[0];
		$data['locationRes'] = $this->loc->getLocationCampsByTitle(trim($slug));
		$data['locationInfo'] = $this->loc->getLocationByTitle(trim($slug));
		return view('Site/slug', $data);
	}
	

}
