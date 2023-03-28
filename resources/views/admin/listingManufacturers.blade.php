@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.Manufacturers') }} <small>{{ trans('labels.ListingAllManufacturers') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.Manufacturers') }}</li>
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
            <h3 class="box-title">{{ trans('labels.ListingAllManufacturers') }} </h3>
            <div class="box-tools pull-right">
            	<a href="addManufacturer" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNewManufacturer') }}</a>
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.ID') }}</th>
                      <th>{{ trans('labels.Name') }}</th>
                      <th>{{ trans('labels.Image') }}</th>
                      <th>{{ trans('labels.OtherInfo') }}</th>
                      <th>{{ trans('labels.Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($listingManufacturers)>0)
                    @foreach ($listingManufacturers  as $key=>$listingManufacturer)
                        <tr>
                            <td>{{ $listingManufacturer->id }}</td>
                            <td>{{ $listingManufacturer->name }}</td>
                            <td><img src="{{asset('').'/'.$listingManufacturer->image}}" alt="" width=" 100px"></td>
                            <td>
                            	<strong>{{ trans('labels.ClickDate') }}: </strong> {{ $listingManufacturer->clik_date }}<br>
                                <strong>{{ trans('labels.URL') }}: </strong>{{ $listingManufacturer->url }} <br>
                                <strong>{{ trans('labels.Clicked') }}: </strong>{{ $listingManufacturer->url_clicked }}  
                            </td>
                            <td>
                            	<a data-toggle="tooltip" data-placement="bottom" title="Edit" href="editManufacturer/{{ $listingManufacturer->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                                <a id="manufacturerFrom" manufacturers_id='{{ $listingManufacturer->id }}' data-toggle="tooltip" data-placement="bottom" title="Delete" href="#" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        </tr>
                    @endforeach
                    
                    @else
                       <tr>
                            <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                       </tr>
                    @endif
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	{{$listingManufacturers->links()}}
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
    
    <!-- deleteManufacturerModal -->
	<div class="modal fade" id="manufacturerModal" tabindex="-1" role="dialog" aria-labelledby="deleteManufacturerModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteManufacturerModalLabel">{{ trans('labels.DeleteManufacturer') }}</h4>
		  </div>
		  {!! Form::open(array('url' =>'admin/deleteManufacturer', 'name'=>'deleteManufacturer', 'id'=>'deleteManufacturer', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
				  {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
				  {!! Form::hidden('manufacturers_id',  '', array('class'=>'form-control', 'id'=>'manufacturers_id')) !!}
		  <div class="modal-body">						
			  <p>{{ trans('labels.DeleteManufacturerText') }}</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
			<button type="submit" class="btn btn-primary">{{ trans('labels.Delete') }}</button>
		  </div>
		  {!! Form::close() !!}
		</div>
	  </div>
	</div>
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
@endsection 