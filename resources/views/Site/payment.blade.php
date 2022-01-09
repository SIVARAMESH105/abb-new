<style>
h2 {
  text-align: center;
}

table caption {
	padding: .5em 0;
}

@media screen and (max-width: 767px) {
  table caption {
    border-bottom: 1px solid #ddd;
  }
}

.p {
  text-align: center;
  padding-top: 140px;
  font-size: 14px;
}
.error{
	color:red;
}
</style>
@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
					 <h2>Checkout - Step 2 of 3</h2>
						  <div class="row">
							<div class="col-xs-12">
							@if(empty($camp_details) && empty($productVal) && empty($training))
								<a href="{{ url('schedule') }}" class="btn btn-primary" name="Chkoutbottom" style=" margin-bottom: 5px;">Add Camp</a>
								<a href="{{ url('store') }}" class="btn btn-primary" name="Chkoutbottom" style="margin-bottom: 5px;">Add Product</a>
								<label><h3>Your cart is empty.</h3></label>
							</div>
						  </div>
							@else
						  <div class="row">
							<div class="col-xs-12">
							@if(isset($camp_details) && !empty($camp_details))
									<div class="other-info">
										<div class="table-title">
										  <label><h3>Camps</h3></label>
										</div>
										<div class="table-button">
										  <a href="{{ url('schedule') }}" class="btn btn-primary" name="Chkoutbottom" style="margin-bottom: 5px;">ADD ANOTHER CAMP</a>
										</div>
									</div>
								    <div class="table-responsive">
										<table class="table table-bordered">
												<thead>
													<tr>
													  <th>Student</th>
													  <th>Camp Focus</th>
													  <th>Location</th>
													  <th>Date/Time</th>
													  <th>Price</th>
													</tr>
												</thead>
												<tbody>
													@foreach($camp_details as $details)
														<?php 
															$startdate = explode("-", $details->startdate); 
															$Esdate=date("Y-m-j", mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]));
															$today = date("Y-m-d");
															$EarlyBirdDate  =  date("Y-m-d", strtotime ( '-'.$details->EarlyBirdDays.' day' . $Esdate ));
															if($EarlyBirdDate > $today)
																$cost = $details->cost  -$details->EarlyBirdDiscount;
															else
																$cost = $details->cost;
															
															$startdate = $details->startdate;
															$sd = date_parse_from_format("Y-m-d", $startdate);
															$startmonthNum  = $sd["month"];
															$startdateObj   = DateTime::createFromFormat('!m', $startmonthNum);
															$startmonthName = $startdateObj->format('F');
															
															$startDateTime = $details->starttime;
															$startTime = date('h:i A', strtotime($startDateTime));
															
															$enddate = $details->enddate;
															$ed = date_parse_from_format("Y-m-d", $enddate);
															$endmonthNum  = $ed["month"];
															$enddateObj   = DateTime::createFromFormat('!m', $endmonthNum);
															$endmonthName = $enddateObj->format('F');
															
															$endDateTime = $details->endtime;
															$endTime = date('h:i A', strtotime($endDateTime));
														?>
														<tr>
															<td>{{$details->student_name}}</td>
															<td>{{$details->camp_focus}}</td>
															<td>{{$details->Location}}</td>
															<td>{{$startmonthName}} {{ $sd["day"]}} - {{$endmonthName}} {{ $ed["day"]}}, {{$startTime}} to {{$endTime}}</td>
															<td>${{round($cost)}}</td>
														</tr>
													@endforeach
												</tbody>
										</table>
									</div><!--end of .table-responsive-->
									<div class="other-info">
								  		<div class="table-title">
								  			<label class="highlight-label"><span>Total Amount:</span> ${{$total_amount}}</label>
								  		</div>
								  	</div>
							    @endif
								<br>
								<br>
							    @if(isset($productVal) && !empty($productVal))
									<div class="other-info">
										<div class="table-title">
										  <label><h3>Products</h3></label>
										</div>
										<div class="table-button">
										  <a href="{{ url('store') }}" class="btn btn-primary" name="Chkoutbottom" style="margin-bottom: 5px;">ADD ANOTHER PRODUCT</a>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-bordered">
												<thead>
													<tr>
													  <th>Product</th>
													  <th>Size</th>
													  <th>Color</th>
													  <th>Quantity</th>
													  <th>Price</th>
													</tr>
												</thead>
												<tbody>
												<?php $last_cost = 0; ?>
												<?php //echo '<pre>'; print_r($productVal);die; ?>
													@foreach($productVal as $products)
														
														<tr>
															<td>{{$products['pd_name']}}</td>
															<td>{{$products['pro_size']}}</td>
															<td>{{$products['pro_color']}}</td>
															<td>{{$products['pd_qty']}}</td>
															<td>${{$products['pd_price']}}</td>
														</tr>
														<?php $last_cost += $products['pd_price'];?>
													@endforeach
												</tbody>
										</table>
								  	</div><!--end of .table-responsive-->
								  	<div class="other-info">
								  		<div class="table-title">
								  			@php
								  				$shipping_fees = 0;
								  				if(!empty($shipping_charges)) {
								  					$last_cost = $last_cost+$shipping_charges;
								  					$shipping_fees =$shipping_charges;
								  				}
								  			@endphp
								  			<label class="highlight-label"><span>Total Amount:</span> ${{$last_cost}}@if(!empty($shipping_fees)) (included shipping charges: ${{$shipping_fees}})@endif</label>
								  		</div>
								  	</div>
						        @endif
						        @if(isset($training) && !empty($training))
								<form id="UpdateQtyInfo" action="{{url('cart/UpdateQtyInfo')}}" method="post" class="form-horizontal">
									{{ csrf_field() }}
									<div class="other-info">
										<div class="table-title">
											<label><h3>One-on-One</h3></label>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-bordered">
												<thead>
													<tr>
													  <th>Product</th>
													  <th>Mon</th>
													  <th>Tue</th>
													  <th>Wed</th>
													  <th>Thur</th>
													  <th>Price</th>
													</tr>
												</thead>
												<tbody>
												<tr>
													<input type="hidden" name="parent_first_name" value="{{$training['parent_first_name']}}">
													<input type="hidden" name="parent_last_name" value="{{$training['parent_last_name']}}">
													<input type="hidden" name="playername" value="{{$training['playername']}}">
													<input type="hidden" name="gender" value="{{$training['gender']}}">
													<input type="hidden" name="address" value="{{$training['address']}}">
													<input type="hidden" name="city" value="{{$training['city']}}">
													<input type="hidden" name="state" value="{{$training['state']}}">
													<input type="hidden" name="zip_code" value="{{$training['zip_code']}}">
													<input type="hidden" name="team_name" value="{{$training['team_name']}}">
													<input type="hidden" name="user_email" value="{{$training['user_email']}}">
													<td>One-on-One</td>
													<td>
														@if(isset($training['time_mon']))
															@foreach($training['time_mon'] as $day)
																{{$day}},
																<input type="hidden" name="time_mon[]" value="{{$day}}">
															@endforeach
														@endif
													</td>
													<td>
														@if(isset($training['time_tue']))
															@foreach($training['time_tue'] as $day)
																{{$day}},
															<input type="hidden" name="time_tue[]" value="{{$day}}">
															@endforeach
														@endif
													</td>
													<td>
														@if(isset($training['time_wed']))
															@foreach($training['time_wed'] as $day)
																{{$day}},
															<input type="hidden" name="time_wed[]" value="{{$day}}">
															@endforeach
														@endif
													</td>
													<td>
														@if(isset($training['time_thur']))
															@foreach($training['time_thur'] as $day)
																{{$day}},
															<input type="hidden" name="time_thur[]" value="{{$day}}">
															@endforeach
														@endif
													</td>
													<td>@if(isset($total_amount_training)) ${{$total_amount_training}} @endif</td>
												</tr>
												</tbody>
										</table>
									</div>
									<div class="other-info">
										<div class="table-title">
											<label class="highlight-label"><span>Total Amount:</span> @if(isset($total_amount_training)) ${{$total_amount_training}} @endif</label>
										</div>
									</div>
								</div>
							</form>
						  </div><!--end of .table-responsive-->
						@endif
								
								<div class="page-header">
									<h3 class="">Payment Method</h3>      
								</div>
								<input type="hidden" name="camp_total_amount" id="camp_total_amount" value="{{ $total_amount }}">
								<!-- Text input-->
								<form id="PaymentChoose" action="{{url('checkout/paymentConfirmation')}}" method="post" class="form-horizontal">
									{{ csrf_field() }}
									@if(!empty($shipping_fees))
										<input type="hidden" name="shipping_total_amt" value="{{$shipping_fees}}"/>
									@endif
									@if($wallet!='0')
										<div class="page-header">
											@if(!empty($productVal) || !empty($training)) 
												<span class="error">Wallet balance only used for camps registration. Please remove products/training from cart to use wallet balance.</span>
											@endif
											<h3 class="">Use My Wallet Cost</h3>
											<input type="checkbox" name="my_wallet" id="my_wallet" value="{{$wallet}}" @if(!empty($productVal) || !empty($training)) disabled @endif />&nbsp; ${{$wallet}}  
										</div>
									@endif
									<div id="enter_card_details">
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
									</div>
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="submit"></label>
									  <div class="col-md-3 col-sm-6 col-xs-12">
										<button id="submit" name="submit" class="btn btn-primary">Submit</button>
									  </div>
									</div>
								</form>
						@endif
					  </div>
					</div>
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
	<script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
	<script>
		$('#my_wallet').change(function(){
			if(this.checked) {				
				var camp_total_amount = $('#camp_total_amount').val();
				var wallet_amount = $('#my_wallet').val();
				if (wallet_amount > camp_total_amount) {
					$('#enter_card_details').hide();
				} else {
					$('#enter_card_details').show();
				}
			} else {
				$('#enter_card_details').show();
			}
		});
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
</body>
</html>
