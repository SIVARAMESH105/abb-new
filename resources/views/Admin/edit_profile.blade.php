  
@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Edit Profile</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">Edit Profile</li>
	  </ol>
	</section>
@endsection

@section('content')
<!-- Default box -->
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-8  col-md-offset-2">
		<div class="box">
			<div class="box-body">
				<form method="post" class="form-horizontal" id="edit-profile" action="{{url('admin/update_profile/'.backpack_user()->id)}}">
					{!! csrf_field() !!}
					<div class="form-group">
						<label class="col-md-4 control-label">Name<span class="red">*</span></label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="username" value="{{backpack_user()->name}}">
								@if ($errors->has('username'))
									<div class="error" >
										{{ $errors->first('username') }}
									</div>
								@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">Email<span class="red">*</span></label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="useremail" value="{{backpack_user()->email}}">
								@if ($errors->has('useremail'))
									<div class="error" >
										{{ $errors->first('useremail') }}
									</div>
								@endif
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<input type="submit" name="submit" value="Update" class="btn btn-default">
						</div>
					</div>
				</form>
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

	

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->

<script>
jQuery(document).ready(function(){
	jQuery("#edit-profile").validate({ 
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.appendTo(element.parent('div'));
        },
        focusInvalid: false,
        highlight: function(element, errorClass, validClass) {
            jQuery(element).removeClass(errorClass);
        },
        rules: {
            'username': {
              required: true,
            }, 
             'useremail': {
              required: true,
            }
        },
        messages:{
            'username': {
              required: "Please enter the name",
            },
             'useremail': {
              required: "Please enter the email",
            }
        },
    });

    jQuery("#edit-profile").find("button[type='submit']").on("submit",function(e){
        if(jQuery("#edit-profile").valid()) {
            jQuery(this).submit();
        }
    });
});

</script>

  @stack('crud_list_scripts')
@endsection