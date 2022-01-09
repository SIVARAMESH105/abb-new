@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  	<h1>
		    <span class="text-capitalize">Coach Assignments Report</span>
	  	</h1>
	  	<ol class="breadcrumb">
		    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
		    <li class="active">Coach Assignments Report</li>
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
					<table id="coachAssignmentsReportTable" class="table table-bordered table-striped display">
						<thead>
							<tr>
								<th>Camp Name</th>
								<th>Location</th>
								<th>City</th>
								<th>State</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Coach Name</th>
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
			$('title').html("Coach Assignments Report");
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
		    var table = $('#coachAssignmentsReportTable').DataTable({
		        processing: true,
		        pageLength: 25,
		        /* Disable initial sort */
				aaSorting: [],
				language: {
				 	processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>"
				},
		        serverSide: false,
				ajax: {
		            "url": base_url+"/admin/coachAssignmentsReportTable",
					headers: {'X-CSRF-TOKEN': token},
		            "type": "POST"
		        },
		        columns: [
		            { data: 'camp_focus', name: 'camp_focus' },
		            { data: 'Location', name: 'tbllocation.Location' },
		            { data: 'City', name: 'tbllocation.City'},
		            { data: 'state_name', name: 'tbl_state_codes.state_name'},
		            { data: 'startdate', name: 'startdate'},
		            { data: 'enddate', name: 'enddate'},
		            { data: 'full_name', name: 'full_name'}     
		        ],
		        dom: 'Blfrtip',
               	buttons: dtButtons([
                 	'excelHtml5',
                 	'csvHtml5',
                 	'pdfHtml5',
                 	'colvis'
               	]),
		    });
		    // move the datatable buttons in the top-right corner and make them smaller
           	table.buttons().each(function(button) {
             	if (button.node.className.indexOf('buttons-columnVisibility') == -1) {
                   button.node.className = button.node.className + " btn-sm";
                }
           	});
           	$(".dt-buttons").appendTo($('#datatable_button_stack' ));
		});
	</script>
	<!-- CRUD LIST CONTENT - crud_list_scripts stack -->
	@stack('crud_list_scripts')
@endsection