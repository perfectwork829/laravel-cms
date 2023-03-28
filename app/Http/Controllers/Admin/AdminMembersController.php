<?php
/*
Project Name: IonicEcommerce
Project URI: http://ionicecommerce.com
Author: VectorCoder Team
Author URI: http://vectorcoder.com/
Version: 2.1
*/
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

//validator is builtin class in laravel
use Validator;

use DB;
//for password encryption or hash protected

use Hash;
use App\Administrator;

//for authenitcate login data
use Auth;

//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//for requesting a value 
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;

class AdminMembersController extends Controller
{
	
	public function listingCustomers(Request $request){
		$title = array('pageTitle' => 'Listing Members');
		//$language_id            				=   $request->language_id;
		$language_id            				=   '1';			
		
		$customerData = array();
		$message = array();
		$errorMessage = array();
		
		$customers = DB::table('customers')->paginate(10);
		$customers[0]->customers_default_address_id;
		
		//get function from ManufacturerController controller
		$myVar = new AddressController();
		$customerData['countries'] = $myVar->getAllCountries();
		
		//get function from ManufacturerController controller
		$myVar = new AddressController();
		$customerData['address'] = $myVar->getAllAddress($customers[0]->customers_id);
		
		//print_r()
		$customerData['customers'] = $customers;
		$customerData['message'] = $message;
		$customerData['errorMessage'] = $errorMessage;
		
		//print_r($customerData['address']);
		return view("admin.listingCustomers",$title)->with('customers', $customerData);
	}
	
	
}
