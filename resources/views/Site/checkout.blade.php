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
@if (session('status'))          
	<div class="alert alert-success">  
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
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
						<h1>Checkout - Step 1 of 3</h1>
						@if(empty($camp_details) && empty($productVal) && empty($training))
						<a href="{{ url('schedule') }}" class="btn btn-primary" name="Chkoutbottom" style="margin-bottom: 5px;">Add Camp</a>
						<a href="{{ url('store') }}" class="btn btn-primary" name="Chkoutbottom" style="margin-bottom: 5px;">Add Product</a>
						<label><h3>Your cart is empty.</h3></label>
					@else
						  <div class="row">
							<div class="col-xs-12">
							@if(isset($camp_details) && !empty($camp_details))
								<div class="other-info">
									<div class="table-title">
										<label><h2>Camps</h2></label>
									</div>
									<div class="table-button">	
										<a href="{{ url('schedule') }}" class="btn btn-primary" name="Chkoutbottom" style="margin-bottom: 5px;">ADD ANOTHER CAMP</a>
										<a href="{{ url('store') }}" class="btn btn-primary" name="Chkoutbottom" style="margin-left: 54%; margin-bottom: 5px;">RETURN TO PRODUCT STORE</a>
									</div>
								</div>
								<div class="table-responsive">
									<table summary="This table shows how to create responsive tables using Bootstrap's default functionality" class="table table-bordered table-hover">
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
									<label><h2>Products</h2></label>
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
										<?php //echo '<pre>'; print_r($productVal);die; 
											$last_cost = 0;?>
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
									<label class="highlight-label"><span>Total Amount:</span> ${{$last_cost}}</label>
						    	</div>
						    </div>
						    @endif
						    @if(isset($training) && !empty($training))
								<form id="UpdateQtyInfo" action="{{url('checkout/paymentChoose')}}" method="post" class="form-horizontal">
									{{ csrf_field() }}
									<div class="other-info">
										<div class="table-title">
											<label><h2>One-on-One</h2></label>
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
						@endif
					        @if(!empty($camp_details))
							<div class="page-header">
								<h1 class="">Billing Information</h1>      
							</div>
								<!-- Text input-->
									<form id="BillingInfo" action="{{url('checkout/paymentChoose')}}" method="post" class="form-horizontal">
									{{ csrf_field() }}
									
									<div class="form-group ">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">First Name <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
										<input id="first_name" name="first_name" value="@if(old('first_name')){{old('first_name')}}@else{{$billing_val->name}}@endif" type="text" placeholder="First name" class="form-control input-md">
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Last Name <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="last_name" name="last_name" value="@if(old('last_name')){{old('last_name')}}@else{{$billing_val->fname}}@endif" type="text" placeholder="Last name" class="form-control input-md" >
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Address<span class="important">*</span></label>
										<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
											<input id="address" name="address" value="@if(old('address')){{old('address')}}@else{{$billing_val->address}}@endif" type="text" placeholder="Address" class="form-control input-md">
										</div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									 <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">City<span class="important">*</span></label>
										<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
											<input id="city" name="city" value="@if(old('city')){{old('city')}}@else{{$billing_val->city}}@endif" type="text" placeholder="City" class="form-control input-md">
										</div>
									</div>
									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">State (OT for "Other")<span class="important">*</span></label>
										<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
											<input id="state" name="state" value="@if(old('state')){{old('state')}}@else{{$billing_val->state}}@endif" type="text" placeholder="State" class="form-control input-md" >
										</div>
									</div>
									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">ZIP/Postal Code<span class="important">*</span></label>
										<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
											<input id="zip_code" name="zip_code" value="@if(old('zip_code')){{old('zip_code')}}@else{{$billing_val->zip}}@endif" type="text" placeholder="ZIP/Postal Code" class="form-control input-md" >
										</div>
									</div>

									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Country<span class="important">*</span></label>
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
										<select id="country" name="country" value="{{ old('country') }}" class="form-control input-md" >
											<option value="">Select</option>
											@foreach($country_details as $key => $details)
												<option value="{{$key}}" @if($billing_val->country == $key) selected='selected' @endif>{{$details}}</option>
											@endforeach
										</select>
									  </div>
									</div>

									<div class="form-group">
									   <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Email<span class="important">*</span></label>
										<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
											<input id="email" name="email" value="@if(old('email')){{old('email')}}@else{{$billing_val->parent_email}}@endif" type="email" placeholder="Parent Email" class="form-control input-md" >
										</div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Confirm Email<span class="important">*</span></label>
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="confirm_email" name="confirm_email" value="{{old('confirm_email')}}" type="text" placeholder="Confirm E-mail" class="form-control input-md" >
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
										<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Home Phone<span class="important">*</span></label>									  
										<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
											<input id="home_phone" name="home_phone" value="@if(old('home_phone')){{old('home_phone')}}@else{{$billing_val->home_phone}}@endif" type="text" placeholder="Home Phone" class="form-control input-md">
										</div>
									</div>

									<!-- Text input-->
									<div class="form-group">
										<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Work/Other Phone</label>
										<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
											<input id="other_phone" name="other_phone" value="@if(old('work_phone')){{old('work_phone')}}@else{{$billing_val->work_phone}}@endif" type="text" placeholder="Work Phone" class="form-control input-md">
										</div>
									</div>
								@if(!empty($productVal))
									<div class="page-header ">
									<h1 class="">Shipping Information</h1>      
									</div>
									
									<div class="form-group same-as-address">
										<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Same as shipping information</label>  
										<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
											<input type="checkbox" value="0" name="same_ship_adr" id="same_ship_adr" >
										</div>
									</div>
									
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">First Name <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
										<input id="first_name" name="txtShippingFirstName" value="{{old('txtShippingFirstName')}}" type="text" placeholder="First name" class="form-control input-md">
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Last Name <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="last_name" name="txtShippingLastName" value="{{old('txtShippingLastName')}}" type="text" placeholder="Last name" class="form-control input-md" >
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Address <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="address" name="txtShippingAddress1" value="{{old('txtShippingAddress1')}}" type="text" placeholder="Address" class="form-control input-md">
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">City <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="city" name="txtShippingCity" value="{{old('txtShippingCity')}}" type="text" placeholder="City" class="form-control input-md">
										
									  </div>
									</div>
									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="state">State (OT for "Other") <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="state" name="txtShippingState" value="{{old('txtShippingState')}}" type="text" placeholder="State" class="form-control input-md" >
										
									  </div>
									</div>
									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip_code">ZIP/Postal Code <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="zip_code" name="txtShippingPostalCode" value="{{old('txtShippingPostalCode')}}" type="text" placeholder="ZIP/Postal Code" class="form-control input-md" >
										
									  </div>
									</div>

									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Country <span class="important">*</span></label>
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
										<select id="txtShippingCountry" name="txtShippingCountry" value="{{old('txtShippingCountry')}}" class="form-control input-md" >
											<option value="">Select</option>
											@foreach($country_details as $key => $details)
												<option value="{{$key}}">{{$details}}</option>
											@endforeach
										</select>
									  </div>
									</div>


									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add1">Home Phone <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="txtShippingPhone" name="txtShippingPhone" value="{{old('txtShippingPhone')}}" type="text" placeholder="Home Phone" class="form-control input-md">
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Work/Other Phone</label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="txtShippingWorkPhone" name="txtShippingWorkPhone" value="{{old('txtShippingWorkPhone')}}" type="text" placeholder="Work Phone" class="form-control input-md">
										
									  </div>
									</div>
									@endif
								@endif	
								@if(isset($productVal) && !empty($productVal) && empty($camp_details) || isset($training) && !empty($training))
								<div class="page-header">
									<h1 class="">Billing Information</h1>      
								</div>
								<!-- Text input-->
								<form id="BillingInfo" action="{{url('checkout/paymentChoose')}}" method="post" class="form-horizontal">
								{{ csrf_field() }}
									
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">First Name <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
										<input id="first_name" name="first_name" value="{{old('first_name')}}" type="text" placeholder="First name" class="form-control input-md">
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Last Name <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="last_name" name="last_name" value="{{old('last_name')}}" type="text" placeholder="Last name" class="form-control input-md" >
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Address <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="address" name="address" value="{{old('address')}}" type="text" placeholder="Address" class="form-control input-md">
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">City <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="city" name="city" value="{{old('city')}}" type="text" placeholder="City" class="form-control input-md">
									  </div>
									</div>
									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="state">State (OT for "Other") <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="state" name="state" value="{{old('state')}}" type="text" placeholder="State" class="form-control input-md" >
									  </div>
									</div>
									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip_code">ZIP/Postal Code <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="zip_code" name="zip_code" value="{{old('zip_code')}}" type="text" placeholder="ZIP/Postal Code" class="form-control input-md" >
										
									  </div>
									</div>

									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Country <span class="important">*</span></label>
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
										<select id="country" name="country" value="{{old('country')}}" class="form-control input-md" >
											<option value="">Select</option>
											@foreach($country_details as $key => $details)
												<option value="{{$key}}">{{$details}}</option>
											@endforeach
										</select>
									  </div>
									</div>

									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="email">Email <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="email" name="email" value="{{old('email')}}" type="email" placeholder="Parent Email" class="form-control input-md" >
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Confirm Email <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="confirm_email" name="confirm_email" value="{{old('confirm_email')}}" type="text" placeholder="Confirm E-mail" class="form-control input-md" >
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add1">Home Phone <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="home_phone" name="home_phone" value="{{old('home_phone')}}" type="text" placeholder="Home Phone" class="form-control input-md">
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Work/Other Phone</label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="other_phone" name="other_phone" value="{{old('other_phone')}}" type="text" placeholder="Work Phone" class="form-control input-md">
									  </div>
									</div>
									
									<div class="page-header ">
									<h1 class="">Shipping Information</h1>      
									</div>
									
									<div class="form-group same-as-address">
										<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Same as shipping information</label>  
										<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
											<input type="checkbox" value="0" name="same_ship_adr" id="same_ship_adr" >
										</div>
									</div>
									
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">First Name <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
										<input id="first_name" name="txtShippingFirstName" value="{{old('txtShippingFirstName')}}" type="text" placeholder="First name" class="form-control input-md">
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Last Name <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="last_name" name="txtShippingLastName" value="{{old('txtShippingLastName')}}" type="text" placeholder="Last name" class="form-control input-md" >
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Address <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="address" name="txtShippingAddress1" value="{{old('txtShippingAddress1')}}" type="text" placeholder="Address" class="form-control input-md">
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">City <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="city" name="txtShippingCity" value="{{old('txtShippingCity')}}" type="text" placeholder="City" class="form-control input-md">
										
									  </div>
									</div>
									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="state">State (OT for "Other") <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="state" name="txtShippingState" value="{{old('txtShippingState')}}" type="text" placeholder="State" class="form-control input-md" >
										
									  </div>
									</div>
									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip_code">ZIP/Postal Code <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="zip_code" name="txtShippingPostalCode" value="{{old('txtShippingPostalCode')}}" type="text" placeholder="ZIP/Postal Code" class="form-control input-md" >
										
									  </div>
									</div>

									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Country <span class="important">*</span></label>
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
										<select id="txtShippingCountry" name="txtShippingCountry" value="{{old('txtShippingCountry')}}" class="form-control input-md" >
											<option value="">Select</option>
											@foreach($country_details as $key => $details)
												<option value="{{$key}}">{{$details}}</option>
											@endforeach
										</select>
									  </div>
									</div>


									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add1">Home Phone <span class="important">*</span></label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="txtShippingPhone" name="txtShippingPhone" value="{{old('txtShippingPhone')}}" type="text" placeholder="Home Phone" class="form-control input-md">
										
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group ship_adr">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Work/Other Phone</label>  
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
									  <input id="txtShippingWorkPhone" name="txtShippingWorkPhone" value="{{old('txtShippingWorkPhone')}}" type="text" placeholder="Work Phone" class="form-control input-md">
										
									  </div>
									</div>
									@endif
									
									@if(isset($camp_details) && !empty($camp_details))
									<div class="page-header">
									<h1 class="">Group Information</h1>      
									</div>
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Camp</label>
									  <div class="col-md-3 col-sm-6 col-xs-12 error-cls">
										<select id="group_camp" name="group_camp" value="{{old('group_camp')}}" class="form-control input-md" >
											<option value="">Select</option>
											@foreach($camp_details as $details)
												<option value="{{$details->id}}">{{$details->camp_focus}}-{{$details->City}}</option>
											@endforeach
										</select>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Group Code</label>  
										<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
											<input id="group_code" name="group_code" type="text" placeholder="Group Code" class="form-control input-md">
										</div>
									</div>
									
									<div class="form-group error-cls">
										<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Create Group</label>  
										<div class="col-md-3 col-sm-6 col-xs-12">
											<input type="checkbox" value="0" name="grpchk" id="grpchk" >
										</div>
									</div>

									<div class="create-groups" style="display: none;">
										<!--<div class="show-form">
											<a data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
									          <i class="fa fa-chevron-circle-down"></i> Create Group
									        </a>
										</div>-->
										<!--class="collapse"-->
								        <div id="collapseOne"  role="tabpanel" aria-labelledby="headingOne">
									    	<div class="panel-body">
									        	<div class="create-group-mobile">
													<div class="row create-group">
														<div class="col-md-11">
															<div class="form-group">
																<label class="col-md-2 col-sm-4 control-label" for="add2">First Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="username1" name="username[]" value="" type="text" placeholder="First Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Last Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="lastname1" name="lastname[]" value="" type="text" placeholder="Last Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Email</label> 
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="grpemail1" name="grpemail[]" value="" type="email" placeholder="Email" class="form-control input-md" >
																</div>
															</div>
														</div>
														<div class="col-md-1 col-sm-10 remove-mobile">
															<div class="btn btn-default first-btn remove-camp" style="display:none;" onclick="removeInv(this)">Remove
															</div>
														</div>
													</div>
													<div class="row create-group">
														<div class="col-md-11">
															<div class="form-group">
																<label class="col-md-2 col-sm-4 control-label" for="add2">First Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="username2" name="username[]" value="" type="text" placeholder="First Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Last Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="lastname2" name="lastname[]" value="" type="text" placeholder="Last Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Email</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="grpemail2" name="grpemail[]" value="" type="email" placeholder="Email" class="form-control input-md" >
																</div>
															</div>
														</div>
														<div class="col-md-1 col-sm-10 remove-mobile">
															<div class="btn btn-default remove-camp" onclick="removeInv(this)">Remove
															</div>
														</div>
													</div>
													<div class="row create-group">
														<div class="col-md-11">
															<div class="form-group">
																<label class="col-md-2 col-sm-4 control-label" for="add2">First Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="username3" name="username[]" value="" type="text" placeholder="First Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Last Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="lastname3" name="lastname[]" value="" type="text" placeholder="Last Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Email</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="grpemail3" name="grpemail[]" value="" type="email" placeholder="Email" class="form-control input-md" >
																</div>
															</div>
														</div>
														<div class="col-md-1 col-sm-10 remove-mobile">
															<div class="btn btn-default remove-camp" onclick="removeInv(this)">Remove</div>
														</div>
													</div>
													<div class="row create-group">
														<div class="col-md-11">
															<div class="form-group">
																<label class="col-md-2 col-sm-4 control-label" for="add2">First Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="username4" name="username[]" value="" type="text" placeholder="First Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Last Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="lastname4" name="lastname[]" value="" type="text" placeholder="Last Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Email</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="grpemail4" name="grpemail[]" value="" type="email" placeholder="Email" class="form-control input-md" >
																</div>
															</div>
														</div>
														<div class="col-md-1 col-sm-10 remove-mobile">
															<div class="btn btn-default remove-camp" onclick="removeInv(this)">Remove</div>
														</div>
													</div>
													<div class="row create-group">
														<div class="col-md-11">
															<div class="form-group">
																<label class="col-md-2 col-sm-4 control-label" for="add2">First Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="username5" name="username[]" value="" type="text" placeholder="First Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Last Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="lastname5" name="lastname[]" value="" type="text" placeholder="Last Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Email</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="grpemail5" name="grpemail[]" value="" type="email" placeholder="Email" class="form-control input-md" >
																</div>
															</div>
														</div>
														<div class="col-md-1 col-sm-10 remove-mobile">
															<div class="btn btn-default remove-camp" onclick="removeInv(this)">Remove</div>
														</div>
													</div>
													<div class="row create-group">
														<div class="col-md-11">
															<div class="form-group">
																<label class="col-md-2 col-sm-4 control-label" for="add2">First Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="username6" name="username[]" value="" type="text" placeholder="First Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Last Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="lastname6" name="lastname[]" value="" type="text" placeholder="Last Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Email</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="grpemail6" name="grpemail[]" value="" type="email" placeholder="Email" class="form-control input-md" >
																</div>
															</div>
														</div>
														<div class="col-md-1 col-sm-10 remove-mobile">
															<div class="btn btn-default remove-camp" onclick="removeInv(this)">Remove</div>
														</div>
													</div>
													<div class="row create-group">
														<div class="col-md-11">
															<div class="form-group">
																<label class="col-md-2 col-sm-4 control-label" for="add2">First Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="username7" name="username[]" value="" type="text" placeholder="First Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Last Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="lastname7" name="lastname[]" value="" type="text" placeholder="Last Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Email</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="grpemail7" name="grpemail[]" value="" type="email" placeholder="Email" class="form-control input-md" >
																</div>
															</div>
														</div>
														<div class="col-md-1 col-sm-10 remove-mobile">
															<div class="btn btn-default remove-camp" onclick="removeInv(this)">Remove</div>
														</div>
													</div>
													<div class="row create-group">
														<div class="col-md-11">
															<div class="form-group">
																<label class="col-md-2 col-sm-4 control-label" for="add2">First Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="username8" name="username[]" value="" type="text" placeholder="First Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Last Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="lastname8" name="lastname[]" value="" type="text" placeholder="Last Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Email</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="grpemail8" name="grpemail[]" value="" type="email" placeholder="Email" class="form-control input-md" >
																</div>
															</div>
														</div>
														<div class="col-md-1 col-sm-10 remove-mobile">
															<div class="btn btn-default remove-camp" onclick="removeInv(this)">Remove</div>
														</div>
													</div>													
													<div class="row create-group">
														<div class="col-md-11">
															<div class="form-group">
																<label class="col-md-2 col-sm-4 control-label" for="add2">First Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="username9" name="username[]" value="" type="text" placeholder="First Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Last Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="lastname9" name="lastname[]" value="" type="text" placeholder="Last Name" class="form-control input-md">
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Email</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="grpemail9" name="grpemail[]" value="" type="email" placeholder="Email" class="form-control input-md" >
																</div>
															</div>
														</div>
														<div class="col-md-1 col-sm-10 remove-mobile">
															<div class="btn btn-default remove-camp" onclick="removeInv(this)">Remove</div>
														</div>
													</div>
													<div class="row create-group">
														<div class="col-md-11">
															<div class="form-group" id="create_group">
																<label class="col-md-2 col-sm-4 control-label" for="add2">First Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="username10" name="username[]" value="" type="text" placeholder="First Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Last Name</label>  
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="lastname10" name="lastname[]" value="" type="text" placeholder="Last Name" class="form-control input-md" >
																</div>
																<label class="col-md-2 col-sm-4 control-label" for="add2">Email</label>
																<div class="col-md-2 col-sm-6 input-wrap error-cls">
																	<input id="grpemail10" name="grpemail[]" value="" type="email" placeholder="Email" class="form-control input-md">
																</div>
															</div>
														</div>
														<div class="col-md-1 col-sm-10 remove-mobile">
															<div class="btn btn-default remove-camp" onclick="removeInv(this)">Remove</div>
														</div>
													</div>
												</div>
								     	    </div>
									    </div>
										<div class="row add-another-row">
											<div class="col-md-12">
												<input type="hidden" id="chk_inv" value="0">
												<a href="javascript:void(0)" class="btn btn-primary add_inv" id="add_inv" >Add</a>
											</div>
										</div>
									</div>
									@endif
									<div class="form-group">
									  <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="submit"></label>
									  <div class="col-md-3 col-sm-6 col-xs-12">
										<button id="submit" type="submit" name="submit" class="btn btn-primary">PROCEED >></button>
									  </div>
									</div>
								</form>
							</div>
						
					</div>
					@endif
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
	<script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
	<script>
		
		$('#group_code').on('input', function() {
			if ($('#group_code').val() !=''){
				$('#grpchk').val('160').prop('disabled', true);
				
			} else {
				$("#grpchk").removeAttr("disabled");
				
			}
		});
		
		$("#grpchk").click(function () {
			$('#err_msg').remove();
			if ($('#grpchk').is(':checked')) {
				if($("#group_camp").val() == ''){
					$('#group_camp').after("<p style='color:red;' id='err_msg'> Please choose camp</p>");
					return false;
				}
				if($('#group_code').is(':enabled')) { 
					$('#group_code-error').remove();
				}
				$('#grpchk').val(1);
				$('#group_code').val('');
				$("#group_code" ).prop( "disabled", true );
				$("#group_camp").prop('required',true);
				$(".create-groups" ).show();
			}else{
				$('#grpchk').val(0);
				$( "#group_code" ).prop( "disabled", false );
				$("#group_camp").prop('required',false);
				$( ".create-groups" ).hide();
			}
		});
	</script>
	<script>
		setTimeout(function() {
		 $('.alert-success').fadeOut();
		 $('#name, #msg, #origin').val('')
		}, 5000 );
		
		$("#same_ship_adr").change( function() {
			  if ( $(this).is(":checked") ) {
				$("#same_ship_adr").val(1);
				$('.ship_adr').hide();
			  } else if ( $(this).not(":checked") ) {
				$("#same_ship_adr").val(0);
				$('.ship_adr').show();
				$(".ship_adr").prop('required',true);
			  }
		});
		
		$("#group_code").change(function () {
			if ($('#group_code').val() !='') {
				$("#group_camp").prop('required',true);
			}else{
				$("#group_camp").prop('required', false);
			}
		});
		
		$("#group_camp").change(function () {
			if ($('#group_camp').val() !='' && $('#group_code').val() == '' && $('#grpchk').val() != '') {
				$("#group_code").prop('required',true);
				$('#err_msg').remove();
			}else{
				$("#group_code").prop('required', false);
			}
		});
		
		$('#submit').click(function (){
			var flag = 0;
			if ($('#grpchk').is(':checked')) {
				if ($('#username1').val() =='' && $('#lastname1').val() == '' && $('#grpemail1').val() == '') {
					$('#err_msg_first').remove();
					$('#err_msg_second').remove();
					$('#err_msg_third').remove();
					$('#username1').after("<p style='color:red;' class='error' id='err_msg_first'> Please enter firstname</p>");
					$('#lastname1').after("<p style='color:red;' class='error' id='err_msg_second'> Please enter lastname</p>");
					$('#grpemail1').after("<p style='color:red;' class='error' id='err_msg_third'> Please enter email</p>");
					flag = 1;
				}
				if ($('#username1').val() !='' && $('#lastname1').val() != '' && $('#grpemail1').val() != ''){
					$('#err_msg_first').remove();
					$('#err_msg_second').remove();
					$('#err_msg_third').remove();
				}
				if ($('#username1').val() =='' && $('#lastname1').val() != '' && $('#grpemail1').val() != '') { 
					$('#err_msg_first').remove();
					$('#err_msg_second').remove();
					$('#err_msg_third').remove();
					$('#username1').after("<p style='color:red;' class='error' id='err_msg_first'> Please enter firstname</p>");
					flag = 1;
				}
				if ($('#username1').val() !='' && $('#lastname1').val() == '' && $('#grpemail1').val() != '') {
					$('#err_msg_first').remove();
					$('#err_msg_second').remove();
					$('#err_msg_third').remove();
					$('#lastname1').after("<p style='color:red;' class='error' id='err_msg_second'> Please enter lastname</p>");
					flag = 1;
				}
				if ($('#username1').val() !='' && $('#lastname1').val() != '' && $('#grpemail1').val() == '') {
					$('#err_msg_first').remove();
					$('#err_msg_second').remove();
					$('#err_msg_third').remove();
					$('#grpemail1').after("<p style='color:red;' class='error' id='err_msg_third'> Please enter email</p>");
					flag = 1;
				}
				
				if ($('#username1').val() =='' && $('#lastname1').val() == '' && $('#grpemail1').val() != '') { 
					$('#err_msg_first').remove();
					$('#err_msg_second').remove();
					$('#err_msg_third').remove();
					$('#username1').after("<p style='color:red;' class='error' id='err_msg_first'> Please enter firstname</p>");
					$('#err_msg_second').remove();
					$('#lastname1').after("<p style='color:red;' class='error' id='err_msg_second'> Please enter lastname</p>");
					flag = 1;
				}
				if ($('#username1').val() =='' && $('#lastname1').val() != '' && $('#grpemail1').val() == '') {
					$('#err_msg_first').remove();
					$('#err_msg_second').remove();
					$('#err_msg_third').remove();
					$('#username1').after("<p style='color:red;' class='error' id='err_msg_first'> Please enter firstname</p>");
					$('#err_msg_third').remove();
					$('#grpemail1').after("<p style='color:red;' class='error' id='err_msg_third'> Please enter email</p>");
					flag = 1;
				}
				if ($('#username1').val() !='' && $('#lastname1').val() == '' && $('#grpemail1').val() == '') {
					$('#err_msg_first').remove();
					$('#err_msg_second').remove();
					$('#err_msg_third').remove();
					$('#lastname1').after("<p style='color:red;' class='error' id='err_msg_second'> Please enter lastname</p>");
					$('#err_msg_third').remove();
					$('#grpemail1').after("<p style='color:red;' class='error' id='err_msg_third'> Please enter email</p>");
					flag = 1;
				}
				
			}
			var obj = $('input[name="username[]"]');
			var obj1 = $('input[name="lastname[]"]');
			var obj2 = $('input[name="grpemail[]"]');
			$.each( obj, function( key, value ) {
			  var rrt = parseInt(key+1);
			  if(rrt > 1) {
				  if($(value).val() != "" && $('#lastname'+rrt).val() == "" && $('#grpemail'+rrt).val() == "") {
						$('#err_msg11').remove();
						$('#err_msg12').remove();
						$('#err_msg13').remove();
						$('#lastname'+rrt).after("<p style='color:red;' class='error' id='err_msg11'> Please enter lastname</p>");
						$('#grpemail'+rrt).after("<p style='color:red;' class='error' id='err_msg12'> Please enter email</p>");
						flag = 1;
				  } else if($(value).val() == "" && $('#lastname'+rrt).val() == "" && $('#grpemail'+rrt).val() != "") {
						$('#err_msg11').remove();
						$('#err_msg12').remove();
						$('#err_msg13').remove();
						$(value).after("<p style='color:red;' class='error' id='err_msg13'> Please enter firstname</p>");
						$('#lastname'+rrt).after("<p style='color:red;' class='error' id='err_msg11'> Please enter lastname</p>");
						flag = 1;
				  } else if($(value).val() == ""  && $('#lastname'+rrt).val() != "" && $('#grpemail'+rrt).val() == "") {
						$('#err_msg11').remove();
						$('#err_msg12').remove();
						$('#err_msg13').remove();
						$(value).after("<p style='color:red;' class='error' id='err_msg13'> Please enter firstname</p>");
						$('#grpemail'+rrt).after("<p style='color:red;' class='error' id='err_msg12'> Please enter email</p>");
						flag = 1;
				  }
				 else if($(value).val() != ""  && $('#grpemail'+rrt).val() != "" && $('#lastname'+rrt).val() == "") {
						$('#err_msg11').remove();
						$('#err_msg12').remove();
						$('#err_msg13').remove();
						$('#lastname'+rrt).after("<p style='color:red;' class='error' id='err_msg11'> Please enter lastname</p>");
						flag = 1;
				  }
				  else if($(value).val() == ""  && $('#grpemail'+rrt).val() != "" && $('#lastname'+rrt).val() != "") {
						$('#err_msg11').remove();
						$('#err_msg12').remove();
						$('#err_msg13').remove();
						$(value).after("<p style='color:red;' class='error' id='err_msg13'> Please enter firstname</p>");
						flag = 1;
				  }
				  else if($(value).val() != "" && $('#lastname'+rrt).val() != "" && $('#grpemail'+rrt).val() == "") {
						$('#err_msg11').remove();
						$('#err_msg12').remove();
						$('#err_msg13').remove();
						$('#grpemail'+rrt).after("<p style='color:red;' class='error' id='err_msg12'> Please enter email</p>");
						flag = 1;
				  }
			  }
			});
			if(flag == 1) {
				return false;
			} else {
				$('#err_msg_first').remove();
				$('#err_msg_second').remove();
				$('#err_msg_third').remove();
				$('#err_msg11').remove();
				$('#err_msg12').remove();
				$('#err_msg13').remove();
				$('#err_msg14').remove();
				$('#err_msg15').remove();
				$('#err_msg16').remove();
				$('#err_msg17').remove();
				$('#err_msg18').remove();
				$('#err_msg19').remove();
				$('.form-horizontal').submit();
				return true;
			}
		});
		

		
		$("#BillingInfo").validate({
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.appendTo( element.parents(".error-cls"));
        },
        rules: {
            'first_name': {
              required: true,
            },
            'last_name' :{
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
            'zip_code' :{
                required : true,
            },
            'country' :{
                required : true,
            }, 
            'email' :{
                required : true,
            },
            'confirm_email' :{
                required : true,
				equalTo: '#email'
            },
            'home_phone' :{
                required : true,
            },
            'txtShippingFirstName' :{
                required : true,
            },
            'txtShippingLastName' :{
                required : true,
            },
            'txtShippingAddress1' :{
                required : true,
            },
            'txtShippingCity' :{
                required : true,
            },
            'txtShippingState' :{
                required : true,
            },
            'txtShippingPostalCode' :{
				required : true,
            },
            'txtShippingCountry' :{
                required : true,
            },
            'txtShippingPhone' :{
                required : true,
            }
        },
        messages:{
            'first_name': {
              required: "Please enter first name"
            },
            'last_name' :{
                required : "Please enter last name",
            }, 
            'address' :{
                required : "Please enter address",
            }, 
            'city' :{
                required : "Please enter city",
            }, 
            'state' :{
                required : "Please enter state",
            }, 
            'zip_code' :{
                required : "Please enter zip code",
            },
            'country' :{
                required : "Please select country",
            }, 
            'email' :{
                required : "Please enter email",
            },
            'confirm_email' :{
                required : "Please enter confirm email",
            },
            'home_phone' :{
                required : "Please enter home phone",
            },
            'txtShippingFirstName' :{
                required : "Please enter first name",
            },
            'txtShippingLastName' :{
                required : "Please enter last name",
            },
            'txtShippingAddress1' :{
                required : "Please enter address name",
            },
            'txtShippingCity' :{
                required : "Please enter city name",
            },
            'txtShippingState' :{
                required : "Please enter state name",
            },
            'txtShippingPostalCode' :{
                required : "Please enter postal code",
            },
            'txtShippingCountry' :{
                required : "Please choose country",
            },
            'txtShippingPhone' :{
                required : "Please enter home phone",
            }
        }
    });
	$("#BillingInfo").find("button[type='submit']").on("submit",function(e){
        
        if($("#BillingInfo").valid()) {
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
			if(last_val <= 5){
				$(".create-group:last").clone().insertAfter(".create-group:last");
				if($(".create-group:last").find('div.btn btn-default remove-camp').length)
				{	
					$(".create-group:last").find('div.btn btn-default remove-camp').remove();
					$('.create-group:last').append('<div class="form-group btn btn-default" onclick="removeInv(this)">Remove\
								</div>');
				}
				$(".create-group:last").next('div').find('input').val('');
				return true;
			}else{
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
		$(eve).parent('div').parent('div').remove();
	}
	</script>
</body>
</html>
