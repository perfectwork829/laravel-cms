@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.MainCategories') }} <small>{{ trans('labels.ListingAllMainCategories') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.MainCategories') }}</li>
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
            <h3 class="box-title">{{ trans('labels.ListingAllMainCategories') }} </h3>
            <div class="box-tools pull-right">
            	<a href="addCategory" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNewCategory') }}</a>
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
                      <th>{{ trans('labels.Icon') }}</th>
                      <th>{{ trans('labels.AddedLastModifiedDate') }}</th>
                      <th>{{ trans('labels.Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($listingCategories)>0)
                    @foreach ($listingCategories as $key=>$categories)
                        <tr>
                            <td>{{ $categories->id }}</td>
                            <td>{{ $categories->name }}</td>
                            <td><img src="{{asset('').'/'.$categories->image}}" alt="" width=" 100px"></td>
                            <td><img src="{{asset('').'/'.$categories->icon}}" alt="" width=" 100px"></td>
                            <td><strong>{{ trans('labels.AddedDate') }}: </strong> {{ $categories->date_added }}<br>
                            <strong>{{ trans('labels.ModifiedDate') }}: </strong>{{ $categories->last_modified }}  </td>
                            <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editCategory/{{ $categories->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                            <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" href="deleteCategory/{{ $categories->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        </tr>
                        
                    @endforeach
                    @else
                       <tr>
                            <td colspan="6">{{ trans('labels.NoRecordFound') }}</td>
                       </tr>
                    @endif
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	{{$listingCategories->links()}}
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