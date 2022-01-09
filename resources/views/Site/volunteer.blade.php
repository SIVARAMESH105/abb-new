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
                    @if($pageContent[0]->image1 != '')
                        <div class="banner-wrap header-image">
                            <img src="{{ url('public/uploads/images/cms//'.$pageContent[0]->image1) }}" alt="Banner image">
                        </div>
                    @endif
                    <h1>volunteer</h1>                     
                    @php echo $pageContent[0]->content; @endphp
                    <div class="col-xs-12">
                        <form action="{{url('site/contactAction')}}" class="form-horizontal" method="POST" name="contactform" id="contactform">
                            {!! csrf_field() !!}
                            <input type="hidden" name="recipient" value="info@advantagebasketball.com">
                            <p></p>
                            
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add1">Name <span class="important">*</span></label>  
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                <input name="realname" type="Text" id="realname" value="" size="30" maxlength="50" class="form-control input-md"> 
                              </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Email <span class="important">*</span></label>  
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                              <input type="email" name="email" id="email" value="" size="30" maxlength="50" class="form-control input-md">
                              </div>
                            </div>


                            <!-- Text input-->
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Address</label>  
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                              <input name="address" type="Text" id="address" value="" size="30" maxlength="50" class="form-control input-md">
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">City</label>  
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                <input name="city" type="Text" id="city" value="" size="30" maxlength="50" class="form-control input-md">
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">State <span class="important">*</span></label>  
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                <input name="state" type="Text" id="state" value="" size="30" maxlength="50" class="form-control input-md">
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Zip Code</label>  
                             <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                <input name="zipcode" type="Text" id="zipcode" value="" size="30" maxlength="50" class="form-control input-md">
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Phone</label>  
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                <input name="phone" type="Text" id="phone" value="" size="30" maxlength="50" class="form-control input-md">
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Fax</label>  
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                <input name="fax" type="Text" id="fax" value="" size="30" maxlength="50" class="form-control input-md">
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="hearabout">How did you hear about us </label>
                              <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                <select id="hearabout" name="hearabout" class="form-control input-md" >
                                    <option value="">Select</option>
                                    @foreach($hearabout as $key=>$hear)
                                        <option value="{{$key}}" {{ (old('hearabout') == $key) ? "selected ='selected'" : '' }}>{{$hear}}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Enter any comments or questions here</label>  
                                <div class="col-md-3 col-sm-6 col-xs-12  error-cls">
                                  <textarea name="comments" value="{{ old('comments') }}" style="width: 100%;"></textarea>
                                  <p>If you have any questions, please <a href="mailto:info@advantagebasketball.com">email</a> or call us at 425-670-8877. Please print a copy of this form for your records before clicking the Submit button below.</p>
                                </div>
                            </div>
                            <span class="bodytext" style="margin-left: 32%;">We appreciate your questions and your feedback!</span>
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="submit"></label>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="submit" id="submit" name="submit" class="btn btn-primary" style="margin-top: 15px;     margin-left: 40%;">Send to us</button>
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
    $("#contactform").validate({
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
            'state' :{
                required : true,
            }
        },
        messages:{
            'realname': {
              required: "Please enter name"
            },
            'email' :{
                required : "Please enter email",
            }, 
            'state' :{
                required : "Please enter state",
            }
        }
    });
     $("#contactform").find("button[type='submit']").on("submit",function(e){
        
        if($("#contactform").valid()) { 
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
