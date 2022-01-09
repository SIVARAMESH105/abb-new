@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  	<h1>
		    <span class="text-capitalize">Coach Revenue Report</span>
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
							<th>Camp Revenue</th>
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
						</tr>
					</tfoot>
					<tbody>
						@if(!empty($campdatas))
							@foreach ($campdatas as $campdata)
								<tr>
									<td>{{$campdata->camp_focus}}</td>
									<td>{{$campdata->Location}}</td>
									<td>{{$campdata->City}}</td>
									<td>{{$campdata->state_name}}</td>
									<td>{{$campdata->startdate}}</td>
									<td>{{$campdata->enddate}}</td>
									<td>{{$campdata->starttime}}</td>
									<td>{{$campdata->endtime}}</td>
									<td>$ {{$campdata->camprevenue}}</td>
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
    <script src={{ asset('public/packages/datatableexporttools/dataTables.buttons.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/buttons.bootstrap.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/jszip.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/pdfmake.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/vfs_fonts.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/buttons.html5.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/buttons.print.min.js') }} type="text/javascript"></script>
	<script src={{ asset('public/packages/datatableexporttools/buttons.colVis.min.js') }} type="text/javascript"></script>

	<script type="text/javascript">
	  jQuery(document).ready(function($) {
			var base_url = $('#base_url').val(); 
			var token = $('input[name="_token"]').val();
			$('title').html("Coach Camp Revenue Report");
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
			var table = $("#crudTable").DataTable({
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
		            var camperRevenueTotal = api
		                .column( 8 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		                $( api.column( 7 ).footer() ).append('Total');
						console.log(camperRevenueTotal);
			            $( api.column( 8 ).footer() ).append("$ "+camperRevenueTotal);
    			},
				"paging": 25,
				"autoWidth": true,
				dom: 'Blfrtip',
				buttons: dtButtons([
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5',
					'colvis'
				]),
				columns: [
						{ data: 'Camp Name', name: 'Camp Name' },
						{ data: 'Location', name: 'Location' },
						{ data: 'City', name: 'City' },
						{ data: 'State', name: 'State' },
						{ data: 'Start Date', name: 'Start Date' },
						{ data: 'End Date', name: 'End Date' },
						{ data: 'Start Time', name: 'Start Time' },
						{ data: 'End Time', name: 'End Time' },
						{ data: 'Camp Revenue', name: 'Camp Revenue' },
					],
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