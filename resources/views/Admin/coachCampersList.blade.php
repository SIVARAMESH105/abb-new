@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Camper List</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url('admin/viewCoachRosters/'.Auth::user()->id.'/'.Auth::user()->user_type) }}">View Rosters</a></li>
	    <li class="active">Camper List</li>
	  </ol>
	</section>
@endsection

@section('content')
<!-- Default box -->
<div>
	<table border="1" width="100%">
		<tr>
			<td>{{$campers['camps'][0]->camp_focus}}</td>
			<td>{{$campers['camps'][0]->startdate.' '.$campers['camps'][0]->enddate}}</td>
		</tr>
		<tr>
			<td>{{$campers['camps'][0]->Location}}</td>
			<td>Start Time: {{$campers['camps'][0]->starttime}}</td>
		</tr>
		<tr>
			<td>{{$campers['camps'][0]->City.' '.$campers['camps'][0]->stateName.' '.$campers['camps'][0]->Zip}}</td>
			<td>End Time: {{$campers['camps'][0]->endtime}}</td>
		</tr>
	</table>
</div>
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
		<div class="box">
			<div class="box-body table-responsive">
				<table id="crudTable" class="table table-bordered table-striped display">
					<thead>
						<tr>
							<th>Roster Name</th>
							<th>Gender</th>
							<th>DOB</th>
							<th>City</th>
							<th>Grade</th>
							<th>Skill Level</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($campers['rosters'] as $camper)
							<tr>
								<td>{{$camper->name}}</td>
								<td>{{$camper->gender}}</td>
								<td>{{$camper->dob}}</td>
								<td>{{$camper->city}}</td>
								<td>{{$camper->grade}}</td>
								<td>{{$camper->basketball_skill}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<a href="{{url('admin/coachRostersPdf/'.$campId)}}" target="_blank" style="float:right;"><img src="{{asset('public/images/pdf.jpeg')}}" width="22" height="22" border="0"></a>
			</div>
		</div>
	</div>
</div>
@endsection

@section('after_styles')
  <!-- DATA TABLES -->
  <link href="{{ asset('public/vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ asset('public/vendor/backpack/crud/css/crud.css') }}">
  <link rel="stylesheet" href="{{ asset('public/vendor/backpack/crud/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('public/vendor/backpack/crud/css/list.css') }}">

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
@endsection

@section('after_scripts')
  	<!-- DATA TABLES SCRIPT -->
    <script src="{{ asset('public/vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('public/vendor/backpack/crud/js/form.js') }}"></script>
    <script src="{{ asset('public/vendor/backpack/crud/js/list.js') }}"></script>

    <script src="{{ asset('public/vendor/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
	  jQuery(document).ready(function($) {
		var table = $("#crudTable").DataTable({
			"pageLength": '25',
			/* Disable initial sort */
			"aaSorting": [],
			"language": {
				  "emptyTable":     "{{ trans('backpack::crud.emptyTable') }}",
				  "info":           "{{ trans('backpack::crud.info') }}",
				  "infoEmpty":      "{{ trans('backpack::crud.infoEmpty') }}",
				  "infoFiltered":   "{{ trans('backpack::crud.infoFiltered') }}",
				  "infoPostFix":    "{{ trans('backpack::crud.infoPostFix') }}",
				  "thousands":      "{{ trans('backpack::crud.thousands') }}",
				  "lengthMenu":     "{{ trans('backpack::crud.lengthMenu') }}",
				  "loadingRecords": "{{ trans('backpack::crud.loadingRecords') }}",
				  "processing":     "{{ trans('backpack::crud.processing') }}",
				  "search":         "{{ trans('backpack::crud.search') }}",
				  "zeroRecords":    "{{ trans('backpack::crud.zeroRecords') }}",
				  "paginate": {
					  "first":      "{{ trans('backpack::crud.paginate.first') }}",
					  "last":       "{{ trans('backpack::crud.paginate.last') }}",
					  "next":       "{{ trans('backpack::crud.paginate.next') }}",
					  "previous":   "{{ trans('backpack::crud.paginate.previous') }}"
				  },
				  "aria": {
					  "sortAscending":  "{{ trans('backpack::crud.aria.sortAscending') }}",
					  "sortDescending": "{{ trans('backpack::crud.aria.sortDescending') }}"
				  }
			  }
		  });
	  });
	</script>
  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection