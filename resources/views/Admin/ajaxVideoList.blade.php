<div class="col-md-12">	
	@if($videoList)
	<div class='previews-dropzone video-wrap'>
		<div class="selected-video selected-images">
			<div class="selected-img-wrap">
				<div class="staff-img" >
					<video width="320" height="240" class="video-close" controls>
					  <source src="{{url('public/uploads/videos/'.$videoList->video)}}">               
					</video>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="ajxvideo" id="ajxvideo" value="{{$videoList->video}}">
	@else
		<div class="text-center no-data-found"><p>No videos found!</p></div>
	@endif
</div>