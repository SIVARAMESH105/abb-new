@include("Site.header")

<style>
.error{
	color:red;
}
body {font-family: "Lato", sans-serif;}

</style>	

<div class="secondary-top edit-profile-spacing ">
	<div class="container container-md search-content">
	@if (session('status'))          
			<div class="alert alert-success">  
				<a class="panel-close close" data-dismiss="alert">&times;</a>                
				{{ session('status') }}
			</div>
	@endif
	@if (session('error'))
		<div class="alert alert-danger">
			<a class="panel-close close" data-dismiss="alert">&times;</a>  
			{{ session('error') }}
		</div>
	@endif          
	  <div class="bg-white-section">
                <div class="row">
	<!-- Nav tabs -->
	<div class="col-xs-12">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
		  <li class="nav-item active">
			<a class="nav-link " id="profile-tab" data-toggle="tab" href="#editprofile" role="tab" aria-controls="editprofile" aria-selected="true">Profile</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="pasword-tab" data-toggle="tab" href="#password-tab" role="tab" aria-controls="password" aria-selected="false">Password</a>
		  </li>
		</ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane active" id="editprofile" role="tabpanel" aria-labelledby="pasword-tab">
		<div id="changeUserProfileTab">
		  <h2>Edit Profile</h2>
		  <form id="changeUserProfile" action="{{url('user/changeUserProfile')}}" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<?php //echo '<pre>'; print_r($UserVal->email);die; ?>
				<fieldset>
				<input type="hidden" id="id" name="id" value="{{$UserVal->id}}"/>
				<!-- Form Name -->
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Name <span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="user_name" name="user_name" type="text" value="{{$UserVal->name}}" placeholder="User name" class="form-control input-md">
					</div>
				</div>

				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Email <span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="user_email" name="user_email" type="email" value="{{$UserVal->email}}" placeholder="Email" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">First name <span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="fname" name="fname" type="text" value="{{$UserVal->fname}}" placeholder="First name" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="gender">Gender <span class="important">*</span></label>
				  <div class="col-md-4 col-sm-6 col-xs-12 error-cls"> 
					<label class="radio-inline" for="gender-0">
					  <input type="radio" name="gender" id="gender-0" value="male" <?php if($UserVal->gender == 'male'){ echo "checked=checked";}  ?>>
					  Male
					</label> 
					<label class="radio-inline" for="gender-1">
					  <input type="radio" name="gender" id="gender-1" value="female" <?php if($UserVal->gender == 'female'){ echo "checked=checked";}  ?>>
					  Female
					</label>
				  </div>
				</div>
				
				<div class="form-group">
					<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Date of brith<span class="important">*</span></label>
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input type="text" id="datepicker" value="{{$UserVal->dob}}" name="dob" class="form-control input-md">
					</div>
					@if ($errors->has('dob'))
						<div class="error">{{$errors->first('dob')}}</div>
					@endif
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Grade <span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="grade" name="grade" type="text" value="{{$UserVal->grade}}" placeholder="Grade" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Parent firstname<span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="parent_firstname" name="parent_firstname" type="text" value="{{$UserVal->parent_firstname}}" placeholder="Parent firstname" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Parent lastname<span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="parent_lastname" name="parent_lastname" type="text" value="{{$UserVal->parent_lastname}}" placeholder="Parent lastname" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Address<span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="address" name="address" type="text" value="{{$UserVal->address}}" placeholder="Address" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">City<span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="city" name="city" type="text" value="{{$UserVal->city}}" placeholder="City" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">State<span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="state" name="state" type="text" value="{{$UserVal->state}}" placeholder="State" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Zip<span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="zip" name="zip" type="text" value="{{$UserVal->zip}}" placeholder="Zip" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Country <span class="important">*</span></label>
				  <div class="col-md-4 col-sm-6 col-xs-12 error-cls">
					<select id="country" name="country" class="form-control input-md" value="{{ old('country') }}" required="">
						<option value="">Select</option>

						@foreach($country_details as $key => $details)
							<option value="{{$key}}" @if($UserVal->country == $key) selected='selected' @endif>{{$details}}</option>
						@endforeach
					</select>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Home phone<span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="home_phone" name="home_phone" type="text" value="{{$UserVal->home_phone}}" placeholder="Home phone" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Parent email<span class="important">*</span></label>  
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
						<input id="parent_email" name="parent_email" type="text" value="{{$UserVal->parent_email}}" placeholder="Parent email" class="form-control input-md">
					</div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="session_before">Have you attended an Advantage Basketball Camps session before? <span class="important">*</span></label>
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls"> 
						<label class="radio-inline" for="session_before-0">
						  <input type="radio" name="session_before" id="session_before-0" value="yes" <?php if($UserVal->basketball_exp=='yes'){ echo "checked=checked";}  ?>>
						  Yes
						</label> 
						<label class="radio-inline" for="session_before-1">
						  <input type="radio" name="session_before" id="session_before-1" value="no" <?php if($UserVal->basketball_exp=='no'){ echo "checked=checked";}  ?>>
						  No
						</label>
					</div>
				</div>
				<div class="form-group if-yes" >
				<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">If yes, city/state, and year</label>  
					  <div class="col-md-4 col-sm-6 col-xs-12 error-cls">
					  <input id="other_session" name="other_session" value="{{$UserVal->basketball_exp_desc}}" type="text" placeholder="" class="form-control input-md" >
					</div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="rating">How woud you rate your basketball skills and abilities? <span class="important">*</span></label>
				  <div class="col-md-4 col-sm-6 col-xs-12 error-cls">
					<label class="radio-inline" for="rating-0">
					  <input type="radio" name="rating" id="rating-0" value="beginner" <?php if($UserVal->basketball_skill=='beginner'){ echo "checked=checked";}  ?>>
						Beginner
					</label> 
					<label class="radio-inline" for="rating-1">
					  <input type="radio" name="rating" id="rating-1" value="intermediate" <?php if($UserVal->basketball_skill=='intermediate'){ echo "checked=checked";}  ?>>
						Intermediate
					</label>
					<label class="radio-inline" for="rating-2">
					  <input type="radio" name="rating" id="rating-2" value="advanced" <?php if($UserVal->basketball_skill=='advanced'){ echo "checked=checked";}  ?>>
						Advanced
					</label>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="submit"></label>
					<div class="col-md-4 col-sm-6 col-xs-12 error-cls">
					<button type="submit" id="submit" name="submit" class="btn btn-primary">SUBMIT</button>
				  </div>
				</div>
				</fieldset>
				</form>
		</div>
      </div>
      <div class="tab-pane" id="password-tab" role="tabpanel" aria-labelledby="password-tab">
          	<div id="changeUserPwdTab">
			  <h2>Change Password</h2>
			    <form id="changeUserPwd" action="{{url('user/changeUserPwd')}}" method="post" class="form-horizontal tab-pane">
					{{ csrf_field() }}
					<?php //echo '<pre>'; print_r($UserVal->email);die; ?>
					<fieldset>
					<input type="hidden" id="id" name="id" value="{{$UserVal->id}}"/>
					<!-- Form Name -->
					<div class="form-group">
					  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Old Password <span class="important">*</span></label>  
					  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
					  <input id="old_password" name="old_password" type="password" value="" placeholder="Old Password" class="form-control input-md">
						
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">New Password <span class="important">*</span></label>  
					  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
					  <input id="new_password" name="new_password" type="password" value="" placeholder="New Password" class="form-control input-md">
						
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Confirm Password <span class="important">*</span></label>  
						<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
							<input id="confirm_password" name="confirm_password" type="password" value="" placeholder="Confirm Password" class="form-control input-md">
						</div>
					</div>
					
					<div class="form-group">
					  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="submit"></label>
					  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
						<button type="submit" id="chkpwd" name="submit" class="btn btn-primary">SUBMIT</button>
					  </div>
					</div>
					</fieldset>
				</form> 
			</div>
      </div>
    </div>
	</div>
	</div>
</div>
</div>
</div>

@include("Site.features")
@include("Site.footer")
<script src="{{ asset('public/js/registercamp.js') }}"></script>
<script src="{{ asset('public/js/jquery-ui.js')}}"></script>
<script>
	$("#datepicker").datepicker({
	  changeMonth: true,//this option for allowing user to select month
	  changeYear: true, //this option for allowing user to select from year range
	  dateFormat: 'yy-mm-dd',
	});
</script>
<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
<script>
	setTimeout(function() {
	 $('.alert-success').fadeOut();
	 $('.alert-danger').fadeOut();
	 $('#name, #email, #msg, #origin').val('')
	}, 5000 );
	
	$("#changeUserProfile").validate({
	errorElement: "span",
	errorPlacement: function(error, element) {
		error.appendTo( element.parents(".error-cls"));
	},
	rules: {
		'user_name': {
		  required: true,
		},
		'user_email' :{
			required : true,
		},
		'fname' :{
			required : true,
		},
		'gender' :{
			required : true,
		},
		'dob' :{
			required : true,
		},
		'grade' :{
			required : true,
		},
		'parent_firstname' :{
			required : true,
		},
		'parent_lastname' :{
			required : true,
		},
		'address' :{
			required : true,
		},
		'city' :{
			required : true,
		},
		'state' :{
			required : true,
		},
		'zip' :{
			required : true,
		},
		'country' :{
			required : true,
		},
		'home_phone' :{
			required : true,
		},
		'parent_email' :{
			required : true,
		},
		'session_before' :{
			required : true,
		},
		'rating' :{
			required : true,
		}
	},
	messages:{
		'user_name': {
		  required: "Please enter user name"
		},
		'user_email' :{
			required : "Please enter email",
		},
		'user_email' :{
			required : "Please enter email",
		},
		'fname' :{
			required : "Please enter first name",
		},
		'gender' :{
			required : "Please choose gender",
		},
		'dob' :{
			required : "Please choose date of birth",
		},
		'grade' :{
			required : "Please enter grade",
		},
		'parent_firstname' :{
			required : "Please enter parent firstname",
		},
		'parent_lastname' :{
			required : "Please enter parent lastname",
		},
		'address' :{
			required : "Please enter address",
		},
		'city' :{
			required : "Please enter city",
		},
		'country' :{
			required : "Please choose country",
		},
		'home_phone' :{
			required : "Please enter home phone",
		},
		'parent_email' :{
			required : "Please enter parent email",
		},
		'session_before' :{
			required : "Please choose session before",
		},
		'rating' :{
			required : "Please choose skills",
		}
	}
});
 $("#changeUserProfile").find("button[type='submit']").on("submit",function(e){
	
	if($("#changeUserProfile").valid()) { 
		$(this).submit();
	} else {
		return false;
	}
});

$("#changeUserPwd").validate({
	errorElement: "span",
	errorPlacement: function(error, element) {
		error.appendTo( element.parents(".error-cls"));
	},
	rules: {
		'old_password': {
		  required: true,
		},
		'new_password' :{
			required : true,
		},
		'confirm_password' :{
			required : true,
		}
	},
	messages:{
		'old_password': {
		  required: "Please enter user old paswword"
		},
		'new_password' :{
			required : "Please enter new paswword",
		},
		'confirm_password' :{
			required : "Please enter confirm paswword",
		}
	}
});
 $("#changeUserPwd").find("button[type='submit']").on("submit",function(e){
	
	if($("#changeUserPwd").valid()) { 
		$(this).submit();
	} else {
		return false;
	}
});
</script>
<script>
$('#chkpwd').click(function(){
	var pwd = $('#new_password').val();
	var con_pwd = $('#confirm_password').val();
	if(pwd == con_pwd){
		return true;
	}else{
		$('#err_msg').remove();
		$('#confirm_password').after("<p style='color:red;' id='err_msg'> Confirm password does not match</p>");
		return false;
	}
});
</script>
</body>
</html>
