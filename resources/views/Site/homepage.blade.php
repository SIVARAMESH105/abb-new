@include("Site.header")		
       @if(isset($_SESSION['cur_user_id']) && $_SESSION['cur_user_id'] !='')
            <div class="secondary-top" style="background:white;">
                <div class="bg-white-section">
                    <section class="dashboard-view-section" >
                    <div class ="container container-sm search-content">
                        <div class="dashboard-container">
                            <h3>{{ $user_name->name }}</h3>
                            <div class="row">
                                <div class="col-sm-6 col-md-4 text-center">
                                    <div class="dashboard-types">
                                        <a href="{{url('user/editProfile')}}" class="dashboard-types-view">
                                             <img src="{{asset('public/images/dashboard-profile.png')}}">
                                             <p>My Profile</p>
                                         </a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 text-center">
                                    <div class="dashboard-types">
                                        <a href="{{url('user/regCamps')}}" class="dashboard-types-view">
                                             <img src="{{asset('public/images/dashboard-registration.png')}}">
                                             <p>Camp Registrations</p>
                                         </a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 text-center">
                                    <div class="dashboard-types">
                                        <a href="{{url('user/purchaseProducts')}}" class="dashboard-types-view">
                                             <img src="{{asset('public/images/dashboard-product.png')}}">
                                             <p>Product Purchases</p>
                                         </a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 text-center">
                                    <div class="dashboard-types">
                                        <a href="{{url('user/userGroups')}}" class="dashboard-types-view">
                                             <img src="{{asset('public/images/dashboard-groups.png')}}">
                                             <p>Groups</p>
                                         </a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 text-center">
                                    <div class="dashboard-types">
                                        <a href="{{url('reviews')}}" class="dashboard-types-view">
                                             <img src="{{asset('public/images/dashboard-reviews.png')}}">
                                             <p>Reviews</p>
                                         </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        @else
        <div class="secondary-top">
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
            <div class="container container-sm">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="banner-wrap">
                            <div class="owl-carousel owl-theme">
                                @if($pageContent[0]->image1 !='')
                                    <div class="item">
                                        <img src="{{url('public/uploads/images/cms/'.$pageContent[0]->image1)}}" alt="slider one">
                                        <div class="banner-caption">
                                            @if($pageContent[0]->content1 !='')
                                                <h2>{{$pageContent[0]->content1}}</h2>
                                            @endif
                                        </div>
                                    </div>
                                 @endif
                                @if($pageContent[0]->image2 !='')
                                    <div class="item">
                                        <img src="{{url('public/uploads/images/cms/'.$pageContent[0]->image2)}}" alt="Slider Two">
                                        <div class="banner-caption">
                                             @if($pageContent[0]->content2 !='')
                                                <h2>{{$pageContent[0]->content2}}</h2> 
                                            @endif  
                                        </div>
                                    </div>
                                @endif
                                @if($pageContent[0]->image3 !='')
                                    <div class="item">
                                        <img src="{{url('public/uploads/images/cms/'.$pageContent[0]->image3)}}" alt="">
                                        <div class="banner-caption">
                                             @if($pageContent[0]->content3 !='')
                                                <h2>{{$pageContent[0]->content3}}</h2>
                                            @endif
                                        </div>
                                    </div>
                                 @endif
                                @if($pageContent[0]->image4 !='')
                                    <div class="item">
                                        <img src="{{url('public/uploads/images/cms/'.$pageContent[0]->image4)}}" alt="">
                                        <div class="banner-caption">
                                            @if($pageContent[0]->content4 !='')
                                                <h2>{{$pageContent[0]->content4}}</h2>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if($pageContent[0]->image5 !='')
                                    <div class="item">
                                        <img src="{{url('public/uploads/images/cms/'.$pageContent[0]->image5)}}" alt="">
                                        <div class="banner-caption">
                                             @if($pageContent[0]->content5 !='')
                                                <h2>{{$pageContent[0]->content5}}</h2>
                                            @endif
                                        </div>
                                    </div>
                                 @endif
                                 @if($pageContent[0]->image6 !='')
                                    <div class="item">
                                        <img src="{{url('public/uploads/images/cms/'.$pageContent[0]->image6)}}" alt="">
                                        <div class="banner-caption">
                                             @if($pageContent[0]->content6 !='')
                                                <h2>{{$pageContent[0]->content6}}</h2>
                                            @endif
                                        </div>
                                    </div>  
                                 @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row map-content">
                    <div class="col-sm-6 col-xs-12">
                        <div class="map-wrap">
                            <img class="img-responsive" src="{{ asset('public/images/us-map.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="map-wrap">
                            <h2>BASKETBALL CAMPS<small>Nationwide</small></h2>
                        </div>
                        <div class="register-wrap">
                            <a href="{{url('schedule')}}">REGISTER NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="three-links">
        <div class="container container-sm" >
            <div class="row">
                <div class="col-sm-4">
                    <a href="{{url('schedule')}}">
                        <div class="icon-links">
                            <img src="{{ asset('public/images/location.png') }}" alt="">
                            <h4>LOCATIONS</h4>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="{{url('reviews')}}">
                        <div class="icon-links">
                            <img src="{{ asset('public/images/reviews.png') }}" alt="">
                            <h4>REVIEWS</h4>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a class="popup-models" id="modal-one" data-target="#myModal" data-toggle="modal">
                        <div class="icon-links">
                            <img src="{{ asset('public/images/video.png') }}" alt="">
                            <h4>CAMP VIDEO</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- For Video Popup code-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" id="close-button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div id="myModal">
                        <div class="item mySlides">
                            <div class="popup-view">
                                <div class="popup-block">
                                    <h4>CAMP VIDEO</h4>
                                </div>
                                <div class="staff-dp">
                                    <video id="video-ply" width="320" height="240" class="video-close" controls>
                                        <source src="{{url('public/uploads/videos/advantagebasketball.mp4')}}" type="video/mp4">
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Css style work for the purpose div added by developer-->
    <div class ="container container-sm search-content">
        <section class="advantage" id="search">
            <div class="container container-sm" id="page-content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="title">
                            <h1>Advantage Basketball Camps for Kids 5-18</h1>
                            <h1>The Ultimate Sports Training Experience</h1>
                        </div>
                        <div class="each-advantage">
                            <p>Your kids will grow and learn about more than basketball at an Advantage Basketball Camps’ session. While they practice ball-handling, dribbling, and shooting, they will also learn about self-esteem, teamwork, and the value of hard work.</p>
                        </div>
                        <div class="each-advantage">
                            <h2>Industry-Leading Basketball Training Techniques</h2>
                            <p>Your child will learn using the most advanced sports coaching and training methods in use today. Our techniques have been developed over 20 years to motivate kids to learn through repetition, with fun.</p>
                        </div>
                        <div class="each-advantage">
                            <h2>Variety of Basketball Camps At Locations Nationwide</h2>
                            <p>The summer 2017 camps will consist of 1-5 day sessions for boys and girls of all skill levels, from 6 to 18 years of age. </p>
    						<?php //echo "<pre>";print_r($list_cities); echo "</pre>"; //exit;?>
    						<div class = "location-column-break">
								@php $i = 0; @endphp
								@foreach ($list_cities as $key => $list_city)
									@if ($i != 0 && $i % 21 == 0)
										</div>
										<div class="location-column-break">
										<ul>
									@endif
									@php $i++; @endphp
									<h6 class ="location-state"> {{ $key}} </h6>
									<ul>
									@foreach ($list_city as $key => $city)
										@if ($i % 21 == 0)
											</ul>
											</div> <div class="location-column-break">
											<ul>
										@endif
										@php $i++; @endphp
										<li> <a href ="{{URL::to('/')}}/locations/{!!$city->title!!}" class="text-underline">{{  $city->City }}</a></li>
									@endforeach
									</ul>
								@endforeach
    						</div>
                        </div>
                        <div class="each-advantage">
                            <h2>Youth Sports Camps With A Positive Difference</h2>
                            <p>You will see your children gain an improved positive attitude, greater appreciation for good moral values, and a better understanding of the keys that will lead to their own success. The sport is basketball, but the most important element is the children’s future development.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endif
@include("Site.features")
@include("Site.footer")
<script>
        setTimeout(function() {
		 $('.alert-success').fadeOut();
		 $('#name, #email, #msg, #origin').val('')
		}, 5000 );
</script>
</body>
</html>
