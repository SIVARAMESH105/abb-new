@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  	<h1>
		    <span class="text-capitalize">Revenue Report</span>
	  	</h1>
	  	<ol class="breadcrumb">
		    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
		    <li class="active">Revenue Report</li>
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
					<table id="revenueReportTable" class="table table-bordered table-striped display">
					@if($optionsDisplay==1)
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
								<th>Camper Count</th>
								<th>Camp Revenue</th>
								<th>Coach Name</th>
							</tr>
						</thead>
						<tfoot align="right">
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</tfoot>
					@elseif($optionsDisplay==2)
						<thead>
							<tr>
								<th>Camp Revenue</th>
								<th>Product Revenue</th>
								<th>Total Revenue</th>
							</tr>
						</thead>
					@else
						<thead>
							<tr>
							    <th>Total Revenue</th>
							</tr>
						</thead>
					@endif					
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
			$('title').html("Revenue Report");
			var dtButtons = function(buttons){
               	var extended = [];
               	for(var i = 0; i < buttons.length; i++){
	               	var item = {
	                    extend: buttons[i],
	                    footer: true,
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
            
           	@if($optionsDisplay==1)
           		// For All camper details, camp total, grand totals
           		var columns = [
		            { data: 'camp_focus', name: 'camp_focus' },
		            { data: 'Location', name: 'tbllocation.Location' },
		            { data: 'City', name: 'tbllocation.City'},
		            { data: 'state_name', name: 'tbl_state_codes.state_name'},
		            { data: 'startdate', name: 'startdate'},
		            { data: 'enddate', name: 'enddate'},
		            { data: 'starttime', name: 'starttime'},
		            { data: 'endtime', name: 'endtime'},
		            { data: 'campercount', name: 'campercount'},
		            { data: 'camp_revenue', name: 'camp_revenue'},
		            { data: 'full_name', name: 'full_name'}     
		        ];
           	@elseif($optionsDisplay==2)
           	   //Camp total and grand total
           		var columns = [
		            { data: 'camp_revenue', name: 'camp_revenue' },
		            { data: 'product_revenue', name: 'product_revenue' },
		            { data: 'total_revenue', name: 'total_revenue'},  
		        ];
           	@else
           		//Camp grand total only
           		var columns = [
           			{ data: 'total_revenue', name: 'total_revenue'},
           		]
           	@endif
				var table = $('#revenueReportTable').DataTable({
				@if($optionsDisplay==1)
		    	"footerCallback": function ( row, data, start, end, display ) {
		            var api = this.api(), data;
		            
		            // converting to interger to find total
		            var intVal = function ( i ) {
		                return typeof i === 'string' ?
		                    i.replace(/[\$,]/g, '')*1 :
		                    typeof i === 'number' ?
		                        i : 0;
		            };
		 
		            // computing column Total of the complete result 
		            var camperTotal = api
		                .column( 8 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		            var camperRevenueTotal = api
		                .column( 9 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		                $( api.column( 6 ).footer() ).html('Total');
			            $( api.column( 8 ).footer() ).html(camperTotal);
			            $( api.column( 9 ).footer() ).html("$ "+camperRevenueTotal);
			            //$( api.column( 5 ).footer() ).html("$ "+camperRevenueTotal);
			    },
    			@endif
		        processing: true,
		        pageLength: 25,

		        /* Disable initial sort */
				aaSorting: [],
				language: {
				 	processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>",
				 	emptyTable:"<p class='text-center'>Sorry, no camps match your criteria, please select different criteria and try again.</p>"
				},
		        serverSide: false,
				ajax: {
		            "url": base_url+"/admin/revenueReportTable",
					headers: {'X-CSRF-TOKEN': token},
		            "type": "POST"
		        },
		        columns: columns,
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