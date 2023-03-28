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


class AdminCategoriesController extends Controller
{
	public function getCategories($language_id){
		
		$language_id     =   $language_id;		
		$listingCategories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name')
		->where('categories_description.language_id','=', $language_id )->where('parent_id', '0')->get();
		return($listingCategories) ;
		//print_r($mainCategories);
	}
	
	public function getSubCategories($language_id){
		
		$language_id     =   $language_id;		
		$listingCategories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name')
		->where('categories_description.language_id','=', $language_id )->where('parent_id','>', '0')->get();
		return($listingCategories);
		//print_r($mainCategories);
	}
	
	public function listingCategories(){
		$title = array('pageTitle' => Lang::get("labels.MainCategories"));
		
		$listingCategories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.categories_icon as icon',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name', 'categories_description.language_id')
		->where('parent_id', '0')->where('categories_description.language_id', '1')->paginate(10);
		
		return view("admin.listingCategories",$title)->with('listingCategories', $listingCategories);
	}
	
	//add category
	public function addCategory(Request $request){
		$title = array('pageTitle' => Lang::get("labels.AddCategories"));
		
		$result = array();
		$result['message'] = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		return view("admin.addCategory",$title)->with('result', $result);
	}
	
	//addNewCategory	
	public function addNewCategory(Request $request){
		
		$title = array('pageTitle' => Lang::get("labels.AddCategories"));
		
		$result = array();
		$date_added	= date('y-m-d h:i:s');
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
		
		//$categoryName = $request->categoryName;
		
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/category_images/', $fileName);
			$uploadImage = 'resources/assets/images/category_images/'.$fileName; 
		}	else{
			$uploadImage = '';
		}	
		
		if($request->hasFile('newIcon')){
			$icon = $request->newIcon;
			$iconName = time().'.'.$icon->getClientOriginalName();
			$icon->move('resources/assets/images/category_icons/', $iconName);
			$uploadIcon = 'resources/assets/images/category_icons/'.$iconName; 
		}	else{
			$uploadIcon = '';
		}	
		
		$categories_id = DB::table('categories')->insertGetId([
					'categories_image'   =>   $uploadImage,
					'date_added'		 =>   $date_added,
					'parent_id'		 	 =>   '0',
					'categories_icon'	 =>	  $uploadIcon
					]);
		
		//multiple lanugauge with record 
		foreach($languages as $languages_data){
			$categoryName= 'categoryName_'.$languages_data->languages_id;
				
			DB::table('categories_description')->insert([
					'categories_name'   =>   $request->$categoryName,
					'categories_id'     =>   $categories_id,
					'language_id'       =>   $languages_data->languages_id
				]);
		}		
				
		$message = Lang::get("labels.CategoriesAddedMessage");
				
		//return view('admin.addCategory', $title)->with('result', $result);
		return redirect()->back()->withErrors([$message]);
	}
	
	//editCategory
	public function editCategory(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.EditMainCategories"));
		$result = array();		
		$result['message'] = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		$editCategory = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image', 'categories.categories_icon as icon',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name', 'categories_description.language_id', 'categories_description.categories_description_id')
		->where('categories.categories_id', $request->id)->get();
		
		$result['editCategory'] = $editCategory;		
		
		return view("admin.editCategory", $title)->with('result', $result);
	}
	
	//updateCategory
	public function updateCategory(Request $request){
		
		$title = array('pageTitle' => Lang::get("labels.EditMainCategories"));
		$last_modified 	=   date('y-m-d h:i:s');
		
		$result = array();		
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
		
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/category_images/', $fileName);
			$uploadImage = 'resources/assets/images/category_images/'.$fileName; 
		}else{
			$uploadImage = $request->oldImage;
		}
		
		if($request->hasFile('newIcon')){
			$icon = $request->newIcon;
			$iconName = time().'.'.$icon->getClientOriginalName();
			$icon->move('resources/assets/images/category_icons/', $iconName);
			$uploadIcon = 'resources/assets/images/category_icons/'.$iconName; 
		}	else{
			$uploadIcon = $request->oldIcon;
		}
		
		
		DB::table('categories')->where('categories_id', $request->id)->update([
			'categories_image'   =>   $uploadImage,
			'last_modified'   	 =>   $last_modified,
			'categories_icon'    =>   $uploadIcon
			]);
		
		//multiple lanugauge with record 
		foreach($languages as $languages_data){
			$categories_description_id = 'categories_description_id_'.$languages_data->languages_id;
			$categoryName= 'categoryName_'.$languages_data->languages_id;
			//print_r($request->$categories_description_id);
			
			$checkexist = DB::table('categories_description')->where('categories_description_id','=',$request->$categories_description_id)->get();
			if(count($checkexist)>0){
				DB::table('categories_description')
					->where('categories_id', $request->id)
					->where('categories_description_id', $request->$categories_description_id)
					->update([
						'categories_name'   =>   $request->$categoryName,
					]);
			}else{
				DB::table('categories_description')->insert([
					'categories_name'   =>   $request->$categoryName,
					'categories_id'     =>   $request->id,
					'language_id'       =>   $languages_data->languages_id
				]);
			}
		}
		
		$message = Lang::get("labels.CategoriesUpdateMessage");
		return redirect()->back()->withErrors([$message]);
	}
	
	
	//delete category
	public function deleteCategory(Request $request){
		
		
		DB::table('categories')->where('categories_id', $request->id)->delete();
		DB::table('categories_description')->where('categories_id', $request->id)->delete();
		
		$listingCategories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name')
		->where('parent_id', '0')->get();
		
		$message = Lang::get("labels.CategoriesDeleteMessage");
				
		return redirect()->back()->withErrors([$message]);
	}
	
	
	
	//sub categories
	public function listingSubCategories(){
		$title = array('pageTitle' => Lang::get("labels.SubCategories"));
		
		$listingSubCategories = DB::table('categories as subCategories')
		->leftJoin('categories_description as subCategoryDesc','subCategoryDesc.categories_id', '=', 'subCategories.categories_id')
		
		->leftJoin('categories as mainCategory','mainCategory.categories_id', '=', 'subCategories.categories_id')
		->leftJoin('categories_description as mainCategoryDesc','mainCategoryDesc.categories_id', '=', 'mainCategory.parent_id')
		
		->select(
			'subCategories.categories_id as subId',
			'subCategories.categories_image as image',
			'subCategories.categories_icon as icon',
			'subCategories.date_added as date_added',
			'subCategories.last_modified as last_modified',
			'subCategoryDesc.categories_name as subCategoryName',
			'mainCategoryDesc.categories_name as mainCategoryName',
			'subCategoryDesc.language_id'
			)
		->where('subCategories.parent_id', '>', '0')->where('subCategoryDesc.language_id', '1')->where('mainCategoryDesc.language_id', '1')->orderBy('subId','ASC')->paginate(20);
		
		return view("admin.listingSubCategories",$title)->with('listingSubCategories', $listingSubCategories);
	}
	
	//addSubCategory
	public function addSubCategory(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.AddSubCategories"));
		$result = array();
		$result['message'] = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		$categories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as mainId', 'categories_description.categories_name as mainName')
		->where('parent_id', '0')->where('language_id','=', 1)->get();
		$result['categories'] = $categories;
		
		return view("admin.addSubCategory",$title)->with('result', $result);
	}
	
	
	//addNewSubCategory
	public function addNewSubCategory(Request $request){
		
		$title = array('pageTitle' => Lang::get("labels.AddSubCategories"));
		$date_added	= date('y-m-d h:i:s');
		$result = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
		
		$categoryName = $request->categoryName;
		$parent_id = $request->parent_id;
		
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/category_images/', $fileName);
			$uploadImage = 'resources/assets/images/category_images/'.$fileName; 
		}else{
			$uploadImage = '';
		}
		
		if($request->hasFile('newIcon')){
			$icon = $request->newIcon;
			$iconName = time().'.'.$icon->getClientOriginalName();
			$icon->move('resources/assets/images/category_icons/', $iconName);
			$uploadIcon = 'resources/assets/images/category_icons/'.$iconName; 
		}	else{
			$uploadIcon = '';
		}		
		
		$categories_id = DB::table('categories')->insertGetId([
					'categories_image'   =>   $uploadImage,
					'date_added'		 =>   $date_added,
					'parent_id'		 	 =>   $parent_id,
					'categories_icon'	 =>	  $uploadIcon
					]);
					
		//multiple lanugauge with record 
		foreach($languages as $languages_data){
			$categoryName= 'categoryName_'.$languages_data->languages_id;
				
			DB::table('categories_description')->insert([
					'categories_name'   =>   $request->$categoryName,
					'categories_id'     =>   $categories_id,
					'language_id'       =>   $languages_data->languages_id
				]);
		}	
		
				
		$categories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as mainId', 'categories_description.categories_name as mainName')
		->where('parent_id', '0')->get();
		$result['categories'] = $categories;
		
		$message = Lang::get("labels.AddSubCategoryMessage");
				
		return redirect()->back()->withErrors([$message]);
	}
	
	public function editSubCategory(Request $request){
		
		$title = array('pageTitle' => Lang::get("labels.EditSubCategories"));
		$result = array();
		$result['message'] = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		$editSubCategory = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image', 'categories.categories_icon as icon',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name', 'categories.parent_id as parent_id', 'categories_description.categories_description_id', 'categories_description.language_id')
		->where('categories.categories_id', $request->id)->get();
		
		$categories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as mainId', 'categories_description.categories_name as mainName')
		->where('parent_id', '0')->where('language_id','=', 1)->get();
		$result['editSubCategory'] = $editSubCategory;
		$result['categories'] = $categories;
		//print_r($editSubCategory);
		return view("admin.editSubCategory",$title)->with('result', $result);
	}
	
	
	//updateSubCategory
	public function updateSubCategory(Request $request){
		
		$title = array('pageTitle' => Lang::get("labels.EditSubCategories"));
		$result = array();
		$result['message'] = "Sub category has been updated.";
		$last_modified 	=   date('y-m-d h:i:s');
		$parent_id = $request->parent_id;
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
		
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/category_images/', $fileName);
			$uploadImage = 'resources/assets/images/category_images/'.$fileName; 
		}else{
			$uploadImage = $request->oldImage;
		}
		
		if($request->hasFile('newIcon')){
			$icon = $request->newIcon;
			$iconName = time().'.'.$icon->getClientOriginalName();
			$icon->move('resources/assets/images/category_icons/', $iconName);
			$uploadIcon = 'resources/assets/images/category_icons/'.$iconName; 
		}	else{
			$uploadIcon = $request->oldIcon;
		}
		
		DB::table('categories')->where('categories_id', $request->id)->update(
		[
			'categories_image'   =>   $uploadImage,
			'categories_icon'    =>   $uploadIcon,
			'last_modified'  	 =>   $last_modified,
			'parent_id' 		 =>   $parent_id
		]);
		
		
		//multiple lanugauge with record 
		foreach($languages as $languages_data){
			$categories_description_id = 'categories_description_id_'.$languages_data->languages_id;
			$categoryName= 'categoryName_'.$languages_data->languages_id;
			//print_r($request->$categories_description_id);
			$checkExist = DB::table('categories_description')->where('categories_description_id','=',$request->$categories_description_id)->get();
			if(count($checkExist)>0){
				DB::table('categories_description')
					->where('categories_id', $request->id)
					->where('categories_description_id', $request->$categories_description_id)
					->update([
						'categories_name'   =>   $request->$categoryName,
					]);
			}else{
				DB::table('categories_description')->insert([
					'categories_name'   =>   $request->$categoryName,
					'categories_id'     =>   $request->id,
					'language_id'       =>   $languages_data->languages_id
				]);	
			}
		}
		
		$message = Lang::get("labels.SubCategorieUpdateMessage");
		return redirect()->back()->withErrors([$message]);
		
	}
	
	//delete sub category
	public function deleteSubCategory(Request $request){
		
		DB::table('categories')->where('categories_id', $request->id)->delete();
		DB::table('categories_description')->where('categories_id', $request->id)->delete();
		
		$message = Lang::get("labels.SubCategorieDeleteMessage");
		return redirect()->back()->withErrors([$message]);
	}
}
