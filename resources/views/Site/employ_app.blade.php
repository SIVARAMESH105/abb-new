@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
					@if($pageContent[0]->image1 != '')
						<div class="banner-wrap header-image">
							<img src="{{ url('public/uploads/images/cms//'.$pageContent[0]->image1) }}" alt="Banner image">
						</div>
					@endif
					@php echo $pageContent[0]->content; @endphp
					<form action="{{url('site/empApplyAction')}}" method=POST name="emplymentform" id="employmentform" onSubmit="return formValidation()">
						{!! csrf_field() !!}
						<input type=hidden name="recipient" value="info@advantagebasketball.com">
						<input type=hidden name="subject" value="ABC Website Employment Application Submission">
						<input type="hidden" name="website" value="http://www.advantagebasketball.com/employ_app.htm" />
						<input name="redirect" type="hidden" id="redirect" value="https://www.advantagebasketball.com/employ_thanks.htm" />					  
						<table border="0" align="center" width="520" cellspacing="0" cellpadding="0" background="images/clear.gif">
							<tr> 
								<td height="30" colspan="2" valign="middle"><span class="heading">About You</span></td>
							</tr>
							<tr>
								<td width="139" align="right"><span class="label">Name : </span></td>
								<td width="358">
									<input name="realname" type="Text" id="realname" value="" size="30" maxlength="50">
									<span class="required">required</b></span>
								</td>
							</tr>
							<tr>
								<td width="139" align="right"> <span class="label">Email: </span></td>
								<td width="358">
									<input type="Text" name="email" id="email" value="" size="30" maxlength="50">
									<span class="required">required</span>
								</td>
							</tr>
							<tr>
								<td width="139" align="right"> <span class="label_normal">Address: </span></td>
								<td width="358">
									<input name="address" type="Text" id="address" value="" size="30" maxlength="50">
								</td>
							</tr>
							<tr>
								<td width="139" align="right"> <span class="label_normal">City: </span></td>
								<td width="358"><input name="city" type="Text" id="city" value="" size="30" maxlength="50">	 </td>
							</tr>
							<tr>
								<td width="139" align="right"><span class="label_normal">State: </span></td>
								<td width="358"><input name="state" type="Text" id="state" value="" size="30" maxlength="50"></td>
							</tr>
							<tr>
								<td width="139" align="right"><span class="label_normal">Zip Code: </span></td>
								<td width="358"><input name="zipcode" type="Text" id="zipcode" value="" size="30" maxlength="50"></td>
							</tr>
							<tr>
								<td width="139" align="right"><span class="label_normal">Phone: </span></td>
								<td width="358"><input name="phone" type="Text" id="phone" value="" size="30" maxlength="50"></td>
							</tr>
							<tr>
								<td align="right"> <span class="label_normal"> Birth Date: </span> </td>
								<td><input name="birthdate" type="Text" id="birthdate" value="" size="30" maxlength="50"></td>
							</tr>
							<tr>
								<td colspan="2" align="right" height="50"> 
									<div align="left"><span class="label_normal">Have you ever been convicted of any criminal act including sex-related or child-abuse-related offenses?</span></div>
								</td>
							</tr>
							<tr>
								<td width="139" align="right">&nbsp;</td>
								<td width="358"> 
									<input type="radio" name="everConvictedCriminal" value="yes">	  Yes 
									<input type="radio" name="everConvictedCriminal" value="no">No
								</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td height="30" colspan="2" valign="middle"><span class="content_heading">Position Applying For</b></span></td>
							</tr>
							<tr>
								<td width="139"> 
									<p align="right"><span class="label_normal"><a href="positions.htm">Position</a>:&nbsp;</span></p>
								</td>
								<td width="358" valign="middle"> 
									<select name="position" size="1" id="position">
										<option>Select One</option>
										<option value="Counselor FT">Camp Counselor - Full Time</option>
										<option value="Counselor PT">Camp Counselor - Part Time</option>
										<option value="Counselor Weekends">Camp Counselor - Weekends Only</option>
										<option value="Secretary FT">Office Secretary - Full Time</option>
										<option value="Secretary PT">Office Secretary - Part Time</option>
										<option value="Host-Promoter">Camp Host/Promoter</option>
										<option value="Cruise">Cruise Director</option>
										<option value="International">International Director</option>
									</select>
								</td>
							</tr>
							<tr>
								<td width="139"> 
									<p align="right"><span class="label_normal">Start Date: </span></p>
								</td>
								<td width="358" valign="middle"> 
									<input name="avail_date" type="text" id="avail_date" size="25">
								</td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Hours Available: </span></p></td>
								<td width="358" valign="middle"> 
									<input name="avail_hours" type="text" id="avail_hours" size="25">
								</td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Pay Range:</span></p></td>
								<td width="358"><input name="payrange" type="text" id="payrange" size="25"></td>
							</tr>
							<tr><td colspan="2">&nbsp;</td></tr>
							<tr> 
								<td height="30" colspan="2"><span class="content_heading">Educational Background </b></span></td>
							</tr>
							<tr>
								<td height="30" colspan="2"><span class="label_normal">College or University</span></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">School Name: </span></p></td>
								<td width="358"><input name="college_name" type="text" id="college_name" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Degree: </span></p></td>
								<td width="358"><input name="college_degree" type="text" id="college_degree" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Major: </span></p></td>
								<td width="358"><input name="college_major" type="text" id="college_major" size="30"></td>
							</tr>
							<tr>
								<td width="139"></td>
								<td width="358"></td>
							</tr>
							<tr>
								<td height="30" colspan="2"><span class="label_normal">Technical or Trade School</span></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">School Name: </span></p></td>
								<td width="358"><input name="tradeschool_name" type="text" id="tradeschool_name" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Course of Study: </span></p></td>
								<td width="358"><input name="tradeschool_study" type="text" id="tradeschool_study" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Certificates: </span></p></td>
								<td width="358">
									<input name="tradeschool_certificates" type="text" id="tradeschool_certificates" size="30">
								</td>
							</tr>
							<tr>
								<td height="30" colspan="2"><span class="label_normal">High School or GED</span></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">School Name: </span></p></td>
								<td width="358"><input name="highschool_name" type="text" id="highschool_name" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Other Skills or<br>Special Training: </span></p></td>
								<td width="358">
									<span class="label_normal"> 
										<textarea name="other_skills" cols="30" rows="5" wrap="PHYSICAL" id="other_skills"></textarea>
									</span>
								</td>
							</tr>
							<tr><td colspan="2">&nbsp;</td></tr>
							<tr>
								<td height="30" colspan="2"><span class="content_heading">Athletic Background</b></span></td>
							</tr>
							<tr>
								<td height="30" colspan="2"><span class="content">Experience As A Player</span></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Sports Played: </span></p></td>
								<td width="358"><input name="sport_played" type="text" id="sport_played" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Years Played: </span></p></td>
								<td width="358"><input name="years_played" type="text" id="years_played" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Comments: </span></p></td>
								<td width="358"><input name="player_comment" type="text" id="player_comment" size="30"></td>
							</tr>
							<tr>
								<td height="30" colspan="2"><span class="content">Experience As A Coach</span></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Sports Coached: </span></p></td>
								<td width="358"><input name="sport_played_as_coach" type="text" id="sport_played_as_coach" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Years Coached: </span></p></td>
								<td width="358"><input name="years_played_as_coach" type="text" id="years_played_as_coach" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Comments: </span></p></td>
								<td width="358"><input name="coach_comment" type="text" id="coach_comment" size="30"></td>
							</tr>
							<tr><td colspan="2">&nbsp;</td></tr>
							<tr>
								<td height="30" colspan="2"><span class="content_heading">Employment History</b></span></td>
							</tr>
							<tr>
								<td height="30" colspan="2"><span class="content">Present Or Last Position</span></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">1.Company Name: </span></p></td>
								<td width="358"><input name="company_1" type="text" id="company_1" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Address: </span></p></td>
								<td width="358">
									<input name="company1_address" type="text" id="company1_address" size="30">
								</td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Phone: </span></p></td>
								<td width="358"><input name="company1_phone" type="text" size="25"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Your Job Title: </span></p></td>
								<td width="358"><input name="company1_title" type="text" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Supervisors Name: </span></p></td>
								<td width="358"><input name="company1_supervisor" type="text" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Department: </span></p></td>
								<td width="358"><input name="company1_dept" type="text" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Start Date: </span></p></td>
								<td width="358">
									<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td width="20%"><input name="company1_start" type="text" size="10"></td>
											<td width="7%">
												<div align="right"> 
													<p align="right"><span class="label_normal">To: </span></p>
												</div>
											</td>
											<td width="74%"><input name="company1_end" type="text" size="10"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Pay: </span></p></td>
								<td width="358"><input name="company1_pay" type="text" size="25"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Reason For Leaving: </span></p></td>
								<td width="358"><input name="company1_reason" type="text" size="30"></td>
							</tr>
							<tr>
								<td height="30" colspan="2"><span class="content">Previous Position</span></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">2.Company Name: </span></p></td>
								<td width="358"><input name="company_2" type="text" id="company_1" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Address: </span></p></td>
								<td width="358"><input name="company2_address" type="text" id="company1_address" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Phone: </span></p></td>
								<td width="358"><input name="company2_phone" type="text" size="25"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Your Job Title: </span></p></td>
								<td width="358"><input name="company2_title" type="text" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Supervisors Name: </span></p></td>
								<td width="358"><input name="company2_supervisor" type="text" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Department: </span></p></td>
								<td width="358"><input name="company2_dept" type="text" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Start Date: </span></p></td>
								<td width="358">
									<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td width="20%"><input name="company2_start" type="text" size="10"></td>
											<td width="7%">
												<div align="right">
													<p align="right"><span class="label_normal">To: </span></p>
												</div>
											</td>
											<td width="74%"><input name="company2_end" type="text" size="10"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Pay: </span></p></td>
								<td width="358"><input name="company2_pay" type="text" size="25"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Reason For Leaving: </span></p></td>
								<td width="358"><input name="company2_reason" type="text" size="30"></td>
							</tr>
							<tr>
								<td height="30" colspan="2"><span class="content">Previous Position</span></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">3.Company Name: </span></p></td>
								<td width="358"><input name="company_3" type="text" id="company_1" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Address: </span></p></td>
								<td width="358"><input name="company3_address" type="text" id="company1_address" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Phone: </span></p></td>
								<td width="358"><input name="company3_phone" type="text" size="25"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Your Job Title: </span></p></td>
								<td width="358"><input name="company3_title" type="text" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Supervisors Name: </span></p></td>
								<td width="358"><input name="company3_supervisor" type="text" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Department: </span></p></td>
								<td width="358"><input name="company3_dept" type="text" size="30"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Start Date: </span></p></td>
								<td width="358"> 
									<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr> 
											<td width="20%"><input name="company3_start" type="text" size="10"></td>
											<td width="7%">
												<div align="right">
													<p align="right"><span class="label_normal">To: </span></p>
												</div>
											</td>
											<td width="74%"><input name="company3_end" type="text" size="10"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Pay: </span></p></td>
								<td width="358"><input name="company3_pay" type="text" size="25"></td>
							</tr>
							<tr>
								<td width="139"><p align="right"><span class="label_normal">Reason For Leaving: </span></p></td>
								<td width="358"><input name="company3_reason" type="text" size="30"></td>
							</tr>
							<tr><td colspan="2">&nbsp;</td></tr>
							<tr>
								<td height="30" colspan="2"><span class="content_heading">Other</b></span></td>
							</tr>
							<tr>
								<td height="30" colspan="2" valign="middle">
									<p><span class="label_normal">How did you find out about Advantage Basketball Camps: </span></p>
								</td>
							</tr>
							<tr>
								<td width="139" align="right">&nbsp;</td>
								<td width="358">
									<span class="content">
										<select name="foundUs" size="6" id="foundUs">
											<option value="Referral">Referral from a friend</option>
											<option value="Brochure">Brochure</option>
											<option value="Advertisement">Advertisement</option>
											<option value="Link">Link from another site</option>
											<option value="Search Engine">Search engine</option>
											<option value="Other">Other</option>
										</select>
									</span>
								</td>
							</tr>
							<tr><td colspan="2">&nbsp;</td></tr>
							<tr>
								<td height="30" colspan="2" align="right" valign="middle"> 
									<div align="left"><p><span class="label_normal">Enter any comments or questions here:</span></p>
									</div>
								</td>
							</tr>
							<tr>
								<td width="139" align="right">&nbsp;</td>
								<td width="358">
									<span class="content"> 
										<textarea name="comments" cols="30" rows="5" wrap="VIRTUAL" id="comments"></textarea>
									</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="right"><div align="left">&nbsp;</div></td>
							</tr>
							<tr>
								<td width="139" height="2" align="center" valign="top"> 
									<input name="authorization" type="checkbox" id="authorization" value="yes"><br>
									<span class="required">required</b></span>
								</td>
								<td width="358" valign="top" height="2"> 
									<p><span class="content">By checking this box and entering my Social Security number I am agreeing to have my background checked.</span></p>
								</td>
							</tr>
							<tr><td colspan="2" align="right">&nbsp;</td></tr>
							<tr>
								<td colspan="2" align="right"> 
									<div align="left"><span class="content">Thank you for applying to Advantage Basketball Camps!</span></div>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="right"><div align="left">&nbsp;</div></td>
							</tr>
							<tr>
								<td width="139" align="right">&nbsp;</td>
								<td width="358" align="right"> 
									<div align="left">
										<input type="Submit" name="Send" value="Send to us">
										&nbsp;&nbsp; 
										<input type="reset" name="Reset" value="Reset">
									</div>
								</td>
							</tr>
							<tr>
								<td width="139">&nbsp;</td>
								<td width="358">&nbsp;</td>
							</tr>
						</table>
				  </form>
                </div>
            </div>
        </div>
    </section>
    @include("Site.features")
    @include("Site.footer")
	@php $base_url = \URL::to(''); @endphp
	<script>
	function formValidation() {
		valid = true;
		var realname = document.emplymentform.realname.value;
		var email = document.emplymentform.email.value;
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(realname.trim() == '') {
			$('#realname').css("border-color", "red");
			document.emplymentform.realname.focus();
			valid = false;
		} else {
			$('#realname').css("border-color", "");
		}
		if(email.trim() == '') {
			$('#email').css("border-color", "red");
			document.emplymentform.email.focus();
			valid = false;
		} else if(!regex.test(email)) {
			$('#email').css("border-color", "red");
			document.emplymentform.email.focus();
			valid = false;
		} else {
			$('#email').css("border-color", "");
		}
		if(document.emplymentform.authorization.checked == false) {
			$('#authorization').css("border-color", "red");
			document.emplymentform.authorization.focus();
			valid = false;
		}
		return valid;
	}
	</script>
</body>
</html>
