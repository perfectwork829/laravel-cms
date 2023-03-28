<?php $__env->startSection('content'); ?>
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?php echo e(trans('labels.ProductsStock')); ?> <small><?php echo e(trans('labels.ProductsStock')); ?>...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
      <li class="active"><?php echo e(trans('labels.ProductsStock')); ?></li>
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
              <li class="<?php if(!isset($_REQUEST['action'])): ?> active  <?php endif; ?>"><a href="#low-in-stock" data-toggle="tab"> <?php echo e(trans('labels.LowInStock')); ?> </a></li>
              <li class="<?php if(isset($_REQUEST['action']) and $_REQUEST['action']=='outofstock'): ?> active  <?php endif; ?>"><a href="#out-of-stock" data-toggle="tab"> <?php echo e(trans('labels.OutofStock')); ?> </a></li>
            </ul>
            <div class="tab-content">
              <div class=" <?php if(!isset($_REQUEST['action'])): ?> active  <?php endif; ?> tab-pane" id="low-in-stock">
               <div class="box-body">
                    <div class="row">
                      <div class="col-xs-12">
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th><?php echo e(trans('labels.ID')); ?></th>
                              <th><?php echo e(trans('labels.Image')); ?></th>
                              <th><?php echo e(trans('labels.Products')); ?></th>
                              <th><?php echo e(trans('labels.Quantity')); ?></th>
                              <th><?php echo e(trans('labels.View')); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                         <?php if(count($result['lowQunatity']) > 0): ?>
                            <?php $__currentLoopData = $result['lowQunatity']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$lowQunatityProducts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($lowQunatityProducts->products_id); ?></td>
                                    <td><img src="<?php echo e(asset('').'/'.$lowQunatityProducts->products_image); ?>" alt="" width=" 100px" height="100px"></td>
                                    <td width="45%">
                                        <strong><?php echo e($lowQunatityProducts->products_name); ?> ( <?php echo e($lowQunatityProducts->products_model); ?> )</strong><br>
                                    </td>
                                    <td>
                                        <?php echo e($lowQunatityProducts->products_quantity); ?>

                                    </td>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="editProduct/<?php echo e($lowQunatityProducts->products_id); ?>" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>
                         </tbody>
                        </table>
                        <div class="col-xs-12 text-right">
                            <?php echo e($result['lowQunatity']->links()); ?>

                        </div>
                      </div>
                      
                    </div>
         		 </div>
              </div>
              <!-- /.tab-pane -->
              <div class="<?php if(isset($_REQUEST['action']) and $_REQUEST['action']=='outofstock'): ?> active  <?php endif; ?> tab-pane" id="out-of-stock">
                <!-- The timeline -->
                <div class="box-body">
                    <div class="row">
                      <div class="col-xs-12">
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th><?php echo e(trans('labels.ID')); ?></th>
                              <th><?php echo e(trans('labels.Image')); ?></th>
                              <th><?php echo e(trans('labels.Products')); ?></th>
                              <th><?php echo e(trans('labels.Quantity')); ?></th>
                              <th><?php echo e(trans('labels.View')); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php if(count($result['outOfStock']) > 0): ?>
                            <?php $__currentLoopData = $result['outOfStock']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$outOfStockData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <tr>
                                    <td><?php echo e($outOfStockData->products_id); ?></td>
                                    <td><img src="<?php echo e(asset('').'/'.$outOfStockData->products_image); ?>" alt="" width=" 100px" height="100px"></td>
                                    <td width="45%">
                                        <strong><?php echo e($outOfStockData->products_name); ?> ( <?php echo e($outOfStockData->products_model); ?> )</strong><br>
                                    </td>
                                    <td>
                                        <?php echo e($outOfStockData->products_quantity); ?>

                                    </td>
                                   
                                    <td>
                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="editProduct/<?php echo e($outOfStockData->products_id); ?>" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                                    </td>
                                </tr>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                          </tbody>
                        </table>
                        <div class="col-xs-12 text-right">
                            <?php echo e($result['outOfStock']->links()); ?>

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
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>