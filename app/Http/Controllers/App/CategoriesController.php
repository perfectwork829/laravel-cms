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
use App\Administrator;

//for authenitcate login data
use Auth;

//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//for requesting a value 
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class CategoriesController extends Controller
{
	public function getMainCategories($language_id){
		//$language_id     =   $language_id;
		
		$getCategories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name')
		->where('parent_id', '0')->where('categories_description.language_id', $language_id)->get();
		return($getCategories) ;
	}
	
	public function getCategories(Request $request){
		$language_id 	 = '1';
		
		if(empty($request->category_id)){
			$category_id	= '0';
		}else{
			$category_id	=   $request->category_id;
		}
		
		$getCategories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name')
		->where('parent_id', $category_id)->where('categories_description.language_id', $language_id)->get();
		return($getCategories) ;
	}
	
	public function listingCategories(){
		$title = array('pageTitle' => 'Main Categories');
		$listingCategories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name')
		->where('parent_id', '0')->get();
		//print $this->getCategories();
		$listingCategories[] = $listingCategories[0];
		return view("admin.listingCategories",$title)->with('listingCategories', $listingCategories);
	}
	
	
	
	public function updateCategory(Request $request){
		
		$title = array('pageTitle' => 'Main Categories');
		$last_modified 	=   date('y-m-d h:i:s');
		
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/category_images/', $fileName);
			$uploadImage = 'resources/assets/images/category_images/'.$fileName; 
		}else{
			$uploadImage = $request->oldImage;
		}
		
		
		DB::table('categories')->where('categories_id', $request->id)->update(['categories_image'   =>   $uploadImage, 'last_modified'   =>   $last_modified]);
		DB::table('categories_description')->where('categories_id', $request->id)->update(['categories_name'   =>   $request->categoryName]);
		
		$editCategory = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name')
		->where('categories.categories_id', $request->id)->get();
		//print_r($editCategory);
		return redirect('admin/editCategory/'.$request->id)->with('success', 'You are registered successfully');
		//==return view("admin.editCategory",$title)->with('editCategory', $editCategory);
	}
	
	
	public function addCategory(Request $request){
		
		$title = array('pageTitle' => 'Add Categories');
		return view("admin.addCategory",$title);
	}
		
	public function addNewCategory(Request $request){
		
		$title = array('pageTitle' => 'Add Categories');
		$date_added	= date('y-m-d h:i:s');
		$categoryName = $request->categoryName;
		
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/category_images/', $fileName);
			$uploadImage = 'resources/assets/images/category_images/'.$fileName; 
		}	else{
			$uploadImage = '';
		}	
		
		$categories_id = DB::table('categories')->insertGetId([
					'categories_image'   =>   $uploadImage,
					'date_added'		 =>   $date_added,
					'parent_id'		 	 =>   '0'
					]);
		DB::table('categories_description')->insert([
					'categories_name'   =>   $request->categoryName,
					'categories_id'     =>     $categories_id
				]);
		
		return view('admin.addCategory', $title)->with('success', 'Category has been added successfully');
	}
	
	public function deleteCategory(Request $request){
		
		$title = array('pageTitle' => 'Main Categories');
		
		DB::table('categories')->where('categories_id', $request->id)->delete();
		DB::table('categories_description')->where('categories_id', $request->id)->delete();
		
		$listingCategories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name')
		->where('parent_id', '0')->get();
		//print_r($mainCategories);
		return redirect('admin/listingCategories');
		//return reditrect("admin.listingCategories",$title)->with('listingCategories', $listingCategories);
	}
	
	
	
	//sub categories
	public function listingSubCategories(){
		$title = array('pageTitle' => 'Sub Categories');
		
		$listingSubCategories = DB::table('categories as subCategories')
		->leftJoin('categories_description as subCategoryDesc','subCategoryDesc.categories_id', '=', 'subCategories.categories_id')
		
		->leftJoin('categories as mainCategory','mainCategory.categories_id', '=', 'subCategories.categories_id')
		->leftJoin('categories_description as mainCategoryDesc','mainCategoryDesc.categories_id', '=', 'mainCategory.parent_id')
		
		->select(
			'subCategories.categories_id as subId',
			'subCategories.categories_image as image',
			'subCategories.date_added as date_added',
			'subCategories.last_modified as last_modified',
			'subCategoryDesc.categories_name as subCategoryName',
			'mainCategoryDesc.categories_name as mainCategoryName'
			)
		->where('subCategories.parent_id', '>', '0')->get();
		//print_r($listingSubCategories);
		return view("admin.listingSubCategories",$title)->with('listingSubCategories', $listingSubCategories);
	}
	
	//addSubCategory
	public function addSubCategory(Request $request){		
		$title = array('pageTitle' => 'Add Sub Categories');
		
		$categories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as mainId', 'categories_description.categories_name as mainName')
		->where('parent_id', '0')->get();
		
		return view("admin.addSubCategory",$title)->with('categories', $categories);
	}
	
	
	//addNewCategory
	public function addNewSubCategory(Request $request){
		
		$title = array('pageTitle' => 'Add Sub Categories');
		$date_added	= date('y-m-d h:i:s');
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
		
		$categories_id = DB::table('categories')->insertGetId([
					'categories_image'   =>   $uploadImage,
					'date_added'		 =>   $date_added,
					'parent_id'		 	 =>   $parent_id
					]);
		DB::table('categories_description')->insert([
					'categories_name'   =>   $request->categoryName,
					'categories_id'     =>     $categories_id
				]);
				
		$categories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as mainId', 'categories_description.categories_name as mainName')
		->where('parent_id', '0')->get();
		
		return view('admin.addSubCategory', $title)->with('categories', $categories);
	}
	
	public function editSubCategory(Request $request){
		
		$title = array('pageTitle' => 'Sub Categories');
		
		$editSubCategory = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name')
		->where('categories.categories_id', $request->id)->get();
		
		$categories = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as mainId', 'categories_description.categories_name as mainName')
		->where('parent_id', '0')->get();
		
		$editSubCategory['categories'] = $categories;
		
		return view("admin.editSubCategory",$title)->with('editSubCategory', $editSubCategory);
	}
	
	
	//updateCategory
	public function updateSubCategory(Request $request){
		
		$title = array('pageTitle' => 'Main Categories');
		$last_modified 	=   date('y-m-d h:i:s');
		$parent_id = $request->parent_id;
		
		
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/category_images/', $fileName);
			$uploadImage = 'resources/assets/images/category_images/'.$fileName; 
		}else{
			$uploadImage = $request->oldImage;
		}
		
		
		DB::table('categories')->where('categories_id', $request->id)->update(['categories_image'   =>   $uploadImage, 'last_modified'   =>   $last_modified, 'parent_id' => $parent_id]);
		DB::table('categories_description')->where('categories_id', $request->id)->update(['categories_name'   =>   $request->categoryName]);
		
		$editCategory = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name')
		->where('categories.categories_id', $request->id)->get();
		
		return redirect('admin/editSubCategory/'.$request->id)->with('success', 'You are registered successfully');
	}
	
	//delete sub category
	public function deleteSubCategory(Request $request){
		
		$title = array('pageTitle' => 'Main Categories');
		
		DB::table('categories')->where('categories_id', $request->id)->delete();
		DB::table('categories_description')->where('categories_id', $request->id)->delete();
		
		//print_r($mainCategories);
		return redirect('admin/listingSubCategories');
		//return reditrect("admin.listingCategories",$title)->with('listingCategories', $listingCategories);
	}
}
