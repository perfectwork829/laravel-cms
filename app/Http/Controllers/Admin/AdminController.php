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

//for requesting a value 
use Illuminate\Http\Request;


class AdminController extends Controller
{
	public function dashboard(Request $request){
		$title 			  = 	array('pageTitle' => Lang::get("labels.title_dashboard"));
		$language_id      = 	'1';
		$result 		  =		array();
		
		$reportBase		  = 	$request->reportBase;
		
		//recently order placed
		$orders = DB::table('orders')
			->LeftJoin('currencies', 'currencies.code', '=', 'orders.currency')
			->orderBy('date_purchased','DESC')
			->get();
		
		//print_r($orders);
		
		$index = 0;
		$total_price = array();
		foreach($orders as $orders_data){
			$orders_products = DB::table('orders_products')
				->select('final_price', DB::raw('SUM(final_price) as total_price'))
				->where('orders_id', '=' ,$orders_data->orders_id)
				->groupBy('final_price')
				->get();
				
			$orders[$index]->total_price = $orders_products[0]->total_price;
			
			$orders_status_history = DB::table('orders_status_history')
				->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
				->select('orders_status.orders_status_name', 'orders_status.orders_status_id')
				->where('orders_id', '=', $orders_data->orders_id)->orderby('orders_status_history.date_added', 'DESC')->limit(1)->get();
				
			$orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
			$orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
			
			$index++;				
		}
		
		$compeleted_orders = 0;
		$pending_orders = 0;
		foreach($orders as $orders_data){
			
			if($orders_data->orders_status_id=='2')
			{
				$compeleted_orders++;
			}
			if($orders_data->orders_status_id=='1')
			{
				$pending_orders++;
			}
		}
		//print_r($orders);
		//$result['orders'] = array_slice($orders, '0', '10');
		$result['orders'] = $orders->chunk(10);
		$result['pending_orders'] = $pending_orders;
		$result['compeleted_orders'] = $compeleted_orders;
		$result['total_orders'] = count($orders);
		
		$result['inprocess'] = count($orders)-$pending_orders-$compeleted_orders;
		//add to cart orders
		$cart = DB::table('customers_basket')->get();
		
		$result['cart'] = count($cart);
		
		//Rencently added products
		$recentProducts = DB::table('products')
			->leftJoin('products_description','products_description.products_id','=','products.products_id')
			->where('products_description.language_id','=', $language_id)
			->orderBy('products.products_id', 'DESC')
			->paginate(8);
			
		$result['recentProducts'] = $recentProducts;
		
		//products
		$products = DB::table('products')
			->leftJoin('products_description','products_description.products_id','=','products.products_id')
			->where('products_description.language_id','=', $language_id)
			->orderBy('products.products_id', 'DESC')
			->get();
			
		//low products & out of stock
		$lowLimit = 0;
		$outOfStock = 0;
		foreach($products as $products_data){
			if($products_data->low_limit >= 1 && $products_data->products_quantity >= $products_data->low_limit){
				$lowLimit++;
			}elseif($products_data->products_quantity == 0){
				$outOfStock++;
			}
		}
		
		$result['lowLimit'] = $lowLimit;
		$result['outOfStock'] = $outOfStock;	
		$result['totalProducts'] = count($products);
		
		$customers = DB::table('customers')
			->LeftJoin('customers_info','customers_info.customers_info_id','=', 'customers.customers_id')
			->orderBy('customers_info.customers_info_date_account_created','DESC')
			->get();
			
		//$result['recentCustomers'] = array_slice($customers, '0', '21');
		$result['recentCustomers'] = $customers->chunk(21);
		//print_r($result['recentCustomers']);
		//print '<br><br><br>';
//		foreach ($result['recentCustomers']  as $recentCustomers){
//			print_r($recentCustomers[0]->customers_id);	
//		}
		$result['totalCustomers'] = count($customers);
		$result['reportBase'] = $reportBase;	
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$currency = $myVar->getSetting();
		$result['currency'] = $currency;
		
		return view("admin.dashboard",$title)->with('result', $result);
	}
	
	
	public function login(){
		if (Auth::check()) {
		  // The user is logged in...
		  return redirect('/admin/dashboard/this_month');
		}else{
			$title = array('pageTitle' => Lang::get("labels.login_page_name"));
			return view("admin.login",$title);
		}
	}
	
	public function admininfo(){
		$administor = administrators::all();		
		return view("admin.login",$title);
	}
	
	//login function
	public function checkLogin(Request $request){
		$validator = Validator::make(
			array(
					'email'    => $request->email,
					'password' => $request->password
				), 
			array(
					'email'    => 'required | email',
					'password' => 'required',
				)
		);
		//check validation
		if($validator->fails()){
			return redirect('admin/login')->withErrors($validator)->withInput();
		}else{
			//check authentication of email and password
			$adminInfo = array("email" => $request->email, "password" => $request->password);
			if(Auth::attempt($adminInfo)) {
				$admin = Auth::User();
				$administrators = DB::table('administrators')->where('myid', $admin->myid)->get();	
				return redirect()->intended('admin/dashboard/this_month')->with('administrators', $administrators);
			}else{
				return redirect('admin/login')->with('loginError',Lang::get("labels.EmailPasswordIncorrectText"));
			}
		}
		
	}
	
	
	//logout
	public function logout(){
		Auth::logout();	
		return redirect()->intended('admin/login');
	}
	
	//admin profile
	public function adminProfile(Request $request){
		$title = array('pageTitle' => Lang::get("labels.Profile"));		
		
		$result = array();
		
		$countries = DB::table('countries')->get();
		$zones = DB::table('zones')->where('zone_country_id', '=', Auth::user()->country)->get();
		
		$result['countries'] = $countries;
		$result['zones'] = $zones;
		
		return view("admin.adminProfile",$title)->with('result', $result);
	}
	
	//updateProfile
	public function updateProfile(Request $request){
		
		$updated_at	= date('y-m-d h:i:s');
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/views/admin/images/admin_profile/', $fileName);
			$uploadImage = 'resources/views/admin/images/admin_profile/'.$fileName; 
		}	else{
			$uploadImage = $request->oldImage;
		}	
		
		$orders_status = DB::table('administrators')->where('myid','=', Auth::user()->myid)->update([
				'user_name'		=>	$request->user_name,
				'first_name'	=>	$request->first_name,
				'last_name'		=>	$request->last_name,
				'address'		=>	$request->address,
				'city'			=>	$request->city,
				'state'			=>	$request->state,
				'zip'			=>	$request->zip,
				'country'		=>	$request->country,
				'phone'			=>	$request->phone,
				'image'			=>	$uploadImage,
				'updated_at'	=>	$updated_at
				]);
		
		$message = Lang::get("labels.ProfileUpdateMessage");
		return redirect()->back()->withErrors([$message]);
	}
	
	//updateProfile
	public function updateAdminPassword(Request $request){
		
		$orders_status = DB::table('administrators')->where('myid','=', Auth::user()->myid)->update([
				'password'		=>	Hash::make($request->password)
				]);
		
		$message = Lang::get("labels.PasswordUpdateMessage");
		return redirect()->back()->withErrors([$message]);
	}

}
