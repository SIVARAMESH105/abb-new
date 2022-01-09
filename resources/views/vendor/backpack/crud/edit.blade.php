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

		  {!! Form::open(array('url' => $crud->route.'/'.$entry->getKey(), 'method' => 'put', 'files'=>$crud->hasUploadFields('update', $entry->getKey()))) !!}
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
		    <div class="box-body">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', ['fields' => $fields, 'action' => 'edit'])
		      @else
		      	@include('crud::form_content', ['fields' => $fields, 'action' => 'edit'])
		      @endif
		    </div><!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::crud.save') }}</span></button>
		      <a href="{{ url($crud->route) }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">{{ trans('backpack::crud.cancel') }}</span></a>
			  <?php
				if(Request::segment(2) == 'manageCoaches' && Request::segment(4) == 'edit') {
					$assignmentsUrl = 'window.location.href=admin/coachAssignments/';
					echo '<a href="'.URL::to('/admin/coachAssignment/'.Request::segment(3)).'"><button type="button" class="btn ladda-button" data-style="zoom-in">View Assignments</button></a>';
				}
			?>
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
	requestUrl = "{{$url[4].'/'.$url[6]}}";
	if(requestUrl == 'manageCamps/edit') {
		// Applying styles and displaying span
		$('select[name=LocationId]').prev('label').css({"display": "inherit"});
		$('select[name=LocationId]').css({"width": "70%", "display": "inline"});
		
		// Sorting all options in order
		var location_options =$('select[name=LocationId] option');
		var selected = $('select[name=LocationId]').val();
		location_options.sort(function(a,b) {
			if (a.text > b.text) return 1;
			if (a.text < b.text) return -1;
			return 0
		})
		$('select[name=LocationId]').empty().append( location_options );
		$('select[name=LocationId]').val(selected);
		$('select[name=LocationId]').prepend("<option value=''>Select Location</option>");
		
		// Updating state and city value on document ready
		url = "<?php echo url('admin/ajaxGetStateCityName/'); ?>";
		$.ajax({
			type: "GET",
			url: url+'/'+selected,
			success: function ( res ) {
				names = res.split('/');
				$('select[name=LocationId]').next("span").remove();
				$('select[name=LocationId]').after("<span><b>State: </b>"+names[0]+" <b>City: </b>"+names[1]+"</span>");
			}
		});
		
		// Updating state and city value onchange location
		$('select[name=LocationId]').change(function() {
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
	if(requestUrl == 'manageCoaches/edit') {
		$('input[name=username]').after('<input type="hidden" name="exist_username" class="exist_username" value="">');
		$('input[name=username]').after('<input type="hidden" name="username_validate" class="username_validate" value="">');
		$('.exist_username').val($('input[name=username]').val());
		$("input[name=username]").blur(function(){
			if($('.exist_username').val() != $('input[name=username]').val()) {
				if($('.username_validate').val() == '') {
					usernameAvail(this.value);
				}
			} else {
				$('input[name=username]').next('div').remove();
				$('.username_validate').val('');
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