	@include("Site.header")
		<script src ="{{ asset('public/js/video-srt.js') }}"></script>
        <div class="secondary-top">
            <div class="container container-md">
                <div class="bg-white-section">
					
                    <section class="with-sidebar-layout">
						<div class="content-body-wrap search-content">
							@if(isset($locationInfo->geo)=="yes")
							<h1>Basketball Camp - @if(!empty($locationInfo)){{$locationInfo->City}}, {{$locationInfo->state_name}}@endif
							</h1>
							@if(!empty($locationInfo->geoImage))
								<img width="700" height="300" src="{{ asset('public/uploads/images/geo/images/'.$locationInfo->geoImage) }}" alt="{{$locationInfo->image_alt_txt}}">
							@endif
							<p class="image-caption">Register for a summer basketball camp in {{$locationInfo->City}}, {{$locationInfo->state_name}}.</p>
							<div class="form-group camp-group location-individual" id="camplist">
								@if(count($locationRes)>0)
									@foreach($locationRes as $val)
									<div class="search-results">
										<h2>{!!$val->camp_focus!!}</h2>
										<p><b>{!!$val->Location!!}</b></p>
										<p>{!!$val->Address!!}</p>
										<p>@if(!empty($val->City)){!!$val->City !!},@endif {!!$val->state_name!!} {!!$val->Zip!!}</p>
										<p>@if(!empty($val->startCamp))<i>Dates:</i>{!!$val->startCamp!!} - {!!$val->endCamp!!}@endif</p>
										<span class="complete" style="display: inline;">
										<p>@if(!empty($val->campstarttime))<i>Hours:</i>{!!$val->campstarttime!!} to {!!$val->campendtime!!}@endif</p>
										<p>@if(!empty($val->cost))<i>Cost:</i>$ {!!$val->cost!!}@endif</p>
										<p>@if(!empty($val->EarlyBirdDiscount))<i>Early-bird discount:</i>{!!$val->EarlyBirdDiscount!!}@endif<p>@if(!empty($val->contact))<i>Contact:</i>{!!$val->contact!!}@endif</p>
										<a class="campmap text-underline" href="https://www.google.com/maps?q=@if(!empty($val->Address)){!!$val->Address!!},@endif{!!$val->City !!} @if(!empty($val->Zip)){!!$val->Zip!!},@endif{!!$val->Location!!}&amp;output=embed" data-toggle="modal" data-target="#modalRegister">(map)</a></p>
										<p><a class="text-underline" href="{{URL::to('/')}}/camp/register/{!!$val->id!!}">Register now</a></p></span>
									</div>
									<script type="application/ld+json">
									{
									  "@context": "http://schema.org",
									  "@type": "ChildrensEvent",
									  "description": "Advantage Basketball Camps in Bellingham, Washington during Summer 2019, featuring Ball Handling and Basketball Shooting training.",
									  "image": "{{ URL::to('/') }}/images/featured_image.jpg",
									  "location": {
									    "@type": "Place",
									    "address": {
									      "@type": "PostalAddress",
									      "streetAddress": "{{ $val->Address }}",
									      "addressLocality": "{{ $val->City }}",
									      "addressRegion": "{{ $val->state_name }}",
										  "postalCode": "{{ $val->Zip }}",
										  "addressCountry": "{{ $val->country_code }}"
										  },
									    "name": "{{ $val->Location }}"
									  },
									  "name": "{{ $val->camp_focus }}",
									  "offers": {
									    "@type": "Offer",
									    "availability":"http://schema.org/LimitedAvailability",
									    "availabilityEnds":"2019-08-01T09:00",
									    "offeredBy": {
									     "@type": "Corporation",
									     "contactPoint": {
									      "@type": "ContactPoint",
									       "areaServed" : "US",
									       "contactType": "Sales",
									       "email" : "info@advantagebasketball.com",
									       "telephone" : "+1-425-670-8877"
									      },
									     "address": {
									      "@type": "PostalAddress",
									       "postOfficeBoxNumber": "1344",
									       "addressLocality": "Lynnwood",
									       "addressRegion": "WA",
									       "postalCode": "98046",
									       "addressCountry": "{{ $val->country_code }}"},
									     "identifier":{"@type":"PropertyValue","propertyID":"UBI","value":"601600614"},
									     "image": "{{ URL::to('/') }}/public/images/logo-image.png",
									     "legalName": "Hummel Enterprises, Inc.",
									     "name": "Advantage Basketball Camps",
									     "sameAs":	"https://www.linkedin.com/company/advantage-basketball-camps",
									     "telephone":	"+1-425-670-8877",
									     "url": "{{ URL::to('/') }}"
									    },
									    "price": "{{ $val->cost }}",
									    "priceCurrency": "USD",
									    "url": "{{ URL::to('/').'/camp/register/'.$val->id }}"
									  },
									  "startDate": "{{ $val->startdate.'T'.$val->starttime }}",
									  "endDate": "{{ $val->enddate.'T'.$val->endtime }}",
									  "typicalAgeRange": "6-18"
									}
									</script>
									@endforeach
								@endif
							</div>
							@if(!empty($locationInfo->AdditionalInfo))
								<div class="additionInfo">{!!$locationInfo->AdditionalInfo!!}</div>
							@endif
							@if($locationInfo->geo=="yes")
								 <div class="row">
									<div class="col-xs-12 location-inividual-benefits">
										<h3>{!!$locationInfo->geoTitleTag!!}</h3>
										<p>{!!$locationInfo->geoDescriptionTag!!}</p>
										<p>{!!$locationInfo->geoContent!!}</p>
										@if(!empty($locationInfo->geoVideo))
											<div class="location-individual-video">
												<a class="popup-models" id="modal-one" data-target="#myModal" data-toggle="modal">
													<div class="staff-img video-thumbnail" >
														<video width="100%">
														@if($locationInfo->isAjaxUpload==1)
															<source src="{{url('public/uploads/videos/'.$locationInfo->geoVideo)}}" type="video/mp4">
														@else
															<source src="{{url('public/uploads/images/geo/videos/'.$locationInfo->geoVideo)}}" type="video/mp4">
														@endif
														</video>
													</div>
												</a>
											</div>
										@endif
									</div>
								</div>
							@endif
							@else
							<section class="advantage">
								<h2>No Geo-Targeted location page found!</h2>
							</section>
							@endif
                        </div>
						
                        <div class="side-bar-wrap">
                        <form name="ccoptin" class="form-horizontal" action="https://visitor.constantcontact.com/d.jsp" target="_blank" method="post">                    
                            <input type="hidden" name="m" value="1101857529536">
                            <input type="hidden" name="p" value="oi">
                            <div class="form-group">
                              <label class="control-label" for="add2">GET NOTIFIED ABOUT LOCAL CAMPS. ENTER YOUR E-MAIL TO SUBSCRIBE:</label>  
                              <div class="error-cls">
                              <input type="text" name="ea" size="14" value="" class="form-control input-md">
                              </div>
                            </div>
                            <div class="form-group sidebar-form-button">
                              <label class="control-label" for="submit">THEN CLICK</label>
                              <div class="">
                                <input type="submit" name="go" value="Go" class="submit btn" />
                              </div>
                            </div>
                        </form>
							<h2>Looking for a summer basketball camp near you?</h2>
							<p>Click here to use our camp locator!</p>
							<h3>Need lodging near this camp?</h3>
							<img src="{{url('public/images/holiday-express.jpg')}}">
							<p>other camp information goes here.for Example,using a special entrance or an NBA star will be signing autographs or other special circumstances.Hotel info above and this text are populated from the "Additional Info" field in the "Location" form.</p>   
						</div>
                    </section>	
                </div>
            </div>
        </div>
		<!-- Model box -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<button type="button" id="close-button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="modal-body">
					<div id="myModal">
						<div class="item mySlides">
								<div class="popup-view">
									<div class="popup-block">
									</div>
									<div class="staff-dp">
									@if(!empty($locationInfo->geoVideo))
										<video width="320" height="240" class="video-close" controls>
											
											@if($locationInfo->isAjaxUpload==1)
												<source src="{{url('public/uploads/videos/'.$locationInfo->geoVideo)}}" type="video/mp4">
												@if (!empty($locationInfo->geoTranscript)) 
                                                	<track src="{{url('public/uploads/images/geo/transcript/'.$locationInfo->geoTranscript)}}" kind="subtitles" srclang="en" label="English" default>
                                            	@endif
											@else
												<source src="{{url('public/uploads/images/geo/videos/'.$locationInfo->geoVideo)}}" type="video/mp4">
												@if (!empty($locationInfo->geoTranscript)) 
                                                	<track src="{{url('public/uploads/images/geo/transcript/'.$locationInfo->geoTranscript)}}" kind="subtitles" srclang="en" label="English" default>
                                            	@endif
											@endif
										</video>
									@endif
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Map modal-->
	<div id="modalRegister" class="modal fade" role="dialog">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img aria-hidden="true" src="{{ asset('public/images/close.png') }}" alt="Close" title="Close"></button>
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<iframe id="location" src=""></iframe>
				</div>
			</div>
		</div>
	</div>
    </section>
	@include("Site.features")
	@include("Site.footer")
	<script>
		$(document).on('click','.campmap', function(event){
            var mapsrc = $(this).attr('href');
            $('#location').attr('src'," ");
            $('#location').attr('src',mapsrc);
		});
	</script>
</body>
</html>
