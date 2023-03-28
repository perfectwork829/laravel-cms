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

use Mail;
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


class AdminAppLabelsController extends Controller
{
	
	//listingAppLabels
	public function listingAppLabels(Request $request){
		$title = array('pageTitle' => Lang::get("labels.ListingLabels"));	
		
		$language_id = '1';	
		
		$result = array();
		$message = array();
			
		$labels = DB::table('labels')
			->leftJoin('label_value','label_value.label_id','=','labels.label_id')
			->where('language_id','=', $language_id)
			->paginate(20);
		
		$result['message'] = $message;
		$result['labels']  = $labels;
		//print_r($result['labels']);
		return view("admin.listingAppLabels", $title)->with('result', $result);
	}
	
	//addAppLabel
	public function manageAppLabel(Request $request){
		$title = array('pageTitle' => Lang::get("labels.ManageLabel"));
		
		$result = array();
		$message = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		$alllabels = DB::table('labels')->get();
		$totalRecord = count($alllabels);
		//$totalRecord = 100;
		
		//print($totalRecord);
		
		$rem = $totalRecord/50;
		//print '<br>divided record: '.$rem;
		
		$arr = explode('.',trim($rem));
		
		if(is_float($rem)){
			$numberVal = $arr[0];
			$numberVal+=1;
			//$lastRem = $totalRecord - ($arr[0]*50);
		}else{
			$numberVal = $arr[0];
		}
		
		//print '<br> '.$numberVal;
		
		$i=1;
		$start = 0;
		$end = 49;
		$data  = array();
		while($i <= $numberVal){
			$labels = DB::table('labels')->skip($start)->take(50)->orderby('label_id','ASC')->get();
			
			$myVal  = array();
			$index = 0;
			foreach($labels as $labels_data){
				array_push($myVal,$labels_data);
				
				$values = DB::table('label_value')
						->leftJoin('languages','languages.languages_id','=','label_value.language_id')
						->select('languages.name', 'label_value.*')
						->where('label_id','=',$labels_data->label_id)
						->orderBy('label_value.language_id','ASC')
						->get();
				
				//print_r($labels);
				$myVal[$index++]->values = $values;
			}
				//print_r($result);
			$start +=50;
			$data[$i] = $myVal;
			$i++;
		}
			//print_r($data);
		
		//$labels = DB::table('labels')->get();
		
		
		
//		$data  = array();
//		$index = 0;
//		foreach($labels as $labels_data){
//			array_push($data,$labels_data);
//			
//			$values = DB::table('label_value')
//					->leftJoin('languages','languages.languages_id','=','label_value.language_id')
//					->select('languages.name', 'label_value.*')
//					->where('label_id','=',$labels_data->label_id)
//					->orderBy('label_value.language_id','ASC')
//					->get();
//			
//			$data[$index++]->values = $values;
//		}
//			//print_r($data);
//		
		$result['labels'] = $data;
		//print_r($result['labels']);
		//print '<br><br>';
		foreach ($result['labels'] as $lab_data){
			foreach ($lab_data as $labels_data){
				//print_r($labels_data->label_name);
				//print '<br><br>';
				//$labels_trans = $labels_data->toArray();
				//print_r($labels_data);
				//print '<br><br>';
				//print_r($labels_data->values);
				
//				foreach ($labels_data->values as $labels_trans){
//					//foreach ($labels_trans as $labels_content){
//						print_r($labels_trans->label_value);
//						print '<br><br>';
//					//}
//				}
			}
		}
			
//		
		return view("admin.manageAppLabel", $title)->with('result', $result);
	}
	
	//addAppKey
	public function addAppKey(Request $request){
		$title = array('pageTitle' => Lang::get("labels.AddKeyLabel"));
		
		$result = array();
		$message = array();
				
		/*$labels = DB::table('labels')->get();
		$result['labels'] = $labels;*/
		
		return view("admin.addAppKey", $title)->with('result', $result);
	}
	
	//addNewAppLabel	
	public function addNewAppLabel(Request $request){
		
		$label_name = $request->label_name;
		
		$checkExist = DB::table('labels')->where('label_name','=',$label_name)->get();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
		
		if(count($checkExist)>0){
			
			$message = Lang::get("labels.Labelkeyalreadyexist");
			return redirect()->back()->withErrors([$message]);
			
		}else{
			
			DB::table('labels')->insert([
							'label_name'  	=>   $request->label_name
							]);
			
			return redirect()->back()->with('message', Lang::get("labels.LabelkeyAddedMessage"));
					
		}
		
	}
	
	//editTaxClass
	public function editAppLabel(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.EditLabel"));
				
		$result = array();
		$message = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		$labels = DB::table('labels')->get();
		$result['labels'] = $labels;
		
		$labels_value = DB::table('labels')
				->leftJoin('label_value','label_value.label_id','=','labels.label_id')
				->where('labels.label_id', '=', $request->id)
				->orderBy('label_value.label_id','ASC')
				->get();
				
		$result['labels_value'] = $labels_value;
		return view("admin.editAppLabel",$title)->with('result', $result);
	}
	
	
	//updateAppLabel
	public function updateAppLabel(Request $request){
	
		
		$title = array('pageTitle' => Lang::get("labels.EditLabel"));
		$last_modified 	=   date('y-m-d h:i:s');
		
		$result = array();		
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();
				
		$labels = DB::table('labels')->get();
		
		foreach($labels as $labels_data){
			
			$label	 =	 'label_id_'.$labels_data->label_id;
			$label_id 		= $request->$label;
			
			foreach($languages as $languages_data){
				
				$label_id 		= $request->$label;
				$label_value    = 'label_value_'.$languages_data->languages_id.'_'.$label_id;
				
				$checkexist = DB::table('label_value')->where('label_id','=',$label_id)->where('language_id','=',$languages_data->languages_id)->get();
				if(count($checkexist)>0){
					DB::table('label_value')
						->where('label_id', $label_id)
						->where('language_id', $languages_data->languages_id)
						->update([
							'label_value'   =>   $request->$label_value,
						]);
				}else{
					DB::table('label_value')->insert([
						'label_value'   	=>   $request->$label_value,
						'label_id'     		=>   $label_id,
						'language_id'       =>   $languages_data->languages_id
					]);
				}
			}
		
		}
		
		return redirect()->back()->with('message', Lang::get("labels.LabelkeyUpdatedMessage"));
	
	}
	
	//deleteCountry
	public function deleteBanner(Request $request){
		DB::table('banners')->where('banners_id', $request->banners_id)->delete();
		return redirect()->back()->withErrors([Lang::get("labels.BannerDeletedMessage")]);
	}
}
