@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.Options') }} <small>{{ trans('labels.ListingAllOptions') }}...</small> </h1>
    <ol class="breadcrumb">
     <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.Options') }}</li>
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
            <h3 class="box-title">{{ trans('labels.ListingAllOptions') }} </h3>
            <div class="box-tools pull-right">
            	<a href="addAttributes" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNewOption') }}</a>
            </div>
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
              @foreach($result['data'] as $result_data )
              <table id="" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ $result_data->products_options_name }} ({{ $result_data->name }})</th>
                      <th width="40%">
                      	<a data-toggle="tooltip" data-placement="bottom" title="Edit Option" href="editAttributes/{{$result_data->products_options_id}}/{{$result_data->language_id}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                        <a option_id="{{ $result_data->products_options_id }}" class="badge bg-red deleteOption"><i class="fa fa-trash " aria-hidden="true"></i></a>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($result_data->values as $key=>$values_data )
                  <tr @if($key++==0) id="content_<?=$result_data->products_options_id.'_'.$result_data->languages_id?>" @endif>
                  		<td>
                        	<p class="form-p-<?=$result_data->products_options_id.$values_data->products_options_values_id?>">{{ $values_data->products_options_values_name }}</p> 
                        	 
                            <div style="display:none" class="row form-content-<?=$result_data->products_options_id.$values_data->products_options_values_id?>">
                            {!! Form::open(array('url' =>'admin/updateAttributeValue', 'method'=>'post', 'class' => 'form-horizontal form-validate editvalue-form', 'enctype'=>'multipart/form-data')) !!}
                                {!! Form::hidden('products_options_values_id', $values_data->products_options_values_id  , array('class'=>'form-control', 'id'=>'products_options_values_id')) !!}    
                                {!! Form::hidden('language_id', $result_data->languages_id  , array('class'=>'form-control', 'id'=>'language_id')) !!}
                               	{!! Form::hidden('products_options_id', $result_data->products_options_id  , array('class'=>'form-control', 'id'=>'products_options_id')) !!}                            
                                <div class="col-sm-10 col-md-4">
                                    {!! Form::text('products_options_values_name', $values_data->products_options_values_name , array('class'=>'form-control', 'id'=>'products_options_values_name')) !!}
                                     
                                </div>
                                <button name="updateValue" type="button" class="btn btn-primary update-value"><i class="fa fa-check" aria-hidden="true"></i> {{ trans('labels.Update') }}</button>&nbsp;&nbsp
                                <button name="cancelValue" type="button" class="btn btn-warning cancel-value" value = '<?=$result_data->products_options_id.$values_data->products_options_values_id?>'><i class="fa fa-times "></i> {{ trans('labels.Cancel') }}</button>
                            {!! Form::close() !!}
                            </div>
                        </td>
                        <td>
                        	<a data-toggle="tooltip" value = '<?=$result_data->products_options_id.$values_data->products_options_values_id?>' data-placement="bottom" title="Edit Value" href="javascript:void(0)" class="badge bg-light-blue edit-value"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
							
                            <a href="javascript:void(0)" value_id = '<?=$values_data->products_options_values_id?>' language_id = '<?=$result_data->languages_id?>' option_id = '<?=$values_data->products_options_id?>' data-toggle="tooltip" data-placement="bottom" title="Delete Value" class="badge bg-red delete-value"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
                   @endforeach
                    
                    <tr>
                  		<td colspan="2">
                            {!! Form::open(array('url' =>'admin/addAttributeValue', 'method'=>'post', 'class' => 'form-horizontal form-validate addvalue-form', 'enctype'=>'multipart/form-data')) !!}
                                {!! Form::hidden('language_id', $result_data->languages_id  , array('class'=>'form-control', 'id'=>'language_id')) !!}
                                {!! Form::hidden('products_options_id', $result_data->products_options_id  , array('class'=>'form-control', 'id'=>'products_options_id')) !!}        
                                                        
                                <div class="col-sm-10 col-md-3 row form-group">
                                    {!! Form::text('products_options_values_name', '' , array('class'=>'form-control', 'id'=>'products_options_values_name')) !!}
									<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0; text-transform:none">{{ trans('labels.AddOptionVAlueOption') }}</span>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="addValue" type="button" class="btn btn-primary add-value"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp; {{ trans('labels.AddValue') }}</button>
                            {!! Form::close() !!}
                       </td>
                    </tr>
                  </tbody>
                </table>
                @endforeach
                <div class="col-xs-12 text-right">
               	 {{$result['attributes']->links()}}
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
    <!-- deleteAttributeModal -->
	<div class="modal fade" id="deleteAttributeModal" tabindex="-1" role="dialog" aria-labelledby="deleteAttributeModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteAttributeModalLabel">{{ trans('labels.AssociatedProducts') }}</h4>
		  </div>
		  {!! Form::open(array('url' =>'admin/deleteAttribute', 'name'=>'deleteAttribute', 'id'=>'deleteAttribute', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
				  {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
				  {!! Form::hidden('option_id',  '', array('class'=>'form-control', 'id'=>'option_id')) !!}
		  <div class="modal-body">						
			  <p>{{ trans('labels.DeleteOptionPrompt') }}</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
			<button type="submit" class="btn btn-primary" id="deleteAttribute">{{ trans('labels.Delete') }}</button>
		  </div>
		  {!! Form::close() !!}
		</div>
	  </div>
	</div>

    <div class="modal fade" id="productListModal" tabindex="-1" role="dialog" aria-labelledby="productListModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="productListModalLabel">{{ trans('labels.AssociatedProducts') }}</h4>
          </div>
          <div class="modal-body">	
          	<p><strong>{{ trans('labels.DeletingErrorMessage') }}</strong></p>					
              <ul style="padding:0" id="assciate-products">
              </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Ok') }}</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="productListModalValue" tabindex="-1" role="dialog" aria-labelledby="productListModalValueLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="productListModalValueLabel">{{ trans('labels.AssociatedProducts') }}</h4>
          </div>
          <div class="modal-body">	
          	<p><strong>{{ trans('labels.DeletingErrorMessage') }}</strong></p>					
              <ul style="padding:0" id="assciate-products-value">
              </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Ok') }}</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- deleteAttributeModal -->
	<div class="modal fade" id="deleteValueModal" tabindex="-1" role="dialog" aria-labelledby="deleteValueModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteValueModalLabel">{{ trans('labels.DeleteValue') }}</h4>
		  </div>
		  {!! Form::open(array('url' =>'admin/deleteValue', 'name'=>'deleteValue', 'id'=>'deleteValue', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
				  {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
				  {!! Form::hidden('value_id',  '', array('class'=>'form-control', 'id'=>'value_id')) !!}
                  
                  {!! Form::hidden('delete_language_id', '' , array('class'=>'form-control', 'id'=>'delete_language_id')) !!}
                  {!! Form::hidden('delete_products_options_id', '' , array('class'=>'form-control', 'id'=>'delete_products_options_id')) !!}
									
		  <div class="modal-body">						
			  <p>{{ trans('labels.DeleteValuePrompt') }}</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
			<button type="button" class="btn btn-primary" id="deleteAttribute">{{ trans('labels.Delete') }} </button>
		  </div>
		  {!! Form::close() !!}
		</div>
	  </div>
	</div>
    <!-- Main row --> 
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
@endsection 