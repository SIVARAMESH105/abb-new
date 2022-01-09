@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    {{ trans('backpack::crud.add') }} <span class="text-lowercase">{{ $crud->entity_name }}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.add') }} {{$crud->entity_name}}</li>
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

		  {!! Form::open(array('url' => $crud->route, 'method' => 'post', 'files'=>$crud->hasUploadFields('create'))) !!}
		  <div class="box">

		    <div class="box-header with-border">
		      <h3 class="box-title">{{ trans('backpack::crud.add_a_new') }} {{ $crud->entity_name }}</h3>
		    </div>
		    <div class="box-body">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @endif
		    </div><!-- /.box-body -->
		    <div class="box-footer">
               <input type="radio" name="redirect_after_save" value="{{ $crud->route }}" checked style="display:none">
			  <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::crud.add') }}</span></button>
		      <a href="{{ url($crud->route) }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">{{ trans('backpack::crud.cancel') }}</span></a>
		    </div><!-- /.box-footer-->

		  </div><!-- /.box -->
		  {!! Form::close() !!}
	</div>
</div>

@endsection
@php
$url = explode('/', Request::url());
@endphp
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(function () {
	requestUrl = "{{$url[4].'/'.$url[5]}}";
	if(requestUrl == 'manageCamps/create') {
		// Applying styles and displaying span
		$('select[name=LocationId]').prev('label').css({"display": "inherit"});
		$('select[name=LocationId]').css({"width": "70%", "display": "inline"});
		$('select[name=LocationId]').after("<span><b>State: City: </b></span>");
		
		// Sorting all options in order
		var location_options =$('select[name=LocationId] option');
		location_options.sort(function(a,b) {
			if (a.text > b.text) return 1;
			if (a.text < b.text) return -1;
			return 0
		})
		$('select[name=LocationId]').empty().append( location_options );
		$('select[name=LocationId]').prepend("<option value='' selected='selected'>Select Location</option>");
		
		// Updating state and city value onchange location
		$('select[name=LocationId]').change(function() {
			url = "<?php echo url('admin/ajaxGetStateCityName/'); ?>";
			$.ajax({
				type: "GET",
				url: url+'/'+this.value,
				success: function ( res ) {
					names = res.split('/');
					$('select[name=LocationId]').next("span").remove();
					$('select[name=LocationId]').after("<span><b>State: </b>"+names[0]+" <b>City: </b>"+names[1]+"</span>");
				}
			});
		});
	}
	
	// Validating the username availability
	if(requestUrl == 'manageCoaches/create') {
		$('input[name=username]').after('<input type="hidden" name="username_validate" class="username_validate" value="">');
		$("input[name=username]").blur(function(){
			if($('input[name=username]').val() != '') {
				if($('.username_validate').val() == '') {
					usernameAvail(this.value);
				}
			}
		});
		$("form").submit(function() {
			if($('.username_validate').val() == 1){
				return false;
			}
		});
	}
});

function usernameAvail(val)
{
	url = "<?php echo url('admin/ajaxUsernameAvail/'); ?>";
	$.ajax({
		type: "GET",
		url: url+'/'+val,
		async: false,
		success: function (res) {
			if(res > 0){
				$('input[name=username]').after('<div style="color:red;">This username is already exist.</div>');
				$('.username_validate').val(1);
			} else {
				$('input[name=username]').next('div').remove();
				$('.username_validate').val('');
			}
		}
	});
}
</script>