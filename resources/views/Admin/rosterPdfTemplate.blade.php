<?php
if(count($camps) > 0) {
	$campName = $camps[0]->camp_focus;
	$campStartDate = $camps[0]->startdate;
	$campEndDate = $camps[0]->enddate;
	$campLocation = $camps[0]->Location;
	$campStartTime = $camps[0]->starttime;
	$campEndTime = $camps[0]->endtime;
	$campCity = $camps[0]->City;
	$campState = $camps[0]->State;
	$campZip = $camps[0]->Zip;
} else {
	$campName = '';
	$campStartDate = '';
	$campEndDate = '';
	$campLocation = '';
	$campStartTime = '';
	$campEndTime = '';
	$campCity = '';
	$campState = '';
	$campZip = '';
}
if(count($coach) > 0) {
	$coachFirstName = $coach[0]->first_name;
	$coachLastName = $coach[0]->last_name;
} else {
	$coachFirstName = '';
	$coachLastName = '';
}
$contentPhysical = '
	<table style="border-collapse: collapse;width:100%;">
		<tr>
			<td style="border:1px solid #000;padding:0px 5px;">'.$campName.'</td> <td style="border:1px solid #000;padding:0px 5px;">'.$campStartDate.'&nbsp;-&nbsp;'.$campEndDate.'&nbsp;</td>
		</tr>
		<tr>
			<td style="border:1px solid #000;padding:0px 5px;">'.$campLocation.'</td><td style="border:1px solid #000;padding:0px 5px;">Start Time:&nbsp;'.$campStartTime.'</td>
		</tr>
		<tr>
			<td style="border:1px solid #000;padding:0px 5px;">'.$campCity.'&nbsp;'.$campState.'&nbsp;'.$campZip.'</td>
			<td style="border:1px solid #000;padding:0px 5px;">End Time:&nbsp;'.$campEndTime.'</td>
		</tr>
		<tr>
			<td style="border:1px solid #000;padding:0px 5px;">Coach:&nbsp;'.$coachFirstName.'&nbsp;'.$coachLastName.'</td>
			<td style="border:1px solid #000;padding:0px 5px;">Camper Count:&nbsp;'.count($rosters).'</td>
		</tr> 
	</table>
	<br>
	<table style="border-collapse: collapse;width:100%;">
		<tr align="center"> 
			<td style="border:1px solid #000;padding:0px 5px;"><b>Roster Name</b></td>
			<td style="border:1px solid #000;padding:0px 5px;"><b>Sex</b></td>
			<td style="border:1px solid #000;padding:0px 5px;"><b>Birth date</b></td>
			<td style="border:1px solid #000;padding:0px 5px;"><b>Grade</b></td>
			<td style="border:1px solid #000;padding:0px 5px;"><b>Experience</b></td>
			<td style="border:1px solid #000;padding:0px 5px;"><b>Parent Name </b></td>
			<td style="border:1px solid #000;padding:0px 5px;"><b>Parent Email</b></td>
			<td style="border:1px solid #000;padding:0px 5px;"><b>Home Phone</b></td>
			<td style="border:1px solid #000;padding:0px 5px;"><b>Work Phone</b></td>
			<td style="border:1px solid #000;padding:0px 5px;"><b>Paid</b></td>
		</tr>';
		//echo '<pre>'; print_r($rosters);die;
		//<td style="border:1px solid #000;padding:0px 5px;">'.$roster->tshirtsize.'</td>
		//<td style="border:1px solid #000;padding:0px 5px;"><b>Size</b></td>
		if (count($rosters) > 0) {
			$i = 0;
			foreach($rosters as $roster) {
				$i += 1;
				if($roster->gender == 'male'){
					$gender="M";
				} else if($roster->gender == 'female'){
					$gender="F";
				}else{
					$gender="";
				}
				$contentPhysical .= '<tr> 
										<td style="border:1px solid #000;padding:0px 5px;">'.$roster->fname.'&nbsp;'.$roster->name.'</td>
										<td style="border:1px solid #000;padding:0px 5px;">'.$gender.'</td>
										<td style="border:1px solid #000;padding:0px 5px;">'.$roster->dob.'</td>
										<td style="border:1px solid #000;padding:0px 5px;">'.$roster->grade.'</td>
										<td style="border:1px solid #000;padding:0px 5px;">'.$roster->basketball_skill.'</td>
										<td style="border:1px solid #000;padding:0px 5px;">'.$roster->parent_firstname.' '.$roster->parent_lastname.'</td>
										<td style="border:1px solid #000;padding:0px 5px;">'.$roster->parent_email.'</td>
										<td style="border:1px solid #000;padding:0px 5px;">'.$roster->home_phone.'</td>
										<td style="border:1px solid #000;padding:0px 5px;">'.$roster->work_phone.'</td>
										<td style="border:1px solid #000;padding:0px 5px;">$'.number_format($roster->amount_paid, 2, '.', '').'</td>
									</tr>';
				if ($i%20 == 0) { 	  
					$contentPhysical .= '</table>
						<table align="center" style="border-collapse: collapse;width:100%;">
							<tr>
								<td style="border:1px solid #000;padding:0px 5px;">&nbsp;</td>
							</tr>
						</table>
						<table class="pdf-border" style="border-collapse: collapse;width:100%;">
							<tr> 
								<td style="border:1px solid #000;padding:0px 5px;"><b>Roster Name</b></td>
								<td style="border:1px solid #000;padding:0px 5px;"><b>Sex</b></td>
								<td style="border:1px solid #000;padding:0px 5px;"><b>Birth date</b></td>
								<td style="border:1px solid #000;padding:0px 5px;"><b>Grade</b></td>
								<td style="border:1px solid #000;padding:0px 5px;"><b>Size</b></td>
								<td style="border:1px solid #000;padding:0px 5px;"><b>Experience</b></td>
								<td style="border:1px solid #000;padding:0px 5px;"><b>Parent Name </b></td>
								<td style="border:1px solid #000;padding:0px 5px;"><b>Parent Email</b></td>
								<td style="border:1px solid #000;padding:0px 5px;"><b>Home Phone</b></td>
								<td style="border:1px solid #000;padding:0px 5px;"><b>Work Phone</b></td>
								<td style="border:1px solid #000;padding:0px 5px;"><b>Paid</b></td>
							</tr>
						</table>
	<table>'; 
				}  
			} // end foreach
		} else {
			$contentPhysical .='<tr><td colspan="6" align="center">No Roster Yet</td></tr>';
		}
		$contentPhysical .= '</table><p>&nbsp;</p>'; 
echo $contentPhysical;
?>