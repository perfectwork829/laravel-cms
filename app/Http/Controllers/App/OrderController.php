<?php
/*
Project Name: IonicEcommerce
Project URI: http://ionicecommerce.com
Author: VectorCoder Team
Author URI: http://vectorcoder.com/
Version: 2.1
*/
namespace App\Http\Controllers\App;

//validator is builtin class in laravel
use Validator;

use Mail;
use DB;
//for password encryption or hash protected
use Hash;

//for authenitcate login data
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

//for requesting a value 
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

//for Carbon a value 
use Carbon;
use Log;
class OrderController extends Controller
{
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	 
	 
	//get coupons
	public function getCoupon(Request $request){
		
		$result = array();
		$coupons = DB::table('coupons')->where('code', '=', $request->code)->get();
				
		if(count($coupons)>0){
			
			if(!empty($coupons[0]->product_ids)){
				$product_ids = explode(',', $coupons[0]->product_ids);	
				$coupons[0]->product_ids =  $product_ids;
			}
			else{
				$coupons[0]->product_ids = array();
			}
			
			if(!empty($coupons[0]->exclude_product_ids)){
				$exclude_product_ids = explode(',', $coupons[0]->exclude_product_ids);	
				$coupons[0]->exclude_product_ids =  $exclude_product_ids;
			}else{
				$coupons[0]->exclude_product_ids =  array();
			}
			
			if(!empty($coupons[0]->product_categories)){
				$product_categories = explode(',', $coupons[0]->product_categories);	
				$coupons[0]->product_categories =  $product_categories;
			}else{
				$coupons[0]->product_categories =  array();
			}
			
			if(!empty($coupons[0]->excluded_product_categories)){
				$excluded_product_categories = explode(',', $coupons[0]->excluded_product_categories);	
				$coupons[0]->excluded_product_categories =  $excluded_product_categories;
			}else{
				$coupons[0]->excluded_product_categories = array();	
			}
			
			if(!empty($coupons[0]->email_restrictions)){
				$email_restrictions = explode(',', $coupons[0]->email_restrictions);	
				$coupons[0]->email_restrictions =  $email_restrictions;
			}else{
				$coupons[0]->email_restrictions =  array();
			}
			
			if(!empty($coupons[0]->used_by)){
				$used_by = explode(',', $coupons[0]->used_by);	
				$coupons[0]->used_by =  $used_by;
			}else{
				$coupons[0]->used_by =  array();
			}
			
			$responseData = array('success'=>'1', 'data'=>$coupons, 'message'=>"Coupon info is returned.");
		}else{
			$responseData = array('success'=>'0', 'data'=>$coupons, 'message'=>"Coupon doesn't exist.");
		}
		
		$orderResponse = json_encode($responseData);
		print $orderResponse;
	}
		 
	//generate token 
	public function generateBraintreeToken(){
		
		$payments_setting = DB::table('payments_setting')->get();
		
		//braintree transaction get nonce
		$is_transaction  = '0'; 			# For payment through braintree
		
		//if($shipping_method[0]->brantree_active == '1'){
			if($payments_setting[0]->braintree_enviroment == '0'){
				$braintree_environment = 'sandbox';	
			}else{
				$environment = 'production';	
			}
			
			$braintree_merchant_id = $payments_setting[0]->braintree_merchant_id;
			$braintree_public_key  = $payments_setting[0]->braintree_public_key;
			$braintree_private_key = $payments_setting[0]->braintree_private_key;
		//}
		
		//for token please check braintree.php file
		require_once app_path('braintree/Braintree.php');
		
		$responseData = array('success'=>'1', 'token'=>$clientToken, 'message'=>"Token generated.");
		$orderResponse = json_encode($responseData);
		print $orderResponse;
	}
	
	//get default payment method
	public function getPaymentMethods(){
		$result = array();
		$payments_setting = DB::table('payments_setting')->get();
		
		if($payments_setting[0]->braintree_enviroment=='0'){
			$braintree_enviroment = 'Test';
		}else{
			$braintree_enviroment = 'Live';
		}
		
		$braintree = array(
			'environment' => $braintree_enviroment, 
			'name' => $payments_setting[0]->braintree_name, 
			'public_key' => $payments_setting[0]->braintree_public_key,
			'active' => $payments_setting[0]->brantree_active,
			'payment_currency' => $payments_setting[0]->payment_currency
		);
		
		if($payments_setting[0]->stripe_enviroment=='0'){
			$stripe_enviroment = 'Test';
		}else{
			$stripe_enviroment = 'Live';
		}
		
		$stripe = array(
			'environment' => $stripe_enviroment,
			'name' => $payments_setting[0]->stripe_name, 
			'public_key' => $payments_setting[0]->publishable_key,
			'active' => $payments_setting[0]->stripe_active,
			'payment_currency' => $payments_setting[0]->payment_currency
		);
		
		$cod = array(
			'environment' => '', 
			'name' => $payments_setting[0]->cod_name, 
			'public_key' => '',
			'active' => $payments_setting[0]->cash_on_delivery,
			'payment_currency' => $payments_setting[0]->payment_currency
		);
		
		if($payments_setting[0]->paypal_enviroment=='0'){
			$paypal_enviroment = 'Test';
		}else{
			$paypal_enviroment = 'Live';
		}		
		
		$paypal = array(
			'environment' => $paypal_enviroment, 
			'name' => $payments_setting[0]->paypal_name, 
			'public_key' => $payments_setting[0]->paypal_id,
			'active' => $payments_setting[0]->paypal_status,
			'payment_currency' => $payments_setting[0]->payment_currency
		);
		
		$result[0] = $braintree;
		$result[1] = $stripe;
		$result[2] = $cod;
		$result[3] = $paypal;
		
		$responseData = array('success'=>'1', 'data'=>$result, 'message'=>"Payment methods are returned.");
		$orderResponse = json_encode($responseData);
		print $orderResponse;
	}
	
	//get shipping / tax Rate
	public function getRate(Request $request){
		
		$data = array();
		
		//tax rate
		$tax_zone_id   			=   $request->tax_zone_id;
		
		$index = '0';
		$total_tax = '0';
		$is_number = true;
		foreach($request->products as $products_data){
			$final_price = $request->products[$index]['final_price'];
			$products = DB::table('products')
				->LeftJoin('tax_rates', 'tax_rates.tax_class_id','=','products.products_tax_class_id')
				->where('tax_rates.tax_zone_id', $tax_zone_id)
				->where('products_id', $products_data['products_id'])->get();
			if(count($products)>0){
				$tax_value = $products[0]->tax_rate/100*$final_price;
				$total_tax = $total_tax+$tax_value;
				$index++;	
			}
		}
		
		if($total_tax>0){
			$data['tax'] = $total_tax;		
		}else{
			$data['tax'] = '0';
		}
		
		
		$countries = DB::table('countries')->where('countries_id','=',$request->country_id)->get();
		
		//website path
		$websiteURL =  "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$replaceURL = str_replace('getRate','', $websiteURL);
		$requiredURL = $replaceURL.'app/ups/ups.php';
		
		
		//default shipping method
		$shippings = DB::table('shipping_methods')->get();
		
		$result = array();
		foreach($shippings as $shipping_methods){
			//ups shipping rate
			if($shipping_methods->methods_type_link == 'upsShipping' and $shipping_methods->status == '1'){
				//print_r('sadsadsa');
				$result2= array();
				$is_transaction = '0';
				
				$ups_shipping = DB::table('ups_shipping')->where('ups_id', '=', '1')->get();
				
				//shipp from and all credentials
				$accessKey  = $ups_shipping[0]->access_key; 	
				$userId 	= $ups_shipping[0]->user_name;			
				$password 	= $ups_shipping[0]->password;
				
				//ship from address
				$fromAddress  = $ups_shipping[0]->address_line_1;
				$fromPostalCode  = $ups_shipping[0]->post_code;
				$fromCity  = $ups_shipping[0]->city;
				$fromState  = $ups_shipping[0]->state;
				$fromCountry  = $ups_shipping[0]->country; 
				
				//ship to address
				$toPostalCode = $request->postcode;
				$toCity = $request->city;	
				$toState = $request->state;	
				$toCountry = $countries[0]->countries_iso_code_2;	
				$toAddress = $request->street_address;	
				
				//product detail
				$products_weight = $request->products_weight;
				$products_weight_unit = $request->products_weight_unit;
				
				//change G or KG to LBS
				if($products_weight_unit=='g'){
					$productsWeight = $products_weight/453.59237;
				}else if($products_weight_unit=='kg'){
					$productsWeight = $products_weight/0.45359237;
				}
						
				//production or test mode
				if($ups_shipping[0]->shippingEnvironment == 1){ 			#production mode
					$useIntegration = true;				
				}else{
					$useIntegration = false;								#test mode
				}
				
				$serviceData = explode(',',$ups_shipping[0]->serviceType);
				
				
				$index = 0; 
				foreach($serviceData as $value){
					if($value == "US_01")
					{
						$name = 'Next Day Air';
						$serviceTtype = "1DA";
					}
					else if ($value == "US_02")
					{
						$name = '2nd Day Air';
						$serviceTtype = "2DA";
					}
						else if ($value == "US_03")
					{
						$name = 'Ground';
						$serviceTtype = "GND";
					}
					else if ($value == "US_12")
					{
						$name = '3 Day Select';
						$serviceTtype = "3DS";
					}
					else if ($value == "US_13")
					{
						$name = 'Next Day Air Saver';
						$serviceTtype = "1DP";
					}
					else if ($value == "US_14")
					{
						$name = 'Next Day Air Early A.M.';
						$serviceTtype = "1DM";
					}
					else if ($value == "US_59")
					{
						$name = '2nd Day Air A.M.';
						$serviceTtype = "2DM";
					}
					else if($value == "IN_07")
					{
						$name = 'Worldwide Express';
						$serviceTtype = "UPSWWE";
					}
					else if ($value == "IN_08")
					{
						$name = 'Worldwide Expedited';
						$serviceTtype = "UPSWWX";
					}
					else if ($value == "IN_11")
					{
						$name = 'Standard';
						$serviceTtype = "UPSSTD";
					}
					else if ($value == "IN_54")
					{
						$name = 'Worldwide Express Plus';
						$serviceTtype = "UPSWWEXPP";
					}
					
				$some_data = array(
					'access_key' => $accessKey,  						# UPS License Number
					'user_name' => $userId,								# UPS Username
					'password' => $password, 							# UPS Password
					'pickUpType' => '03',								# Drop Off Location
					'shipToPostalCode' => $toPostalCode, 				# Destination  Postal Code
					'shipToCountryCode' => $toCountry,					# Destination  Country
					'shipFromPostalCode' => $fromPostalCode, 			# Origin Postal Code
					'shipFromCountryCode' => $fromCountry,				# Origin Country
					'residentialIndicator' => 'IN', 					# Residence Shipping and for commercial shipping "COM"
					'cServiceCodes' => $serviceTtype, 					# Sipping rate for UPS Ground 
					'packagingType' => '02',
					'packageWeight' => $productsWeight
				  );  
				 
				  $curl = curl_init();
				  // You can also set the URL you want to communicate with by doing this:
				  // $curl = curl_init('http://localhost/echoservice');
				   
				  // We POST the data
				  curl_setopt($curl, CURLOPT_POST, 1);
				  // Set the url path we want to call
				  curl_setopt($curl, CURLOPT_URL, $requiredURL);  
				  // Make it so the data coming back is put into a string
				  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				  // Insert the data
				  curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
				   
				  // You can also bunch the above commands into an array if you choose using: curl_setopt_array
				   
				  // Send the request
				  $rate = curl_exec($curl);
				  // Free up the resources $curl is using
				  curl_close($curl);
				  
				 if (is_numeric($rate)){
					$success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>'UPS Shipping');
					$result2[$index] = array('name'=>$name,'rate'=>$rate,'currencyCode'=>'USD','shipping_method'=>'upsShipping');
					$index++;
				 }
				 else{
					$success = array('success'=>'0','message'=>"Selected regions are not supported for UPS shipping", 'name'=>'UPS Shipping');
					//$data2 = (object) array('name'=>'','rate'=>array(),'currencyCode'=>'USD','shipping_method'=>'upsShipping');
				 }
				 
				  $success['services'] = $result2;
				  $result['upsShipping'] = $success;
				  
				}
				
				
			}else if($shipping_methods->methods_type_link == 'flateRate' and $shipping_methods->status == '1'){
				
				$ups_shipping = DB::table('flate_rate')->where('id', '=', '1')->get();
				$data2 =  array('name'=>'Flate Rate','rate'=>$ups_shipping[0]->flate_rate,'currencyCode'=>$ups_shipping[0]->currency,'shipping_method'=>'flateRate');
				if(count($ups_shipping)>0){
					$success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>'Flate Rate');
					$success['services'][0] = $data2;
					$result['flateRate'] = $success;
				}
				
				
			}else if($shipping_methods->methods_type_link == 'localPickup' and $shipping_methods->status == '1') {
							
				$data2 =  array('name'=>'Local Pickup', 'rate'=>'0', 'currencyCode'=>'USD', 'shipping_method'=>'localPickup');
				$success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>'Local Pickup');
				$success['services'][0] = $data2;
				$result['localPickup'] = $success;
					
			}else if($shipping_methods->methods_type_link == 'freeShipping'  and $shipping_methods->status == '1'){
						
				$data2 =  array('name'=>'Free Shipping','rate'=>'0','currencyCode'=>'USD','shipping_method'=>'freeShipping');
				$success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>'Free Shipping');
				$success['services'][0] = $data2;
				$result['freeShipping'] = $success;
			}
		}
		$data['shippingMethods'] = $result;		
		
		$responseData = array('success'=>'1', 'data'=>$data, 'message'=>"Data is returned.");
		
		$orderResponse = json_encode($responseData);
		print $orderResponse;
	}
	
	
	//addToOrder
	public function addToOrder(Request $request){
		
		//Log::useDailyFiles(storage_path().'/logs/debug.log');
		//Log::info(['Request'=>$request->all()]);
		
		$date_added								=	date('Y-m-d h:i:s');
		
		$customers_id            				=   $request->customers_id;
		$customers_telephone            		=   $request->customers_telephone;
		$customers_email_address            	=   $request->customers_email_address;	
			
		$delivery_firstname  	          		=   $request->delivery_firstname;
		$delivery_lastname            			=   $request->delivery_lastname;
		$delivery_street_address            	=   $request->delivery_street_address;
		$delivery_suburb            			=   $request->delivery_suburb;
		$delivery_city            				=   $request->delivery_city;
		$delivery_postcode            			=   $request->delivery_postcode;
		
		$delivery = DB::table('zones')->where('zone_name', '=', $request->delivery_zone)->get();
		
		if(count($delivery)){
			$delivery_state            				=   $delivery[0]->zone_code;
		}else{
			$delivery_state            				=   'other';
		}
		   
		$delivery_country            			=   $request->delivery_country;
		
		$billing_firstname            			=   $request->billing_firstname;
		$billing_lastname            			=   $request->billing_lastname;
		$billing_street_address            		=   $request->billing_street_address;
		$billing_suburb	            			=   $request->billing_suburb;
		$billing_city            				=   $request->billing_city;
		$billing_postcode            			=   $request->billing_postcode;
		
		$billing = DB::table('zones')->where('zone_name', '=', $request->billing_zone)->get();
		
		if(count($billing)){
			$billing_state            				=   $billing[0]->zone_code;
		}else{
			$billing_state            				=   'other';
		}
		
		$billing_country            			=   $request->billing_country;
		
		$payment_method            				=   $request->payment_method;
		$order_information 						=	array();
		
		$cc_type            				=   $request->cc_type;
		$cc_owner            				=   $request->cc_owner;
		$cc_number            				=   $request->cc_number;
		$cc_expires            				=   $request->cc_expires;
		$last_modified            			=   date('Y-m-d H:i:s');
		$date_purchased            			=   date('Y-m-d H:i:s');
		$order_price						=   $request->totalPrice;
		$shipping_cost            			=   $request->shipping_cost;
		$shipping_method            		=   $request->shipping_method;
		$orders_status            			=   '1';
		$orders_date_finished            	=   $request->orders_date_finished;
		$comments            				=   $request->comments;
		//$currency            				=   $request->currency;
		$currency            				=   'usd';
		$currency_value            			=   $request->currency_value;
		//$products_tax						=	$request->products_tax;
		
		//tax info
		$total_tax							=	$request->total_tax;
		
		$products_tax 						= 	1;
		//coupon info
		$is_coupon_applied            		=   $request->is_coupon_applied;
		
		if($is_coupon_applied==1){
			
			$code = array();	
			$coupon_amount = 0;	
			$exclude_product_ids = array();
			$product_categories = array();
			$excluded_product_categories = array();
			$exclude_product_ids = array();
			
			$coupon_amount    =		$request->coupon_amount;
			
			foreach($request->coupons as $coupons_data){
				
				//update coupans		
				$coupon_id = DB::statement("UPDATE `coupons` SET `used_by`= CONCAT(used_by,',$customers_id') WHERE `code` = '".$coupons_data['code']."'");
				
				//dd(DB::getQueryLog());
				
				//Log::useDailyFiles(storage_path().'/logs/debug.log');
		 		//Log::info(['coupon_query'=>DB::getQueryLog()]);
			
			}
			$code = json_encode($request->coupons);
			
		}else{
			$code            					=   '';
			$coupon_amount            			=   '';
		}	
		
		
		//payment methods 
		$payments_setting = DB::table('payments_setting')->get();
		
		if($payment_method == 'paypal' or $payment_method == 'card_payment'){
			
			//braintree transaction with nonce
			$is_transaction  = '1'; 			# For payment through braintree
			$nonce    		 =   $request->nonce;
			
			if($payments_setting[0]->braintree_enviroment == '0'){
				$braintree_environment = 'sandbox';	
			}else{
				$braintree_environment = 'production';	
			}
			
			$braintree_merchant_id = $payments_setting[0]->braintree_merchant_id;
			$braintree_public_key  = $payments_setting[0]->braintree_public_key;
			$braintree_private_key = $payments_setting[0]->braintree_private_key;
			
			//brain tree credential
			require_once app_path('braintree/Braintree.php');
			//print_r($result);
			if ($result->success) 
			{
			//print_r("success!: " . $result->transaction->id);
			if($result->transaction->id)
				{
					$order_information = array(
						'braintree_id'=>$result->transaction->id,
						'status'=>$result->transaction->status,
						'type'=>$result->transaction->type,
						'currencyIsoCode'=>$result->transaction->currencyIsoCode,
						'amount'=>$result->transaction->amount,
						'merchantAccountId'=>$result->transaction->merchantAccountId,
						'subMerchantAccountId'=>$result->transaction->subMerchantAccountId,
						'masterMerchantAccountId'=>$result->transaction->masterMerchantAccountId,
						//'orderId'=>$result->transaction->orderId,
						'createdAt'=>time(),
//						'updatedAt'=>$result->transaction->updatedAt->date,
						'token'=>$result->transaction->creditCard['token'],
						'bin'=>$result->transaction->creditCard['bin'],
						'last4'=>$result->transaction->creditCard['last4'],
						'cardType'=>$result->transaction->creditCard['cardType'],
						'expirationMonth'=>$result->transaction->creditCard['expirationMonth'],
						'expirationYear'=>$result->transaction->creditCard['expirationYear'],
						'customerLocation'=>$result->transaction->creditCard['customerLocation'],
						'cardholderName'=>$result->transaction->creditCard['cardholderName']
					);
					//print_r($order_information);
					$payment_status = "success";
					//print_r($result->transaction->status);
				}
			} 
			else
				{
					$payment_status = "failed";
				}
				
		}else if($payment_method == 'stripe'){				#### stipe payment
			//require file
			require_once app_path('stripe/config.php');
			
			//get token from app
			$token  = $request->nonce;
			
			$customer = \Stripe\Customer::create(array(
			  'email' => $customers_email_address,
			  'source'  => $token
			));
			
			$charge = \Stripe\Charge::create(array(
			  'customer' => $customer->id,
			  'amount'   => 100*$order_price,
			  'currency' => 'usd'
			));
			
			 if($charge->paid == true){
				 $order_information = array(
						'paid'=>'true',
						'transaction_id'=>$charge->id,
						'type'=>$charge->outcome->type,
						'balance_transaction'=>$charge->balance_transaction,
						'status'=>$charge->status,
						'currency'=>$charge->currency,
						'amount'=>$charge->amount,
						'created'=>date('d M,Y', $charge->created),
						'dispute'=>$charge->dispute,
						'customer'=>$charge->customer,
						'address_zip'=>$charge->source->address_zip,
						'seller_message'=>$charge->outcome->seller_message,
						'network_status'=>$charge->outcome->network_status,
						'expirationMonth'=>$charge->outcome->type
					);
					//print_r($order_information);
					$payment_status = "success";
					
			 }else{
					$payment_status = "failed";	 
			 }
			
		}else if($payment_method == 'cash_on_delivery'){
			
			$payment_method = 'Cash on Delivery';
			$payment_status='success';
			
		} else if($payment_method == 'simplePaypal'){
			
			$payment_method = 'PayPal Express Checkout';
			$payment_status='success';
			$order_information = $request->nonce;
				
		} 
		
		// print $payment_status;
		//check if order is verified
		if($payment_status=='success'){
			//DB::enableQueryLog();
			//update database
			$orders_id = DB::table('orders')->insertGetId(
				[	 'customers_id' => $customers_id,
					 'customers_name'  => $delivery_firstname.' '.$delivery_lastname,
					 'customers_street_address' => $delivery_street_address,
					 'customers_suburb'  =>  $delivery_suburb,
					 'customers_city' => $delivery_city,
					 'customers_postcode'  => $delivery_postcode,
					 'customers_state' => $delivery_state,
					 'customers_country'  =>  $delivery_country,
					 'customers_telephone' => $customers_telephone,
					 'customers_email_address'  => $customers_email_address,
					// 'customers_address_format_id' => $delivery_address_format_id,
					 
					 'delivery_name'  =>  $delivery_firstname.' '.$delivery_lastname,
					 'delivery_street_address' => $delivery_street_address,
					 'delivery_suburb'  => $delivery_suburb,
					 'delivery_city' => $delivery_city,
					 'delivery_postcode'  =>  $delivery_postcode,
					 'delivery_state' => $delivery_state,
					 'delivery_country'  => $delivery_country,
					// 'delivery_address_format_id' => $delivery_address_format_id,
					 
					 'billing_name'  => $billing_firstname.' '.$billing_lastname,
					 'billing_street_address' => $billing_street_address,
					 'billing_suburb'  =>  $billing_suburb,
					 'billing_city' => $billing_city,
					 'billing_postcode'  => $billing_postcode,
					 'billing_state' => $billing_state,
					 'billing_country'  =>  $billing_country,
					 //'billing_address_format_id' => $billing_address_format_id,
					 
					 'payment_method'  =>  $payment_method,
					 'cc_type' => $cc_type,
					 'cc_owner'  => $cc_owner,
					 'cc_number' =>$cc_number,
					 'cc_expires'  =>  $cc_expires,
					 'last_modified' => $last_modified,
					 'date_purchased'  => $date_purchased,
					 'order_price'  => $order_price,
					 'shipping_cost' =>$shipping_cost,
					 'shipping_method'  =>  $shipping_method,
					// 'orders_status' => $orders_status,
					 //'orders_date_finished'  => $orders_date_finished,
					 'currency'  =>  $currency,
					 'currency_value' => $last_modified,
					 'order_information' => json_encode($order_information),
					 'coupon_code'		 =>		$code,
					 'coupon_amount' 	 =>		$coupon_amount,
				 	 'total_tax'		 =>		$total_tax,
				]);
			
			 //orders status history
			 $orders_history_id = DB::table('orders_status_history')->insertGetId(
				[	 'orders_id'  => $orders_id,
					 'orders_status_id' => $orders_status,
					 'date_added'  => $date_added,
					 'customer_notified' =>'1',
					 'comments'  =>  $comments
				]);
				
				//dd(DB::getQueryLog());
				
				/*$query = DB::getQueryLog();
				print_r($query);*/
				
			 foreach($request->products as $products){	
				
				$orders_products_id = DB::table('orders_products')->insertGetId(
				[		 		
					 'orders_id' 		 => 	$orders_id,
					 'products_id' 	 	 =>		$products['products_id'],
					 'products_name'	 => 	$products['products_name'],
					 'products_price'	 =>  	$products['price'],
					 'final_price' 		 =>  	$products['final_price']*$products['customers_basket_quantity'],
					 'products_tax' 	 =>  	$products_tax,
					 'products_quantity' =>  	$products['customers_basket_quantity'],
				]);
				 
				
				if(!empty($products['attributes'])){
					foreach($products['attributes'] as $attribute){
						DB::table('orders_products_attributes')->insert(
						[
							 'orders_id' => $orders_id,
							 'products_id'  => $products['products_id'],
							 'orders_products_id'  => $orders_products_id,
							 'products_options' =>$attribute['products_options'],
							 'products_options_values'  =>  $attribute['products_options_values'],
							 'options_values_price'  =>  $attribute['options_values_price'],
							 'price_prefix'  =>  $attribute['price_prefix']
						]);
						
						
					}
				}
							
			 }
			
			//Log::useDailyFiles(storage_path().'/logs/debug.log');
		 	//Log::info(['orders'=>DB::getQueryLog()]);
			$responseData = array('success'=>'1', 'data'=>array(), 'message'=>"Order has been placed successfully.");
			
			//send order email to user
			
			$order = DB::table('orders')
				->LeftJoin('orders_status_history', 'orders_status_history.orders_id', '=', 'orders.orders_id')
				->LeftJoin('orders_status', 'orders_status.orders_status_id', '=' ,'orders_status_history.orders_status_id')
				->where('orders.orders_id', '=', $orders_id)->orderby('orders_status_history.date_added', 'DESC')->get();
			
		//foreach
		foreach($order as $data){
			$orders_id	 = $data->orders_id;
			
			$orders_products = DB::table('orders_products')
				->join('products', 'products.products_id','=', 'orders_products.products_id')
				->select('orders_products.*', 'products.products_image as image')
				->where('orders_products.orders_id', '=', $orders_id)->get();
				$i = 0;
				$total_price  = 0;
				$product = array();
				$subtotal = 0;
				foreach($orders_products as $orders_products_data){
					$product_attribute = DB::table('orders_products_attributes')
						->where([
							['orders_products_id', '=', $orders_products_data->orders_products_id],
							['orders_id', '=', $orders_products_data->orders_id],
						])
						->get();
						
					$orders_products_data->attribute = $product_attribute;
					$product[$i] = $orders_products_data;
					//$total_tax	 = $total_tax+$orders_products_data->products_tax;
					$total_price = $total_price+$orders_products[$i]->final_price;
					
					$subtotal += $orders_products[$i]->final_price;
					
					$i++;
					//$orders_products_data[] = $orders_products_data;
				}
			//print_r($product);
			$data->data = $product;
			$orders_data[] = $data;
		}
		
			$orders_status_history = DB::table('orders_status_history')
				->LeftJoin('orders_status', 'orders_status.orders_status_id', '=' ,'orders_status_history.orders_status_id')
				->orderBy('orders_status_history.date_added', 'desc')
				->where('orders_id', '=', $orders_id)->get();
					
			$orders_status = DB::table('orders_status')->get();
					
			$ordersData['orders_data']		 	 	=	$orders_data;
			$ordersData['total_price']  			=	$total_price;
			$ordersData['orders_status']			=	$orders_status;
			$ordersData['orders_status_history']    =	$orders_status_history;
			$ordersData['subtotal']    				=	$subtotal;
			
			Mail::send('/mail/orderEmail', ['ordersData' => $ordersData], function($m) use ($ordersData){
				$m->to($ordersData['orders_data'][0]->customers_email_address)->subject('Ecommerce App: Your order has been placed"')->getSwiftMessage()
				->getHeaders()
				->addTextHeader('x-mailgun-native-send', 'true');	
			});
			
		}else if($payment_status == "failed"){
			$responseData = array('success'=>'0', 'data'=>array(), 'message'=>"Error while placing order.");	
		}
		
		$orderResponse = json_encode($responseData);
		print $orderResponse;
	}
	
	
	//getOrders
	public function getOrders(Request $request){
		$customers_id            				=   $request->customers_id;
		$language_id             				=   $request->language_id;		
		//$customers_id            				=   '47';		
		
		$order = DB::table('orders')->orderBy('customers_id', 'desc')
				->where([
					['customers_id', '=', $customers_id],
					//['orders_status', '=', '1'],
				])->get();
		//print_r($order);
		if(count($order) > 0){		
			//foreach
			$index = '0';
			foreach($order as $data){
				
				if(!empty($data->coupon_code)){
					//$product_ids = explode(',', $coupons[0]->product_ids);	
					$coupon_code =  $data->coupon_code;
					$order[$index]->coupons = json_decode($coupon_code);
				}
				else{
					$coupon_code =  array();
					$order[$index]->coupons = $coupon_code;
				}
				
				unset($data->coupon_code);
				
				$orders_id	 = $data->orders_id;
				
				$orders_status_history = DB::table('orders_status_history')
						->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
						->select('orders_status.orders_status_name', 'orders_status.orders_status_id', 'orders_status_history.comments')
						->where('orders_id', '=', $orders_id)->orderby('orders_status_history.orders_status_history_id', 'ASC')->get();
						
				//print_r($orders_status_history);
				$order[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
				$order[$index]->orders_status = $orders_status_history[0]->orders_status_name;
				$order[$index]->customer_comments = $orders_status_history[0]->comments;
				
				$total_comments = count($orders_status_history);
				$i = 1;
				
				foreach($orders_status_history as $orders_status_history_data){
					
					/*if($total_comments == $i and !empty($orders_status_history_data->comments)){
						$order[$index]->orders_status_id = $orders_status_history_data->orders_status_id;
						$order[$index]->orders_status = $orders_status_history_data->orders_status_name;
						$order[$index]->customer_comments = $orders_status_history_data->comments;
					}else
					*/
					if($total_comments == $i && $i != 1){
						$order[$index]->orders_status_id = $orders_status_history_data->orders_status_id;
						$order[$index]->orders_status = $orders_status_history_data->orders_status_name;
						$order[$index]->admin_comments = $orders_status_history_data->comments;
					}else{
						$order[$index]->admin_comments = '';
					}
					
					$i++;
				}
								
				$orders_products = DB::table('orders_products')
				->join('products', 'products.products_id','=', 'orders_products.products_id')
				->LeftJoin('products_to_categories','products_to_categories.products_id','=','products.products_id')
				->LeftJoin('categories_description','categories_description.categories_id','=','products_to_categories.categories_id')
				->select('orders_products.*', 'products.products_image as image', 'categories_description.*')
				->where('orders_products.orders_id', '=', $orders_id)->where('categories_description.language_id','=', $language_id)->get();
				$k = 0;
				$product = array();
				foreach($orders_products as $orders_products_data){
					
					$product_attribute = DB::table('orders_products_attributes')
						->where([
							['orders_products_id', '=', $orders_products_data->orders_products_id],
							['orders_id', '=', $orders_products_data->orders_id],
						])
						->get();
						
					$orders_products_data->attributes = $product_attribute;
					$product[$k] = $orders_products_data;
					$k++;
				}
				$data->data = $product;
				$orders_data[] = $data;
			$index++;
			}
				//print_r($product);
				$responseData = array('success'=>'1', 'data'=>$orders_data, 'message'=>"Returned all orders.");
		}else{
				$orders_data = array();
				$responseData = array('success'=>'0', 'data'=>$orders_data, 'message'=>"Order is not placed yet.");
		}
		
		$orderResponse = json_encode($responseData);
		print $orderResponse;
	}
			
}