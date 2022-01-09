@extends('backpack::layout')

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
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
		<div class="box">
			<div class="box-body table-responsive view-order-table">
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
					@endphp
				@endif
				<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
					<tr> 
						<td colspan="2" align="center" class="table-header" id="infoTableHeader"><b>Order Detail</b></td>
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
						<td width="150" class="labelText">Last Update</td>
						<td>{{$od_last_update}}</td>
					</tr>
					<tr> 
						<td class="labelText">Status</td>
						<td>
							<form name="modifyStatusForm" id="modifyStatusForm" method="POST" action="{{ url('admin/modifyOrderStatus') }}" accept-charset="UTF-8">
								{{ csrf_field() }}
								<input type="hidden" name="orderId" id="orderId" value="{{$orderId}}">
								<select name="orderStatus" id="orderStatus" class="box">
									@foreach($statusOptions as $statusOption)
										<option value="{{$statusOption}}" @if($od_status == $statusOption) {{'selected'}} @endif>{{$statusOption}}</option>
									@endforeach
								</select>
								<div class="tracking-details">
									<!--<input type="text" name="trackURL" id="trackURL" value="@if(count($orderDetails)>0){{$orderDetails[0]->shipping_tracking_URL}}@endif" placeholder="Enter a Tracking URL" />-->
									<input type="" name="trackingnumber" id="trackingnumber" value="@if(count($orderDetails)>0){{$orderDetails[0]->shipping_tracking_number}}@endif" placeholder="Enter a Tracking Number">
								</div>
								<div class="modifybutton">
									<!--<input name="btnModify" type="submit" id="btnModify" value="Modify Status" class="box" onClick="modifyOrderStatus();">-->
									<input name="btnModify" type="submit" id="btnModify" value="Modify Status" class="box">
								</div>
							</form>
						</td>
					</tr>
				</table>
				<br>
				<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
					<tr> 
						<td colspan="3" align="center" class="table-header" id="infoTableHeader"><b>Products</b></td>
					</tr>
					<tr> 
						<td width="150" class="labelText">Item</td>
						<td width="150" class="labelText">Unit Price</td>
						<td width="150" class="labelText">Total</td>
					</tr>
					@php $subTotal = 0; @endphp
					@if(count($orderItems) > 0)
						@foreach($orderItems as $orderItem)
							@php $subTotal += $orderItem->pd_price * $orderItem->od_qty; @endphp
							<tr> 
								<td>
									@if(($orderItem->od_color != '') && ($orderItem->od_size !=''))
										@php $attributs = "<b>Color:</b>&nbsp;&nbsp;".$orderItem->od_color.", <b>Size:</b>&nbsp;&nbsp;".$orderItem->od_size; @endphp
									@elseif($orderItem->od_color != '')
										@php $attributs = "<b>Color:</b>&nbsp;&nbsp;".$orderItem->od_color; @endphp
									@else 
										@php $attributs = ""; @endphp
									@endif
										@php echo $orderItem->od_qty.'X'.$orderItem->pd_name.'<br>'.$attributs; @endphp
								</td>
								<td>${{$orderItem->pd_price}}</td>
								<td>${{number_format($orderItem->od_qty*$orderItem->pd_price, 2, '.', '')}}</td>
							</tr>
						@endforeach
						<tr> 
							<td colspan="2" align="right">Shipping</td>
							<td align="right">${{$od_shipping_cost}}</td>
						</tr>
					@else
						<tr>
							<td colspan="3" align="center">No Item Ordered</td>
						</tr>
					@endif
					@if(strtolower($od_shipping_state) == 'wa')
						<tr> 
							<td colspan="2" align="right">Washington State Sales Tax</td>
							<td>{{$od_wa_cost}}</td>
						</tr>
					@else
						@php $od_wa_cost = 0; @endphp
					@endif
					<tr> 
						<td colspan="2" align="right">Total</td>
						<td align="right">
						@if(count($orderItems) > 0)
								${{number_format($od_shipping_cost+$subTotal+$od_wa_cost, 2, '.', '')}}
							@else 
								{{'$0.00'}}
							@endif
						</td>
					</tr>
				</table>
				<br>
				<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" >
					<tr id="infoTableHeader"> 
						<td colspan="9" class="table-header" >Registered Camp</td>
					</tr>
					<tr align="center"> 
						<td>Student Name</td>
						<td>Camp Name</td>
						<td>Location</td>
						<td>City</td>
						<td>State</td>
						<td>Startdate</td>
						<td>Enddate</td>
						<td>Total</td>
						<td>Modify Camp</td>
					</tr>
					@php $campsubTotal = 0; @endphp
					@if(count($registeredCamps) > 0)
						@foreach($registeredCamps as $registeredCamp)
							@php $campsubTotal += $registeredCamp->amount_paid; @endphp
							<tr>
								<td>{{$registeredCamp->name}}</td>
								<td>{{$registeredCamp->camp_focus}}</td>
								<td>{{$registeredCamp->Location}}</td>
								<td>{{$registeredCamp->City}}</td>
								<td>{{$registeredCamp->State}}</td>
								<td>{{$registeredCamp->startdate}}</td>
								<td>{{$registeredCamp->enddate}}</td>
								<td>{{$registeredCamp->amount_paid}}</td>
								<td><a href="" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit</a></td>
							</tr>
							<tr>
								<td>Registration Comments:</td>
								<td colspan="8">
									@if($registeredCamp->comments != '')
										{{$registeredCamp->comments}}
									@else
										{{"NA"}}
									@endif
								</td>
							</tr>
						@endforeach
					@else
						<tr><td colspan="9" align="center">No Camp Registered</td></tr>
					@endif
					<tr id="infoTableHeader"> 
						<td colspan="8" align="right">Registration & Order Total</td>
						<td align="right">
							@php $ws_cost = $od_wa_cost; @endphp
							@if($subTotal > 0 && $campsubTotal > 0)
								@if(strtolower($od_shipping_state) == 'wa' && $od_shipping_cost != '')
									@php $amount = $subTotal + $od_shipping_cost + $ws_cost + $campsubTotal; @endphp
								@else
									@php $amount = $subTotal +  $od_shipping_cost + $campsubTotal; @endphp
								@endif
							@elseif($subTotal > 0)
								@if(strtolower($od_shipping_state) == 'wa' && $od_shipping_cost != '')
									@php $amount = $subTotal + $od_shipping_cost + $ws_cost; @endphp
								@else
									@php $amount = $subTotal +  $od_shipping_cost; @endphp
								@endif
							@else
								@php $amount = $campsubTotal; @endphp
							@endif
							${{number_format($amount, 2, '.', '')}}
						</td>
					</tr>
				</table>
				<br>
				<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
					<tr id="infoTableHeader"> 
						<td colspan="2" class="table-header">How did you hear about us</td>
					</tr>
					<tr> 
						<td colspan="2">@if(isset($registeredCamp->hear) && $registeredCamp->hear != '') {{$registeredCamp->hear}} @else {{"NA"}} @endif</td>
					</tr>
				</table>
				@if(count($orderItems) > 0)
					<br>
					<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
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
							@if(!empty($od_shipping_work_phone))
								<td>{{$od_shipping_work_phone}}</td>
							@else
								<td>--</td>
							@endif
						</tr>
					</table>
				@endif
				<br>
				<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
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
						@if(!empty($od_payment_work_phone))
							<td>{{$od_payment_work_phone}}</td>
						@else
							<td>--</td>
						@endif
					</tr>
					 <tr> 
						<td width="150">E-mail</td>
						<td>{{$od_shipping_email}}</td>
					</tr>
				</table>
				<br>
				@if($od_payment_type != 'Manual Registration')
					<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
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
				@else
					<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
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
				@endif
				<br>
				<table width="700" border="1"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
					<tr id="infoTableHeader"> 
						<td colspan="2" class="table-header">Checkout Comments</td>
					</tr>
					<tr> 
						<td colspan="2">@if($od_checkout_comments != '') {{$od_checkout_comments}} @else {{"NA"}} @endif</td>
					</tr>
				</table>
				<br>
				<p align="center" class="go-back"> 
					<input name="btnBack" type="button" id="btnBack" value="Back" class="box" onClick="window.history.back();">
				</p>
			</div>
		</div>
	</div>
</div>
@endsection

@section('after_styles')

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
@endsection

@section('after_scripts')

<script type="text/javascript">
	function modifyOrderStatus()
	{
		var orderId = $('#orderId').val();
		var orderStatus = $('#orderStatus').val();
		window.location = "{{ url('admin/modifyOrderStatus') }}"+'/'+orderId+'/'+orderStatus;
	}
	$(document).ready(function() {
		if($('select#orderStatus').val() !='Shipped') {
			$('.tracking-details').hide();
			$(".tracking-details input").val('');
		} else {
			$(".tracking-details input").prop('required',true);
		}
		$(document).on('change', 'select#orderStatus', function() {
  			if(this.value =='Shipped') {
  				$('.tracking-details').show();
  				$(".tracking-details input").prop('required',true);
  			} else {
  				$('.tracking-details').hide();
  				$(".tracking-details input").val('');
  				$(".tracking-details input").prop('required',false);
  			}
		});
	});
	
</script>
  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection