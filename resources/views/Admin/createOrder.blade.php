@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Create Order</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url('admin/orders') }}">Orders</a></li>
	    <li class="active">Create Order</li>
	  </ol>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<!-- Default box -->
		
		<form method="post" class="form-horizontal" name="createOrder" id="create-order" action="{{url('admin/orders/store')}}">
			{!! csrf_field() !!}
		<div class="box">
		    <div class="box-header with-border">
				<h3 class="box-title">Add a new  Order</h3>
		    </div>
		    <div class="box-body">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      		      	<!-- load the view from the application if it exists, otherwise load the one in the package -->
            <!-- text input -->
			<div class="form-group col-md-12">
				<label><h4>1. GENERAL INFORMATION</h4><br>Student's First Name<span class="red">*</span></label>
                <input type="text" name="name" value="" class="form-control">
				@if ($errors->has('name'))
					<div class="error">{{$errors->first('name')}}</div>
				@endif
			</div>
			<!-- load the view from the application if it exists, otherwise load the one in the package -->
            <!-- text input -->
			<div class="form-group col-md-12">
				<label>Student's Last Name<span class="red">*</span></label>
                <input type="text" name="fname" value="" class="form-control">
				@if ($errors->has('fname'))
					<div class="error">{{$errors->first('fname')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>Email<span class="red">*</span></label>
                <input type="text" name="user_email" value="" class="form-control">
				@if ($errors->has('user_email'))
					<div class="error">{{$errors->first('user_email')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>Password<span class="red">*</span></label>
                <input type="password" name="user_password" value="" class="form-control">
				@if ($errors->has('user_password'))
					<div class="error">{{$errors->first('user_password')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>T-shirt Size<span class="red">*</span></label>
				<select name="tshirtsize" class="form-control">
					<option value="">-</option>
					<option value="2">Youth Medium (Y-M)</option>
					<option value="4">Adult Small (A-S)</option>
					<option value="5">Adult Medium (A-M)</option>
					<option value="6">Adult Large (A-L)</option>
					<option value="7">Adult Extra Large (A-XL)</option>
					<option value="8">Adult Extra-Extra Large (A-XXL)</option>
                </select>
				@if ($errors->has('tshirtsize'))
					<div class="error">{{$errors->first('tshirtsize')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<div>
					<label>Student Gender<span class="red">*</span></label>
				</div>
				<label class="radio-inline" for="gender_1">
					<input type="radio" id="gender_1" name="gender" value="Female"> Female
				</label>
				<label class="radio-inline" for="gender_2">
					<input type="radio" id="gender_2" name="gender" value="Male"> Male
				</label>
				@if ($errors->has('gender'))
					<div class="error">{{$errors->first('gender')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>Student Birthdate<span class="red">*</span></label>
				<input type="date" name="dob" value="" class="form-control">
				@if ($errors->has('dob'))
					<div class="error">{{$errors->first('dob')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>Student Grade<span class="red">*</span></label>
                <input type="text" name="grade" value="" class="form-control">
				@if ($errors->has('grade'))
					<div class="error">{{$errors->first('grade')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label><i>Parent/Guardian</i><br>First Name<span class="red">*</span></label>
                <input type="text" name="parent_firstname" value="" class="form-control">
				@if ($errors->has('parent_firstname'))
					<div class="error">{{$errors->first('parent_firstname')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>Last Name<span class="red">*</span></label>
                <input type="text" name="parent_lastname" value="" class="form-control">
				@if ($errors->has('parent_lastname'))
					<div class="error">{{$errors->first('parent_lastname')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>Address<span class="red">*</span></label>
                <input type="text" name="address" value="" class="form-control">
				@if ($errors->has('address'))
					<div class="error">{{$errors->first('address')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>City<span class="red">*</span></label>
                <input type="text" name="city" value="" class="form-control">
				@if ($errors->has('city'))
					<div class="error">{{$errors->first('city')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>State<span class="red">*</span></label>
                <input type="text" name="state" value="" class="form-control">
				@if ($errors->has('state'))
					<div class="error">{{$errors->first('state')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>ZIP/Postal Code<span class="red">*</span></label>
                <input type="text" name="zip" value="" class="form-control">
				@if ($errors->has('zip'))
					<div class="error">{{$errors->first('zip')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>Country</label>
				<select name="country" class="form-control">
                    <option value="">Other</option>
                    <option value="AR">Argentina</option>
                    <option value="AU">Australia</option>
                    <option value="AT">Austria</option>
                    <option value="BS">Bahamas</option>
                    <option value="BE">Belgium</option>
                    <option value="BM">Bermuda</option>
                    <option value="BR">Brazil</option>
                    <option value="BG">Bulgaria</option>
                    <option value="CA">Canada</option>
                    <option value="CL">Chile</option>
                    <option value="CN">China</option>
                    <option value="CY">Cyprus</option>
                    <option value="CZ">Czech Republic</option>
                    <option value="EC">Ecuador</option>
                    <option value="EG">Egypt</option>
                    <option value="SV">El Salvador</option>
                    <option value="FR">France</option>
                    <option value="DE">Germany</option>
                    <option value="GR">Greece</option>
                    <option value="GD">Grenada</option>
                    <option value="GT">Guatemala</option>
                    <option value="HK">Hong Kong S.A.R., China</option>
                    <option value="HU">Hungary</option>
                    <option value="IN">India</option>
                    <option value="ID">Indonesia</option>
                    <option value="IE">Ireland</option>
                    <option value="IL">Israel</option>
                    <option value="IT">Italy</option>
                    <option value="JP">Japan</option>
                    <option value="KW">Kuwait</option>
                    <option value="LB">Lebanon</option>
                    <option value="LT">Lithuania</option>
                    <option value="MY">Malaysia</option>
                    <option value="MX">Mexico</option>
                    <option value="NL">Netherlands</option>
                    <option value="NZ">New Zealand</option>
                    <option value="NG">Nigeria</option>
                    <option value="PE">Peru</option>
                    <option value="PH">Philippines</option>
                    <option value="PL">Poland</option>
                    <option value="PT">Portugal</option>
                    <option value="PR">Puerto Rico</option>
                    <option value="QA">Qatar</option>
                    <option value="RO">Romania</option>
                    <option value="RU">Russia</option>
                    <option value="SA">Saudi Arabia</option>
                    <option value="SN">Senegal</option>
                    <option value="SP">Serbia</option>
                    <option value="SG">Singapore</option>
                    <option value="ZA">South Africa</option>
                    <option value="KR">South Korea</option>
                    <option value="ES">Spain</option>
                    <option value="CH">Switzerland</option>
                    <option value="TW">Taiwan</option>
                    <option value="TR">Turkey</option>
                    <option value="UA">Ukraine</option>
                    <option value="AE">United Arab Emirates</option>
                    <option value="GB">United Kingdom</option>
                    <option value="US" selected>United States</option>
                    <option value="VN">Vietnam</option>
                </select>
			</div>
			<div class="form-group col-md-12">
				<label>Home Phone<span class="red">*</span></label>
                <input type="text" name="home_phone" value="" class="form-control">
				@if ($errors->has('home_phone'))
					<div class="error">{{$errors->first('home_phone')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>Work/Other Phone</label>
                <input type="text" name="work_phone" value="" class="form-control">
			</div>
			<div class="form-group col-md-12">
				<label>Parent E-mail<span class="red">*</span></label>
                <input type="text" name="parent_email" value="" class="form-control">
				@if ($errors->has('parent_email'))
					<div class="error">{{$errors->first('parent_email')}}</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>How did you hear about us?</label>
                <select name="Txthear" class="form-control">
					<option></option> 
					<option>Referral from a friend</option>
					<option>Search engines</option>
					<option>Link from another website</option>
					<option>Magazine article</option>
					<option>Newspaper</option>
					<option>Other</option>
				</select>
			</div>
			<div class="form-group col-md-12">
				<div>
					<label><h4>2. BASKETBALL EXPERIENCE</h4><br>Have you attended an Advantage Basketball Camps session before?</label>
				</div>
				<label class="radio-inline" for="basketball_exp_1">
					<input type="radio" id="basketball_exp_1" name="basketball_exp" value="Yes"> Yes
				</label>
				<label class="radio-inline" for="basketball_exp_2">
					<input type="radio" id="basketball_exp_2" name="basketball_exp" value="No"> No
				</label>
			</div>
			<div class="form-group col-md-12">
				<label>If yes, where/when</label>
                <input type="text" name="basketball_exp_desc" value="" class="form-control">
			</div>
			<div class="form-group col-md-12">
				<div>
					<label>How woud you rate your basketball skills and abilities?</label>
				</div>
				<label class="radio-inline" for="basketball_skill_1">
					<input type="radio" id="basketball_skill_1" name="basketball_skill" value="Beginner"> Beginner
				</label>
				<label class="radio-inline" for="basketball_skill_2">
					<input type="radio" id="basketball_skill_2" name="basketball_skill" value="Intermediate"> Intermediate
				</label>
				<label class="radio-inline" for="basketball_skill_3">
					<input type="radio" id="basketball_skill_3" name="basketball_skill" value="Advanced"> Advanced
				</label>
			</div>
			<div class="form-group col-md-12">
				<div>
					<label><h4>3. CAMP DETAILS</h4></label>
				</div>
				<label>Camp Name</label>
                <input type="text" name="camp_name" value="" readonly="readonly" class="form-control"><a href="javascript:void(0);" onclick="openPopup();">Select Camp</a>
				@if ($errors->has('camp_name'))
					<div class="error">{{$errors->first('camp_name')}}</div>
				@endif
				<br>
				<label>Camp Details</label>
                <input type="text" name="camp_location" readonly="readonly" class="form-control">
                <input type="text" name="camp_city" readonly="readonly" class="form-control">
                <input type="text" name="camp_state" readonly="readonly" class="form-control">
                <input type="text" name="camp_zip" readonly="readonly" class="form-control">
                <input type="text" name="camp_sdate" readonly="readonly"> - 
                <input type="text" name="camp_edate" readonly="readonly">
			</div>
			<div class="form-group col-md-12">
				<div>
					<label><h4>4. PAYMENT INFORMATION</h4></label>
				</div>
				<label>Payment amount</label>
                <input type="text" name="payment_amount" value="" class="form-control">
				@if ($errors->has('payment_amount'))
					<div class="error">{{$errors->first('payment_amount')}}</div>
				@endif
				<label>Last 4 numbers of the credit card</label>
                <input type="text" name="credit_card_number" class="form-control">
				@if ($errors->has('credit_card_number'))
					<div class="error">{{$errors->first('credit_card_number')}}</div>
				@endif
				<label>Transaction ID</label>
                <input type="text" name="transaction_id" class="form-control">
				@if ($errors->has('transaction_id'))
					<div class="error">{{$errors->first('transaction_id')}}</div>
				@endif
				<label>Payment type</label><br>
                <input id="payment_type" type="radio" name="payment_type" value="Visa"><label for="RadioAttendedYes">Visa</label>&nbsp;&nbsp;&nbsp;
				<input id="payment_type" type="radio" name="payment_type" value="MasterCard"><label for="RadioAttendedNo">MasterCard</label>
				<input id="payment_type" type="radio" name="payment_type" value="AmericanExpress"><label for="RadioAttendedNo">American Express</label>
				 <input id="payment_type" type="radio" name="payment_type" value="Discovercard"><label for="RadioAttendedNo">Discover card</label>				 
				 <input id="payment_type" type="radio" name="payment_type" value="Cheque"><label for="RadioAttendedNo">Cheque</label>
				 <input id="payment_type" type="radio" name="payment_type" value="MoneyOrder"><label for="RadioAttendedNo">Money Order</label>
				 <input id="payment_type" type="radio" name="payment_type" value="Cash"><label for="RadioAttendedNo">Cash</label>
				 <input id="payment_type" type="radio" name="payment_type" value="Scholarship"><label for="RadioAttendedNo">Scholarship</label>				
				<input id="payment_type" type="radio" name="payment_type" value="Other"><label for="RadioAttendedNo">Other</label>
				<input type="hidden" name="cost">
				<input type="hidden" name="new_camp_id">
			</div>
		</div><!-- /.box-body -->
		<div class="box-footer">
            <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> Add</span></button>
		    <a href="{{url('admin/orders')}}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">Cancel</span></a>
		</div><!-- /.box-footer-->
	</div><!-- /.box -->
</form>
	</div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(function () {
	$('#geoCheckbox').change(function () {                
		$('#geo').toggle();
	}).change();
	
	$('#location').submit(function( event ) {
		var errors = 0;
		if($("#geoCheckbox").prop('checked') == true) {
			if($('#geoTemplate').val() == '') {
				$('#geoTemplateError').html('The template text field is required.');
				errors = 1;
			} else {
				$('#geoTemplateError').html('');
			}
			if($('#image').val() == '') {
				$('#imageError').html('The image field is required.');
				errors = 1;
			} else {
				var allowed_extensions = new Array("jpeg","jpg","png","gif");
				var file_extension = $('#image').val().split('.').pop();
				if ($.inArray($('#image').val().split('.').pop().toLowerCase(), allowed_extensions) == -1) {
					$('#imageError').html("Only '.jpeg','.jpg', '.png', '.gif' formats are allowed.");
					errors = 1;
				} else {
					$('#imageError').html('');
				}
			}
			/* if($('#video').val() == '') {
				$('#videoError').html('The video field is required.');
				errors = 1;
			} else {
				$('#videoError').html('');
			} */
			if(errors == 1) {
				return false;
			}
		}
	});
});

function openPopup() {
	window.open("<?php echo url('admin/campList'); ?>");
}
</script>