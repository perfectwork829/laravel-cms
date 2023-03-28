<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

//validator is builtin class in laravel
use Validator;

use DB;
use App\Administrator;

use App;
use Lang;

//for authenitcate login data
use Auth;


//for requesting a value 
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;


class AdminPaymentController extends Controller
{
	//braintreeSetting
	public function paymentSetting(Request $request){
		$title = array('pageTitle' => Lang::get("labels.PaymentSetting"));		
		
		$shipping_methods = DB::table('payments_setting')->where('payments_id', '=', '1')->get();		
		$result['shipping_methods']	= $shipping_methods;
		return view("admin.paymentSetting", $title)->with('result', $result);
	}
	
	//updatePaymentSetting	
	public function updatePaymentSetting(Request $request){
		
		DB::table('payments_setting')->where('payments_id', '=', '1')->update([
				'braintree_enviroment'   =>   $request->braintree_enviroment,
				'braintree_merchant_id'	 =>   $request->braintree_merchant_id,
				'braintree_public_key'	 =>   $request->braintree_public_key,
				'braintree_private_key'	 =>   $request->braintree_private_key,
				'brantree_active'	 	 =>   $request->brantree_active,
				'stripe_enviroment'	 	 =>   $request->stripe_enviroment,
				'secret_key'	 	 	 =>   $request->secret_key,
				'publishable_key'	 	 =>   $request->publishable_key,
				'stripe_active'	 		 =>   $request->stripe_active,
				'cash_on_delivery'		 =>	  $request->cash_on_delivery,
				'braintree_name'	 	 =>   $request->braintree_name,
				'stripe_name'	 		 =>   $request->stripe_name,
				'cod_name'		 		 =>	  $request->cod_name,
				'paypal_status'	 		 =>   $request->paypal_status,
				'paypal_enviroment'		 =>	  $request->paypal_enviroment,
				'paypal_id'	 	 		 =>   $request->paypal_id,
				'paypal_name'	 		 =>   $request->paypal_name,
				'payment_currency'		 =>	  $request->payment_currency,
				]);
				
										
		$message = Lang::get("labels.InformationUpdatedMessage");
		return redirect()->back()->withErrors([$message]);
	}
	
}
