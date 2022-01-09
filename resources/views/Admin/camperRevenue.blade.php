@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  	<h1>
		    <span class="text-capitalize">Revenue Per Camper</span>
	  	</h1>
	  	<ol class="breadcrumb">
		    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
		    <li class="active">Revenue Per Camper</li>
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
					<a href="{{url('/admin/rosterReportView')}}" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="ionicons ion-arrow-left-a">  </i> Back To Roster Reports</span></a>
					<div id="datatable_button_stack" class="pull-right text-right">	
					</div>
				</div>
				{!! csrf_field() !!}
			  	<input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
			  	<input type="hidden" name="camp_id" value="{{ $camp_id }}" id="camp_id"/>
				<div class="box-body table-responsive">
					<table id="camperRevenueTable" class="table table-bordered table-striped display">
						<thead>
							<tr>
								<th>Camper Name</th>
								<th>Camper Email</th>
								<th>Gender</th>
								<th>DOB</th>
								<th>Camp Name</th>
								<th>Camper Revenue</th>
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
			var camp_id = $('#camp_id').val(); 
			var token = $('input[name="_token"]').val();
			$('title').html("Roster Report");
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
		    var table = $('#camperRevenueTable').DataTable({
		        processing: true,
		        pageLength: 25,
		        /* Disable initial sort */
				aaSorting: [],
				language: {
				 	processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>"
				},
		        serverSide: false,
				ajax: {
		            "url": base_url+"/admin/getCamperRevenueList",
					headers: {'X-CSRF-TOKEN': token},
		            "type": "POST",
		            "data": {
		            	"camp_id": camp_id
		            }
		        },
		        columns: [
		            { data: 'name', name: 'name' },
		            { data: 'email', name: 'email' },
		            { data: 'gender', name: 'gender'},
		            { data: 'dob', name: 'dob'},
		            { data: 'camp_focus', name: 'camp_focus'},
		            { data: 'camperrevenue', name: 'camperrevenue'}
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