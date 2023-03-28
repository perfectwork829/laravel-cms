@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.Setting') }} <small>{{ trans('labels.Setting') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.Setting') }}</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content"> 
    <!-- Info boxes --> 
    
    <!-- /.row -->

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.Setting') }} </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                        <!--<div class="box-header with-border">
                          <h3 class="box-title">Setting</h3>
                        </div>-->
                        <!-- /.box-header -->
                        <!-- form start -->                        
                         <div class="box-body">
                          @if( count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-success" role="alert">
                                      <span class="icon fa fa-check" aria-hidden="true"></span>
                                      <span class="sr-only">{{ trans('labels.Setting') }}Error:</span>
                                      {{ $error }}
                                </div>
                             @endforeach
                          @endif
                        
                            {!! Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                            	
                            {!! Form::hidden('setting_id',  $result['setting'][0]->setting_id, array('class'=>'form-control', 'id'=>'id')) !!}
                            <h4>{{ trans('labels.generalSetting') }} </h4>
                            <hr>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.homeStyle') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="home_style" class="form-control">
                              	<option @if($result['setting'][0]->home_style == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Style1') }}</option>
                                <option @if($result['setting'][0]->home_style == '2')
                                        selected
                                    @endif
                                 value="2"> {{ trans('labels.Style2') }}</option>
                              	<option @if($result['setting'][0]->home_style == '3')
                                        selected
                                    @endif
                                 value="3"> {{ trans('labels.Style3') }}</option>
                                <option @if($result['setting'][0]->home_style == '4')
                                        selected
                                    @endif
                                 value="4"> {{ trans('labels.Style4') }}</option>
                              	<option @if($result['setting'][0]->home_style == '5')
                                        selected
                                    @endif
                                 value="5"> {{ trans('labels.Style5') }}</option>                                   
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.homeStyleText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.categoryStyle') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="category_style" class="form-control">
                              	<option @if($result['setting'][0]->category_style == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.categories1') }}</option>
                                <option @if($result['setting'][0]->category_style == '2')
                                        selected
                                    @endif
                                 value="2"> {{ trans('labels.categories2') }}</option>
                              	<option @if($result['setting'][0]->category_style == '3')
                                        selected
                                    @endif
                                 value="3"> {{ trans('labels.categories3') }}</option>
                                <option @if($result['setting'][0]->category_style == '4')
                                        selected
                                    @endif
                                 value="4"> {{ trans('labels.categories4') }}</option>
                              	<option @if($result['setting'][0]->category_style == '5')
                                        selected
                                    @endif
                                 value="5"> {{ trans('labels.categories5') }}</option>  
                              	<option @if($result['setting'][0]->category_style == '6')
                                        selected
                                    @endif
                                 value="6"> {{ trans('labels.categories6') }}</option>                                   
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.categoryStyleText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group android-hide">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.DisplayFooterMenu') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="footer_button" class="form-control">
                              	<option @if($result['setting'][0]->footer_button == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->footer_button == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.DisplayFooterMenuText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group android-hide">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.DisplayCartButton') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="cart_button" class="form-control">
                              	<option @if($result['setting'][0]->cart_button == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->cart_button == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.DisplayCartButtonText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group android-hide">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.packageName') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('package_name',  $result['setting'][0]->package_name, array('class'=>'form-control', 'id'=>'package_name')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.packageNameText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.AppName') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('app_name',  $result['setting'][0]->app_name, array('class'=>'form-control', 'id'=>'app_name')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.AppNameText') }}</span>
                              </div>
                            </div>
                            
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.websiteURL') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('site_url',  $result['setting'][0]->site_url, array('class'=>'form-control', 'id'=>'site_url')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.websiteURLText') }}</span>
                              </div>
                            </div>
                            
                             <div class="form-group android-hide"  style="display: none">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.googleAnalyticId') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('google_analytic_id',  $result['setting'][0]->google_analytic_id, array('class'=>'form-control', 'id'=>'google_analytic_id')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.googleAnalyticIdText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.CurrencySymbol') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('currency_symbol',  $result['setting'][0]->currency_symbol, array('class'=>'form-control', 'id'=>'currency_symbol')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.CurrencySymbolText') }}</span>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.NewProductDuration') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('new_product_duration',  $result['setting'][0]->new_product_duration, array('class'=>'form-control', 'id'=>'new_product_duration')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.NewProductDurationText') }}</span>
                              </div>
                            </div>
                            
                             <div class="form-group android-hide" style="display: none">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.LazzyLoadingEffect') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                               
                                <select name="lazzy_loading_effect" class="form-control">
                                    	<option 
                                        	@if($result['setting'][0]->lazzy_loading_effect == 'android')
                                            	selected
                                            @endif
                                         value="android"> {{ trans('labels.Android') }}</option>
                                         <option 
                                        	@if($result['setting'][0]->lazzy_loading_effect == 'ios-small')
                                            	selected
                                            @endif
                                         value="ios-small"> {{ trans('labels.IOSSmall') }}</option>
                                         <option 
                                        	@if($result['setting'][0]->lazzy_loading_effect == 'bubbles')
                                            	selected
                                            @endif
                                         value="bubbles"> {{ trans('labels.Bubbles') }}</option>
                                         <option 
                                        	@if($result['setting'][0]->lazzy_loading_effect == 'circles')
                                            	selected
                                            @endif
                                         value="circles"> {{ trans('labels.Circles') }}</option>
                                         <option 
                                        	@if($result['setting'][0]->lazzy_loading_effect == 'crescent')
                                            	selected
                                            @endif
                                         value="crescent"> {{ trans('labels.Crescent') }}</option>
                                         <option 
                                        	@if($result['setting'][0]->lazzy_loading_effect == 'dots')
                                            	selected
                                            @endif
                                         value="dots"> {{ trans('labels.Dots') }}</option>
                                         <option 
                                        	@if($result['setting'][0]->lazzy_loading_effect == 'lines')
                                            	selected
                                            @endif
                                         value="lines"> {{ trans('labels.Lines') }}</option>
                                         <option 
                                        	@if($result['setting'][0]->lazzy_loading_effect == 'ripple')
                                            	selected
                                            @endif
                                         value="ripple"> {{ trans('labels.Ripple') }}</option>
                                         <option 
                                        	@if($result['setting'][0]->lazzy_loading_effect == 'spiral')
                                            	selected
                                            @endif
                                         value="spiral"> {{ trans('labels.Spiral') }}</option>
                                         
                                 </select>
                                    
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.LazzyLoadingEffectText') }}</span>
                              </div>
                            </div>
                            
                             <hr>                            
                            <h4>{{ trans('labels.InqueryEmails') }} </h4>
                            <hr>
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ContactUsEmail') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('contact_us_email',  $result['setting'][0]->contact_us_email, array('class'=>'form-control', 'id'=>'contact_us_email')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                {{ trans('labels.ContactUsEmailText') }}</span>
                              </div>
                            </div>
                            
                            
                            
                            <hr>
                            <h4>{{ trans('labels.OurInfo') }} </h4>
                            <hr>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.PhoneNumber') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('phone_no',  $result['setting'][0]->phone_no, array('class'=>'form-control', 'id'=>'phone_no')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                {{ trans('labels.PhoneNumberText') }}</span>
                              </div>
                            </div>
                                                        
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Address') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('address',  $result['setting'][0]->address, array('class'=>'form-control', 'id'=>'address')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.AddressText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.City') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('city',  $result['setting'][0]->city, array('class'=>'form-control', 'id'=>'city')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.CityText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.State') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('state',  $result['setting'][0]->state, array('class'=>'form-control', 'id'=>'state')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.StateText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Zip') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('zip',  $result['setting'][0]->zip, array('class'=>'form-control', 'id'=>'zip')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.ZipText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Country') }}
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('country',  $result['setting'][0]->country, array('class'=>'form-control', 'id'=>'country')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.CountryContactUs') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Latitude') }}
                             
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('latitude',  $result['setting'][0]->latitude, array('class'=>'form-control', 'id'=>'latitude')) !!}
                                 <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.latitudeText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Longitude') }}</label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('longitude',  $result['setting'][0]->longitude, array('class'=>'form-control', 'id'=>'longitude')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.LongitudeText') }}</span>
                              </div>
                            </div>
                            
                            <hr>
                            <h4>{{ trans('labels.displayPages') }} </h4>
                            <hr>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.wishListPage') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="wish_list_page" class="form-control">
                              	<option @if($result['setting'][0]->wish_list_page == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->wish_list_page == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.wishListPageText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.editProfilePage') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="edit_profile_page" class="form-control">
                              	<option @if($result['setting'][0]->edit_profile_page == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->edit_profile_page == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.editProfilePageText') }}</span>
                              </div>
                            </div>
                            
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.shippingAddressPage') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="shipping_address_page" class="form-control">
                              	<option @if($result['setting'][0]->shipping_address_page == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->shipping_address_page == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.shippingAddressPageText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.myOrdersPage') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="my_orders_page" class="form-control">
                              	<option @if($result['setting'][0]->my_orders_page == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->my_orders_page == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.myOrdersPageText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.contactUsPage') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="contact_us_page" class="form-control">
                              	<option @if($result['setting'][0]->contact_us_page == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->contact_us_page == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.contactUsPageText') }}</span>
                              </div>
                            </div>
                            
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.aboutUsPage') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="about_us_page" class="form-control">
                              	<option @if($result['setting'][0]->about_us_page == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->about_us_page == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.aboutUsPageText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.newsPage') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="news_page" class="form-control">
                              	<option @if($result['setting'][0]->news_page == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->news_page == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.newsPageText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.introPage') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="intro_page" class="form-control">
                              	<option @if($result['setting'][0]->intro_page == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->intro_page == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.introPageText') }}</span>
                              </div>
                            </div>
                            
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.shareapp') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="share_app" class="form-control">
                              	<option @if($result['setting'][0]->share_app == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->share_app == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.shareappText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.rateapp') }}</label>
                              <div class="col-sm-10 col-md-4">
                              <select name="rate_app" class="form-control">
                              	<option @if($result['setting'][0]->rate_app == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->rate_app == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.rateappText') }}</span>
                              </div>
                            </div>
                            
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.settingPage') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="setting_page" class="form-control">
                              	<option @if($result['setting'][0]->setting_page == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->setting_page == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.settingPageText') }}</span>
                              </div>
                            </div>
                            
                             <hr>
                            <h4>{{ trans('labels.LocalNotification') }} </h4>
                            <hr>
                            
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Title') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('notification_title',  $result['setting'][0]->notification_title, array('class'=>'form-control', 'id'=>'notification_title')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.NotificationTitleText') }}</span>
                              </div>
                            </div>
                            
                            <!--<div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label"> Logo </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::file('app_logo', array('id'=>'app_logo')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Upload logo.</span>
                                <br>
                                {!! Form::hidden('oldImage',  $result['setting'][0]->app_logo , array('id'=>'app_logo',)) !!}
                                <img src="{{asset('').$result['setting'][0]->app_logo}}" alt="" width=" 100px">
                              </div>
                            </div>-->
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Detail') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('notification_text',  $result['setting'][0]->notification_text, array('class'=>'form-control', 'id'=>'notification_text')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.NotificationDetailtext') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.NotificationDuration') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    
                                    <select class="form-control" name="notification_duration">
                                          <option value="day" @if($result['setting'][0]->notification_duration=='day') selected @endif>{{ trans('labels.Day') }}</option>
                                          <option value="month" @if($result['setting'][0]->notification_duration=='month') selected @endif>{{ trans('labels.Month') }}</option>
                                          <option value="year" @if($result['setting'][0]->notification_duration=='year') selected @endif>{{ trans('labels.Year') }}</option>
                                    </select>
                                    
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.NotificationDurationText') }}</span>
                                  </div>
                                </div>
                                
                            <hr>
                            <h4>{{ trans('labels.PushNotificationSetting') }} </h4>
                            <hr>
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.AppKey') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('fcm_android',  $result['setting'][0]->fcm_android, array('class'=>'form-control', 'id'=>'fcm_android')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                {{ trans('labels.AppKeyText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.SenderId') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('fcm_android_sender_id',  $result['setting'][0]->fcm_android_sender_id, array('class'=>'form-control', 'id'=>'fcm_android_sender_id')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.SenderIdText') }}</span>
                              </div>
                            </div>
                            
                            
                            <!--<div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">FCM App ID (IOS)
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('fcm_ios',  $result['setting'][0]->fcm_ios, array('class'=>'form-control', 'id'=>'fcm_ios')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">App Key of FCM push notification IOS.</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">Sender Id (IOS)
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('fcm_ios_sender_id',  $result['setting'][0]->fcm_ios_sender_id, array('class'=>'form-control', 'id'=>'fcm_ios_sender_id')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">Sender Id of FCM push notification for IOS.</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">FCM Ap ID (Desktop)
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('fcm_desktop',  $result['setting'][0]->fcm_desktop, array('class'=>'form-control', 'id'=>'fcm_desktop')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">App Key of FCM Push notification</span>
                              </div>
                            </div>-->
                            
                            
                             <hr>
                            
                            <h4>{{ trans('labels.FacbookLogin') }} </h4>
                            <hr>
                            
                                                                   
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FacebookAppID') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('facebook_app_id',  $result['setting'][0]->facebook_app_id, array('class'=>'form-control', 'id'=>'facebook_app_id')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.FacebookAppIDText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FacebookSecretID') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('facebook_secret_id',  $result['setting'][0]->facebook_secret_id, array('class'=>'form-control', 'id'=>'facebook_secret_id')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.FacebookSecretIDText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.facebookLogin') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="facebook_login" class="form-control">
                              	<option @if($result['setting'][0]->facebook_login == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.enable') }}</option>
                              	<option @if($result['setting'][0]->facebook_login == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.disable') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.facebookLoginText') }}</span>
                              </div>
                            </div>
                            
                            <hr>
                            <h4>{{ trans('labels.googleSetting') }} </h4>
                            <hr>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.googleLogin') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="google_login" class="form-control">
                              	<option @if($result['setting'][0]->google_login == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.enable') }}</option>
                              	<option @if($result['setting'][0]->google_login == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.disable') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.googleLoginText') }}</span>
                              </div>
                            </div>
                            
                            <hr>
                            <h4>{{ trans('labels.admobSetting') }} </h4>
                            <hr>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.admobID') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('admob_id',  $result['setting'][0]->admob_id, array('class'=>'form-control', 'id'=>'admob_id')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.admobIDText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.unitIdBanner') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('ad_unit_id_banner',  $result['setting'][0]->ad_unit_id_banner, array('class'=>'form-control', 'id'=>'ad_unit_id_banner')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.unitIdBannerText') }}</span>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.unitIdInterstitial') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('ad_unit_id_interstitial',  $result['setting'][0]->ad_unit_id_interstitial, array('class'=>'form-control', 'id'=>'ad_unit_id_interstitial')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.unitIdInterstitialText') }}</span>
                              </div>
                            </div>
                            
                            
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.admobStatus') }}
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                              <select name="admob" class="form-control">
                              	<option @if($result['setting'][0]->admob == '1')
                                        selected
                                    @endif
                                 value="1"> {{ trans('labels.Show') }}</option>
                              	<option @if($result['setting'][0]->admob == '0')
                                        selected
                                    @endif
                                 value="0"> {{ trans('labels.Hide') }}</option>
                                         
                               </select>
                                
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.admobStatusText') }}</span>
                              </div>
                            </div>
                            
                            <!--<div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">Featured Category ID (Wordpress)
                              
                              </label>
                              <div class="col-sm-10 col-md-4">
                                {!! Form::text('featured_category',  $result['setting'][0]->featured_category, array('class'=>'form-control', 'id'=>'featured_category')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">Set feature category for wordpress to show in app.</span>
                              </div>
                            </div>-->
                            
                            
                           
                           
                            
                              
                            
                              <!-- /.box-body -->
                            <div class="box-footer text-center">
                            	<button type="submit" class="btn btn-primary">{{ trans('labels.Update') }} </button>
                            	<a href="{{ URL::to('admin/dashboard/this_month')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                            </div>
                              
                              <!-- /.box-footer -->
                            {!! Form::close() !!}
                        </div>
                  </div>
              </div>
            </div>
            
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
    
    <!-- Main row --> 
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
@endsection 