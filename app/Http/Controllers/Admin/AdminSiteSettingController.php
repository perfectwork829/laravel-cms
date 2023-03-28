<?php

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

//for requesting a value 
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;


class AdminSiteSettingController extends Controller
{
	//listingOrderStatus
	public function listingOrderStatus(Request $request){
		$title = array('pageTitle' => Lang::get("labels.ListingOrderStatus"));		
		
		$result = array();
		
		$orders_status = DB::table('orders_status')
			->LeftJoin('languages', 'languages.languages_id','=', 'orders_status.language_id')
			->paginate(60);
		
		$result['orders_status'] = $orders_status;
		
		return view("admin.listingOrderStatus",$title)->with('result', $result);
	}
	
	//addOrderStatus
	public function addOrderStatus(Request $request){
		$title = array('pageTitle' => Lang::get("labels.AddOrderStatus"));
		$result = array();
		
		$languages = DB::table('languages')->get();		
		$result['languages'] = $languages;
		
		return view("admin.addOrderStatus",$title)->with('result', $result);
	}
		
	//addNewOrderStatus	
	public function addNewOrderStatus(Request $request){
		
		//total records
		$orders_status = DB::table('orders_status')->get();
		$orders_status_id = count($orders_status)+1;
		
		DB::table('orders_status')->insertGetId([
				'orders_status_id'		=>	$orders_status_id,
				'language_id'			=>	$request->language_id,
				'orders_status_name'	=>	$request->orders_status_name
				]);
								
		$message = Lang::get("labels.OrderStatusAddedMessage");
		return redirect()->back()->withErrors([$message]);
	}
	
	//editOrderStatus
	public function editOrderStatus(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.EditOrderStatus"));
		$result = array();		
		
		$orders_status = DB::table('orders_status')
			->LeftJoin('languages', 'languages.languages_id','=', 'orders_status.language_id')
			->where('orders_status_id','=', $request->id)
			->paginate(60);
			
		$result['orders_status'] = $orders_status;	
			
		$languages = DB::table('languages')->get();		
		$result['languages'] = $languages;
		
		return view("admin.editOrderStatus",$title)->with('result', $result);
	}
	
	//updateOrderStatus	
	public function updateOrderStatus(Request $request){
		
		$orders_status = DB::table('orders_status')->where('orders_status_id','=', $request->id)->update([
				'language_id'			=>	$request->language_id,
				'orders_status_name'	=>	$request->orders_status_name
				]);
		
		$message = Lang::get("labels.OrderStatusUpdatedMessage");
		return redirect()->back()->withErrors([$message]);
	}
	
	//deleteCountry
	public function deleteOrderStatus(Request $request){
		DB::table('orders_status')->where('orders_status_id', $request->id)->delete();
		return redirect()->back()->withErrors([Lang::get("labels.OrderStatusDeletedMessage")]);
	}
		
	//getlanguages
	public function getLanguages(){
		$languages = DB::table('languages')->get();
		return $languages;
	}
	
	//getsinglelanguages
	public function getSingleLanguages($language_id){
		$languages = DB::table('languages')->get();
		return $languages;
	}
	
	//listingLanguages
	public function listingLanguages(Request $request){
		$title = array('pageTitle' => Lang::get("labels.ListingLanguages"));		
		
		$result = array();
		
		$languages = DB::table('languages')
			->paginate(60);
		
		$result['languages'] = $languages;
		
		return view("admin.listingLanguages",$title)->with('result', $result);
	}
	
	//addLanguages
	public function addLanguages(Request $request){
		$title = array('pageTitle' => Lang::get("labels.AddLanguage"));		
		return view("admin.addLanguages",$title);
	}
		
	//addNewLanguages	
	public function addNewLanguages(Request $request){
		
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/language_flags/', $fileName);
			$uploadImage = 'resources/assets/images/language_flags/'.$fileName; 
		}	else{
			$uploadImage = '';
		}	
		
		DB::table('languages')->insertGetId([
				'name'			=>	$request->name,
				'code'			=>	$request->code,
				'image'			=>	$uploadImage,
				'directory'		=>	$request->directory,
				'direction'		=>	$request->direction
				]);
								
		$message = Lang::get("labels.languageAddedMessage");
		return redirect()->back()->withErrors([$message]);
	}
	
	//editOrderStatus
	public function editLanguages(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.EditLanguage"));
		
		$languages = DB::table('languages')->where('languages_id','=', $request->id)->get();
		
		$result['languages'] = $languages;
		
		return view("admin.editLanguages",$title)->with('result', $result);
	}
	
	//updateOrderStatus	
	public function updateLanguages(Request $request){
		
		if($request->hasFile('newImage')){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/language_flags/', $fileName);
			$uploadImage = 'resources/assets/images/language_flags/'.$fileName; 
		}	else{
			$uploadImage = $request->oldImage;
		}	
		
		$orders_status = DB::table('languages')->where('languages_id','=', $request->id)->update([
				'name'			=>	$request->name,
				'code'			=>	$request->code,
				'image'			=>	$uploadImage,
				'directory'		=>	$request->directory,
				'direction'		=>	$request->direction
				]);
		
		$message = Lang::get("labels.languageEditMessage");
		return redirect()->back()->withErrors([$message]);
	}
	
	//deletelanguage
	public function deleteLanguage(Request $request){
		DB::table('languages')->where('languages_id', $request->id)->delete();
		return redirect()->back()->withErrors([Lang::get("labels.languageDeleteMessage")]);
	}
	
	
	//setting page
	public function setting(Request $request){
		$title = array('pageTitle' => Lang::get("labels.setting"));		
		
		$result = array();
		
		$setting = DB::table('setting')->get();
		
		$result['setting'] = $setting;
		return view("admin.setting",$title)->with('result', $result);
	}
	
	//setting page
	public function getSetting(){
		$setting = DB::table('setting')->get();
		return $setting;
	}
	
	
	//update setting	
	public function updateSetting(Request $request){
		
		/*if($request->hasFile('app_logo')){
			$image = $request->app_logo;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/site_images/', $fileName);
			$uploadImage = 'resources/assets/images/site_images/'.$fileName; 
		}else{
			$uploadImage = $request->oldImage;
		}*/	
		
		
		$orders_status = DB::table('setting')->where('setting_id','=', $request->setting_id)->update([
				'facebook_app_id'			=>	$request->facebook_app_id,
				'facebook_secret_id'		=>	$request->facebook_secret_id,
				'fcm_desktop'				=>	$request->fcm_desktop,
				'fcm_ios'					=>	$request->fcm_ios,
				'fcm_android'				=>	$request->fcm_android,
				'address'					=>	$request->address,
				'city'						=>	$request->city,
				'contact_us_email'			=>	$request->contact_us_email,
				'state'						=>	$request->state,
				'country'					=>	$request->country,
				'zip'						=>	$request->zip,
				'phone_no'					=>	$request->phone_no,
				'latitude'					=>	$request->latitude,
				'longitude'					=>	$request->longitude,
				'fcm_android_sender_id'		=>	$request->fcm_android_sender_id,
				'fcm_ios_sender_id'			=>	$request->fcm_ios_sender_id,
				'app_name'					=>	$request->app_name,
				'currency_symbol'			=>	$request->currency_symbol,
				'new_product_duration'		=>	$request->new_product_duration,
				'notification_title'		=>	$request->notification_title,
				'notification_text'			=>	$request->notification_text,
				'lazzy_loading_effect'		=>	$request->lazzy_loading_effect,
				'footer_button'				=>	$request->footer_button,
				'cart_button'				=>	$request->cart_button,
				//'app_logo'					=>	$uploadImage,
				'featured_category'			=>	$request->featured_category,
				'notification_duration'		=>	$request->notification_duration,
				'wish_list_page'			=>	$request->wish_list_page,
				'edit_profile_page'			=>	$request->edit_profile_page,
				'shipping_address_page'		=>	$request->shipping_address_page,
				'my_orders_page'			=>	$request->my_orders_page,
				'contact_us_page'			=>	$request->contact_us_page,
				'about_us_page'				=>	$request->about_us_page,
				'news_page'					=>	$request->news_page,
				'intro_page'				=>	$request->intro_page,
				'setting_page'				=>	$request->setting_page,
				'home_style'				=>	$request->home_style,
				'site_url'					=>	$request->site_url,
				'admob'						=>	$request->admob,
				'admob_id'					=>	$request->admob_id,
				'ad_unit_id_banner'			=>	$request->ad_unit_id_banner,
				'ad_unit_id_interstitial'	=>	$request->ad_unit_id_interstitial,			
				'package_name'				=>	$request->package_name,
				'category_style'			=>	$request->category_style,
				'google_analytic_id'		=>	$request->google_analytic_id,
				'share_app'					=>	$request->share_app,
				'rate_app'					=>	$request->rate_app,
				'google_login'				=>	$request->google_login,
				'facebook_login'			=>	$request->facebook_login,
				]);
		
		$message = Lang::get("labels.SettingUpdateMessage");
		return redirect()->back()->withErrors([$message]);
	}
	
}
