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

//for authenitcate login data
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

//for requesting a value 
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

//for Carbon a value 
use Carbon;

class PagesController extends Controller
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
		
	//getAllPages 
	public function getAllPages(Request $request){
		$language_id            				=   $request->language_id;	
			
		$data = DB::table('pages')
			->LeftJoin('pages_description', 'pages_description.page_id', '=', 'pages.page_id')
			->where('pages_description.language_id', '=', $language_id)->get();

		$result = array();
		$index = 0;
		foreach($data as $pages_data){
			array_push($result, $pages_data);
			
			$description =  $pages_data->description;
			$result[$index]->description = stripslashes($description);
			$index++;
			
		}
		//print_r($result);

		//check if record exist
		if(count($data)>0){
				$responseData = array('success'=>'1', 'pages_data'=>$result,  'message'=>"Returned all products.");
			}else{
				$responseData = array('success'=>'0', 'pages_data'=>array(),  'message'=>"Empty record.");
			}		
						
		$categoryResponse = json_encode($responseData);
		print $categoryResponse;
	}
	
}
