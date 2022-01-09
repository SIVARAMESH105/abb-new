@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  	<h1>
		    <span class="text-capitalize">Director Report</span>
	  	</h1>
	  	<ol class="breadcrumb">
		    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
		    <li class="active">Director Report</li>
	  	</ol>
	</section>
@endsection
@section('content')
	<!-- Default box -->
	<div class="row">
	    <!-- THE ACTUAL CONTENT -->
	    <div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<a href="{{url('/admin/reports')}}" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="ionicons ion-arrow-left-a">  </i> Back To Reports</span></a>
					<div id="datatable_button_stack" class="pull-right text-right">
					</div>
				</div>
				{!! csrf_field() !!}
			  	<input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
				<div class="box-body table-responsive">
					<table id="directorReportTable" class="table table-bordered table-striped display">
						<thead>
							<tr>
								<th>Name</th>
								<th>Address</th>
								<th>City</th>
								<th>Phone</th>
								<th>E-mail</th>
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
    <script src={{ asset('public/packages/datatableexporttools/dataTables.buttons.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/buttons.bootstrap.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/jszip.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/pdfmake.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/vfs_fonts.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/buttons.html5.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/buttons.print.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/buttons.colVis.min.js') }} type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var base_url = $('#base_url').val(); 
			var token = $('input[name="_token"]').val();
			$('title').html("Director List Report");
			var dtButtons = function(buttons){
				var extended = [];
				for(var i = 0; i < buttons.length; i++){
					var item = {
						extend: buttons[i],
						exportOptions: {
							columns: [':visible']
						}
					};
					switch(buttons[i]){
						case 'pdfHtml5':
						item.orientation = 'landscape';
						break;
					}
					extended.push(item);
				}
				return extended;
			}
		    $('#directorReportTable').DataTable({
		        processing: true,
				language: {
					 processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>"
				},
		        serverSide: false,
				pageLength: 25,
				ajax: {
		            "url": base_url+"/admin/directorReportindex",
					headers: {'X-CSRF-TOKEN': token},
		        },
				dom: 'Blfrtip',
				buttons: dtButtons([
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5',
					'colvis'
				]),
		        columns: [
		            { data: 'name', name: 'name' },
		            { data: 'address', name: 'address' },
		            { data: 'city', name: 'city'},
		            { data: 'home_phone', name: 'home_phone'},
		            { data: 'email', name: 'email'}     
		        ],
		    });
			$(".dt-buttons").appendTo($('#datatable_button_stack' ));
		});
	</script>
	<!-- CRUD LIST CONTENT - crud_list_scripts stack -->
	@stack('crud_list_scripts')
@endsection