	@include("Site.header")
	<style>
	.error{
		color:red;
	}
	</style>
		<link rel='stylesheet' href="{{asset('public/css/magnific-popup.css')}}">
		<link rel='stylesheet' href="{{asset('public/css/font-awesome.min.css')}}">
	        <div class="secondary-top">
	            <div class="container container-md search-content">
	                <div class="bg-white-section">
	                    <form id="Detailpage" action="{{url('product/addProductCart')}}" method="post" class="form-horizontal">
						{{ csrf_field() }}
						<input type="hidden" id="pd_price" name="pd_price" value="{{$details[0]->pd_price}}"/>
						<input type="hidden" id="pd_specialprice" name="pd_specialprice" value="{{$details[0]->pd_specialprice}}"/>
						<input type="hidden" id="pd_id" name="pd_id" value="{{$details[0]->pd_id}}"/>
						<input type="hidden" id="pd_name" name="pd_name" value="{{$details[0]->pd_name}}"/>
							<section class="advantage staff-page product-detail-page">
								<div class="row">
									<div class="col-xs-12 back-to-product">
										<a href="{{url('store')}}" class="btn btn-primary remove-camp">Continue Shopping</a>
									</div>
									<div class="col-xs-12 staff-header">
										<h2>@php echo $details[0]->pd_name; @endphp</h2>
									</div>
								</div>
								<div class="row">
								<?php 
								if(isset($_SESSION['product']) && !empty($_SESSION['product'])){
									foreach($_SESSION['product']  as $vals){
										if ($vals['pd_qty'] <= $details[0]->pd_breakqty && $vals['pd_id'] == $details[0]->pd_id) {
										$details[0]->pd_breakqty =  $details[0]->pd_breakqty - $vals['pd_qty'];
										}
									}
								}?>
								<!--<h4>Select color first, then size drop-down list will appear.</h4>-->
									<div class="staff-member-detail product-details-page">
										
											<div class="staff-img" style="background-image: url({{url('public/uploads/images/products/thumbnail/'.$details[0]->pd_thumbnail)}});"></div>
											<h3>{{$details[0]->pd_name}}</h3>
											<p>@php echo $details[0]->pd_description; @endphp</p>
											<p class="product-info"><span>Price</span> $ @php echo $details[0]->pd_price; @endphp</p>
											<p class="product-info"><span>Avaliable Quantity</span> @php echo $details[0]->pd_breakqty; @endphp</p>	
									</div>
								</div>
								@if($details[0]->pd_breakqty == 0)
									<p class="out-of-stock" style="color:red;">Sorry out of stock</p>
								@else
								<div class="col-xs-12 availablity-form">
									
									<div class="form-group">
										<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Enter Quantity <span class="important">*</span></label>
										<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
											<input type="text" class="form-control input-md" id="pd_qty" name="pd_qty" required=""/>
										</div>
									</div>
									@if($get_product_size !='')
									<?php //echo '<pre>'; print_r($product_color);die;?>
										@if($get_product_size[0]->sizecode == 'None')  
										<input type="hidden" name="pro_size" id="pro_size" value ="{{$get_product_size[0]->sizecode}}"/>
										@else
											<div class="form-group">
												
												<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Select Size <span class="important">*</span></label>
												<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
													<select id="pro_size" name="pro_size" class="form-control input-md" value="{{ old('pro_size') }}" required="">
													
														<option value="">Select</option>
														@foreach($get_product_size as $size)
															<option value="{{$size->sizecode}}">{{$size->sizecode}}</option>
														@endforeach
													</select>
												</div>
											</div>
										@endif
									@endif
									@if($get_product_color->isEmpty())
										<?php //echo '<pre>'; print_r($product_color);die;?>
										@if($product_color[0]->color_name == 'None')  
										<input type="hidden" name="pro_color" id="pro_color" value ="{{$product_color[0]->color_name}}"/>
										@else
										<div class="form-group">
											<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Select Color <span class="important">*</span></label>
											<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
												<select id="pro_color" name="pro_color" class="form-control input-md" value="{{ old('pro_color') }}" required="">
													<option value="">Select</option>
													<option value="{{$product_color[0]->color_id}}">{{$product_color[0]->color_name}}</option>
												</select>
											</div>
										</div>
										@endif
									@else
										<div class="form-group">
											<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Select Color <span class="important">*</span></label>
											<div class="col-md-3 col-sm-6 col-xs-12 error-cls">
												<select id="pro_color" name="pro_color" class="form-control input-md" value="{{ old('pro_color') }}" required="">
													<option value="">Select</option>
													<?php //echo '<pre>'; print_r($get_product_color);die; ?>
													@foreach($get_product_color as $color)
														<option value="{{$color->pd_attr_color}}">{{$color->pd_attr_color}}</option>
													@endforeach
												</select>
											</div>
										</div>
									@endif
									
									<div class="form-group">
										<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="submit"></label>
										<div class="col-md-3 col-sm-6 col-xs-12" style="text-align:left">
											<button type="submit" id="submit" name="submit" class="btn btn-primary">ADD TO CART</button>
										</div>
									</div>
								</div>
							</section>
							
							@endif
						</form>
	                </div>
	            </div>
	        </div>
	    </section>

	    @include("Site.features")
	    @include("Site.footer")
		<script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
		<script>
			$("#pd_qty").change(function () {
				var cur_val = $('#pd_qty').val();
				var qty = <?php echo $details[0]->pd_breakqty;?>;
				if(cur_val > qty){
					$('#err_msg').remove();
					$('#pd_qty').after("<p style='color:red;' id='err_msg'> Sorry quantity not available !</p>");
					$('#pd_qty').val('');
					return false;
				}else{
					$('#err_msg').remove();
					return true;
				}
				
			});
			
			$("#pd_qty").keydown(function (e) {
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
					(e.keyCode >= 35 && e.keyCode <= 40)) {
						 return;
				}
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});
			
			$("#Detailpage").validate({
	        errorElement: "span",
	        errorPlacement: function(error, element) {
	            error.appendTo( element.parents(".error-cls"));
	        },
	        rules: {
	            'pd_qty': {
	              required: true,
	            },
	            'pro_size' :{
	                required : true,
	            }, 
	            'pro_color' :{
	                required : true,
	            }
	        },
	        messages:{
	            'pd_qty': {
	              required: "Please enter quantity"
	            },
	            'pro_size' :{
	                required : "Please select size",
	            }, 
	            'pro_color' :{
	                required : "Please select color",
	            }
	        }
	    });
		 $("#Detailpage").find("button[type='submit']").on("submit",function(e){
	        
	        if($("#Detailpage").valid()) { 
	            $(this).submit();
	        } else {
	            return false;
	        }
	    });
		</script>
	</body>
	</html>
