<?php

	/*
	|--------------------------------------------------------------------------
	| Unauthorized Routes For Admin
	|--------------------------------------------------------------------------
	*/
	Route::group(['middleware' => ['SuperAdminMiddleware']], function(){
		// Backpack\CRUD: Define the resources for the entities you want to CRUD.
		CRUD::resource('viewRosters', 'ViewRostersCrudController');
		//CRUD::resource('manageCampers', 'ManageCampersCrudController');
		CRUD::resource('manageCamps', 'ManageCampsCrudController');
		CRUD::resource('manageLocations', 'ManageLocationsCrudController');
		CRUD::resource('manageCountry', 'ManageCountryCrudController');
		CRUD::resource('manageState', 'ManageStatesCrudController');
		CRUD::resource('manageAssignments', 'ManageAssignmentsCrudController');
		CRUD::resource('manageProducts', 'ManageProductsCrudController');
		//CRUD::resource('campers', 'CamperCrudController');
		CRUD::resource('manageColors', 'ManageColorsCrudController');
		CRUD::resource('manageFlyers', 'ManageFlyersCrudController');
		CRUD::resource('cms', 'ManageCmsCrudController');
		CRUD::resource('staffbios', 'StaffBiosCrudController');
		CRUD::resource('videoGallery', 'VideoGalleryCrudController');
		CRUD::resource('manageGroups', 'ManageGroupsCrudController');
		Route::post('ajaxDeleteFeatureimage', 'ManageCmsCrudController@deleteFeatureImage');  
		
			// Directors CRUD
		Route::get('manageDirectors', 'ManageDirectorsCrudController@directorsList');
		Route::post('getDirectorsList', 'ManageDirectorsCrudController@getDirectorsList');
		Route::get('createDirector', 'ManageDirectorsCrudController@createDirector');
		Route::post('storeDirector', 'ManageDirectorsCrudController@storeDirector');
		Route::get('editDirector/{id}', 'ManageDirectorsCrudController@editDirector');
		Route::post('updateDirector', 'ManageDirectorsCrudController@updateDirector');
		Route::get('deleteDirector/{director_id}', 'ManageDirectorsCrudController@deleteDirector');
		
		Route::get('manageCampers', 'ManageCampersCrudController@campersList');
		Route::post('getCamperslist', 'ManageCampersCrudController@getCamperslist');
		Route::get('editCamper/{id}/{p_type}', 'ManageCampersCrudController@editCamper');
		Route::post('updateCamper', 'ManageCampersCrudController@updateCamper');
		Route::get('deleteCamper/{id}/{p_type}', 'ManageCampersCrudController@deleteCamper');
		
		#Dropzone
		Route::post('dropzoneUpload', 'DropzoneController@dropzoneUpload');
		#Ajax video gallary
		Route::post('ajaxGetVideoGallary', 'VideoGalleryCrudController@ajaxGetVideoGallary');
		
		Route::get('campers', 'CamperCrudController@campers');
		Route::post('getCamperUserslist', 'CamperCrudController@getCamperUserslist');
		Route::post('video/activestatus/{id}/{videostatus}', 'VideoGalleryCrudController@statusCheck');
		
		Route::get('imagesGallery', 'ImageGalleryCrudController@imagesList');
		Route::post('getimageslist', 'ImageGalleryCrudController@getImageslist');
		Route::post('image/activestatus/{id}/{imagestatus}', 'ImageGalleryCrudController@imageStatus');
		
		//Ajx slug URL
		Route::post("ajaxSlugUrl","ManageLocationsCrudController@toVerifySlugUrl");
		
		Route::post('updateCamp/{id}', 'ManageCampsCrudController@update');
		Route::get('camper/{id}', 'CamperCrudController@redirectToCamper');
		
		Route::get('rostersXls/{id}', 'ViewRostersCrudController@downloadRostersXls');
		Route::get('rostersPdf/{id}', 'ViewRostersCrudController@downloadRostersPdf');
		Route::get('orders', 'OrdersController@orderList');
		Route::get('orders/create', 'OrdersController@createOrder');
		Route::post('orders/store', 'OrdersController@store');
		Route::post('searchOrdersWithLastname', 'OrdersController@searchOrdersWithLastname');
		Route::get('viewOrder/{id}', 'OrdersController@viewOrder');
		//Route::get('modifyOrderStatus/{id}/{status}', 'OrdersController@modifyOrderStatus');
		Route::post('modifyOrderStatus', 'OrdersController@modifyOrderStatus');
		Route::get('editCms/{id}', 'ManageCmsCrudController@editCms');
		Route::post('updateCms/{id}', 'ManageCmsCrudController@updateCms');
		Route::get('ajaxReloadStates/{id}', 'ManageStatesCrudController@reloadStates');
		Route::get('campList', 'ManageCampsCrudController@campPopupList');
		//Route::get('sendEmailAllCoaches', 'ManageCoachesCrudController@sendEmailAllCoaches');
		
		Route::get('ajaxGetStateCityName/{id}', 'ManageLocationsCrudController@getStateCityNameByAjax');
		Route::get('groupDetails/{id}', 'ManageGroupsCrudController@groupDetails');
		Route::post('group/inviteMembers', 'ManageGroupsCrudController@inviteMembers');
		Route::post('group/resendInvite', 'ManageGroupsCrudController@resendInvite');
		Route::post('group/updateInvite', 'ManageGroupsCrudController@updateInvite');
		Route::post('group/deleteInvity', 'ManageGroupsCrudController@deleteInvity');
		// Affiliate CRUD
		Route::get('manageAffiliate', 'AffiliateController@affiliateList');
		Route::get('createAffiliate', 'AffiliateController@createAffiliate');
		Route::post('getAffiliateList', 'AffiliateController@getAffiliateList');
		Route::get('deleteAffiliate/{affiliate_id}', 'AffiliateController@deleteAffiliate');
		Route::post('storeAffiliate', 'AffiliateController@storeAffiliate');
		Route::get('editAffiliate/{id}', 'AffiliateController@editAffiliate');
		Route::post('updateAffiliate', 'AffiliateController@updateAffiliate');
        Route::post('affiliateApprove', 'AffiliateController@affiliateApprove');
        Route::get('affiliateReports', 'AffiliateController@affiliateReports');
        Route::post('getAffiliateReportList', 'AffiliateController@getAffiliateReportList');
		Route::post('ajaxAffiliatePaymentStatus', 'AffiliateController@ajaxAffiliatePaymentStatus');
        Route::get('trackWebShipment', 'WebShipmentsController@trackWebShipment');
        Route::post('getTrackWebShipmentList', 'WebShipmentsController@getTrackWebShipmentList');
        
         
   });
   
   Route::group(['middleware' =>['Directors']], function() {
		CRUD::resource('manageCoaches', 'ManageCoachesCrudController');
		Route::get('sendEmailAllCoaches', 'ManageCoachesCrudController@sendEmailAllCoaches');
		CRUD::resource('coachAssignments', 'AssignmentDetailsCrudController');
		Route::get('coachAssignment/{id}', 'AssignmentDetailsCrudController@redirectToCoachAssignments');
  		Route::post('ajaxGetStateReportCityName', 'ManageLocationsCrudController@getStateReportCityNameByAjax');
		Route::post('ajaxGetCityReportLocationName', 'ManageLocationsCrudController@getCityReportLocationNameByAjax');
		Route::post('ajaxGetLocationReportCampName', 'ManageLocationsCrudController@getLocationReportCampNameByAjax');
		Route::post('ajaxGetDirectorReportCoachName', 'ManageLocationsCrudController@getDirectorReportCoachNameByAjax');
		Route::get('reports', 'ReportsController@reportsList');
   });
   
    Route::group(['middleware' =>['Coach']], function() {
		Route::get('viewCoachRosters/{id}/{type}', 'ViewCoachRostersController@viewRosters');
		Route::get('coachCampersList/{id}', 'ViewCoachRostersController@coachCampersList');
		Route::get('coachRostersPdf/{id}', 'ViewCoachRostersController@downloadRostersPdf');
		
   });     
   

	Route::get('edit_profile/{id}', 'UserController@edit');
	Route::post('update_profile/{id}', 'UserController@update');
	Route::get('change_password', 'UserController@changePassword');
	Route::post('update_password/{id}', 'UserController@updatePassword');
	Route::get('ajaxUsernameAvail/{id}', 'UserController@usernameAvail');
    

    // Rosters report
    
    Route::get('rosterReportView', 'RosterReportsController@rosterReportView');
    Route::post('rosterReports', 'RosterReportsController@rosterReport');
    Route::post('rosterReportTable', 'RosterReportsController@rosterReportTable');
    Route::get('camperRevenue/{camp_id}', 'RosterReportsController@camperRevenue');
    Route::post('getCamperRevenueList', 'RosterReportsController@getCamperRevenueList');
    // Director list report
	Route::get('directorReport', 'DirectorListReportsController@directorReportView');
	Route::get('directorReportindex', 'DirectorListReportsController@index');

    // Coach assignments report
    Route::get('coachAssignmentsReportView', 'CoachAssignmentsReportsController@coachAssignmentsReportView');
    Route::post('coachAssignmentsReports', 'CoachAssignmentsReportsController@coachAssignmentsReport');
    Route::post('coachAssignmentsReportTable', 'CoachAssignmentsReportsController@coachAssignmentsReportTable');

    // Revenue report
    Route::post('revenueReports', 'RevenueReportsController@revenueReports');
    Route::get('revenueReportView', 'RevenueReportsController@revenueReportView');
    Route::post('revenueReportTable', 'RevenueReportsController@revenueReportTable');
    //coach revenue report
	Route::post('coachRevenueReport', 'RevenueReportsController@coachRevenueReport');

	//To do need to remove in future for getStructuredDataCity routes
	Route::get('getStructuredDataCity/{id}', 'ManageLocationsCrudController@getStructuredDataCity');
	
    
	

    



