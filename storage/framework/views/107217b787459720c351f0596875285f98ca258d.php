<?php $__env->startSection('content'); ?>
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?php echo e(trans('labels.AdminProfile')); ?> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
      <li class="active"><?php echo e(trans('labels.AdminProfile')); ?> </li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo e(asset('').Auth::user()->image); ?>" alt="<?php echo e(Auth::user()->first_name); ?> profile picture">

              <h3 class="profile-username text-center"><?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?></h3>

              <p class="text-muted text-center"><?php echo e(trans('labels.Administrator')); ?></p>

             <!-- <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li>
              </ul>

              <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab"><?php echo e(trans('labels.Profile')); ?></a></li>
              <li><a href="#passwordDiv" data-toggle="tab"><?php echo e(trans('labels.Password')); ?></a></li>
            </ul>
            <div class="tab-content">
              <div class=" active tab-pane" id="profile">
            	  <?php if(count($errors) > 0): ?>
					  <?php if($errors->any()): ?>
                      <div class="alert alert-success alert-dismissible">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <h4><i class="icon fa fa-check"></i> <?php echo e(trans('labels.Success')); ?></h4>
                        <?php echo e($errors->first()); ?>

                      </div>
                  	<?php endif; ?>
				  <?php endif; ?>
                <!-- The timeline -->
                   <?php echo Form::open(array('url' =>'admin/updateProfile', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

                            <?php echo Form::hidden('myid', Auth::user()->myid, array('class'=>'form-control', 'id'=>'myid')); ?>

                            <?php echo Form::hidden('oldImage', Auth::user()->image, array('class'=>'form-control', 'id'=>'oldImage')); ?>

                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label"><?php echo e(trans('labels.AdminFirstName')); ?></label>
    
                        <div class="col-sm-10">
                          <?php echo Form::text('first_name', Auth::user()->first_name, array('class'=>'form-control', 'id'=>'first_name')); ?>

                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                          <?php echo e(trans('labels.AdminFirstNameText')); ?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label"><?php echo e(trans('labels.LastName')); ?></label>
    
                        <div class="col-sm-10">
                          <?php echo Form::text('last_name', Auth::user()->last_name, array('class'=>'form-control', 'id'=>'last_name')); ?>

                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                          <?php echo e(trans('labels.AdminLastNameText')); ?></span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label"><?php echo e(trans('labels.Picture')); ?>

                        </label>
    
                        <div class="col-sm-10">
                          <?php echo Form::file('newImage', array('id'=>'newImage')); ?><br>
						  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                       <?php echo e(trans('labels.PictureText')); ?></span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label"><?php echo e(trans('labels.Address')); ?> </label>
    
                        <div class="col-sm-10">
                          <?php echo Form::text('address', Auth::user()->address, array('class'=>'form-control', 'id'=>'address')); ?>

                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                          <?php echo e(trans('labels.AddressText')); ?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label"><?php echo e(trans('labels.City')); ?>

                        </label>
    
                        <div class="col-sm-10">
                         <?php echo Form::text('city', Auth::user()->city, array('class'=>'form-control', 'id'=>'city')); ?>

                         <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.CityText')); ?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label"><?php echo e(trans('labels.Country')); ?></label>
    					<div class="col-sm-10">                       
                            <select class="form-control" name="country" id="entry_country_id">
                            	<option value=""><?php echo e(trans('labels.SelectCountry')); ?></option>
                            	<?php $__currentLoopData = $result['countries']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $countries): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            		<option <?php if(Auth::user()->country==$countries->countries_id): ?> selected <?php endif; ?> value="<?php echo e($countries->countries_id); ?>"><?php echo e($countries->countries_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.CountryText')); ?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label"><?php echo e(trans('labels.State')); ?></label>
    					<div class="col-sm-10">
                           <select class="form-control zoneContent" name="state">
                            	<option value=""><?php echo e(trans('labels.SelectZone')); ?></option>
                            	<?php $__currentLoopData = $result['zones']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zones): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            		<option <?php if(Auth::user()->state==$zones->zone_id): ?> selected <?php endif; ?> value="<?php echo e($zones->zone_id); ?>"><?php echo e($zones->zone_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.SelectZoneText')); ?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label"><?php echo e(trans('labels.ZipCode')); ?></label>
    
                        <div class="col-sm-10">
                         <?php echo Form::text('zip', Auth::user()->zip, array('class'=>'form-control', 'id'=>'zip')); ?>

                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label"><?php echo e(trans('labels.Phone')); ?></label>
    
                        <div class="col-sm-10">
                         <?php echo Form::text('phone', Auth::user()->phone, array('class'=>'form-control', 'id'=>'phone')); ?>

                         <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                         <?php echo e(trans('labels.PhoneText')); ?></span>
                        </div>
                      </div>
                      
                      
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-success"><?php echo e(trans('labels.Update')); ?></button>
                        </div>
                      </div>
                    <?php echo Form::close(); ?>

              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="passwordDiv">
                 <?php echo Form::open(array('url' =>'admin/updateAdminPassword', 'onSubmit'=>'return validatePasswordForm()', 'id'=>'updateAdminPassword', 'name'=>'updateAdminPassword' , 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label"><?php echo e(trans('labels.NewPassword')); ?></label>
					<div class="col-sm-10">
                      <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.AdminPasswordRestriction')); ?></span>
                      <span style="display: none" class="help-block"></span>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="re-password" class="col-sm-2 control-label"><?php echo e(trans('labels.Re-EnterPassword')); ?></label>
					<div class="col-sm-10">
                      <input type="password" class="form-control" id="re_password" name="re_password" placeholder="Re-Enter Password">
                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.AdminPasswordRestriction')); ?></span>
                      <span style="display: none" class="help-block"></span>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger"><?php echo e(trans('labels.Update')); ?></button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
  <!-- /.content --> 
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>