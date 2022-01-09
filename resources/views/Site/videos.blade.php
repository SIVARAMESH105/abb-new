@include("Site.header")
	<link rel='stylesheet' href="{{asset('public/css/magnific-popup.css')}}">
	<link rel='stylesheet' href="{{asset('public/css/font-awesome.min.css')}}">
    <script src ="{{ asset('public/js/video-srt.js') }}"></script>
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
                    @if($pageContent[0]->image1 != '')
						<div class="banner-wrap header-image">
							<img src="{{ url('public/uploads/images/cms//'.$pageContent[0]->image1) }}" alt="Banner image">
						</div>
					@endif
					<section class="advantage staff-page video-page">
                        <div class="row">
                            <div class="col-xs-12 staff-header">
								<h1>Camp Videos</h1>
                                @php echo $pageContent[0]->content; @endphp
                            </div>
                        </div>
                        <div class="row">
							@php $i = 1; @endphp
							@if (count($videos)>=1)
                            @foreach($videos as $video)
								<div class="staff-member with-caption video-page-section"  onclick="openModal();currentSlide({{$i}})">
									<div class="staff-member-detail">
										<a class="popup-models" id="modal-one" data-target="#myModal" data-toggle="modal">
											

                                            @if ($video->image) 
                                                <div class="staff-img" alt="{{$video->video_alt_text}}"  style="background-image: url({{url('public/uploads/videos/posters/'.$video->image)}});"></div>                                                     
											@else
                                                <div class="staff-img" >
                                                <video width="100%" height="240">
                                                  	<source src="{{url('public/uploads/videos/'.$video->video)}}" type="video/mp4">            
                                                </video>
                                                </div>
                                            @endif
                                            <h3>{{$video->title}} </h3>
										</a>
									</div>
								</div>
								@php $i++; @endphp
							@endforeach
                            @else
                                <div class="text-center no-data-found"><p>No videos found</p></div>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

	<!-- Model box -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<button type="button" id="close-button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="modal-body">
					<div id="myModal">
						@php $i = 1; @endphp
						@foreach($videos as $video)
							<div class="item mySlides">
								<div class="popup-view">
									<div class="popup-block">
										<h4>{{$video->title}}</h4>
									</div>
									<div class="staff-dp">
										<video id="video-ply-{{$i}}" width="320" height="240" class="video-close" controls>
											<source src="{{url('public/uploads/videos/'.$video->video)}}" type="video/mp4">
											@if ($video->transcript) 
                                                <track src="{{url('public/uploads/videos/transcript/'.$video->transcript)}}" kind="subtitles" srclang="en" label="English" default>
                                            @endif
										</video>
									</div>
								</div>
							</div>
							@php $i++; @endphp
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
	<script>
		function openModal() {
		  document.getElementById('myModal').style.display = "block";

		}
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
		  if (n > slides.length) {slideIndex = 1}
		  if (n < 1) {slideIndex = slides.length}
		  for (i = 0; i < slides.length; i++) {
			  slides[i].style.display = "none";			  
			  slides[i].className = "item mySlides";
		  }
		  slides[slideIndex-1].style.display = "block";
		  slides[slideIndex-1].className = "item mySlides active";

		  var videos = document.getElementById("video-ply");
             
		  $(".video-popup .author-slider a").click(function(){
		  	var curentVideo = $(".mySlides.active").find("video").attr("id");
		  	$(".mySlides").each(function(){
		  		$(this).find("video").get(0).pause();
		  		if($(this).hasClass("active")){
		  			// $(this).find("video").get(0).play();
		  		}
		  	})

		  	// var videos = document.getElementById(curentVideo);
		  	// console.log("test="+curentVideo);
		  	// videos.play();
		  });		  
		}
        // pause video and reset time after modal window closed
        $('#myModal').on('hidden.bs.modal', function () {
            var videos = $("#video-ply").get(0);
            var curentVideo = $(".mySlides.active").find("video").attr("id");
            var videopause = $('#'+curentVideo).get(0);
            if (videopause != null) {
              videopause.pause();
              videopause.currentTime = 0;
            }
        });
	</script>
</body>
</html>
