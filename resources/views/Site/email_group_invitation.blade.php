

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>ABB</title>
<style type="text/css">

#outlook a,body{padding:0}table,table td{border-collapse:collapse}@media screen and (max-width:600px){table[class=container]{width:95%!important}}body{width:100%!important;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0}.ExternalClass{width:100%}.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td{line-height:100%}#backgroundTable{margin:0;padding:0;width:100%!important;line-height:100%!important}img{outline:0;text-decoration:none;-ms-interpolation-mode:bicubic}a img{border:none}.image_fix{display:block}h1,h2,h3,h4,h5,h6{color:#000!important}h1 a,h2 a,h3 a,h4 a,h5 a,h6 a{color:#00f!important}h1 a:active,h2 a:active,h3 a:active,h4 a:active,h5 a:active,h6 a:active{color:red!important}h1 a:visited,h2 a:visited,h3 a:visited,h4 a:visited,h5 a:visited,h6 a:visited{color:purple!important}table{mso-table-lspace:0;mso-table-rspace:0}a{color:#000}@media only screen and (max-device-width:480px){a[href^=tel],a[href^=sms]{text-decoration:none;color:#000;pointer-events:none;cursor:default}.mobile_link a[href^=tel],.mobile_link a[href^=sms]{text-decoration:default;color:orange!important;pointer-events:auto;cursor:default}}@media only screen and (min-device-width:768px) and (max-device-width:1024px){a[href^=tel],a[href^=sms]{text-decoration:none;color:#00f;pointer-events:none;cursor:default}.mobile_link a[href^=tel],.mobile_link a[href^=sms]{text-decoration:default;color:orange!important;pointer-events:auto;cursor:default}}h2{color:#181818;font-family:Helvetica,Arial,sans-serif;font-size:22px;line-height:22px;font-weight:400}a.link2,p{font-family:Helvetica,Arial,sans-serif;font-size:16px}a.link2{text-decoration:none;color:#fff;border-radius:4px}p{margin:1em 0;color:#555;line-height:160%}

</style>

</head>
<body>
	<table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class='bgBody'>
	<tr>
		<td>
	<table cellpadding="0" width="620" class="container" align="center" cellspacing="0" border="0">
	<tr>
		<td>
		<!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
		<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
			<tr>
				<td class='movableContentContainer bgItem'>

					

					<div class='movableContent'>
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
							<tr height="25">
								<td width="200">&nbsp;</td>
								<td width="200">&nbsp;</td>
								<td width="200">&nbsp;</td>
							</tr>
							<tr>	
								<td colspan="3" width="600" align="center">
									<div class="contentEditableContainer contentTextEditable">
					                	<div class="contentEditable" align='left' >
					                  		<p >Hi @if(isset($user_name)) {{$user_name}} @endif,
					                  			<br/>
					                  			<br/>
												</p>
					                	</div>
					              	</div>
									<?php //echo '<pre>'; print_r($campDetails);die; ?>
									<p>{{$reg_username}} registered their child for an Advantage Basketball Camp.  They are inviting you to register too! </p>

									<p>If you register for the {{$campDetails->camp_focus}} to take place {{$campDetails->startdate}} {{$campDetails->starttime}} to {{$campDetails->enddate}} {{$campDetails->endtime}} at {{$campDetails->Location}},{{$campDetails->City}},{{$campDetails->state_name}} before {{$campDetails->EarlyBirdDays}} days, you may qualify for a group discount.  The discount only applies if 5 or more of your group registers by that date.  If 5-9 people register, you'll receive a 5% discount.  If 10 or more register, you'll all receive a 10% discount! </p>

									<p>Be sure to contact {{$reg_username}} to let them know you received their invitation and that you'll be registering too!</p>
			
									<p>To start the registration process, simply <a href="{{ url('camp/register/'.$campDetails->id)}}">click here</a>.  You MUST use your group code or you will not obtain your discount, and you may cause the rest of your group to lose their discount too!</p>

									<p>ENTER THIS GROUP CODE IN YOUR REGISTRATION FORM:  {{$group_code}} </p>

									<p>If you have any questions, please feel free to contact us by phone or e-mail.  We're looking forward to seeing your child at our Advantage Basketball Camp! </p>

									<p>Advantage Basketball Camps

									425-670-8877

									info@advantagebasketball.com </p>
								</td>
								
							</tr>
						</table>
						
					</div>
					
				</td>
			</tr>
		</table>

	</td></tr></table>
	
		</td>
	</tr>
	</table>
</body>
</html>
