@include("Site.header")

<style>
    .error {
        color: red;
    }
</style>
    <div class="container container-md search-content">
        <div class="bg-white-section">
            <div class="secondary-top">
                @if (session('status'))
                <div class="alert alert-success">
                    <a class="panel-close close" data-dismiss="alert">&times;</a> {{ session('status') }}
                </div>
                @endif @if (session('error'))
                <div class="alert alert-danger">
                    <a class="panel-close close" data-dismiss="alert">&times;</a> {{ session('error') }}
                </div>
                @endif

                <form id="trainingregform" action="{{url('one-on-one/addOneOnOne')}}" method="post" class="form-horizontal">
                  {{ csrf_field() }}
                    @php echo $pageContent[0]->content; @endphp
                    <fieldset>
                        <input type="hidden" name="is_selected" id="is_selected" value="">
                        <input type="hidden" name="hiddenRegType" id="hiddenRegType" value="">
                        <input type="hidden" name="recipient" value="mike@newtechweb.com">
                        <input type="hidden" name="subject" value="Advantage Basketball Training Registration">
                        <input type="hidden" name="website" value="http://www.advantagebasketballtraining.com">
                        <input type="hidden" name="sort" value="order:parent_first_name,parent_last_name,playername,gender,grade,address,city,state,zip,phone,email,teamname,unlimited_training,unlimited_training_total,unlimited_training_half_month,unlimited_training_half_month_total,one_per_week_training,one_per_week_training_total,one_per_week_training_half_month,one_per_week_training_half_month_total,trainingregtotal,creditcardname,card,creditcardnumber,verification,expmonth,expyear,authorization">
                        <!-- Form Name -->
                        <div class="container container-sm">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="text-center">Training Registration Form</h1>
                                </div>
                            </div>

                            <div class="page-header">
                                <h2 class="">GENERAL INFORMATION</h2>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Parent First Name <span class="important">*</span></label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <input id="parent_first_name" name="parent_first_name" type="text" placeholder="Parent First Name" value="<?php if(old('parent_first_name') !='') echo old('parent_first_name');  else '';?>" class="form-control input-md" required="">

                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Parent Last Name <span class="important">*</span></label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <input id="parent_last_name" name="parent_last_name" type="text" placeholder="Parent Last Name" value="<?php if(old('parent_last_name') !='') echo old('parent_last_name'); else '';?>" class="form-control input-md">

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Player Name <span class="important">*</span></label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <input id="playername" name="playername" type="text" placeholder="Player Name" value="<?php if(old('playername') !='') echo old('playername'); else '';?>" class="form-control input-md">

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="gender">Gender <span class="important">*</span></label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label class="radio-inline" for="gender-0">
                                        <input type="radio" name="gender" id="gender-0" value="male" checked="checked"> Male
                                    </label>
                                    <label class="radio-inline" for="gender-1">
                                        <input type="radio" name="gender" id="gender-1" value="female"> Female
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="ln">Grade Level <span class="important">*</span></label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <select id="grade_level" name="grade_level">
                                        <option value="">Choose a Grade Level</option>
                                        <option value="1" @if(old('grade_level') =='1') selected @endif>1st</option>
                                        <option value="2" @if(old('grade_level') =='2') selected @endif>2nd</option>
                                        <option value="3" @if(old('grade_level') =='3') selected @endif>3rd</option>
                                        <option value="4" @if(old('grade_level') =='4') selected @endif>4th</option>
                                        <option value="5" @if(old('grade_level') =='5') selected @endif>5th</option>
                                        <option value="6" @if(old('grade_level') =='6') selected @endif>6th</option>
                                        <option value="7" @if(old('grade_level') =='7') selected @endif>7th</option>
                                        <option value="8" @if(old('grade_level') =='8') selected @endif>8th</option>
                                        <option value="9" @if(old('grade_level') =='9') selected @endif>9th</option>
                                        <option value="10" @if(old('grade_level') =='10') selected @endif>10th</option>
                                        <option value="11" @if(old('grade_level') =='11') selected @endif>11th</option>
                                        <option value="12" @if(old('grade_level') =='12') selected @endif>12th</option>
                                    </select>

                                </div>
                            </div>

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
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="email">State <span class="important">*</span></label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <input id="state" name="state" type="text" placeholder="State" maxlength=3 value="<?php if(old('state') !='') echo old('state'); else if(!empty($user_details->state)) echo $user_details->state; else ''; ?>" class="form-control input-md" required="">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="email">Zip Code <span class="important">*</span></label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <input id="zip_code" name="zip_code" type="text" placeholder="Zip code" maxlength=6 value="<?php if(old('zip_code') !='') echo old('zip_code'); else if(!empty($user_details->zip)) echo $user_details->zip; else ''; ?>" class="form-control input-md" required="">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="phone">Phone <span class="important">*</span></label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <input id="phone" name="phone" type="text" placeholder="Phone" value="<?php if(old('phone') !='') echo old('phone'); else if(!empty($user_details->phone)) echo $user_details->phone; else ''; ?>" class="form-control input-md" required="">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="city">Email <span class="important">*</span></label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <input id="user_email" name="user_email" type="email" value="<?php if(old('user_email') !='') echo old('user_email'); else if(!empty($user_details->email)) echo $user_details->email; else ''; ?>" placeholder="Email" class="form-control input-md" required="">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-md-offset-1 col-sm-4 col-xs-12 control-label" for="fn">Team Name</label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <input id="team_name" name="team_name" type="text" placeholder="Team Name" value="<?php if(old('team_name') !='') echo old('team_name');  else '';?>" class="form-control input-md">
                                </div>
                            </div>
                            <div class="page-header">
                                <h2 class="">SELECT TYPE OF REGISTRATION</h2>
                            </div>
                            <p style="font-size: 100%;">
                                Monthly training will start on the day you register (today), which will become your monthly renewal date. Your credit card will automatically be charged the same amount on or about the same day each following month until you send us an e-mail to
                                <a href="mailto:info@advantagebasketball.com">info@advantagebasketball.com</a> telling us you do not want to train anymore. You must contact us by e‑mail to cancel or your card will be charged again each month. For those who are playing on our teams, your monthly $140.00 fee is mandatory to be on our teams, whether you train with us or not.
                            </p>
                            <input type="checkbox" name="unlimited_training" id="unlimited_training" required="" value="140">
                            <label for="unlimited_training">Unlimited Training</label>
                            <div class="form-group">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <p style="font-weight: bold;">$140.00/mo</P>
                                    <span class="price_container"></span>
                                </div>
                            </div>
                            <p style="font-size: 100%;">
                                For mid-month to end-of-month rates call 425-670-8877 or send e-mail to
                                <a href="mailto:info@advantagebasketball.com">info@advantagebasketball.com</a>
                                <div class="page-header">
                                    <h2 class="">SELECT YOUR SESSION(S)</h2>
                                </div>
                                <p style="font-size: 100%;">
                                    Training sessions are only available during days and times indicated in the grid below. You may register for any time slot by clicking a check box, or come to any and all sessions even if you have only selected one box below. These are the recommended time slots for your grade level:
                                </p>
                                <ul>
                                    <li>1st to 3rd grade: 5:00-6:00pm on Tuesday and Thursday</li>
                                    <li>4th to 7th grade: 6:00-7:00pm Monday through Thursday</li>
                                    <li>8th to 12th grade: 6:00 to 7:00 on Monday and Wednesday</li>
                                </ul>
                                <p style="font-size: 100%;">
                                    These are only recommended time slots. You can come to any time slot between 5:00-7:00pm Monday through Thursday.
                                </p>
                                <p style="font-size: 100%;">
                                    The gym will be closed on holidays.
                                </p>
                                <p style="font-size: 100%;">
                                    Summer training hours for July and August will be 6-7pm Monday-Thursday.
                                </p>
                                <table class="abb-bordered-table">
                                    <tr>
                                        <td>
                                            Click the session name below for more information.
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td colspan="4">Mon</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>5</td>
                                                    <td>6</td>
                                                    <td>7</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td colspan="4">Tue</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>5</td>
                                                    <td>6</td>
                                                    <td>7</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td colspan="4">Wed</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>5</td>
                                                    <td>6</td>
                                                    <td>7</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td colspan="4">Thu</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>5</td>
                                                    <td>6</td>
                                                    <td>7</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td colspan="4">Fri</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>5</td>
                                                    <td>6</td>
                                                    <td>7</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Basic Training
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
														<input type="checkbox" name="time-mon[]" value="4">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="time-mon[]" value="5">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="time-mon[]" value="6">
                                                    </td>
                                                    <td>
														<input type="checkbox" name="time-mon[]" value="7">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
														<input type="checkbox" name="time-tue[]" value="4">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="time-tue[]" value="5">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="time-tue[]" value="6">
                                                    </td>
                                                    <td>
														<input type="checkbox" name="time-tue[]" value="7">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
														<input type="checkbox" name="time-wed[]" value="4">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="time-wed[]" value="5">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="time-wed[]" value="6">
                                                    </td>
                                                    <td>
														<input type="checkbox" name="time-wed[]" value="7">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
														<input type="checkbox" name="time-thur[]" value="4">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="time-thur[]" value="5">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="time-thur[]" value="6">
                                                    </td>
                                                    <td>
														<input type="checkbox" name="time-thur[]" value="7">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
														<input type="checkbox" name="time-fri[]" value="4">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="time-fri[]" value="5">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="time-fri[]" value="6">
                                                    </td>
                                                    <td>
														<input type="checkbox" name="time-fri[]" value="7">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <button type="submit">submit</button>
                </form>

                </div>
            </div>
        </div>
</div>
</section>
@include("Site.features") @include("Site.footer")
<script src="{{ asset('public/js/registercamp.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('public/js/jquery.validate.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#unlimited_training').click(function() {
            if ($(this).is(':checked')) {
                $('span.price_container').text('140.00');
            } else {
                $('span.price_container').text('');
            }
        });

         setTimeout(function() {
         $('.alert-success').fadeOut();
         $('.alert-danger').fadeOut();
         $('#name, #email, #msg, #origin').val('')
        }, 5000 );
        
        $("#phone, #zip_code").keydown(function (e) {
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
        
        $("#trainingregform").validate({
          errorElement: "span",
          errorPlacement: function(error, element) {
              error.appendTo( element.parents(".col-xs-12"));
          },
          rules: {
              'parent_first_name': {
                required: true,
              },
              'parent_last_name' :{
                  required : true,
              }, 
              'playername' :{
                  required : true,
              },
              'grade_level' :{
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
              'phone' :{
                  required : true,
              },
              'unlimited_training' :{
                  required : true,
              }
          },
          messages:{
              'parent_first_name': {
                required: "Please enter parent first name"
              },
              'parent_last_name' :{
                  required : "Please enter parent last name",
              }, 
              'playername' :{
                  required : "Please enter player name",
              }, 
              'user_email' :{
                required: "Please enter user email",
              },
              'grade_level' :{
                  required : "Please select grade level",
              }, 
              'address' :{
                  required : "Please enter player address",
              }, 
              'city' :{
                  required : "Please enter city",
              },
              'state' :{
                  required : "Please enter state",
              },
              'zip_code' :{
                  required : "Please enter zipcode",
              },
              'phone' :{
                  required : "Please enter phone number",
              },
              'unlimited_training' :{
                  required : "Please select training",
              }
          }
      });
     $("#trainingregform").find("button[type='submit']").on("submit",function(e){
          
          if($("#trainingregform").valid()) { 
              $(this).submit();
          } else {
              return false;
          }
      });
    });
</script>
</body>

</html>