@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.EditProduct') }} <small>{{ trans('labels.EditProduct') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/listingProducts')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.ListingAllProducts') }}</a></li>
      <li class="active">{{ trans('labels.EditProduct') }}</li>
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
            <h3 class="box-title">{{ trans('labels.EditProduct') }} </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                        <!-- /.box-header -->
                        <!-- form start -->                        
                         <div class="box-body">
                          @if( count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                      <span class="sr-only">Error:</span>
                                      {{ $error }}
                                </div>
                             @endforeach
                          @endif
                        
                            {!! Form::open(array('url' =>'admin/updateProduct', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                            	
                            	{!! Form::hidden('id',  $result['product'][0]->products_id, array('class'=>'form-control', 'id'=>'id')) !!}
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Category') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control field-validate" id="category_id" name="category_id" onChange="getSubCategory();">
                                            <option value="">Choose Category</option>
                                            @foreach ($result['categories'] as $categories)
                                            <option
                                            @if(!empty($result['mainCategories'][0]->parent_id))
                                             @if($result['mainCategories'][0]->parent_id == $categories->id )
                                              selected  
                                             @endif
                                            @endif
                                           
                                            value="{{ $categories->id }}">{{ $categories->name }}</option>
                                            @endforeach
                                      </select>
                                       <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ChooseCatgoryText') }}</span>
                                       <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.SubCategory') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control field-validate" name="sub_category_id" id="sub_category_id">
                                        <option value="">Choose Sub Category</option>
                                         @foreach ($result['subCategories'] as $subCategories)
                                            <option
                                             @if($result['subCategoryId'][0]->categories_id == $subCategories->id )
                                              selected  
                                             @endif
                                            value="{{ $subCategories->id }}">{{ $subCategories->name }}</option>
                                            @endforeach
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ChooseSubCatgoryText') }}</span>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Manufacturers') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="manufacturers_id">
                                     	 <option value="">Choose Manufacturer</option>
                                         @foreach ($result['manufacturer'] as $manufacturer)
                                          <option
                                           @if($result['product'][0]->manufacturers_id == $manufacturer->id )
                                             selected  
                                           @endif
                                           value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                      	 @endforeach
                                      </select>
                                  	  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ChooseManufacturerText') }}..</span>
                                  </div>
                                </div>
                                
                                <hr>
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Special') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" onChange="showSpecial()" name="isSpecial" id="isSpecial">
                                          <option 
                                           @if($result['product'][0]->products_id != $result['specialProduct'][0]->products_id && $result['specialProduct'][0]->status == 0)
                                             selected  
                                           @endif 
                                           value="no">{{ trans('labels.No') }}</option>
                                          <option
                                           @if($result['product'][0]->products_id == $result['specialProduct'][0]->products_id && $result['specialProduct'][0]->status == 1)
                                             selected  
                                           @endif 
                                           value="yes">{{ trans('labels.Yes') }}</option>
                                      </select>
                                 	  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"> {{ trans('labels.SpecialProductText') }}</span>
                                  </div>
                                </div>
                                
                                <div class="special-container" style="display: none;">
									<div class="form-group">
									  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.SpecialPrice') }}</label>
									  <div class="col-sm-10 col-md-4">
									  	{!! Form::text('specials_new_products_price',  $result['specialProduct'][0]->specials_new_products_price, array('class'=>'form-control', 'id'=>'special-price')) !!}
									    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                        {{ trans('labels.SpecialPriceTxt') }}.</span>
                                        <span class="help-block hidden">{{ trans('labels.SpecialPriceNote') }}.</span>
									  </div>
									</div>
                              		<div class="form-group">
                              		 <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ExpiryDate') }}<</label>
									  <div class="col-sm-10 col-md-4">
                                     @if(!empty($result['specialProduct'][0]->status) and $result['specialProduct'][0]->status == 1)
                                     	{!! Form::text('expires_date',  date('d/m/Y', $result['specialProduct'][0]->expires_date), array('class'=>'form-control datepicker', 'id'=>'expiry-date')) !!}
                                     @else
                                     	{!! Form::text('expires_date',  '', array('class'=>'form-control datepicker', 'id'=>'expiry-date')) !!}
                                     @endif
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                        {{ trans('labels.SpecialExpiryDateTxt') }}
                                        </span>
                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
									  </div>
									</div>
                              		<div class="form-group">
									  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
									  <div class="col-sm-10 col-md-4">
										  <select class="form-control" name="status">
											  <option
                                               @if($result['specialProduct'][0]->status == 1 )
                                                 selected  
                                               @endif 
                                               value="1">{{ trans('labels.Active') }}
                                               </option>
											   <option
                                               @if($result['specialProduct'][0]->status == 0 )
                                                 selected 
                                               @endif 
                                               value="0">{{ trans('labels.Inactive') }}</option>
										  </select>
									       <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    	  {{ trans('labels.ActiveSpecialProductText') }}.</span>
									  </div>
									</div>
                               	</div>
                                <hr>
                                
                                <!--<div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">Products Name</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('products_name',  $result['product'][0]->products_name, array('class'=>'form-control', 'id'=>'products_name')) !!}
                                  </div>
                                </div>-->
                                <?php $i = 0; $j = 0;?>
                                @foreach($result['languages'] as $languages)
                                
                                	@if(!empty($result['languages'][$j]->language_id)) 
                                    <input type="hidden" name="categories_description_id_<?=$languages->languages_id?>" value="{{ $result['editCategory'][$i]->categories_description_id}}">
                                    @endif
                                <!--<div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">Product URL</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('products_url',  $result['product'][0]->products_url, array('class'=>'form-control', 'id'=>'products_url')) !!}
                                  </div>
                                </div>-->
                                
                                
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductName') }} ({{ $languages->name }})</label>
                                    <div class="col-sm-10 col-md-4">
                                        <input type="text" name="products_name_<?=$languages->languages_id?>" class="form-control field-validate" @if(!empty($result['product'][$j]->language_id)) value="{{ $result['product'][$i]->products_name }}" @endif>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                           {{ trans('labels.EnterProductNameIn') }} {{ $languages->name }} </span>
                                      <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                	<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Description') }} ({{ $languages->name }})</label>
                                    <div class="col-sm-10 col-md-8">
                                     
                                        <textarea  id="editor<?=$languages->languages_id?>" name="products_description_<?=$languages->languages_id?>" class="form-control" rows="5">@if(!empty($result['product'][$j]->language_id)){{ stripslashes($result['product'][$i]->products_description) }}@endif</textarea>
                                     
                                   	<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.EnterProductDetailIn') }} {{ $languages->name }}</span>
                                    
                                    </div>
                                </div>
                                
                                 <!--<div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">Detail</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::textarea('products_description',  $result['product'][0]->products_description, array('class'=>'form-control', 'id'=>'products_description')) !!}<br>
                                  </div>
                                </div>-->
                                <?php if(count($result['product'])>1) { $i++; } $j++;?>
                                
                              @endforeach
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.TaxClass') }}
                                  </label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control field-validate" name="tax_class_id">
                                         <option selected> {{ trans('labels.SelectTaxClass') }}</option>
                                         @foreach ($result['taxClass'] as $taxClass)
                                          <option
                                           @if($result['product'][0]->products_tax_class_id == $taxClass->tax_class_id )
                                             selected  
                                           @endif 
                                           value="{{ $taxClass->tax_class_id }}">{{ $taxClass->tax_class_title }}</option>
                                      	 @endforeach
                                      </select>
                                 	<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                     {{ trans('labels.ChooseTaxClassForProductText') }}
                                     </span>
                                      <span class="help-block hidden">{{ trans('labels.SelectProductTaxClass') }}</span>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsPrice') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('products_price',  $result['product'][0]->products_price, array('class'=>'form-control number-validate', 'id'=>'products_price')) !!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.ProductPriceText') }}
                                    </span>                                  
                                    <span class="help-block hidden">{{ trans('labels.ProductPriceText') }}</span>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsWeight') }}</label>
                                  <div class="col-sm-10 col-md-3">
                                    {!! Form::text('products_weight',  $result['product'][0]->products_weight, array('class'=>'form-control number-validate', 'id'=>'products_weight')) !!}
                                 <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.RequiredTextForWeight') }}
                                    </span>
                                  
                                  </div>
                                  <div class="col-sm-10 col-md-1" style="padding-left: 0;">
                                  	  <select class="form-control" name="products_weight_unit">
                                          <option value="g" @if($result['product'][0]->products_weight_unit=='g') selected @endif>{{ trans('labels.gram') }}</option>.
                                          <option value="kg" @if($result['product'][0]->products_weight_unit=='kg') selected @endif>{{ trans('labels.KiloGram') }}</option>
                                      </select>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsModel') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('products_model',  $result['product'][0]->products_model, array('class'=>'form-control', 'id'=>'products_model')) !!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.ProductsModelText') }}
                                    </span>
                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                  </div>
                                </div>
                                
                                 <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsQuantity') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('products_quantity',  $result['product'][0]->products_quantity, array('class'=>'form-control number-validate', 'id'=>'products_quantity')) !!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.ProductsQuantityText') }}
                                    </span>
                                    <span class="help-block hidden">{{ trans('labels.ProductsQuantityText') }}</span>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.QuantityLowLimit') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('low_limit', $result['product'][0]->low_limit, array('class'=>'form-control', 'id'=>'low_limit')) !!}
                                  	<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.QuantityLowLimitText') }}</span>
                                  </div>
                                </div>
                                
                                
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::file('products_image', array('id'=>'products_image')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.UploadProductImageText') }}</span>
                                    <br>
                                    {!! Form::hidden('oldImage',  $result['product'][0]->products_image , array('id'=>'oldImage', 'class'=>'field-validate ')) !!}
                                    <img src="{{asset('').$result['product'][0]->products_image}}" alt="" width=" 100px">
                                  </div>
                                </div>
                                
                                                               
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="products_status">
                                          <option value="1" @if($result['product'][0]->products_status==1) selected @endif >{{ trans('labels.Active') }}</option>
                                          <option value="0" @if($result['product'][0]->products_status==0) selected @endif>{{ trans('labels.Inactive') }}</option>                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.SelectStatus') }}</span>
                                  </div>
                                </div>
                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('labels.Update') }}</button>
                                <a href="{{ URL::to('admin/listingProducts')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
<script src="{!! asset('resources/views/admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
<script type="text/javascript">
		$(function () {
			
			//for multiple languages
			@foreach($result['languages'] as $languages)
				// Replace the <textarea id="editor1"> with a CKEditor
				// instance, using default configuration.
				CKEDITOR.replace('editor{{$languages->languages_id}}');
			
			@endforeach
			
			//bootstrap WYSIHTML5 - text editor
			$(".textarea").wysihtml5();
			
    });
</script>
@endsection 