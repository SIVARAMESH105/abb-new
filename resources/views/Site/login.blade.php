@include("Site.header")
<style>
.error{
	color:red;
}
</style>
	<div class="secondary-top">
			<section class="login-page-section">
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
		            <div class="container container-md search-content">
		                <div class="bg-white-section">
		                    <h3 class="text-center">Login </h3>
							<form action="{{url('user/loginUser')}}" class="form-horizontal" method="POST" name="loginUser" id="loginUser">
								{!! csrf_field() !!}
								<input type="hidden" name="recipient" value="info@advantagebasketball.com">
								<p></p>
								<!-- <table border="0" align="center" width="450" cellspacing="0" cellpadding="0" background="images/clear.gif">
									<tbody>
										<tr>
											<td colspan="2">&nbsp;</td>
										</tr>
										
										<tr>
											<td width="75" align="right" class="bodytext">
												<span class="label_normal">Email <label style="color:red;">*&nbsp;</label></span>
											</td>
											<td width="375" class="error-cls">
												<input type="email" class="form-control input-md" name="email" id="email" value="" size="30"  maxlength="50">
											</td>
										</tr>
										<tr>
											<td width="75">&nbsp;</td>
											<td width="375">&nbsp;</td>
										</tr>
										<tr>
											<td width="75" align="right" class="bodytext">
												<span class="label_normal">Password <label style="color:red;">*&nbsp;</label></span>
											</td>
											<td width="375" class="error-cls">
												<input name="password" class="form-control input-md" type="password" id="address" value="" size="30" maxlength="50">
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
													<input type="Submit" class="btn btn-primary" name="Send" value="Login">
												</div>
												<div align="right">
													<a href="{{url('forgotPassword')}}" >Forgot Password</a>
												</div>
											</td>
										</tr>
										
										<tr>
											<td width="75">&nbsp;</td>
											<td width="375">&nbsp;</td>
										</tr>
										
									</tbody>
								</table> -->
							 	<div class="form-group">
								    <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Email <span class="important">*</span></label>
								    <div class="col-md-3 col-sm-6 col-xs-12">
										<input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Email" class="form-control input-md" required="">
									</div>
							    </div>
							    <div class="form-group">
								    <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Password <span class="important">*</span></label>  
								    <div class="col-md-3 col-sm-6 col-xs-12">
										<input id="password" name="password" type="password" value="{{ old('password') }}" placeholder="Password" class="form-control input-md" required="">
									</div>
							  	</div>
							  	<div class="form-group">
								    <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label"></label>  
								    <div class="col-md-3 col-sm-6 col-xs-12">
								    	<button type="submit" id="submit" name="submit" class="btn btn-primary">SUBMIT</button>
								    	<div class="forgot-password">
								    		<a href="{{url('forgotPassword')}}" >Forgot Password</a>
								    	</div>
								    </div>
							  	</div>
							</form>
		                </div>
		            </div>
		    </section>
    </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
	@php $base_url = \URL::to(''); @endphp
	<script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
	<script>
		$("#loginUser").validate({
			errorElement: "span",
			errorPlacement: function(error, element) {
				error.appendTo( element.parents(".col-xs-12"));
			},
			rules: {
				'email': {
				  required: true,
				},
				'password' :{
					required : true,
				}
			},
			messages:{
				'email': {
				  required: "Please enter email"
				},
				'password' :{
					required : "Please enter password",
				}
			}
		});
		$("#loginUser").find("button[type='submit']").on("submit",function(e){
			
			if($("#loginUser").valid()) {
				$(this).submit();
			} else {
				return false;
			}
		});
	</script>
</body>
</html>
