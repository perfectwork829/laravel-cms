@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.ProductsStock') }} <small>{{ trans('labels.ProductsStock') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.ProductsStock') }}</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content"> 
    <!-- Info boxes --> 
    
    <!-- /.row -->
    
    <div class="row">
	<div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="@if(!isset($_REQUEST['action'])) active  @endif"><a href="#low-in-stock" data-toggle="tab"> {{ trans('labels.LowInStock') }} </a></li>
              <li class="@if(isset($_REQUEST['action']) and $_REQUEST['action']=='outofstock') active  @endif"><a href="#out-of-stock" data-toggle="tab"> {{ trans('labels.OutofStock') }} </a></li>
            </ul>
            <div class="tab-content">
              <div class=" @if(!isset($_REQUEST['action'])) active  @endif tab-pane" id="low-in-stock">
               <div class="box-body">
                    <div class="row">
                      <div class="col-xs-12">
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>{{ trans('labels.ID') }}</th>
                              <th>{{ trans('labels.Image') }}</th>
                              <th>{{ trans('labels.Products') }}</th>
                              <th>{{ trans('labels.Quantity') }}</th>
                              <th>{{ trans('labels.View') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                         @if(count($result['lowQunatity']) > 0)
                            @foreach ($result['lowQunatity'] as  $key=>$lowQunatityProducts)
                                <tr>
                                    <td>{{ $lowQunatityProducts->products_id }}</td>
                                    <td><img src="{{asset('').'/'.$lowQunatityProducts->products_image}}" alt="" width=" 100px" height="100px"></td>
                                    <td width="45%">
                                        <strong>{{ $lowQunatityProducts->products_name }} ( {{ $lowQunatityProducts->products_model }} )</strong><br>
                                    </td>
                                    <td>
                                        {{ $lowQunatityProducts->products_quantity }}
                                    </td>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="editProduct/{{ $lowQunatityProducts->products_id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                                    </td>
                                </tr>
                            @endforeach
                         @endif
                         </tbody>
                        </table>
                        <div class="col-xs-12 text-right">
                            {{$result['lowQunatity']->links()}}
                        </div>
                      </div>
                      
                    </div>
         		 </div>
              </div>
              <!-- /.tab-pane -->
              <div class="@if(isset($_REQUEST['action']) and $_REQUEST['action']=='outofstock') active  @endif tab-pane" id="out-of-stock">
                <!-- The timeline -->
                <div class="box-body">
                    <div class="row">
                      <div class="col-xs-12">
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>{{ trans('labels.ID') }}</th>
                              <th>{{ trans('labels.Image') }}</th>
                              <th>{{ trans('labels.Products') }}</th>
                              <th>{{ trans('labels.Quantity') }}</th>
                              <th>{{ trans('labels.View') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                          @if(count($result['outOfStock']) > 0)
                            @foreach ($result['outOfStock'] as  $key=>$outOfStockData)
                                
                                <tr>
                                    <td>{{ $outOfStockData->products_id }}</td>
                                    <td><img src="{{asset('').'/'.$outOfStockData->products_image}}" alt="" width=" 100px" height="100px"></td>
                                    <td width="45%">
                                        <strong>{{ $outOfStockData->products_name }} ( {{ $outOfStockData->products_model }} )</strong><br>
                                    </td>
                                    <td>
                                        {{ $outOfStockData->products_quantity }}
                                    </td>
                                   
                                    <td>
                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="editProduct/{{ $outOfStockData->products_id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                                    </td>
                                </tr>
                             @endforeach
                            @endif
                          </tbody>
                        </table>
                        <div class="col-xs-12 text-right">
                            {{$result['outOfStock']->links()}}
                        </div>
                           
                      </div>
                      
                    </div>
         		 </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
       </div>
    <!-- Main row --> 
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
@endsection 