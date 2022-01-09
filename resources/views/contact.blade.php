@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md">
                <div class="bg-white-section">
                    @if($pageContent[0]->image1 != '')
						<div class="banner-wrap header-image">
							<img src="{{ url('public/uploads/images/cms//'.$pageContent[0]->image1) }}" alt="Banner image">
						</div>
					@endif
					 <?php echo $pageContent[0]->content; ?>
					<form action="{{url('site/contactAction')}}" method="POST" name="contactform" id="contactform" onsubmit="return formValidation()">
						{!! csrf_field() !!}
						<input type="hidden" name="recipient" value="info@advantagebasketball.com">
						<p></p>
						<table border="0" align="center" width="450" cellspacing="0" cellpadding="0" background="images/clear.gif">
							<tbody>
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td width="75" align="right" class="bodytext">
										<span class="label_normal">Name: </span>
									</td>
									<td width="375">
										<input name="realname" type="Text" id="realname" value="" size="30" maxlength="50">
										<span class="bodytext">required</span>
									</td>
								</tr>
								<tr>
									<td width="75" align="right" class="bodytext">
										<span class="label_normal">Email: </span>
									</td>
									<td width="375">
										<input type="Text" name="email" id="email" value="" size="30" maxlength="50">
										<span class="bodytext">required</span>
									</td>
								</tr>
								<tr>
									<td width="75" align="right" class="bodytext">
										<span class="label_normal">Address: </span>
									</td>
									<td width="375">
										<input name="address" type="Text" id="address" value="" size="30" maxlength="50">
									</td>
								</tr>
								<tr>
									<td width="75" align="right" class="bodytext">
										<span class="label_normal">City: </span>
									</td>
									<td width="375">
										<input name="city" type="Text" id="city" value="" size="30" maxlength="50">
									</td>
								</tr>
								<tr>
									<td width="75" align="right" class="bodytext">
										<span class="label_normal">State:</span>
									</td>
									<td width="375">
										<input name="state" type="Text" id="state" value="" size="30" maxlength="50">
										<span class="bodytext">required</span>
									</td>
								</tr>
								<tr>
									<td width="75" align="right" class="bodytext">
										<span class="label_normal">Zip Code: </span>
									</td>
									<td width="375">
										<input name="zipcode" type="Text" id="zipcode" value="" size="30" maxlength="50">
									</td>
								</tr>
								<tr>
									<td width="75" align="right" class="bodytext">
										<span class="label_normal">Phone:</span>
									</td>
									<td width="375">
										<input name="phone" type="Text" id="phone" value="" size="30" maxlength="50">
									</td>
								</tr>
								<tr>
									<td width="75" align="right" class="bodytext">
										<span class="label_normal">Fax:</span>
									</td>
									<td width="375">
										<input name="fax" type="Text" id="fax" value="" size="30" maxlength="50">
									</td>
								</tr>
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr valign="middle">
									<td height="30" colspan="2">
										<span class="bodytext"><b>How did you find out about Advantage Basketball Camps:</b></span>
									</td>
								</tr>
								<tr>
									<td width="75" align="right">&nbsp;</td>
									<td width="375">
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
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr valign="middle">
									<td height="30" colspan="2" align="right">
										<div align="left">
											<span class="bodytext">Enter any comments or questions here:</span>
										</div>
									</td>
								</tr>
								<tr>
									<td width="75" align="right">&nbsp;</td>
									<td width="375">
										<span class="content">
											<textarea name="comments" cols="30" rows="5" wrap="VIRTUAL" id="comments"></textarea>
										</span>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="right">
										<div align="left">&nbsp;</div>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="right">
										<div align="left">
											<span class="bodytext">We appreciate your questions and your feedback!</span>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="right">
										<div align="left">&nbsp;</div>
									</td>
								</tr>
								<tr>
									<td width="75" align="right">&nbsp;</td>
									<td width="375" align="right">
										<div align="left">
											<input type="Submit" name="Send" value="Send to us">
										</div>
									</td>
								</tr>
								<tr>
									<td width="75">&nbsp;</td>
									<td width="375">&nbsp;</td>
								</tr>
							</tbody>
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
	</script>
</body>
</html>
