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

class AdminNewsController extends Controller
{
	
	public function listingNews(Request $request){
		$title = array('pageTitle' => 'News');
		$language_id            				=   '1';			
		
		$news = DB::table('news_to_news_categories')
			->leftJoin('news_categories', 'news_categories.categories_id', '=', 'news_to_news_categories.categories_id')
			->leftJoin('news', 'news.news_id', '=', 'news_to_news_categories.news_id')
			->leftJoin('news_description','news_description.news_id','=','news.news_id')
			->leftJoin('news_categories_description','news_categories_description.categories_id','=','news_to_news_categories.categories_id')
			
			->select('news_to_news_categories.*', 'news_categories_description.categories_name','news_categories.*', 'news.*','news_description.*')
			->where('news_description.language_id','=', $language_id)
			->where('news_categories_description.language_id','=', $language_id)
			->orderBy('news.news_id', 'ASC')
			->paginate(20);
		
		$currentTime =  array('currentTime'=>time());
		return view("admin.listingNews",$title)->with('news', $news);
	}
	
	public function addNews(Request $request){
	
		$title = array('pageTitle' => 'Add News');
		$language_id      =   '1';
		
		$result = array();
		
		//get function from other controller
		$myVar = new AdminNewsCategoriesController();
		$result['newsCategories'] = $myVar->getNewsCategories($language_id);
				
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		//print_r($result);
		return view("admin.addNews", $title)->with('result', $result);
	}
	
	//addNewNews
	public function addNewNews(Request $request){
		$title = array('pageTitle' => 'Add News');	
		$date_added	= date('Y-m-d h:i:s');
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
		
		
		//print_r($expiryDateFormate);
		if($request->hasFile('news_image')){
			$image = $request->news_image;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/news_images/', $fileName);
			$uploadImage = 'resources/assets/images/news_images/'.$fileName; 
		}else{
			$uploadImage = '';
		}	
		
		$news_id = DB::table('news')->insertGetId([
					'news_image'  			 =>   $uploadImage,
					'news_date_added'	 	 =>   $date_added,
					'news_status'		 	 =>   $request->news_status,
					'is_feature'		 	 =>   $request->is_feature
					]);
		
		foreach($languages as $languages_data){
			$news_name = 'news_name_'.$languages_data->languages_id;
			$news_description = 'news_description_'.$languages_data->languages_id;
			
			DB::table('news_description')->insert([
					'news_name'  	    	 =>   $request->$news_name,
					'language_id'			 =>   $languages_data->languages_id,
					'news_id'				 =>   $news_id,
					/*'news_url'			 =>   $request->news_url,*/
					'news_description'		 =>   addslashes($request->$news_description)
					]);
		}	
		
		DB::table('news_to_news_categories')->insert([
					'news_id'   		=>     $news_id,
					'categories_id'     =>     $request->category_id
				]);
				
		$message = 'News has been added successfully!';				
		return redirect()->back()->withErrors([$message]);
	}
		
	//editnew
	public function editNews(Request $request){
		$title = array('pageTitle' => 'Edit News');
		$language_id      =   '1';	
		$news_id     	  =   $request->id;	
		$category_id	  =	  '0';
		
		$result = array();
		
		//get categories from other controller
		$myVar = new AdminNewsCategoriesController();
		$result['categories'] = $myVar->getNewsCategories($language_id);
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
						
		$news = DB::table('news')
			->leftJoin('news_description','news_description.news_id','=','news.news_id')
	
			->select('news.*','news_description.*')
			//->where('news_description.language_id','=', $language_id)
			->where('news.news_id','=', $news_id)
			->get();
		
		$result['news'] = $news;
		
		
		//get new sub category id
		$newsCategory = DB::table('news_to_news_categories')->where('news_id','=', $news_id)->get();
		$result['categoryId'] = $newsCategory;
		
		
		$categories = DB::table('news_categories')
		->leftJoin('news_categories_description','news_categories_description.categories_id', '=', 'news_categories.categories_id')
		->select('news_categories.categories_id as id', 'news_categories_description.categories_name as name', 'news_categories.categories_id', 'news_categories_description.categories_description_id' )
		->where('news_categories.categories_id','=', $result['categoryId'][0]->categories_id)->get();
		
		$result['editCategory'] = $categories;
		
		//print_r($result);
		return view("admin.editNews", $title)->with('result', $result);		
	}
	
	
	//updatenew
	public function updateNews(Request $request){
		
		$language_id      =   '1';	
		$news_id      =   $request->id;	
		$news_last_modified	= date('Y-m-d h:i:s');
			
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
		
		if($request->hasFile('news_image')){
			$image = $request->news_image;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/news_images/', $fileName);
			$uploadImage = 'resources/assets/images/news_images/'.$fileName; 
		}else{
			$uploadImage = $request->oldImage;
		}	
		
		DB::table('news')->where('news_id','=',$news_id)->update([
					'news_image'  			 =>   $uploadImage,
					'news_last_modified'	 =>   $news_last_modified,
					'news_status'		 	 =>   $request->news_status,
					'is_feature'		 	 =>   $request->is_feature
					]);
		
		
		foreach($languages as $languages_data){
			$news_name = 'news_name_'.$languages_data->languages_id;
			$news_description = 'news_description_'.$languages_data->languages_id;
			//if(!empty($request->$news_name)){
			
			$checkExist = DB::table('news_description')->where('news_id','=',$news_id)->where('language_id','=',$languages_data->languages_id)->get();
			
			if(count($checkExist)>0){
				DB::table('news_description')->where('news_id','=',$news_id)->where('language_id','=',$languages_data->languages_id)->update([
					'news_name'  	     =>   $request->$news_name,
					/*'news_url'		 =>   $request->news_url,*/
					'news_description'	 =>   addslashes($request->$news_description)
					]);
			}else{
				DB::table('news_description')->insert([
						'news_name'  	     =>   $request->$news_name,
						'language_id'		 =>   $languages_data->languages_id,
						'news_id'			 =>   $news_id,
						/*'news_url'		 =>   $request->news_url,*/
						'news_description'	 =>   addslashes($request->$news_description)
						]);	
			}
		}
		
		DB::table('news_to_news_categories')->where('news_id','=',$news_id)->update([
					'categories_id'     =>     $request->category_id
				]);
		
		$message = 'News has been added successfully!';				
		return redirect()->back()->withErrors([$message]);
		
	}
	
	//deleteNews
	public function deleteNews(Request $request){
		DB::table('news')->where('news_id', $request->id)->delete();
		DB::table('news_description')->where('news_id', $request->id)->delete();
		DB::table('news_to_news_categories')->where('news_id', $request->id)->delete();
		return redirect()->back()->withErrors(['News has been deleted successfully!']);
	}
	
	
	
	
}
