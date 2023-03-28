@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.AddOptions') }} <small>{{ trans('labels.AddOptions') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/listingProducts') }}"><i class="fa fa-dashboard"></i>{{ trans('labels.ListingAllProducts') }}</a></li>
      <li class="active">{{ trans('labels.AddOptions') }}</li>
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
            <h3 class="box-title">{{ trans('labels.ListingDefaultOptions') }} </h3>
            <div class="box-tools pull-right">
            	<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#addDefaultAttributesModal">
            	{{ trans('labels.AddDefaultOption') }}
            	</button>
            </div>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.ID') }}</th>
                      <th>{{ trans('labels.OptionName') }}</th>
                      <th>{{ trans('labels.OptionValue') }}</th>
                     <!-- <th>Price</th>-->
                      <th>{{ trans('labels.Action') }}</th>
                    </tr>
                  </thead>
                  <tbody class="contentDefaultAttribute">
                  	
                  		@if (count($result['products_attributes']) > 0)
							@foreach($result['products_attributes'] as $key=>$products_attributes)
                                @if($products_attributes->is_default == '1')
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $products_attributes->products_options_name }}</td>
                                        <td>{{ $products_attributes->products_options_values_name }}</td>
                                        <!--<td>{{ $products_attributes->price_prefix }}{{ $products_attributes->options_values_price }}</td>-->
                                        <td>
                                            <a class="badge bg-light-blue editDefaultAttributeModal" products_id = '{{ $products_attributes->products_id }}' products_attributes_id = "{{ $products_attributes->products_attributes_id }}" language_id = "{{ $products_attributes->language_id }}" options_id = '{{ $products_attributes->options_id }}' ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                                            <a products_id = '{{ $products_attributes->products_id }}' products_attributes_id = "{{ $products_attributes->products_attributes_id }}" class="badge bg-red deleteDefaultAttributeModal"><i class="fa fa-trash " aria-hidden="true"></i></a></td>
                                    </tr> 
                                 @endif
                            @endforeach
						@else
						<tr>
							<td colspan="5"><strong>
				    		{{ trans('labels.NoRecordFoundTextForDefaultOption') }}
				    		</td>
					    </tr>
						@endif
                 		
                  		
                  	 
                  </tbody>
                </table>
                
                <!-- addDefaultAttributesModal -->
				<div class="modal fade" id="addDefaultAttributesModal" tabindex="-1" role="dialog" aria-labelledby="addAttributeModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="addAttributeModalLabel">{{ trans('labels.AddOptions') }}</h4>
					  </div>
					  {!! Form::open(array('url' =>'admin/addNewDefaultAttribute', 'name'=>'addAttributeFrom', 'id'=>'addDefaultAttributeFrom', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                          {!! Form::hidden('products_id',  $result['data']['products_id'], array('class'=>'form-control', 'id'=>'products_id')) !!}
                          {!! Form::hidden('subcategory_id',  $result['subcategory_id'], array('class'=>'form-control', 'id'=>'subcategory_id')) !!}
                          {!! Form::hidden('is_default',  '1', array('class'=>'form-control', 'id'=>'is_default')) !!}
                              
					  <div class="modal-body">
                          <div class="form-group">
							  <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.Language') }} </label>
							  <div class="col-sm-10 col-md-8">
								  <select class="form-control language_id" name="languages_id">		
                                  	<option value="" class="field-validate">{{ trans('labels.ChooseLanguage') }}</option>								 
									 @foreach($result['languages'] as $languages)
									  <option value="{{ $languages->languages_id }}">{{ $languages->name }}</option>
									 @endforeach										 
								  </select>
                              	<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                              	{{ trans('labels.Chooselagnuage') }}</span>
                             
							  </div>
						  </div>
                            
                            
                          <div class="form-group">
							  <label for="name" class="col-sm-2 col-md-4 control-label">
                             	 {{ trans('labels.OptionName') }}                             	 
                              </label>
							  <div class="col-sm-10 col-md-8">
								  <select class="form-control default-option-id field-validate" name="products_options_id"></select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            	{{ trans('labels.AddOptionNameText') }}
                                 </span>
                             
							  </div>
						  </div>

						   <div class="form-group">
							  <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.OptionValues') }}</label>
							  <div class="col-sm-10 col-md-8">
								  <select class="form-control products_options_values_id field-validate" name="products_options_values_id">										 
									 <!--@foreach($result['options_value'] as $options_value)
									  <option value="{{ $options_value->products_options_values_id }}">{{ $options_value->products_options_values_name }}</option>
									 @endforeach	-->									 
								  </select>
                                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                  {{ trans('labels.AddOptionValueText') }}</span>
							  </div>
							</div>
							
							<!--<div class="form-group">
							  <label for="name" class="col-sm-2 col-md-4 control-label">Price Prefix</label>
							  <div class="col-sm-10 col-md-8">
								 {!! Form::text('price_prefix',  '+', array('class'=>'form-control', 'id'=>'price_prefix')) !!}
							  </div>
							</div>

							<div class="form-group">
							  <label for="name" class="col-sm-2 col-md-4 control-label">Price</label>
							  <div class="col-sm-10 col-md-8">
								 {!! Form::text('options_values_price',  '0', array('class'=>'form-control', 'id'=>'options_values_price')) !!}
							  </div>
							</div>-->
                            <div class="alert alert-danger addDefaultError" style="display: none; margin-bottom: 0;" role="alert"><i class="icon fa fa-ban"></i>{{ trans('labels.AddOptionErrorText') }} </div>
                      </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
						<button type="button" class="btn btn-primary" id="addDefaultAttribute">{{ trans('labels.AddOption') }}</button>
					  </div>
					  {!! Form::close() !!}
					</div>
				  </div>
				</div>
                
				<!-- editDefaultAttributeModal -->
				<div class="modal fade" id="editDefaultAttributeModal" tabindex="-1" role="dialog" aria-labelledby="editDefaultAttributeModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content editDefaultContent">
					  
					</div>
				  </div>
				</div>
                
           		<!-- deleteDefaultAttributeModal -->
				<div class="modal fade" id="deleteDefaultAttributeModal" tabindex="-1" role="dialog" aria-labelledby="deleteDefaultAttributeModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content deleteDefaultEmbed">
					  
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
</div>


<div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.ListingAdditionalProductsOptions') }} </h3>
            <div class="box-tools pull-right">
            	<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#addAttributeModal">
            	{{ trans('labels.AddAdditionalOption') }}</button>
            </div>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.ID') }}</th>
                      <th>{{ trans('labels.OptionName') }}</th>
                      <th>{{ trans('labels.OptionValue') }}</th>
                      <th>{{ trans('labels.Price') }}</th>
                      <th>{{ trans('labels.Action') }}</th>
                      
                    </tr>
                  </thead>
                  <tbody class="contentAttribute">
                  	
                  		@if (count($result['products_attributes']) > 0)
							@foreach($result['products_attributes'] as $key=>$products_attributes)
                                @if($products_attributes->is_default == '0')
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $products_attributes->products_options_name }}</td>
                                    <td>{{ $products_attributes->products_options_values_name }}</td>
                                    <td>{{ $products_attributes->price_prefix }}{{ $products_attributes->options_values_price }}</td>
                                    <td>
                                       <a class="badge bg-light-blue editProductAttributeModal" products_id = '{{ $products_attributes->products_id }}' products_attributes_id = "{{ $products_attributes->products_attributes_id }}" language_id = "{{ $products_attributes->language_id }}" options_id = '{{ $products_attributes->options_id }}' ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                                            <a products_id = '{{ $products_attributes->products_id }}' products_attributes_id = "{{ $products_attributes->products_attributes_id }}" class="badge bg-red deleteProductAttributeModal"><i class="fa fa-trash " aria-hidden="true"></i></a></td>
                                </tr> 
                           @endif
                                @endforeach
						@else
						<tr>
							<td colspan="5">
				    		{{ trans('labels.NoRecordFoundTextForAdditionalOption') }}
				    		</td>
					    </tr>
						@endif
                 		
                  		
                  	 
                  </tbody>
                </table>
                
                <!-- addAttributeModal -->
				<div class="modal fade" id="addAttributeModal" tabindex="-1" role="dialog" aria-labelledby="addAttributeModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="addAttributeModalLabel">{{ trans('labels.AddOptions') }}</h4>
					  </div>
					  {!! Form::open(array('url' =>'admin/addNewProductAttribute', 'name'=>'addAttributeFrom', 'id'=>'addAttributeFrom', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                              {!! Form::hidden('products_id',  $result['data']['products_id'], array('class'=>'form-control', 'id'=>'products_id')) !!}
                              
                              {!! Form::hidden('subcategory_id',  $result['subcategory_id'], array('class'=>'form-control', 'id'=>'subcategory_id')) !!}
                              {!! Form::hidden('is_default',  '0', array('class'=>'form-control', 'id'=>'is_default')) !!}
					  <div class="modal-body">	
                      <div class="form-group">
							  <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.Language') }}</label>
							  <div class="col-sm-10 col-md-8">
								  <select class="form-control additional_language_id" name="languages_id">		
                                  	<option value="" class="field-validate">{{ trans('labels.ChooseLanguage') }}</option>								 
									 @foreach($result['languages'] as $languages)
									  <option value="{{ $languages->languages_id }}">{{ $languages->name }}</option>
									 @endforeach										 
								  </select>
                              	<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                              	{{ trans('labels.ChooseLanguage') }}</span>
                              
							  </div>
						  </div>
                      					
						  <div class="form-group">
							  <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.OptionName') }}  </label>
							  <div class="col-sm-10 col-md-8">
								  <select class="form-control  additional-option-id field-validate" name="products_options_id">										 
									 <!--@foreach($result['options'] as $options)
									  <option value="{{ $options->products_options_id }}">{{ $options->products_options_name }}</option>
									 @endforeach-->										 
								  </select>  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
								  {{ trans('labels.OptionNameText') }}
								  </span>
							  </div>
							</div>

						   <div class="form-group">
							  <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.OptionValues') }}</label>
							  <div class="col-sm-10 col-md-8">
								 <select class="form-control additional_products_options_values_id field-validate" name="products_options_values_id">										 
									<!-- @foreach($result['options_value'] as $options_value)
									  <option value="{{ $options_value->products_options_values_id }}">{{ $options_value->products_options_values_name }}</option>
									 @endforeach-->										 
								  </select>
                                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                  {{ trans('labels.OptionValuesText') }}</span>
							  </div>
							</div>
							
							<div class="form-group">
							  <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.PricePrefix') }}</label>
							  <div class="col-sm-10 col-md-8">
								 {!! Form::text('price_prefix',  '+', array('class'=>'form-control', 'id'=>'price_prefix')) !!}
                                 <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                 {{ trans('labels.PricePrefixText') }}</span>
							  </div>
							</div>

							<div class="form-group">
							  <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.Price') }}</label>
							  <div class="col-sm-10 col-md-8">
								 {!! Form::text('options_values_price',  '0', array('class'=>'form-control', 'id'=>'options_values_price')) !!}
                                 <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.NumericValueError') }}</span>
							  </div>
							</div>
                            <div class="alert alert-danger addError" style="display: none; margin-bottom: 0;" role="alert">
                            {{ trans('labels.OpitonExistText') }}</div>
                      </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
						<button type="button" class="btn btn-primary" id="addAttribute">{{ trans('labels.AddOption') }}</button>
					  </div>
					  {!! Form::close() !!}
					</div>
				  </div>
				</div>
                
				<!-- editProductAttributeModal -->
				<div class="modal fade" id="editProductAttributeModal" tabindex="-1" role="dialog" aria-labelledby="editProductAttributeModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content editContent">
					  
					</div>
				  </div>
				</div>
            
           		<!-- deleteProductAttributeModal -->
				<div class="modal fade" id="deleteProductAttributeModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductAttributeModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content deleteEmbed">
					  
				    </div>
				  </div>
            
             
                </div>
              
            </div>
          </div>
          <!-- /.box-body --> 
        <div class="box-footer text-center">
				<a href="{{ URL::to("admin/addProductImages/{$result['data']['products_id']}")}}" class="btn btn-primary">{{ trans('labels.AddImages') }}</a>
                <a href="{{ URL::to("admin/listingProducts")}}" class="btn btn-success">{{ trans('labels.Complete') }}</a>
			</div>
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
    
    <!-- Main row -->  
</div>
   
    
    <!-- Main row -->  
</div>
    
    <!-- /.row --> 
  </section>
  <!-- /.content -->

@endsection 