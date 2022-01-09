@extends('backpack::layout') @section('header')
<section class="content-header">
    <h1>
	    <span class="text-capitalize">Create Affiliate</span>
	  </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
        <li class="active">Create Affiliate</li>
    </ol>
</section>

@endsection @section('content')
<!-- Default box -->
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-8  col-md-offset-2">
	<a href="{{ url('admin/manageAffiliate') }}"><i class="fa fa-angle-double-left"></i> Back to <span class="text-lowercase">manage affiliate </span></a><br><br>
        <div class="box">
            <?php //echo '<pre>'; print_r($UserVal);die; ?>
                <form method="POST" action="{{url('admin/storeAffiliate')}}" id="admin_add_aff" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create</h3>
                        </div>
                        <div class="box-body">
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- text input -->
                            <div class="form-group col-md-12">
                                <label>Name<span class="red">*</span></label>

                                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
								@if ($errors->has('name'))
    								<div class="error">
    									{{ $errors->first('name') }}
    								</div>
    							@endif 
                            </div>
							<div class="form-group col-md-12">
                                <label>Address<span class="red">*</span></label>

                                <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control">
                                @if ($errors->has('address'))
                                    <div class="error">
                                        {{ $errors->first('address') }}
                                    </div>
                                @endif 
                            </div>
							<div class="form-group col-md-12">
                                <label>Phone<span class="red">*</span></label>

                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control">
                                @if ($errors->has('phone'))
                                    <div class="error">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @endif 
                            </div>

                            <div class="form-group col-md-12">
                                <label>Email<span class="red">*</span></label>

                                <input type="text" id="email" name="email" value="{{ old('email') }}" class="form-control">
                                @if ($errors->has('email'))
                                    <div class="error">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif 
                            </div>
                            <div class="form-group col-md-12">
                                <label>Commision Percentage<span class="red">*</span></label>

                                <input type="text" id="commission_percentage" name="commission_percentage" value="{{ old('commission_percentage') }}" class="form-control">
                                @if ($errors->has('commission_percentage'))
                                    <div class="error">
                                        {{ $errors->first('commission_percentage') }}
                                    </div>
                                @endif 
                            </div>
							<div class="input_fields_wrap">
								<div class="form-group">
									<label></label>
									<div class="col-md-12">
										 <input type="button" class="add_field_button" value="Add More Fields for URL"/>
									</div>
								</div>
								<div class="form-group col-md-12">
									<label>URL<span class="red">*</span></label>

									<input type="text" id="URL[]" name="URL[]" value="{{ old('URL') }}" class="form-control">
									@if ($errors->has('URL_links'))
										<div class="error">
											{{ $errors->first('URL_links') }}
										</div>
									@endif 
								</div>
							</div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
							<a href="{{url('admin/manageAffiliate')}}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">Cancel</span></a>
                        </div>
                        <!-- /.box-footer-->
                    </div>
                    <!-- /.box -->
                </form>
        </div>
    </div>
</div>
@endsection
<script src="{{ asset('public/js/jquery.min.js')}}"></script>
 <script>
	  $(document).ready(function() {
			$("#admin_add_aff").validate({
			  errorElement: "span",
			  errorPlacement: function(error, element) {
				  error.appendTo( element.parents(".form-group"));
			  },
			  rules: {
				  'name': {
					required: true,
				  },
				  'address' :{
					  required : true,
				  }, 
				  'phone' :{
					  required : true,
				  }, 
				  'email' :{
					  required : true,
				  }, 
				  'URL[]' :{
					  required : true,
				  }
			  },
			  messages:{
				  'name': {
					required: "Please enter name"
				  },
				  'address' :{
					  required : "Please enter address",
				  }, 
				  'phone' :{
					  required : "Please enter phone",
				  }, 
				  'email' :{
					  required : "Please enter email",
				  }, 
				  'URL[]' :{
					  required : "Please enter the URL",
				  }
			  }
		  });
		
		//Add more fie
		var max_fields      = 5; //maximum input boxes allowed
		var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
		var add_button      = $(".add_field_button"); //Add button ID

		var x = 1; //initlal text box count
		$(add_button).click(function(e){ //on add input button click
			e.preventDefault();
			if(x < max_fields){ //max input box allowed
				x++; //text box increment
				var htmlAppend = '<div class="form-group col-md-12"><label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label">&nbsp;</label><input id="URL[]" name="URL[]" type="text" value="" placeholder="URL" class="form-control input-md"><a href="#" class="remove_field">Remove</a>&nbsp;&nbsp;&nbsp;&nbsp;</div>';
				$(wrapper).append(htmlAppend); //add input box
			}
		});

		$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent('div').remove(); x--;
		})
	  });
	</script> 