<?php

namespace App\Http\Controllers\Site;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Users;
use App\Models\Site\CountrySite;
use App\Models\Site\Groups;
use App\Models\Site\GroupInvites;
use App\Models\Site\Store;
use App\Models\Site\OrderItem;
use App\Models\Site\Orders;
use App\Models\Site\Camps;
use App\Models\Site\Roster;
use App\Models\Site\Wallet;
use App\Models\Site\Migrate;
use Carbon\Carbon;
use Hash;
use DataTables;
use DB;
use DateTime;
use Redirect;
session_start();

class MigrateController extends Controller
{
    public function __construct(){
		DB::enableQueryLog();
        $this->rosterObj = new Roster();
        $this->userObj = new Users();
        $this->campObj = new Camps();
        $this->walletObj = new Wallet();
        $this->migrateObj = new Migrate();
    }
	
	public function migrateData(){
        try{
             //tbllocation table
          /*$locationAdvbball = DB::connection('mysql1')->select(DB::raw('SELECT `Id`,`Location`, `Address`, `City`, `State`, `Country`, `Zip`, `MapLink`, `AdditionalInfo` FROM tbllocation'));
            $stateId = '';
            $countryId = '';
           if(count($locationAdvbball)>0) {
            $i=1;
             foreach($locationAdvbball as $key=>$Advbball) {
                echo $i. "Location rows inserted";
                echo "<br/>";
                $state = DB::connection('mysql')->select(DB::raw("SELECT `state_id` FROM tbl_state_codes where state_code='".$Advbball->State."'"));
                $country = DB::connection('mysql')->select(DB::raw("SELECT `country_id` FROM tbl_country where country_code='".$Advbball->Country."'"));
                if(count($state) >0 || count($country) > 0) {
                    $stateId = $state[0]->state_id;
                    $countryId = $country[0]->country_id;
                }
                $insertQry = DB::connection('mysql')->insert(DB::raw("INSERT INTO `tbllocation`(`Id`,`Location`, `Address`, `City`, `State`, `Country`, `Zip`, `MapLink`, `AdditionalInfo`, `geo`, `slug_url`) VALUES ('".$Advbball->Id."', '".addslashes($Advbball->Location)."','".addslashes($Advbball->Address)."','".$Advbball->City."','".$stateId."','".$countryId."','".$Advbball->Zip."','".$Advbball->MapLink."','".addslashes($Advbball->AdditionalInfo)."','no',NULL)"));
                $i++;
                
             }
			}*/
             //tbl_camp table
            /*$campAdvbballs = DB::connection('mysql1')->select(DB::raw('SELECT `id`, `camp_focus`, `LocationId`, `location`, `address`, `city`, `state`, `zip`, `AdditionalInfo`, `country`, `startdate`, `enddate`, `starttime`, `endtime`, `date_time`, `season`, `cost`, `EarlyBirdDiscount`, `contact`, `description`, `CutoffDays`, `EarlyBirdDays`, `status`, `flyer_id`, `last_update` FROM tbl_camp'));
            if(count($campAdvbballs)>0) {
                $i=1;
                foreach($campAdvbballs as $key=>$campAdvbball) {
                    echo $i. "Camp table rows inserted";
                    echo "<br/>";
                    $insertQry = DB::connection('mysql')->insert(DB::raw("INSERT INTO `tbl_camp`(`id`,`camp_focus`, `LocationId`, `address`, `zip`, `AdditionalInfo`, `country`, `startdate`, `enddate`, `starttime`, `endtime`, `date_time`, `season`, `cost`, `EarlyBirdDiscount`, `contact`, `description`, `CutoffDays`, `EarlyBirdDays`, `status`, `coach_id`, `flyer_id`, `last_update`) VALUES ('".$campAdvbball->id."', '".addslashes($campAdvbball->camp_focus)."','".$campAdvbball->LocationId."','".addslashes($campAdvbball->address)."','".$campAdvbball->zip."','".addslashes($campAdvbball->AdditionalInfo)."','".$campAdvbball->country."','".$campAdvbball->startdate."','".$campAdvbball->enddate."','".$campAdvbball->starttime."','".$campAdvbball->endtime."','".$campAdvbball->date_time."','".$campAdvbball->season."','".$campAdvbball->cost."','".$campAdvbball->EarlyBirdDiscount."','".addslashes($campAdvbball->contact)."','".$campAdvbball->description."','".$campAdvbball->CutoffDays."','".$campAdvbball->EarlyBirdDays."','".$campAdvbball->status."',NULL,'".$campAdvbball->flyer_id."','".$campAdvbball->last_update."')"));
                    $i++;
                }
            }*/
            //tbl_order table 
            /*$orderAdvbballs = DB::connection('mysql1')->select(DB::raw('SELECT `od_id`, `od_date`, `od_last_update`, `od_status`, `od_memo`, `od_shipping_first_name`, `od_shipping_last_name`, `od_shipping_address1`, `od_shipping_address2`, `od_shipping_phone`, `od_shipping_work_phone`, `od_shipping_city`, `od_shipping_state`, `od_shipping_postal_code`, `od_shipping_country`, `od_shipping_email`, `od_shipping_cost`, `od_wa_cost`, `od_payment_first_name`, `od_payment_last_name`, `od_payment_address1`, `od_payment_address2`, `od_payment_phone`, `od_payment_work_phone`, `od_payment_city`, `od_payment_state`, `od_payment_postal_code`, `od_payment_country`, `od_payment_type`, `od_payment_cctype`, `od_payment_ccnumber`, `od_payment_invoice`, `od_payment_approval_code`, `od_payment_transaction_id`, `od_checkout_comments` FROM `tbl_order` limit 20000, 20000'));//limit 0, 20000' next limit 20000, 20000'
            if(count($orderAdvbballs)>0) {
                $i=1;
                foreach($orderAdvbballs as $key=>$orderAdvbball) {
                    echo $i. "Order table rows inserted ".$orderAdvbball->od_id;
                    echo "<br/>";
                    $insertQry = DB::connection('mysql')->insert(DB::raw("INSERT INTO `tbl_order`(`od_id`, `od_date`, `od_last_update`, `od_status`, `user_id`, `od_memo`, `od_shipping_first_name`, `od_shipping_last_name`, `od_shipping_address1`, `od_shipping_address2`, `od_shipping_phone`, `od_shipping_work_phone`, `od_shipping_city`, `od_shipping_state`, `od_shipping_postal_code`, `od_shipping_country`, `od_shipping_email`, `od_shipping_cost`, `od_wa_cost`, `od_payment_first_name`, `od_payment_last_name`, `od_payment_address1`, `od_payment_address2`, `od_payment_phone`, `od_payment_work_phone`, `od_payment_city`, `od_payment_state`, `od_payment_postal_code`, `od_payment_country`, `od_payment_type`, `od_payment_cctype`, `od_payment_ccnumber`, `od_payment_invoice`, `od_payment_approval_code`, `od_payment_transaction_id`, `od_checkout_comments`) VALUES ('".$orderAdvbball->od_id."','".$orderAdvbball->od_date."','".addslashes($orderAdvbball->od_last_update)."','".addslashes($orderAdvbball->od_status)."','','".addslashes($orderAdvbball->od_memo)."','".addslashes($orderAdvbball->od_shipping_first_name)."','".addslashes($orderAdvbball->od_shipping_last_name)."','".addslashes($orderAdvbball->od_shipping_address1)."','".addslashes($orderAdvbball->od_shipping_address2)."','".addslashes($orderAdvbball->od_shipping_phone)."','".addslashes($orderAdvbball->od_shipping_work_phone)."','".addslashes($orderAdvbball->od_shipping_city)."','".addslashes($orderAdvbball->od_shipping_state)."','".addslashes($orderAdvbball->od_shipping_postal_code)."','".addslashes($orderAdvbball->od_shipping_country)."','".addslashes($orderAdvbball->od_shipping_email)."','".addslashes($orderAdvbball->od_shipping_cost)."','".addslashes($orderAdvbball->od_wa_cost)."','".addslashes($orderAdvbball->od_payment_first_name)."','".addslashes($orderAdvbball->od_payment_last_name)."','".addslashes($orderAdvbball->od_payment_address1)."','".addslashes($orderAdvbball->od_payment_address2)."','".addslashes($orderAdvbball->od_payment_phone)."','".addslashes($orderAdvbball->od_payment_work_phone)."','".addslashes($orderAdvbball->od_payment_city)."','".addslashes($orderAdvbball->od_payment_state)."','".addslashes($orderAdvbball->od_payment_postal_code)."','".addslashes($orderAdvbball->od_payment_country)."','".addslashes($orderAdvbball->od_payment_type)."','".addslashes($orderAdvbball->od_payment_cctype)."','".addslashes($orderAdvbball->od_payment_ccnumber)."','".addslashes($orderAdvbball->od_payment_invoice)."','".addslashes($orderAdvbball->od_payment_approval_code)."','".addslashes($orderAdvbball->od_payment_transaction_id)."','".addslashes($orderAdvbball->od_checkout_comments)."')"));
                    $i++;
                }
            }*/
            //tbl_order_camp table
            /*$ocampAdvbballs = DB::connection('mysql1')->select(DB::raw('SELECT `od_id`, `camp_id`, `roster_id`, `last_update` FROM `tbl_order_camp` limit 20000, 20000'));//limit 0, 20000' next limit 20000, 20000');
            if(count($ocampAdvbballs)>0) {
                $i=1;
                foreach($ocampAdvbballs as $key=>$ocampAdvbball) {
                    echo $i. "Order camp table rows inserted ".$ocampAdvbball->od_id;
                    echo "<br/>";
                   $insertQry = DB::connection('mysql')->insert(DB::raw("INSERT INTO `tbl_order_camp`(`od_id`, `camp_id`, `roster_id`, `user_id`, `last_update`) VALUES ('".$ocampAdvbball->od_id."','".$ocampAdvbball->camp_id."','".$ocampAdvbball->roster_id."','','".$ocampAdvbball->last_update."')"));
                    $i++; 
                }
            }*/
            //tbl_order_item table
            /*$oitemAdvbballs = DB::connection('mysql1')->select(DB::raw('SELECT `od_id`, `pd_id`, `od_qty`, `od_size`, `od_color`, `sts` FROM `tbl_order_item`'));//limit 0, 20000' next limit 20000, 20000');
            if(count($oitemAdvbballs)>0) {
                $i=1;
                foreach($oitemAdvbballs as $key=>$oitemAdvbball) {
                    echo $i. "Order item table rows inserted ".$oitemAdvbball->od_id;
                    echo "<br/>";
                   $insertQry = DB::connection('mysql')->insert(DB::raw("INSERT INTO `tbl_order_item`(`od_id`, `pd_id`, `od_qty`, `od_size`, `od_color`, `od_user_id`, `od_price`, `sts`) VALUES ('".$oitemAdvbball->od_id."','".$oitemAdvbball->pd_id."','".$oitemAdvbball->od_qty."','".$oitemAdvbball->od_size."','".$oitemAdvbball->od_color."','','','".$oitemAdvbball->sts."')"));
                    $i++; 
                }
            }*/
            //tbl_state_codes table
           /*$stCodeAdvbballs = DB::connection('mysql1')->select(DB::raw('SELECT `state_id`, `state_code`, `state_name`, `country_id`, `status` FROM `tbl_state_codes`'));//limit 0, 20000' next limit 20000, 20000');
            if(count($stCodeAdvbballs)>0) {
                $i=1;
                $countryId='';
                foreach($stCodeAdvbballs as $key=>$stCodeAdvbball) {
                    echo $i. "state code table rows inserted ".$stCodeAdvbball->state_id;
                    echo "<br/>";
                    $country = DB::connection('mysql')->select(DB::raw("SELECT `country_id` FROM tbl_country where country_code='".$stCodeAdvbball->country_id."'"));
                    if( count($country) > 0) {
                        $countryId = $country[0]->country_id;
                    }
                   $insertQry = DB::connection('mysql')->insert(DB::raw("INSERT INTO `tbl_state_codes`(`state_code`, `state_name`, `country_id`, `status`) VALUES ('".$stCodeAdvbball->state_code."','".$stCodeAdvbball->state_name."','".$countryId."','".$stCodeAdvbball->status."')"));
                    $i++; 
                }
            }*/
             //tbl_coach table
          /*$tblcoachAdvbballs = DB::connection('mysql1')->select(DB::raw('SELECT `id`,`user_id`, `first_name`, `last_name`, `gender`, `dob`, `address`, `city`, `state`, `zip`, `country`, `home_phone`, `work_phone`, `email`, `emp_startdate`, `notes`, `cellphone`, `tshirt_size`, `last_update` FROM `tbl_coach'));//limit 0, 20000' next limit 20000, 20000');
            if(count($tblcoachAdvbballs)>0) {
                $i=1;
                $countryId='';
                foreach($tblcoachAdvbballs as $key=>$tblcoachAdvbball) {
                    echo $i. "coach table rows inserted ".$tblcoachAdvbball->id;
                    echo "<br/>";
                    $country = DB::connection('mysql')->select(DB::raw("SELECT `country_id` FROM tbl_country where country_code='".$tblcoachAdvbball->country."'"));
                    if( count($country) > 0) {
                        $countryId = $country[0]->country_id;
                    }
                   $insertQry = DB::connection('mysql')->insert(DB::raw("INSERT INTO `tbl_coach`( `id`, `user_id`, `first_name`, `last_name`, `gender`, `dob`, `address`, `city`, `state`, `zip`, `country`, `home_phone`, `work_phone`, `email`, `emp_startdate`, `notes`, `cellphone`, `tshirt_size`, `last_update`) VALUES ('".$tblcoachAdvbball->id."', '".$tblcoachAdvbball->user_id."','".$tblcoachAdvbball->first_name."','".$tblcoachAdvbball->last_name."','".$tblcoachAdvbball->gender."','".$tblcoachAdvbball->dob."','".$tblcoachAdvbball->address."','".$tblcoachAdvbball->city."','".$tblcoachAdvbball->state."','".$tblcoachAdvbball->zip."','".$countryId."','".$tblcoachAdvbball->home_phone."','".$tblcoachAdvbball->work_phone."','".$tblcoachAdvbball->email."','".$tblcoachAdvbball->emp_startdate."','".$tblcoachAdvbball->notes."','".$tblcoachAdvbball->cellphone."','".$tblcoachAdvbball->tshirt_size."','".$tblcoachAdvbball->last_update."')"));
                    $i++; 
                }
            }*/

            /* tbl_roster table */
            /*$tblRosterAdvbballs = DB::connection('mysql1')->select(DB::raw('SELECT `id`, `name`, `fname`, `tshirtsize`, `gender`, `dob`, `grade`, `parent_firstname`, `parent_lastname`, `address`, `city`, `state`, `zip`, `country`, `home_phone`, `work_phone`, `parent_email`, `basketball_exp`, `basketball_exp_desc`, `basketball_skill`, `camp_id`, `amount_paid`, `comments`, `hear`, `status`, `last_update` FROM `tbl_roster` limit 20000, 20000'));
            if(count($tblRosterAdvbballs)>0) {
            	//echo "<pre>"; print_r($tblRosterAdvbballs); echo "</pre>";
            	//exit;
            	$i=1;
            	foreach($tblRosterAdvbballs as $key=>$tblRosterAdvbball) {
            		//check roster
            		$res = DB::connection('mysql')->select(DB::raw("SELECT count(`id`) as count FROM `tbl_roster` WHERE `id`='".$tblRosterAdvbball->id."'"));//limit 0, 20000' next limit 20000, 20000');
            		if($res[0]->count == 1) {
            			//update the advbballdev_new.tbl_roster

            			echo "update record is: $i and roster id is:".$tblRosterAdvbball->id;
            			echo "<br/>=======================</br>";
            			$updateQry = DB::connection('mysql')->update(DB::raw("UPDATE `tbl_roster` SET `tshirtsize`='".addslashes($tblRosterAdvbball->tshirtsize)."',`camp_id`='".addslashes($tblRosterAdvbball->camp_id)."',`amount_paid`='".addslashes($tblRosterAdvbball->amount_paid)."',`comments`='".addslashes($tblRosterAdvbball->comments)."',`hear`='".addslashes($tblRosterAdvbball->hear)."',`status`='".addslashes($tblRosterAdvbball->status)."',`last_update`='".$tblRosterAdvbball->last_update."' WHERE id='".$tblRosterAdvbball->id."'"));
            		} else {
            			echo "insert record is: $i and roster id is:".$tblRosterAdvbball->id;
            			echo "<br/>=======================</br>";
            			//else insert 
            			$insertQry = DB::connection('mysql')->insert(DB::raw("INSERT INTO `tbl_roster`(`id`,`tshirtsize`, `camp_id`, `amount_paid`, `comments`, `hear`, `status`, `last_update`) VALUES ('".$tblRosterAdvbball->id."','".addslashes($tblRosterAdvbball->tshirtsize)."', '".addslashes($tblRosterAdvbball->camp_id)."', '".addslashes($tblRosterAdvbball->amount_paid)."', '".addslashes($tblRosterAdvbball->comments)."', '".addslashes($tblRosterAdvbball->hear)."','".addslashes($tblRosterAdvbball->status)."','".$tblRosterAdvbball->last_update."')"));
            		}
            		$i++;
            	}

            }*/
            //users table
            /*$usersTbl = DB::connection('mysql1')->select(DB::raw('SELECT  * FROM `tbl_user`'));
            if(count($usersTbl)>0) {
            	//get the tbl_coach reacod only userid
            	//echo "<pre>"; print_r($usersTbl); echo "</pre>";
            	$i=1;
            	foreach($usersTbl as $key=>$users) {
            		echo "<br/>";
            		echo $i."User inserted: ".$users->user_id;
            		echo "<br/>";
            		$tblcoachAdvbballs = DB::connection('mysql1')->select(DB::raw("SELECT `id`,`user_id`, `first_name`, `last_name`, `gender`, `dob`, `address`, `city`, `state`, `zip`, `country`, `home_phone`, `work_phone`, `email`, `emp_startdate`, `notes`, `cellphone`, `tshirt_size`, `last_update` FROM `tbl_coach` where `user_id`='".$users->user_id."'"));
            		$password = Hash::make($users->user_password);
            		$user_type = $users->user_type;
            		$created_at = $users->user_regdate;
            		$user_last_login = $users->user_last_login;
            		if(count($tblcoachAdvbballs) > 0) {

            			$email = $tblcoachAdvbballs[0]->email;
            			$fname = $tblcoachAdvbballs[0]->first_name;
            			$gender = $tblcoachAdvbballs[0]->gender;
            			$dob = $tblcoachAdvbballs[0]->dob;
            			$address = $tblcoachAdvbballs[0]->address;
            			$city = $tblcoachAdvbballs[0]->city;
            			$state = $tblcoachAdvbballs[0]->state;
            			$zip = $tblcoachAdvbballs[0]->zip;
            			$country = $tblcoachAdvbballs[0]->country;
            			$home_phone = $tblcoachAdvbballs[0]->home_phone;
            			$work_phone = $tblcoachAdvbballs[0]->work_phone;
            			//insert users table for new database
            			
            			$insertQry = DB::connection('mysql')->insert(DB::raw("INSERT INTO `users`(`id`, `name`, `email`, `password`, `fname`, `gender`, `dob`, `grade`, `parent_firstname`, `parent_lastname`, `address`, `city`, `state`, `zip`, `country`, `home_phone`, `work_phone`, `parent_email`, `basketball_exp`, `basketball_exp_desc`, `basketball_skill`, `remember_token`, `user_type`, `affiliate_reference_code`, `created_at`, `updated_at`, `user_last_login`) VALUES ('".$users->user_id."','".$users->user_name."','".$email."','".$password."','".$fname."','".$gender."','".$dob."','default','default','default','".$address."','".$city."','".$state."','".$zip."','".$country."','".$home_phone."','".$work_phone."','default','default','default','default','default','".$user_type."','','".$created_at."','','".$user_last_login."')"));

            		} else {
            			$email ='default'.$i;
            			$insertQry = DB::connection('mysql')->insert(DB::raw("INSERT INTO `users`(`id`, `name`, `email`, `password`, `fname`, `gender`, `dob`, `grade`, `parent_firstname`, `parent_lastname`, `address`, `city`, `state`, `zip`, `country`, `home_phone`, `work_phone`, `parent_email`, `basketball_exp`, `basketball_exp_desc`, `basketball_skill`, `remember_token`, `user_type`, `affiliate_reference_code`, `created_at`, `updated_at`, `user_last_login`) VALUES ('".$users->user_id."','".$users->user_name."','".$email."','".$password."','default','default','0000-00-00','default','default','default','default','default','default','default','default','default','default','default','default','default','default','default','".$user_type."','','".$created_at."','','".$user_last_login."')"));
            		}
            		$i++;
            		//echo "<pre>"; print_r($tblcoachAdvbballs); echo "</pre>";
            	}
            }*/
        } catch(\Exception $e) {

    		print_r($e->getMessage());exit;
        }
    }
}
