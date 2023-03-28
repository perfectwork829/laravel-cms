<script src="<?php echo asset('resources/views/admin/plugins/jQuery/jQuery-2.2.0.min.js'); ?>"></script>
<script src="<?php echo asset('resources/views/admin/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo asset('resources/views/admin/plugins/select2/select2.full.min.js'); ?>"></script>

<!-- InputMask -->
<script src="<?php echo asset('resources/views/admin/plugins/input-mask/jquery.inputmask.js'); ?>"></script>
<script src="<?php echo asset('resources/views/admin/plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>"></script>
<script src="<?php echo asset('resources/views/admin/plugins/input-mask/jquery.inputmask.extensions.js'); ?>"></script>

<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo asset('resources/views/admin/plugins/daterangepicker/daterangepicker.js'); ?>"></script>


<!-- bootstrap datepicker -->
<script src="<?php echo asset('resources/views/admin/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>

<!-- bootstrap color picker -->
<script src="<?php echo asset('resources/views/admin/plugins/colorpicker/bootstrap-colorpicker.min.js'); ?>"></script>
<!-- bootstrap time picker -->
<script src="<?php echo asset('resources/views/admin/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo asset('resources/views/admin/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo asset('resources/views/admin/plugins/iCheck/icheck.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?php echo asset('resources/views/admin/plugins/fastclick/fastclick.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo asset('resources/views/admin/dist/js/app.min.js'); ?>"></script>
<?php if(Request::path() == 'admin/dashboard/last_year' or Request::path() == 'admin/dashboard/last_month' or Request::path() == 'admin/dashboard/this_month'): ?>
    <!--<script src="<?php echo asset('resources/views/admin/dist/js/pages/dashboard.js'); ?>"></script>-->
<?php endif; ?>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo asset('resources/views/admin/js/demo.js'); ?>"></script>

<script src="<?php echo asset('resources/views/admin/plugins/chartjs/Chart.min.js'); ?>"></script>
<script src="<?php echo asset('resources/views/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
<script src="<?php echo asset('resources/views/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
<script src="<?php echo asset('resources/views/admin/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>

<script src="<?php echo asset('resources/views/admin/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>

<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo asset('resources/views/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>

<!-- Page script -->

<?php
/*date_default_timezone_set("UTC");*/
//$c_time = date('M d Y',time());
//$date = $c_time.' 11:59:59 PM';
//$exp_date = strtotime($date);
//$now = time();
//
///*print(date('M d Y H:i:s',$exp_date))."<br>";
//print(date('M d Y H:i:s',$now))."<br>";*/
//if ($now < $exp_date) {
//?>
<script>
// Count down milliseconds = server_end - server_now = client_end - client_now
//var server_end = <!--<?php //echo $exp_date; ?>--> * 1000;
//var server_now = <!--<?php //echo time(); ?>--> * 1000;
//var client_now = new Date().getTime();
//var end = server_end - server_now + client_now; // this is the real end time
//
//var _second = 1000;
//var _minute = _second * 60;
//var _hour = _minute * 60;
//var _day = _hour *24
//var timer;
//
//function showRemaining()
//{
//    var now = new Date();
//    var distance = end - now;
//    if (distance < 0 ) {
//       clearInterval( timer );
//       document.getElementById('countdown').innerHTML = 'EXPIRED!';
//
//       return;
//    }
//    var days = Math.floor(distance / _day);
//    var hours = Math.floor( (distance % _day ) / _hour );
//    var minutes = Math.floor( (distance % _hour) / _minute );
//    var seconds = Math.floor( (distance % _minute) / _second );
//
//    var countdown = document.getElementById('countdown');
//    countdown.innerHTML = '';
//    if (days) {
//        countdown.innerHTML += 'Days: ' + days + ' ';
//    }
//    countdown.innerHTML += 'Demo will be reset automatically after: ' + hours;
//    countdown.innerHTML +=  ':'+minutes;
//    countdown.innerHTML +=  ':'+seconds;
//}
//
//timer = setInterval(showRemaining, 1000);
//</script>
<?php
//} else {
//    echo "Times Up";
//}
//?>




<script type="text/javascript">

$(document).ready(function () {
$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
});
	
	$(function () {
	
		//Initialize Select2 Elements
		$(".select2").select2();
	
		//Datemask dd/mm/yyyy
		$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
		//Datemask2 mm/dd/yyyy
		$("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
		//Money Euro
		$("[data-mask]").inputmask();
	
		//Date range picker
		$('.reservation').daterangepicker();
		//Date range picker with time picker
		$('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
		//Date range as a button
	/*    $('#daterange-btn').daterangepicker(
			{
			  ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			  },
			  startDate: moment().subtract(29, 'days'),
			  endDate: moment()
			},
			function (start, end) {
			  $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			}
		);*/
	
		//Date picker
		$('#datepicker').datepicker({
		  autoclose: true
		});
	
		//iCheck for checkbox and radio inputs
		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
		  checkboxClass: 'icheckbox_minimal-blue',
		  radioClass: 'iradio_minimal-blue'
		});
		//Red color scheme for iCheck
		$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
		  checkboxClass: 'icheckbox_minimal-red',
		  radioClass: 'iradio_minimal-red'
		});
		//Flat red color scheme for iCheck
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		  checkboxClass: 'icheckbox_flat-green',
		  radioClass: 'iradio_flat-green'
		});
	
		//Colorpicker
		$(".my-colorpicker1").colorpicker();
		//color picker with addon
		$(".my-colorpicker2").colorpicker();
	
		//Timepicker
		$(".timepicker").timepicker({
		  showInputs: false
		});
	  });


$(document).on('click', '.checkboxess', function(e){
      checked = $("input[type=checkbox]:checked.checkboxess").length;
		//console.log(checked);
		 //return false;
      if(!checked) {
        //alert("You must check at least one checkbox.");
        return false;
      }

});

	
//ajax call for add option value
$(document).on('click', '.add-value', function(e){
	$("#loader").show();
	var parentFrom = $(this).parent('.addvalue-form');
	var language_id = parentFrom.children('#language_id').val();
	var products_options_id = parentFrom.children('#products_options_id').val();
	var formData = parentFrom.serialize();
	$.ajax({
		url: '<?php echo e(URL::to("admin/addAttributeValue")); ?>',
		type: "POST",
		data: formData,
		//async: false,
		success: function (res) {
				$('.addError').hide();
				$('#addAttributeModal').modal('hide');
				$("#content_"+products_options_id+'_'+language_id).parent('tbody').html(res);
		},
		//cache: false,
		//contentType: false,
		//processData: false
	});
		
});

//ajax call for add option value
$(document).on('click', '.update-value', function(e){
	$("#loader").show();
	var parentFrom = $(this).parent('.editvalue-form');
	var language_id = parentFrom.children('#language_id').val();
	var products_options_id = parentFrom.children('#products_options_id').val();
	var formData = parentFrom.serialize();
	console.log('language_id: '+language_id);
	console.log('products_options_id: '+products_options_id);
	$.ajax({
		url: '<?php echo e(URL::to("admin/updateAttributeValue")); ?>',
		type: "POST",
		data: formData,
		//async: false,
		success: function (res) {
				$('.addError').hide();
				//$("#content_"+products_options_id+'_'+language_id).parent('tbody').html(res);
				$("#content_"+products_options_id+'_'+language_id).parent('tbody').html(res);
		},
		//cache: false,
		//contentType: false,
		//processData: false
	});
		
});


//deleteAttribute
$(document).on('click', '#deleteAttribute', function(e){
	$("#loader").show();
	var parentFrom = $('#deleteValue');
	var language_id = parentFrom.children('#delete_language_id').val();
	var products_options_id = parentFrom.children('#delete_products_options_id').val();
	var formData = parentFrom.serialize();
	//console.log(formData);
	//console.log('language_id: '+language_id);
	//console.log('products_options_id: '+products_options_id);
	$.ajax({
		url: '<?php echo e(URL::to("admin/deleteValue")); ?>',
		type: "POST",
		data: formData,
		//async: false,
		success: function (res) {
				$('.addError').hide();
				//$("#content_"+products_options_id+'_'+language_id).parent('tbody').html(res);
				$("#content_"+products_options_id+'_'+language_id).parent('tbody').html(res);
				$('#deleteValueModal').modal('hide');
		},
		//cache: false,
		//contentType: false,
		//processData: false
	});
		
});

//ajax call for submit value
$(document).on('click', '#addAttribute', function(e){
	$("#loader").show();
	var formData = $('#addAttributeFrom').serialize();
	$.ajax({
		url: '<?php echo e(URL::to("admin/addNewProductAttribute")); ?>',
		type: "POST",
		data: formData,
		//async: false,
		success: function (res) {
			//console.log(res);
			//console.log(res.length);
			if(res.length != ''){
				$('.addError').hide();
				$('#addAttributeModal').modal('hide');
				var i;
				var showData = [];
				for (i = 0; i < res.length; ++i) {
					var j = i + 1; 
					showData[i] = "<tr><td>"+j+"</td><td>"+res[i].products_options_name+"</td><td>"+res[i].products_options_values_name+"</td><td>"+res[i].price_prefix+" "+res[i].options_values_price+"</td><td>    <a class='badge bg-light-blue editProductAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' ><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteProductAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' products_id = '"+res[i].products_id+"' ><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>"; 

				}
				$(".contentAttribute").html(showData);
			}else{
				//console.log("empty");
				$('.addError').show();
			}
			
			
		},
		//cache: false,
		//contentType: false,
		//processData: false
	});
		
		
});


//ajax call for submit value
$(document).on('click', '#addDefaultAttribute', function(e){
	$("#loader").show();
	var formData = $('#addDefaultAttributeFrom').serialize();
	$.ajax({
		url: '<?php echo e(URL::to("admin/addNewDefaultAttribute")); ?>',
		type: "POST",
		data: formData,
		//async: false,
		success: function (res) {
			//console.log(res);
			//console.log(res.length);
			if(res.length != ''){
				$('.addError').hide();
				$('#addDefaultAttributesModal').modal('hide');
				var i;
				var showData = [];
				for (i = 0; i < res.length; ++i) {
					var j = i + 1;
					showData[i] = "<tr><td>"+j+"</td><td>"+res[i].products_options_name+"</td><td>"+res[i].products_options_values_name+"</td><td><a class='badge bg-light-blue editDefaultAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' language_id ='"+res[i].language_id+"' options_id ='"+res[i].options_id+"'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteDefaultAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' products_id = '"+res[i].products_id+"' ><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>"; 

				}
				$(".contentDefaultAttribute").html(showData);
			}else{
				//console.log("empty");
				$('.addDefaultError').show();
			}
			
			
		},
		//cache: false,
		//contentType: false,
		//processData: false
	});
		
		
});

//onchange get zones agains country
$(document).on('change', '#entry_country_id', function(e){
	
	/*<?php if(Request::path() == 'admin/adminProfile'): ?>
		var getZones = '../getZones';
	<?php else: ?>
		var getZones = '../../getZones';
	<?php endif; ?>*/
	
	var zone_country_id = $(this).val();
	$.ajax({
	  url: "<?php echo e(URL::to('getZones')); ?>",
	  dataType: 'json',
	  type: "post",
	  data: '&zone_country_id='+zone_country_id,
	  success: function(data){
		//alert(data);
		//console.log(data.data[0].zone_id);
		//console.log(data.data.length);
		if(data.data.length>0){
			var i;
			var showData = [];
			for (i = 0; i < data.data.length; ++i) {
				showData[i] = "<option value='"+data.data[i].zone_id+"'>"+data.data[i].zone_name+"</option>"; 
			}
		}else{
			showData = "<option value=''>Select Zone</option>"; 				
		}
			$(".zoneContent").html(showData);
	  }
	});
	
});
//ajax call for submit value
$(document).on('click', '#addAddress', function(e){
	$("#loader").show();
	var formData = $('#addAddressFrom').serialize();
	$.ajax({
		url: '<?php echo e(URL::to("admin/addNewCustomerAddress")); ?>',
		type: "POST",
		data: formData,
		async: false,
		success: function (res) {
			console.log(res);
			console.log(res.length);
			if(res.length != ''){
				$('#addAdressModal').modal('hide');
				var i;
				var showData = [];
				for (i = 0; i < res.length; ++i) {
					var j = i + 1;
					//console.log(res[i]);
					showData[i] = "<tr><td>"+j+"</td><td><strong>Company:</strong> "+res[i].entry_company+"<br><strong>First Name:</strong> "+res[i].entry_firstname+"<br><strong>Last Name:</strong> "+res[i].entry_lastname+"</td><td><strong>Street:</strong> "+res[i].entry_street_address+"<br><strong>Suburb:</strong> "+res[i].entry_suburb+"<br><strong>Postcode:</strong> "+res[i].entry_postcode+"<br><strong>City:</strong> "+res[i].entry_city+"<br><strong>State:</strong> "+res[i].entry_state+"<br><strong>Zone:</strong> "+res[i].zone_name+"<br><strong>Country:</strong> "+res[i].countries_name+"</td><td><a class='badge bg-light-blue editAddressModal' customers_id = '"+res[i].customers_id+"' address_book_id = '"+res[i].address_book_id+"' ><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a><a customers_id = '"+res[i].customers_id+"' address_book_id = '"+res[i].address_book_id+"' class='badge bg-red deleteAddressModal'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>"; 

				}
				$(".contentAttribute").html(showData);
			}else{
				//console.log("empty");
			}
		},
	});
});

//editAddressModal
$(document).on('click', '.editAddressModal', function(){
	var customers_id = $(this).attr('customers_id');
	var address_book_id = $(this).attr('address_book_id');
	$.ajax({
		url: "<?php echo e(URL::to('admin/editAddress')); ?>",
		type: "POST",
		data: '&customers_id='+customers_id+'&address_book_id='+address_book_id,
		success: function (data) {
			$('.editContent').html(data); 
			$('#editAddressModal').modal('show');
		},
		dataType: 'html'
	});
});
	
	
		
//editProductAttributeModal
$(document).on('click', '.editProductAttributeModal', function(){
	var products_id = $(this).attr('products_id');
	var products_attributes_id = $(this).attr('products_attributes_id');
	var language_id = $(this).attr('language_id');	
	var options_id = $(this).attr('options_id');
	$.ajax({
		url: '<?php echo e(URL::to("admin/editProductAttribute")); ?>',
		type: "POST",
		data: '&products_id='+products_id+'&products_attributes_id='+products_attributes_id+'&language_id='+language_id+'&options_id='+options_id,
		success: function (data) {
			$('.editContent').html(data); 
			$('#editProductAttributeModal').modal('show');
		},
		dataType: 'html'
	});
});

//editDefaultAttributeModal
$(document).on('click', '.editDefaultAttributeModal', function(){
	var products_id = $(this).attr('products_id');
	var products_attributes_id = $(this).attr('products_attributes_id');
	var language_id = $(this).attr('language_id');
	var options_id = $(this).attr('options_id');
	$.ajax({
		url: "<?php echo e(URL::to('admin/editDefaultAttribute')); ?>",
		type: "POST",
		data: '&products_id='+products_id+'&products_attributes_id='+products_attributes_id+'&language_id='+language_id+'&options_id='+options_id,
		success: function (data) {
			$('.editDefaultContent').html(data); 
			$('#editDefaultAttributeModal').modal('show');
		},
		dataType: 'html'
	});
});

//udpate address
$(document).on('click', '#updateAddress', function(e){
		$("#loader").show();
		var formData = $('#editAddressFrom').serialize();
		$.ajax({
			url: "<?php echo e(URL::to('admin/updateAddress')); ?>",
			type: "POST",
			data: formData,
			//async: false,
			success: function (res) {
				//console.log(res);
				//console.log(res.length);
				if(res.length != ''){
					$('.addError').hide();
					$('#editAddressModal').modal('hide');
					var i;
					var showData = [];
					for (i = 0; i < res.length; ++i) {
					//console.log(res[i]);
					var j = i + 1;
					showData[i] = "<tr><td>"+j+"</td><td><strong>Company:</strong> "+res[i].entry_company+"<br><strong>First Name:</strong> "+res[i].entry_firstname+"<br><strong>Last Name:</strong> "+res[i].entry_lastname+"</td><td><strong>Street:</strong> "+res[i].entry_street_address+"<br><strong>Suburb:</strong> "+res[i].entry_suburb+"<br><strong>Postcode:</strong> "+res[i].entry_postcode+"<br><strong>City:</strong> "+res[i].entry_city+"<br><strong>State:</strong> "+res[i].entry_state+"<br><strong>Zone:</strong> "+res[i].zone_name+"<br><strong>Country:</strong> "+res[i].countries_name+"</td><td><a class='badge bg-light-blue editAddressModal' customers_id = '"+res[i].customers_id+"' address_book_id = '"+res[i].address_book_id+"' ><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a><a customers_id = '"+res[i].customers_id+"' address_book_id = '"+res[i].address_book_id+"' class='badge bg-red deleteAddressModal'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>"; 

					}
					$(".contentAttribute").html(showData);
					
				}else{
					//console.log("empty");
					$('.addError').show();
				}


			},
			//cache: false,
			//contentType: false,
			//processData: false
		});
		
	});
	
	
		
	$(document).on('click', '#updateProductAttribute', function(e){
		$("#loader").show();
		var formData = $('#editAttributeFrom').serialize();
		$.ajax({
			url: '<?php echo e(URL::to("admin/updateProductAttribute")); ?>',
			type: "POST",
			data: formData,
			//async: false,
			success: function (res) {
				//console.log(res);
				//console.log(res.length);
				if(res.length != ''){
					$('.addError').hide();
					$('#editProductAttributeModal').modal('hide');
					var i;
					var showData = [];
					for (i = 0; i < res.length; ++i) {
						var j = i + 1;
						showData[i] = "<tr><td>"+j+"</td><td>"+res[i].products_options_name+"</td><td>"+res[i].products_options_values_name+"</td><td>"+res[i].price_prefix+" "+res[i].options_values_price+"</td><td>    <a class='badge bg-light-blue editProductAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' products_id = '"+res[i].products_id+"'  language_id = '"+res[i].language_id+"'  options_id = '"+res[i].options_id+"'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteProductAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' products_id = '"+res[i].products_id+"' language_id = '"+res[i].language_id+"'  options_id = '"+res[i].options_id+"'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>"; 

					}
					$(".contentAttribute").html(showData);
				}else{
					//console.log("empty");
					$('.addError').show();
				}


			},
			//cache: false,
			//contentType: false,
			//processData: false
		});
		
	});
	
	
	$(document).on('click', '#updateDefaultAttribute', function(e){
		$("#loader").show();
		var formData = $('#editDefaultAttributeFrom').serialize();
		$.ajax({
			url: "<?php echo e(URL::to('admin/updateDefaultAttribute')); ?>",
			type: "POST",
			data: formData,
			//async: false,
			success: function (res) {
				//console.log(res);
				console.log(res.length);
				if(res.length != ''){
					$('.addError').hide();
					$('#editDefaultAttributeModal').modal('hide');
					var i;
					var showData = [];
					for (i = 0; i < res.length; ++i) {
						var j = i + 1;
						showData[i] = "<tr><td>"+j+"</td><td>"+res[i].products_options_name+"</td><td>"+res[i].products_options_values_name+"</td><td><a class='badge bg-light-blue editDefaultAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' language_id ='"+res[i].language_id+"' options_id ='"+res[i].options_id+"'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteDefaultAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' products_id = '"+res[i].products_id+"' ><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";
					}
					$(".contentDefaultAttribute").html(showData);
				}else{
					//console.log("empty");
					$('.addError').show();
				}


			},
			//cache: false,
			//contentType: false,
			//processData: false
		});
		
	});
	
	
	
	//deleteAddressModal
	$(document).on('click', '.deleteAddressModal', function(){
		var customers_id = $(this).attr('customers_id');
		var address_book_id = $(this).attr('address_book_id');
		$('#customers_id').val(customers_id);
		$('#address_book_id').val(address_book_id);
		$('#deleteAddressModal').modal('show');
	});
		
	//deleteAddress
	$(document).on('click', '#deleteAddressBtn', function(){
		$("#loader").show();
		var formData = $('#deleteAddress').serialize();
		console.log(formData);
		$.ajax({
			url: "<?php echo e(URL::to('admin/deleteAddress')); ?>",
			type: "POST",
			data: formData,
			success: function (res) {
				//$('.deleteEmbed').html(res); 
				//alert(res);
				$('#deleteAddressModal').modal('hide');
				if(res.length != ''){
					var i;
					var showData = [];
					for (i = 0; i < res.length; ++i) {
					//console.log(res[i]);
					var j = i + 1;
					showData[i] = "<tr><td>"+j+"</td><td><strong>Company:</strong> "+res[i].entry_company+"<br><strong>First Name:</strong> "+res[i].entry_firstname+"<br><strong>Last Name:</strong> "+res[i].entry_lastname+"</td><td><strong>Street:</strong> "+res[i].entry_street_address+"<br><strong>Suburb:</strong> "+res[i].entry_suburb+"<br><strong>Postcode:</strong> "+res[i].entry_postcode+"<br><strong>City:</strong> "+res[i].entry_city+"<br><strong>State:</strong> "+res[i].entry_state+"<br><strong>Zone:</strong> "+res[i].zone_name+"<br><strong>Country:</strong> "+res[i].countries_name+"</td><td><a class='badge bg-light-blue editAddressModal' customers_id = '"+res[i].customers_id+"' address_book_id = '"+res[i].address_book_id+"' ><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a><a customers_id = '"+res[i].customers_id+"' address_book_id = '"+res[i].address_book_id+"' class='badge bg-red deleteAddressModal'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>"; 

					}
					//$(".contentAttribute").html(showData);
					
				}else{
					//console.log("empty");
					var showData = "<tr><td colspan='5'><strong>No record found!</strong> Please click on '<strong>Add Address</strong>' to add address.</td></tr>";
				}
					$(".contentAttribute").html(showData);
			},
		});
	});
	
	//device id
	/*$(document).on('click', '#deletedeviceId', function(){
		var devices_id = $(this).attr('devices_id');
		$('#devices_id').val(devices_id);
		$('#deletedeviceModal').modal('show');
	})
	
	//DeviceDeletedMessage
	$(document).on('click', '.deleteProductAttributeModal', function(){
		var products_id = $(this).attr('products_id');
		var products_attributes_id = $(this).attr('products_attributes_id');
		$.ajax({
			url: "<?php echo e(URL::to('admin/deleteProductAttributeModal')); ?>",
			type: "POST",
			data: '&products_id='+products_id+'&products_attributes_id='+products_attributes_id,
			success: function (data) {
				$('.deleteEmbed').html(data); 
				$('#deleteProductAttributeModal').modal('show');
			},
			dataType: 'html'
		});
	});*/
	
	
	//deleteProductAttributeModal
	$(document).on('click', '.deleteProductAttributeModal', function(){
		var products_id = $(this).attr('products_id');
		var products_attributes_id = $(this).attr('products_attributes_id');
		$.ajax({
			url: "<?php echo e(URL::to('admin/deleteProductAttributeModal')); ?>",
			type: "POST",
			data: '&products_id='+products_id+'&products_attributes_id='+products_attributes_id,
			success: function (data) {
				$('.deleteEmbed').html(data); 
				$('#deleteProductAttributeModal').modal('show');
			},
			dataType: 'html'
		});
	});
	
	//deleteDefaultAttributeModal
	$(document).on('click', '.deleteDefaultAttributeModal', function(){
		var products_id = $(this).attr('products_id');
		var products_attributes_id = $(this).attr('products_attributes_id');
		$.ajax({
			url: "<?php echo e(URL::to('admin/deleteDefaultAttributeModal')); ?>",
			type: "POST",
			data: '&products_id='+products_id+'&products_attributes_id='+products_attributes_id,
			success: function (data) {
				$('.deleteDefaultEmbed').html(data); 
				$('#deleteDefaultAttributeModal').modal('show');
			},
			dataType: 'html'
		});
	});
	
	//deleteOption
	$(document).on('click', '.deleteOption', function(){
		$("#loader").show();
		var option_id = $(this).attr('option_id');
		//alert(option_id);
		$.ajax({
			url: "<?php echo e(URL::to('admin/checkAttributeAssociate')); ?>",
			type: "POST",
			data: '&option_id='+option_id,
			success: function (res) {
				//$('.deleteEmbed').html(res); 
				//alert(res);
				if(res.length != ''){
					$('.addError').hide();
					$("#assciate-products").html(res);
					$('#productListModal').modal('show');
				}else{
					$('#option_id').val(option_id);
					$('#productListModal').modal('hide');
					$('#deleteAttributeModal').modal('show');
					$(".contentAttribute").html(res);
				}
			},
		});
	});
	
	//deleteOption
	$(document).on('click', '.delete-value', function(){
		$("#loader").show();
		var value_id = $(this).attr('value_id');
		var delete_products_options_id = $(this).attr('option_id');
		var delete_language_id = $(this).attr('language_id');
		//alert(delete_language_id);
		$.ajax({
			url: "<?php echo e(URL::to('admin/checkValueAssociate')); ?>",
			type: "POST",
			data: '&value_id='+value_id,
			success: function (res) {
				//$('.deleteEmbed').html(res); 
				//alert(res);
				if(res.length != ''){
					$('.addError').hide();
					$("#assciate-products-value").html(res);
					$('#productListModalValue').modal('show');
				}else{
					$('#value_id').val(value_id);
					$('#delete_products_options_id').val(delete_products_options_id);
					$('#delete_language_id').val(delete_language_id);
					$('#productListModalValue').modal('hide');
					$('#deleteValueModal').modal('show');
					$(".contentAttribute").html(res);
				}
			},
		});
	});
		
	//deleteProductAttribute
	$(document).on('click', '#deleteProductAttribute', function(){
		$("#loader").show();
		var formData = $('#deleteAttributeForm').serialize();
		console.log(formData);
		$.ajax({
			url: "<?php echo e(URL::to('admin/deleteProductAttribute')); ?>",
			type: "POST",
			data: formData,
			success: function (res) {
				//$('.deleteEmbed').html(res); 
				//alert(res);
				if(res.length != ''){
					$('.addError').hide();
					$('#deleteProductAttributeModal').modal('hide');
					var i;
					var showData = [];
					for (i = 0; i < res.length; ++i) {
						var j = i + 1;
						showData[i] = "<tr><td>"+j+"</td><td>"+res[i].products_options_name+"</td><td>"+res[i].products_options_values_name+"</td><td>"+res[i].price_prefix+" "+res[i].options_values_price+"</td><td>    <a class='badge bg-light-blue editProductAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' products_id = '"+res[i].products_id+"'  language_id = '"+res[i].language_id+"'  options_id = '"+res[i].options_id+"'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteProductAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' products_id = '"+res[i].products_id+"' language_id = '"+res[i].language_id+"'  options_id = '"+res[i].options_id+"'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>"; 
					}
					//console.log(res.length);
					$(".contentAttribute").html(showData);
				}else{
					
					$('#deleteProductAttributeModal').modal('hide');
					//console.log("empty");
					$('.addError').show();
					$(".contentAttribute").html(res);
				}
			},
		});
	});
	
	
	
	
	//deleteDefaultAttributeModal
	$(document).on('click', '#deleteDefaultAttribute', function(){
		$("#loader").show();
		var formData = $('#deleteDefaultAttributeForm').serialize();
		console.log(formData);
		$.ajax({
			url: "<?php echo e(URL::to('admin/deleteDefaultAttribute')); ?>",
			type: "POST",
			data: formData,
			success: function (res) {
				//$('.deleteEmbed').html(res); 
				//alert(res);
				if(res.length != ''){
					$('.addError').hide();
					$('#deleteDefaultAttributeModal').modal('hide');
					var i;
					var showData = [];
					for (i = 0; i < res.length; ++i) {
						var j = i + 1;
						showData[i] = "<tr><td>"+j+"</td><td>"+res[i].products_options_name+"</td><td>"+res[i].products_options_values_name+"</td><td><a class='badge bg-light-blue editDefaultAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' language_id ='"+res[i].language_id+"' options_id ='"+res[i].options_id+"'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteDefaultAttributeModal' products_attributes_id = '"+res[i].products_attributes_id+"' products_id = '"+res[i].products_id+"' ><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>"; 
					}
					//console.log(res.length);
					$(".contentDefaultAttribute").html(showData);
				}else{
					
					$('#deleteDefaultAttributeModal').modal('hide');
					//console.log("empty");
					$('.addDefaultError').show();
					$(".contentDefaultAttribute").html(res);
				}
			},
		});
	});
		
	//ajax call for submit value
	$(document).on('click', '#addImage', function(e){
		$("#loader").show();
		var formData = new FormData($('#addImageFrom')[0]);
		$.ajax({
			url: '<?php echo e(URL::to("admin/addNewProductImage")); ?>',
			type: "POST",
			data: formData,
			//async: false,
			success: function (res) {
				//console.log(res);
				console.log(res);
				if(res.length != ''){
					$('.addError').hide();
					$('#addImagesModal').modal('hide');
					var i;
					var showData = [];
					for (i = 0; i < res.length; ++i) {
						var j = i + 1;
						showData[i] = "<tr><td>"+j+"</td><td><img src=<?php echo e(asset('').'/'); ?>"+res[i].image+" alt='' width=' 100px'></td><td>"+res[i].htmlcontent+"</td> <td><a products_id = '"+res[i].products_id+"' class='badge bg-light-blue editProductImagesModal' id = '"+res[i].id+"' ><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteProductImagesModal' id = '"+res[i].id+"' products_id = '"+res[i].products_id+"' ><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>"; 
					}
					$(".contentImages").html(showData);
				}else{
					$('.addError').show();
				}


			},
			cache: false,
			contentType: false,
			processData: false
		});
		
		
	});
		
	//editProductImagesModal
	$(document).on('click', '.editProductImagesModal', function(){
		var id = $(this).attr('id');
		var products_id = $(this).attr('products_id');
		$.ajax({
			url: '<?php echo e(URL::to("admin/editProductImage")); ?>',
			type: "POST",
			data: '&products_id='+products_id+'&id='+id,
			success: function (data) {
				$('.editImageContent').html(data); 
				$('#editProductImagesModal').modal('show');
			},
			dataType: 'html'
		});
	});
	
		
	$(document).on('click', '#updateProductImage', function(e){
		$("#loader").show();
		var formData = new FormData($('#editImageFrom')[0]);
		$.ajax({
			url: "<?php echo e(URL::to('admin/updateProductImage')); ?>",
			type: "POST",
			data: formData,
			//async: false,
			success: function (res) {
				//console.log(res);
				//console.log(res.length);
				if(res.length != ''){
					$('.addError').hide();
					$('#editProductImagesModal').modal('hide');
					var i;
					var showData = [];
					for (i = 0; i < res.length; ++i) {
						var j = i + 1;
						showData[i] = "<tr><td>"+j+"</td><td><img src=<?php echo e(asset('').'/'); ?>"+res[i].image+" alt='' width=' 100px'></td><td>"+res[i].htmlcontent+"</td> <td><a products_id = '"+res[i].products_id+"' class='badge bg-light-blue editProductImagesModal' id = '"+res[i].id+"' ><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteProductImagesModal' id = '"+res[i].id+"' products_id = '"+res[i].products_id+"' ><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";

					}
					$(".contentImages").html(showData);
				}else{
					//console.log("empty");
					$('.addError').show();
				}


			},
			cache: false,
			contentType: false,
			processData: false
		});
		
	});	
		
	//send push Notification
	$(document).on('click', '#send-notificaion', function(){
		$('.not-sent').addClass('hide');
		$('.sent-push').addClass('hide');
		var title = $('#title').val();
		var message = $('#message').val();
		
		if(title !=''){
			$('.title-error').addClass('hidden');
			$('.title-error').closest('.form-group').removeClass('has-error');
			if(message !=''){
				
				$('.message-error').closest('.form-group').removeClass('has-error');
				$('.message-error').addClass('hidden');
				
				var device_type = $('#device_type').val();
				var device_id = $('#device_id').val();
				
				$.ajax({
					url: "<?php echo e(URL::to('admin/notifyUser')); ?>",
					type: "POST",
					data: 'device_type='+device_type+'&title='+title+'&message='+message+'&device_id='+device_id,
					success: function (res) {
						$('.sent-push').addClass('hide');
						$('.not-sent').addClass('hide');
						if($.trim(res) == '1'){
							$('.sent-push').removeClass('hide');
						}else{
							$('.not-sent').removeClass('hide');
						}
					},
				});
			
			}else{
				$('.message-error').closest('.form-group').addClass('has-error');
				$('.message-error').removeClass('hidden');
			}
			
		}else{
			$('.title-error').closest('.form-group').addClass('has-error');
			$('.title-error').removeClass('hidden');
		}
		
	});

	//deleteProductImagesModal
	$(document).on('click', '.deleteProductImagesModal', function(){
		var id = $(this).attr('id');
		var products_id = $(this).attr('products_id');
		$.ajax({
			url: '<?php echo e(URL::to("admin/deleteProductImageModal")); ?>',
			type: "POST",
			data: '&products_id='+products_id+'&id='+id,
			success: function (data) {
				$('.deleteImageEmbed').html(data); 
				$('#deleteProductImageModal').modal('show');
			},
			dataType: 'html'
		});
	});
		
	//deleteProductImage
	$(document).on('click', '#deleteProductImage', function(){
		$("#loader").show();
		var formData = $('#deleteImageForm').serialize();
		console.log(formData);
		$.ajax({
			url: "<?php echo e(URL::to('admin/deleteProductImage')); ?>",
			type: "POST",
			data: formData,
			success: function (res) {
				//$('.deleteEmbed').html(res); 
				//alert(res);
				if(res.length != ''){
					$('.addError').hide();
					$('#deleteProductImageModal').modal('hide');
					var i;
					var showData = [];
					for (i = 0; i < res.length; ++i) {
						var j = i + 1;
						showData[i] = "<tr><td>"+j+"</td><td><img src=<?php echo e(asset('').'/'); ?>"+res[i].image+" alt='' width=' 100px'></td><td>"+res[i].htmlcontent+"</td> <td><a products_id = '"+res[i].products_id+"' class='badge bg-light-blue editProductImagesModal' id = '"+res[i].id+"' ><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteProductImagesModal' id = '"+res[i].id+"' products_id = '"+res[i].products_id+"' ><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";
					}
					//console.log(res.length);
					$(".contentImages").html(showData);
				}else{
					var showData = '<tr><td colspan="4"><strong>No record found!</strong> Please click on "<strong>Add Product Images</strong>" to add images.</td></tr>';
					$('#deleteProductImageModal').modal('hide');
					//console.log("empty");
					//$('.addError').show();
					$(".contentImages").html(showData);
				}
			},
		});
	});
	
	
	//ajax call for notification pop
	$(document).on('click', '#notification-popup', function(){
		var customers_id = $(this).attr('customers_id');
		$.ajax({
			//url: '<?php echo e(URL::to("admin/editProductAttribute")); ?>',
			url: '<?php echo e(URL::to("admin/customerNotification")); ?>',
			type: "POST",
			data: '&customers_id='+customers_id,
			success: function (data) {
				$('.notificationContent').html(data); 
				$('#notificationModal').modal('show');
				
				//$('.editContent').html(data); 
				//$('#editProductAttributeModal').modal('show');
			},
			dataType: 'html'
		});
	});
	
	//get products for coupon
	$(document).on('focus', '.couponProdcuts input', function(){
		//var products = $(".couponProdcuts .select2-selection__rendered .select2-selection__choice").attr('title');
		//console.log(products);
		var products = $(this).attr('products_id');
		$.ajax({
			url: "<?php echo e(URL::to('admin/couponProducts')); ?>",
			type: "POST",
			//data: '&products_id='+products_id+'&products_attributes_id='+products_attributes_id,
			data: '',
			success: function (data) {
			},
			dataType: 'html'
		});
	});
	
	//call function on window load
	<?php if(Request::path() == 'admin/editProduct/*'): ?>
		getSubCategory();
	<?php endif; ?>
	//special product
	showSpecial();
			
	//deleteProductModal
	$(document).on('click', '#deleteProductId', function(){
		var products_id = $(this).attr('products_id');
		$('#products_id').val(products_id);
		$("#deleteProductModal").modal('show');
	});
		
	//deleteAttributeModal
	$(document).on('click', '#deleteAttributeFrom', function(){
		var option_id = $(this).attr('option_id');
		$('#option_id').val(option_id);
		$("#deleteAttributeModal").modal('show');
	});
	
	
	//deleteCustomerModal
	$(document).on('click', '#deleteCustomerFrom', function(){
		var customers_id = $(this).attr('customers_id');
		$('#customers_id').val(customers_id);
		$("#deleteCustomerModal").modal('show');
	});
	
	//deletemanufacturerModal
	$(document).on('click', '#manufacturerFrom', function(){
		var manufacturers_id = $(this).attr('manufacturers_id');
		$('#manufacturers_id').val(manufacturers_id);
		$("#manufacturerModal").modal('show');
	});
	
	//deleteCountrytModal
	$(document).on('click', '#deleteCountryId', function(){
		var countries_id = $(this).attr('countries_id');
		$('#countries_id').val(countries_id);
		$("#deleteCountryModal").modal('show');
	});
	
	//deleteZoneModal
	$(document).on('click', '#deletezoneId', function(){
		var zone_id = $(this).attr('zone_id');
		$('#zone_id').val(zone_id);
		$("#deleteZoneModal").modal('show');
	});
	
	//deleteTaxClassModal
	$(document).on('click', '#deleteTaxClassId', function(){
		var tax_class_id = $(this).attr('tax_class_id');
		$('#tax_class_id').val(tax_class_id);
		$("#deleteTaxClassModal").modal('show');
	});
	
	//deleteTaxRateModal
	$(document).on('click', '#deleteTaxRateId', function(){
		var tax_rates_id = $(this).attr('tax_rates_id');
		$('#tax_rates_id').val(tax_rates_id);
		$("#deleteTaxRateModal").modal('show');
	});
	
	//deleteOrderStatusModal
	$(document).on('click', '#deleteOrderStatusId', function(){
		var orders_status_id = $(this).attr('orders_status_id');
		$('#orders_status_id').val(orders_status_id);
		$("#deleteOrderStatusModal").modal('show');
	});
	
	//deletelanguageModal
	$(document).on('click', '#deleteLanguageId', function(){
		var languages_id = $(this).attr('languages_id');
		$('#languages_id').val(languages_id);
		$("#deleteLanguagesModal").modal('show');
	});
	
	//deleteTaxRateModal
	$(document).on('click', '#deleteCoupans_id', function(){
		var coupans_id = $(this).attr('coupans_id');
		$('#coupans_id').val(coupans_id);
		$("#deleteCoupanModal").modal('show');
	});
	
	//deleteTaxClassModal
	$(document).on('click', '#deleteBannerId', function(){
		var banners_id = $(this).attr('banners_id');
		$('#banners_id').val(banners_id);
		$("#deleteBannerModal").modal('show');
	});
	
	//deleteNewsCategoryModal
	$(document).on('click', '#deleteNewsCategroyId', function(){
		var id = $(this).attr('category_id');
		$('#id').val(id);
		$("#deleteNewsCategoryModal").modal('show');
	});
	
	//deleteNewsModal
	$(document).on('click', '#deleteNewsId', function(){
		var id = $(this).attr('news_id');
		$('#id').val(id);
		$("#deleteNewsModal").modal('show');
	});
	
	//deletePageModal
	$(document).on('click', '#deletePageId', function(){
		var id = $(this).attr('page_id');
		$('#id').val(id);
		$("#deletePageModal").modal('show');
	});
	
	//deleteTaxClassModal
	$(document).on('click', '#deleteOrdersId', function(){
		var orders_id = $(this).attr('orders_id');
		$('#orders_id').val(orders_id);
		$("#deleteModal").modal('show');
	});
	
	
	//edit option value
	$(document).on('click', '.edit-value', function(){
		var value = $(this).attr('value');
		$(".form-p-"+value).hide();
		$(".form-content-"+value).show();
	});
	
	//cancel option value
	$(document).on('click', '.cancel-value', function(){
		var value = $(this).attr('value');
		$(".form-content-"+value).hide();
		$(".form-p-"+value).show();
	});
	
	
	
	<?php if(Request::is('admin/editCustomers/*')): ?>
	{
		changePassword();
	}
	<?php endif; ?>
 
	//getRange
	$(document).on('click', '.getRange', function(){
		var dateRange = $('.dateRange').val();
		if(dateRange != ''){
			$('.dateRange').parent('.input-group').removeClass('has-error');
			dateRange = dateRange.replace(/-/g , "_");
			dateRange = dateRange.replace(/\//g , "-");
			dateRange = dateRange.replace(/ /g , "");
			//alert(dateRange);
			window.location="<?php echo e(URL::to('admin/dashboard/dateRange=')); ?>"+dateRange;
		}else{
			$('.dateRange').parent('.input-group').addClass('has-error');
		}
	});
	
	//getRange
	$(document).on('click', '.default_method', function(){
		var shipping_id = $(this).attr('shipping_id');
		//alert(shipping_id);
		$.ajax({
			url: '<?php echo e(URL::to("admin/defaultShippingMethod")); ?>',
			type: "POST",
			data: '&shipping_id='+shipping_id,
			success: function (data) {
				$('.default-div').removeClass('hidden');
			},
		});
	});
	
	//product options language
	$(document).on('change', '.language_id', function(){
		var language_id = $(this).val();
		getOptions(language_id);
	});
	
	//product options option with language id
	$(document).on('change', '.default-option-id', function(){
		var option_id = $(this).val();
		getOptionsValue(option_id);
	});
	
	//product options language
	$(document).on('change', '.edit_language_id', function(){
		var language_id = $(this).val();
		getEditOptions(language_id);
	});
	
	//product options option with language id
	$(document).on('change', '.edit-default-option-id', function(){
		var option_id = $(this).val();
		getEditOptionsValue(option_id);
	});
	
	
	
	
	
	
	//product options language
	$(document).on('change', '.additional_language_id', function(){
		var language_id = $(this).val();
		getAdditionalOptions(language_id);
	});
	
	//product options option with language id
	$(document).on('change', '.additional-option-id', function(){
		var option_id = $(this).val();
		getAdditionalOptionsValue(option_id);
	});
	
	//product options language
	$(document).on('change', '.edit_additional_language_id', function(){
		var language_id = $(this).val();
		getEditAdditionalOptions(language_id);
	});
	
	//product options option with language id
	$(document).on('change', '.edit-additional-option-id', function(){
		var option_id = $(this).val();
		getEditAdditionalOptionsValue(option_id);
	});
	
	
	
});
	
function getOptions(languages_id) {
	//alert(languages_id);
	$.ajax({
		url: '<?php echo e(URL::to("admin/getOptions")); ?>',
		type: "POST",
		data: '&languages_id='+languages_id,
		success: function (data) {
			/*if(data.length != ''){
			}
			*/
			$('.default-option-id').html(data);
		},
	});
}

	
function getOptionsValue(option_id) {
	var language_id = $('.language_id').val();
	$.ajax({
		url: '<?php echo e(URL::to("admin/getOptionsValue")); ?>',
		type: "POST",
		data: '&option_id='+option_id+'&language_id='+language_id,
		success: function (data) {
			$('.products_options_values_id').html(data);
		},
	});
}

function getEditOptions(languages_id) {
	//alert(languages_id);
	$.ajax({
		url: '<?php echo e(URL::to("admin/getOptions")); ?>',
		type: "POST",
		data: '&languages_id='+languages_id,
		success: function (data) {
			/*if(data.length != ''){
			}
			*/
			$('.edit-default-option-id').html(data);
		},
	});
}

	
function getEditOptionsValue(option_id) {
	
	var language_id = $('.edit_language_id').val();
	//alert(language_id);
	$.ajax({
		url: '<?php echo e(URL::to("admin/getOptionsValue")); ?>',
		type: "POST",
		data: '&option_id='+option_id+'&language_id='+language_id,
		success: function (data) {
			$('.edit-products_options_values_id').html(data);
		},
	});
}






function getAdditionalOptions(languages_id) {
	//alert(languages_id);
	$.ajax({
		url: '<?php echo e(URL::to("admin/getOptions")); ?>',
		type: "POST",
		data: '&languages_id='+languages_id,
		success: function (data) {
			/*if(data.length != ''){
			}
			*/
			$('.additional-option-id').html(data);
		},
	});
}

	
function getAdditionalOptionsValue(option_id) {
	
	var language_id = $('.additional_language_id').val();
	$.ajax({
		url: '<?php echo e(URL::to("admin/getOptionsValue")); ?>',
		type: "POST",
		data: '&option_id='+option_id+'&language_id='+language_id,
		success: function (data) {
			$('.additional_products_options_values_id').html(data);
		},
	});
}

function getEditAdditionalOptions(languages_id) {
	//alert(languages_id);
	$.ajax({
		url: '<?php echo e(URL::to("admin/getOptions")); ?>',
		type: "POST",
		data: '&languages_id='+languages_id,
		success: function (data) {
			$('.edit-additional-option-id').html(data);
		},
	});
}

	
function getEditAdditionalOptionsValue(option_id) {
	
	var language_id = $('.edit_additional_language_id').val();
	//alert(language_id);
	$.ajax({
		url: '<?php echo e(URL::to("admin/getOptionsValue")); ?>',
		type: "POST",
		data: '&option_id='+option_id+'&language_id='+language_id,
		success: function (data) {
			$('.edit-additional-products_options_values_id').html(data);
		},
	});
}





//getSubCategory
function getSubCategory() {
	
	<?php if(Request::path() == 'admin/addProduct'): ?>
		//var getCategories = 'getCategories';
	 	var getCategories =	'<?php echo e(URL::to("getCategories")); ?>';
	 
	<?php else: ?>
		var getCategories = '<?php echo e(URL::to("getCategories")); ?>';
	<?php endif; ?>
	
	var category_id = $('#category_id').val();
	if(category_id != ''){
		$.ajax({
			url: getCategories,
			type: "POST",
			data: '&category_id='+category_id,
			success: function (data) {
				if(data.length != ''){
					var i;
					var showData = [];
					for (i = 0; i < data.length; ++i) {
						showData[i] = "<option value='"+data[i].id+"'>"+data[i].name+"</option>";
					}
					$("#sub_category_id").html(showData);
				}else{
					$("#sub_category_id").html("<option value=''>Please Select</option>");
				}
			},
		});
	}
}

//showSpecial
function showSpecial() {
	if($('#isSpecial').val() == 'yes'){
		$(".special-container").show();
		$(".special-container input#expiry-date").addClass("field-validate");
		$(".special-container input#special-price").addClass("number-validate");
		
		//number-validate
	}else{
		$(".special-container").hide();
		$(".special-container input#expiry-date").removeClass("field-validate");
		$(".special-container input#special-price").removeClass("number-validate");
	}
}

	
$(function () {
	$('.datepicker').datepicker({
	  autoclose: true,
	  format: 'dd/mm/yyyy'
	});

});


function banner_type(){
	var type = $(this).val();
	//alert(type);
	if(type=='category'){
		$('.categoryContent').show();
		$('.productContent').hide();
	}else if(type=='product'){
		$('.categoryContent').hide();
		$('.productContent').show();
	}else{
		$('.categoryContent').hide();
		$('.productContent').hide();	
	}
}
$(document).on('change','.choseOption',function(){
	//console.log('here');
	var content = $(this).attr('content');
	var choseOption = $(this).val();
	console.log(choseOption);
	
	if(choseOption == 'new'){
		$('.field-validate_'+content).addClass('field-validate');
		$('.newAttribute_'+content).show();
		$('.oldAttribute_'+content).hide();
	}else if(choseOption == 'old'){	
		$('.field-validate_'+content).removeClass('field-validate');
		$('.newAttribute_'+content).hide();
		$('.oldAttribute_'+content).show();
	}
	
});


$(document).on('change', '#bannerType', function(e){
	var type = $(this).val();
	
	if(type=='category'){
		$('.categoryContent').show();
		$('.productContent').hide();
	}else if(type=='product'){
		$('.categoryContent').hide();
		$('.productContent').show();
	}else{
		$('.categoryContent').hide();
		$('.productContent').hide();	
	}
	
});

//notifyTo
$(document).on('click', '.notifyTo', function(e){
	
	if($(this).is(':checked')){
		//alert('checked');
		$('.device_id > input').attr('disabled', true);
	}else{
		$('.device_id > input').removeAttr('disabled');
	}
});

//filter devieces
$(document).on('change', '.filter-devieces', function(e){
	var filter_devices = $(this).val();
	
	/*$('.device_id > input').removeAttr('checked');
	$('.notifyTo').attr("checked", "checked");
	$('.filter-div').show();
	$('.device_id').hide();
	
	$('label[devicetype="'+filter_devices+'"]').show();
	$('.device_id label[attributeid=' + filter_devices + ']').show();*/
	
});

//validate form
$(document).on('submit', '.form-validate', function(e){
	var error = "";
	
	//to validate text field
	$(".field-validate").each(function() {
		
		if(this.value == '') {
			$(this).closest(".form-group").addClass('has-error');
			//$(this).next(".error-content").removeClass('hidden');
			error = "has error";
		}else{
			$(this).closest(".form-group").removeClass('has-error');
			//$(this).next(".error-content").addClass('hidden');
		}
	});
	
	$(".number-validate").each(function() {
		if(this.value == '' || isNaN(this.value)) {
			$(this).closest(".form-group").addClass('has-error');
			//$(this).next(".error-content").removeClass('hidden');
			error = "has error";
		}else{
			$(this).closest(".form-group").removeClass('has-error');
			//$(this).next(".error-content").addClass('hidden');
		}
	});
	
	//
	$(".email-validate").each(function() {
		var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		if(this.value != '' && validEmail.test(this.value)) {
			$(this).closest(".form-group").removeClass('has-error');
			//$(this).next(".error-content").addClass('hidden');
			
		}else{
			$(this).closest(".form-group").addClass('has-error');
			//$(this).next(".error-content").removeClass('hidden');
			error = "has error";
		}
	});
	
	if(error=="has error"){
    	return false;
	}
	
});

//focus form field
$(document).on('keyup change', '.field-validate', function(e){
	
	if(this.value == '') {
		$(this).closest(".form-group").addClass('has-error');
		//$(this).next(".error-content").removeClass('hidden');
	}else{
		$(this).closest(".form-group").removeClass('has-error');
		//$(this).next(".error-content").addClass('hidden');
	}
	
});

//focus form field
$(document).on('keyup', '.number-validate', function(e){
	
	if(this.value == '' || isNaN(this.value)) {
		$(this).closest(".form-group").addClass('has-error');
		//$(this).next(".error-content").removeClass('hidden');
	}else{
		$(this).closest(".form-group").removeClass('has-error');
		//$(this).next(".error-content").addClass('hidden');
	}
	
});

$(document).on('keyup focusout', '.email-validate', function(e){
	var validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	if(this.value != '' && validEmail.test(this.value)) {
		$(this).closest(".form-group").removeClass('has-error');
		//$(this).next(".error-content").addClass('hidden');
		
	}else{
		$(this).closest(".form-group").addClass('has-error');
		//$(this).next(".error-content").removeClass('hidden');
		error = "has error";
	}
});


//show password div
function changePassword(){
	var change_password = $("#change_password").val();
	console.log(change_password);
	if(change_password=='1'){
		$('.password_content').show();
	}else{
		$('.password_content').hide();	
	}
}

//show password div
	function validatePasswordForm(){
		var password = document.forms["updateAdminPassword"]["password"].value;
		var re_password = document.forms["updateAdminPassword"]["re_password"].value;
		var err = '';
		if (password == null || password == "" || password.length < 6) {
			  $('#password').closest('.col-sm-10').addClass('has-error');
			  $('#password').focus();
			  err = "Password must be filled and of more than 6 characters! \n";
			  $('#password').next('.error-content').html(err).show();
			  return false;
		}else{
			 $('#password').closest('.col-sm-10').removeClass('has-error');
			 $('#password').next('.error-content').hide();
			 
			  if (re_password == null || re_password == '' ) {
					 err  = "Please re enter password! \n";
					 document.getElementById("re_password").focus();
					 $('#re_password').parent('.col-sm-10').addClass('has-error');
					 $('#re_password').next('.error-content').html(err).show();
					 return false;
			 }else{
				 if (re_password != password) {
					 err  = "Both passwords must be matched! \n";
					 document.getElementById("re_password").focus()
					 $('#re_password').parent('.col-sm-10').addClass('has-error');
					 $('#re_password').next('.error-content').html(err).show();
					return false;
				 }else{
					return true;
				
				}
			 }
		}
}




	
</script>