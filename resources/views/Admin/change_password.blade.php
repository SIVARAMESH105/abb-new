@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Change Password</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">Change Password</li>
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
				<form method="post" class="form-horizontal" id="chg_pwd" action="{{url('admin/update_password/'.backpack_user()->id)}}">
					{!! csrf_field() !!}
					<div class="form-group">
						<label class="col-md-4 control-label">Current Password<span class="red">*</span></label>
						<div class="col-md-4">
							<input type="password" class="form-control" name="current_password">
							@if ($errors->has('current_password'))
								<div class="error">
									{{ $errors->first('current_password') }}
								</div>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">New Password<span class="red">*</span></label>
						<div class="col-md-4">
							<input type="password" class="form-control" name="new_password">
							@if ($errors->has('new_password'))
								<div class="error">
									{{ $errors->first('new_password') }}
								</div>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">Confirm Password<span class="red">*</span></label>
						<div class="col-md-4">
							<input type="password" class="form-control" name="confirm_password">
							@if ($errors->has('confirm_password'))
								<div class="error">
									{{ $errors->first('confirm_password') }}
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

	<script>
jQuery(document).ready(function(){
	jQuery("#chg_pwd").validate({ 
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.appendTo(element.parent('div'));
        },
        focusInvalid: false,
        highlight: function(element, errorClass, validClass) {
            jQuery(element).removeClass(errorClass);
        },
        rules: {
            'current_password': {
              required: true,
            }, 
             'new_password': {
              required: true,
            }, 
             'confirm_password': {
              required: true,
            }
        },
        messages:{
            'current_password': {
              required: "Please enter current password",
            },
             'new_password': {
              required: "Please enter new password",
            },
             'confirm_password': {
              required: "Please enter confirm password",
            }
        },
    });

    jQuery("#chg_pwd").find("button[type='submit']").on("submit",function(e){
        if(jQuery("#chg_pwd").valid()) {
            jQuery(this).submit();
        }
    });
});

</script>

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection