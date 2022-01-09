<table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class='bgBody' style=" font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <tr>
        <td>
            <table cellpadding="0" width="620" class="container" align="left" cellspacing="0" border="0" style="background:  #cccccc;">
                <tr>
                    <td>
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
                                                <td colspan="3" width="600" align="center" style="padding-bottom: 30px;">
                                                    <div class="logo">
                                                        <img src="{{asset('public/images/logo-image.png')}}" alt="abb">
                                                    </div>
                                                    <div class="contentEditableContainer contentTextEditable">
                                                        <div class="contentEditable" align='left'>
															@if(isset($userflog)== 1)
																<p>Hi {{ ucfirst($name) }},
																	<br/>
																	Your refund has been processed.  You should see a credit from Advantage Basketball Camps appearing on your next credit card statement for the amount of ${{ $amount }}.  Thank you.
																</p>
															@else
																<p>Hi Admin,
																	<br/>
																	The below user has apply the refund for camp registration from {{env('APP_URL')}} site.
																</p>
															@endif
                                                        </div>
                                                    </div>
													@if(isset($userflog)!= 1)	
													   <table cellpadding="20" cellspacing="0" border="1" align="center">
															@if(!isset($userflog))
															<tr>
																<td><b>Name</b></td>
																<td>{{ ucfirst($name) }}</td>
															</tr>
															<tr>
																<td><b>Email</b></td>
																<td>{{ $email }}</td>
															</tr>
															@endif
															<tr>
																<td><b>Camp Name</b></td>
																<td>{{ $campname }}</td>
															</tr>
															<tr>
																<td><b>Camp Location</b></td>
																<td>{{ $location }}</td>
															</tr>
															<tr>
																<td><b>Camp Cancelled Date</b></td>
																<td>{{ $canceldate }}</td>
															</tr>
														</table>
													@endif
                                                    <p align='left'>Team Advantage Basket Ball</p>
                                                </td>

                                            </tr>
                                        </table>

                                    </div>

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>