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

//for Carbon a value 
use Carbon;

class ProductsController extends Controller
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
	
	//editProduct 
	public function editProduct($language_id, $products_id){
		//print_r($language_id);
		//print_r($products_id);
		$product = DB::table('products')
		->leftJoin('products_description','products_description.products_id','=','products.products_id')

		->select('products.*','products_description.*')
		->where('products_description.language_id','=', $language_id)
		->where('products.products_id','=', $products_id)
		->get();
		return($product);
	}
	
	
}
