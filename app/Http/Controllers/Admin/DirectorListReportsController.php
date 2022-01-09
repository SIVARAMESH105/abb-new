<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\DirectorListReports;
use DataTables;

class DirectorListReportsController extends Controller
{
    
	public function index()
    {
		$this->directorObj = new DirectorListReports();
		$DirectorList = $this->directorObj->getDirectorList();
        return Datatables::of($DirectorList)->make(true);
    }

	public function directorReportView()
	{
		return view('Admin.directorReport');
		
	}

}

?>