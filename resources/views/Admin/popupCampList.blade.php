@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Camp List</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">Camp List</li>
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
							<th></th>
							<th>Camp Name</th>
							<th>Location</th>
							<th>City</th>
							<th>State</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($campList as $camp)
							<tr>
								<td><input type="radio" value="{{$camp->id.','.$camp->camp_focus.','.$camp->cost.','.$camp->location.','.$camp->Address.','.$camp->City.','.$camp->State.','.$camp->Zip.','.$camp->startdate.','.$camp->enddate}}" onclick="post_value(this.value);"></td>
								<td>{{$camp->camp_focus}}</td>
								<td>{{$camp->location}}</td>
								<td>{{$camp->City}}</td>
								<td>{{$camp->State}}</td>
								<td>{{$camp->startdate}}</td>
								<td>{{$camp->enddate}}</td>
								<td>{{$camp->starttime}}</td>
								<td>{{$camp->endtime}}</td>
								<td>{{$camp->status}}</td>
							</tr>
						@endforeach
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
	  function post_value(val){
		var campDetails = val.split(",");
		window.opener.document.createOrder.new_camp_id.value = campDetails[0];
		window.opener.document.createOrder.camp_name.value = campDetails[1];
		window.opener.document.createOrder.camp_location.value = campDetails[3];
		window.opener.document.createOrder.camp_city.value = campDetails[5];
		window.opener.document.createOrder.camp_state.value = campDetails[6];
		window.opener.document.createOrder.camp_zip.value = campDetails[7];
		window.opener.document.createOrder.camp_sdate.value = campDetails[8];
		window.opener.document.createOrder.camp_edate.value = campDetails[9];
		window.close();
	}
	</script>
  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection