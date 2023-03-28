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

//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//for requesting a value 
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;


class AdminReportsController extends Controller
{
	//statsCustomers
	public function statsCustomers(Request $request){
		$title = array('pageTitle' => Lang::get("labels.CustomerOrdersTotal"));		
		
		$cusomters = DB::table('customers')
			->join('orders', 'orders.customers_id', '=', 'customers.customers_id')
			->select('customers.customers_id', 'customers.customers_firstname as firstname', 'customers.customers_lastname as lastname', 'order_price', DB::raw('SUM(order_price) as price'))
			->groupby('customers.customers_id')
			->paginate(60);
		
		$result['data'] = $cusomters;
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['currency'] = $myVar->getSetting();
		
		return view("admin.statsCustomers",$title)->with('result', $result);
	}
	
	//statsProductsPurchased
	public function statsProductsPurchased(Request $request){
		$title = array('pageTitle' => Lang::get("labels.StatsProductsPurchased"));
		
		$products = DB::table('products')
			->join('products_description', 'products_description.products_id', '=', 'products.products_id')
			->orderBy('products_ordered', 'DESC')
			->where('products_description.language_id','=','1')
			->paginate(20);
		
		$result['data'] = $products;
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['currency'] = $myVar->getSetting();
		
		return view("admin.statsProductsPurchased",$title)->with('result', $result);
	}
	
	//statsProductsLiked
	public function statsProductsLiked(Request $request){
		$title = array('pageTitle' => Lang::get("labels.StatsProductsLiked"));
		
		$products = DB::table('products')
			->join('products_description', 'products_description.products_id', '=', 'products.products_id')
			->where('products.products_liked', '>', '0')
			->where('products_description.language_id','=','1')
			->orderBy('products_liked', 'DESC')
			->paginate(20);
		
		$result['data'] = $products;
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['currency'] = $myVar->getSetting();
		
		return view("admin.statsProductsLiked",$title)->with('result', $result);
	}
	
	//productsStock
	public function productsStock(Request $request){
		$title = array('pageTitle' => Lang::get("labels.ProductsStocks"));
		
		$lowQunatity = DB::table('products')
			->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
			->whereColumn('products.products_quantity', '<=', 'products.low_limit')
			->where('products_description.language_id', '=', 1)
			->where('products.low_limit', '>', 0)
			//->get();
			->paginate(10);
		
		$outOfStock = DB::table('products')
			->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
			->where('products_description.language_id', '=', 1)
			->where('products.low_limit', '=', 0)
			->paginate(10);
		
		$result['lowQunatity'] = $lowQunatity;
		$result['outOfStock'] = $outOfStock;
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['currency'] = $myVar->getSetting();
		
		return view("admin.productsStock",$title)->with('result', $result);
	}
	
	public function getFormattedDate($reportBase){
		
		$dateFrom	= date('Y-m-01', $date);
		$dateTo 	= date('Y-m-t',  $date);
	}	
	
	//public function productSaleReport($reportBase){
	public function productSaleReport(Request $request){
		
		$saleData = array();
		$date = time();
		$reportBase = $request->reportBase;
		//$reportBase = 'last_year';
		
		if($reportBase=='this_month'){
			
			$dateLimit 	= date('d',  $date);
			
			//for current month		
			for($j = 1; $j <= $dateLimit; $j++){
				
				$dateFrom   = date('Y-m-'.$j.' 00:00:00', time());
				$dateTo 	= date('Y-m-'.$j.' 23:59:59', time());
				
				//sold products
				$orders = DB::table('orders')
					->whereBetween('date_purchased', [$dateFrom, $dateTo])
					->get();
			
				$totalSale = 0;
				foreach($orders as $orders_data){
					
					$orders_status = DB::table('orders_status_history')
						->where('orders_id', '=', $orders_data->orders_id)
						->orderby('date_added', 'DESC')->limit(1)->get();
						
					if($orders_status[0]->orders_status_id != 3){
						$totalSale++;
					}
				}
				
				//purchase products
				$products = DB::table('products')
					->select('products_quantity', DB::raw('SUM(products_quantity) as products_quantity'))
					->whereBetween('products_date_added', [$dateFrom, $dateTo])
					->get();
									
				$saleData[$j-1]['date'] = date('d M',strtotime($dateFrom));
				$saleData[$j-1]['totalSale'] = $totalSale;
				
				if(empty($products[0]->products_quantity)){
					$producQuantity = 0;
				}else{
					$producQuantity = $products[0]->products_quantity;
				}
				
				$saleData[$j-1]['productQuantity'] = $producQuantity;
			}
			
		}else if($reportBase=='last_month'){
			$datePrevStart =  date("Y-n-j", strtotime("first day of previous month"));
			$datePrevEnd   =  date("Y-n-j", strtotime("last day of previous month"));
			
			$dateLimit 	= date('d',  strtotime($datePrevEnd));
			
			//for last month		
			for($j = 1; $j <= $dateLimit; $j++){
				
				$dateFrom   = date('Y-m-'.$j.' 00:00:00', strtotime($datePrevStart));
				$dateTo 	= date('Y-m-'.$j.' 23:59:59', strtotime($datePrevEnd));
				
				//sold products
				$orders = DB::table('orders')
					->whereBetween('date_purchased', [$dateFrom, $dateTo])
					->get();
			
				$totalSale = 0;
				foreach($orders as $orders_data){
					
					$orders_status = DB::table('orders_status_history')
						->where('orders_id', '=', $orders_data->orders_id)
						->orderby('date_added', 'DESC')->limit(1)->get();
						
					if($orders_status[0]->orders_status_id != 3){
						$totalSale++;
					}
				}
				
				//purchase products
				$products = DB::table('products')
					->select('products_quantity', DB::raw('SUM(products_quantity) as products_quantity'))
					->whereBetween('products_date_added', [$dateFrom, $dateTo])
					->get();
									
				$saleData[$j-1]['date'] = date('d M',strtotime($dateFrom));
				$saleData[$j-1]['totalSale'] = $totalSale;
				
				if(empty($products[0]->products_quantity)){
					$producQuantity = 0;
				}else{
					$producQuantity = $products[0]->products_quantity;
				}
				
				$saleData[$j-1]['productQuantity'] = $producQuantity;
			}
			
		}else if($reportBase=='last_year'){
			
			$dateLimit 	=   date("Y", strtotime("-1 year"));
			
			$datePrevStart =  date("Y-n-j", strtotime("first day of previous month"));
			$datePrevEnd   =  date("Y-n-j", strtotime("last day of previous month"));
			
			//for last year		
			for($j = 1; $j <= 12; $j++){
				$dateFrom   = date( $dateLimit.'-'.$j.'-1 00:00:00', strtotime($datePrevStart));
				$dateTo 	= date( $dateLimit.'-'.$j.'-31 23:59:59', strtotime($datePrevEnd));
				
				//sold products
				$orders = DB::table('orders')
					->whereBetween('date_purchased', [$dateFrom, $dateTo])
					->get();
			
				$totalSale = 0;
				foreach($orders as $orders_data){
					
					$orders_status = DB::table('orders_status_history')
						->where('orders_id', '=', $orders_data->orders_id)
						->orderby('date_added', 'DESC')->limit(1)->get();
						
					if($orders_status[0]->orders_status_id != 3){
						$totalSale++;
					}
				}
				
				//purchase products
				$products = DB::table('products')
					->select('products_quantity', DB::raw('SUM(products_quantity) as products_quantity'))
					->whereBetween('products_date_added', [$dateFrom, $dateTo])
					->get();
									
				$saleData[$j-1]['date'] = date('M Y',strtotime($dateFrom));
				$saleData[$j-1]['totalSale'] = $totalSale;
				
				if(empty($products[0]->products_quantity)){
					$producQuantity = 0;
				}else{
					$producQuantity = $products[0]->products_quantity;
				}
				
				$saleData[$j-1]['productQuantity'] = $producQuantity;
			}
		}else{
			$reportBase = str_replace('dateRange','', $reportBase);
		$reportBase = str_replace('=','', $reportBase);
		$reportBase = str_replace('-','/', $reportBase);
		
		$dateFrom = substr($reportBase,0,10);
		$dateTo = substr($reportBase,11,21);
		
		$diff = abs(strtotime($dateFrom) - strtotime($dateTo));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$totalDays = floor($diff / (60 * 60 * 24));
	//	print ('day: '.$days.' months: '.$months.' years: '.$years.'<br>');
		$totalMonths = floor($diff / 60 / 60 / 24 / 30);
		
		if($diff == 0 && $days == 0 && $years == 0 && $months == 0){
			//print 'asdsad';
			
			$dateLimitFrom 	= date('G',  strtotime($dateFrom));
			$dateLimitTo 	= date('d',  strtotime($dateTo));
			$selecteddate 	= date('m',  strtotime($dateFrom));
			$selecteddate	= date('Y',  strtotime($dateFrom));
			
			//for current month		
			for($j = 1; $j <= 24; $j++){
								
				$dateFrom   = date('Y-m-d'.' '.$j.':00:00', strtotime($dateFrom));
				$dateTo   = date('Y-m-d'.' '.$j.':59:59', strtotime($dateFrom));
				
				//sold products
				$orders = DB::table('orders')
					->whereBetween('date_purchased', [$dateFrom, $dateTo])
					->get();
			
				$totalSale = 0;
				foreach($orders as $orders_data){
					
					$orders_status = DB::table('orders_status_history')
						->where('orders_id', '=', $orders_data->orders_id)
						->orderby('date_added', 'DESC')->limit(1)->get();
						
					if($orders_status[0]->orders_status_id != 3){
						$totalSale++;
					}
				}
				
				//purchase products
				$products = DB::table('products')
					->select('products_quantity', DB::raw('SUM(products_quantity) as products_quantity'))
					->whereBetween('products_date_added', [$dateFrom, $dateTo])
					->get();
									
				$saleData[$j-1]['date'] = date('h a',strtotime($dateFrom));
				$saleData[$j-1]['totalSale'] = $totalSale;
				
				if(empty($products[0]->products_quantity)){
					$producQuantity = 0;
				}else{
					$producQuantity = $products[0]->products_quantity;
				}
				
				$saleData[$j-1]['productQuantity'] = $producQuantity;
				//print $dateLimitFrom.'<br>';
				
			}
			
		}else if($days > 1 && $years == 0 && $months == 0){
			
			//print 'daily';
			
			$dateLimitFrom 	= date('d',  strtotime($dateFrom));
			$dateLimitTo 	= date('d',  strtotime($dateTo));
			$selectedMonth 	= date('m',  strtotime($dateFrom));
			$selectedYear	= date('Y',  strtotime($dateFrom));
			//print $selectedYear;
			
			//for current month		
			for($j = 1; $j <= $totalDays; $j++){
				
				//print 'dateFrom: '.date('Y-m-'.$j.' 00:00:00', time()).'dateTo: '.date('Y-m-'.$j.' 23:59:59', time());
				//print '<br>';
				
				$dateFrom   = date($selectedYear.'-'.$selectedMonth.'-'.$dateLimitFrom, strtotime($dateFrom));
				//$dateTo 	= date('Y-m-'.$j.' 23:59:59', time());
				//print $dateFrom .'<br>';
				$lastday   =  date('t',strtotime($dateFrom));
				//print 'lastday: '.$lastday .' <br>';
				
				
				//sold products
				$orders = DB::table('orders')
					->whereBetween('date_purchased', [$dateFrom, $dateTo])
					->get();
			
				$totalSale = 0;
				foreach($orders as $orders_data){
					
					$orders_status = DB::table('orders_status_history')
						->where('orders_id', '=', $orders_data->orders_id)
						->orderby('date_added', 'DESC')->limit(1)->get();
						
					if($orders_status[0]->orders_status_id != 3){
						$totalSale++;
					}
				}
				
				//purchase products
				$products = DB::table('products')
					->select('products_quantity', DB::raw('SUM(products_quantity) as products_quantity'))
					->whereBetween('products_date_added', [$dateFrom, $dateTo])
					->get();
									
				$saleData[$j-1]['date'] = date('d M',strtotime($dateFrom));
				$saleData[$j-1]['totalSale'] = $totalSale;
				
				if(empty($products[0]->products_quantity)){
					$producQuantity = 0;
				}else{
					$producQuantity = $products[0]->products_quantity;
				}
				
				$saleData[$j-1]['productQuantity'] = $producQuantity;
				//print $dateLimitFrom.'<br>';
				if($dateLimitFrom == $lastday ){
					$dateLimitFrom = '1';
					$selectedMonth++;
					
				}else{
					$dateLimitFrom++;
				}
				
				if($selectedMonth > 12){
					$selectedMonth = '1';
					$selectedYear++;
				}
			}
		}else if($months >= 1 && $years == 0){
			
			//for check if date range enter into another month
			if($days>0){
				$months+=1;	
			}
						
			$dateLimitFrom 	= date('d',  strtotime($dateFrom));
			$dateLimitTo 	= date('d',  strtotime($dateTo));
			$selectedMonth 	= date('m',  strtotime($dateFrom));
			$selectedYear	= date('Y',  strtotime($dateFrom));
			//print $selectedMonth;
			
			$i = 0;
			//for current month		
			for($j = 1; $j <= $months; $j++){
				if($j==$months){
					$lastday = $dateLimitTo;
				}else{
					$lastday  =  date('t',strtotime($dateLimitFrom.'-'.$selectedMonth.'-'.$selectedYear));
				}
				
				$dateFrom   = date($selectedYear.'-'.$selectedMonth.'-'.$dateLimitFrom, strtotime($dateFrom));
				$dateTo   = date($selectedYear.'-'.$selectedMonth.'-'.$lastday, strtotime($dateTo));
				//print $dateFrom.' '.$dateTo.'<br>';
				
				
				//sold products
				$orders = DB::table('orders')
					->whereBetween('date_purchased', [$dateFrom, $dateTo])
					->get();
			
				$totalSale = 0;
				foreach($orders as $orders_data){
					
					$orders_status = DB::table('orders_status_history')
						->where('orders_id', '=', $orders_data->orders_id)
						->orderby('date_added', 'DESC')->limit(1)->get();
						
					if($orders_status[0]->orders_status_id != 3){
						$totalSale++;
					}
				}
				
				//purchase products
				$products = DB::table('products')
					->select('products_quantity', DB::raw('SUM(products_quantity) as products_quantity'))
					->whereBetween('products_date_added', [$dateFrom, $dateTo])
					->get();
									
				$saleData[$i]['date'] = date('M Y',strtotime($dateFrom));
				$saleData[$i]['totalSale'] = $totalSale;
				
				if(empty($products[0]->products_quantity)){
					$producQuantity = 0;
				}else{
					$producQuantity = $products[0]->products_quantity;
				}
				
				$saleData[$i]['productQuantity'] = $producQuantity;
				
				$selectedMonth++;
				if($selectedMonth > 12){
					$selectedMonth = '1';
					$selectedYear++;
				}
				$i++;
			}
		
		} else if($years >= 1){
			
			//print $years.'sadsa';
			if($months>0){
				$years+=1;	
			}
			
			//print $years;
			
			$dateLimitFrom 	= date('d',  strtotime($dateFrom));
			$dateLimitTo 	= date('d',  strtotime($dateTo));
			
			$selectedMonthFrom 	= date('m',  strtotime($dateFrom));
			$selectedMonthTo 	= date('m',  strtotime($dateTo));
			
			$selectedYearFrom	= date('Y',  strtotime($dateFrom));
			$selectedYearTo	= date('Y',  strtotime($dateTo));
			//print $selectedYearFrom.' '.$selectedYearTo;
			
			$i = 0;
			//for current month		
			for($j = $selectedYearFrom; $j <= $selectedYearTo; $j++){
				
				if($j==$selectedYearTo){
					$selectedYearTo = $selectedYearTo;	
					$dateLimitTo = $dateLimitTo;
				}else{
					$selectedMonthTo = 12;	
					$dateLimitTo = 31;
				}
				
				if( $selectedYearFrom == $j ){
					$selectedMonthFrom = $selectedMonthFrom;
				}else{
					$selectedMonthFrom = 1;
				}
				
			//	print $j.'-'.$selectedMonthFrom.'-'.$dateLimitFrom.'<br>';
				//print $j.'-'.$selectedMonthTo.'-'.$dateLimitTo.'<br>';
				//$lastday  =  date('t',strtotime($dateLimitFrom.'-'.$selectedMonth.'-'.$selectedYear));
				
				
				$dateFrom   = date($j.'-'.$selectedMonthFrom.'-'.$dateLimitFrom, strtotime($dateFrom));
				$dateTo   	= date($j.'-'.$selectedMonthTo.'-'.$dateLimitTo, strtotime($dateTo));
			//	print $dateFrom.' '.$dateTo.'<br>';
				//print $dateFrom.'<br>';
				
				
				//sold products
				$orders = DB::table('orders')
					->whereBetween('date_purchased', [$dateFrom, $dateTo])
					->get();
			
				$totalSale = 0;
				foreach($orders as $orders_data){
					
					$orders_status = DB::table('orders_status_history')
						->where('orders_id', '=', $orders_data->orders_id)
						->orderby('date_added', 'DESC')->limit(1)->get();
						
					if($orders_status[0]->orders_status_id != 3){
						$totalSale++;
					}
				}
				
				//purchase products
				$products = DB::table('products')
					->select('products_quantity', DB::raw('SUM(products_quantity) as products_quantity'))
					->whereBetween('products_date_added', [$dateFrom, $dateTo])
					->get();
									
				$saleData[$i]['date'] = date('Y',strtotime($dateFrom));
				$saleData[$i]['totalSale'] = $totalSale;
				
				if(empty($products[0]->products_quantity)){
					$producQuantity = 0;
				}else{
					$producQuantity = $products[0]->products_quantity;
				}
				
				$saleData[$i]['productQuantity'] = $producQuantity;
				//$selectedYear++;
				//$selectedMonth++;
				$i++;
			}
			
		
		}
			//print_r($saleData);
		}
		
		 //$reportBase = str_replace('dateRange','', $reportBase);
		 
		// return $reportBase;
		 return $saleData;	
	}
}
