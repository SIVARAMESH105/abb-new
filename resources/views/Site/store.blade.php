@include("Site.header")
	<link rel='stylesheet' href="{{asset('public/css/magnific-popup.css')}}">
	<link rel='stylesheet' href="{{asset('public/css/font-awesome.min.css')}}">
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
                    @if($pageContent[0]->image1 != '')
						<div class="banner-wrap header-image">
							<img src="{{ url('public/uploads/images/cms//'.$pageContent[0]->image1) }}" alt="Banner image">
						</div>
					@endif
					<section class="advantage staff-page products-store">
                        <div class="row">
                            <div class="col-xs-12 staff-header">
								<h1>Products</h1>
                                @php echo $pageContent[0]->content; @endphp
                            </div>
                        </div>
                        <div class="row">
						<?php //echo '<pre>'; print_r($storeInfo);die; ?>
							@php $i = 1; @endphp
							@foreach($storeInfo as $store)
								<div class="col-sm-6 col-md-3 col-xs-12 staff-member with-caption"  onclick="openModal();currentSlide({{$i}})">
									<div class="staff-member-detail">
										<a class="popup-models" id="modal-one" data-target="#myModal" data-toggle="modal">
											<a href="{{ url('productDetail/'.$store->pd_id) }}"><div class="staff-img" style="background-image: url({{url('public/uploads/images/products/thumbnail/'.$store->pd_thumbnail)}});"></div>
											<!--<a href="#"><h3>{{$store->pd_name}}</h3></a>-->
											<h3>{{$store->pd_name}}</h3></a>
											<p class="product-info">@php echo $store->pd_shorttitle; @endphp</p>
											<p class="product-info"><span>Price:</span> ${{$store->pd_price}}</p>
										</a>
									</div>
								</div>
								@php $i++; @endphp
							@endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
   
    @include("Site.features")
    @include("Site.footer")
	
</body>
</html>
