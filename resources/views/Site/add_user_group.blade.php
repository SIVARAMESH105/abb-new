@include("Site.header")
<div class="secondary-top">
<style>
.error{
	color:red;
}
</style>
<div class="container container-md">
	<div class="row">
		<div class="col-md-12">
			<h1>Add Group</h1>    
			<form id="addGroupInfo" action="{{url('user/inviteUserGroup')}}" method="post" class="mt-30">
				{{ csrf_field() }}
				<div class="form-group row error-cls">
				  <label class="col-md-3 col-sm-3 control-label" for="selectbasic">Camp</label>
				  <div class="col-md-6 col-sm-4">
					<select id="group_camp" name="group_camp" value="{{ old('group_camp') }}" class="form-control input-md" >
						<option value="">Select</option>
						@foreach($campDetails as $details)
							<option value="{{$details->c_id}}">{{$details->camp_focus}}-{{$details->City}}</option>
						@endforeach
					</select>
				  </div>
				</div>
				
				<div class="create-groups" >
					
					<!--<div class="form-group create-group">
						<label class="col-md-2 control-label" for="add2">First Name</label>  
						<div class="col-md-2 error-cls">
							<input id="username1" name="username[]" value="{{ old('username') }}" type="text" placeholder="First Name" class="form-control input-md" >
						</div>
						<label class="col-md-2 control-label" for="add2">Last Name</label>  
						<div class="col-md-2 error-cls">
							<input id="lastname1" name="lastname[]" value="{{ old('lastname') }}" type="text" placeholder="Last Name" class="form-control input-md" >
						</div>
						<label class="col-md-2 control-label" for="add2">Email</label> 
						<div class="col-md-2 error-cls">
							<input id="grpemail1" name="grpemail[]" value="{{ old('grpemail') }}" type="text" placeholder="Email" class="form-control input-md" >
						</div>
						<div class="form-group btn btn-default first-btn" style="display:none;" onclick="removeInv(this)">Remove
						</div>
					</div>-->
					
					<div id="collapseOne" aria-labelledby="headingOne">
						<div class="create-group-mobile">
							<div class="row create-group ">
								<div class="col-sm-3 mb-20">
									<div class="form-group row">
										<label class="col-md-12	control-label" for="add2">First Name</label>  
										<div class="col-md-12 input-wrap error-cls">
											<input id="username1" name="username[]" value="{{ old('username') }}" type="text" placeholder="First Name" class="form-control input-md" >
										</div>
									</div>
								</div>
								<div class="col-sm-3 mb-20">
									<div class="form-group row">
										<label class="col-md-12  control-label" for="add2">Last Name</label>  
										<div class="col-md-12 input-wrap error-cls">
											<input id="lastname1" name="lastname[]" value="{{ old('lastname') }}" type="text" placeholder="Last Name" class="form-control input-md" >
										</div>
									</div>
								</div>
								<div class="col-sm-3 mb-20">
									<div class="form-group row">
										<label class="col-md-12 control-label" for="add2">Email</label> 
										<div class="col-md-12 input-wrap error-cls">
											<input id="grpemail1" name="grpemail[]" value="{{ old('grpemail') }}" type="email" placeholder="Email" class="form-control input-md" >
										</div>
									</div>
								</div>
								<div class="col-sm-3 remove-mobile">
									<div class="form-group row">
										<label for="" class="col-md-12 control-label"></label>
										<div class="col-md-12 input-wrap">
											<div class="btn btn-default remove-camp" onclick="removeInv(this)" style="display:none;">Remove</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group add-another-row text-right mb-20">
					<div class="row">
					  <div class="col-md-12 text-right">
						<input type="hidden" id="chk_inv" value="0">
						<a href="javascript:void(0)" class="btn btn-primary add_inv" id="add_inv" >Add</a>
						<button id="submit" type="submit" name="submit" class="btn btn-primary">Submit</button>
					  </div>	
					</div>
				</div>
			</form>		
		</div>
	</div>
</div>
</div>
@include("Site.features")
@include("Site.footer")
 
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
$("#addGroupInfo").validate({
	errorElement: "span",
	errorPlacement: function(error, element) {
		error.appendTo( element.parents(".error-cls"));
	},
	rules: {
		'group_camp': {
		  required: true,
		},
		'username[]' :{
			required : true,
		},
		'lastname[]' :{
			required : true,
		},
		'grpemail[]' :{
			required : true,
		}
	},
	messages:{
		'group_camp': {
		  required: "Please choose camp"
		},
		'username[]' :{
			required : "Please enter firstname",
		},
		'lastname[]' :{
			required : "Please enter lastname",
		},
		'grpemail[]' :{
			required : "Please enter email",
		}
	}
});
$("#addGroupInfo").find("button[type='submit']").on("submit",function(e){
	
	if($("#addGroupInfo").valid()) {
		$(this).submit();
	} else {
		return false;
	}
});

$(document).ready(function(){
	$(".add_inv").click(function () {
		var val = $('#chk_inv').val();
		var count_val = parseInt(val) + 1;
		$('#chk_inv').val(count_val);
		var last_val = $('#chk_inv').val();
		if (last_val <= 5) {
			$(".create-group:last").clone().insertBefore(".create-group:last");
			$(".create-group:last").find('div.error-cls').find('input').val('');
			if($(".create-group:last").find('div.remove-camp').length){	
				$(".create-group:last").find('div.remove-camp').remove();
				$('.create-group:last').append('<div class="btn btn-default remove-camp" onclick="removeInv(this)">Remove\
							</div>');
			}
			return true;
		} else {
			var val = $('#chk_inv').val();
			var count_val = parseInt(val) - 1;
			$('#chk_inv').val(count_val);
			alert('maximum exists !');
			return false;
		}
	});
});

function removeInv(eve) {
	var val = $('#chk_inv').val();
	var count_val = parseInt(val) - 1;
	$('#chk_inv').val(count_val);
	$(eve).parent('div').remove();
}

</script>


<?php //echo 'fd';die; ?>

