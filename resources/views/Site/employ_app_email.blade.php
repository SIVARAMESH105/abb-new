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
<p>Hi,<br/></p>
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
                                    <table cellpadding="20" cellspacing="0" border="1" align="center">
                                        <tr>
                                            <td><b>Name</b></td>
                                            <td>{{ $realname }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Email</b></td>
                                            <td>{{ $email }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Address</b></td>
                                            <td>{{ $address }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>City</b></td>
                                            <td>{{ $city }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>State</b></td>
                                            <td>{{ $state }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Zip Code</b></td>
                                            <td>{{ $zipcode }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Phone</b></td>
                                            <td>{{ $phone }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Birth Date</b></td>
                                            <td>{{ $phone }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <td><b>Have you ever been convicted of any criminal act including sex-related or child-abuse-related offenses?</b></td>
                                            <td>
                                            @if(!empty($everConvictedCriminal)){{ $everConvictedCriminal }}
                                            
                                                
                                            @endif
                                           </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Position Applying For</b></td>
                                           
                                        </tr>
                                        <tr>
                                            <td><b>Position</b></td>
                                            <td>
                                            @if(!empty($position)){{ $position }}
                                            
                                                
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Start Date</b></td>
                                            <td>

                                            @if(!empty($avail_date)){{ $avail_date }}
                                            
                                                
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Hours Available</b></td>
                                            <td>
                                            @if(!empty($avail_hours)){{ $avail_hours }}
                                            
                                                
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Pay Range</b></td>
                                            <td>
                                            @if(!empty($payrange)){{ $payrange }}
                                            
                                                
                                            @endif
                                            </td>
                                        </tr>
                                       
                                        <tr> 
                                            <td colspan="2"><b>Educational Background </b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">College or University</td>
                                        </tr>
                                        <tr>
                                            <td ><b>School Name: </b></td>
                                            <td>
                                            @if(!empty($college_name)){{ $college_name }}
                                            
                                                
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td ><b>Degree: </b></td>
                                            <td>
                                            @if(!empty($college_degree)){{ $college_degree }}
                                            
                                                
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td ><b>Major: </b></td>
                                            <td>
                                            @if(!empty($college_major)){{ $college_major }}
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Technical or Trade School</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>School Name: </b></td>
                                            <td>
                                            @if(!empty($tradeschool_name)){{ $tradeschool_name }}
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Course of Study:</b></td>
                                            <td>
                                            @if(!empty($tradeschool_study)){{ $tradeschool_study }}
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Certificates: </b></td>
                                            <td>
                                            @if(!empty($tradeschool_certificates)){{ $tradeschool_certificates }}
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>High School or GED</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>School Name: </b></td>
                                            <td>
                                            @if(!empty($highschool_name)){{ $highschool_name }}
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Other Skills or<br>Special Training: </b></td>
                                            <td>
                                            @if(!empty($other_skills)){{ $other_skills }}
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr><td colspan="2">&nbsp;</td></tr>
                                        <tr>
                                            <td colspan="2"><b>Athletic Background</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Experience As A Player</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>Sports Played:</b></td>
                                            <td>
                                            @if(!empty($sport_played)){{ $sport_played }}
                                            @endif
                                            </td>
                                        
                                        </tr>
                                        <tr>
                                            <td><b>Years Played:</b></td>
                                            <td>
                                            @if(!empty($years_played)){{ $years_played }}
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Comments:</b></td>
                                            <td>
                                            @if(!empty($player_comment)){{ $player_comment }}
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Experience As A Coach</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>Sports Coached: </b></td>
                                            <td>
                                            @if(!empty($sport_played_as_coach)){{ $sport_played_as_coach }}
                                            
                                                
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Years Coached: </b></td>
                                            <td>
                                            @if(!empty($years_played_as_coach)){{ $years_played_as_coach }}
                                            
                                                
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Comments: </b></td>
                                            <td>
                                            @if(!empty($coach_comment)){{ $coach_comment }}
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr><td colspan="2">&nbsp;</td></tr>
                                        <tr>
                                            <td><b>Employment History</b></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Present Or Last Position</span></td>
                                        </tr>
                                        <tr>
                                            <td><b>1.Company Name: </b></td>
                                            <td>
                                            @if(!empty($company_1)){{ $company_1 }}
                                            
                                                
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Address: </b></td>
                                            <td>
                                            @if(!empty($company1_address)){{ $company1_address }}
                                            
                                                
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Phone: </b></td>
                                            <td>
                                            @if(!empty($company1_phone)){{ $company1_phone }}
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Your Job Title: </b></td>
                                            <td>
                                            @if(!empty($company1_title)){{ $company1_title }}
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Supervisors Name: </b></td>
                                            <td>
                                            @if(!empty($company1_supervisor)){{ $company1_supervisor }}
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Department: </b></td>
                                            <td>
                                            @if(!empty($company1_dept)){{ $company1_dept }}
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Start Date: </b></td>
                                            <td>
                                            @if(!empty($company1_start) || !empty($company1_end))
                                            {{ $company1_start.' to '. $company1_end}}
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Pay: </b></td>
                                            <td>
                                            @if(!empty($company1_pay)){{ $company1_pay }}
                                            
                                                
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Reason For Leaving: </b></td>
                                            <td>
                                            @if(!empty($company1_reason)){{ $company1_reason }}
                                            
                                                
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Previous Position</span></td>
                                        </tr>
                                        <tr>
                                            <td><b>2.Company Name: </b></td>
                                            <td>{{ $company_2 }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Address: </b></td>
                                            <td>{{ $company2_address }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Phone: </b></td>
                                            <td>{{ $company2_phone }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Your Job Title: </b></td>
                                            <td>{{ $company2_title }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Supervisors Name: </b></td>
                                            <td>{{ $company2_supervisor }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Department: </b></td>
                                            <td>{{ $company2_dept }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Start Date: </b></td>
                                            <td>
                                            @if(!empty($company2_start) || !empty($company2_end))
                                                  {{ $company2_start.' to '. $company2_end}}
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Pay: </b></td>
                                            <td>{{ $company2_pay }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Reason For Leaving: </b></td>
                                            <td>{{ $company2_reason }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Previous Position</span></td>
                                        </tr>
                                        <tr>
                                            <td><b>3.Company Name: </b></td>
                                            <td>{{ $company_3 }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Address: </b></td>
                                            <td>{{ $company3_address }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Phone: </b></td>
                                            <td>{{ $company3_phone }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Your Job Title: </b></td>
                                            <td>{{ $company3_title }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Supervisors Name: </b></td>
                                            <td>{{ $company3_supervisor }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Department: </b></td>
                                            <td>{{ $company3_dept }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Start Date: </b></td>
                                            <td>
                                            @if(!empty($company3_start) || !empty($company3_end))
                                            {{ $company3_start.' to '. $company3_end}}
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Pay: </b></td>
                                            <td>{{ $company3_pay }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Reason For Leaving: </b></td>
                                            <td>{{ $company3_reason }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Other</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>
                                                How did you find out about Advantage Basketball Camps:</b>
                                            </td>
                                        
                                            <td>
                                            @if(!empty($foundUs)){{ $foundUs }}
                                            @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b>Enter any comments or questions here:</b>
                                            </td>
                                            <td>{{ $comments }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td><b> 
                                                Background verification
                                            </b>
                                            </td>
                                            <td>
                                            @if(!empty($authorization)){{ $authorization }}
                                            @endif
                                            </td>
                                        </tr>
                                    </table>
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
    <p>Thanks</p>
</body>
</html>

