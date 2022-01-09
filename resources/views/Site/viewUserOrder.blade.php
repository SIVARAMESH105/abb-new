
@include("Site.header")
@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Registrations & Order Details</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">Registrations & Orders -> Order Details</li>
	  </ol>
	</section>
@endsection

@section('content')
<!-- Default box -->
<div class="container container-md search-content">
	<div class="row">
	    <!-- THE ACTUAL CONTENT -->
	    <div class="col-md-12">
			<div class="box">
				<div class="box-body view-order-table">
					@if(count($orderDetails) > 0)
						@php
							$od_id = $orderDetails[0]->od_id;
							$od_date = $orderDetails[0]->od_date;
							$od_last_update = $orderDetails[0]->od_last_update;
							$od_status = $orderDetails[0]->od_status;
							$od_shipping_cost = $orderDetails[0]->od_shipping_cost;
							
							$od_shipping_state = $orderDetails[0]->od_shipping_state;
							$od_shipping_first_name = $orderDetails[0]->od_shipping_first_name;
							$od_shipping_last_name = $orderDetails[0]->od_shipping_last_name;
							$od_shipping_address1 = $orderDetails[0]->od_shipping_address1;
							$od_shipping_city = $orderDetails[0]->od_shipping_city;
							$od_shipping_postal_code = $orderDetails[0]->od_shipping_postal_code;
							$od_shipping_country = $orderDetails[0]->od_shipping_country;
							$od_shipping_phone = $orderDetails[0]->od_shipping_phone;
							$od_shipping_work_phone = $orderDetails[0]->od_shipping_work_phone;
							$od_payment_first_name = $orderDetails[0]->od_payment_first_name;
							$od_payment_last_name = $orderDetails[0]->od_payment_last_name;
							$od_payment_address1 = $orderDetails[0]->od_payment_address1;
							$od_payment_city = $orderDetails[0]->od_payment_city;
							$od_payment_state = $orderDetails[0]->od_payment_state;
							$od_payment_postal_code = $orderDetails[0]->od_payment_postal_code;
							$od_payment_country = $orderDetails[0]->od_payment_country;
							$od_payment_phone = $orderDetails[0]->od_payment_phone;
							$od_payment_work_phone = $orderDetails[0]->od_payment_work_phone;
							$od_shipping_email = $orderDetails[0]->od_shipping_email;
							$od_payment_type = $orderDetails[0]->od_payment_type;
							$od_payment_cctype = $orderDetails[0]->od_payment_cctype;
							$od_payment_ccnumber = $orderDetails[0]->od_payment_ccnumber;
							$od_payment_invoice = $orderDetails[0]->od_payment_invoice;
							$od_payment_approval_code = $orderDetails[0]->od_payment_approval_code;
							$od_payment_transaction_id = $orderDetails[0]->od_payment_transaction_id;
							$od_checkout_comments = $orderDetails[0]->od_checkout_comments;
							$od_wa_cost = $orderDetails[0]->od_wa_cost;
							$shipping_tracking_number = $orderDetails[0]->shipping_tracking_number;
						@endphp
					@else
						@php
							$od_id = '';
							$od_date = '';
							$od_last_update = '';
							$od_status = '';
							$od_shipping_cost = '';
							$od_shipping_state = '';
							$od_shipping_first_name = '';
							$od_shipping_last_name = '';
							$od_shipping_address1 = '';
							$od_shipping_city = '';
							$od_shipping_postal_code = '';
							$od_shipping_country = '';
							$od_shipping_phone = '';
							$od_shipping_work_phone = '';
							$od_payment_first_name = '';
							$od_payment_last_name = '';
							$od_payment_address1 = '';
							$od_payment_city = '';
							$od_payment_state = '';
							$od_payment_postal_code = '';
							$od_payment_country = '';
							$od_payment_phone = '';
							$od_payment_work_phone = '';
							$od_shipping_email = '';
							$od_payment_type = '';
							$od_payment_cctype = '';
							$od_payment_ccnumber = '';
							$od_payment_invoice = '';
							$od_payment_approval_code = '';
							$od_payment_transaction_id = '';
							$od_checkout_comments = '';
							$od_wa_cost = '';
							$shipping_tracking_number ='';
						@endphp
					@endif
					<h3 class="table-header" style=" margin-top: 30%; text-align: center;"><b>Order Detail</b></h3>
					<div class="table-responsive">
						<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="table table-bordered detailTable" style="margin-top: 30px;">
							<tr> 
								<td colspan="2" align="center" class="table-header" id="infoTableHeader"><b>Order</b></td>
							</tr>
							<tr> 
								<td width="150" class="labelText">Order Number</td>
								<td>{{$od_id}}</td>
							</tr>
							<tr> 
								<td width="150" class="labelText">Order Date</td>
								<td>{{$od_date}}</td>
							</tr>
							
							<tr> 
								<td class="labelText">Status</td>
								<td>{{$od_status}}</td>
							</tr>
							@if($od_status=='Shipped')
							<tr> 
								<td class="labelText">Tracking Number</td>
								<td>{{$shipping_tracking_number}}</td>
							</tr>
							@endif
							<input type="hidden" name="orderId" id="orderId" value="{{$orderId}}">
						</table>
					</div>
					
					<div class="table-responsive">
						<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="table table-bordered detailTable" style ="margin-top: 30px;">
							<tr> 
								<td colspan="4" align="center" class="table-header" id="infoTableHeader"><b>Products</b></td>
							</tr>
							<tr> 
								<td width="150" class="labelText">Item</td>
								<td width="150" class="labelText">Unit Price (X) Quantity</td>
								<td width="150" class="labelText">Product Image</td>
								<td width="150" class="labelText">Total</td>
							</tr>
							@php $subTotal = 0; @endphp
							@if(count($orderItems) > 0)
								@foreach($orderItems as $orderItem)
									@php $subTotal += $orderItem->pd_price * $orderItem->od_qty; @endphp
									<tr> 
										<td>
											@if(($orderItem->od_color != '') && ($orderItem->od_size !=''))
												@php $attributs = "<b>Color:</b>&nbsp;&nbsp;".$orderItem->od_color.", <b>Size:</b>&nbsp;&nbsp;".$orderItem->od_size.", <b>Quantity:</b>&nbsp;&nbsp;".$orderItem->od_qty; @endphp
											@elseif($orderItem->od_color != '')
												@php $attributs = "<b>Color:</b>&nbsp;&nbsp;".$orderItem->od_color; @endphp
											@else 
												@php $attributs = ""; @endphp
											@endif
												<b>Product Name : </b>@php  echo $orderItem->pd_name.'<br>'.$attributs; @endphp
										</td>
										<td>${{$orderItem->pd_price}} (X) {{$orderItem->od_qty}}</td>
										<td><img src="../public/uploads/images/products/thumbnail/<?php echo $orderItem->pd_thumbnail;?>" alt="Advantage Basketball Camps"></td>
										<td>${{number_format($orderItem->od_qty*$orderItem->pd_price, 2, '.', '')}}</td>
									</tr>
								@endforeach
								<tr> 
									<td colspan="3" align="right">Shipping</td>
									<td align="right">${{$od_shipping_cost}}</td>
								</tr>
							@else
								<tr>
									<td colspan="3" align="center">No Item Ordered</td>
								</tr>
							@endif
							@if(strtolower($od_shipping_state) == 'wa')
								<tr> 
									<td colspan="3" align="right">Washington State Sales Tax</td>
									<td>{{$od_wa_cost}}</td>
								</tr>
							@else
								@php $od_wa_cost = 0; @endphp
							@endif
							<tr> 
								<td colspan="3" align="right">Total</td>
								<td align="right">
									@if(count($orderItems) > 0)
										${{number_format($od_shipping_cost+$subTotal+$od_wa_cost, 2, '.', '')}}
									@else 
										{{'$0.00'}}
									@endif
								</td>
							</tr>
						</table>
					</div>
					
					@if(count($orderItems) > 0)
					<br>
					<div class="table-responsive">
						<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="table table-bordered detailTable">
							<tr id="infoTableHeader"> 
								<td colspan="2">Shipping Information</td>
							</tr>
							<tr> 
								<td width="150">First Name</td>
								<td>{{$od_shipping_first_name}}</td>
							</tr>
							<tr> 
								<td width="150">Last Name</td>
								<td>{{$od_shipping_last_name}}</td>
							</tr>
							<tr> 
								<td width="150">Address</td>
								<td>{{$od_shipping_address1}}</td>
							</tr>
							<tr> 
								<td width="150">City</td>
								<td>{{$od_shipping_city}}</td>
							</tr>
							<tr> 
								<td width="150">Province / State</td>
								<td>{{$od_shipping_state}}</td>
							</tr>
							<tr> 
								<td width="150">Postal Code</td>
								<td>{{$od_shipping_postal_code}}</td>
							</tr>
							<tr> 
								<td width="150">Country</td>
								<td>{{$od_shipping_country}}</td>
							</tr>
							<tr> 
								<td width="150">Home Phone Number</td>
								<td>{{$od_shipping_phone}}</td>
							</tr>
							<tr> 
								<td width="150">Work Phone Number</td>
								<td>{{$od_shipping_work_phone}}</td>
							</tr>
						</table>
					</div>
						
					@endif
					<br>
					<div class="table-responsive">
						<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="table table-bordered detailTable">
							<tr id="infoTableHeader"> 
								<td colspan="2" class="table-header">Billing Information</td>
							</tr>
							<tr> 
								<td width="150">First Name</td>
								<td>{{$od_payment_first_name}}</td>
							</tr>
							<tr> 
								<td width="150">Last Name</td>
								<td>{{$od_payment_last_name}}</td>
							</tr>
							<tr> 
								<td width="150">Address</td>
								<td>{{$od_payment_address1}}</td>
							</tr>
							<tr> 
								<td width="150">City</td>
								<td>{{$od_payment_city}}</td>
							</tr>
							<tr> 
								<td width="150">Province / State</td>
								<td>{{$od_payment_state}}</td>
							</tr>
							<tr> 
								<td width="150">Postal Code</td>
								<td>{{$od_payment_postal_code}}</td>
							</tr>
							<tr> 
								<td width="150">Country</td>
								<td>{{$od_payment_country}}</td>
							</tr>    
							<tr> 
								<td width="150">Home Phone Number</td>
								<td>{{$od_payment_phone}}</td>
							</tr>
							<tr> 
								<td width="150">Work Phone Number</td>
								<td>{{$od_payment_work_phone}}</td>
							</tr>
							 <tr> 
								<td width="150">E-mail</td>
								<td>{{$od_shipping_email}}</td>
							</tr>
						</table>
					</div>
					
					<br>
					@if($od_payment_type != 'Manual Registration')
						<div class="table-responsive">
						<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="table table-bordered detailTable">
							<tr id="infoTableHeader"> 
								<td colspan="2" class="table-header">Payment Information</td>
							</tr>
							<tr> 
								<td width="150">Card Type</td>
								<td>{{$od_payment_cctype}}</td>
							</tr>
							<tr> 
								<td width="150">Card Number</td>
								<td>{{$od_payment_ccnumber}}</td>
							</tr>
							<tr> 
								<td width="150">Invoice</td>
								<td>{{$od_payment_invoice}}</td>
							</tr>
							<tr> 
								<td width="150">Approval Code</td>
								<td>{{$od_payment_approval_code}}</td>
							</tr>
							<tr> 
								<td width="150">Transaction Id</td>
								<td>{{$od_payment_transaction_id}}</td>
							</tr>
						</table>					
						</div>
					@else
						<div class="table-responsive">
							<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="table table-bordered detailTable">
								<tr id="infoTableHeader">	
									<td colspan="2">Payment Information</td>
								</tr>

								<tr> 
									<td width="150">Payment Method</td>
									<td>Manual Registration</td>
								</tr>
									<tr> 
									<td width="150">Payment Type</td>
									<td>{{$od_payment_type}}</td>
								</tr>
								<tr> 
									<td width="150">Card Number:</td>
									<td>{{$od_payment_ccnumber}}</td>
								</tr>
								<tr> 
									<td width="150">Transaction ID:</td>
									<td>{{$od_payment_transaction_id}}</td>
								</tr>
							</table>
						</div>
					@endif
					<br>
					
					<p align="center" class="go-back">
						<a href="{{ url('user/purchaseProducts') }}" class="btn btn-primary" name="backForm">Back</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
@include("Site.features")
@include("Site.footer")
@section('after_styles')

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
@endsection

@section('after_scripts')


  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection