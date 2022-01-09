@include("Site.header")
<style>
.error{
	color:red;
}
</style>
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
		<div class="box">
			<div class="box-body table-responsive view-order-table">
			@if (session('status'))          
			<div class="alert alert-success removeonajax">  
			<a class="panel-close close" data-dismiss="alert">&times;</a>                
			{{ session('status') }}
			</div>
			@endif
			@if (session('error'))
				<div class="alert alert-danger removeonajax">
				<a class="panel-close close" data-dismiss="alert">&times;</a>  
					{{ session('error') }}
				</div>
			@endif
				<br>
				<form method="post" id="inviteMdsembers" style="margin-bottom: 200px;">
				{{ csrf_field() }}
				</form>
				<br>
				<br>
				<br>
				<div class="alert alert-success" id="email_succ" style="display:none;"><a class="panel-close close" data-dismiss="alert">&times;</a></div>
				<h3 align="center"><b>Invited Members</b></h3>
				@php
					//echo "<pre>"; print_r($groupInvityDetails); exit;
					$groupId = 0;
					if(count($groupInvityDetails) > 0)
					{
						foreach($groupInvityDetails as $invity)
						{
							if($invity->group_id != $groupId)
							{
								$groupId = $invity->group_id;
								@endphp
								
								<b style="margin-left:10%;">Group Code : {{$invity->group_code}}</b>
								<br>
								<table class="table table-bordered detailTable" style="   margin-top: 15px;">
									<tr>
									<td  class="table-header" id="infoTableHeader"><b>First Name</b></td>
									<td  class="table-header" id="infoTableHeader"><b>Last Name</b></td>
									<td  class="table-header" id="infoTableHeader"><b>Email</b></td>
									<td  class="table-header" id="infoTableHeader"><b>Registered</b></td>
									<td  class="table-header" id="infoTableHeader"><b>Action</b></td>
								</tr>
								@php
							}
							@endphp
								<tr> 
									<td class="labelText">{{$invity->first_name}}</td>
									<td class="labelText">{{$invity->last_name}}</td>
									<td class="labelText">{{$invity->email}}</td>
									<td  class="labelText">@if($invity->register == 1) <img src="{{ asset('public/images/green-check-mark.png') }}" width="12px"> @else <a href="javascript:void(0);" onclick="resendInvite('{{$invity->first_name}}', '{{$invity->last_name}}', '{{$invity->email}}', '{{$invity->group_code}}', '{{$invity->user_name}}', {{$campId}})" id="resend_id">Resend</a> @endif</td>
									<td  class="labelText"><a href="javascript:void(0);" onclick="editInvite('{{$invity->id}}')">Edit</a> | <a href="{{url('user/deleteInvite/'.$invity->group_id.'/'.$invity->id.'/'.$invity->camp_id)}}">Delete</a></td>
								</tr>
								<img src="{{asset('public/images/Loading_icon.gif')}}" style="display:none; margin-left: 45%;" height = "100px" width="150px" id="LoadingImage">
							@php
							if($invity->group_id != $groupId)
							{
								echo '</table><br>';
							}
							$groupId = $invity->group_id;
						}
						echo '</table><br>';
					} else {
						@endphp
							<table width="750" border="1"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
								<tr>
									<td align="center" class="table-header" id="infoTableHeader"><b>First Name</b></td>
									<td align="center" class="table-header" id="infoTableHeader"><b>Last Name</b></td>
									<td align="center" class="table-header" id="infoTableHeader"><b>Email</b></td>
									<td align="center" class="table-header" id="infoTableHeader"><b>Registered</b></td>
								</tr>
								<tr> 
									<td colspan="4" align="center" class="labelText">No invite found for this group</td>
								</tr>
							</table>
							<br>
						@php
					}
				@endphp				
				<p align="center" class="go-back">
					<a href="{{ url('user/userGroups') }}" class="btn btn-primary" name="backForm">Back</a>				
				</p>
			</div>
		</div>
	</div>
</div>
<div class="modal fade " id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit</h4>
        </div>
		<form id="updateGroupInfo" action="{{url('user/updateUserGroup')}}" method="post" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="cur_id" id="cur_id" value="" />
		<input type="hidden" name="group_id" id="group_id" value="" />
        <div class="modal-body">
         	<div class="form-group">
	         	<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">First Name</label>  
				<div class="col-md-3 col-sm-6 col-xs-12  error-cls">
					<input id="firstname" name="firstname" value="{{ old('firstname') }}" type="text" placeholder="name" class="form-control input-md" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Last Name</label>  
				<div class="col-md-3 col-sm-6 col-xs-12  error-cls">
					<input id="lastname" name="lastname" value="{{ old('lastname') }}" type="text" placeholder="name" class="form-control input-md" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Email</label> 
				<div class="col-md-3 col-sm-6 col-xs-12  error-cls">
					<input id="grpemail" name="grpemail" value="{{ old('grpemail') }}" type="text" placeholder="email" class="form-control input-md email-wi" >
				</div>
			</div>
        </div>
        <div class="modal-footer">
          <button id="submit" type="submit" name="submit" class="btn btn-primary">Update</button>
        </div>
		
		</form>
      </div>
	  
      
    </div>
  </div>
  
</div>

<script type="text/javascript">
	function resendInvite(firstName, lastName, email, groupCode, username, campId) {
		var token = $('input[name="_token"]').val();
		document.getElementById('resend_id').style.pointerEvents = 'none';
		url = "<?php echo url('user/resendInvite'); ?>";
		$("#LoadingImage").show();
		var data = { firstName : firstName, lastName : lastName, email : email, groupCode: groupCode, username: username, campId: campId }
		$.ajax({
			type : 'POST',
			url : url,
			headers: {'X-CSRF-TOKEN': token},
			data : data,
			success:function(res) {
				document.getElementById('resend_id').style.pointerEvents = 'auto'; 
				$("#LoadingImage").hide();
				$("#email_succ").html('<a class="panel-close close" data-dismiss="alert">&times;</a>');
				$("#email_succ a").after("Email Sent Successfully");
				document.getElementById('email_succ').style.display = "block";
				setTimeout(function() {
					$('#email_succ').fadeOut();
				}, 5000 );
			}
		});
	}
	function editInvite(id) {
		var token = $('input[name="_token"]').val();
		url = "<?php echo url('user/editInvite'); ?>";
		var data = { id : id}
		$.ajax({
			type : 'POST',
			url : url,
			headers: {'X-CSRF-TOKEN': token},
			data : data,
			success:function(res) {
				$('#cur_id').val(res[0]['id']);
				$('#firstname').val(res[0]['first_name']);
				$('#lastname').val(res[0]['last_name']);
				$('#grpemail').val(res[0]['email']);
				$('#group_id').val(res[0]['group_id']);
				$('#myModal').modal('show');
			}
		});
	}
</script>
@include("Site.features")
@include("Site.footer")
 <script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
<script>
$("#updateGroupInfo").validate({
	errorElement: "span",
	errorPlacement: function(error, element) {
		error.appendTo( element.parents(".error-cls"));
	},
	rules: {
		'firstname': {
		  required: true,
		},
		'lastname' :{
			required : true,
		},
		'grpemail' :{
			required : true,
		}
	},
	messages:{
		'firstname': {
		  required: "Please enter first name"
		},
		'lastname' :{
			required : "Please enter last name",
		},
		'grpemail' :{
			required : "Please enter email",
		}
	}
});
 $("#updateGroupInfo").find("button[type='submit']").on("submit",function(e){
	
	if($("#updateGroupInfo").valid()) { 
		$(this).submit();
	} else {
		return false;
	}
});
</script>
@section('after_styles')

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
@stack('crud_list_styles')
@endsection

@section('after_scripts')


  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection