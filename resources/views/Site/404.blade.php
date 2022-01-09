@include("Site.header")
        <div class="secondary-top">
            <div class="container container-md search-content">
                <div class="bg-white-section">
                    @if($pageContent[0]->image1 != '')
						<div class="banner-wrap header-image">
							<img src="{{ url('public/uploads/images/cms//'.$pageContent[0]->image1) }}" alt="Banner image">
						</div>
					@endif
					 {!! $pageContent[0]->content !!}
					<form action="" method="POST" name="contactform" id="contactform" onsubmit="return formValidation()">
						{!! csrf_field() !!}
						<input type="hidden" name="recipient" value="webmaster@newtechweb.com">
						<input type="hidden" name="subject" value="Advantage Basketball 404 Error Response">
						<input type="hidden" name="website" value="http://www.advantagebasketball.com/404.htm">
						<input type="hidden" name="redirect" value="http://www.advantagebasketball.com/404_thanks.htm">
						<table width="450" cellspacing="4">
							<tbody>
								<tr>
									<td width="53%" align="right" height="30" valign="baseline">
										<font face="Arial, Helvetica, sans-serif" size="2">&nbsp;</font>
									</td>
									<td width="47%" height="30" valign="middle">
										<font color="#FF6600" face="Arial, Helvetica, sans-serif" size="5">*</font>
										<font face="Arial, Helvetica, sans-serif" size="2">Fields are required.</font>
									</td>
								</tr>
								<tr>
									<td width="53%" align="right" height="30" valign="middle">
										<font face="Arial, Helvetica, sans-serif" size="2">Your name:</font>
									</td>
									<td width="47%" height="30" valign="middle">
										<input type="text" name="realname" size="20" maxlength="20">
									</td>
								</tr>
								<tr>
									<td width="53%" align="right" height="30" valign="middle">
										<font face="Arial, Helvetica, sans-serif" size="2">Your e-mail address:</font>
									</td>
									<td width="47%" height="30" valign="middle">
										<input type="email" name="email" size="20">
									</td>
								</tr>   
								<tr>
									<td width="53%" align="right" height="30" valign="middle">
										<font face="Arial, Helvetica, sans-serif" size="2">Your website address:</font>
									</td>
									<td width="47%" height="30" valign="middle">
										<input type="text" name="URL" size="20">
									</td>
								</tr>
								<tr>
									<td width="53%" align="right" valign="top" height="138">
										<font face="Arial, Helvetica, sans-serif" size="2">&nbsp;<br></font>
										<font color="#FF6600" face="Arial, Helvetica, sans-serif" size="5">*</font>
										<font face="Arial, Helvetica, sans-serif" size="2">What website page (URL) are you looking for? Please describe how you got to this page:</font>
									</td>
									<td width="47%" valign="top" height="138">
										<textarea rows="6" name="ErrorIssue" id="ErrorIssue" cols="28"></textarea>
									</td>
								</tr>
								<tr>
									<td align="right" valign="middle" height="2" colspan="2">
										<div align="center">
											<center><p><input type="submit" value="Notify Webmaster" name="Submit"></p></center>
										</div>
									</td>
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
		var ErrorIssue = document.contactform.ErrorIssue.value;
		if(ErrorIssue.trim() == '') {
			$('#ErrorIssue').css("border-color", "red");
			document.contactform.ErrorIssue.focus();
			valid = false;
		} else {
			$('#ErrorIssue').css("border-color", "");
		}
		return valid;
	}
	</script>
</body>
</html>
