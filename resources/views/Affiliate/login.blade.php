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
		                    <h3 class="text-center">Affiliate Login </h3>
							<form action="{{url('affliate/doLogin')}}" class="form-horizontal" method="POST" name="loginUser" id="loginUser">
								{!! csrf_field() !!}
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
				  required: "Please enter the email address"
				},
				'password' :{
					required : "Please enter the password",
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
