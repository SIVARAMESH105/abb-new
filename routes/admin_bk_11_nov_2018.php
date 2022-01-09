<?php
	// Backpack\CRUD: Define the resources for the entities you want to CRUD.
	CRUD::resource('viewRosters', 'ViewRostersCrudController');
	//CRUD::resource('manageCampers', 'ManageCampersCrudController');
	CRUD::resource('manageCoaches', 'ManageCoachesCrudController');
	CRUD::resource('manageCamps', 'ManageCampsCrudController');
	CRUD::resource('manageLocations', 'ManageLocationsCrudController');
	CRUD::resource('manageCountry', 'ManageCountryCrudController');
	CRUD::resource('manageState', 'ManageStatesCrudController');
	CRUD::resource('manageAssignments', 'ManageAssignmentsCrudController');
	CRUD::resource('manageProducts', 'ManageProductsCrudController');
	//CRUD::resource('campers', 'CamperCrudController');
	CRUD::resource('manageColors', 'ManageColorsCrudController');
	CRUD::resource('coachAssignments', 'AssignmentDetailsCrudController');
	CRUD::resource('manageFlyers', 'ManageFlyersCrudController');
	CRUD::resource('cms', 'ManageCmsCrudController');
	CRUD::resource('staffbios', 'StaffBiosCrudController');
	CRUD::resource('videoGallery', 'VideoGalleryCrudController');
	CRUD::resource('manageGroups', 'ManageGroupsCrudController');

	Route::get('edit_profile/{id}', 'UserController@edit');
	Route::post('update_profile/{id}', 'UserController@update');
	Route::get('change_password', 'UserController@changePassword');
	Route::post('update_password/{id}', 'UserController@updatePassword');
	Route::get('ajaxUsernameAvail/{id}', 'UserController@usernameAvail');
	Route::post('updateCamp/{id}', 'ManageCampsCrudController@update');
	Route::get('camper/{id}', 'CamperCrudController@redirectToCamper');
	Route::get('coachAssignment/{id}', 'AssignmentDetailsCrudController@redirectToCoachAssignments');
	Route::get('rostersXls/{id}', 'ViewRostersCrudController@downloadRostersXls');
	Route::get('rostersPdf/{id}', 'ViewRostersCrudController@downloadRostersPdf');
	Route::get('coachRostersPdf/{id}', 'ViewCoachRostersController@downloadRostersPdf');
	Route::get('orders', 'OrdersController@orderList');
	Route::get('orders/create', 'OrdersController@createOrder');
	Route::post('orders/store', 'OrdersController@store');
	Route::post('searchOrdersWithLastname', 'OrdersController@searchOrdersWithLastname');
	Route::get('viewOrder/{id}', 'OrdersController@viewOrder');
	Route::get('modifyOrderStatus/{id}/{status}', 'OrdersController@modifyOrderStatus');
	Route::get('editCms/{id}', 'ManageCmsCrudController@editCms');
	Route::post('updateCms/{id}', 'ManageCmsCrudController@updateCms');
	Route::get('ajaxReloadStates/{id}', 'ManageStatesCrudController@reloadStates');
	Route::get('campList', 'ManageCampsCrudController@campPopupList');
	Route::get('sendEmailAllCoaches', 'ManageCoachesCrudController@sendEmailAllCoaches');
	Route::get('viewCoachRosters/{id}/{type}', 'ViewCoachRostersController@viewRosters');
	Route::get('coachCampersList/{id}', 'ViewCoachRostersController@coachCampersList');
	Route::get('ajaxGetStateCityName/{id}', 'ManageLocationsCrudController@getStateCityNameByAjax');
	Route::get('groupDetails/{id}', 'ManageGroupsCrudController@groupDetails');
	Route::post('group/inviteMembers', 'ManageGroupsCrudController@inviteMembers');
	Route::post('group/resendInvite', 'ManageGroupsCrudController@resendInvite');
	Route::post('group/updateInvite', 'ManageGroupsCrudController@updateInvite');
	Route::post('group/deleteInvity', 'ManageGroupsCrudController@deleteInvity');
	
	Route::get('manageCampers', 'ManageCampersCrudController@campersList');
	Route::post('getCamperslist', 'ManageCampersCrudController@getCamperslist');
	Route::get('editCamper/{id}/{p_type}', 'ManageCampersCrudController@editCamper');
	Route::post('updateCamper', 'ManageCampersCrudController@updateCamper');
	Route::get('deleteCamper/{id}/{p_type}', 'ManageCampersCrudController@deleteCamper');
	
	Route::get('campers', 'CamperCrudController@campers');
	Route::post('getCamperUserslist', 'CamperCrudController@getCamperUserslist');
    Route::post('video/activestatus/{id}/{videostatus}', 'VideoGalleryCrudController@statusCheck');
    
    Route::get('imagesGallery', 'ImageGalleryCrudController@imagesList');
    Route::post('getimageslist', 'ImageGalleryCrudController@getImageslist');
    Route::post('image/activestatus/{id}/{imagestatus}', 'ImageGalleryCrudController@imageStatus');
