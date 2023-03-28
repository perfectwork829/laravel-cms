@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.EditPage') }} <small>{{ trans('labels.EditPage') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/listingPages')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.ListingAllPages') }}</a></li>
      <li class="active">{{ trans('labels.EditPage') }}</li>
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
            <h3 class="box-title">{{ trans('labels.EditPage') }} </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                        <!--<div class="box-header with-border">
                          <h3 class="box-title">{{ trans('labels.EditPage') }}</h3>
                        </div>-->
                        <!-- /.box-header -->
                        <!-- form start -->                        
                         <div class="box-body">
                          @if( count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-success" role="alert">
                                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                      <span class="sr-only">{{ trans('labels.Error') }}:</span>
                                      {{ $error }}
                                </div>
                             @endforeach
                          @endif
                        
                            {!! Form::open(array('url' =>'admin/updatePage', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                            	
                            {!! Form::hidden('id',  $result['editPage'][0]->page_id, array('class'=>'form-control', 'id'=>'id')) !!}
                              <div class="form-group">
								  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.PageSlug') }}</label>
								  <div class="col-sm-10 col-md-4">
									{!! Form::text('slug',  $result['editPage'][0]->slug, array('class'=>'form-control field-validate', 'id'=>'slug')) !!}
									<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.pageSlugWithDashesText') }}</span>
								  </div>
							 </div>
                                
                            <?php $i = 0; $j = 0;?>
                                @foreach($result['languages'] as $languages)
                                
                                @if(!empty($result['languages'][$j]->language_id)) 
                                    <input type="hidden" name="page_description_id_<?=$languages->languages_id?>" value="{{ $result['editPage'][$i]->page_description_id}}">
                                    @endif
                                
                                
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.PageName') }} ({{ $languages->name }})</label>
                                    <div class="col-sm-10 col-md-4">
                                        <input type="text" name="name_<?=$languages->languages_id?>" class="form-control field-validate" @if(!empty($result['editPage'][$j]->language_id)) value="{{ $result['editPage'][$i]->name }}" @endif>
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.PageName') }} ({{ $languages->name }})</span>
                                     
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                	<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Description') }} ({{ $languages->name }})</label>
                                    <div class="col-sm-10 col-md-8">
                                        <textarea id="editor<?=$languages->languages_id?>" name="description_<?=$languages->languages_id?>" class="form-control"  rows="10" cols="80">@if(!empty($result['editPage'][$j]->language_id)){{ stripslashes($result['editPage'][$i]->description) }}@endif</textarea>
                                    	<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Description') }} ({{ $languages->name }})</span>
                                    <br>
                                    </div>
                                </div>
                                <?php if(count($result['editPage'])>1) { $i++; } $j++;?>
                                
                              @endforeach
                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('labels.Update') }}</button>
                                <a href="{{ URL::to('admin/listingPages')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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