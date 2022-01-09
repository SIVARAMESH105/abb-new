@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Track WebShipments</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">Track WebShipments</li>
	  </ol>
	</section>
@endsection
<?php //echo 'ds';die; ?>
@section('content')
<!-- Default box -->

<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
				<div id="datatable_button_stack" class="pull-right text-right">	
				</div>
			</div>
			{!! csrf_field() !!}
	  		<input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
			<div class="box-body table-responsive">
				<table id="webShipmentsTable" class="table table-bordered table-striped display">
					<thead>
						<tr>
							<th>Tracking Number</th>
							<th>Product Image</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Status Of The Shipment</th>
						</tr>
					</thead>					
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
$(document).ready(function() {
	var base_url = $('#base_url').val(); 
	var token = $('input[name="_token"]').val();
	$('#webShipmentsTable').DataTable({
        processing: true,
		language: {
			 processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>"
		},
        serverSide: false,
		ajax: {
            "url": base_url+"/admin/getTrackWebShipmentList",
			headers: {'X-CSRF-TOKEN': token},
            "type": "POST"
        },
        columns: [
            { data: 'tracking_number', name: 'tracking_number', sortable:true },
			{ data: 'pd_thumbnail', name: 'pd_thumbnail', sortable:false},
            { data: 'pd_name', name: 'pd_name' },
			{ data: 'od_qty', name: 'od_qty' },
			{ data: 'status_of_shipment', name: 'status_of_shipment' } 
        ]
    });
});
</script>
  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection