@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Edit Options <small>Edit Options...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to("admin/dashboard/this_month")}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ URL::to("admin/listingAttributes")}}"><i class="fa fa-dashboard"></i> Listing Options</a></li>
      <li class="active">Edit Options</li>
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
            <h3 class="box-title">Edit Options Value</h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              	  <div class="box box-info"><br>
                	  @if (count($errors) > 0)
							  @if($errors->any())
								<div class="alert alert-success alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								  {{$errors->first()}}
								</div>
							  @endif
						@endif
						@if(count($attributes['errorMessage'])>0)
						
						<div class="alert alert-danger alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  {{ $attributes['errorMessage']['error'] }}
						</div>
						
						@endif
						
						@if(count($attributes['message'])>0)
						
						<div class="alert alert-success alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						 {{ $attributes['message']['success'] }}
						</div>
						
						@endif
                                               
                        <div class="box-body">
                         
                            {!! Form::open(array('url' =>'admin/updateAttributes', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                           		{!! Form::hidden('products_options_id', $attributes['options'][0]->products_options_id , array('class'=>'form-control', 'id'=>'products_options_id')) !!}
                                
                           
                            <div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Option Name</label>
								<div class="col-sm-10 col-md-4">
                                {!! Form::text('products_options_name',  $attributes['options'][0]->products_options_name, array('class'=>'form-control field-validate', 'id'=>'products_options_name')) !!}
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Edit option name to assocaite with product.</span>
								</div>
							</div>
							
							<!-- /.box-body -->
							<div class="box-footer text-center">
								<button type="submit" class="btn btn-primary">Update Option</button>
								<a href="{{ URL::to("admin/listingAttributes")}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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