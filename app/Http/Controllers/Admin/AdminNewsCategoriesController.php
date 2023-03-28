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

//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//for requesting a value 
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;


class AdminNewsCategoriesController extends Controller
{
	public function getNewsCategories($language_id){
		
		$getCategories = DB::table('news_categories')
		->leftJoin('news_categories_description','news_categories_description.categories_id', '=', 'news_categories.categories_id')
		->select('news_categories.categories_id as id', 'news_categories.categories_image as image',  'news_categories.categories_icon as icon',  'news_categories.date_added as date_added', 'news_categories.last_modified as last_modified', 'news_categories_description.categories_name as name', 'news_categories_description.language_id')
		->where('parent_id', '0')->where('news_categories_description.language_id', $language_id)->get();
		return($getCategories) ;
	}
	
	public function listingNewsCategories(){
		$title = array('pageTitle' => Lang::get("labels.NewsCategories"));
		
		$listingCategories = DB::table('news_categories')
		->leftJoin('news_categories_description','news_categories_description.categories_id', '=', 'news_categories.categories_id')
		->select('news_categories.categories_id as id', 'news_categories.categories_image as image',  'news_categories.categories_icon as icon',  'news_categories.date_added as date_added', 'news_categories.last_modified as last_modified', 'news_categories_description.categories_name as name', 'news_categories_description.language_id')
		->where('parent_id', '0')->where('news_categories_description.language_id', '1')->paginate(10);
		
		return view("admin.listingNewsCategories",$title)->with('listingCategories', $listingCategories);
	}
	
	//add category
	public function addNewsCategory(Request $request){
		$title = array('pageTitle' => Lang::get("labels.AddNewsCategories"));
		
		$result = array();
		$result['message'] = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		return view("admin.addNewsCategory",$title)->with('result', $result);
	}
	
	//addNewCategory	
	public function addNewsNewCategory(Request $request){
		
		$title = array('pageTitle' => Lang::get("labels.AddNewsCategories"));
		
		$result = array();
		$date_added	= date('y-m-d h:i:s');
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
				
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/news_categories_images/', $fileName);
			$uploadImage = 'resources/assets/images/news_categories_images/'.$fileName; 
		}	else{
			$uploadImage = '';
		}	
		
		if($request->hasFile('newIcon')){
			$icon = $request->newIcon;
			$iconName = time().'.'.$icon->getClientOriginalName();
			$icon->move('resources/assets/images/news_icons/', $iconName);
			$uploadIcon = 'resources/assets/images/news_icons/'.$iconName; 
		}	else{
			$uploadIcon = '';
		}	
		
		$categories_id = DB::table('news_categories')->insertGetId([
					'categories_image'   =>   $uploadImage,
					'date_added'		 =>   $date_added,
					'parent_id'		 	 =>   '0',
					'categories_icon'	 =>	  $uploadIcon
					]);
		
		//multiple lanugauge with record 
		foreach($languages as $languages_data){
			$categoryName= 'categoryName_'.$languages_data->languages_id;
				
			DB::table('news_categories_description')->insert([
					'categories_name'   =>   $request->$categoryName,
					'categories_id'     =>   $categories_id,
					'language_id'       =>   $languages_data->languages_id
				]);
		}		
				
		$message = Lang::get("labels.NewsCategoriesAddedMessage");
				
		//return view('admin.addCategory', $title)->with('result', $result);
		return redirect()->back()->withErrors([$message]);
	}
	
	//editCategory
	public function editNewsCategory(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.EditNewsCategories"));
		$result = array();		
		$result['message'] = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		$editCategory = DB::table('news_categories')
		->leftJoin('news_categories_description','news_categories_description.categories_id', '=', 'news_categories.categories_id')
		->select('news_categories.categories_id as id', 'news_categories.categories_image as image', 'news_categories.categories_icon as icon',  'news_categories.date_added as date_added', 'news_categories.last_modified as last_modified', 'news_categories_description.categories_name as name', 'news_categories_description.language_id', 'news_categories_description.categories_description_id')
		->where('news_categories.categories_id', $request->id)->get();
		
		$result['editCategory'] = $editCategory;		
		
		return view("admin.editNewsCategory", $title)->with('result', $result);
	}
	
	//updateCategory
	public function updateNewsCategory(Request $request){
		
		$title = array('pageTitle' => Lang::get("labels.EditNewsCategories"));
		$last_modified 	=   date('y-m-d h:i:s');
		
		$result = array();		
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
		
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/news_categories_images/', $fileName);
			$uploadImage = 'resources/assets/images/news_categories_images/'.$fileName; 
		}else{
			$uploadImage = $request->oldImage;
		}
		
		if($request->hasFile('newIcon')){
			$icon = $request->newIcon;
			$iconName = time().'.'.$icon->getClientOriginalName();
			$icon->move('resources/assets/images/news_icons/', $iconName);
			$uploadIcon = 'resources/assets/images/news_icons/'.$iconName; 
		}	else{
			$uploadIcon = $request->oldIcon;
		}
		
		
		DB::table('news_categories')->where('categories_id', $request->id)->update([
			'categories_image'   =>   $uploadImage,
			'last_modified'   	 =>   $last_modified,
			'categories_icon'    =>   $uploadIcon
			]);
		
		//multiple lanugauge with record 
		foreach($languages as $languages_data){
			$categories_description_id = 'categories_description_id_'.$languages_data->languages_id;
			$categoryName= 'categoryName_'.$languages_data->languages_id;
			//print_r($request->$categories_description_id);
			
			$checkexist = DB::table('news_categories_description')->where('categories_description_id','=',$request->$categories_description_id)->get();
			if(count($checkexist)>0){
				DB::table('news_categories_description')
					->where('categories_id', $request->id)
					->where('categories_description_id', $request->$categories_description_id)
					->update([
						'categories_name'   =>   $request->$categoryName,
					]);
			}else{
				DB::table('news_categories_description')->insert([
					'categories_name'   =>   $request->$categoryName,
					'categories_id'     =>   $request->id,
					'language_id'       =>   $languages_data->languages_id
				]);
			}
		}
		
		$message = Lang::get("labels.NewsCategoriesUpdatedMessage");
		return redirect()->back()->withErrors([$message]);
	}
	
	
	//deleteNewsCategory
	public function deleteNewsCategory(Request $request){
		DB::table('news_categories')->where('categories_id', $request->id)->delete();
		DB::table('news_categories_description')->where('categories_id', $request->id)->delete();
		return redirect()->back()->withErrors([Lang::get("labels.NewsCategoriesDeletedMessage")]);
	}
	
}
