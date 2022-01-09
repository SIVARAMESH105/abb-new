@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    {{ trans('backpack::crud.edit') }} <span class="text-lowercase">{{ $crud->entity_name }}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.edit') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<!-- Default box -->
		@if ($crud->hasAccess('list'))
			<a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span class="text-lowercase">{{ $crud->entity_name_plural }}</span></a><br><br>
		@endif

		@include('crud::inc.grouped_errors')

		<form enctype="multipart/form-data" method="post" id="location" action= "{{url('admin/manageLocations/'.$content[0]->Id)}}">
			<input name="_method" type="hidden" value="PUT">
			{!! csrf_field() !!}
			<input type="hidden" name="existImage" id="existImage" value="@if(isset($content[0]->geoImage)){{$content[0]->geoImage}}@endif">
			<input type="hidden" name="existVideo" value="@if(isset($content[0]->geoVideo)){{$content[0]->geoVideo}}@endif">
			<input type="hidden" name="existTranscript" value="@if(isset($content[0]->geoTranscript)){{$content[0]->geoTranscript}}@endif">
			<input type="hidden" name="locationId" value="@if(isset($content[0]->Id)){{$content[0]->Id}}@endif">
			<input type="hidden" name="isAjaxUpload" value="@if(isset($content[0]->isAjaxUpload)){{$content[0]->isAjaxUpload}}@endif">
		  <div class="box">
		    <div class="box-header with-border">
				@if ($crud->model->translationEnabled())
			    	<!-- Single button -->
					<div class="btn-group pull-right">
					  <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Language: {{ $crud->model->getAvailableLocales()[$crud->request->input('locale')?$crud->request->input('locale'):App::getLocale()] }} <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
						  	<li><a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a></li>
					  	@endforeach
					  </ul>
					</div>
					<h3 class="box-title" style="line-height: 30px;">{{ trans('backpack::crud.edit') }}</h3>
				@else
					<h3 class="box-title">{{ trans('backpack::crud.edit') }}</h3>
				@endif
		    </div>
		    <div class="box-body row">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
				<div class="form-group col-md-12">
					<label>Camp Location<span class="red">*</span></label>
                    <input type="text" name="Location" value="@if(isset($content[0]->Location)){{$content[0]->Location}}@endif" class="form-control">
					@if ($errors->has('Location'))
						<div class="error">{{$errors->first('Location')}}</div>
					@endif
				</div>
				<div class="form-group col-md-12">
					<label>Address<span class="red">*</span></label>
					<input type="text" name="Address" value="@if(isset($content[0]->Address)){{$content[0]->Address}}@endif" class="form-control">
					@if ($errors->has('Address'))
						<div class="error">{{$errors->first('Address')}}</div>
					@endif
				</div>
				<div class="form-group col-md-4">
					<label>City<span class="red">*</span></label>
					<input type="text" name="City" value="@if(isset($content[0]->City)){{$content[0]->City}}@endif" class="form-control city">
					@if ($errors->has('City'))
						<div class="error">{{$errors->first('City')}}</div>
					@endif
				</div>
				<div class="form-group col-md-4">
					<label>State<span class="red">*</span></label>
					<select name="State" class="form-control state">
						@foreach($states as $state)
							<option data-attr = "{{$state->state_code}}" value="{{$state->state_id}}" @if($content[0]->State == $state->state_id) {{'selected'}} @endif >{{$state->state_name}}</option>
						@endforeach
                    </select>
					@if ($errors->has('State'))
						<div class="error">{{$errors->first('State')}}</div>
					@endif
				</div>
				<div class="form-group col-md-4">
					<label>Zip<span class="red">*</span></label>
					<input type="text" name="Zip" value="@if(isset($content[0]->Zip)){{$content[0]->Zip}}@endif" class="form-control">
					@if ($errors->has('Zip'))
						<div class="error">{{$errors->first('Zip')}}</div>
					@endif
				</div>
				<div class="form-group col-md-4">
					<label>Country<span class="red">*</span></label>
					<select name="Country" class="form-control" onchange="reloadStates(this.value, '');">
						@foreach($countries as $country)
							<option value="{{$country->country_id}}" @if($content[0]->Country == $country->country_id) {{'selected'}} @endif>{{$country->country_name}}</option>
						@endforeach
                    </select>
					@if ($errors->has('Country'))
						<div class="error">{{$errors->first('Country')}}</div>
					@endif
				</div>
				<div class="form-group col-md-4">
					<input type="checkbox" name="geoCheckbox" id="geoCheckbox" value="yes" @if($content[0]->geo == 'yes') {{'checked'}} @endif >
					<label for="geoCheckbox">Geo-targeted location page</label>
				</div>
				<div class="form-group col-md-4">
					<label>Director<span class="red">*</span></label>
					<select name="director" class="form-control">
						<option value="">Select a Director</option>
						@foreach($directors as $key=>$director)
							<option value="{{$director}}" @if(!empty($dlist->director)) @if($dlist->director==$director){{'selected'}} @endif @endif>{{$director}}</option>
						@endforeach
                    </select>
					<div class="error" id="directorError">@if ($errors->has('director')){{$errors->first('director')}}@endif</div>
					
				</div>
				<div class="form-group col-md-12">
					<label>Additional Information</label>
					<textarea name="AdditionalInfo" id="additionalText">{{$content[0]->AdditionalInfo}}</textarea>
				</div>
				<div class="form-group col-md-12" id="geo">
					@php
						if(isset($content[0]->geoPageTitle)) {
							$slug_url = $content[0]->geoPageTitle;
						} else {
							$city = $content[0]->City;
							$slug_url = "basketball-camp-$city-$stateCode";
						}
					@endphp
					<div class="form-group col-md-12">
						<label>Slug/URL</label>
						<p class="edit-txt">{{URL::to('/')}}/locations/<span class="edit-name">{!!$slug_url!!}</span>&nbsp;&nbsp;<a href="javascript:;" title="Edit"><i class="fa fa-edit icon-edit">Edit</i><span class="icons-ok-can"><i class="fa icon-ok">Ok</i> | <i class="fa icon-cancel">cancel</i></span></a><p>
						<input type="hidden" name="title" id="slugUrl" value="{!!$slug_url!!}"/>
						@if ($errors->has('title'))
							<div class="error">The slug URL has already been taken.</div>
						@endif
					</div>
					<div class="form-group col-md-12">
						<label>Title Tag</label>
						<input type="text" name="titletag" value="@if(isset($content[0]->geoTitleTag)){{$content[0]->geoTitleTag}}@endif" class="form-control">
					</div>
					<div class="form-group col-md-12">
						<label>Description Tag</label>
						<input type="text" name="desctag" value="@if(isset($content[0]->geoDescriptionTag)){{$content[0]->geoDescriptionTag}}@endif" class="form-control">
					</div>
					<h4>Geo-targeted location page</h4>
					<div class="form-group col-md-12">
						<label>Template Text<span class="red">*</span></label>
						<textarea name="geoTemplate"  value="{{old('geoTemplate')}}" id="geoTemplate">@if(isset($content[0]->geoContent)) {{$content[0]->geoContent}} @endif</textarea>
						<div class="error" id="geoTemplateError">@if ($errors->has('geoTemplate')){{$errors->first('geoTemplate')}}@endif</div>
					</div>
					<div class="form-group col-md-12">
						<label>Featured Image (2000 x 675 px)<span class="red">*</span></label>
						 <div class="dropzone dropzone-previews" id="feature-dropzone">
							<div class="fallback">
								<input type="file" class="form-control">
							</div>
						</div>
						<input type="hidden" name="image" id="image" >
						<div class="error" id="imageError">@if ($errors->has('image')){{$errors->first('image')}}@endif</div>
					</div>
					<div class="col-md-12">
						@if(isset($content[0]->geoImage) && $content[0]->geoImage != '')
						<div class='previews-dropzone video-wrap'>
							<div class="selected-image selected-images">
							<div class="selected-img-wrap">
								<img src="{{url('public/uploads/images/geo/images/'.$content[0]->geoImage)}}" width="100px" height="100px">
							<a href="javascript:void(0);" class="remove-video" title="Remove" onclick='removeImage();'>Remove</a>
							</div>
							</div>
						</div>
						@endif
						
					</div>
					<div class="form-group col-md-12">
						<label>Feature Image Alt Text</label>
						<input type="text" name="alt" class="form-control" value="@if(isset($content[0]->image_alt_txt)){{$content[0]->image_alt_txt}}@endif">
					</div>
					{{--<div class="form-group col-md-12">
						<label>Video (MP4 format, 854 x 480 px)</label>
						<input type="file" name="video" class="form-control">
						@if(isset($content[0]->geoVideo) && $content[0]->geoVideo != '')
							{{$content[0]->geoVideo}}
						@endif
					</div>--}}
					<div class="form-group col-md-12">
						<label>Video (MP4 format, 854 x 480 px)</label>
						<div class="dropzone dropzone-previews" id="feature-dropzone-video">
							<div class="fallback">
								<input type="file" class="form-control">
							</div>
						</div>
						<input type="hidden" name="video" id="video">
						<div class="error" id="videoError"></div>
					</div>
					<div class="col-md-12">	
						@if(isset($content[0]->geoVideo) && $content[0]->geoVideo != '')
						<div class='previews-dropzone video-wrap'>
							<div class="selected-video selected-images">
								<div class="selected-img-wrap">
									<video width="320" height="240" class="video-close" controls>
										@if($content[0]->isAjaxUpload==1)
											<source src="{{url('public/uploads/videos/'.$content[0]->geoVideo)}}" type="video/mp4">
										@else
											<source src="{{url('public/uploads/images/geo/videos/'.$content[0]->geoVideo)}}" type="video/mp4">
										@endif
									</video>
									<a href="javascript:void(0);" class="remove-video" title="Remove" onclick='removeVideo();'>Remove</a>
								</div>
							</div>
						</div>
						@endif
					</div>
					@if(count($videoLists)>0)
					<div class="form-group col-md-6">
						<label>Or, select from previously uploaded files:</label>
						<select name="galary-video" id="galary-video" class="form-control">
							<option value="">Select a video</option>
							@foreach($videoLists as $videos)
								<option value="{{$videos->id}}">{{$videos->title}}</option>
							@endforeach
						</select>
					</div>
					@endif
					<div class="ajxVideo"></div>
					<div class="form-group col-md-12">
						<label>Transcript File upload (support .vtt, .srt format)</label>
						<input type="file" name="transcript" id="transcript" class="form-control">
					        <div class="fallback">
					        @if(isset($content[0]->geoTranscript) && $content[0]->geoTranscript != '')
								<div class="well well-sm" id="transcript-div">
									<a target="_blank" href="{{url('public/uploads/images/geo/transcript/'.$content[0]->geoTranscript)}}">{{$content[0]->geoTranscript}}</a>
									<a id="image_file_clear_button" href="javascript:void(0);" class="btn btn-default btn-xs pull-right" title="Clear file" onclick='removeTranscript();'><i class="fa fa-remove"></i></a>
									<div class="clearfix"></div>
								</div>
					        @endif
							</div>     
						<div class="error" id="transcriptError">@if ($errors->has('transcript')){{$errors->first('transcript')}}@endif</div>
					</div>
				</div>
				
		    </div><!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::crud.save') }}</span></button>
		      <a href="{{ url($crud->route) }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">{{ trans('backpack::crud.cancel') }}</span></a>
		    </div><!-- /.box-footer-->
		  </div><!-- /.box -->
		</form>
			
	</div>
</div>
@endsection
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<!--<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>-->
<script src="{{ asset('js/ckeditor.js') }}"></script>

 


<script>
    $(document).ready(function(){
       // CKEDITOR.replace( 'additionalText' ); 
        //CKEDITOR.replace( 'geoTemplate' );
        //New Classic Editor js file 
		ClassicEditor
		.create(document.querySelector('#additionalText'))
		.catch(error=>{
		console.error(error);
		}); 
		ClassicEditor
		.create(document.querySelector('#geoTemplate'))
		.catch(error=>{
		console.error(error);
		});        
		if($("#geoCheckbox").prop('checked') == true) {   
			$('#geo').toggle();
		}
		Dropzone.autoDiscover = false;
   		url = baseUrl+'/admin/dropzoneUpload';
		//Image upload
		$("div#feature-dropzone").dropzone({
			 addRemoveLinks: true,
			 url: url,
			 acceptedFiles: 'image/*',
			 maxFiles: 1,
			 maxFilesize: 8, // MB
			 dictDefaultMessage: "Browse Files",
			 dictMaxFilesExceeded: "You can not upload any more files.",
			 dictFileTooBig: "That image is too large. We only allow 8MB or smaller.",
			 dictInvalidFileType: "You can't upload files of this type.",
			 maxfilesexceeded: function(file) {
				this.removeFile(file);
			}
		 });

		//video upload
		$("div#feature-dropzone-video").dropzone({
			 addRemoveLinks: true,
			 url: url,
			 acceptedFiles: 'video/*',
			 maxFiles: 1,
			 maxFilesize: 50, // MB
			 dictDefaultMessage: "Browse Files",
			 dictMaxFilesExceeded: "You can not upload any more files.",
			 dictFileTooBig: "That image is too large. We only allow 8MB or smaller.",
			 dictInvalidFileType: "You can't upload files of this type.",
			 maxfilesexceeded: function(file) {
				this.removeFile(file);
			}
		 });
			
		//select video files 
		requesturl = "<?php echo url('admin/ajaxGetVideoGallary/'); ?>";
		var token = $('meta[name="csrf-token"]').attr('content');
		$(document).on("change","#galary-video", function() {
			$.ajax({
				url: requesturl,
				type: "POST",
				data: {"token":token,"vid":$(this).val()},
				success:function(result) {
					$(".ajxVideo").html(result);
				}
			});
		});
		//transcript hide
		$("#transcript-notempty").hide();
    });
</script>
 
<script>
$(function () {
	reloadStates("<?php echo $content[0]->Country; ?>", "<?php echo $content[0]->State; ?>");
	$('#geoCheckbox').change(function () {                
		$('#geo').toggle();
	}).change();
	
	if($("#geoCheckbox").is(':checked')) {
		$("#geo").show();
	} else {
		$("#geo").hide();
	}
	
	var errors = 0;
	$('#location').submit(function( event ) {
		var valid = true;
		if($("#geoCheckbox").prop('checked') == true) {
			var geoTemplateValue = CKEDITOR.instances['geoTemplate'].getData();
			if(geoTemplateValue == '') {
				$('#geoTemplateError').html('The template text field is required.');
				errors = 1;
				return valid = false;
			} else {
				$('#geoTemplateError').html('');
			}
			if($('#existImage').val() == '') {
				$('#imageError').html('The image field is required.');
				errors = 1;
				return valid = false;
			} else {
				var allowed_extensions = new Array("jpeg","jpg","png","gif","bmp","tiff","tif");
				var file_extension = $('#existImage').val().split('.').pop();
				if ($.inArray($('#existImage').val().split('.').pop().toLowerCase(), allowed_extensions) == -1) {
					$('#imageError').html("Only '.jpeg','.jpg', '.png', '.gif' formats are allowed.");
					errors = 1;
					return valid = false;
				} else {
					$('#imageError').html('');
				}
			}
			if($('select[name="director"]').val() == '') {
				$('#directorError').html('The director field is required.');
				return valid = false;
			} else {
				$('#directorError').html('');
			}
			/*Transcript validation*/
			if($('#transcript').val()!='') {
				var transcriptArray = new Array("vtt","srt");
				var fileExtension = $('#transcript').val().split('.').pop();
				if ($.inArray($('#transcript').val().split('.').pop().toLowerCase(), transcriptArray) == -1) {
					$('#transcriptError').html("<span class='help-block' style='color:red;'>The transcript must be a file of type: vtt, srt</span>");
					errors = 1;
					return valid = false;
				} else {
					$('#transcriptError').html('');
				}
			}
			/*end*/	
			if(!valid) {
				alert('am here');
				event.preventDefault();
			}
		}
	});
	$(".edit-txt .icons-ok-can").hide();
	$( ".city" ).keyup(function(e) {
		if(e.keyCode != 9){
			cit_value = $(".city").val();
			var regex = /^[a-zA-Z-\s]+$/;
			if(!regex.test(cit_value)){
				alert("Oops!, No special character and numbers are allowed.");
				$(".city").focus();
				return false;
			} else
			{
				updateSlugNew(cit_value);
			}
		}
	});
	$(".state").change(function () {
		state_value =$(".state option:selected").attr('data-attr');
		updateSlug(state_value);
	});
});
function reloadStates(val, selected) {
	url = "<?php echo url('admin/ajaxReloadStates/'); ?>";
	$.ajax({
		type: "GET",
		url: url+'/'+val,
		success: function( res ) {
			$("select[name='State']").find('option').remove().end(); // when you use end it get back to selector again and in your case your selector was "option" not the select
			if(selected == '') {
				$("select[name='State']").append(res); // you are appending an option here with values so
			} else {
				$("select[name='State']").append(res).val(selected);
			}
		}
	});
}

$(document).on("click", ".edit-txt .icon-edit", function() {
	var txt = $(".edit-name").text();
	$(".edit-name").replaceWith("<input class='edit-name' type='text' value='' maxlength='75'/>");
	$("input.edit-name").val(txt);
	var width = txt.length;
	$("input.edit-name").css("width", width+"%");
	$("input.edit-name").focus();
	$(".edit-txt .icon-edit").hide();
	$(".edit-txt .icons-ok-can").show();
	
});

$(document).on("click",".edit-txt .icon-ok", function() {
	$(".edit-txt .icon-edit").show();
	var editedVal = $("input.edit-name").val();
	var regex = /^[a-zA-Z- ]+$/;
	if(!regex.test(editedVal)){
		alert("Oops!, No special character and numbers are allowed.");
		$("input.edit-name").focus();
		$(".edit-txt .icons-ok-can").show();
		$(".edit-txt .icon-edit").hide();
		return false;
	} else {
		$(".edit-txt .icons-ok-can").hide();
		//To do ajax call to verify unique slug URL
		var url = "<?php echo url('admin/ajaxSlugUrl/'); ?>";
		var token = $('meta[name="csrf-token"]').attr('content');
		var data = {"locationId":$('input[name="locationId"]').val(), "_token":token, "slugurl":editedVal, "location":"edit"}
		$.ajax({
			url:url,
			type:"post",
			data:data,
			success:function(result) {
				if(result > 0) {
					alert("Oops!, slug url is already taken. Please update a unique slug url.");
					$("input.edit-name").focus();
					$(".edit-txt .icons-ok-can").show();
					$(".edit-txt .icon-edit").hide();
					return false;
				} else {
					$("input.edit-name").replaceWith('<span class="edit-name">'+editedVal+'</span>');
					$("#slugUrl").val(editedVal);
					$(".edit-txt .icon-edit").show();
				}
			}
		});
	}
});

$(document).on("click",".edit-txt .icon-cancel", function() {
	$(".edit-txt .icon-edit").show();
	$(".edit-txt .icons-ok-can").hide();
	var editedVal = $("#slugUrl").val();
	$("input.edit-name").replaceWith('<span class="edit-name">'+editedVal+'</span>');
});

function removeImage(i) {
	if(confirm('Are you sure want to remove image?')) {
		$('.selected-image').remove();
	}
}

function removeVideo(i) {
	if(confirm('Are you sure want to remove video?')) {
		$('.selected-video').remove();
	}
}

function removeTranscript(i) {
	if(confirm('Are you sure want to remove transcript?')) {
		$('#transcript-div').remove();
		$('#transcript-nonempty').show();

	}
}

function updateSlug(value) {
	var editedVal = $(".edit-name").text();
	var split_slug_value = editedVal .split("-");
	split_slug_value[split_slug_value.length-1]=value;
	new_slug_value = split_slug_value.join("-");
	$(".edit-name").text(new_slug_value.toLowerCase());
	$("#slugUrl").val(new_slug_value);
}
function updateSlugNew(value){
	var editedVal = $(".edit-name").text();
	var split_slug_value = editedVal .split("-");
	// New array created to replace the city value
	new_array = [];
	new_array[0] = split_slug_value[0];
	new_array[1] = split_slug_value[1];
	new_array[2] = value;
	new_array[3] = split_slug_value[split_slug_value.length-1];
	new_slug_value = new_array.join("-");
	$(".edit-name").text(new_slug_value.toLowerCase());
	$("#slugUrl").val(new_slug_value);
}


</script>