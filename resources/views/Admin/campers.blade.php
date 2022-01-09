@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Camper List</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">Camper List</li>
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
			{!! csrf_field() !!}
		  <input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
			<div class="box-body table-responsive">
				<table id="camperUsersTable" class="table table-bordered table-striped display">
					<thead>
						<tr>
							<th>Roster Name</th>
							<th>Gender</th>
							<th>DOB</th>
							<th>City</th>
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

<script type="text/javascript">
$(document).ready(function() {
	var base_url = $('#base_url').val(); 
	var token = $('input[name="_token"]').val();
    $('#camperUsersTable').DataTable({
        processing: true,
		language: {
			 processing: "<img src='{{ asset('public/images/Loading_icon.gif') }}' style='width: 200px;height: auto;margin: 0 auto;'>"
		},
        serverSide: true,
		ajax: {
            "url": base_url+"/admin/getCamperUserslist",
			headers: {'X-CSRF-TOKEN': token},
            "type": "POST"
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'gender', name: 'gender' },
            { data: 'dob', name: 'dob' },
            { data: 'city', name: 'city'},
			{ data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
<script>
function confirmationDelete(t_id,p_type)
{
	var conf = confirm('Are you sure want to delete this record?');
	if(conf){
	var base_url = $('#base_url').val(); 
	  window.location.href = (base_url+"/admin/deleteCamper/"+t_id+"/"+p_type);
	}else{
		return false;
	}
}
</script>
  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection