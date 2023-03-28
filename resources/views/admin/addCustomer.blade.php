@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.AddCustomer') }} <small>{{ trans('labels.AddCustomer') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="listingmembers"><i class="fa fa-users"></i>{{ trans('labels.ListingAllCustomers') }}</a></li>
      <li class="active">{{ trans('labels.AddCustomer') }}</li>
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
            <h3 class="box-title">{{ trans('labels.AddCustomer') }}</h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              	  <div class="box box-info"><br>
						
						
                        <!--<div class="box-header with-border">
                          <h3 class="box-title">Edit category</h3>
                        </div>-->
                        <!-- /.box-header -->
                        <!-- form start -->                        
                         <div class="box-body">
                         
                            {!! Form::open(array('url' =>'admin/addNewMembers', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                            
                            <div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">First Name
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">Enter customer first name.</span>
                                </label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('customers_firstname',  '', array('class'=>'form-control field-validate', 'id'=>'customers_firstname'))!!}
                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Last Name
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">Enter customer last name.</span>
                                </label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('customers_lastname',  '', array('class'=>'form-control field-validate', 'id'=>'customers_lastname'))!!}
                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Date of Birth
                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">Enter customer date of birth.</span>
                                </label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('customers_dob',  '', array('class'=>'form-control', 'id'=>'customers_dob', 'disabled'=>'disabled'))!!}
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Email</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('customers_email_address',  '', array('class'=>'form-control field-validate', 'id'=>'customers_email_address'))!!}
                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Password</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('customers_password',  '', array('class'=>'form-control field-validate', 'id'=>'customers_password'))!!}
                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Telephone</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('customers_telephone',  '', array('class'=>'form-control', 'id'=>'customers_telephone'))!!}
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Fax Number</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('customers_fax',  '', array('class'=>'form-control', 'id'=>'customers_fax'))!!}
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Status</label>
								<div class="col-sm-10 col-md-4">
									<select name="old_option" class='form-control' id="old_option"> 
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Company name</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('entry_company',  '', array('class'=>'form-control', 'id'=>'entry_company'))!!}
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">First Name</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('entry_firstname',  '', array('class'=>'form-control', 'id'=>'entry_firstname'))!!}
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Address</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('entry_street_address',  '', array('class'=>'form-control', 'id'=>'entry_street_address'))!!}
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Suburb</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('entry_suburb',  '', array('class'=>'form-control', 'id'=>'entry_suburb'))!!}
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Entry Postcode</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('entry_postcode',  '', array('class'=>'form-control', 'id'=>'entry_postcode'))!!}
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">City</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('entry_city',  '', array('class'=>'form-control', 'id'=>'entry_city'))!!}
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">State</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('entry_state',  '', array('class'=>'form-control', 'id'=>'entry_state'))!!}
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">Suburb</label>
								<div class="col-sm-10 col-md-4">
									{!! Form::text('entry_suburb',  '', array('class'=>'form-control', 'id'=>'entry_suburb'))!!}
								</div>
							</div>
							
							<!-- /.box-body -->
							<div class="box-footer text-center">
								<button type="submit" class="btn btn-primary">Add Member</button>
								<a href="listingMembers" type="button" class="btn btn-success">Completed</a>
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