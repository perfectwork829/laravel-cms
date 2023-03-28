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


class AdminNotificationController extends Controller
{
	//listingDevices
	public function listingDevices(Request $request){
		$title = array('pageTitle' => Lang::get("labels.ListingDevices"));		
		
		$result = array();
		$message = array();
		$errorMessage = array();
		
		if(!empty($request->id)){
			if($request->active=='no'){
				$status = '0';
			}elseif($request->active=='yes'){
				$status = '1';
			}
			
			DB::table('devices')->where('id', '=', $request->id)->update([
				'status'		 =>	  $status
				]);	
		}
		
		if(isset($request->filter) and !empty($request->filter)){
			$devices = DB::table('devices')
				->LeftJoin('customers', 'customers.customers_id','=', 'devices.customers_id')
				->where('device_type','=', $request->filter)
				->where('devices.is_notify','=', '1')
				->orderBy('id','DESC')
				->paginate(100);
		}else{
			$devices = DB::table('devices')
				->LeftJoin('customers', 'customers.customers_id','=', 'devices.customers_id')
				->orderBy('id','DESC')
				->where('devices.is_notify','=', '1')
				->paginate(100);
		}
				
		$result['message'] = $message;
		$result['devices'] = $devices;
		
		return view("admin.listingDevices",$title)->with('result', $result);
	}
	
	//viewDevices
	public function viewDevices(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.ViewDevice"));
		$result = array();		
		$result['message'] = array();
		
		$devices = DB::table('devices')
			->LeftJoin('customers', 'customers.customers_id','=', 'devices.customers_id')
			->where('devices.id', $request->id)
			->get();	
		
		$result['devices'] = $devices;	
		return view("admin.viewDevices",$title)->with('result', $result);
	}
	
		
	//notifyUser
	public function notifyUser(Request $request){
		$device_type 	= 	$request->device_type;
		$device_id 		= 	$request->device_id;
		$message 		= 	$request->message;
		$title 			= 	$request->title;
		
		$sendData = array
				  (
					'body' 	=> $message,
					'title'	=> $title ,
							'icon'	=> 'myicon',/*Default Icon*/
							'sound' => 'mySound'/*Default sound*/
				  );
		
		$response = $this->fcmNotification($device_id, $sendData);				
		return $response;
	}
	
	
	//notifications
	public function notifications(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.SendNotifications"));
		$result = array();		
		$result['message'] = array();
		
		$devices = DB::table('devices')
			->LeftJoin('customers', 'customers.customers_id','=', 'devices.customers_id')
			->where('devices.is_notify','=', '1')
			->groupBy('devices.customers_id')
			->orderBy('devices.register_date', 'desc')
			->get();	
		
		$result['devices'] = $devices;	
		return view("admin.notifications", $title)->with('result', $result);
	}

	
	//sendNotification
	public function sendNotifications(Request $request){
		$device_type 		= 	$request->device_type;
		$devices_status 	= 	$request->devices_status;
		$message 			= 	$request->message;
		$title 				= 	$request->title;
		
		$sendData = array
				  (
				'body' 	=> $message,
				'title'	=> $title ,
						'icon'	=> 'myicon',/*Default Icon*/
						'sound' => 'mySound'/*Default sound*/
				  );	
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$setting = $myVar->getSetting();
		
		if($device_type =='all'){ 	/* to all users notification */
			
			$devices = DB::table('devices')
						->where('status','=', $devices_status)
						->where('devices.is_notify','=', '1')
						->get();
			
			foreach($devices as $devices_data){					
				$response[] = $this->fcmNotification($devices_data->device_id, $sendData);
			}
					
			
		}else if($device_type =='1'){    /* apple notification */			
			
			$devices = DB::table('devices')
							->select('devices.device_id')
							->where('status','=', $devices_status)
							->where('devices.is_notify','=', '1')
							->where('device_type','=', $device_type)
							->get();
						
			foreach($devices as $devices_data){
				
				$response[] = $this->fcmNotification($devices_data->device_id, $sendData);
			}
			
		}else if($device_type =='2'){ 	/* android notification */
		
			$devices = DB::table('devices')
							->select('devices.device_id')
							->where('status','=', $devices_status)
							->where('devices.is_notify','=', '1')
							->where('device_type','=', $device_type)
							->get();
			
						
			foreach($devices as $devices_data){
				$response[] = $this->fcmNotification($devices_data->device_id, $sendData);
			}
			
						
		}
		
		if(in_array('1', $response)){
			$message = 'sent';
		}else{
			$message = 'error';	
		}
		
		if ($message == 'sent'){	
			return redirect()->back()->withErrors([Lang::get("labels.notificationSendMessage")]);
		}elseif ($message == 'error'){	
			return redirect()->back()->withErrors([Lang::get("labels.notificationSendMessageError")]);
		}
	}
	
	//customerNotification
	public function customerNotification(Request $request){
		
		$devices = DB::table('devices')
					->leftJoin('customers','customers.customers_id','=','devices.customers_id')
					->select('devices.*','customers.customers_firstname','customers.customers_lastname')
					->where('devices.customers_id','=', $request->customers_id)
					->where('devices.is_notify','=', '1')
					->orderBy('register_date','DESC')->take(1)->get();
		
		return view("admin/customerNotificationForm")->with('devices', $devices);
	}
	
	
	//deleteTaxRate
	public function deletedevice(Request $request){
		DB::table('devices')->where('device_id', $request->id)->delete();
		return redirect()->back()->withErrors([Lang::get("labels.DeviceDeletedMessage")]);
	}
	
	public function fcmNotification($device_id, $sendData){
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$setting = $myVar->getSetting();
		
		#API access key from Google API's Console
		if (!defined('API_ACCESS_KEY')){
			define('API_ACCESS_KEY', $setting[0]->fcm_android);
		}
				
		$fields = array
				(
					'to'		=> $device_id,
					'notification'	=> $sendData
				);


		$headers = array
				(
					'Authorization: key=' . API_ACCESS_KEY,
					'Content-Type: application/json'
				);
		#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, true );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch);
		$data = json_decode($result);
		if($result === false)
		die('Curl failed ' . curl_error());

		curl_close($ch);

		if(!empty($data->success) and $data->success >= 1){
			$response = '1';
		}else{
			$response = '0';	
		}	
		
		print $response;
		
	}
}
