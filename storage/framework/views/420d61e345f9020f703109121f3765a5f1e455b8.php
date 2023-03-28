<?php $__env->startSection('content'); ?>
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?php echo e(trans('labels.ManageLabel')); ?> <small><?php echo e(trans('labels.ManageLabel')); ?>...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
      <li><a href="<?php echo e(URL::to('admin/listingAppLabels')); ?>"><i class="fa fa-bars"></i> <?php echo e(trans('labels.ManageLabel')); ?></a></li>
      <li class="active"><?php echo e(trans('labels.ManageLabel')); ?></li>
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
            <h3 class="box-title">Manage Labels </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                        <!--<div class="box-header with-border">
                          <h3 class="box-title">Edit category</h3>
                        </div>-->
                        
                        <!-- /.box-header -->
                        <br>                       
                       <?php if(count($errors) > 0): ?>
							  <?php if($errors->any()): ?>
								<div class="alert alert-danger alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								  <?php echo e($errors->first()); ?>

								</div><br>

							  <?php endif; ?>
						<?php endif; ?>
                        
                        <?php if(session()->has('message')): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo e(session()->get('message')); ?>

                            </div><br>

                        <?php endif; ?>
						<div class="box-tools pull-right">
                            <a href="<?php echo e(URL::to('admin/addAppKey')); ?>" type="button" class="btn btn-block btn-primary"><?php echo e(trans('labels.AddNewKey')); ?></a>
                        </div><br>

                        <!-- form start -->                        
                         <div class="box-body">
                            <?php $__currentLoopData = $result['labels']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         
                            <?php echo Form::open(array('url' =>'admin/updateAppLabel', 'name'=>'form', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

								<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $labels_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								
								<?php $labels_data1 = $labels_data->values->toArray(); ?>
								<hr>
								<h4><strong><?php echo e(trans('labels.LabelKey')); ?>:</strong> <?php echo e($labels_data->label_name); ?></h4>
								<hr><br>

								<? //print_r($labels_data1);?> 
								<?php $i = 0; $j=0;?>
									<?php $__currentLoopData = $result['languages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$languages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


										<input type="hidden" name="label_id_<?=$labels_data->label_id?>" value="<?php echo e($labels_data->label_id); ?>">
					
										<div class="form-group">
										  <label for="name" class="col-sm-2 col-md-2 control-label"><?php echo e(trans('labels.LabelValue')); ?> (<?php echo e($languages->name); ?>)</label>
										  <div class="col-sm-10 col-md-10">
											<input type="text" name="label_value_<?=$languages->languages_id?>_<?=$labels_data->label_id?>" class="form-control" <?php if(!empty($labels_data1[$j]->language_id)): ?> value="<?php echo e($labels_data1[$j]->label_value); ?>" <?php endif; ?>>
											<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.LabelValue')); ?> (<?php echo e($languages->name); ?>).</span>
											<span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
										  </div>
										</div>

									 <?php 
										if(count($labels_data->values)>1) { $i++; }
										$j++;
									  ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>              
                            
                                                                
                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <a href="<?php echo e(URL::to('admin/listingLanguages')); ?>" type="button" class="pull-left btn btn-default"><?php echo e(trans('labels.back')); ?></a>
                                <button type="submit" class="btn btn-primary pull-right"><?php echo e(trans('labels.UpdateLabel')); ?></button>
                              </div>
                              <!-- /.box-footer -->
                            <?php echo Form::close(); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
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
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>