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
	<section>
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
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section shopping-cart">                    
					 <h1>Your Shopping Cart</h1>
					@if(empty($camp_details) && empty($productVal) && empty($training))
						<a href="{{ url('schedule') }}" class="btn btn-primary" name="Chkoutbottom" style="margin-left: 83%; margin-bottom: 5px;">Add Camp</a>
						<a href="{{ url('store') }}" class="btn btn-primary" name="Chkoutbottom" style="margin-left: 83%; margin-bottom: 5px;">Add Product</a>
						<label><h3>Your cart is empty.</h3></label>
					@else
						
						<div class="container container-md">
						  <div class="row">
							<div class="col-xs-12">
								@if(isset($camp_details) && !empty($camp_details))
									<div class="other-info">
										<div class="table-title">
											<label><h2>Camps</h2></label>
										</div>
										<div class="table-button">
											<a href="{{ url('schedule') }}" class="btn btn-primary" name="Chkoutbottom" style="margin-left: 67%; margin-bottom: 5px;">ADD ANOTHER CAMP</a>
										</div>
									</div>
								  <div class="table-responsive">
									<table class="table table-bordered table-hover">
											<thead>
												<tr>
												  <th>Student</th>
												  <th>Camp Focus</th>
												  <th>Location</th>
												  <th>Date/Time</th>
												  <th>Price</th>
												  <th>Remove</th>
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
														<td><a href="javascript:void(0)" onclick="remove_camp({{$details->id}})" class="btn btn-primary remove-camp">Remove</a></td>
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
								<a class="pages-link" href="{{ url('store') }}">Add a basketball t-shirts,shorts,or other products to your order! Click here to visit our online store.</a>
								<br>
								<br>
								@if(isset($productVal) && !empty($productVal))
								<form id="UpdateQtyInfo" action="{{url('cart/UpdateQtyInfo')}}" method="post" class="form-horizontal">
									{{ csrf_field() }}
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
													  <th>Remove</th>
													</tr>
												</thead>
												<tbody>
												<?php //echo '<pre>'; print_r($productVal);die;
												$last_cost = 0;?>
												@foreach($productVal as $products)
													<tr>
														<input type="hidden" name="curPrice[]" value="{{$products['pd_price']}}" style="width: 50px;"/>
														<input type="hidden" name="cur_pd_id[]" value="{{$products['pd_id']}}" style="width: 50px;"/>
														<input type="hidden" name="pd_name[]" value="{{$products['pd_name']}}" style="width: 50px;"/>
														<input type="hidden" name="pro_size[]" value="{{$products['pro_size']}}" style="width: 50px;"/>
														<input type="hidden" name="pro_color[]" value="{{$products['pro_color']}}" style="width: 50px;"/>
														<td>{{$products['pd_name']}}</td>
														<td>{{$products['pro_size']}}</td>
														<td>{{$products['pro_color']}}</td>
														<td><input class="qty-change" type="text" name="qtychg[]" value="{{$products['pd_qty']}}" style="width: 50px;"/></td>
														<td>${{$products['pd_price']}}</td>
												<td><a href="javascript:void(0)" onclick="remove_product({{$products['pd_id']}},{{$products['pd_price']}},'{{$products['pro_size']}}','{{$products['pro_color']}}')" class="btn btn-primary remove-camp">Remove</a></td>
														</tr>
														<?php $last_cost += $products['pd_price'];?>
													@endforeach
												</tbody>
										</table>
									</div>
									<div class="other-info">
										<div class="table-title">
											<label class="highlight-label"><span>Total Amount:</span> ${{$last_cost}}</label>
										</div>
										<div class="table-button">
											<button id="submit" type="submit" name="submit" class="btn btn-primary">Update cart</button>
										</div>
									</div>
								</div>
							</form>
						  </div><!--end of .table-responsive-->
						@endif
						@if(isset($training) && !empty($training))
								<form id="UpdateQtyInfo" action="{{url('cart/UpdateQtyInfo')}}" method="post" class="form-horizontal">
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
													  <th>Remove</th>
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
													<td><a href="javascript:void(0)" onclick="remove_training()" class="btn btn-primary remove-camp">Remove</a></td>
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
						  <div class="col-xs-12">
						  	
							  <div class="checkout-button">
							  	<a href="{{ url('checkout/checkoutPage') }}" class="btn btn-primary" name="Chkoutbottom">GO CHECKOUT</a>
							  </div>
						  </div>
							</div>
						</div>
					</div>
					@endif
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
	<script src="{{ URL::asset('public/js/jquery-alert/jquery-confirm.min.js') }}"></script>
	<script>
	function remove_camp(cid){
	$.confirm({
			  title: 'Remove',
			  content: 'Are you sure do you want to remove the camp?',
			  buttons: {
			  ok: function () {
					var b_url = '{{url("/")}}';
					window.location.href = b_url+"/site/removeCamp/"+cid;
				},
			  cancel: function () {
				  $('#myProductModal').modal('hide');
				}
			}
		});
	}
	
	function remove_product(pid,pd_price,pd_size,pd_color){
	$.confirm({
			  title: 'Remove',
			  content: 'Are you sure do you want to remove the product?',
			  buttons: {
			  ok: function () {
					var b_url = '{{url("/")}}';
					if(pd_size!='') {
						pd_size =pd_size;
					} else {
						pd_size ='';
					}
					window.location.href = b_url+"/site/removeProduct/"+pid+'/'+pd_price+'/'+pd_color+'/'+pd_size;
				},
			  cancel: function () {
				  $('#myProductModal').modal('hide');
				}
			}
		});
	}

	function remove_training(){
	$.confirm({
			  title: 'Remove',
			  content: 'Are you sure do you want to remove the One-on-One Training?',
			  buttons: {
			  ok: function () {
					var b_url = '{{url("/")}}';
					window.location.href = b_url+"/site/removeTraining";
				},
			  cancel: function () {
				  $('#myProductModal').modal('hide');
				}
			}
		});
	}
	</script>
</body>
</html>
