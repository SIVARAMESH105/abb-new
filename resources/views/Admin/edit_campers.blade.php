@extends('backpack::layout') @section('header')
<section class="content-header">
    <h1>
	    <span class="text-capitalize">Edit Camper</span>
	  </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
        <li class="active">Edit Camper</li>
    </ol>
</section>
@endsection @section('content')
<!-- Default box -->
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-8  col-md-offset-2">
	@if(Request::segment(4)== 'm_camper')
	<a href="{{ url('admin/manageCampers') }}"><i class="fa fa-angle-double-left"></i> Back to all <span class="text-lowercase">manage campers </span></a><br><br>
	@else
	<a href="{{ url('admin/campers') }}"><i class="fa fa-angle-double-left"></i> Back to all <span class="text-lowercase"> campers </span></a><br><br>
	@endif
        <div class="box">
            <?php //echo '<pre>'; print_r($UserVal);die; ?>
                <form method="POST" action="{{url('admin/updateCamper')}}" accept-charset="UTF-8">
                    {{ csrf_field() }}
					<input type="hidden" id="id" name="id" value="{{$UserVal->id}}"/>
					<input type="hidden" id="id" name="page_type" value="{{Request::segment(4)}}"/>
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit</h3>
                        </div>
                        <div class="box-body">
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>
                                    <h4>1. GENERAL INFORMATION</h4>
                                    <br>Student's First Name<span class="red">*</span></label>

                                <input type="text" name="name" value="{{$UserVal->name}}" class="form-control">
								@if ($errors->has('name'))
								<div class="error">
									{{ $errors->first('name') }}
								</div>
							@endif 
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>Student's Last Name*</label>

                                <input type="text" name="fname" value="{{$UserVal->fname}}" class="form-control">
								@if ($errors->has('fname'))
								<div class="error">
									{{ $errors->first('fname') }}
								</div>
								@endif 
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- select -->

                            <div class="form-group col-md-12">

                                <label>T-shirt Size<span class="red">*</span></label>

                                <select name="tshirtsize" class="form-control">

                                    <option value="">-</option>

                                    <option value="2">Youth Medium (Y-M)</option>
                                    <option value="4" selected="">Adult Small (A-S)</option>
                                    <option value="5">Adult Medium (A-M)</option>
                                    <option value="6">Adult Large (A-L)</option>
                                    <option value="7">Adult Extra Large (A-XL)</option>
                                    <option value="8">Adult Extra-Extra Large (A-XXL)</option>
                                </select>
								@if ($errors->has('tshirtsize'))
								<div class="error">
									{{ $errors->first('tshirtsize') }}
								</div>
								@endif
                            </div>
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- radio -->

                            <div class="form-group col-md-12">

                                <div>
                                    <label>Student Gender<span class="red">*</span></label>
                                </div>

                                <label class="radio-inline" for="gender_1">
                                    <input type="radio" id="gender_1" name="gender" value="male" <?php if($UserVal->gender=='male'){ echo "checked=checked";}  ?>> Male
                                </label>

                                <label class="radio-inline" for="gender_2">
                                    <input type="radio" id="gender_2" name="gender" value="female" <?php if($UserVal->gender=='female'){ echo "checked=checked";}  ?>> Female
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
                                <label>Student Birthdate<span class="red">*</span></label>
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
                                <label>Student Grade<span class="red">*</span></label>

                                <input type="text" name="grade" value="{{$UserVal->grade}}" class="form-control">
								@if ($errors->has('grade'))
								<div class="error">
									{{ $errors->first('grade') }}
								</div>
								@endif
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label><i>Parent/Guardian</i>
                                    <br>First Name<span class="red">*</span></label>

                                <input type="text" name="parent_firstname" value="{{$UserVal->parent_firstname}}" class="form-control">
								@if ($errors->has('parent_firstname'))
								<div class="error">
									{{ $errors->first('parent_firstname') }}
								</div>
								@endif
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>Last Name<span class="red">*</span></label>

                                <input type="text" name="parent_lastname" value="{{$UserVal->parent_lastname}}" class="form-control">
								@if ($errors->has('parent_lastname'))
								<div class="error">
									{{ $errors->first('parent_lastname') }}
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

                                <input type="text" name="state" value="{{$UserVal->state}}" class="form-control">
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
                                <label>Country</label>
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
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>Home Phone<span class="red">*</span></label>

                                <input type="text" name="home_phone" value="{{$UserVal->home_phone}}" class="form-control">
								@if ($errors->has('home_phone'))
								<div class="error">
									{{ $errors->first('home_phone') }}
								</div>
								@endif
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>Work/Other Phone</label>

                                <input type="text" name="work_phone" value="{{$UserVal->work_phone}}" class="form-control">
								@if ($errors->has('work_phone'))
								<div class="error">
									{{ $errors->first('work_phone') }}
								</div>
								@endif
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>Parent E-mail<span class="red">*</span></label>

                                <input type="text" name="parent_email" value="{{$UserVal->parent_email}}" class="form-control">
								@if ($errors->has('parent_email'))
								<div class="error">
									{{ $errors->first('parent_email') }}
								</div>
								@endif
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- radio -->

                            <div class="form-group col-md-12">

                                <div>
                                    <label>
                                        <h4>2. BASKETBALL EXPERIENCE</h4>
                                        <br>Have you attended an Advantage Basketball Camps session before?</label>
                                </div>

                                <label class="radio-inline" for="basketball_exp_1">
                                    <input type="radio" id="basketball_exp_1" name="basketball_exp" value="yes" <?php if($UserVal->basketball_exp=='yes'){ echo "checked=checked";}  ?>> Yes
                                </label>

                                <label class="radio-inline" for="basketball_exp_2">
                                    <input type="radio" id="basketball_exp_2" name="basketball_exp" value="no" <?php if($UserVal->basketball_exp=='no'){ echo "checked=checked";}  ?>> No
                                </label>
								@if ($errors->has('basketball_exp'))
								<div class="error">
									{{ $errors->first('basketball_exp') }}
								</div>
								@endif
                            </div>
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>If yes, where/when</label>

                                <input type="text" name="basketball_exp_desc" value="{{$UserVal->basketball_exp_desc}}" class="form-control">
								@if ($errors->has('basketball_exp_desc'))
								<div class="error">
									{{ $errors->first('basketball_exp_desc') }}
								</div>
								@endif
                            </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- radio -->

                            <div class="form-group col-md-12">

                                <div>
                                    <label>How woud you rate your basketball skills and abilities?</label>
                                </div>

                                <label class="radio-inline" for="basketball_skill_1">
                                    <input type="radio" id="basketball_skill_1" name="basketball_skill" value="beginner" <?php if($UserVal->basketball_skill=='beginner'){ echo "checked=checked";}  ?>> Beginner
                                </label>

                                <label class="radio-inline" for="basketball_skill_2">
                                    <input type="radio" id="basketball_skill_2" name="basketball_skill" value="intermediate" <?php if($UserVal->basketball_skill=='intermediate'){ echo "checked=checked";}  ?>> Intermediate
                                </label>

                                <label class="radio-inline" for="basketball_skill_3">
                                    <input type="radio" id="basketball_skill_3" name="basketball_skill" value="advanced" <?php if($UserVal->basketball_skill=='advanced'){ echo "checked=checked";}  ?>> Advanced
                                </label>
								@if ($errors->has('basketball_skill'))
								<div class="error">
									{{ $errors->first('basketball_skill') }}
								</div>
								@endif
                            </div>
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- hidden input -->
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
                            @if(Request::segment(4)== 'm_camper')
							<a href="{{url('admin/manageCampers')}}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">Cancel</span></a>
							@else
							<a href="{{url('admin/campers')}}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">Cancel</span></a>
							@endif
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