<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\RosterReports;
use DataTables;

class RosterReportsController extends Controller
{
    public function __construct()
    {  
        $this->reportsObj = new RosterReports();
                      
    }

    public function rosterReportView(Request $request)
    {
        if ($request->session()->has('rosterReportData')) {
            return view('Admin.rosterReport');
        } else {
            return \Redirect::to('admin/reports');
        }
    }

    public function rosterReport(Request $request)
    {
        if ($request->isMethod('post')) {
            $rosterReportData['states'] = $request->input('states');
            $rosterReportData['cities'] = $request->input('cities');
            $rosterReportData['locations'] = $request->input('locations');
            $rosterReportData['coachers'] = $request->input('coachers');
            $request->session()->put('rosterReportData', $rosterReportData);
            return \Redirect::to('admin/rosterReportView');
        }
    }

    public function rosterReportTable(Request $request) 
    {       
        if ($request->isMethod('post')) {
            $rosterReportData = $request->session()->get('rosterReportData');
            $rosters = $this->reportsObj->getRostersreport($rosterReportData);
            return DataTables::of($rosters)
                ->addColumn('full_name', function($rosters){
                    return $rosters->first_name.' '.$rosters->last_name;
                })->addColumn('camp_focus', function($rosters){
                    $pdfIconSrc = asset('public/images/pdf.jpeg');
                    return '<a href="camperRevenue/'.$rosters->id.'" target="_blank">'.$rosters->camp_focus.'</a>';
                })->editColumn("camprevenue", function($rosters){
					return "$ ".$rosters->camprevenue;
				})->rawColumns(['full_name', 'camp_focus'])
            ->make(true);           
        }
    }

    public function camperRevenue(Request $request)
    {
        if (!empty($request['camp_id'])) {
            $data['camp_id'] = $request['camp_id'];
            return view('Admin.camperRevenue', $data);
        } else {
            return \Redirect::back();
        }
    }

    public function getCamperRevenueList(Request $request) 
    {
        $camp_id = $request['camp_id'];
        $getCamperRevenue = $this->reportsObj->getCamperRevenue($camp_id);
        return DataTables::of($getCamperRevenue)->make(true); 
    }
}

?>