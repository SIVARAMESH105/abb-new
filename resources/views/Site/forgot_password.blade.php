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
                    <h3 class="text-center">Forgot Password </h3>
					<form action="{{url('site/forgotPassword')}}" method="POST" name="forgotPassword" id="forgotPassword">
						{!! csrf_field() !!}
						<p></p>
						<table border="0" align="center" width="450" cellspacing="0" cellpadding="0" background="images/clear.gif">
							<tbody>
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								
								<tr>
									<td width="75" align="right" class="bodytext">
										<span class="label_normal">Email <label style="color:red;">*&nbsp;</label></span>
									</td>
									<td width="375" class="error-cls">
										<input type="email" class="form-control input-md" name="email" id="email" value="" size="30"  maxlength="50" required>
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
											<input type="Submit" class="btn btn-primary" name="Send" value="Submit">
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
	@php $base_url = \URL::to(''); @endphp
	<script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
	<script>
		$("#forgotPassword").validate({
			errorElement: "span",
			errorPlacement: function(error, element) {
				error.appendTo( element.parents(".error-cls"));
			},
			rules: {
				'email': {
				  required: true,
				}
			},
			messages:{
				'email': {
				  required: "Please enter email"
				}
			}
		});
		$("#forgotPassword").find("button[type='submit']").on("submit",function(e){
			
			if($("#forgotPassword").valid()) {
				$(this).submit();
			} else {
				return false;
			}
		});
	</script>
	<script>
		setTimeout(function() {
		 $('.alert-success').fadeOut();
		 $('#name, #email, #msg, #origin').val('')
		}, 5000 );
	</script>
</body>
</html>
