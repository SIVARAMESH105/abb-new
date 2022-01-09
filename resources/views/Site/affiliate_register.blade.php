  @include("Site.header")
  <style>
  .error{
  	color:red;
  }
  </style>	

  <div class="secondary-top ">
    @if (session('status'))          
    		<div class="alert alert-success">  
    			<a class="panel-close close" data-dismiss="alert">&times;</a>                
    			{{ session('status') }}
    		</div>
    @endif
    @if (session('error'))
    	<div class="alert alert-danger">
    		<a class="panel-close close" data-dismiss="alert">&times;</a>  
    		{{ session('error') }}
    	</div>
    @endif
	@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class ="container container-sm search-content">          
        <form id="affiliateRegister" action="{{url('affiliate/registerSave')}}" method="post" class="form-horizontal search-content">
        {{ csrf_field() }}
        <fieldset>

      <!-- Form Name -->
      <div class="container container-sm">
        <div class="row">
          <div class="col-md-12">
            <h2 class="text-center"> Affiliate Registration Form</h2>
          </div>
        </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="name">Name <span class="important">*</span></label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
			<input id="name" name="name" type="text" placeholder="Name" value="{{old('name')}}" class="form-control input-md" >
			@if ($errors->has('name'))
				<div class="error">{{$errors->first('name')}}</div>
			@endif
          
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="address">Address <span class="important">*</span></label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
			<input id="address" name="address" type="text" placeholder="Address" value="{{old('address')}}" class="form-control input-md">
			@if ($errors->has('address'))
				<div class="error">{{$errors->first('address')}}</div>
			@endif
        </div>
      </div>
	  <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="phone">Phone <span class="important">*</span></label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
			<input id="phone" name="phone" type="text" placeholder="Phone" value="{{old('phone')}}" placeholder="Email" class="form-control input-md">
			@if ($errors->has('phone'))
				<div class="error">{{$errors->first('phone')}}</div>
			@endif
        </div>
       </div>

      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="email">Email <span class="important">*</span></label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
			<input id="email" name="email" type="email" placeholder="Email" value="{{old('email')}}" placeholder="Email" class="form-control input-md" >
			@if ($errors->has('email'))
                <div class="error" >{{ $errors->first('email') }}</div>
            @endif
        </div>
      </div>
	  <div class="input_fields_wrap">
			<div class="form-group">
				<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add-more"></label>
				<div class="col-md-7">
					 <input type="button" class="add_field_button" value="Add More Fields for URL"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="url">URL <span class="important">*</span></label>  
				<div class="col-md-3 col-sm-6 col-xs-12">
					<input id="URL[]" name="URL[]" type="text" value="{{old('URL')}}" placeholder="URL" class="form-control input-md">
				</div>
			</div>
		</div>
      <!-- Button -->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="submit"></label>
        <div class="col-md-7">
            <input type="submit" id="submit" name="submit" class="btn btn-primary" value="SUBMIT"/>
        </div>
      </div>
      </fieldset>
      </form>
  </div>

  	</div>
    </div>
      </section>
      @include("Site.features")
      @include("Site.footer")
	  <script>
	  $(document).ready(function() {
			$("#affiliateRegister").validate({
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
				var htmlAppend = '<div class="form-group"><label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label">&nbsp;</label><div class="col-md-3 col-sm-6 col-xs-12"><input id="URL[]" name="URL[]" type="text" value="" placeholder="URL" class="form-control input-md"><a href="#" class="remove_field">Remove</a></div></div>';
				$(wrapper).append(htmlAppend); //add input box
			}
		});

		$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent().parent('div').remove(); x--;
		})
	  });
	</script>
  </body>
  </html>