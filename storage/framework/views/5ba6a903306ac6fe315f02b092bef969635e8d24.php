<?php $__env->startSection('content'); ?>
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?php echo e(trans('labels.Customers')); ?> <small><?php echo e(trans('labels.ListingAllCustomers')); ?>...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
      <li class="active"><?php echo e(trans('labels.Customers')); ?></li>
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
            <h3 class="box-title"><?php echo e(trans('labels.ListingAllCustomers')); ?> </h3>
            <div class="box-tools pull-right">
            	<a href="addCustomers" type="button" class="btn btn-block btn-primary"><?php echo e(trans('labels.AddNewCustomers')); ?></a>
            </div>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		
				  <?php if(count($errors) > 0): ?>
					  <?php if($errors->any()): ?>
						<div class="alert alert-success alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <?php echo e($errors->first()); ?>

						</div>
					  <?php endif; ?>
				  <?php endif; ?>
              </div>
              
            </div>
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th><?php echo e(trans('labels.ID')); ?></th>
                      <th><?php echo e(trans('labels.Picture')); ?></th>
                      <th><?php echo e(trans('labels.PersonalInfo')); ?></th>
                      <th><?php echo e(trans('labels.Address')); ?></th>
                      <th><?php echo e(trans('labels.Action')); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php if(count($customers['result']) > 0): ?>
						<?php $__currentLoopData = $customers['result']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$listingCustomers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($listingCustomers->customers_id); ?></td>
								<td>
                                <?php if(!empty($listingCustomers->customers_picture)): ?>
                                <img src="../<?php echo e($listingCustomers->customers_picture); ?>" style="width: 100px; float: left; margin-right: 10px">
                                <?php else: ?>
                                <img src="../resources/assets/images/default_images/user.png" style="width: 100px; float: left; margin-right: 10px">
                                <?php endif; ?>
									
								</td>								
								<td>
                                	<!--<strong>UserName: </strong> <?php echo e($listingCustomers->user_name); ?><br>-->
                                    <strong><?php echo e(trans('labels.Name')); ?>: </strong> <?php echo e($listingCustomers->customers_firstname); ?> <?php echo e($listingCustomers->customers_lastname); ?> <br>
									<strong><?php echo e(trans('labels.DOB')); ?>: </strong> <?php echo e($listingCustomers->customers_dob); ?>  <br>
									<strong><?php echo e(trans('labels.Email')); ?>: </strong> <?php echo e($listingCustomers->customers_email_address); ?> <br>
									<strong><?php echo e(trans('labels.Telephone')); ?>: </strong> <?php echo e($listingCustomers->customers_telephone); ?> <br>
									<strong><?php echo e(trans('labels.Fax')); ?>: </strong> <?php echo e($listingCustomers->customers_fax); ?> <br>
                                    <strong><?php echo e(trans('labels.Devices')); ?>: </strong> 
                                    <?php if(count($listingCustomers->devices)>0): ?>
                                      <a href="javaScript:avoid(0)" id="notification-popup" customers_id = "<?php echo e($listingCustomers->customers_id); ?>"> 
                                    	<?php $__currentLoopData = $listingCustomers->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $devices_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        	<span>
                                            	<?php if($devices_data->device_type == 1): ?>
                                            		IOS
                                                <?php elseif($devices_data->device_type == 2): ?>
                                                	Android
                                                <?php endif; ?>
                                            </span> 
                                    	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </a>
                                    <?php endif; ?>
                                    </td>
								<td>
                                	<strong><?php echo e(trans('labels.Company')); ?>: </strong> <?php echo e($listingCustomers->entry_company); ?> <br>
                                    <!--<strong>Suburb: </strong> <?php echo e($listingCustomers->entry_suburb); ?> <br>-->
                                    <strong><?php echo e(trans('labels.Address')); ?>: </strong> 
                                    <?php if(!empty($listingCustomers->entry_street_address)): ?> 
                                    	<?php echo e($listingCustomers->entry_street_address); ?>,
                                    <?php endif; ?>
                                     <?php if(!empty($listingCustomers->entry_city)): ?> 
                                    	<?php echo e($listingCustomers->entry_city); ?>,
                                    <?php endif; ?>
                                     <?php if(!empty($listingCustomers->entry_state)): ?> 
                                    	<?php echo e($listingCustomers->entry_state); ?>,
                                    <?php endif; ?>
                                     <?php if(!empty($listingCustomers->entry_postcode)): ?> 
                                    	<?php echo e($listingCustomers->entry_postcode); ?>

                                    <?php endif; ?>
                                     <?php if(!empty($listingCustomers->countries_name)): ?> 
                                    	<?php echo e($listingCustomers->countries_name); ?>

                                    <?php endif; ?> 
                                    
                                </td>
								<td>
									<a data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.Edit')); ?>" href="editCustomers/<?php echo e($listingCustomers->customers_id); ?>" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 

									<a data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.Delete')); ?>" id="deleteCustomerFrom" customers_id="<?php echo e($listingCustomers->customers_id); ?>" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
								</td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    	<tr>
							<td colspan="4"><?php echo e(trans('labels.NoRecordFound')); ?></td>							
						</tr>
                    <?php endif; ?>
                  </tbody>
                </table>
                <?php if(count($customers['result']) > 0): ?>
					<div class="col-xs-12 text-right">
						<?php echo e($customers['result']->links()); ?>

					</div>
                 <?php endif; ?>
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
   
    <!-- deleteCustomerModal -->
	<div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="deleteCustomerModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteCustomerModalLabel"><?php echo e(trans('labels.DeleteCustomer')); ?></h4>
		  </div>
		  <?php echo Form::open(array('url' =>'admin/deleteCustomers', 'name'=>'deleteCustomer', 'id'=>'deleteCustomer', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

				  <?php echo Form::hidden('action',  'delete', array('class'=>'form-control')); ?>

				  <?php echo Form::hidden('customers_id',  '', array('class'=>'form-control', 'id'=>'customers_id')); ?>

		  <div class="modal-body">						
			  <p><?php echo e(trans('labels.DeleteCustomerText')); ?></p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(trans('labels.Close')); ?></button>
			<button type="submit" class="btn btn-primary"><?php echo e(trans('labels.DeleteCustomer')); ?></button>
		  </div>
		  <?php echo Form::close(); ?>

		</div>
	  </div>
	</div>
    
    <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content notificationContent">

		</div>
	  </div>
	</div>

    <!-- Main row --> 
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>