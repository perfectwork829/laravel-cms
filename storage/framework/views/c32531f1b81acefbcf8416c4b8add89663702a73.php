<!DOCTYPE html>
<html>

<!-- meta contains meta taga, css and fontawesome icons etc -->
<?php echo $__env->make('admin.common.meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- ./end of meta -->

<body class="hold-transition login-page">
	<!-- wrapper -->
    <div class="wrapper">
    
        <!-- dynamic content -->
        <?php echo $__env->yieldContent('content'); ?>;  
        <!-- ./end of dynamic content -->        
    
    </div>
	<!-- ./wrapper -->

	<!-- all js scripts including custom js -->
	<?php echo $__env->make('admin.common.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- ./end of js scripts -->
    
	</body>
</html>
