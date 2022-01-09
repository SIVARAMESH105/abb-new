@include("Site.header")
<style>
.error{
	color:red;
}
</style>
	<div class="secondary-top">
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
            <div class="container container-md">
                <div class="bg-white-section">
				<?php //echo '<pre>'; print_r($user_details->id);die; ?>
                    <h3 class="text-center">Reset Password</h3>
					<form action="{{url('site/updatePassword')}}" method="POST" name="resetPwdUser" id="resetPwdUser">
						{!! csrf_field() !!}
						<input type="hidden" name="user_id" value="{{$user_details->id}}">
						<p></p>
						<table border="0" align="center" width="450" cellspacing="0" cellpadding="0" background="images/clear.gif">
							<tbody>
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								
								<tr>
									<td width="75" align="right" class="bodytext">
										<label class="col-md-4 control-label">New Password:<span style="color:red;">*</span></label>&nbsp; </span>
									</td>
									<td width="375" class="error-cls">
										<input type="password" class="form-control input-md" name="password" id="password" value="" size="30"  maxlength="50" required>
									</td>
								</tr>
								<tr>
									<td width="75">&nbsp;</td>
									<td width="375">&nbsp;</td>
								</tr>
								<tr>
									<td width="75" align="right" class="bodytext">
										<label class="col-md-4 control-label">Confirm Password:<span style="color:red;">*</span></label>&nbsp; </span>
									</td>
									<td width="375" class="error-cls">
										<input type="password"  class="form-control input-md" name="confirm_password" id="confirm_password" value="" size="30" maxlength="50" required>
									</td>
								</tr>
								<tr>
									<td width="75">&nbsp;</td>
									<td width="375">&nbsp;</td>
								</tr>
								<tr>
									<td width="75" align="right">&nbsp;</td>
									<td width="375" align="right">
										<div align="left">
											<input type="Submit" class="btn btn-primary" name="Send" value="Submit" id="chkpwd">
										</div>
										
									</td>
								</tr>
								
								<tr>
									<td width="75">&nbsp;</td>
									<td width="375">&nbsp;</td>
								</tr>
								
							</tbody>
						</table>
					</form>
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
	<script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
	<script>
		$("#resetPwdUser").validate({
			errorElement: "span",
			errorPlacement: function(error, element) {
				error.appendTo( element.parents(".error-cls"));
			},
			rules: {
				'password': {
				  required: true,
				},
				'confirm_password' :{
					required : true,
				}
			},
			messages:{
				'password': {
				  required: "Please enter password"
				},
				'confirm_password' :{
					required : "Please enter confirm password",
				}
			}
		});
		$("#resetPwdUser").find("button[type='submit']").on("submit",function(e){
			
			if($("#resetPwdUser").valid()) {
				$(this).submit();
			} else {
				return false;
			}
		});
	</script>
	<script>
	$('#chkpwd').click(function(){
		var pwd = $('#password').val();
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
