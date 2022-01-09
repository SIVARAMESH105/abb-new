@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">{{ucfirst($pageContent[0]->title)}}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active"><a href="{{url('admin/cms')}}">CMS</a></li>
	    <li class="active">{{ucfirst($pageContent[0]->title)}}</li>
	  </ol>
	</section>
@endsection 
@section('content')
<!-- Default box -->
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
		<div class="box">
			<div class="box-body table-responsive">				
				<form enctype="multipart/form-data" method="post" action="{{url('admin/updateCms/'.$pageId)}}">
					{!! csrf_field() !!}
					<table id="crudTable" class="table table-bordered table-striped display">
						<tr>
							<th>Url</th>
								@if($pageContent[0]->title != '')
									<td>
									<input class="form-control" type="text" name="title" value="{{$pageContent[0]->title}}" disabled >
									</td>
								@else
									<td>
									<input class="form-control" type="text" name="title" value="">
									</td>
								@endif
						</tr>
						<tr>
							<th>Meta Title</th>
								@if($metaTitleVal[0]->meta_title != '')  
									<td>
									<input class="form-control" type="text" name="meta_title" value="{{$metaTitleVal[0]->meta_title}}"  >
									</td>
								@else     
								  
									<td>
									<input class="form-control" type="text" name="meta_title" value="">
									</td>
								@endif	
						</tr>   
						<!--@php unset($pageContent[0]->title); @endphp-->     
								<th>Meta Description</th>
								@if($metaVal[0]->meta != '')
									<td>
									<textarea name="meta" id="meta"><?php echo htmlspecialchars($metaVal[0]->meta);?></textarea>
									
									</td>
								@else
									<td>
									<textarea name="meta" id="meta"></textarea>
									
									</td>
								@endif
								
						@foreach ($pageContent[0] as $column => $content)    
							<tr>
								@if($fieldTypes[$column] == 'editor')
								<th>{{str_replace('_', ' ', ucfirst($column))}} </th>
								@elseif($fieldTypes[$column] == 'upload') 
								<th>{{str_replace('_', ' ', ucfirst($column))}} - 725 Wide x 264 height</th>
								@endif   
								<td>  
									@if($fieldTypes[$column] == 'editor')
										<textarea name="{{$column}}" id="{{$column}}">{{$content}}</textarea>
										
									@elseif($fieldTypes[$column] == 'upload')  
										@if($content != '')
											<img src="{{url('public/uploads/images/cms/'.$content)}}" width="100px" height="100px">
										@endif     
										<input type="file" name="img_{{$column}}" id="img_{{$column}}" value="{{$content}}">
										<a  data-id="{{$imgName[0]->id}}" data-column= "{{$column}}" class="btn btn-xs btn-default slider-image"  data-button-type="delete"><i class="fa fa-trash"></i>Remove</a>  
										<input type="hidden" name="{{$column}}" value="{{$content}}">
										@php $errorImg = 'img_'.$column; @endphp   
										@if ($errors->has($errorImg))
											<div class="error">{{$errors->first($errorImg)}}</div>
										@endif
										
									@endif
									
								</td>
							</tr>
						@endforeach  
						@if($pageTypeVal[0]->page_type != 'homepage')  
						<tr>
							<th>Feature Image</th>
							<td>
							@if($imgName[0]->image1 != '')
								<img src="{{url('public/uploads/images/cms/'.$imgName[0]->image1)}}" width="100px" height="100px">
							@endif
							<input type="file" name="feature_image" id="feature_image">
							<a  data-id="{{$imgName[0]->id}}" data-column= "image1" class="btn btn-xs btn-default" id="delete-image" data-button-type="delete"><i class="fa fa-trash"></i>Remove</a>
							<div id="imageError"></div>	   						
								@if ($errors->any())
									 @foreach ($errors->all() as $error)
										 <div class="error">{{$error}}</div>
									 @endforeach
								 @endif
							</td>
						</tr>
						@endif  

						<tr>
							<td colspan="2" align="center">
								<input type="submit" name="update" value="Update">
								<input type="button" name="cancel" value="Cancel" onClick="window.history.back();">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('after_styles')
  
  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
<script>
    ClassicEditor
    .create(document.querySelector('#meta'))
    .catch(error=>{
        console.error(error);
    });
    ClassicEditor
    .create(document.querySelector('#content'))
    .catch(error=>{
        console.error(error);
    }); 
     ClassicEditor
    .create(document.querySelector('#sidebar'))
    .catch(error=>{
        console.error(error);
    });                                                  
</script>
    <script>
        $(document).ready(function(){ 
        	/*Remove the Feature image code  on the cms section*/  
			$("#delete-image").on('click', function() {
				var checkstr =  confirm('Are you sure you want to remove this Image?');
				if(checkstr == true){
					var cms_id = $(this).attr("data-id"); 
					var column = $(this).attr("data-column");
					var token = jQuery('meta[name="csrf-token"]').attr('content');
					url = "<?php echo url('admin/ajaxDeleteFeatureimage'); ?>";
					$.ajax({
						url: url,
					    type: 'POST',
						data: {"_token":token, cms_id: cms_id,column: column},
					    success: function(data) {
					        //jQuery(".location-div").html(data);
					        alert(data.msg);
					        location.reload();      
					    }
					});
				}else{
					return false;
				}	
			});         

			$(".btn.btn-xs.btn-default.slider-image").on('click', function() {
				var checkstr =  confirm('Are you sure you want to remove this Image?');
				if(checkstr == true){
					var cms_id = $(this).attr("data-id");
					var column = $(this).attr("data-column");    
					var token = jQuery('meta[name="csrf-token"]').attr('content');
					url = "<?php echo url('admin/ajaxDeleteFeatureimage'); ?>";
					$.ajax({
						url: url,
					    type: 'POST',
						data: {"_token":token, cms_id: cms_id,column: column},
					    success: function(data) {
					        //jQuery(".location-div").html(data);
					        alert(data.msg);
					        location.reload();      
					    }
					});
				}else{
					return false;
				}	  
				
			});          
            CKEDITOR.replace( 'meta' ); 
            CKEDITOR.replace( 'content' );              
            CKEDITOR.replace( 'sidebar' );              
        });
        $("#feature_image").on("change", function(e) {
      $('#imageError').html('');
      var allowed_extensions = new Array("jpg","jpeg","png","gif");
      var file_extension = $('#feature_image').val().split('.').pop();        
      if ($.inArray($('#feature_image').val().split('.').pop().toLowerCase(), allowed_extensions) == -1) {
          $('#imageError').html("<span id='doc_file-error' class='error invalid-feedback' style='display: inline;'>Only jpg,jpeg,png,gif format are allowed</span>");                    
          $("#feature_image").addClass("is-invalid");
          $("#feature_image").attr("aria-describedby","doc_file-error");
          $("#feature_image").attr("aria-invalid","true");
      } else {
          $('#imageError').html('');
          $("#doc_file").removeClass("is-invalid");
          $("#doc_file").attr("aria-describedby","");
          $("#doc_file").attr("aria-invalid","true");
      }
               
  });   
    </script>
	<script type="text/javascript">
	  jQuery(document).ready(function($) {
			//jQuery( '#meta','#content').ckeditor();
			
	  });
	</script>
  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection