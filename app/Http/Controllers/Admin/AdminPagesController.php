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
use App;
use Lang;
//for authenitcate login data
use Auth;

//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//for requesting a value 
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;

class AdminPagesController extends Controller
{
	
	public function listingPages(Request $request){
		$title 			= array('pageTitle' => Lang::get("labels.Pages"));
		$language_id    =   '1';		
		
		$pages = DB::table('pages')
			->leftJoin('pages_description', 'pages_description.page_id', '=', 'pages.page_id')
			->where('pages_description.language_id','=', $language_id)
			->orderBy('pages.page_id', 'ASC')
			->paginate(20);
		
		$result["pages"] = $pages;
		
		
		return view("admin.listingPages",$title)->with('result', $result);
	}
	
	public function addPage(Request $request){
	
		$title = array('pageTitle' => Lang::get("labels.AddPage"));
		$language_id      =   '1';
		
		$result = array();
		
		//get function from other controller
		$myVar = new AdminNewsCategoriesController();
		$result['newsCategories'] = $myVar->getNewsCategories($language_id);
				
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		//print_r($result);
		return view("admin.addPage", $title)->with('result', $result);
	}
	
	//addNewPage
	public function addNewPage(Request $request){
		$title = array('pageTitle' => Lang::get("labels.AddPage"));	
		
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
		
		$slug = str_replace(' ','-' ,trim($request->slug));
		$slug = str_replace('_','-' ,$slug);
		
		$page_id = DB::table('pages')->insertGetId([
					'slug'		 			 =>   $slug,
					]);
		
		foreach($languages as $languages_data){
			$name = 'name_'.$languages_data->languages_id;
			$description = 'description_'.$languages_data->languages_id;
			
			DB::table('pages_description')->insert([
					'name'  	    		 =>   $request->$name,
					'language_id'			 =>   $languages_data->languages_id,
					'page_id'				 =>   $page_id,
					'description'			 =>   addslashes($request->$description)
					]);
		}	
		
				
		$message = Lang::get("labels.PageAddedMessage");				
		return redirect()->back()->withErrors([$message]);
	}
		
	//editnew
	public function editPage(Request $request){
		$title = array('pageTitle' => Lang::get("labels.EditPage"));
		$language_id      =   '1';	
		$page_id     	  =   $request->id;	
		
		$result = array();
				
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
				
		$pages = DB::table('pages')
			->leftJoin('pages_description', 'pages_description.page_id', '=', 'pages.page_id')
			->select('pages.*','pages_description.description','pages_description.language_id','pages_description.name' ,'pages_description.page_description_id')
			->where('pages.page_id','=', $page_id)
			->get();
		
		$result['editPage'] = $pages;
		
		//print_r($result['editPage']);
		return view("admin.editPage", $title)->with('result', $result);		
	}
	
	
	//updatePage
	public function updatePage(Request $request){
		
		$page_id      =   $request->id;	
			
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
		
		$slug = str_replace(' ','-' ,trim($request->slug));
		$slug = str_replace('_','-' ,$slug);
		
		DB::table('pages')->where('page_id','=',$page_id)->update([
					'slug'		 			 =>   $slug,
					]);
		
		
		foreach($languages as $languages_data){
			$name = 'name_'.$languages_data->languages_id;
			$description = 'description_'.$languages_data->languages_id;
			
			$checkExist = DB::table('pages_description')->where('page_id','=',$page_id)->where('language_id','=',$languages_data->languages_id)->get();
			
			if(count($checkExist)>0){
				DB::table('pages_description')->where('page_id','=',$page_id)->where('language_id','=',$languages_data->languages_id)->update([
					'name'  	    		 =>   $request->$name,
					'language_id'			 =>   $languages_data->languages_id,
					'description'			 =>   addslashes($request->$description)
					]);
			}else{
				DB::table('pages_description')->insert([
					'name'  	    		 =>   $request->$name,
					'language_id'			 =>   $languages_data->languages_id,
					'page_id'				 =>   $page_id,
					'description'			 =>   addslashes($request->$description)
					]);
			}
		}
		
		
		$message = Lang::get("labels.PageUpdateMessage");				
		return redirect()->back()->withErrors([$message]);
		
	}
	
		
	//pageStatus
	public function pageStatus(Request $request){
		
	if(!empty($request->id)){
		if($request->active=='no'){
			$status = '0';
		}elseif($request->active=='yes'){
			$status = '1';
		}
		DB::table('pages')->where('page_id', '=', $request->id)->update([
			'status'		 =>	  $status
			]);	
		}
		
		return redirect()->back()->withErrors([Lang::get("labels.PageStatusMessage")]);
	}
	
	
	
	
	
}
