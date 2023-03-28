<?php $__env->startSection('content'); ?>
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?php echo e(trans('labels.Manufacturers')); ?> <small><?php echo e(trans('labels.ListingAllManufacturers')); ?>...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
      <li class="active"><?php echo e(trans('labels.Manufacturers')); ?></li>
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
            <h3 class="box-title"><?php echo e(trans('labels.ListingAllManufacturers')); ?> </h3>
            <div class="box-tools pull-right">
            	<a href="addManufacturer" type="button" class="btn btn-block btn-primary"><?php echo e(trans('labels.AddNewManufacturer')); ?></a>
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
                      <th><?php echo e(trans('labels.Name')); ?></th>
                      <th><?php echo e(trans('labels.Image')); ?></th>
                      <th><?php echo e(trans('labels.OtherInfo')); ?></th>
                      <th><?php echo e(trans('labels.Action')); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if(count($listingManufacturers)>0): ?>
                    <?php $__currentLoopData = $listingManufacturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$listingManufacturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($listingManufacturer->id); ?></td>
                            <td><?php echo e($listingManufacturer->name); ?></td>
                            <td><img src="<?php echo e(asset('').'/'.$listingManufacturer->image); ?>" alt="" width=" 100px"></td>
                            <td>
                            	<strong><?php echo e(trans('labels.ClickDate')); ?>: </strong> <?php echo e($listingManufacturer->clik_date); ?><br>
                                <strong><?php echo e(trans('labels.URL')); ?>: </strong><?php echo e($listingManufacturer->url); ?> <br>
                                <strong><?php echo e(trans('labels.Clicked')); ?>: </strong><?php echo e($listingManufacturer->url_clicked); ?>  
                            </td>
                            <td>
                            	<a data-toggle="tooltip" data-placement="bottom" title="Edit" href="editManufacturer/<?php echo e($listingManufacturer->id); ?>" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                                <a id="manufacturerFrom" manufacturers_id='<?php echo e($listingManufacturer->id); ?>' data-toggle="tooltip" data-placement="bottom" title="Delete" href="#" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php else: ?>
                       <tr>
                            <td colspan="5"><?php echo e(trans('labels.NoRecordFound')); ?></td>
                       </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	<?php echo e($listingManufacturers->links()); ?>

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
			<h4 class="modal-title" id="deleteManufacturerModalLabel"><?php echo e(trans('labels.DeleteManufacturer')); ?></h4>
		  </div>
		  <?php echo Form::open(array('url' =>'admin/deleteManufacturer', 'name'=>'deleteManufacturer', 'id'=>'deleteManufacturer', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

				  <?php echo Form::hidden('action',  'delete', array('class'=>'form-control')); ?>

				  <?php echo Form::hidden('manufacturers_id',  '', array('class'=>'form-control', 'id'=>'manufacturers_id')); ?>

		  <div class="modal-body">						
			  <p><?php echo e(trans('labels.DeleteManufacturerText')); ?></p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(trans('labels.Close')); ?></button>
			<button type="submit" class="btn btn-primary"><?php echo e(trans('labels.Delete')); ?></button>
		  </div>
		  <?php echo Form::close(); ?>

		</div>
	  </div>
	</div>
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>