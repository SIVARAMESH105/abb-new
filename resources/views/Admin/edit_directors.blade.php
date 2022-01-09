@extends('backpack::layout') @section('header')
<section class="content-header">
    <h1>
	    <span class="text-capitalize">Edit Director</span>
	  </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
        <li class="active">Edit Director</li>
    </ol>
</section>
@endsection @section('content')
<!-- Default box -->
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-8  col-md-offset-2">
	<a href="{{ url('admin/manageDirectors') }}"><i class="fa fa-angle-double-left"></i> Back to <span class="text-lowercase">manage directors </span></a><br><br>
        <div class="box">
            <?php //echo '<pre>'; print_r($UserVal);die; ?>
                <form method="POST" action="{{url('admin/updateDirector')}}" accept-charset="UTF-8">
                    {{ csrf_field() }}
					<input type="hidden" id="id" name="id" value="{{$UserVal->id}}"/>
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit</h3>
                        </div>
                        <div class="box-body">
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>Name<span class="red">*</span></label>

                                <input type="text" name="name" value="{{$UserVal->name}}" class="form-control">
								@if ($errors->has('name'))
    								<div class="error">
    									{{ $errors->first('name') }}
    								</div>
    							@endif 
                            </div>

                            <div class="form-group col-md-12">
                                <label>Email<span class="red">*</span></label>

                                <input type="text" name="email" value="{{$UserVal->email}}" class="form-control">
                                @if ($errors->has('email'))
                                    <div class="error">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif 
                            </div>

                            
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- radio -->

                            <div class="form-group col-md-12">

                                <div>
                                    <label>Gender<span class="red">*</span></label>
                                </div>

                                <label class="radio-inline" for="gender_1">
                                    <input type="radio" id="gender_1" name="gender" value="male" <?php if($UserVal->gender=='male'){ echo "checked";}  ?>> Male
                                </label>

                                <label class="radio-inline" for="gender_2">
                                    <input type="radio" id="gender_2" name="gender" value="female" <?php if($UserVal->gender=='female'){ echo "checked";}  ?>> Female
                                </label>
								@if ($errors->has('gender'))
    								<div class="error">
    									{{ $errors->first('gender') }}
    								</div>
								@endif
                            </div>
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- html5 date input -->

                            <div class="form-group col-md-12">
                                <label>Date Of Birth<span class="red">*</span></label>
                                <input type="date" name="dob" value="{{$UserVal->dob}}" class="form-control">
								@if ($errors->has('dob'))
    								<div class="error">
    									{{ $errors->first('dob') }}
    								</div>
								@endif
                            </div>

                            
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>Address<span class="red">*</span></label>

                                <input type="text" name="address" value="{{$UserVal->address}}" class="form-control">
								@if ($errors->has('address'))
								<div class="error">
									{{ $errors->first('address') }}
								</div>
								@endif
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>City<span class="red">*</span></label>

                                <input type="text" name="city" value="{{$UserVal->city}}" class="form-control">
								@if ($errors->has('city'))
								<div class="error">
									{{ $errors->first('city') }}
								</div>
								@endif
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>State<span class="red">*</span></label>
                                <select name="state" class="form-control state">
                                    @foreach($states as $state)
                                        <option data-attr = "{{$state->state_code}}" value="{{$state->state_id}}" @if($UserVal->state == $state->state_id) {{'selected'}} @endif >{{$state->state_name}}</option>
                                    @endforeach
                                </select>
								@if ($errors->has('state'))
								<div class="error">
									{{ $errors->first('state') }}
								</div>
								@endif
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>ZIP/Postal Code<span class="red">*</span></label>

                                <input type="text" name="zip" value="{{$UserVal->zip}}" class="form-control">
								@if ($errors->has('zip'))
								<div class="error">
									{{ $errors->first('zip') }}
								</div>
								@endif
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- select from array -->
                            <div class="form-group col-md-12">
                                <label>Country<span class="red">*</span></label>
                                <select id="country" name="country" class="form-control input-md" value="{{ old('country') }}" required="">
									<option value="">Select</option>

									@foreach($country_details as $key => $details)
										<option value="{{$key}}" @if($UserVal->country == $key) selected='selected' @endif>{{$details}}</option>
									@endforeach
								</select>
								@if ($errors->has('country'))
    								<div class="error">
    									{{ $errors->first('country') }}
    								</div>
								@endif
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
							<a href="{{url('admin/manageDirectors')}}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">Cancel</span></a>
                        </div>
                        <!-- /.box-footer-->
                    </div>
                    <!-- /.box -->
                </form>
        </div>
    </div>
</div>
@endsection @section('after_styles')
<!-- DATA TABLES -->
<link href="{{ asset('public/vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('public/vendor/backpack/crud/css/crud.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendor/backpack/crud/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendor/backpack/crud/css/list.css') }}">

<!-- CRUD LIST CONTENT - crud_list_styles stack -->
@stack('crud_list_styles') @endsection @section('after_scripts')
<!-- DATA TABLES SCRIPT -->
<script src="{{ asset('public/vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>

<script src="{{ asset('public/vendor/backpack/crud/js/crud.js') }}"></script>
<script src="{{ asset('public/vendor/backpack/crud/js/form.js') }}"></script>
<script src="{{ asset('public/vendor/backpack/crud/js/list.js') }}"></script>

<script src="{{ asset('public/vendor/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- CRUD LIST CONTENT - crud_list_scripts stack -->
@stack('crud_list_scripts') @endsection