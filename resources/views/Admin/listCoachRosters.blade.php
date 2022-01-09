@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Camp Details for @if(isset($rosters[0]->coach_name)) {{$rosters[0]->coach_name}} @endif</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">View Rosters</li>
	  </ol>
	</section>
@endsection

@section('content')
<!-- Default box -->
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
		<div class="box">
			<div class="box-body table-responsive">
				<table id="crudTable" class="table table-bordered table-striped display">
					<thead>
						<tr>
							<th>Camp Name</th>
							<th>Location</th>
							<th>City</th>
							<th>State</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>PDF</th>
						</tr>
					</thead>
					<tbody>
						@if(!empty($rosters))
							@foreach ($rosters as $roster)
								<tr>
									<td><a href="{{url('admin/coachCampersList/'.$roster->id)}}">{{$roster->camp_focus}}</a></td>
									<td>{{$roster->location}}</td>
									<td>{{$roster->city}}</td>
									<td>{{$roster->state}}</td>
									<td>{{$roster->startdate}}</td>
									<td>{{$roster->enddate}}</td>
									<td>{{$roster->starttime}}</td>
									<td>{{$roster->endtime}}</td>
									<td><a href="{{url('admin/coachRostersPdf/'.$roster->id)}}" target="_blank"><img src="{{asset('public/images/pdf.jpeg')}}" width="22" height="22" border="0"></a></td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
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
			"paging": 25,
			"autoWidth": true,
			columns: [
		            { data: 'Camp Name', name: 'Camp Name' },
		            { data: 'Location', name: 'Location' },
		            { data: 'City', name: 'City' },
		            { data: 'State', name: 'State' },
		            { data: 'Start Date', name: 'Start Date' },
		            { data: 'End Date', name: 'End Date' },
		            { data: 'Start Time', name: 'Start Time' },
		            { data: 'End Time', name: 'End Time' },
		            { data: 'PDF', name: 'PDF' },
		        ],
		  });
	  });
	</script>
  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection