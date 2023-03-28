<?php $__env->startSection('content'); ?>
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?php echo e(trans('labels.Banners')); ?> <small><?php echo e(trans('labels.ListingAllBanners')); ?>...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
      <li class="active"><?php echo e(trans('labels.Banners')); ?></li>
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
            <h3 class="box-title"><?php echo e(trans('labels.ListingAllBanners')); ?> </h3>
            <div class="box-tools pull-right">
            	<a href="addBanner" type="button" class="btn btn-block btn-primary"><?php echo e(trans('labels.AddNewBanner')); ?></a>
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
                      <th><?php echo e(trans('labels.Title')); ?></th>
                      <th><?php echo e(trans('labels.Image')); ?></th>
                      <th><?php echo e(trans('labels.AddedModifiedDate')); ?></th>
                      <th><?php echo e(trans('labels.Action')); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if(count($result['banners'])>0): ?>
                    <?php $__currentLoopData = $result['banners']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$banners): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($banners->banners_id); ?></td>
                            <td><?php echo e($banners->banners_title); ?></td>
                            <td><img src="<?php echo e(asset('').'/'.$banners->banners_image); ?>" alt="" width=" 100px"></td>
                            <td><strong><?php echo e(trans('labels.AddedDate')); ?>: </strong> <?php echo e(date('d M, Y', strtotime($banners->date_added))); ?><br>
                            <strong><?php echo e(trans('labels.ModifiedDate')); ?>: </strong><?php if(!empty($banners->date_status_change)): ?> <?php echo e(date('d M, Y', strtotime($banners->date_status_change))); ?>  <?php endif; ?><br>
                            <strong><?php echo e(trans('labels.ExpiryDate')); ?>: </strong><?php if(!empty($banners->expires_date)): ?> <?php echo e(date('d M, Y', strtotime($banners->expires_date))); ?>  <?php endif; ?></td>
                            
                            <td><a data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.Edit')); ?>" href="editBanner/<?php echo e($banners->banners_id); ?>" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                            
                            <a data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.Delete')); ?>" id="deleteBannerId" banners_id ="<?php echo e($banners->banners_id); ?>" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                	<?php echo e($result['banners']->links()); ?>

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
    
    <!-- deleteBannerModal -->
	<div class="modal fade" id="deleteBannerModal" tabindex="-1" role="dialog" aria-labelledby="deleteBannerModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteBannerModalLabel"><?php echo e(trans('labels.DeleteBanner')); ?></h4>
		  </div>
		  <?php echo Form::open(array('url' =>'admin/deleteBanner', 'name'=>'deleteBanner', 'id'=>'deleteBanner', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

				  <?php echo Form::hidden('action',  'delete', array('class'=>'form-control')); ?>

				  <?php echo Form::hidden('banners_id',  '', array('class'=>'form-control', 'id'=>'banners_id')); ?>

		  <div class="modal-body">						
			  <p><?php echo e(trans('labels.DeleteBannerText')); ?></p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(trans('labels.Close')); ?></button>
			<button type="submit" class="btn btn-primary" id="deleteBanner"><?php echo e(trans('labels.Delete')); ?></button>
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