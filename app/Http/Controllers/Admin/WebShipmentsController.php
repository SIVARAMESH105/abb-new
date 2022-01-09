<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\WebShipments;
use DataTables;



class WebShipmentsController extends Controller
{
    public function __construct()
	{
		$this->webShipmentsObj = new WebShipments();
    }
	/**
     * Show the affiliate Register.
     *
     * @return redirect to page 
     */
	public function trackWebShipment()
	{
		return view('Admin.track_webshipments_lists');
	}
	
	/**
     * Show the affiliate List.
     *
     * @return obeject 
     */
	public function getTrackWebShipmentList(Request $request)
    {
        $trackWebShipmentList = $this->webShipmentsObj->getTrackWebShipmentList();
        return DataTables::of($trackWebShipmentList)
            ->editColumn('pd_thumbnail', function ($details){
                $imageUrl = url('public/uploads/images/products/thumbnail/'.$details->pd_thumbnail);
                return '<img src="'. $imageUrl .'" alt="No Image" width="70" height="70"/>';
            })->addColumn('status_of_shipment', function ($details) {
                if(!empty($details->tracking_number)) {
                    return 'Booked';
                } else {
                    return 'Not Booked Yet';
                }
            })->rawColumns(['pd_thumbnail', 'status_of_shipment'])->make(true);
    }
}
