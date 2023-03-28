@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Edit News <small>Edit News...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/listingNews')}}"><i class="fa fa-dashboard"></i> Listing News</a></li>
      <li class="active">Edit News</li>
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
            <h3 class="box-title">Edit News </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                        <!--<div class="box-header with-border">
                          <h3 class="box-title">Edit News</h3>
                        </div>-->
                        <!-- /.box-header -->
                        <!-- form start -->                        
                         <div class="box-body">
                          @if( count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-success" role="alert">
                                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                      <span class="sr-only">Error:</span>
                                      {{ $error }}
                                </div>
                             @endforeach
                          @endif
                        
                            {!! Form::open(array('url' =>'admin/updateNews', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                            	
                            	{!! Form::hidden('id',  $result['news'][0]->news_id, array('class'=>'form-control', 'id'=>'id')) !!}
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">Category</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control field-validate" id="category_id" name="category_id">
                                            <option value="">Choose Category</option>
                                            @foreach ($result['categories'] as $categories)
                                            <option
                                            @if(!empty($result['editCategory'][0]->categories_id))
                                             @if($result['editCategory'][0]->categories_id == $categories->id )
                                              selected  
                                             @endif
                                            @endif
                                           
                                            value="{{ $categories->id }}">{{ $categories->name }}</option>
                                            @endforeach
                                       </select>
     	                               <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Choose news category</span>
                                  
                                       <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                  </div>
                                </div>
                                
                                <hr>
                                
                                <?php $i = 0; $j = 0;?>
                                @foreach($result['languages'] as $languages)
                                
                                	@if(!empty($result['languages'][$j]->language_id)) 
                                    <input type="hidden" name="categories_description_id_<?=$languages->languages_id?>" value="{{ $result['editCategory'][$i]->categories_description_id}}">
                                    @endif
                                
                                
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.TitleNews') }} ({{ $languages->name }})</label>
                                    <div class="col-sm-10 col-md-4">
                                        <input type="text" name="news_name_<?=$languages->languages_id?>" class="form-control field-validate" @if(!empty($result['news'][$j]->language_id)) value="{{ $result['news'][$i]->news_name }}" @endif>
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.TitleNews') }} ({{ $languages->name }})</span>
                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                	<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Description') }} ({{ $languages->name }})</label>
                                    <div class="col-sm-10 col-md-8">
                                        <textarea id="editor<?=$languages->languages_id?>" name="news_description_<?=$languages->languages_id?>" class="form-control"  rows="10" cols="80">@if(!empty($result['news'][$j]->language_id)){{ stripslashes($result['news'][$i]->news_description) }}@endif</textarea>
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Description') }} ({{ $languages->name }})</span>
                                    <br>
                                    </div>
                                </div>
                                <?php if(count($result['news'])>1) { $i++; } $j++;?>
                                
                              @endforeach
                                
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::file('news_image', array('id'=>'news_image')) !!}<br>
                                    {!! Form::hidden('oldImage',  $result['news'][0]->news_image , array('id'=>'oldImage')) !!}
                                    <img src="{{asset('').$result['news'][0]->news_image}}" alt="" width=" 100px">
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.UploadImageforNews') }}</span>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.IsFeature') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="is_feature">
                                          <option value="1" @if($result['news'][0]->is_feature==1) selected @endif >{{ trans('labels.Yes') }}</option>
                                          <option value="0" @if($result['news'][0]->is_feature==0) selected @endif>{{ trans('labels.No') }}</option>
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.IsFeatureText') }}</span>
                                  </div>
                                </div>
                                                               
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="news_status">
                                          <option value="1" @if($result['news'][0]->news_status==1) selected @endif >{{ trans('labels.Active') }}</option>
                                          <option value="0" @if($result['news'][0]->news_status==0) selected @endif>{{ trans('labels.Inactive') }}</option>
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Active status will be displayed on user side.</span>
                                  </div>
                                </div>
                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('labels.Update') }}</button>
                                <a href="{{ URL::to('admin/listingNews')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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