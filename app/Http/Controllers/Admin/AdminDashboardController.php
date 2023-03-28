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

//for authenitcate login data
use Auth;

//for requesting a value 
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;


class AdminDashboardController extends Controller
{
	//listingOrderStatus
	public function dashboard(Request $request){
		$title = array('pageTitle' => 'Dashboard');		
		$result = array();
		
		$orders = DB::table('orders')
			->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders.orders_status')
			->orderBy('date_purchased','DESC')
			//->paginate(10);
			->get();
			
		$recentOrders = array_slice($input, 0, 10);
		$result['recentOrders'] = $recentOrders;
		print_r($recentOrders);
		//return view("admin.dashboard",$title)->with('result', $result);
	}
	
}
