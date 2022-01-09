<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\CoachAssignmentsReports;
use DataTables;

class CoachAssignmentsReportsController extends Controller
{
    public function __construct()
    {  
        $this->reportsObj = new CoachAssignmentsReports();
                      
    }

    public function coachAssignmentsReportView(Request $request)
    {
        if ($request->session()->has('coachAssignmentsReportData')) {
            return view('Admin.coachAssignmentsReport');
        } else {
            return \Redirect::to('admin/reports');
        }
    }

    public function coachAssignmentsReport(Request $request)
    {
        if ($request->isMethod('post')) {
            $coachAssignmentsReportData['states'] = $request->input('states');
            $coachAssignmentsReportData['cities'] = $request->input('cities');
            $coachAssignmentsReportData['locations'] = $request->input('locations');
            $coachAssignmentsReportData['camps'] = $request->input('camps');
            // $coachAssignmentsReportData['coachers'] = $request->input('coachers');
            $coachAssignmentsReportData['directors'] = $request->input('directors');
			$request->session()->put('coachAssignmentsReportData', $coachAssignmentsReportData);
            return \Redirect::to('admin/coachAssignmentsReportView');
        }
    }

    public function coachAssignmentsReportTable(Request $request) 
    {       
        if ($request->isMethod('post')) {
            $coachAssignmentsReportData = $request->session()->get('coachAssignmentsReportData');
            $coachAssignments = $this->reportsObj->getCoachAssignmentsreport($coachAssignmentsReportData);
            return DataTables::of($coachAssignments)
                ->addColumn('full_name', function($coachAssignments){
                    return $coachAssignments->first_name.' '.$coachAssignments->last_name;
                })->rawColumns(['full_name'])
            ->make(true);           
        }
    }

}

?>