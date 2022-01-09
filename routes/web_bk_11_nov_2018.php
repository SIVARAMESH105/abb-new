<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$var1 = Request::URL();
if(preg_match('/public/',$var1)){
	return response()->view('errors.404');
}

Route::get('admin', function () {
	return redirect('admin/login');
});
// Route::get('/404', function () {
// 	return view('404');
// });

Route::group(['middleware' => 'web'], function () {
	Route::get('', ["as"=>"home","uses"=>'Site\HomeController@homePage']);
	Route::get('{page_name}', ["as"=>"cms","uses"=>'Site\HomeController@page']);	
    Route::get('camp/countrySort/{cid}', ["as"=>"cms","uses"=>'Site\HomeController@countrySort']);
	Route::get('camp/register/{cid}', ["as"=>"cms","uses"=>'Site\HomeController@registerPage']);
	Route::get('camp/registerState/{sid}/{cid}', ["as"=>"cms","uses"=>'Site\HomeController@registerStateSort']);
	Route::get('camp/sortMonth/{mid}/{cid}', ["as"=>"cms","uses"=>'Site\HomeController@sortMonth']);
	Route::post('site/contactAction', ["as"=>"cms","uses"=>'Site\HomeController@submitContact']);
	Route::post('camp/registerSave', ["as"=>"cms","uses"=>'Site\HomeController@registerSave']);
	Route::get('site/removeCamp/{cid}', ["as"=>"cart","uses"=>'Site\CartController@removeCampCart']);
	
	Route::get('cart/cartPage', ["as"=>"cart","uses"=>'Site\CartController@cartPage']);
	Route::get('checkout/checkoutPage', ["as"=>"checkout","uses"=>'Site\CartController@checkoutPage']);
	Route::post('checkout/paymentChoose', ["as"=>"checkout","uses"=>'Site\CartController@paymentChoose']);
	Route::post('checkout/paymentConfirmation', ["as"=>"checkout","uses"=>'Site\CartController@paymentConfirmation']);
	Route::post('checkout/confirmPayement', ["as"=>"checkout","uses"=>'Site\CartController@confirmPayement']);
	
	Route::get('productDetail/{pid}', ["as"=>"cart","uses"=>'Site\ProductController@ProductDetail']);
	
	Route::post('product/addProductCart', ["as"=>"checkout","uses"=>'Site\CartController@addProductCart']);
	Route::get('site/removeProduct/{pid}/{pd_price}/{pd_size}/{pd_color}', ["as"=>"cart","uses"=>'Site\CartController@removeProductCart']);
	Route::post('cart/UpdateQtyInfo', ["as"=>"checkout","uses"=>'Site\CartController@UpdateQtyInfo']);
	
	//Route::post('site/loginUser', ["as"=>"user","uses"=>'Site\HomeController@loginUser']);
	Route::post('site/forgotPassword', ["as"=>"user","uses"=>'Site\HomeController@forgotPassword']);
	
	Route::get('pwd/resetPwd/{email}/', ["as"=>"user","uses"=>'Site\HomeController@resetPwd']);
	Route::post('site/updatePassword', ["as"=>"user","uses"=>'Site\HomeController@updatePassword']);
	
	Route::get('user/editProfile', ["as"=>"user","uses"=>'Site\UserController@editProfile']);
	Route::post('user/changeUserProfile', ["as"=>"user","uses"=>'Site\UserController@changeUserProfile']);
	Route::post('user/changeUserPwd', ["as"=>"user","uses"=>'Site\UserController@changeUserPwd']);
	
	Route::get('user/regCamps', ["as"=>"user","uses"=>'Site\UserController@regCamps']);
	Route::post('user/getlist', ["as"=>"user","uses"=>'Site\UserController@getlist']);
	
	Route::get('user/userGroups', ["as"=>"user","uses"=>'Site\UserController@userGroups']);
	Route::post('user/getGroupslist', ["as"=>"user","uses"=>'Site\UserController@getGroupslist']);
	
	Route::get('user/editGroup/{g_id}/', ["as"=>"user","uses"=>'Site\UserController@editUserGroup']);
	
	Route::get('user/addGroup', ["as"=>"user","uses"=>'Site\UserController@addGroup']);
	Route::post('user/inviteUserGroup', ["as"=>"user","uses"=>'Site\UserController@inviteUserGroup']);
	Route::post('user/resendInvite', ["as"=>"user","uses"=>'Site\UserController@resendInvite']);
	Route::post('user/editInvite', ["as"=>"user","uses"=>'Site\UserController@editInvite']);
	
	Route::get('user/deleteInvite/{g_id}/{i_id}/{c_id}/', ["as"=>"user","uses"=>'Site\UserController@deleteGroupInvite']);
	
	Route::post('user/updateUserGroup', ["as"=>"user","uses"=>'Site\UserController@updateUserGroup']);
	
	Route::get('user/purchaseProducts', ["as"=>"user","uses"=>'Site\UserController@purchaseProducts']);
	Route::post('user/getPurchaseProductslist', ["as"=>"user","uses"=>'Site\UserController@getPurchaseProductslist']);
	
	Route::get('viewOrder/{id}', ["as"=>"user","uses"=>'Site\UserController@viewOrder']);
	
	Route::get("user/logout", '\App\Http\Controllers\Auth\LoginController@logout');
	
    Route::post("user/loginUser", '\App\Http\Controllers\Auth\LoginController@login');
    Route::post("uploadPhotos", '\App\Http\Controllers\Site\HomeController@uploadPhotos');

    Route::post('one-on-one/addOneOnOne', ["as"=>"checkout","uses"=>'Site\CartController@addOneOnOne']);
	Route::get('site/removeTraining', ["as"=>"cart","uses"=>'Site\CartController@removeTrainingCart']);
	
	Route::post('site/page404', ["as"=>"page404","uses"=>'Site\HomeController@page404']);
	Route::post('site/empApplyAction', ["as"=>"empApply","uses"=>'Site\HomeController@empApply']);
	Route::get('site/ajaxGetCity',["as"=>"ajaxGetCity","uses"=>'Site\ScheduleController@ajaxGetCity']);
	Route::get('site/ajaxMonthList',["as"=>"ajaxMonthList","uses"=>'Site\ScheduleController@ajaxMonthList']);
	Route::get('site/ajaxGetCamps',["as"=>"ajaxGetCamps","uses"=>'Site\ScheduleController@ajaxGetCamps']);
	

	Route::post('site/getRecurring', ["as"=>"checkout","uses"=>'Site\WebhookController@getRecurring']);

	Route::get('site/ajaxAllCamps', ["as"=>"ajaxAllCamps","uses"=>'Site\ScheduleController@ajaxAllCamps']);
	Route::get('site/ajaxGetState',["as"=>"ajaxGetState","uses"=>'Site\ScheduleController@ajaxGetState']);
	Route::get('site/ajaxCityByDate',["as"=>"ajaxCityByDate","uses"=>'Site\ScheduleController@ajaxCityByDate']);
	Route::get('site/ajaxCampsByDate',["as"=>"ajaxCampsByDate","uses"=>'Site\ScheduleController@ajaxCampsByDate']);
	
	
    
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
