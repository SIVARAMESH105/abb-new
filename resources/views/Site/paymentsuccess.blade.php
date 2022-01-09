@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
                   <section class="advantage">
                        <div class="row">
                            <div class="col-xs-12">
							<input type="hidden" name="base_url" value="{{url('/')}}" id="base_url"/>
								@if($response =='success')
                                <section class="payment-status-wrap">
                                    <div class="icon-notify success-payment">
                                        <div class="icon-notify-circle">
                                          <i class="fa fa-check" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="titles pay-notify-msg">
                                        <h3>Payment Successfully Completed</h3>
                                    </div>
                                </section>
                                @elseif($response =='card_error')
                                <section class="payment-status-wrap">
                                    <div class="icon-notify failure-payment">
                                        <div class="icon-notify-circle">
                                          <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="titles pay-notify-msg">
                                        <h3>Payment Faliure</h3>
                                    </div>
                                    <div class="each-advantages pay-notify-details" >
                                        <h5>Charge Credit Card ERROR</h5>
                                    </div>
                                    @else
                                    <div class="titles pay-notify-msg">
                                        <h3>Payment Faliure</h3>
                                    </div>
                                    <div class="each-advantages pay-notify-details">
                                        <h5>Error: Charge Credit Card Null response returned</h5>
                                    </div>
                                    @endif
                                </section>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
	
	@if($response =='success')
	<script>
	setTimeout(function() {
		var base_url = $('#base_url').val(); 
		window.location.href = base_url+"/store";
	}, 6000);
	</script>
	@else
	<script>
	setTimeout(function() {
		var base_url = $('#base_url').val(); 
		window.location.href = base_url+"/cart/cartPage";
	}, 6000);
	</script>	
	@endif
</body>
</html>
