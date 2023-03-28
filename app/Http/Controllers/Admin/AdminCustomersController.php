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
use App;
use Lang;
use DB;
//for password encryption or hash protected

use Hash;
use App\Administrator;

//for authenitcate login data
use Auth;
//for redirect
use Illuminate\Support\Facades\Redirect;
//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//for requesting a value 
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;

class AdminCustomersController extends Controller
{
	//add listingCustomers
	public function listingCustomers(Request $request){
		$title = array('pageTitle' => Lang::get("labels.ListingCustomers"));
		$language_id            				=   '1';			
		
		$customerData = array();
		$message = array();
		$errorMessage = array();
		
		$customers = DB::table('customers')
			->LeftJoin('address_book','address_book.address_book_id','=', 'customers.customers_default_address_id')
			->LeftJoin('countries','countries.countries_id','=', 'address_book.entry_country_id')
			->LeftJoin('zones','zones.zone_id','=', 'address_book.entry_zone_id')
			->LeftJoin('customers_info','customers_info.customers_info_id','=', 'customers.customers_id')
			->select('customers.*', 'address_book.entry_gender as entry_gender', 'address_book.entry_company as entry_company', 'address_book.entry_firstname as entry_firstname', 'address_book.entry_lastname as entry_lastname', 'address_book.entry_street_address as entry_street_address', 'address_book.entry_suburb as entry_suburb', 'address_book.entry_postcode as entry_postcode', 'address_book.entry_city as entry_city', 'address_book.entry_state as entry_state', 'countries.*', 'zones.*')
			->orderBy('customers.customers_id','ASC')
			->paginate(50);
			
		$result = array();
		$index = 0;
		foreach($customers as $customers_data){
			array_push($result, $customers_data);
			
			$devices = DB::table('devices')->where('customers_id','=',$customers_data->customers_id)->orderBy('register_date','DESC')->take(1)->get();
			$result[$index]->devices = $devices;
			$index++;
		}
		
		$customerData['message'] = $message;
		$customerData['errorMessage'] = $errorMessage;
		$customerData['result'] = $customers;
		
		return view("admin.listingCustomers",$title)->with('customers', $customerData);
	}
	
	//add addCustomers page
	public function addCustomers(Request $request){
		$title = array('pageTitle' => Lang::get("labels.AddCustomer"));
		//$language_id            				=   $request->language_id;
		$language_id            				=   '1';			
		//print_r($request->all());
		
		$customerData = array();
		$message = array();
		$errorMessage = array();
		
		//get function from ManufacturerController controller
		$myVar = new AddressController();
		$customerData['countries'] = $myVar->getAllCountries();
		
		
		$customerData['message'] = $message;
		$customerData['errorMessage'] = $errorMessage;
		
		//print_r($customerData['address']);
		return view("admin.addCustomers",$title)->with('customers', $customerData);
	}
	
	//add addCustomers data and redirect to address
	public function addNewCustomers(Request $request){
				
		//$language_id            				=   $request->language_id;
		$language_id            				=   '1';			
		
		$customerData = array();
		$message = array();
		$errorMessage = array();
		
		//check email already exists
		$existEmail = DB::table('customers')->where('customers_email_address', '=', $request->customers_email_address)->get();
		//print_r(count($existEmail));
		if(count($existEmail)>0){
			$title = array('pageTitle' => 'Add Customer');
			
			$customerData['message'] = $message;
			$customerData['errorMessage'] = 'Email address already exist.';
			return view("admin.addCustomers",$title)->with('customers', $customerData);
		}else{
						
			if($request->hasFile('newImage')){
				$image = $request->newImage;
				$fileName = time().'.'.$image->getClientOriginalName();
				$image->move('resources/assets/images/user_profile/', $fileName);
				$customers_picture = 'resources/assets/images/user_profile/'.$fileName; 
			}	else{
				$customers_picture = '';
			}			
			
			$customers_id = DB::table('customers')->insertGetId([
						'customers_gender'   		 	=>   $request->customers_gender,
						'customers_firstname'		 	=>   $request->customers_firstname,
						'customers_lastname'		 	=>   $request->customers_lastname,
						'customers_dob'	 			 	=>	 $request->customers_dob,
						'customers_gender'   		 	=>   $request->customers_gender,
						'customers_email_address'	 	=>   $request->customers_email_address,
						'customers_default_address_id' 	=>   $request->customers_default_address_id,
						'customers_telephone'	 		=>	 $request->customers_telephone,
						'customers_fax'   				=>   $request->customers_fax,
						'customers_password'		 	=>   $request->customers_password,
						'isActive'		 	 			=>   $request->isActive,
						'customers_picture'	 			=>	 $customers_picture,
						'created_at'					 =>	 time()
						]);
					
			//print_r($customerData['address']);
			return redirect('admin/addCustomerAddresses/'.$customers_id);		
		}
	}
	
	
	//addCustomers data and redirect to address
	public function addCustomerAddresses(Request $request){
		$title = array('pageTitle' => Lang::get("labels.AddAddress"));
				
		$language_id            				=   $request->language_id;
		$customers_id            				=   $request->id;		
		
		$customerData = array();
		$message = array();
		$errorMessage = array();
		
		$customer_addresses = DB::table('address_book')
			->leftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
			->leftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
			->where('customers_id', '=', $customers_id)->get();	
		
		$countries = DB::table('countries')->get();	
		
		$customerData['message'] = $message;
		$customerData['errorMessage'] = $errorMessage;
		$customerData['customer_addresses'] = $customer_addresses;	
		$customerData['countries'] = $countries;
		$customerData['customers_id'] = $customers_id;	
		
		return view("admin.addCustomerAddresses",$title)->with('data', $customerData);
	}
	
	//add Customer address
	public function addNewCustomerAddress(Request $request){
				
		$address_id = DB::table('address_book')->insertGetId([
						'customers_id'   		=>   $request->customers_id,
						'entry_gender'		 	=>   $request->entry_gender,
						'entry_company'		 	=>   $request->entry_company,
						'entry_firstname'	 	=>	 $request->entry_firstname,
						'entry_lastname'   		=>   $request->entry_lastname,
						'entry_street_address'	=>   $request->entry_street_address,
						'entry_suburb' 			=>   $request->entry_suburb,
						'entry_postcode'	 	=>	 $request->entry_postcode,
						'entry_city'   			=>   $request->entry_city,
						'entry_state'		 	=>   $request->entry_state,
						'entry_country_id'		=>   $request->entry_country_id,
						'entry_zone_id'	 		=>	 $request->entry_zone_id
						]);
						
		//set default address
		if($request->is_default=='1'){
				DB::table('customers')->where('customers_id','=', $request->customers_id)->update([
						'customers_default_address_id'		 	=>   $address_id
						]);
		}
		
		$customer_addresses = DB::table('address_book')
			->leftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
			->leftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
			->where('customers_id', '=', $request->customers_id)->get();
			return ($customer_addresses);
	}
	
	//edit Customers address
	public function editAddress(Request $request){
				
		$customers_id            =   $request->customers_id;	
		$address_book_id         =   $request->address_book_id;	
		
		$customer_addresses = DB::table('address_book')
			->leftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
			->leftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
			->where('address_book_id', '=', $address_book_id)->get();	
		
		$countries = DB::table('countries')->get();	
		$zones = DB::table('zones')->where('zone_country_id','=', $customer_addresses[0]->entry_country_id)->get();
		
		$customers = DB::table('customers')->where('customers_id','=', $customers_id)->get();	
		
		$customerData['customers_id'] = $customers_id;	
		$customerData['customer_addresses'] = $customer_addresses;	
		$customerData['countries'] = $countries;
		$customerData['zones'] = $zones;
		$customerData['customers'] = $customers;
			
		//print_r($customerData);
		return view("admin/editAddressForm")->with('data', $customerData);
	}
	
	//update Customers address
	public function updateAddress(Request $request){
				
		$customers_id            =   $request->customers_id;	
		$address_book_id         =   $request->address_book_id;	
		
		 DB::table('address_book')->where('address_book_id','=', $address_book_id)->update([
				'entry_gender'		 	=>   $request->entry_gender,
				'entry_company'		 	=>   $request->entry_company,
				'entry_firstname'	 	=>	 $request->entry_firstname,
				'entry_lastname'   		=>   $request->entry_lastname,
				'entry_street_address'	=>   $request->entry_street_address,
				'entry_suburb' 			=>   $request->entry_suburb,
				'entry_postcode'	 	=>	 $request->entry_postcode,
				'entry_city'   			=>   $request->entry_city,
				'entry_state'		 	=>   $request->entry_state,
				'entry_country_id'		=>   $request->entry_country_id,
				'entry_zone_id'	 		=>	 $request->entry_zone_id
				]);
						
		//set default address
		if($request->is_default=='1'){
				DB::table('customers')->where('customers_id','=', $customers_id)->update([
						'customers_default_address_id'		 	=>   $address_book_id
						]);
		}
		
		$customer_addresses = DB::table('address_book')
			->leftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
			->leftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
			->where('address_book_id', '=', $address_book_id)->get();	
		
		$countries = DB::table('countries')->get();	
		$zones = DB::table('zones')->where('zone_country_id','=', $customer_addresses[0]->entry_country_id)->get();	
		
		$customer_addresses = DB::table('address_book')
			->leftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
			->leftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
			->where('customers_id', '=', $request->customers_id)->get();
			
		return ($customer_addresses);
	}
	
	
	//delete Customers address
	public function deleteAddress(Request $request){
				
		$customers_id            =   $request->customers_id;	
		$address_book_id         =   $request->address_book_id;	
		
		DB::table('address_book')->where('address_book_id','=', $address_book_id)->delete();
		
		$customer_addresses = DB::table('address_book')
			->leftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
			->leftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
			->where('customers_id', '=', $request->customers_id)->get();
			
		//print_r($customer_addresses);
		return ($customer_addresses);
	}
	
	
	//editCustomers data and redirect to address
	public function editCustomers(Request $request){
		$title = array('pageTitle' => Lang::get("labels.EditCustomer"));
		//$language_id           =   $request->language_id;
		$language_id             =   '1';	
		$customers_id        	 =   $request->id;			
		
		$customerData = array();
		$message = array();
		$errorMessage = array();
		
		DB::table('customers')->where('customers_id', '=', $customers_id)->update(['is_seen' => 1 ]);
		
		$customers = DB::table('customers')->where('customers_id','=', $customers_id)->get();
		
		$customerData['message'] = $message;
		$customerData['errorMessage'] = $errorMessage;
		$customerData['customers'] = $customers;
		
		//print_r($customers);
		return view("admin.editCustomers",$title)->with('data', $customerData);
	}
	
	
	
	//add addCustomers data and redirect to address
	public function updateCustomers(Request $request){
				
		//$language_id            		=   $request->language_id;
		$language_id            		=   '1';			
		$customers_id					=	$request->customers_id;
		
		$customerData = array();
		$message = array();
		$errorMessage = array();
		
				
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/user_profile/', $fileName);
			$customers_picture = 'resources/assets/images/user_profile/'.$fileName; 
		}	else{
			$customers_picture = $request->oldImage;
		}		
		
		$customer_data = array(
			'customers_gender'   		 	=>   $request->customers_gender,
			'customers_firstname'		 	=>   $request->customers_firstname,
			'customers_lastname'		 	=>   $request->customers_lastname,
			'customers_dob'	 			 	=>	 $request->customers_dob,
			'customers_gender'   		 	=>   $request->customers_gender,
			'customers_email_address'	 	=>   $request->customers_email_address,
			'customers_default_address_id' 	=>   $request->customers_default_address_id,
			'customers_telephone'	 		=>	 $request->customers_telephone,
			'customers_fax'   				=>   $request->customers_fax,
			'customers_password'		 	=>   $request->customers_password,
			'isActive'		 	 			=>   $request->isActive,
			'customers_picture'	 			=>	 $customers_picture
		);
		
		
		//check email already exists
		if($request->old_email_address!=$request->customers_email_address){
			$existEmail = DB::table('customers')->where('customers_email_address', '=', $request->customers_email_address)->get();
			//print_r(count($existEmail));
			if(count($existEmail)>0){
				$title = array('pageTitle' => Lang::get("labels.EditCustomer"));
				
				$customerData['message'] = $message;
				$customerData['errorMessage'] = 'Email address already exist.';
				return view("admin.editCustomers",$title)->with('customers', $customerData);
			}else{
				DB::table('customers')->where('customers_id', '=', $customers_id)->update($customer_data);					 
				return redirect('admin/addCustomerAddresses/'.$customers_id);		
			}
		}else{
			DB::table('customers')->where('customers_id', '=', $customers_id)->update($customer_data);					 
			return redirect('admin/addCustomerAddresses/'.$customers_id);
		}
	}
	
	
	//deleteProduct
	public function deleteCustomers(Request $request){
		$customers_id = $request->customers_id;
		
		DB::table('customers')->where('customers_id','=', $customers_id)->delete();
		DB::table('address_book')->where('customers_id','=', $customers_id)->delete();
		
		return redirect()->back()->withErrors([Lang::get("labels.DeleteCustomerMessage")]);
	}
	
	
}
