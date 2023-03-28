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

class NewsController extends Controller
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
	public function allNewsCategories(Request $request){
		$language_id            				=   $request->language_id;	
		$skip									=   $request->page_number.'0';		
		$result 	= 	array();
		$data 		=	array();
		
		$categories = DB::table('news_categories')
			->LeftJoin('news_categories_description', 'news_categories_description.categories_id', '=', 'news_categories.categories_id')
			->select('news_categories.categories_id as id',
				 'news_categories.categories_image as image',
				// 'news_categories.categories_icon as icon',
				 /*'news_categories.sort_order as order',*/
				 'news_categories_description.categories_name as name'
				 )
			->where('news_categories_description.language_id','=', $language_id)->skip($skip)->take(10)
			->get();
		
		if(count($categories)>0){
			
			foreach($categories as $categories_data){
				
				$categories_id = $categories_data->id;
				$news = DB::table('news_categories')
						->LeftJoin('news_to_news_categories', 'news_to_news_categories.categories_id', '=', 'news_categories.categories_id')
						->LeftJoin('news', 'news.news_id', '=', 'news_to_news_categories.news_id')
						->select('news_categories.categories_id', DB::raw('COUNT(DISTINCT news.news_id) as total_news'))
						->where('news_categories.categories_id','=', $categories_id)
						->get();
						
				$categories_data->total_news = $news[0]->total_news;
				array_push($result,$categories_data);
			}
			
			
			$responseData = array('success'=>'1', 'data'=>$result, 'message'=>"Returned all categories.", 'categories'=>count($categories));
		}
		else{
			$responseData = array('success'=>'0', 'data'=>array(), 'message'=>"No category found.", 'categories'=>array());
		}
		
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
	}

	
	//getAllProducts 
	public function getAllNews(Request $request){
		$language_id            				=   $request->language_id;	
		$skip									=   $request->page_number.'0';
		//$skip									=	$request->page_number;
		$currentDate 							=   time();	
		$type									=	$request->type;
		
		
		if($type=="a to z"){
			$sortby								=	"products_name";
			$order								=	"ASC";
		}elseif($type=="z to a"){
			$sortby								=	"products_name";
			$order								=	"DESC";
		}else{
			$sortby = "news.news_id";
			$order = "desc";
		}
		
			
			$categories = DB::table('news_to_news_categories')
				->LeftJoin('news', 'news.news_id', '=', 'news_to_news_categories.news_id');
			
			//if($type=="a to z" or $type=="a to z"){
				$categories->leftJoin('news_description','news_description.news_id','=','news.news_id');
			//}
			
			/*//wishlist customer id
			if($type == "wishlist"){
				$categories->LeftJoin('liked_products', 'liked_products.liked_products_id', '=', 'products.products_id');
			}
			*/
			$categories->select('news.*','news_description.*', 'news_to_news_categories.categories_id');
			
						
			//get single category products
			if(!empty($request->categories_id)){
				$categories->where('news_to_news_categories.categories_id','=', $request->categories_id);
			}
			
			//get single news
			if(!empty($request->news_id) && $request->news_id!=""){
				$categories->where('news.news_id','=', $request->news_id);
			}
			
			//get featured news
			if($request->is_feature==1){
				$categories->where('news.is_feature','=', 1);
			}
			
			
			$categories->where('news_description.language_id','=',$language_id)->orderBy($sortby, $order);
			
			//count
			$total_record = $categories->get();
			
			$data  = $categories->skip($skip)->take(10)->get();
			$result = array();
			$index = 0;
			foreach($data as $news_data){
				array_push($result,$news_data);
				
				$news_description =  $news_data->news_description;
				$result[$index]->news_description = stripslashes($news_description);
				//print_r($result);
				$index++;
			}
			//print_r($result);
			//check if record exist
			if(count($data)>0){
					$responseData = array('success'=>'1', 'news_data'=>$result,  'message'=>"Returned all products.", 'total_record'=>count($total_record));
				}else{
					$responseData = array('success'=>'0', 'news_data'=>array(),  'message'=>"Empty record.", 'total_record'=>count($total_record));
				}		
						
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
	}
	
}
