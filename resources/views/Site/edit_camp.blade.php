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
    @if($errors->any())
        <div class="alert alert-danger">
            <a class="panel-close close" data-dismiss="alert">&times;</a>
        {{$errors->first()}}
        </div>
    @endif
    <div class ="container container-sm search-content">          
        <form id="EditRegisteredCamp" action="{{url('user/editRegisteredCamp')}}" method="post" class="form-horizontal search-content">
        {{ csrf_field() }}
        <input type="hidden" name="roster_id" value="{{ $roster_id }}">
        <fieldset>
        <!-- Form Name -->
        <div class="container container-sm">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Edit Camp</h2>
                </div>
            </div>
            <div class="page-header">
                <h4 class="">1.GENERAL INFORMATION</h4>      
            </div>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Students's Name <span class="important">*</span></label>  
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input id="student_name" name="student_name" type="text" placeholder="First Name" value="<?php if(old('student_name') !='') echo old('student_name'); elseif(!empty($user_details->name)) echo $user_details->name; else '';?>" class="form-control input-md" required="">
                </div>
            </div>

            <!-- Text input-->
            <!-- <div class="form-group">
                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Students's Last Name <span class="important">*</span></label>  
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input id="last_name" name="last_name" type="text" placeholder="Last Name" value="<?php if(old('last_name') !='') echo old('last_name');  elseif(!empty($user_details->fname)) echo $user_details->fname; else '';?>" class="form-control input-md">
          
                </div>
            </div> -->

            <div class="form-group">
                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Email <span class="important">*</span></label>  
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input id="user_email" name="user_email" type="email" value="<?php if(old('user_email') !='') echo old('user_email'); else if(!empty($user_details->email)) echo $user_details->email; else ''; ?>" placeholder="Email" class="form-control input-md" required="">
          
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="gender">Gender <label style="color:red;">*</label></label>
                <div class="col-md-3 col-sm-6 col-xs-12"> 
                    <label class="radio-inline" for="gender-0">
                        <input type="radio" name="gender" id="gender-0" value="male" <?php if($user_details->gender=='male'){ echo "checked=checked";} ?>> Male 
                    </label> 
                    <label class="radio-inline" for="gender-1">
                        <input type="radio" name="gender" id="gender-1" value="female" <?php if($user_details->gender=='female'){ echo "checked=checked";} ?>> Female 
                    </label>
                </div>
            </div>
            <?php 
                $orderdate = explode('-', $user_details->dob);
                $year = $orderdate[0];
                $selected_month = $orderdate[1];
                $day  = $orderdate[2];
            ?>
        <div class="form-group">
            <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="gender">Birthdate <span class="important">*</span></label>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="row date-select-custom">
                    <div class="col-md-3 col-xs-4"> 
                        <select class="form-control input-sm" name="date" value="{{ old('date') }}" required="">
                            <option value="">DD</option>
                            @for($i=1; $i<=31; $i++)              
                                <option value="{{$i}}" @if($i==$day) {{"selected ='selected'"}} @elseif(old('date') == $i) {{"selected ='selected'"}} @endif>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <select class="form-control input-sm" name="month" value="{{ old('month') }}" required="">
                            <option value="">MM</option>
                            @php $i=1; @endphp
                            @foreach($month_values as $key=>$month) 
                                <option value="{{$key}}" @if(old('month') == $i) {{"selected ='selected'"}} @elseif($i==$selected_month) {{"selected ='selected'"}} @endif >{{$month}}</option>
                                @php $i++; @endphp
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 col-xs-4">
                        <select class="form-control input-sm" name="year" value="{{ old('year') }}" required="">
                            <option value="">YYYY</option>
                            @for($i=1990; $i<=2015; $i++)             
                                <option value="{{$i}}" @if($i == $year) {{"selected ='selected'"}} @elseif(old('year') == $i) {{"selected ='selected'"}} @endif>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="cmpny">Most Recent Grade Level <span class="important">*</span></label>  
            <div class="col-md-3 col-sm-6 col-xs-12">
                <input id="grade_level" name="grade_level" type="text" placeholder="Grade Level" value="<?php if(old('grade_level') !='') echo old('grade_level'); else if(!empty($user_details->grade)) echo $user_details->grade; else '';?>" class="form-control input-md" required="">
          
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Parent/Guardian First Name <span class="important">*</span></label>  
            <div class="col-md-3 col-sm-6 col-xs-12">
                <input id="first_name" name="parent_first_name" type="text" placeholder="Parent/Guardian First Name" value="<?php if(old('parent_first_name') !='') echo old('parent_first_name'); else if(!empty($user_details->parent_firstname)) echo $user_details->parent_firstname; else ''; ?>" class="form-control input-md" required="">
          
            </div>
        </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Parent/Guardian Last Name</label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
        <input id="last_name" name="parent_last_name" type="text" placeholder="Parent/Guardian Last Name" value="<?php if(old('parent_last_name') !='') echo old('parent_last_name'); else if(!empty($user_details->parent_lastname)) echo $user_details->parent_lastname; else ''; ?>" class="form-control input-md">
          
        </div>
      </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Address <span class="important">*</span></label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
        <input id="address" name="address" type="text" placeholder="Address" value="<?php if(old('address') !='') echo old('address'); else if(!empty($user_details->address)) echo $user_details->address; else ''; ?>" class="form-control input-md" required="">
          
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="email">City <span class="important">*</span></label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
        <input id="city" name="city" type="text" placeholder="City" value="<?php if(old('city') !='') echo old('city'); else if(!empty($user_details->city)) echo $user_details->city; else ''; ?>" class="form-control input-md" required="">
          
        </div>
      </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="email">State (OT for "Other") <span class="important">*</span></label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
        <input id="state" name="state" type="text" placeholder="State" maxlength =3 value="<?php if(old('state') !='') echo old('state'); else if(!empty($user_details->state)) echo $user_details->state; else ''; ?>" class="form-control input-md" required="">
          
        </div>
      </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="email">ZIP/Postal Code <span class="important">*</span></label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
        <input id="zip_code" name="zip_code" type="text" placeholder="Zip code" maxlength =6 value="<?php if(old('zip_code') !='') echo old('zip_code'); else if(!empty($user_details->zip)) echo $user_details->zip; else ''; ?>" class="form-control input-md" required="">
          
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="selectbasic">Country <span class="important">*</span></label>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <select id="country" name="country" class="form-control input-md" value="{{ old('country') }}" required="">
        <?php //echo '<pre>'; print_r($country_details);die;?>
          <option value="">Select</option>
        @foreach($country_details as $key => $details)
          <option value="{{$key}}" @if($countrysele == $key) selected='selected' @endif>{{$details}}</option>
        @endforeach
          </select>
        </div>
      </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add1">Home Phone <span class="important">*</span></label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
        <input id="home_phone" name="home_phone" type="text" maxlength=20 value="<?php if(old('home_phone') !='') echo old('home_phone'); else if(!empty($user_details->home_phone)) echo $user_details->home_phone; else ''; ?>" placeholder="Home Phone" class="form-control input-md" required="">
          
        </div>
      </div>


      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="add2">Work/Other Phone</label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
        <input id="other_phone" name="other_phone" type="text" maxlength=20 value="<?php if(old('other_phone') !='') echo old('other_phone'); else if(!empty($user_details->work_phone)) echo $user_details->work_phone; else ''; ?>" placeholder="Work Phone" class="form-control input-md">
          
        </div>
      </div>


      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Parent E-mail <span class="important">*</span></label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
        <input id="parent_email" name="parent_email" type="email" value="<?php if(old('parent_email') !='') echo old('parent_email'); else if(!empty($user_details->parent_email)) echo $user_details->parent_email; else ''; ?>" placeholder="Parent Email" class="form-control input-md" required="">
          
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Confirm E-mail <span class="important">*</span></label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
        <input id="confirm_email" name="confirm_email" type="text" value="{{ old('confirm_email') }}" placeholder="Confirm E-mail" class="form-control input-md" required="">
        </div>
      </div>

      <!-- Select Basic -->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="hearabout">How did you hear about us <span class="important">*</span></label>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <select id="hearabout" name="hearabout" class="form-control input-md" required="">
          <option value="">Select</option>
          @foreach($hearabout as $key=>$hear)
            <option value="{{$key}}" <?php if (old('hearabout') == $key) { echo "selected ='selected'"; } elseif ($existinghearabout == $key) { echo "selected ='selected'"; }?>>{{$hear}}</option>
          @endforeach
        </select>
        </div>
      </div>
      <div class="page-header">
          <h4 class="">2.BASKETBALL EXPERIENCE</h4>      
      </div>
      
     <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="session_before">Have you attended an Advantage Basketball Camps session before? <label style="color:red;">*</label></label>
        <div class="col-md-3 col-sm-6 col-xs-12"> 
          <label class="radio-inline" for="session_before-0">
            <input type="radio" name="session_before" id="session_before-0" value="yes" <?php if($user_details->basketball_exp=='yes'){ echo "checked=checked";}  ?>>
            Yes
          </label> 
          <label class="radio-inline" for="session_before-1">
            <input type="radio" name="session_before" id="session_before-1" value="no" <?php if($user_details->basketball_exp=='no'){ echo "checked=checked";}  ?>>
            No
          </label>
        
        </div>
      </div>
    
    <div class="form-group if-yes" >
      <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">If yes, city/state, and year</label>  
          <div class="col-md-3 col-sm-6 col-xs-12">
          <input id="other_session" name="other_session" type="text" value="<?php if($user_details->basketball_exp_desc !='') echo $user_details->basketball_exp_desc; else ''; ?>" placeholder="" class="form-control input-md" >
        </div>
    </div>
      <div class="form-group">
      
      <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="rating">How woud you rate your basketball skills and abilities? <span class="important">*</span></label>
       <div class="col-md-3 col-sm-6 col-xs-12 radio-input-custom"> 
        <label class="radio-inline" for="rating-0">
          <input type="radio" name="rating" id="rating-0" value="beginner" {{ ($user_details->basketball_skill == 'beginner') ? 'checked' : '' }}>Beginner
        </label> 
        <label class="radio-inline" for="rating-1">
          <input type="radio" name="rating" id="rating-1" value="intermediate" {{ ($user_details->basketball_skill == 'intermediate') ? 'checked' : '' }}>
          Intermediate
        </label>
        <label class="radio-inline" for="rating-2">
          <input type="radio" name="rating" id="rating-2" value="advanced" {{ ($user_details->basketball_skill == 'advanced') ? 'checked' : '' }}>
          Advanced
        </label>
        </div>
      </div>
      <article class="product-order-summary">
        <div class="page-header">
          <h4 class="">3. SELECTED SESSION</h4>      
        </div>
        <div class="form-group">
            <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Camp focus:</label>  
            <div class="col-md-3 col-sm-6 col-xs-12">
              <p style="font-weight: bold;">{{$camp_details[0]->camp_focus}}</P>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Location:</label>  
            <div class="col-md-3 col-sm-6 col-xs-12">
              <p>{{$camp_details[0]->Location}}</P>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">City/state:</label>  
            <div class="col-md-3 col-sm-6 col-xs-12">
             <p>{{$camp_details[0]->City}}, {{$camp_details[0]->state_name}},</P>
            </div>
        </div>
        <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Address:</label>  
            <div class="col-md-3 col-sm-6 col-xs-12">
            <p>{{$camp_details[0]->Address}}</P>
          </div>
        </div>
       <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Date and time:</label>  
        <div class="col-md-3 col-sm-6 col-xs-12">
          @php
            $startdate = $camp_details[0]->startdate;
            $sd = date_parse_from_format("Y-m-d", $startdate);
            $startmonthNum  = $sd["month"];
            $startdateObj   = DateTime::createFromFormat('!m', $startmonthNum);
            $startmonthName = $startdateObj->format('F');
            
            $startDateTime = $camp_details[0]->starttime;
            $startTime = date('h:i A', strtotime($startDateTime));
            
            $enddate = $camp_details[0]->enddate;
            $ed = date_parse_from_format("Y-m-d", $enddate);
            $endmonthNum  = $ed["month"];
            $enddateObj   = DateTime::createFromFormat('!m', $endmonthNum);
            $endmonthName = $enddateObj->format('F');
            
            $endDateTime = $camp_details[0]->endtime;
            $endTime = date('h:i A', strtotime($endDateTime));
          @endphp
          <p>{{$startmonthName}} {{ $sd["day"]}} - {{$endmonthName}} {{ $ed["day"]}}, {{$startTime}} to {{$endTime}}</p>
        </div>
      </div>
      <div class="form-group">
      <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Cost:</label>  
          <div class="col-md-3 col-sm-6 col-xs-12">
          <p>$ {{$camp_details[0]->cost}}</P>
        </div>
      </div>
      <div class="form-group">
      <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Contact:</label>  
          <div class="col-md-3 col-sm-6 col-xs-12">
          <p>{{$camp_details[0]->contact}}</P>
        </div>
      </div>
      <div class="form-group">
      <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="zip">Other info:</label>  
          <div class="col-md-3 col-sm-6 col-xs-12">
          <p style="font-size: 100%;">@if($camp_details[0]->AdditionalInfo != ''){!! $camp_details[0]->AdditionalInfo !!}@else -- @endif
          </p>
        </div>
      </div>
      </article>
      <!-- Button -->
      <div class="form-group">
        <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="submit"></label>
        <div class="col-md-7">
            <button type="submit" id="submit" name="submit" class="btn btn-primary">SUBMIT</button>
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
  {{-- <script src="{{ asset('public/js/registercamp.js') }}"></script> --}}
    <script>
      setTimeout(function() {
       $('.alert-success').fadeOut();
       $('.alert-danger').fadeOut();
      }, 5000 );
      
      $("#home_phone,#other_phone,#zip_code").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
           // Allow: Ctrl+A, Command+A
          (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
           // Allow: home, end, left, right, down, up
          (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
          e.preventDefault();
        }
      });
      
      $("#EditRegisteredCamp").validate({
          errorElement: "span",
          errorPlacement: function(error, element) {
              error.appendTo( element.parents(".col-xs-12"));
          },
          rules: {
              'student_name': {
                required: true,
              }, 
              'user_email' :{
                  required : true,
              },
              'gender' :{
                  required : true,
              }, 
              'date' :{
                  required : true,
              },
              'month' :{
                  required : true,
              },
              'year' :{
                  required : true,
              },
              'grade_level' :{
                  required : true,
              },
              'parent_first_name' :{
                  required : true,
              },
              
              'address' :{
                  required : true,
              },
              'city' :{
                  required : true,
              },
              'state' :{
                  required : true,
              },
              'zip_code' :{
                  required : true,
              },
              'country' :{
                  required : true,
              },
              'home_phone' :{
                  required : true,
              }, 
              'parent_email' :{
                  required : true,
              },
              'confirm_email' :{
                  required : true,
          equalTo: '#parent_email'
              },
              'hearabout' :{
                  required : true,
              },
              'session_before' :{
                  required : true,
              },
              'rating' :{
                required : true,
              }
          },
          messages:{
              'student_name': {
                required: "Please enter name"
              }, 
              'user_email' :{
                  required : "Please enter user email",
              }, 
              'gender' :{
                  required : "Please choose gender",
              }, 
              'date' :{
                  required : "Please select date",
              },
              'month' :{
                  required : "Please select month",
              },
              'year' :{
                  required : "Please select year",
              },
              'grade_level' :{
                  required : "Please enter grade level",
              },
              'parent_first_name' :{
                  required : "Please enter parent first name",
              },
              'address' :{
                  required : "Please enter address",
              },
              'city' :{
                  required : "Please enter city",
              },
              'state' :{
                  required : "Please enter state",
              },
              'zip_code' :{
                  required : "Please enter zip_code",
              },
              'country' :{
                  required : "Please select country",
              },
              'home_phone' :{
                  required : "Please enter home phone",
              }, 
              'parent_email' :{
                  required : "Please enter parent email",
              },
              'confirm_email' :{
                  required : "Please enter confirm email",
              },
              'hearabout' :{
                  required : "Please select hear about",
              },
              'session_before' :{
                  required : "Please check the session before checkbox",
              },
              'rating' :{
                required : "Please choose rate",
              }
          }
      });
     $("#EditRegisteredCamp").find("button[type='submit']").on("submit",function(e){
          if($("#EditRegisteredCamp").valid()) { 
              $(this).submit();
          } else {
              return false;
          }
      });
    </script>
  </body>
  </html>
