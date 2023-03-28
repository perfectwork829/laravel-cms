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

class CartController extends Controller
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
	
	//addToCart
	public function addToCart(Request $request){
		
		$customers_id            				=   $request->customers_id;
		$products_id            				=   $request->products_id;
		$customers_basket_quantity            	=   $request->customers_basket_quantity;
		$final_price            				=   $request->final_price;
		$customers_basket_date_added            =   date('Y-m-d H:i:s');
		
		DB::table('customers_basket')->insert(
		[
			 'customers_id' => $customers_id,
			 'products_id'  => $products_id,
			 'customers_basket_quantity' => $customers_basket_quantity,
			 'final_price' => $final_price,
			 'customers_basket_date_added' => $customers_basket_date_added,
		]);
		
		if(!empty($request->attribute)){
			foreach($request->attribute as $attribute){
				//print_r($attribute['products_options_id']);	
				DB::table('customers_basket_attributes')->insert(
				[
					 'customers_id' => $customers_id,
					 'products_id'  => $products_id,
					 'products_options_id' =>$attribute['products_options_id'],
					 'products_options_values_id'  =>  $attribute['products_options_values_id']
				]);
			}
		}
		
		$responseData = array('success'=>'1', 'data'=>array(), 'message'=>"Cart item added.");
		$cartResponse = json_encode($responseData);
		print $cartResponse;
	}
	
	
	//getCart
	public function getCart(Request $request){
		
		$customers_id            				=   $request->customers_id;		
		//$customers_id            				=   '29';
		
		$customers_basket = DB::table('customers_basket')
		->join('products', 'products.products_id','=', 'customers_basket.products_id')
		->join('products_description', 'products_description.products_id','=', 'products.products_id')
		->select('customers_basket.*', 'products.products_model as model', 'products.products_image as image', 'products_description.products_name as products_name', 'products.products_quantity as quantity', 'products.products_price as price', 'products.products_weight as weight', 'products.products_weight as weight', 'products.products_weight as weight' )
		->where([
			['customers_basket.customers_id', '=', $customers_id],
			['customers_basket.is_order', '=', '0'],
		])->get();
		$total_carts = count($customers_basket); 
		if($total_carts > 0){
			foreach($customers_basket as $customers_basket_data){
				
				$customers_basket_attribute = DB::table('customers_basket_attributes')
					->join('products_options', 'products_options.products_options_id','=','customers_basket_attributes.products_options_id')
					->join('products_options_values', 'products_options_values.products_options_values_id','=','customers_basket_attributes.products_options_values_id')
					->select('products_options.products_options_name as attribute_name','products_options_values.products_options_values_name as attribute_value')
					->where([
						['customers_basket_attributes.customers_id', '=', $customers_basket_data->customers_id],
						['customers_basket_attributes.products_id',  '=', $customers_basket_data->products_id],
					])
					->get();
						
				$customers_basket_data->attributes = $customers_basket_attribute;
				$cart_data[] = $customers_basket_data;
			}
			$responseData = array('success'=>'1', 'data'=>$cart_data, 'message'=>"Returned all carts.");
		}else{
			$responseData = array('success'=>'0', 'data'=>array(), 'message'=>"Cart is empty.");
		}		
		
		$cartResponse = json_encode($responseData);
		print $cartResponse;
	}
	
	//updateCart
	public function updateCart(Request $request){
		
		$customers_id            				=   $request->customers_id;
		$products_id            				=   $request->products_id;
		
		$customers_basket_quantity            	=   $request->customers_basket_quantity;
		$final_price            				=   $request->final_price;
		$customers_basket_date_added            =   date('Y-m-d H:i:s');
		
		DB::table('customers_basket')
		->where(
			['customers_id','=', $customers_id],
			['products_id','=', $products_id]
		)->update([
			 'customers_basket_quantity' => $customers_basket_quantity,
			 'final_price' => $final_price,
			 'customers_basket_date_added' => $customers_basket_date_added,
		]);
				
		foreach($request->attribute as $attribute){
			//print_r($attribute['products_options_id']);	
			DB::table('customers_basket_attributes')->insert(
			[
				 'customers_id' => $customers_id,
				 'products_id'  => $products_id,
				 'products_options_id' =>$attribute['products_options_id'],
				 'products_options_values_id'  =>  $attribute['products_options_values_id']
			]);
		}
		
		$cartResponse = json_encode($responseData);
		print $cartResponse;
	}
	
	
	//deleteFromCart
	public function deleteFromCart(Request $request){
		
		$customers_id            				=   $request->customers_id;		
		$products_id            				=   $request->products_id;
		//$customers_id            				=   '28';		
		//$products_id            				=   '1';
		
		DB::table('customers_basket')->where([
			['customers_id', '=', $customers_id],
			['products_id',  '=', $products_id],
		])->delete();
		
		DB::table('customers_basket_attributes')->where([
			['customers_id', '=', $customers_id],
			['products_id',  '=', $products_id],
		])->delete();
				
		$responseData = array('success'=>'1', 'data'=>array(), 'message'=>"Record is deleted.");
		$cartResponse = json_encode($responseData);
		print $cartResponse;
	}
	
}