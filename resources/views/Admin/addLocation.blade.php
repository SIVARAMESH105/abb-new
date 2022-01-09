@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    {{ trans('backpack::crud.add') }} <span class="text-lowercase">{{ $crud->entity_name }}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.add') }}</li>
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

		<form enctype="multipart/form-data" id="location" method="post" action= "{{url('admin/manageLocations')}}">
			{!! csrf_field() !!}
		  <div class="box">

		    <div class="box-header with-border">
		      <h3 class="box-title">{{ trans('backpack::crud.add_a_new') }} {{ $crud->entity_name }}</h3>
			  
		    </div>
		    <div class="box-body row">
		    <!-- load the view from the application if it exists, otherwise load the one in the package -->
				<div class="form-group col-md-12">
					<label>Camp Location<span class="red">*</span></label>
                    <input type="text" name="Location" value="{{old('Location')}}" class="form-control">
					@if ($errors->has('Location'))
						<div class="error">{{$errors->first('Location')}}</div>
					@endif
				</div>
				<div class="form-group col-md-12">
					<label>Address<span class="red">*</span></label>
					<input type="text" name="Address" value="{{old('Address')}}" class="form-control">
					@if ($errors->has('Address'))
						<div class="error">{{$errors->first('Address')}}</div>
					@endif
				</div>
				<div class="form-group col-md-4">
					<label>City<span class="red">*</span></label>
					<input type="text" name="City" value="{{old('City')}}" class="form-control city">
					@if ($errors->has('City'))
						<div class="error">{{$errors->first('City')}}</div>
					@endif
				</div>
				<div class="form-group col-md-4">
					<label>State<span class="red">*</span></label>
					<select name="State" class="form-control state">
						<option value="">Select State</option>
						@foreach($states as $state)
							<option data-attr="{{$state->state_code}}" value="{{$state->state_id}}" @if(Request::old('State') == $state->state_id) {{'selected'}} @endif>{{$state->state_name}}</option>
						@endforeach
                    </select>
					@if ($errors->has('State'))
						<div class="error">{{$errors->first('State')}}</div>
					@endif
				</div>
				<div class="form-group col-md-4">
					<label>Zip<span class="red">*</span></label>
					<input type="text" name="Zip" value="{{old('Zip')}}"class="form-control">
					@if ($errors->has('Zip'))
						<div class="error">{{$errors->first('Zip')}}</div>
					@endif
				</div>
				<div class="form-group col-md-4">
					<label>Country<span class="red">*</span></label>
					<select name="Country" class="form-control" onchange="reloadStates(this.value);">
						@foreach($countries as $country)
							<option value="{{$country->country_id}}" @if(Request::old('Country') == $country->country_id) {{'selected'}} @endif>{{$country->country_name}}</option>
						@endforeach
                    </select>
					@if ($errors->has('Country'))
						<div class="error">{{$errors->first('Country')}}</div>
					@endif
				</div>
				<div class="form-group col-md-4">
					<input type="checkbox" name="geoCheckbox" id="geoCheckbox" value="yes" @if(Request::old('geoCheckbox') =='yes') checked @endif>
					<label for="geoCheckbox">Geo-targeted location page</label>
				</div>
				<div class="form-group col-md-4">
					<label>Director<span class="red">*</span></label>
					<select name="director" class="form-control">
						<option value="">Select a Director</option>
						@foreach($directors as $key=>$director)
							<option value="{{$director}}" @if(Request::old('director') == $director){{'selected'}} @endif>{{$director}}</option>
						@endforeach
                    </select>
					<div class="error" id="directorError">@if ($errors->has('director')){{$errors->first('director')}}@endif</div>
				</div>
				<div class="form-group col-md-12">
					<label>Additional Information</label>
					<textarea name="AdditionalInfo" id="additionalText"></textarea>
				</div>
				<div class="form-group col-md-12" id="geo">
					<div class="form-group col-md-12">
						<label>Slug/URL</label>
						<p class="edit-txt">{{URL::to('/')}}/locations/<span class="edit-name">basketball-camp-<span class="geo-city">city</span>-<span class="geo-state">state</span></span>&nbsp;&nbsp;<a href="javascript:;" title="Edit"><i class="fa fa-edit icon-edit">Edit</i><span class="icons-ok-can"><i class="fa icon-ok">Ok</i> | <i class="fa icon-cancel">Cancel</i></span></a><p>
						<input type="hidden" name="title" id="slugUrl" value="basketball-camp-city-state"/>
						@if ($errors->has('title'))
							<div class="error">The slug URL has already been taken.</div>
						@endif
					</div>
					<div class="form-group col-md-12">
						<label>Title Tag</label>
						<input type="text" name="titletag" class="form-control">
					</div>
					<div class="form-group col-md-12">
						<label>Description Tag</label>
						<input type="text" name="desctag" class="form-control">
					</div>
					<h4>Main Geo-Targeted Page Text</h4>
					<div class="form-group col-md-12">
						<label>Template Text<span class="red">*</span></label>
						<textarea name="geoTemplate" id="geoTemplate">{!! $defaultGeoTemplateText !!}</textarea>
						<div class="error" id="geoTemplateError">@if ($errors->has('geoTemplate')){{$errors->first('geoTemplate')}}@endif</div>
						
					</div>
					<div class="form-group col-md-12">
						<label>Featured Image (2000 x 675 px)<span class="red">*</span></label>
						 <div class="dropzone dropzone-previews" id="feature-dropzone">
							<div class="fallback">
								<input type="file" class="form-control">
							</div>
						</div>
						<input type="hidden" name="image" id="image">
						<div class="error" id="imageError">@if ($errors->has('image')){{$errors->first('image')}}@endif</div>
					</div>
					<div class="form-group col-md-12">
						<label>Feature Image Alt Text</label>
						<input type="text" name="alt" class="form-control">
					</div>
					
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
						<label>Transcript File Upload (support .vtt, .srt format) </label>
							<div class="fallback">
								<input type="file" name="transcript" id="transcript" class="form-control">
							</div>
						<div class="error" id="transcriptError">@if ($errors->has('transcript')){{$errors->first('transcript')}}@endif</div>
					</div>
				</div>
		    </div><!-- /.box-body -->
		    <div class="box-footer">
               <input type="radio" name="redirect_after_save" value="{{ $crud->route }}" checked style="display:none">
			  <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::crud.add') }}</span></button>
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
			 dictFileTooBig: "That video is too large. We only allow 8MB or smaller.",
			 dictMaxFilesExceeded: "You can not upload any more files.",
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

		//Slug url for validation
		cityValue = $(".city").val();
		stateValue = $(".state option:selected").text();
		if(stateValue !='' && $(".state").val() !=''){
			$(".geo-state").text(stateValue);
			$("#slugUrl").val($(".edit-name").text());
		}
		if(cityValue != ''){
			$(".geo-city").text(cityValue);
			$("#slugUrl").val($(".edit-name").text());
		}

    });
</script>
<script>
$(function () {
	$('#geoCheckbox').change(function () {                
		$('#geo').toggle();
	}).change();
	
	$('#location').submit(function( event ) {
		var valid = true;
		if($("#geoCheckbox").prop('checked') == true) {
			var geoTemplateValue = CKEDITOR.instances['geoTemplate'].getData();
			if(geoTemplateValue == '') {
				$('#geoTemplateError').html('The template text field is required.');
				return valid = false;
			} else {
				$('#geoTemplateError').html('');
			}
			if($('#image').val() == '') {
				$('#imageError').html('The image field is required.');
				return valid = false;
			} else {
				var allowed_extensions = new Array("jpeg","jpg","png","gif","bmp","tiff","tif");
				var file_extension = $('#image').val().split('.').pop();
				if ($.inArray($('#image').val().split('.').pop().toLowerCase(), allowed_extensions) == -1) {
					$('#imageError').html("Only '.jpeg','.jpg', '.png', '.gif' formats are allowed.");
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
			/* if($('#video').val() == '') {
				$('#videoError').html('The video field is required.');
				errors = 1;
			} else {
				$('#videoError').html('');
			} */
			/*Transcript validation*/
			if($('#transcript').val()!='') {
				var transcriptArray = new Array("vtt","srt");
				var fileExtension = $('#transcript').val().split('.').pop(); 
				if ($.inArray($('#transcript').val().split('.').pop().toLowerCase(), transcriptArray) == -1) {
					$('#transcriptError').html("<span class='help-block' style='color:red;'>The transcript must be a file of type: vtt, srt</span>");
					return valid = false;
				} else {
					$('#transcriptError').html('');
				}
			}
			/*end*/	
			
			if(!valid) {
				event.preventDefault();
			}
		}
	});
	
	$(".edit-txt .icons-ok-can").hide();
	$( ".city" ).keyup(function(e) {
		if(e.keyCode != 9){
			var regex = /^[a-zA-Z-\s]+$/;
			cit_val= $(".city").val();
			if(!regex.test(cit_val)){
				alert("Oops!, No special character and numbers are allowed.");
				$(".city").focus();
				return false;
			} else {
				//var city = $(".city").val();
				$(".geo-city").text(cit_val.toLowerCase());
				var editedVal = $(".edit-name").text();
				var result = editedVal.toLowerCase();
				$("#slugUrl").val(result);
			}
		}
	});
	$(".state").change(function () {
		var stateCode = $(".state option:selected").attr('data-attr');
		$(".geo-state").text(stateCode);
		var editedVal = $(".edit-name").text();
		var result = editedVal.toLowerCase();
		$("#slugUrl").val(result);
	});
		
		
});
function reloadStates(val) {
	url = "<?php echo url('admin/ajaxReloadStates/'); ?>";
	$.ajax({
		type: "GET",
		url: url+'/'+val,
		success: function( res ) {
			$("select[name='State']")
			.find('option')
			.remove()
			.end() // when you use end it get back to selector again and in your case your selector was "option" not the select
			.append(res); // you are appending an option here with values so
			//.val('your selecteble value'); You can select the default options by giving the value
		}
	});
}


$(document).on("click", ".edit-txt .icon-edit", function() {
	var txt = $(".edit-name").text();
	$(".edit-name").replaceWith("<input class='edit-name' type='text' value='' maxlength='75'/>");
	$("input.edit-name").val(txt);
	$("input.edit-name").css("width", "25%");
	$("input.edit-name").focus();
	$(".edit-txt .icon-edit").hide();
	$(".edit-txt .icons-ok-can").show();
	
});

$(document).on("click",".edit-txt .icon-ok", function() {
	$(".edit-txt .icon-edit").show();
	var editedVal = $("input.edit-name").val();
	var regex = /^[a-zA-Z- ]+$/;
	if(!regex.test(editedVal)){
		alert("Oops!, No special character, and numbers are allowed.");
		$("input.edit-name").focus();
		$(".edit-txt .icons-ok-can").show();
		$(".edit-txt .icon-edit").hide();
		return false;
	} else {
		$(".edit-txt .icons-ok-can").hide();
		//To do ajax call to verify unique slug URL
		var url = "<?php echo url('admin/ajaxSlugUrl/'); ?>";
		var token = $('meta[name="csrf-token"]').attr('content');
		var data = {"location":"add","_token":token,"slugurl":editedVal}
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
	var city = $(".city").val();
	var state = $(".state option:selected").text();
	//$("input.edit-name").replaceWith('<span class="edit-name">'+editedVal+'</span>');
	$("input.edit-name").replaceWith('<span class="edit-name">'+'basketball-camp-'+'<span class="geo-city">'+city+'</span>-<span class="geo-state">'+state+'</span></span>');
});

</script>