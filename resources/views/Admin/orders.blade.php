@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Registrations & Orders</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">Registrations & Orders</li>
	  </ol>
	</section>
	@if (session('status'))          
		<div class="alert alert-success" style="width:260px; float:right">  
			{{ session('status') }}
		</div>
	@endif
@endsection

@section('content')
<!-- Default box -->
<div class="orderSearch">
	<form class="form-inline verticalSpace" action="{{url('admin/searchOrdersWithLastname')}}" method="POST">
		{!! csrf_field() !!}
		<div class="form-group">
		    <label for="exampleInputName2">Parent Lastname</label>
		    <input type="text" class="form-control" name="parentLastname" id="parentLastName" value="@if(isset($parentLastname)) {{$parentLastname}} @endif">
		</div>

		<div class="form-group">
		    <label for="exampleInputName2">Child Lastname</label>
		    <input type="text" class="form-control" name="childLastname" id="childLastName" value="@if(isset($childLastname)) {{$childLastname}} @endif">
		</div>
		<div class="form-group">
			<input type="submit" name="go" value="Go" class="btn btn-default">
			<input type="button" name="showAll" class="btn btn-default" value="Show all" onclick="loadAllOrders()">
		</div>
	</form>
</div>
<br>
<div class="box-header with-border">
	<a href="{{url('admin/orders/create')}}" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Create New Order</span></a>					
	<div id="datatable_button_stack" class="pull-right text-right"></div>
</div>
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
		<div class="box">
			<div class="box-body table-responsive">
				<table id="crudTable" class="table table-bordered table-striped display">
					<thead>
						<tr>
							<th>Order #</th>
							<th>Customer Name</th>
							<th>Order Time</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($orders as $order)
							<tr>
								<td><a href="{{url('admin/viewOrder/'.$order->od_id)}}">{{$order->od_id}}</a></td>
								<td>{{$order->od_payment_first_name.' '.$order->od_payment_last_name}}</td>
								<td>{{$order->od_date}}</td>
								<td>{{$order->od_status}}</td>
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
		setTimeout(function(){ $('.alert-success').hide(); }, 3000);

	  });
	  function loadAllOrders()
	  {
		window.location = "{{ url('admin/orders') }}";
	  }
	</script>
  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection