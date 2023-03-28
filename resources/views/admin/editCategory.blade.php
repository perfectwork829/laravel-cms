@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>{{ trans('labels.EditMainCategories') }}  <small>{{ trans('labels.EditMainCategories') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/listingCategories')}}"><i class="fa fa-bars"></i> {{ trans('labels.ListAllCategories') }}</a></li>
      <li class="active">{{ trans('labels.EditMainCategories') }}</li>
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
            <h3 class="box-title">{{ trans('labels.EditMainCategories') }} </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                    <br>                       
                        @if (count($errors) > 0)
                              @if($errors->any())
                                <div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  {{$errors->first()}}
                                </div>
                              @endif
                          @endif
                        <!--<div class="box-header with-border">
                          <h3 class="box-title">Edit category</h3>
                        </div>-->
                        <!-- /.box-header -->
                        <!-- form start -->                        
                         <div class="box-body">
                         
                            {!! Form::open(array('url' =>'admin/updateCategory', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                              
                                {!! Form::hidden('id',  $result['editCategory'][0]->id , array('class'=>'form-control', 'id'=>'id')) !!}
                                {!! Form::hidden('oldImage',  $result['editCategory'][0]->image , array('id'=>'oldImage')) !!}
                                {!! Form::hidden('oldIcon',  $result['editCategory'][0]->icon , array('id'=>'oldIcon')) !!}
                                
                                
                                <?php $i = 0; $j=0;?>
                                @foreach($result['languages'] as $key=>$languages)
                                	
                                    @if(!empty($result['editCategory'][$j]->language_id)) 
                                    <input type="hidden" name="categories_description_id_<?=$languages->languages_id?>" value="{{ $result['editCategory'][$i]->categories_description_id}}">
                                    @endif
                                    <div class="form-group">
                                      <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }} ({{ $languages->name }})</label>
                                      <div class="col-sm-10 col-md-4">
                                        <input type="text" name="categoryName_<?=$languages->languages_id?>" class="form-control field-validate" @if(!empty($result['editCategory'][$j]->language_id)) value="{{ $result['editCategory'][$i]->name}}" @endif>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CategoryName') }} ({{ $languages->name }}).</span>          
                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                      </div>
                                    </div>
                                 
                                 <?php 
								 	if(count($result['editCategory'])>1) { $i++; }
								 	$j++;
								  ?>
                                @endforeach
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::file('newImage', array('id'=>'newImage')) !!}<br>
                
                                    <img src="{{asset('').$result['editCategory'][0]->image}}" alt="" width=" 100px">
                                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CategoryImageText') }}</span>
                                  
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Icon') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::file('newIcon', array('id'=>'newIcon')) !!}
                                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CategoryIconText') }}</span><br>
                                    <img src="{{asset('').$result['editCategory'][0]->icon}}" alt="" width=" 100px">
                                  </div>
                                </div>
                                
                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('labels.Update') }}</button>
                                <a href="{{ URL::to('admin/listingCategories')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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