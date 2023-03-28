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

use Mail;

//for authenitcate login data
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

//for requesting a value 
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

//for Carbon a value 
use Carbon;

class AppSettingController extends Controller
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
	
	public function getLanguages(){
		$languages = DB::table('languages')->get();
		
		$responseData = array('success'=>'1', 'languages'=>$languages,  'message'=>"Returned all languages.");
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
	}
	
	
	//get Setting
	public function getSetting(){
		$setting = DB::table('setting')->get();
		return $setting;
	}
	
	//get Setting
	public function siteSetting(){
		$setting = $this->getSetting();
		$responseData = array('success'=>'1', 'data'=>$setting,  'message'=>"Returned all site data.");
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
	}
	
	//get Setting
	public function contactUs(Request $request){
		
		$name 		=  $request->name;
		$email 		=  $request->email;
		$message 	=  $request->message;
		
		$setting = $this->getSetting();
		$data = array('name'=>$name, 'email'=>$email, 'message'=>$message, 'adminEmail'=>$setting[0]->contact_us_email);
		
		$responseData = array('success'=>'1', 'data'=>'',  'message'=>"Message has been sent successfully!");
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
		
		Mail::send('/mail/contactUs', ['data' => $data], function($m) use ($data){
				$m->to($data['adminEmail'])->subject('Ecommerce App contact us')->getSwiftMessage()
				->getHeaders()
				->addTextHeader('x-mailgun-native-send', 'true');	
			});
		
		
	}
		
	
	//applabels
	public function appLabels(Request $request){
		
		$language_id 		=  $request->lang;
				
		$labels = DB::table('labels')
			->leftJoin('label_value','label_value.label_id','=','labels.label_id')
			->where('language_id','=', $language_id)
			->get();
			
		$result = array();
		foreach($labels as $labels_data){
			$result[$labels_data->label_name] = $labels_data->label_value;
		}
		
		$responseData = array('success'=>'1', 'labels'=>$result,  'message'=>"Returned all site labels.");
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
	}
	
	//applabels3
	public function appLabels3(Request $request){
		
		$language_id 		=  $request->lang;
				
		$labels = DB::table('labels')
			->leftJoin('label_value','label_value.label_id','=','labels.label_id')
			->where('language_id','=', $language_id)
			->get();
			
		$result = array();
		foreach($labels as $labels_data){
			$result[$labels_data->label_name] = $labels_data->label_value;
		}
		
		$categoryResponse = json_encode($result);
		print $categoryResponse;
	}
	
}
