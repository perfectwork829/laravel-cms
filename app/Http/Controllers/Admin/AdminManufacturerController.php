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


class AdminManufacturerController extends Controller
{
	public function listingManufacturer(){
		$title = array('pageTitle' => Lang::get("labels.Manufacturers"));
		$listingManufacturers = DB::table('manufacturers')
		->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
		->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturers_image as image',  'manufacturers.manufacturers_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date')
		->where('manufacturers_info.languages_id', '1')->paginate(10);
		
		return view("admin.listingManufacturers",$title)->with('listingManufacturers', $listingManufacturers);
	}
	
	public function editManufacturer(Request $request){
		
		$title = array('pageTitle' => Lang::get("labels.EditManufacturers"));
		
		$manufacturers_id = $request->id;
		//print $manufacturers_id;
		$editManufacturer = DB::table('manufacturers')
		->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
		->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturers_image as image',  'manufacturers.manufacturers_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date')
		->where( 'manufacturers.manufacturers_id', $manufacturers_id )
		->get();
		
		return view("admin.editManufacturer",$title)->with('editManufacturer', $editManufacturer);
	}
	
	public function updateManufacturer(Request $request){
		
		$last_modified 	=   date('y-m-d h:i:s');		
		$title = array('pageTitle' => Lang::get("labels.EditManufacturers"));
		$languages_id = '1';
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/manufacturers_images/', $fileName);
			$uploadImage = 'resources/assets/images/manufacturers_images/'.$fileName; 
		}else{
			$uploadImage = $request->oldImage;
		}
		//print_r($request->id);
		
		DB::table('manufacturers')->where('manufacturers_id', $request->id)->update([
					'manufacturers_image'   =>   $uploadImage,
					'last_modified'			=>   $last_modified,
					'manufacturers_name' 	=>   $request->name
					]);
		DB::table('manufacturers_info')->where('manufacturers_id', $request->id)->update([
					'manufacturers_url'     =>     $request->manufacturers_url,
					'languages_id'			=>	   $languages_id,
					//'url_clicked'			=>	   $request->url_clicked
				]);
				
		$editCategory = DB::table('categories')
		->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
		->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.date_added as date_added', 'categories.last_modified as last_modified', 'categories_description.categories_name as name')
		->where('categories.categories_id', $request->id)->get();
		return redirect()->back()->withErrors([Lang::get("labels.ManufacturerUpdatedMessage")]);
	}
	
	
	public function addManufacturer(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.AddManufacturer"));
		return view("admin.addManufacturer",$title);
	}
		
	public function addNewManufacturer(Request $request){
		
		$languages_id 	=  '1';		
		$title = array('pageTitle' => Lang::get("labels.AddManufacturer"));
		$date_added	= date('y-m-d h:i:s');
		
		$validator = Validator::make(
			array(
					'name'    => $request->name,
					//'image'	  => $request->newImage
				), 
			array(
					'name'    => 'required',
					//'image'   => 'required',
				)
		);
		
		if($validator->fails()){
			return redirect('admin/addManufacturer')->withErrors($validator)->withInput();
		}else{
		
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/manufacturers_images/', $fileName);
			$uploadImage = 'resources/assets/images/manufacturers_images/'.$fileName; 
		}	else{
			$uploadImage = '';
		}	
		
		$manufacturers_id = DB::table('manufacturers')->insertGetId([
					'manufacturers_image'   =>   $uploadImage,
					'date_added'			=>   $date_added,
					'manufacturers_name' 	=>   $request->name
					]);
		DB::table('manufacturers_info')->insert([
					'manufacturers_id'  	=>     $manufacturers_id,
					'manufacturers_url'     =>     $request->manufacturers_url,
					'languages_id'			=>	   $languages_id,
					//'url_clicked'			=>	   $request->url_clicked
				]);
		return redirect()->back()->withErrors([Lang::get("labels.manuFacturerAddeddMessage")]);
		}
	}
	
	public function deleteManufacturer(Request $request){
		
		DB::table('manufacturers')->where('manufacturers_id', $request->manufacturers_id)->delete();
		DB::table('manufacturers_info')->where('manufacturers_id', $request->manufacturers_id)->delete();
		
		return redirect()->back()->withErrors([Lang::get("labels.manufacturersDeletedMessage")]);
	}
	
}
