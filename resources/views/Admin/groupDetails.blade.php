@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Group Details of {{$campName}}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">Manage Groups</li>
	    <li class="active">Group Details</li>
	  </ol>
	</section>
@endsection

@section('content')
<!-- Default box -->
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
		<div class="box">
			<div class="box-body table-responsive view-order-table">
				<h4 align="center"><b>Invite Members</b></h4>
				<br>
				<form method="post" id="inviteMembers">
					<table width="700"  align="center" cellpadding="5" cellspacing="1" class="detailTable" style="border:none;">
						<tr>
							<td colspan="2" align="center">Select Group Code</td>
							<td>
								<select name="group_code">
								<?php if(count($groupInvityDetails) > 0){?>
									@foreach($groupInvityDetails as $group)
										<option value="{{$group->group_code}}">{{$group->group_code}}</option>
									@endforeach
								<?php } ?>
								</select>
							</td>
						</tr>
					</table>
					<br>
					<table width="550" align="center" cellpadding="5" cellspacing="1" id="invites" class="detailTable" style="border:none;">
						<tr>
							<td><input type="text" name="username[]" id="first_name[]" placeholder="First Name"></td>
							<td><input type="text" name="last_name[]" id="last_name[]" placeholder="Last Name"></td>
							<td><input type="text" name="grpemail[]" id="email[]" placeholder="Email"></td>
						</tr>
						<tr class="inviteButtons">
							<td colspan="3" align="center">
								<input type="hidden" id="chk_inv" value="1">
								<input type="hidden" name="campId" value="{{$campId}}">
								<input type="button" value="Add row" id="addRow">
								<input type="button" value="Invite" id="invite">
								<img src="{{asset('public/images/Loading_icon.gif')}}" width="100px" class="loading">
							</td>
						</tr>
					</table>
				</form>
				<br>
				<h4 align="center"><b>Invited Members</b></h4>
				@php
					$groupId = 0;
					if(count($groupInvityDetails) > 0)
					{
						foreach($groupInvityDetails as $invity)
						{
							if($invity->group_id != $groupId)
							{
								$groupId = $invity->group_id;
								@endphp
								<table>
									<tr>
										<td><b>Invited By: {{$invity->user_name}}</b></td>
										<td><b>|</b></td>
										<td><b>Group Code: {{$invity->group_code}}</b></td>
									</tr>
								</table>
								<br>
								<table width="750" border="1"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
									<tr>
									<td align="center" class="table-header" id="infoTableHeader"><b>First Name</b></td>
									<td align="center" class="table-header" id="infoTableHeader"><b>Last Name</b></td>
									<td align="center" class="table-header" id="infoTableHeader"><b>Email</b></td>
									<td align="center" class="table-header" id="infoTableHeader"><b>Registered</b></td>
									<td align="center" class="table-header" id="infoTableHeader"><b>Action</b></td>
								</tr>
								@php
							}
							@endphp
								<tr> 
									<td class="labelText">{{$invity->first_name}}</td>
									<td class="labelText">{{$invity->last_name}}</td>
									<td class="labelText">{{$invity->email}}</td>
									<td align="center" class="labelText">
										@if($invity->register == 1)
											<img src="{{ asset('public/images/green-check-mark.png') }}" width="12px">
										@else
											<a href="javascript:void(0);" class="resendInvite" onclick="resendInvite('{{$invity->first_name}}', '{{$invity->last_name}}', '{{$invity->email}}', '{{$invity->group_code}}', '{{$invity->user_name}}', {{$campId}}, {{$invity->id}})">Resend</a>
											<img src="{{asset('public/images/Loading_icon.gif')}}" width="70px" class="resendLoading {{$invity->id}}" style="display:none;">
										@endif
									</td>
									<td align="center" class="labelText"><a class="popup-models" id="modal-one" data-target="#myModal" data-toggle="modal" onclick="displayContent('{{$invity->id}}', '{{$invity->first_name}}', '{{$invity->last_name}}', '{{$invity->email}}')">Edit</a> / <a href="javascript:void(0);" onclick="deleteInvity('{{$invity->id}}');">Delete</a></td>
									
								</tr>
							@php
							if ($invity->group_id != $groupId) {
								echo '</table><br>';
							}
							$groupId = $invity->group_id;
						}
						echo '</table><br>';
					} else {
						@endphp
							<table width="750" border="1"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
								<tr>
									<td align="center" class="table-header" id="infoTableHeader"><b>First Name</b></td>
									<td align="center" class="table-header" id="infoTableHeader"><b>Last Name</b></td>
									<td align="center" class="table-header" id="infoTableHeader"><b>Email</b></td>
									<td align="center" class="table-header" id="infoTableHeader"><b>Registered</b></td>
									<td align="center" class="table-header" id="infoTableHeader"><b>Action</b></td>
								</tr>
								<tr> 
									<td colspan="5" align="center" class="labelText">No group created for this camp</td>
								</tr>
							</table>
							<br>
						@php
					}
				@endphp				
				<p align="center" class="go-back"> 
					<input name="btnBack" type="button" id="btnBack" value="Back" class="box" onClick="window.history.back();">
				</p>
			</div>
		</div>
	</div>
</div>

<div class="modal fade video-popup" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<div class="modal-body">
				<div id="myModal">
					<form method="post" name="singleInvity">
						<h4>Edit</h4>
						<input type="hidden" name="invity_id" id="invity_id">
						<input type="text" name="invity_first_name" id="invity_first_name">
						<input type="text" name="invity_last_name" id="invity_last_name">
						<input type="text" name="invity_email" id="invity_email">
						<input type="button" name="update" id="update" value="Update" onclick="updateInvity();">
						<img src="{{asset('public/images/Loading_icon.gif')}}" width="60px" class="updateLoading {{$invity->id}}" style="display:none;">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('after_styles')

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
@endsection

@section('after_scripts')

<script type="text/javascript">
	$(document).ready(function(){
		$('.loading').hide();
		$("#addRow").click(function () {
			var last_val = $('#chk_inv').val();
			if(last_val <= 9){
				var count_val = parseInt(last_val) + 1;
				$('#chk_inv').val(count_val);
				$("#invites tr.inviteButtons").before('<tr><td><input type="text" name="username[]" id="first_name[]" placeholder="First Name"></td><td><input type="text" name="last_name[]" id="last_name[]" placeholder="Last Name"></td><td><input type="text" name="grpemail[]" id="email[]" placeholder="Email"></td><td><a href="javascript:void(0);" onclick="removeRow('+count_val+');"><img src="{{ asset('public/images/delete.jpg') }}" width="14px"></a></td></tr>');
			}else{
				alert('maximum exists!');
			}
		});
		
		$("#invite").click(function () {
			var error = false;
			$("[name^=first_name]").each(function () {
				if($(this).val().trim() == '') {
					$(this).css("border-color", "orangered");
					error = true;
				} else {
					$(this).css("border-color", "");
				}
			});
			$("[name^=last_name]").each(function () {
				if($(this).val().trim() == '') {
					$(this).css("border-color", "orangered");
					error = true;
				} else {
					$(this).css("border-color", "");
				}
			});
			$("[name^=grpemail]").each(function () {
				var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if($(this).val().trim() == '') {
					$(this).css("border-color", "orangered");
					error = true;
				} else if(!regex.test($(this).val())) {
					$(this).css("border-color", "orangered");
					error = true;
				} else {
					$(this).css("border-color", "");
				}
			});
			if(!error) {
				url = "<?php echo url('admin/group/inviteMembers'); ?>";
				$.ajax({
					type : 'POST',
					url : url,
					data : $('#inviteMembers').serialize(),
					beforeSend: function() {
						$('#addRow').attr('disabled','disabled');
						$('#invite').attr('disabled','disabled');
						$('.loading').show();
					},
					success:function(res) {
						$('.loading').hide();
						//console.log(res);
						alert('Invitation sent successfully');
						location.reload();
					}
				});
			}
		});
	});
	
	function removeRow(row) {
		if(row != 1) {
			$("table#invites tr:nth-child("+row+")").remove();
			var last_val = $('#chk_inv').val();
			var count_val = parseInt(last_val) - 1;
			$('#chk_inv').val(count_val);
		}
	}
	
	function resendInvite(firstName, lastName, email, groupCode, username, campId, invityId) {
		url = "<?php echo url('admin/group/resendInvite'); ?>";
		var data = { firstName : firstName, lastName : lastName, email : email, groupCode: groupCode, username: username, campId: campId }
		$.ajax({
			type : 'POST',
			url : url,
			data : data,
			beforeSend: function() {
				$('.resendInvite').bind('click', false);
				$('.'+invityId).show();
			},
			success:function(res) {
				$('.'+invityId).hide();
				alert('Invitation resent successfully');
				
			}
		});
	}
	
	function displayContent(id, firstName, lastName, email) {
		$('#invity_id').val(id);
		$('#invity_first_name').val(firstName);
		$('#invity_last_name').val(lastName);
		$('#invity_email').val(email);
	}
	
	function updateInvity() {
		var id = $('#invity_id').val();
		var firstName = $('#invity_first_name').val();
		var lastName = $('#invity_last_name').val();
		var email = $('#invity_email').val();
		error = false;
		if(firstName == '') {
			$('#invity_first_name').css("border-color", "red");
			error = true;
		} else {
			$('#invity_first_name').css("border-color", "");
		}
		if(lastName == '') {
			$('#invity_last_name').css("border-color", "red");
			error = true;
		} else {
			$('#invity_last_name').css("border-color", "");
		}
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(email == '') {
			$('#invity_email').css("border-color", "red");
			error = true;
		} else if(!regex.test(email)) {
			$('#invity_email').css("border-color", "red");
			error = true;
		} else {
			$('#invity_email').css("border-color", "");
		}
		if(!error) {
			url = "<?php echo url('admin/group/updateInvite'); ?>";
			var data = { id: id, firstName : firstName, lastName : lastName, email : email }
			$.ajax({
				type : 'POST',
				url : url,
				data : data,
				beforeSend: function() {
					$('#update').attr('disabled','disabled');
					$('.updateLoading').show();
				},
				success:function(res) {
					$('.updateLoading').hide();
					alert('Updated successfully');
					location.reload();
				}
			});
		}
	}
	
	function deleteInvity(id) {
		var r = confirm("Are you sure want to delete?");
		if (r == true) {
			url = "<?php echo url('admin/group/deleteInvity'); ?>";
			var data = { id: id }
			$.ajax({
				type : 'POST',
				url : url,
				data : data,
				beforeSend: function() {
					$('.updateLoading').show();
				},
				success:function(res) {
					alert('Deleted successfully');
					location.reload();
				}
			});
		}
	}
</script>
  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection