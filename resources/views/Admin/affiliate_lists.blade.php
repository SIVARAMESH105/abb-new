@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Manage Affiliate</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">Manage Affiliate</li>
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
				<a href="{{url('/admin/createAffiliate')}}" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Add Affiliate</span></a>
				<div id="datatable_button_stack" class="pull-right text-right">	
				</div>
			</div>
			{!! csrf_field() !!}
	  		<input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
			<div class="box-body table-responsive">
				<table id="affiliateTable" class="table table-bordered table-striped display">
					<thead>
						<tr>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Email</th>
							<th>URL</th>
							<th>Commission Percentage</th>
							<th>Approve Status</th>
							<th>Action</th>
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
	$('#affiliateTable').DataTable({
        processing: true,
		language: {
			 processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>"
		},
        serverSide: false,
		ajax: {
            "url": base_url+"/admin/getAffiliateList",
			headers: {'X-CSRF-TOKEN': token},
            "type": "POST"
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
			{ data: 'phone', name: 'phone' },
			{ data: 'email', name: 'email' },
			{ data: 'URL_links', name: 'URL_links' },
			{ data: 'commission_percentage', name: 'commission_percentage' },
			{ data: 'is_approved', name: 'is_approved' },
			{ data: 'action', name: 'action', orderable: false, searchable: false}
            
        ]
    });
});
//is approve enable function start
function isApprove(id) {
	var base_url = $('#base_url').val(); 
	var token = $('input[name="_token"]').val();
	if($("#approved"+id).is(':checked')) {
		var isApprove=1;  // checked
		$("#approved"+id).attr("disabled", true);
	} else {
		var isApprove=0; // unchecked
	}
	$.ajax({
		url:base_url+"/admin/affiliateApprove",
		type:"POST",
		data:{"_token":token,"approveId":id,"isApprove":isApprove},
		success:function(res) {
			alert("Mail has been send to user");
			$("#approved"+id).attr("disabled", true);
		}
	});
	
}
</script>
<script>
function confirmationDelete(affiliate_id)
{
	var conf = confirm('Are you sure want to delete this record?');
	if(conf){
	var base_url = $('#base_url').val(); 
	  window.location.href = (base_url+"/admin/deleteAffiliate/"+affiliate_id);
	}else{
		return false;
	}
}
</script>
  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection