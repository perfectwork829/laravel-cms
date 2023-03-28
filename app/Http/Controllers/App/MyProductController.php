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

class MyProductController extends Controller
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
	
	//get allCategories
	public function allCategories(Request $request){
		$language_id            				=   $request->language_id;			
		$result 	= 	array();
		$data 		=	array();
		
		
		$categories = DB::table('categories')
			->LeftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
			->select('categories.categories_id as id',
				 'categories.categories_image as image',
				 'categories.categories_icon as icon',
				 'categories.sort_order as order',
				 'categories.parent_id',
				 'categories_description.categories_name as name'
				 )
			->where('categories_description.language_id','=', $language_id)
			->get();
		
		$index = 0;
		foreach($categories as $categories_data){
			$categories_id = $categories_data->id;
			
			if($categories_data->parent_id==0){
				$products = DB::table('categories')
					->LeftJoin('categories as sub_categories', 'sub_categories.parent_id', '=', 'categories.categories_id')
					->LeftJoin('products_to_categories', 'products_to_categories.categories_id', '=', 'sub_categories.categories_id')
					->LeftJoin('products', 'products.products_id', '=', 'products_to_categories.products_id')
					->select('categories.categories_id', DB::raw('COUNT(DISTINCT products.products_id) as total_products'))
					->where('categories.categories_id','=', $categories_id)
					->get();
			}else{
				$products = DB::table('products_to_categories')
					->LeftJoin('products', 'products.products_id', '=', 'products_to_categories.products_id')
					->select('products_to_categories.categories_id', DB::raw('COUNT(DISTINCT products.products_id) as total_products'))
					->where('products_to_categories.categories_id','=', $categories_id)
					->get();
			}
		
			$categories_data->total_products = $products[0]->total_products;
			array_push($result,$categories_data);
			
		}
		
		if(count($categories)>0){
			$responseData = array('success'=>'1', 'data'=>$result, 'message'=>"Returned all categories.", 'categories'=>count($categories));
		}
		else{
			$responseData = array('success'=>'0', 'data'=>array(), 'message'=>"No category found.", 'categories'=>array());
		}
		
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
	}

	
	//getAllProducts 
	public function getAllProducts(Request $request){
		$language_id            				=   $request->language_id;	
		$skip									=   $request->page_number.'0';
		$currentDate 							=   time();	
		$type									=	$request->type;
		
		//filter
		$minPrice	 							=   $request->price['minPrice'];
		$maxPrice	 							=   $request->price['maxPrice'];
				
		
		if($type=="a to z"){
			$sortby								=	"products_name";
			$order								=	"ASC";
		}elseif($type=="z to a"){
			$sortby								=	"products_name";
			$order								=	"DESC";
		}elseif($type=="high to low"){
			$sortby								=	"products_price";
			$order								=	"DESC";
		}elseif($type=="low to high"){
			$sortby								=	"products_price";
			$order								=	"ASC";
		}elseif($type=="top seller"){
			$sortby								=	"products_ordered";
			$order								=	"DESC";
		}elseif($type=="most liked"){
			$sortby								=	"products_liked";
			$order								=	"DESC";
		}elseif($type == "special"){ //deals special products
			$sortby = "specials.products_id";
			$order = "desc";
		}else{
			$sortby = "products.products_id";
			$order = "desc";
		}
		
		
		$filterProducts = array();
		$eliminateRecord = array();
		if(!empty($request->filters)){
			
		foreach($request->filters as $filters_attribute){
			
			$data = DB::table('products_to_categories')
				->join('products', 'products.products_id', '=', 'products_to_categories.products_id')
				->leftJoin('products_description','products_description.products_id','=','products.products_id')
				->leftJoin('manufacturers','manufacturers.manufacturers_id','=','products.manufacturers_id')
				->LeftJoin('specials', function ($join) use ($currentDate) {  
					$join->on('specials.products_id', '=', 'products_to_categories.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
			})
			
				->leftJoin('manufacturers_info','manufacturers.manufacturers_id','=','manufacturers_info.manufacturers_id')
				->leftJoin('products_attributes','products_attributes.products_id','=','products.products_id')
				->leftJoin('products_options','products_options.products_options_id','=','products_attributes.options_id')
				->leftJoin('products_options_values','products_options_values.products_options_values_id','=','products_attributes.options_values_id')
				
				->select('products.*')
				->where('products_description.language_id','=', $language_id)
				->whereBetween('products.products_price', [$minPrice, $maxPrice]);
				
				if(!empty($request->categories_id)){
					$data->where('products_to_categories.categories_id','=', $request->categories_id);
				}
				
				$getProducts = $data->where('products_options.products_options_name','=', $filters_attribute['name'])
					->where('products_options_values.products_options_values_name','=', $filters_attribute['value'])
					->skip($skip)->take(10)
					->groupBy('products.products_id')
					->get();
				
				$foundRecord[] = $getProducts;
				if(count($foundRecord)>0){
					foreach($getProducts as $getProduct){
						if(!in_array($getProduct->products_id, $eliminateRecord)){
							$eliminateRecord[] = $getProduct->products_id;
															
							$products = DB::table('products_to_categories')
								->leftJoin('categories_description', 'categories_description.categories_id', '=', 'products_to_categories.categories_id')
								->leftJoin('products', 'products.products_id', '=', 'products_to_categories.products_id')
								->leftJoin('products_description','products_description.products_id','=','products.products_id')
								->leftJoin('manufacturers','manufacturers.manufacturers_id','=','products.manufacturers_id')
								->leftJoin('manufacturers_info','manufacturers.manufacturers_id','=','manufacturers_info.manufacturers_id')
								->leftJoin('specials', function ($join) use ($currentDate) {  
									$join->on('specials.products_id', '=', 'products_to_categories.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
								})
								
								->select('products_to_categories.*', 'products.*','products_description.*','manufacturers.*','manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price', 'products_to_categories.categories_id', 'categories_description.*')
								->where('categories_description.language_id','=', $language_id)
								->where('products_description.language_id','=', $language_id)
								->where('products.products_id','=', $getProduct->products_id)
								->get();
									$result = array();
									$index = 0;	
									foreach ($products as $products_data){
										$products_id = $products_data->products_id;
										
										//multiple images
										$products_images = DB::table('products_images')->select('image')->where('products_id','=', $products_id)->orderBy('sort_order', 'ASC')->get();		 
										$products_data->images =  $products_images;
										array_push($result,$products_data);
										$options = array();
										$attr = array();
										
										//like product
										if(!empty($request->customers_id)){
											$liked_customers_id		=	$request->customers_id;	
											$categories = DB::table('liked_products')->where('liked_products_id', '=', $products_id)->where('liked_customers_id', '=', $liked_customers_id)->get();
											//print_r($categories);
											if(count($categories)>0){
												$result[$index]->isLiked = '1';
											}else{
												$result[$index]->isLiked = '0';
											}
										}else{
											$result[$index]->isLiked = '0';						
										}
										
										// fetch all options add join from products_options table for option name
										$products_attribute = DB::table('products_attributes')->where('products_id','=', $products_id)->groupBy('options_id')->get();
										if(count($products_attribute)){
										$index2 = 0;
										foreach($products_attribute as $attribute_data){
											$option_name = DB::table('products_options')->where('language_id','=', $language_id)->where('products_options_id','=', $attribute_data->options_id)->get();
											if(count($option_name)>0){
											$temp = array();
											$temp_option['id'] = $attribute_data->options_id;
											$temp_option['name'] = $option_name[0]->products_options_name;
											$attr[$index2]['option'] = $temp_option;
											
											// fetch all attributes add join from products_options_values table for option value name
											$attributes_value_query =  DB::table('products_attributes')->where('products_id','=', $products_id)->where('options_id','=', $attribute_data->options_id)->get();
											foreach($attributes_value_query as $products_option_value){
												$option_value = DB::table('products_options_values')->where('products_options_values_id','=', $products_option_value->options_values_id)->get();
												$temp_i['id'] = $products_option_value->options_values_id;
												$temp_i['value'] = $option_value[0]->products_options_values_name;
												$temp_i['price'] = $products_option_value->options_values_price;
												$temp_i['price_prefix'] = $products_option_value->price_prefix;
												array_push($temp,$temp_i);
												
											}
											$attr[$index2]['values'] = $temp;
											$result[$index]->attributes = 	$attr;	
											$index2++;
											}
										}
											}else{
												$result[$index]->attributes = 	array();	
											}
											array_push($filterProducts,$result[$index]);
											$index++;
										}						
							}
						}
					$responseData = array('success'=>'1', 'product_data'=>$filterProducts,  'message'=>"Returned all products.", 'total_record'=>count($filterProducts));
					}
				else{
					$total_record = array();
					$responseData = array('success'=>'0', 'product_data'=>$filterProducts,  'message'=>"Search results empty.", 'total_record'=>count($total_record));
				}
		}
		}else{
		
			$categories = DB::table('products_to_categories')
				->LeftJoin('products', 'products.products_id', '=', 'products_to_categories.products_id')
				->LeftJoin('categories_description','categories_description.categories_id','=','products_to_categories.categories_id')
				->leftJoin('manufacturers','manufacturers.manufacturers_id','=','products.manufacturers_id')
				->leftJoin('manufacturers_info','manufacturers.manufacturers_id','=','manufacturers_info.manufacturers_id');
			
				$categories->leftJoin('products_description','products_description.products_id','=','products.products_id');
			
			//wishlist customer id
			if($type == "wishlist"){
				$categories->LeftJoin('liked_products', 'liked_products.liked_products_id', '=', 'products.products_id');
			}
			
			//parameter special
			elseif($type == "special"){
				$categories->LeftJoin('specials', 'specials.products_id', '=', 'products_to_categories.products_id')
					->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price', 'specials.specials_new_products_price as discount_price', 'categories_description.*');
			}
			else{
				$categories->LeftJoin('specials', function ($join) use ($currentDate) {  
					$join->on('specials.products_id', '=', 'products_to_categories.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
				})->select('products.*','products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price', 'products_to_categories.categories_id', 'categories_description.*');
			}
			
			
			if($type == "special"){ //deals special products
				$categories->where('specials.status','=', '1')->where('expires_date','>',  $currentDate);
			}
			
			//get single category products
			if(!empty($request->categories_id)){
				$categories->where('products_to_categories.categories_id','=', $request->categories_id);
			}
			
			//get single products
			if(!empty($request->products_id) && $request->products_id!=""){
				$categories->where('products.products_id','=', $request->products_id);
			}
			
			
			//for min and maximum price
			if(!empty($maxPrice)){
				$categories->whereBetween('products.products_price', [$minPrice, $maxPrice]);
			}
			
			
			//wishlist customer id
			if($type == "wishlist"){
				$categories->where('liked_customers_id', '=', $request->customers_id);
			}
						
			$categories->where('products_description.language_id','=',$language_id)
				->where('categories_description.language_id','=',$language_id)
				->orderBy($sortby, $order);
			
			if($type == "special"){ //deals special products
				$categories->groupBy('products.products_id');
			}
			//count
			$total_record = $categories->get();
			
			
			$data  = $categories->skip($skip)->take(10)->get();
			
			$result = array();
			$result2 = array();
			//check if record exist
			if(count($data)>0){
				$index = 0;	
				foreach ($data as $products_data){
				$products_id = $products_data->products_id;
				
				
				//multiple images
				$products_images = DB::table('products_images')->select('image')->where('products_id','=', $products_id)->orderBy('sort_order', 'ASC')->get();		
				$products_data->images =  $products_images;
				array_push($result,$products_data);
				$options = array();
				$attr = array();
				
				//like product
				if(!empty($request->customers_id)){
					$liked_customers_id						=	$request->customers_id;	
					$categories = DB::table('liked_products')->where('liked_products_id', '=', $products_id)->where('liked_customers_id', '=', $liked_customers_id)->get();
					if(count($categories)>0){
						$result[$index]->isLiked = '1';
					}else{
						$result[$index]->isLiked = '0';
					}
				}else{
					$result[$index]->isLiked = '0';						
				}
				
				// fetch all options add join from products_options table for option name
				$products_attribute = DB::table('products_attributes')->where('products_id','=', $products_id)->groupBy('options_id')->get();
				if(count($products_attribute)){
				$index2 = 0;
					foreach($products_attribute as $attribute_data){
						$option_name = DB::table('products_options')->where('language_id','=', $language_id)->where('products_options_id','=', $attribute_data->options_id)->get();
						if(count($option_name)>0){
						$temp = array();
						$temp_option['id'] = $attribute_data->options_id;
						$temp_option['name'] = $option_name[0]->products_options_name;
						$attr[$index2]['option'] = $temp_option;
						
						// fetch all attributes add join from products_options_values table for option value name					
						$attributes_value_query =  DB::table('products_attributes')->where('products_id','=', $products_id)->where('options_id','=', $attribute_data->options_id)->get();
						foreach($attributes_value_query as $products_option_value){
							$option_value = DB::table('products_options_values')->where('products_options_values_id','=', $products_option_value->options_values_id)->get();
							$temp_i['id'] = $products_option_value->options_values_id;
							$temp_i['value'] = $option_value[0]->products_options_values_name;
							$temp_i['price'] = $products_option_value->options_values_price;
							$temp_i['price_prefix'] = $products_option_value->price_prefix;
							array_push($temp,$temp_i);
							
						}
						$attr[$index2]['values'] = $temp;
						$result[$index]->attributes = 	$attr;	
						$index2++;
					}
					}
				}else{
					$result[$index]->attributes = 	array();	
				}
					$index++;
				}
					
					$responseData = array('success'=>'1', 'product_data'=>$result,  'message'=>"Returned all products.", 'total_record'=>count($total_record));
				}else{
					$responseData = array('success'=>'0', 'product_data'=>$result,  'message'=>"Empty record.", 'total_record'=>count($total_record));
				}		
		}
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
	}
	
	
	// likeProduct 
	public function likeProduct(Request $request){
		
		$liked_products_id  = $request->liked_products_id;
		$liked_customers_id = $request->liked_customers_id;
		$date_liked			= date('Y-m-d H:i:s');
		
		//to avoide duplicate record
		DB::table('liked_products')->where([
			'liked_products_id'  => $liked_products_id,
			'liked_customers_id' => $liked_customers_id
		])->delete();
		
		DB::table('liked_products')->insert([
			'liked_products_id'  => $liked_products_id,
			'liked_customers_id' => $liked_customers_id,
			'date_liked' 		 => $date_liked
		]);
				
		$response = DB::table('liked_products')->select('liked_products_id')->where('liked_customers_id', '=', $liked_customers_id)->get();
		DB::table('products')->where('products_id','=',$liked_products_id)->increment('products_liked');
		
		$responseData = array('success'=>'1', 'product_data'=>$response,  'message'=>"Product is liked.");
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
	}
	
	// likeProduct 
	public function unlikeProduct(Request $request){
		
		$liked_products_id  = $request->liked_products_id;
		$liked_customers_id = $request->liked_customers_id;
		
		DB::table('liked_products')->where([
			'liked_products_id'  => $liked_products_id,
			'liked_customers_id' => $liked_customers_id
		])->delete();
		
		DB::table('products')->where('products_id','=',$liked_products_id)->decrement('products_liked');
		
		$response = DB::table('liked_products')->select('liked_products_id')->where('liked_customers_id', '=', $liked_customers_id)->get();
		$responseData = array('success'=>'1', 'product_data'=>$response,  'message'=>"Product is unliked.");
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
	}
	
	//getFilters
	public function getFilters(Request $request){
		
		$language_id     	=   $request->language_id;
		$categories_id      =   $request->categories_id;
		$currentDate		=	time();
		
		
		$price = DB::table('products_to_categories')
						->join('products', 'products.products_id', '=', 'products_to_categories.products_id');
						if(isset($categories_id) and !empty($categories_id)){
							$price->where('products_to_categories.categories_id','=', $categories_id);
						}
						
			$priceContent 	=	$price->max('products_price');
			
			if(count($priceContent)>0){
				$maxPrice = $priceContent;	
			}else{
				$maxPrice = '';
			}
		
		$product = DB::table('products_to_categories')
			->join('products', 'products.products_id', '=', 'products_to_categories.products_id')
			->leftJoin('products_description','products_description.products_id','=','products.products_id')
			->leftJoin('manufacturers','manufacturers.manufacturers_id','=','products.manufacturers_id')
			->leftJoin('manufacturers_info','manufacturers.manufacturers_id','=','manufacturers_info.manufacturers_id')
			->LeftJoin('specials', function ($join) use ($currentDate) {  
				$join->on('specials.products_id', '=', 'products_to_categories.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
			})
			
			->select('products_to_categories.*', 'products.*','products_description.*','manufacturers.*','manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price')
			->where('products_description.language_id','=', $language_id);
			
			if(isset($categories_id) and !empty($categories_id)){
				$product->where('products_to_categories.categories_id','=', $categories_id);
			}
			
			$products = $product->get();
		
		$index = 0;
		$optionsIdArray = array();
		$valueIdArray = array();
		foreach($products as $products_data){
			$option_name = DB::table('products_attributes')->where('products_id', '=', $products_data->products_id)->get();
			foreach($option_name as $option_data){
				
				if(!in_array($option_data->options_id, $optionsIdArray)){
					$optionsIdArray[] = $option_data->options_id;
				}
				
				if(!in_array($option_data->options_values_id, $valueIdArray)){
					$valueIdArray[] = $option_data->options_values_id;
				}
			}
		}
		
		if(!empty($optionsIdArray)){
			
			$index3 = 0;
			$result = array();
			foreach($optionsIdArray as $optionsIdArray){
				$option_name = DB::table('products_options')->where('language_id', $language_id)->where('products_options_id', $optionsIdArray)->get();
				if(count($option_name)>0){
					$attribute_opt_val = DB::table('products_options_values_to_products_options')->where('products_options_id', $optionsIdArray)->get();			
					if(count($attribute_opt_val)>0){
					$temp = array();
					$temp_name['name'] = $option_name[0]->products_options_name;
					$attr[$index3]['option'] = $temp_name;
					//print_r($attr);
					
					foreach($attribute_opt_val as $attribute_opt_val_data){
					
						$attribute_value = DB::table('products_options_values')->where('products_options_values_id', $attribute_opt_val_data->products_options_values_id )->get();
						
						foreach($attribute_value as $attribute_value_data){
							
							if(in_array($attribute_value_data->products_options_values_id,$valueIdArray)){
								$temp_value['value'] = $attribute_value_data->products_options_values_name;
								//array_push($attr, $temp_value);
								array_push($temp, $temp_value);
							}
						}
							$attr[$index3]['values'] = $temp;
					}
					$index3++;
					}
					
					$responseData = array('success'=>'1', 'filters'=>$attr, 'message'=>"Returned all filters successfully.", 'maxPrice'=>$maxPrice);
				}
				//if(count())
				
				//$data = array_filter($attr, function ($i) { return !empty($i['values']); });
				//$responseData = array('success'=>'1', 'filters'=>$attr, 'message'=>"Returned all filters successfully.");
			
			}
			
			/*if(empty($data)){
				$responseData = array('success'=>'0', 'filters'=>array(), 'message'=>"Filter is empty for this category.");	
			}*/
		}else{
			$responseData = array('success'=>'0', 'filters'=>array(), 'message'=>"Filter is empty for this category.", 'maxPrice'=>$maxPrice);	
		}
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
		}
	
	
	//getfilterproducts
	public function getFilterproducts(Request $request){
		
		$language_id            				=   '1';	
		$skip									=   $request->page_number.'0';
		$categories_id 							=   $request->categories_id;
		$minPrice	 							=   $request->price['minPrice'];
		$maxPrice	 							=   $request->price['maxPrice'];
		$currentDate = time();	
		//print_r($request->all());
		$filterProducts = array();
		$eliminateRecord = array();
			
		if(!empty($request->filters)){
			
		foreach($request->filters as $filters_attribute){
			//print_r($filters_attribute);
			
			$getProducts = DB::table('products_to_categories')
				->join('products', 'products.products_id', '=', 'products_to_categories.products_id')
				->leftJoin('products_description','products_description.products_id','=','products.products_id')
				->leftJoin('manufacturers','manufacturers.manufacturers_id','=','products.manufacturers_id')
				->LeftJoin('specials', function ($join) use ($currentDate) {  
					$join->on('specials.products_id', '=', 'products_to_categories.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
			})
			
				->leftJoin('manufacturers_info','manufacturers.manufacturers_id','=','manufacturers_info.manufacturers_id')
				->leftJoin('products_attributes','products_attributes.products_id','=','products.products_id')
				->leftJoin('products_options','products_options.products_options_id','=','products_attributes.options_id')
				->leftJoin('products_options_values','products_options_values.products_options_values_id','=','products_attributes.options_values_id')
				
				->select('products.*')
				//->where('products_description.language_id','=', $language_id)
				//->where('manufacturers_info.languages_id','=', $language_id)
				->whereBetween('products.products_price', [$minPrice, $maxPrice])
				->where('products_to_categories.categories_id','=', $categories_id)
				->where('products_options.products_options_name','=', $filters_attribute['name'])
				->where('products_options_values.products_options_values_name','=', $filters_attribute['value'])
				->skip($skip)->take(10)
				->groupBy('products.products_id')
				->get();
				
				if(count($getProducts)>0){
					foreach($getProducts as $getProduct){
						if(!in_array($getProduct->products_id, $eliminateRecord)){
							$eliminateRecord[] = $getProduct->products_id;
															
							$products = DB::table('products_to_categories')
								->join('categories', 'categories.categories_id', '=', 'products_to_categories.categories_id')
								->leftJoin('categories_description', 'categories_description.categories_id', '=', 'products_to_categories.categories_id')
								->leftJoin('products', 'products.products_id', '=', 'products_to_categories.products_id')
								->leftJoin('products_description','products_description.products_id','=','products.products_id')
								->leftJoin('manufacturers','manufacturers.manufacturers_id','=','products.manufacturers_id')
								->leftJoin('manufacturers_info','manufacturers.manufacturers_id','=','manufacturers_info.manufacturers_id')
								->LeftJoin('specials', function ($join) use ($currentDate) {  
				$join->on('specials.products_id', '=', 'products_to_categories.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
			})
								->select('products_to_categories.*', 'categories_description.categories_name','categories.*', 'products.*','products_description.*','manufacturers.*','manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price')
								//->where('products_description.language_id','=', $language_id)
								//->where('manufacturers_info.languages_id','=', $language_id)
								->where('products.products_id','=', $getProduct->products_id)
								->get();
								//print_r($products);
								$result = array();
									$index = 0;	
									foreach ($products as $products_data){
											$products_id = $products_data->products_id;
											
											$detail = DB::table('products_description')->where('products_id','=', $products_id)->get();
											$index3 =  0;
											foreach($detail as $detail_data){
																				
													//get function from other controller
													$myVar = new AdminSiteSettingController();
													$languages = $myVar->getSingleLanguages($detail_data->language_id);
													
													$result2[$languages[$index3]->code] = $detail_data;
													$index3++;
												}
											//multiple images
											$products_images = DB::table('products_images')->select('image')->where('products_id','=', $products_id)->orderBy('sort_order', 'ASC')->get();		
											$products_data->images =  $products_images;
											
											array_push($result,$products_data);
											$options = array();
											$attr = array();
											
											//like product
											if(!empty($request->customers_id)){
												$liked_customers_id						=	$request->customers_id;	
												$categories = DB::table('liked_products')->where('liked_products_id', '=', $products_id)->where('liked_customers_id', '=', $liked_customers_id)->get();
												//print_r($categories);
												if(count($categories)>0){
													$result[$index]->isLiked = '1';
												}else{
													$result[$index]->isLiked = '0';
												}
											}else{
												$result[$index]->isLiked = '0';						
											}
											
											//get function from other controller
											$myVar = new AdminSiteSettingController();
											$languages = $myVar->getLanguages();
											$data = array();
											foreach($languages as $languages_data){
												$products_attribute = DB::table('products_attributes')->where('products_id','=', $products_id)->groupBy('options_id')->get();
												if(count($products_attribute)>0){
													$index2 = 0;
													foreach($products_attribute as $attribute_data){
														$option_name = DB::table('products_options')->where('products_options_id','=', $attribute_data->options_id)->where('language_id','=',$languages_data->languages_id)->get();
														if(count($option_name)>0){
															$temp = array();
															$temp_option['id'] = $attribute_data->options_id;
															$temp_option['name'] = $option_name[0]->products_options_name;
															$attr[$index2]['option'] = $temp_option;
															
															// fetch all attributes add join from products_options_values table for option value name
															$attributes_value_query =  DB::table('products_attributes')->where('products_id','=', $products_id)->where('options_id','=', $attribute_data->options_id)->get();
															foreach($attributes_value_query as $products_option_value){
																$option_value = DB::table('products_options_values')->where('products_options_values_id','=', $products_option_value->options_values_id)->get();
																$temp_i['id'] = $products_option_value->options_values_id;
																$temp_i['value'] = $option_value[0]->products_options_values_name;
																$temp_i['price'] = $products_option_value->options_values_price;
																$temp_i['price_prefix'] = $products_option_value->price_prefix;
																array_push($temp,$temp_i);
																
															}
															$attr[$index2]['values'] = $temp;
															$data[$languages_data->code] = $attr; 
															//$result[$index]->attributes = $attr;	
															$result[$index]->detail = $result2;
															$index2++;
														}
														
														
														//print_r($data);
													}
													$result[$index]->attributes = $data;
												}else{
													$result[$index]->attributes = 	array();	
												}
											}
												$index++;
								}						
							}
						}
					$responseData = array('success'=>'1', 'product_data'=>$filterProducts,  'message'=>"Returned all products.", 'total_record'=>count($index));
					}
				else{
					$total_record = array();
					$responseData = array('success'=>'0', 'product_data'=>$filterProducts,  'message'=>"Empty record.", 'total_record'=>count($total_record));
				}
		}
		}else{				
				
		$total_record = DB::table('products_to_categories')
					->join('products', 'products.products_id', '=', 'products_to_categories.products_id')
					->leftJoin('products_description','products_description.products_id','=','products.products_id')
					->leftJoin('manufacturers','manufacturers.manufacturers_id','=','products.manufacturers_id')
					->leftJoin('manufacturers_info','manufacturers.manufacturers_id','=','manufacturers_info.manufacturers_id')
					->LeftJoin('specials', function ($join) use ($currentDate) {  
				$join->on('specials.products_id', '=', 'products_to_categories.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
			})
					//->where('products_description.language_id','=', $language_id)
					//->where('manufacturers_info.languages_id','=', $language_id)
					->whereBetween('products.products_price', [$minPrice, $maxPrice])
					->where('products_to_categories.categories_id','=', $categories_id)
					->get();
					
		$products = DB::table('products_to_categories')
					->join('products', 'products.products_id', '=', 'products_to_categories.products_id')
					->leftJoin('products_description','products_description.products_id','=','products.products_id')
					->leftJoin('manufacturers','manufacturers.manufacturers_id','=','products.manufacturers_id')
					->leftJoin('manufacturers_info','manufacturers.manufacturers_id','=','manufacturers_info.manufacturers_id')
					->LeftJoin('specials', function ($join) use ($currentDate) {  
				$join->on('specials.products_id', '=', 'products_to_categories.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
			})
					->select('products_to_categories.*', 'products.*', 'products_description.*','manufacturers.*','manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price')
					//->where('products_description.language_id','=', $language_id)
				//	->where('manufacturers_info.languages_id','=', $language_id)
					->whereBetween('products.products_price', [$minPrice, $maxPrice])
					->where('products_to_categories.categories_id','=', $categories_id)
					->skip($skip)->take(10)
					->get();
			
			$result = array();
			//check if record exist
			if(count($products)>0){
			$index = 0;	
			foreach ($products as $products_data){
				$products_id = $products_data->products_id;				
				
				//multiple images
				$products_images = DB::table('products_images')->select('image')->where('products_id','=', $products_id)->orderBy('sort_order', 'ASC')->get();		
				$products_data->images =  $products_images;
				//array_push($products_data, $temp_images);
				array_push($result,$products_data);
				$options = array();
				$attr = array();
				
				//like product
				if(!empty($request->customers_id)){
					$liked_customers_id						=	$request->customers_id;	
					$categories = DB::table('liked_products')->where('liked_products_id', '=', $products_id)->where('liked_customers_id', '=', $liked_customers_id)->get();
					//print_r($categories);
					if(count($categories)>0){
						$result[$index]->isLiked = '1';
					}else{
						$result[$index]->isLiked = '0';
					}
				}else{
					$result[$index]->isLiked = '0';						
				}
				
				// fetch all options add join from products_options table for option name
				$products_attribute = DB::table('products_attributes')->where('products_id','=', $products_id)->groupBy('options_id')->get();
				if(count($products_attribute)){
				$index2 = 0;
					foreach($products_attribute as $attribute_data){
						$option_name = DB::table('products_options')->where('products_options_id','=', $attribute_data->options_id)->get();
						$temp = array();
						$temp_option['id'] = $attribute_data->options_id;
						$temp_option['name'] = $option_name[0]->products_options_name;
						$attr[$index2]['option'] = $temp_option;
						
						// fetch all attributes add join from products_options_values table for option value name
						
						$attributes_value_query =  DB::table('products_attributes')->where('products_id','=', $products_id)->where('options_id','=', $attribute_data->options_id)->get();
						foreach($attributes_value_query as $products_option_value){
							$option_value = DB::table('products_options_values')->where('products_options_values_id','=', $products_option_value->options_values_id)->get();
							$temp_i['id'] = $products_option_value->options_values_id;
							$temp_i['value'] = $option_value[0]->products_options_values_name;
							$temp_i['price'] = $products_option_value->options_values_price;
							$temp_i['price_prefix'] = $products_option_value->price_prefix;
							array_push($temp,$temp_i);
							
						}
						$attr[$index2]['values'] = $temp;
						$result[$index]->attributes = 	$attr;	
						$index2++;

					}
					}else{
						$result[$index]->attributes = 	array();	
					}
					$index++;
				}
				$responseData = array('success'=>'1', 'product_data'=>$result,  'message'=>"Returned all products.", 'total_record'=>count($total_record));
			}else{
				$total_record = array();
				$responseData = array('success'=>'0', 'product_data'=>$result,  'message'=>"Empty record.", 'total_record'=>count($total_record));
			}	
				
		}
			$categoryResponse = json_encode($responseData);
			print $categoryResponse;
		}
	
	
	
	//getSearchData
	public function getSearchData(Request $request){
		
		$language_id            				=   $request->language_id;
		//$language_id            				=   '1';	
		$searchValue            				=   $request->searchValue;
		$currentDate 							=   time();	
		//print_r($searchValue);
		$result = array();
		
		$mainCategories = DB::table('categories')
			->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
			->select('categories.categories_id as id', 'categories.categories_image as image', 'categories_description.categories_name as name')
			->where('categories_description.categories_name', 'LIKE', '%'.$searchValue.'%')
			->where('categories_description.language_id', '=', $language_id)
			->where('parent_id', '0')->get();
		
		$result['mainCategories'] = $mainCategories;
		
		$subCategories = DB::table('categories')
			->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
			->select('categories.categories_id as id', 'categories.categories_image as image', 'categories_description.categories_name as name')
			->where('categories_description.categories_name', 'LIKE', '%'.$searchValue.'%')
			->where('categories_description.language_id', '=', $language_id)
			->where('parent_id', '1')->get();
		
		$result['subCategories'] = $subCategories;
		
		$manufacturers = DB::table('manufacturers')
			->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
			->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturers_image as image',  'manufacturers.manufacturers_name as name')
			//->where('manufacturers.language_id', '=', $language_id)
			->where('manufacturers.manufacturers_name', 'LIKE', '%'.$searchValue.'%')
			->get();
		
		$productsAttribute = DB::table('products_to_categories')
				->join('products', 'products.products_id', '=', 'products_to_categories.products_id')
				->leftJoin('products_description','products_description.products_id','=','products.products_id')
				->leftJoin('manufacturers','manufacturers.manufacturers_id','=','products.manufacturers_id')
				->leftJoin('manufacturers_info','manufacturers.manufacturers_id','=','manufacturers_info.manufacturers_id')
				->leftJoin('products_attributes','products_attributes.products_id','=','products.products_id')
				->leftJoin('products_options','products_options.products_options_id','=','products_attributes.options_id')
				->leftJoin('products_options_values','products_options_values.products_options_values_id','=','products_attributes.options_values_id')				->LeftJoin('specials', function ($join) use ($currentDate) {  
					$join->on('specials.products_id', '=', 'products_to_categories.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
				})->select('products.*','products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price')
				
				->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price', 'specials.specials_new_products_price as discount_price', 'products_to_categories.categories_id')
				->orWhere('products_options.products_options_name', 'LIKE', '%'.$searchValue.'%')
				->orWhere('products_options_values.products_options_values_name', 'LIKE', '%'.$searchValue.'%')
				->orWhere('products_name', 'LIKE', '%'.$searchValue.'%')
				->orWhere('products_model', 'LIKE', '%'.$searchValue.'%')
				->where('products_description.language_id', '=', $language_id)
				->groupBy('products.products_id')
				->get();
				
			$result2 = array();
			//check if record exist
			if(count($productsAttribute)>0){
				$index = 0;	
				foreach ($productsAttribute as $products_data){
				$products_id = $products_data->products_id;
				
				
				//multiple images
				$products_images = DB::table('products_images')->select('image')->where('products_id','=', $products_id)->orderBy('sort_order', 'ASC')->get();		
				$products_data->images =  $products_images;
				//array_push($products_data, $temp_images);
				array_push($result2,$products_data);
				$options = array();
				$attr = array();
				
				//like product
				if(!empty($request->customers_id)){
					$liked_customers_id						=	$request->customers_id;	
					$categories = DB::table('liked_products')->where('liked_products_id', '=', $products_id)->where('liked_customers_id', '=', $liked_customers_id)->get();
					//print_r($categories);
					if(count($categories)>0){
						$result2[$index]->isLiked = '1';
					}else{
						$result2[$index]->isLiked = '0';
					}
				}else{
					$result2[$index]->isLiked = '0';						
				}
				
				// fetch all options add join from products_options table for option name
				$products_attribute = DB::table('products_attributes')->where('products_id','=', $products_id)->groupBy('options_id')->get();
				if(count($products_attribute)){
					$index2 = 0;
					foreach($products_attribute as $attribute_data){
						$option_name = DB::table('products_options')->where('language_id','=', $language_id)->where('products_options_id','=', $attribute_data->options_id)->get();
						//print_r($option_name);
						if(count($option_name)>0){
						$temp = array();
						$temp_option['id'] = $attribute_data->options_id;
						$temp_option['name'] = $option_name[0]->products_options_name;
						$attr[$index2]['option'] = $temp_option;
						
						// fetch all attributes add join from products_options_values table for option value name
						
						$attributes_value_query =  DB::table('products_attributes')->where('products_id','=', $products_id)->where('options_id','=', $attribute_data->options_id)->get();
						foreach($attributes_value_query as $products_option_value){
							$option_value = DB::table('products_options_values')->where('products_options_values_id','=', $products_option_value->options_values_id)->get();
							$temp_i['id'] = $products_option_value->options_values_id;
							$temp_i['value'] = $option_value[0]->products_options_values_name;
							$temp_i['price'] = $products_option_value->options_values_price;
							$temp_i['price_prefix'] = $products_option_value->price_prefix;
							array_push($temp,$temp_i);
							
						}
						$attr[$index2]['values'] = $temp;
						$result2[$index]->attributes = 	$attr;	
						$index2++;
					}
					}
				}else{
					$result2[$index]->attributes = 	array();	
				}
					$index++;
				}
					
					
				}
		
		
		$result['products'] = $result2;
		$total_record = count($result['products']) + count($result['subCategories']) + count($result['mainCategories']);
		
		if(count($result['products'])==0 and count($result['subCategories'])==0 and count($result['mainCategories'])==0){
			$result = new  \stdClass();
			$responseData = array('success'=>'0', 'product_data'=>$result,  'message'=>"Search result is not found.", 'total_record'=>$total_record);
			
		}else{
			$responseData = array('success'=>'1', 'product_data'=>$result,  'message'=>"Returned all searched products.", 'total_record'=>$total_record);
		}	
		
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
	}
	
}
