@include("Site.header")
	<link rel='stylesheet' href="{{asset('public/css/magnific-popup.css')}}">
	<link rel='stylesheet' href="{{asset('public/css/font-awesome.min.css')}}">
        <div class="secondary-top">
            <div class="container container-md search-content" >
                <div class="bg-white-section">
                    @if($pageContent[0]->image1 != '')
						<div class="banner-wrap header-image">
							<img src="{{ url('public/uploads/images/cms//'.$pageContent[0]->image1) }}" alt="Banner image">
						</div>
					@endif
					<section class="advantage staff-page staff-bio-members">
                        <div class="row">
                            <div class="col-xs-12 staff-header">
								<h2>Advantage Basketball Staff</h2>
                                @php echo $pageContent[0]->content; @endphp
                            </div>
                        </div>
                        <div class="row">
							@php $i = 1; @endphp
							@foreach($staffBioInfo as $staff)
								<div class="col-lg-5-1 col-md-5-1 col-sm-5-3 col-xs-5-5 staff-member with-caption"  onclick="openModal();currentSlide({{$i}})">
									<div class="staff-member-detail">
										<a class="popup-models" id="modal-one" data-target="#myModal" data-toggle="modal">
											<div class="staff-img" style="background-image: url({{url('public/uploads/images/staffbios/thumb/'.$staff->thumbnail)}});"></div>
											<h3>{{$staff->name}}</h3>											
                                            @php 
                                                $description = $staff->short_desc;
                                                if(strlen(strip_tags($description)) > 85) {
                                                    echo  $description = substr($description, 0, 85).'&hellip;</p>'; 
                                                } else {
                                                    echo $description;
                                                }
                                            @endphp
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
    </section>

	<!-- Model box -->
	<div class="staff-modal modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img aria-hidden="true" src="{{ asset('public/images/close.png') }}" alt="Close" title="Close"></button>
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div id="myModal">
						@foreach($staffBioInfo as $staff)
							<div class="item mySlides">
								<div class="popup-view">
									<!-- <div class="staff-dp" style="background:url({{url('public/uploads/images/staffbios/'.$staff->image)}})>"</div> -->
									<div class="staff-dp"> 
										<img src="{{url('public/uploads/images/staffbios/'.$staff->image)}}">
									</div>
									<div class="popup-block">
										<h4>{{$staff->name}}</h4>
										<div class="popup-author-desc"> <hr></div>
										<div class="author-main-content">
											@php echo $staff->short_desc ; @endphp
											@php echo $staff->content; @endphp
										</div>
									</div>
								</div>
							</div>
						@endforeach
						<div class="author-slider">
							<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
							<a class="next" onclick="plusSlides(1)">&#10095;</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
	<!--<script>
		jQuery(document).ready(function () {
			lightBoxPopup();
		});
	</script>-->
	<script>
		function openModal() {
		  document.getElementById('myModal').style.display = "block";
		}

		/* function closeModal() {
		  document.getElementById('myModal').style.display = "none";
		} */

		var slideIndex = 1;
		showSlides(slideIndex);

		function plusSlides(n) {
		  showSlides(slideIndex += n);
		}

		function currentSlide(n) {
		  showSlides(slideIndex = n);
		}

		function showSlides(n) {
		  var i;
		  var slides = document.getElementsByClassName("mySlides");
		  //var dots = document.getElementsByClassName("demo");
		  //var captionText = document.getElementById("caption");
		  if (n > slides.length) {slideIndex = 1}
		  if (n < 1) {slideIndex = slides.length}
		  for (i = 0; i < slides.length; i++) {
			  slides[i].style.display = "none";
		  }
		  /* for (i = 0; i < dots.length; i++) {
			  dots[i].className = dots[i].className.replace(" active", "");
		  } */
		  slides[slideIndex-1].style.display = "block";
		  //dots[slideIndex-1].className += " active";
		  //captionText.innerHTML = dots[slideIndex-1].alt;
		}
	</script>
</body>
</html>
