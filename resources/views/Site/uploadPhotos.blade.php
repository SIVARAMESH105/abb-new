@include("Site.header")
<style>
.error{
    color:red;
}
</style>
    <section>
        
        <div class="secondary-top">
            @if (session('status'))          
                <div class="alert alert-success">  
                    <a class="panel-close close" data-dismiss="alert">&times;</a>                
                    {{ session('status') }}
                </div>
            @endif
            <div class="container container-md search-content">
                <div class="bg-white-section">
                <fieldset>
                    <div class="col-xs-12">
                        <h1>Upload Photo</h1>
                        <form action="{{ url('uploadPhotos') }}" class="form-horizontal" method="POST" name="uploadphotos" id="uploadphotos" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <!-- <input type="hidden" name="recipient" value="info@advantagebasketball.com"> --> 
                            @if (session('success')) 
                                <div class = "alert alert-success" class=".alert-success">
                                    <ul>
                                        <li type="square">{{ session('success') }}</li>
                                    </ul>
                                </div>
                            @endif                           
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add1">Name <span class="important">*</span></label>  
                                <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                    <input name="realname" type="Text" id="realname" placeholder="Name" value="{{ old('realname') }}" maxlength="100" class="form-control input-md"> 
                                </div>
                                @if ($errors->has('realname'))
                                    <div class="error">{{ $errors->first('realname') }}</div>
                                @endif
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Email <span class="important">*</span></label>  
                                <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                    <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" maxlength="100" class="form-control input-md">
                                </div>
                                @if ($errors->has('email'))
                                    <div class="error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Phone <span class="important">*</span></label>  
                                <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                    <input name="phone" type="Text" id="phone" placeholder="Phone" value="{{ old('phone') }}" maxlength="15" class="form-control input-md">
                                    @if ($errors->has('phone'))
                                        <div class="error">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>
                                
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Image <span class="important">*</span></label>  
                                <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                    <input type="file" name="basketimages" id="basketimages" class="form-control input-md">
                                    @if ($errors->has('basketimages'))
                                        <div class="error">{{ $errors->first('basketimages') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Image Caption <span class="important">*</span></label>  
                                <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                    <input type="text" name="caption" id="caption" max-length="255" placeholder="Image Caption"class="form-control input-md" value="{{ old('caption') }}">
                                @if ($errors->has('caption'))
                                    <div class="error">{{ $errors->first('caption') }}</div>
                                @endif
                                </div>                                
                            </div>
                        
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="submit"></label>
                              <div class="col-md-3 col-sm-6 col-xs-12 custom-btn">
                                <button type="submit" id="submit" name="submit" class="btn btn-primary" style="margin-top: 15px;">Upload</button>
                              </div>
                            </div>

                            </fieldset>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
    @php $base_url = \URL::to(''); @endphp
    <script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
    <script>
    $("#uploadphotos").validate({
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.appendTo( element.parents(".error-cls"));
        },
        rules: {
            'realname': {
              required: true,
            },
            'email' :{
                required : true,
            },
            'phone' :{
                required : true,
            },
            'basketimages' :{
                required :true,
            },
            'caption' :{
                required :true,
            }
        },
        messages:{
            'realname': {
              required: "Please enter name"
            },
            'email' :{
                required : "Please enter email",
            },
            'phone' :{
                required : "Please enter phone",
            },
            'basketimages' :{
                required : "Please upload images",
            },
            'caption' :{
                required : "Please enter a caption for image",
            }
        }
    });
     $("#uploadphotos").find("button[type='submit']").on("submit",function(e){
        
        if($("#uploadphotos").valid()) { 
            $(this).submit();
        } else {
            return false;
        }
    });
    </script>
    <script>
        setTimeout(function() {
         $('.alert-success').fadeOut();
        }, 5000 );
    </script>
    
    <!--<script>
    function formValidation() {
        valid = true;
        var name = document.contactform.realname.value;
        var email = document.contactform.email.value;
        var state = document.contactform.state.value;
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(name.trim() == '') {
            $('#realname').css("border-color", "red");
            document.contactform.realname.focus();
            valid = false;
        } else {
            $('#realname').css("border-color", "");
        }
        if(email.trim() == '') {
            $('#email').css("border-color", "red");
            document.contactform.email.focus();
            valid = false;
        } else if(!regex.test(email)) {
            $('#email').css("border-color", "red");
            document.contactform.email.focus();
            valid = false;
        } else {
            $('#email').css("border-color", "");
        }
        if(state.trim() == '') {
            $('#state').css("border-color", "red");
            document.contactform.state.focus();
            valid = false;
        } else {
            $('#state').css("border-color", "");
        }
        return valid;
    }
    </script>-->
</body>
</html>
