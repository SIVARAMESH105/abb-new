<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\RevenueReports;
use DataTables;

class RevenueReportsController extends Controller
{
  
    public function __construct()
    {  
        $this->revenueReportsObj = new RevenueReports();                     
    }

    public function revenueReportView(Request $request)
    {
        if ($request->session()->has('revenueReportData')) {
            $revenueReportData = $request->session()->get('revenueReportData');
            $data['optionsDisplay']= $revenueReportData['options_display'];
            return view('Admin.revenueReport',$data);
        } else {
            return \Redirect::to('admin/reports');
        }
    }

    public function revenueReports(Request $request) 
    {
        if ($request->isMethod('post')) {
            $revenueReportData['startdate'] = $request->input('startdate');
            $revenueReportData['enddate'] = $request->input('enddate');
            $revenueReportData['states'] = $request->input('states');
            $revenueReportData['cities'] = $request->input('cities');
            $revenueReportData['locations'] = $request->input('locations');
            $revenueReportData['coachers'] = $request->input('coachers');
            $revenueReportData['directors'] = $request->input('directors'); 
            $revenueReportData['camps'] = $request->input('camps'); 
            $revenueReportData['options_display'] = $request->input('options_display');   
            $request->session()->put('revenueReportData', $revenueReportData);
            return \Redirect::to('admin/revenueReportView');
        }
    }

    /*
        * This function is used to get the result of revenue report
        * @param array $data 
        * return result of array
        * @param :option_display: 1->All camper details, camp total, grand totals,2->Camp totals, grand totals,3-> grand totals
    */

    public function revenueReportTable(Request $request) 
    {       
        if ($request->isMethod('post')) {
            $revenueReportData = $request->session()->get('revenueReportData');
            $revenue = $this->revenueReportsObj->getRevenueReport($revenueReportData);
            if($revenueReportData['options_display'] ==1) {
                 return DataTables::of($revenue)
                ->addColumn('full_name', function($revenue){
                    return $revenue->first_name.' '.$revenue->last_name;
                })->addColumn('camp_focus', function($revenue){
                    $pdfIconSrc = asset('public/images/pdf.jpeg');
                    return '<a href="camperRevenue/'.$revenue->id.'" target="_blank">'.$revenue->camp_focus.'</a>';
                })->editColumn("camp_revenue", function($revenue){
                    return "$ ".$revenue->camp_revenue;
                })->rawColumns(['full_name', 'camp_focus'])
            ->make(true);   

            } else if(($revenueReportData['options_display'] == 2)) {

                return DataTables::of($revenue)->editColumn("camp_revenue", function($revenue){
    				return "$ ".$revenue['camp_revenue'];
    			})->editColumn("product_revenue", function($revenue){
    				return "$ ".$revenue['product_revenue'];
    			})->editColumn("total_revenue", function($revenue){
    				return "$ ".$revenue['total_revenue'];
    			})->make(true);
            } else {
                return DataTables::of($revenue)->editColumn("total_revenue", function($revenue){
                    return "$ ".$revenue['total_revenue'];
                })->make(true);
            }           
        }
    }
	
	/*
		* This function is used to report generate for coach revenue
		* @param array $request 
		* return view file
	*/
	public function coachRevenueReport(Request $request) {
	
		 if ($request->isMethod('post')) {
			$inputData = $request->all();
			$data['campdatas'] = $this->revenueReportsObj->getCoachRevenuereport($inputData);
			return view('Admin.coachRevenueReport', $data);
			
		 }
	
	}
}

?>