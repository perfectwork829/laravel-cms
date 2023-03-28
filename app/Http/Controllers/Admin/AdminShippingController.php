<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

//validator is builtin class in laravel
use Validator;
use App;
use Lang;
use DB;
use App\Administrator;

//for authenitcate login data
use Auth;


//for requesting a value 
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;


class AdminShippingController extends Controller
{
	public function upsData(){
		
		$ups_shipping = DB::table('ups_shipping')->where('ups_id', '=', '1')->get();
		$result['ups_shipping'] = $ups_shipping;
		return ($ups_shipping);
		
	}
	
	//shippingMethods
	public function shippingMethods(Request $request){
		$title = array('pageTitle' => Lang::get("labels.ShippingMethods"));		
		
		if(!empty($request->id)){
			if($request->active=='no'){
				$status = '0';
			}elseif($request->active=='yes'){
				$status = '1';
			}
			DB::table('shipping_methods')->where('shipping_methods_id', '=', $request->id)->update([
				'status'		 =>	  $status
				]);	
		}
		
		$shipping_methods = DB::table('shipping_methods')->paginate(10);
		$result['shipping_methods'] = $shipping_methods;
		
		//ups data
		$ups_shipping = $this->upsData();
		$result['ups_shipping'] = $ups_shipping;
		
		//flatrate
		$flate_rate = DB::table('flate_rate')->get();
		$result['flate_rate'] = $flate_rate;
					
		return view("admin.shippingMethods", $title)->with('result', $result);
	}
	
	//upsShipping
	public function upsShipping(Request $request){
		$title = array('pageTitle' => Lang::get("labels.UPSShipping"));
		$pickupType = '01';
			
		//ups data
		$ups_shipping = $this->upsData();
		$result['ups_shipping'] = $ups_shipping;
		
		$countries = DB::table('countries')->get();
		$result['countries'] = $countries;
		
		$shipping_methods = DB::table('shipping_methods')->where('shipping_methods_id', '=', '1')->get();
		$result['shipping_methods'] = $shipping_methods;
		
		return view("admin.upsShipping", $title)->with('result', $result);
	}
	
	
	//flateRate
	public function flateRate(Request $request){
		$title = array('pageTitle' => Lang::get("labels.FlateRate"));
		$pickupType = '01';
		
		$shipping_methods = DB::table('flate_rate')->where('id', '=', '1')->get();
		$result['flate_rate'] = $shipping_methods;
		
		$shipping_methods = DB::table('shipping_methods')->where('shipping_methods_id', '=', '4')->get();
		$result['shipping_methods'] = $shipping_methods;
		
		return view("admin.flateRate", $title)->with('result', $result);
	}
	
	//updateFlateRate	
	public function updateFlateRate(Request $request){
		DB::table('flate_rate')->where('id', '=', '1')->update([
				'flate_rate'  		 =>   $request->flate_rate,
				'currency'			 =>	  $request->currency
				]);
				
		DB::table('shipping_methods')->where('shipping_methods_id', '=', '4')->update([
				'status'  		 =>   $request->status,
				]);
										
		$message = Lang::get("labels.InformationUpdatedMessage");
		return redirect()->back()->withErrors([$message]);
	}
	
	
	//addNewTaxRate	
	public function updateUpsShipping(Request $request){
		DB::table('ups_shipping')->where('ups_id', '=', '1')->update([
				'pickup_method'  		 =>   $request->pickup_method,
				'serviceType'			 =>   implode(',', $request->serviceType),
				'shippingEnvironment'	 =>   $request->shippingEnvironment,
				'user_name'	 			 =>   $request->user_name,
				'access_key'	 		 =>   $request->access_key,
				'password'	 			 =>   $request->password,
				'address_line_1'	 	 =>   $request->address_line_1,
				'country'	 			 =>   $request->country,
				'state'	 			 	 =>   $request->state,
				'post_code'	 			 =>   $request->post_code,
				'city'	 				 =>   $request->city,
				'title'	 				 =>   $request->title
				]);
				
		DB::table('shipping_methods')->where('shipping_methods_id', '=', '1')->update([
				'status'  		 =>   $request->status,
				]);
										
		$message = Lang::get("labels.InformationAddedMessage");
		return redirect()->back()->withErrors([$message]);
	}
	
	
	//addNewTaxRate	
	public function defaultShippingMethod(Request $request){
		
		DB::table('shipping_methods')->update([
				'isDefault'  		 =>   0,
				]);
				
		DB::table('shipping_methods')->where('shipping_methods_id', '=', $request->shipping_id)->update([
				'isDefault'  		 =>   1,
				]);
						
		$message = 'changed';
		return $message;
	}
	
}
