@include("Site.header")
<div class="secondary-top">
    <div class="container container-md search-content">
		@if (session('status'))          
		    <div class="alert alert-danger">  
		        <a class="panel-close close" data-dismiss="alert">&times;</a>                
		        {{ session('status') }}
		    </div>
		@endif
       	<div class="bg-white-section">
			<div class="page-header">
				<h3 class="">Refund Method</h3>      
			</div>
			<!-- Text input-->
			<form id="PaymentChoose" action="{{url('refund/paymentRefund')}}" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="camp-id" id="camp-id" value="{{$campid}}"/>
                <input type="hidden" name="roster-id" id="roster-id" value="{{$rosterid}}"/>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="selectbasic">Card Type:</label>
				  <div class="col-md-3 col-sm-6 col-xs-12 error-cls three-radio-wrap">
						<label class="radio-inline" for="master">
						<input class="radio" type="radio" id="master" name="payment_type" value="master"/> <span>Master card</span>
						</label>
						<label class="radio-inline" for="ppal">
						<input class="radio" type="radio" id="ppal" name="payment_type" value="ppal"/> <span>Visa</span>
						</label>
						<label class="radio-inline" for="discover">
						<input class="radio" type="radio" id="discover" name="payment_type" value="discover"/> <span>Discover</span>
						</label>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Card or Account Number:</label>  
				  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
					<input id="first_name" name="card_no" maxlength="16" minlength="16" type="text" placeholder="Card No" class="form-control input-md">
					
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Verification Number </label>  
				  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
				  <input id="last_name" name="cvv" type="password" placeholder="CVV" class="form-control input-md">
					
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="ln">Expiration Date</label>  
				  <div class="col-md-3 col-sm-6 col-xs-12 ">
					  <div class="row">
					  	<div class="col-md-6 col-xs-4 error-cls">
					  		<select class="form-control input-sm " name="month">
								<option value="">MM
								</option>
								<option value="1">01
								</option>
								<option value="2">02
								</option>
								<option value="3">03
								</option>
								<option value="4">04
								</option>
								<option value="5">05
								</option>
								<option value="6">06
								</option>
								<option value="7">07
								</option>
								<option value="8">08
								</option>
								<option value="9">09
								</option>
								<option value="10">10
								</option>
								<option value="11">11
								</option>
								<option value="12">12
								</option>
					  		</select>
					  	</div>
					  	<div class="col-md-6 col-xs-4 error-cls">
					  		<select class="form-control input-sm" name="year">
								<option value="">YYYY
								</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
								<option value="2019">2019</option>
								<option value="2020">2020</option>
								<option value="2021">2021</option>
								<option value="2022">2022</option>
								<option value="2023">2023</option>
								<option value="2024">2024</option>
								<option value="2025">2025</option>
								<option value="2026">2026</option>
								<option value="2027">2027</option>
								<option value="2028">2028</option>
								<option value="2029">2029</option>
								<option value="2030">2030</option>
							</select>
					  	</div>

					  </div>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="submit"></label>
				  <div class="col-md-3 col-sm-6 col-xs-12">
					<button id="submit" name="submit" class="btn btn-primary">Submit</button>
				  </div>
				</div>
			</form>
		</div>
	</div>
</div>
@include("Site.features")
@include("Site.footer")
	<script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
	<script>
	$("#PaymentChoose").validate({
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.appendTo( element.parents(".error-cls"));
        },
        rules: {
            'payment_type': {
              required: true,
            },
            'card_no' :{
                required : true,
            }, 
            'cvv' :{
                required : true,
            }, 
            'month' :{
                required : true,
            }, 
            'year' :{
                required : true,
            }
        },
        messages:{
            'payment_type': {
              required: "Please choose payment type"
            },
            'card_no' :{
                required : "Please enter card number",
            }, 
            'cvv' :{
                required : "Please enter cvv",
            }, 
            'month' :{
                required : "Please select month",
            }, 
            'year' :{
                required : "Please select year",
            }
        }
    });
	 $("#PaymentChoose").find("button[type='submit']").on("submit",function(e){
        
        if($("#PaymentChoose").valid()) { 
            $(this).submit();
        } else {
            return false;
        }
    });
	</script>