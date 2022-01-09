@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Edit Camp</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">Edit Camp</li>
	  </ol>
	</section>
@endsection

@section('content')
<!-- Default box -->
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-8  col-md-offset-2">
		<div class="box">
			<form method="post" action="{{url('admin/updateCamp/'.$camps[0]->id)}}">
				{!! csrf_field() !!}
				<input type="hidden" name="id" value="{{$camps[0]->id}}">
				<input type="hidden" name="locationId" value="{{$camps[0]->LocationId}}">
				<table>
					<tr>
						<td>Camp Name</td>
						<td>
							<input type="text" name="campname" value="{{$camps[0]->camp_focus}}">
							@if ($errors->has('campname'))
								<div class="error">
									{{ $errors->first('campname') }}
								</div>
							@endif 
						</td>
					</tr>
					<tr>
						<td>Location</td>
						<td>
							<select name="location">
								<option value="">Select Location</option>
								@foreach($locations as $locationObj)
									<option value="{{$locationObj->Id}}" <?php echo ($locationObj->Id == $camps[0]->LocationId) ? 'selected' : ''; ?>>{{$locationObj->Location}}</option>
								@endforeach
							</select>
							State: {{$camps[0]->State}}, City: {{$camps[0]->City}}
							@if ($errors->has('location'))
								<div class="error">
									{{ $errors->first('location') }}
								</div>
							@endif 
						</td>
					</tr>
					<tr>
						<td>Start Date</td>
						<td>
							<select name="startMonth">
								<option value="">Month</option>
								<?php
									$i=1;
									foreach($months as $month) { ?>
										<option value="{{$i}}" <?php echo ($i == $startMonth) ? 'selected' : ''; ?>>{{$month}}</option>
								<?php 
										$i++;
									}
								?>
							</select>
							<select name="startDay">
								<option value="">Day</option>
								<?php for($i=1; $i<=31; $i++) { ?>
										<option value="{{$i}}" <?php echo ($i == $startDay) ? 'selected' : ''; ?>>{{$i}}</option>
								<?php } ?>
							</select>
							<select name="startYear">
								<option value="">Year</option>
								<?php for($i=2016; $i<=2019; $i++) { ?>
										<option value="{{$i}}" <?php echo ($i == $startYear) ? 'selected' : ''; ?>>{{$i}}</option>
								<?php } ?>
							</select>
							@if ($errors->has('startMonth'))
								<div class="error">
									{{ $errors->first('startMonth') }}
								</div>
							@endif
							@if ($errors->has('startDay'))
								<div class="error">
									{{ $errors->first('startDay') }}
								</div>
							@endif
							@if ($errors->has('startYear'))
								<div class="error">
									{{ $errors->first('startYear') }}
								</div>
							@endif 
						</td>
					</tr>
					<tr>
						<td>End Date</td>
						<td>
							<select name="endMonth">
								<option value="">Month</option>
								<?php
									$i=1;
									foreach($months as $month) { ?>
										<option value="{{$i}}" <?php echo ($i == $endMonth) ? 'selected' : ''; ?>>{{$month}}</option>
								<?php 
										$i++;
									}
								?>
							</select>
							<select name="endDay">
								<option value="">Day</option>
								<?php for($i=1; $i<=31; $i++) { ?>
										<option value="{{$i}}" <?php echo ($i == $endDay) ? 'selected' : ''; ?>>{{$i}}</option>
								<?php } ?>
							</select>
							<select name="endYear">
								<option value="">Year</option>
								<?php for($i=2016; $i<=2019; $i++) { ?>
										<option value="{{$i}}" <?php echo ($i == $endYear) ? 'selected' : ''; ?>>{{$i}}</option>
								<?php } ?>
							</select>
							@if ($errors->has('endMonth'))
								<div class="error">
									{{ $errors->first('endMonth') }}
								</div>
							@endif
							@if ($errors->has('endDay'))
								<div class="error">
									{{ $errors->first('endDay') }}
								</div>
							@endif
							@if ($errors->has('endYear'))
								<div class="error">
									{{ $errors->first('endYear') }}
								</div>
							@endif 
						</td>
					</tr>
					<tr>
						<td>Start Time</td>
						<td>
							<select name="startTime">
								<option value="">Select</option>
								@foreach($campTimes as $campTime)
									<option value="{{$campTime->timevalue}}" <?php echo ($campTime->timevalue == $starttime) ? 'selected' : ''; ?>>{{$campTime->time}}</option>
								@endforeach
							</select>
							@if ($errors->has('startTime'))
								<div class="error">
									{{ $errors->first('startTime') }}
								</div>
							@endif
						</td>
					</tr>
					<tr>
						<td>End Time</td>
						<td>
							<select name="endTime">
								<option value="">Select</option>
								@foreach($campTimes as $campTime)
									<option value="{{$campTime->timevalue}}" <?php echo ($campTime->timevalue == $endtime) ? 'selected' : ''; ?>>{{$campTime->time}}</option>
								@endforeach
							</select>
							@if ($errors->has('endTime'))
								<div class="error">
									{{ $errors->first('endTime') }}
								</div>
							@endif
						</td>
					</tr>
					<tr>
						<td>Season</td>
						<td>
							<select name="season">
								<option value="">Select</option>
								<?php
									$i=1;
									foreach($months as $month) { ?>
										<option value="{{$i}}" <?php echo ($i == $camps[0]->season) ? 'selected' : ''; ?>>{{$month}}</option>
								<?php 
										$i++;
									}
								?>
							</select>
							@if ($errors->has('season'))
								<div class="error">
									{{ $errors->first('season') }}
								</div>
							@endif
						</td>
					</tr>
					<tr>
						<td>Cost</td>
						<td>
							<input type="text" name="cost" value="{{$camps[0]->cost}}">
							@if ($errors->has('cost'))
								<div class="error">
									{{ $errors->first('cost') }}
								</div>
							@endif
						</td>
					</tr>
					<tr>
						<td>Early Bird Discount</td>
						<td>
							<input type="text" name="earlyBirdDiscount" value="{{$camps[0]->EarlyBirdDiscount}}">
							@if ($errors->has('earlyBirdDiscount'))
								<div class="error">
									{{ $errors->first('earlyBirdDiscount') }}
								</div>
							@endif
						</td>
					</tr>
					<tr>
						<td>Discount Days</td>
						<td>
							<input type="text" name="discountDays" value="{{$camps[0]->EarlyBirdDays}}">
							@if ($errors->has('discountDays'))
								<div class="error">
									{{ $errors->first('discountDays') }}
								</div>
							@endif
						</td>
					</tr>
					<tr>
						<td>Contact</td>
						<td>
							<input type="text" name="contact" value="{{$camps[0]->contact}}">
							@if ($errors->has('contact'))
								<div class="error">
									{{ $errors->first('contact') }}
								</div>
							@endif
						</td>
					</tr>
					<tr>
						<td>Status</td>
						<td>
							<input type="radio" name="status" value="1" <?php echo (1 == $camps[0]->status) ? 'checked' : ''; ?>> Active
							<input type="radio" name="status" value="0" <?php echo (0 == $camps[0]->status) ? 'checked' : ''; ?>> Inactive
							<input type="radio" name="status" value="2" <?php echo (2 == $camps[0]->status) ? 'checked' : ''; ?>> Comming Soon
							@if ($errors->has('status'))
								<div class="error">
									{{ $errors->first('status') }}
								</div>
							@endif
						</td>
					</tr>
					<tr>
						<td>Coach Assign</td>
						<td>
							<select name="coachAssign">
								<option value="">Select Coach</option>
								@foreach($coaches as $coach)
									<option value="{{$coach->id}}" <?php echo ($coach->id == $campCoach[0]->coach_id) ? 'selected' : ''; ?>>{{$coach->first_name.' '.$coach->last_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('coachAssign'))
								<div class="error">
									{{ $errors->first('coachAssign') }}
								</div>
							@endif
						</td>
					</tr>
					<tr>
						<td>Camp Flyer PDF</td>
						<td>
							<select name="campFlyer">
								<option value="">None</option>
								@foreach($flyers as $flyer)
									<option value="{{$flyer->flyer_id}}" <?php echo ($flyer->flyer_id == $camps[0]->flyer_id) ? 'selected' : ''; ?>>{{$flyer->flyer_title}}</option>
								@endforeach
							</select>
							@if ($errors->has('campFlyer'))
								<div class="error">
									{{ $errors->first('campFlyer') }}
								</div>
							@endif
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="submit" value="Update"></td>
					</tr>
				</table>
			</form>
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
  @stack('crud_list_scripts')
@endsection