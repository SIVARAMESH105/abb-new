<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Http\Requests;
use App\Http\Requests\EditAdminProfile as UpdateRequest;
use App\Http\Requests\ChangePassword as ChangePasswordRequest;
//use App\Http\Controllers\Auth;
use Auth;

class UserController extends Controller
{
	function __construct()
	{
		$this->userObj = new user();
	}
	
    public function edit(Request $request, $id)
    {
		return view('Admin.edit_profile');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
		$status = $this->userObj->updateProfile($request->all(), $id);
		if($status) {
			\Alert::success('Profile updated successfully')->flash();
			return \Redirect::to('admin/edit_profile/'.$status);
		} else {
			\Alert::error('Profile updation failed')->flash();
			return \Redirect::to('admin/edit_profile/'.$id)->withInput();
		}
    }
	
	public function changePassword(Request $request)
	{
		return view('Admin.change_password');
	}
	
	public function updatePassword(ChangePasswordRequest $request, $id)
	{
		$status = $this->userObj->updatePass($request->all(), $id);
		if($status) {
			\Alert::success('Password updated successfully')->flash();
			return \Redirect::to('admin/change_password');
		} else {
			\Alert::error('Current password not matched')->flash();
			return \Redirect::to('admin/change_password')->withInput();
		}
	}
	
	public function usernameAvail($username)
	{
		$avail = $this->userObj->checkUsernameAvail($username);
	}
}
