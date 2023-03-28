@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>{{ trans('labels.PaymentSetting') }} <small>{{ trans('labels.PaymentSetting') }}Setting...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.PaymentSetting') }}Payment Setting</li>
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
            <h3 class="box-title">{{ trans('labels.PaymentSetting') }}</h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
              <div class="row">
                  <div class="col-xs-12">              		
                      @if (count($errors) > 0)
                          @if($errors->any())
                            <div class="alert alert-success alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              {{$errors->first()}}
                            </div>
                          @endif
                      @endif
                  </div>
                </div>
            <div class="row">
              <div class="col-xs-12">
              	  <div class="box box-info">
                        <!-- form start -->                        
                         <div class="box-body">
                            {!! Form::open(array('url' =>'admin/updatePaymentSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                            
                            <div class="form-group">
                           		<label for="shippingEnvironment" class="col-sm-2 col-md-3 control-label" style="">{{ trans('labels.PaymentMetods') }}</label>
                                <div class="col-sm-10 col-md-4">
                                    <label class=" control-label">
                                          <input type="checkbox" name="brantree_active" value="1" class="flat-red" @if($result['shipping_methods'][0]->brantree_active==1) checked @endif > &nbsp;{{ trans('labels.Brantree') }}
                                    </label><br>

                                    <label class=" control-label">
                                          <input type="checkbox" name="stripe_active" value="1" class="flat-red" @if($result['shipping_methods'][0]->stripe_active==1) checked @endif > &nbsp;{{ trans('labels.Stripe') }}
                                    </label><br>

                                    
                                    
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.PaymentMetodsText') }}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                           		<label for="shippingEnvironment" class="col-sm-2 col-md-3 control-label" style="">{{ trans('labels.BraintreeAccountType') }}</label>
                                <div class="col-sm-10 col-md-4">
                                    <label class=" control-label">
                                          <input type="radio" name="braintree_enviroment" value="0" class="flat-red" @if($result['shipping_methods'][0]->braintree_enviroment==0) checked @endif > &nbsp;{{ trans('labels.Sanbox') }}
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
                                    <label class=" control-label">
                                          <input type="radio" name="braintree_enviroment" value="1" class="flat-red" @if($result['shipping_methods'][0]->braintree_enviroment==1) checked @endif >  &nbsp;{{ trans('labels.Live') }}
                                    </label>
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.BraintreeAccountTypeText') }}</span>
                                </div>
                            </div>
                             
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.MerchantID') }}</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('braintree_merchant_id', $result['shipping_methods'][0]->braintree_merchant_id, array('class'=>'form-control', 'id'=>'braintree_merchant_id'))!!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.MerchantIDText') }}</span>
								</div>
							</div>						
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.PublicKey') }}</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('braintree_public_key',  $result['shipping_methods'][0]->braintree_public_key, array('class'=>'form-control', 'id'=>'braintree_public_key'))!!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.PublicKeyText') }}</span>
								</div>
							</div>	
                            <div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.PrivateKey') }}</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('braintree_private_key',  $result['shipping_methods'][0]->braintree_private_key, array('class'=>'form-control', 'id'=>'braintree_private_key'))!!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.PrivateKeyText') }}</span>
								</div>
							</div>
                            <hr>
                            <div class="form-group">
                           		<label for="shippingEnvironment" class="col-sm-2 col-md-3 control-label" style="">{{ trans('labels.StripeEnviroment') }}</label>
                                <div class="col-sm-10 col-md-4">
                                    <label class=" control-label">
                                          <input type="radio" name="stripe_enviroment" value="0" class="flat-red" @if($result['shipping_methods'][0]->stripe_enviroment==0) checked @endif > &nbsp;{{ trans('labels.Sanbox') }}
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
                                    <label class=" control-label">
                                          <input type="radio" name="stripe_enviroment" value="1" class="flat-red" @if($result['shipping_methods'][0]->stripe_enviroment==1) checked @endif >  &nbsp;{{ trans('labels.Live') }}
                                    </label>
                                    
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.StripeEnviromentText') }}</span>
                                </div>
                            </div>
                             
                            
                            <div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.SecretKey') }}</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('secret_key', $result['shipping_methods'][0]->secret_key, array('class'=>'form-control', 'id'=>'secret_key'))!!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.SecretKeyText') }}</span>
								</div>
							</div>	
													
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Key') }} </label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('publishable_key',  $result['shipping_methods'][0]->publishable_key, array('class'=>'form-control', 'id'=>'publishable_key'))!!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.StripeKeyText') }}</span>
								</div>
							</div>	
                           	
                            						
							<!-- /.box-body -->
							<div class="box-footer text-center">
								<button type="submit" class="btn btn-primary">{{ trans('labels.Update') }} </button>
								<a href="shippingMethods" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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