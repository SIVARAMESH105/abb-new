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
</style>
@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
					 <h2>Checkout - Step 3 of 3</h2>
						  <div class="row">
							<div class="col-xs-12">
								@if(empty($camp_details) && empty($productVal) && empty($training))
									<label><h2>Your Checkout is empty</h2></label>
								@else
							    @if(isset($camp_details) && !empty($camp_details))
									<div class="other-info">
										<div class="table-title">
										  <label><h3>Camps</h3></label>
										</div>
										<div class="table-button">
										  <a href="{{ url('schedule') }}" class="btn btn-primary" name="Chkoutbottom" style=" margin-bottom: 5px;">ADD ANOTHER CAMP</a>
										</div>
									</div>
								  <div class="table-responsive">
									<table  class="table table-bordered">
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
								  <a href="{{ url('store') }}" class="btn btn-primary" name="Chkoutbottom" style=" margin-bottom: 5px;">ADD ANOTHER PRODUCT</a>
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
													<?php $last_cost += $products['pd_price'];?>
												</tr>
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
													<td>One-on-One</td>
													<td>
														@if(isset($training['time_mon']))
															{{implode(',', $training['time_mon'])}}
														@endif
													</td>
													<td>
														@if(isset($training['time_tue']))
															{{implode(',', $training['time_tue'])}}
														@endif
													</td>
													<td>
														@if(isset($training['time_wed']))
															{{implode(',', $training['time_wed'])}}
														@endif
													</td>
													<td>
														@if(isset($training['time_thur']))
															{{implode(',', $training['time_thur'])}}
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
						@else
						<?php $total_amount_training = 0; ?>
						@endif
							<form id="RegisterCamp" action="{{url('checkout/confirmPayement')}}" method="post" class="form-horizontal">
									{{ csrf_field() }}
									<?php 
									if (isset($productVal) && !empty($productVal)) {
										if ($last_cost > 0) {
											$last_cost = $last_cost;
										}else{
											$last_cost = 0;
										}
									}else{
										$last_cost = 0;
									}
									?>
									<?php //echo '<pre>'; echo($total_amount);die;?>
										<?php if(empty($total_amount)){
											$total_amount = 0;
										}?>
										@if(isset($training) && !empty($training))
									<input type="hidden" name="parent_first_name" value="{{$training['parent_first_name']}}">
									<input type="hidden" name="parent_last_name" value="{{$training['parent_last_name']}}">
									<input type="hidden" name="playername" value="{{$training['playername']}}">
									<input type="hidden" name="gender" value="{{$training['gender']}}">
									<input type="hidden" name="gender" value="{{$training['grade_level']}}">
									<input type="hidden" name="address" value="{{$training['address']}}">
									<input type="hidden" name="city" value="{{$training['city']}}">
									<input type="hidden" name="state" value="{{$training['state']}}">
									<input type="hidden" name="zip_code" value="{{$training['zip_code']}}">
									<input type="hidden" name="phone" value="{{$training['phone']}}">
									<input type="hidden" name="team_name" value="{{$training['team_name']}}">
									<input type="hidden" name="user_email" value="{{$training['user_email']}}">
									@if(isset($training['time_mon']))
										<input type="hidden" name="time_mon" value="{{implode(',', $training['time_mon'])}}">
									@else
										<input type="hidden" name="time_mon" value="">
									@endif
									@if(isset($training['time_tue']))
										<input type="hidden" name="time_tue" value="{{implode(',', $training['time_tue'])}}">
									@else
										<input type="hidden" name="time_tue" value="">
									@endif
									@if(isset($training['time_wed']))
										<input type="hidden" name="time_wed" value="{{implode(',', $training['time_wed'])}}">
									@else
										<input type="hidden" name="time_wed" value="">
									@endif
									@if(isset($training['time_thur']))
										<input type="hidden" name="time_thur" value="{{implode(',', $training['time_thur'])}}">
									@else
										<input type="hidden" name="time_thur" value="">
									@endif
									@endif
									@if(isset($amount_before_using_wallet))
										<input type="hidden" name="amount_before_using_wallet" value="{{ $amount_before_using_wallet }}">
									@endif
									<input id="total_amount" name="total_amount" type="hidden" value ="{{$total_amount + $last_cost + $total_amount_training}}" class="form-control input-md">
									<input id="camp_amount" name="camp_amount" type="hidden" value ="{{$total_amount}}" class="form-control input-md">
									<input id="product_amount" name="product_amount" type="hidden" value ="{{$last_cost}}" class="form-control input-md">
									<input id="total_amount_training" name="total_amount_training" type="hidden" value ="{{$total_amount_training}}" class="form-control input-md">
									@if(!empty($shipping_fees))
										<input type="hidden" name="shipping_total_amt" value="{{$shipping_fees}}"/>
									@endif
									
									
									<article class="product-order-summary">
										<div class="page-header">
											<h3>View Order Summary</h3>
										</div>
										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="fn">First Name</label>  
										  <div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
										  {{$billing_details['first_name']}}
										  </div>
										</div>
										<!-- Text input-->
										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="ln">Last Name</label>  
										  <div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
										 {{$billing_details['last_name']}}
										  </div>
										</div>
										
										<!-- Text input-->
										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="ln">Address</label>  
										  <div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
										  {{$billing_details['address']}}
										  </div>
										</div>

										<!-- Text input-->
										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="email">City</label>  
										  <div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
										  {{$billing_details['city']}}
										  </div>
										</div>
										<!-- Text input-->
										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="email">State (OT for "Other")</label>  
											<div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
										  {{$billing_details['state']}}
											</div>
										</div>
										<!-- Text input-->
										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="email">ZIP/Postal Code</label>  
										  <div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
											{{$billing_details['zip_code']}}
										  </div>
										</div>

										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="selectbasic">Country</label>
										  <div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
											{{$billing_details['country']}}
										  </div>
										</div>

										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="city">Email</label>  
										  <div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
											{{$billing_details['email']}}
										  </div>
										</div>

										<!-- Text input-->
										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="zip">Confirm Email</label>  
										  <div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
											{{$billing_details['confirm_email']}}
										  </div>
										</div>

										<!-- Text input-->
										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="add1">Home Phone</label>  
										  <div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
											{{$billing_details['home_phone']}}
										  </div>
										</div>

										<!-- Text input-->
										@if(!empty($billing_details['other_phone']))
										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="add2">Work/Other Phone</label>  
										  <div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
											{{$billing_details['other_phone']}}
										  </div>
										</div>
`										@endif
										<div class="form-group">
										  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12  control-label" for="submit"></label>
										  <div class="col-md-4 col-md-3 col-sm-6 col-xs-12">
											<button id="submit" name="submit" class="btn btn-primary">Submit</button>
										  </div>
										</div>
									</article>
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
</body>
</html>
