<form id="registrationForm">
	<div class="form-group">
		<label for="firstName">First Name <span class="text text-danger">*</span></label>
		<input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo set_value('firstName'); ?>">
		<?php echo form_error('firstName', '<span class="text-danger">', '</span>'); ?>
	</div>
	<div class="form-group">
		<label for="middleName">Middle Name</label>
		<input type="text" class="form-control" id="middleName" name="middleName" value="<?php echo set_value('middleName'); ?>">
		<?php echo form_error('middleName', '<span class="text-danger">', '</span>'); ?>
	</div>
	<div class="form-group">
		<label for="lastName">Last Name <span class="text text-danger">*</span></label>
		<input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo set_value('lastName'); ?>">
		<?php echo form_error('lastName', '<span class="text-danger">', '</span>'); ?>
	</div>
	<div class="form-group">
		<label for="email">Email address <span class="text text-danger">*</span></label>
		<input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>">
		<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
	</div>
	<div class="form-group">
		<label for="address">Home Address <span class="text text-danger">*</span></label>
		<input type="text" class="form-control" id="address" name="address" value="<?php echo set_value('address'); ?>">
		<?php echo form_error('address', '<span class="text-danger">', '</span>'); ?>
	</div>
	<div class="form-group">
		<label for="contactNumber">11-digit Mobile Number <span class="text text-danger">*</span></label>
		<input type="text" class="form-control" maxlength="11" id="contactNumber" name="contactNumber" value="<?php echo set_value('contactNumber'); ?>">
		<?php echo form_error('contactNumber', '<span class="text-danger">', '</span>'); ?>
	</div>
	<hr class="line">
	<div class="form-group">
		<label for="phoneModel">realme Smartphone Model <span class="text text-danger">*</span></label>
		<select class="custom-select" id="phoneModel" name="phoneModel">
		    <option value="" <?php echo set_select('phoneModel', '', TRUE); ?> >- Select Phone Model -</option>
		    <?php if ($devices) {
		        foreach ($devices as $d) {
		            ?>
		    <option value="<?php echo $d['id']; ?>" <?php echo set_select('phoneModel', $d['id']); ?> ><?php echo $d['device_name']; ?></option>
		            <?php
		        }
		    } ?>
		</select>
		<?php echo form_error('phoneModel', '<span class="text-danger">', '</span>'); ?>
	</div>
	<div class="form-group">
		<label for="imei">realme Smartphone's IMEI1 (Dial *#06# to know your IMEI1)<span class="text text-danger">*</span></label>
		<input type="text" class="form-control" id="imei" name="imei" placeholder="Mobile Phone IMEI Number" value="<?php echo set_value('imei'); ?>">
		<?php echo form_error('imei', '<span class="text-danger">', '</span>'); ?>
	</div>
	<div class="form-group">
		<label for="purchaseDate">Date of Purchase <span class="text text-danger">*</span></label>
		<input type="date" class="form-control" id="purchaseDate" name="purchaseDate" min="2020-11-17" value="<?php echo set_value('purchaseDate'); ?>">
		<?php echo form_error('purchaseDate', '<span class="text-danger">', '</span>'); ?>
	</div>
	<div class="form-group">
		<label for="storeName">Store Name and Branch <br> (if store name is not in the list, select "Others" and specify store name)<span class="text text-danger">*</span></label>
		<select class="custom-select" id="storeName" name="storeName">
		    <option value="" <?php echo set_select('storeName', '', TRUE); ?> >- Select Store Name and Branch -</option>
		    <?php if ($stores) {
		        foreach ($stores as $s) {
		            ?>
		    <option value="<?php echo $s['id']; ?>" <?php echo set_select('storeName', $s['id']); ?> ><?php echo $s['store_name']; ?></option>
		            <?php
		        }
		    } ?>
		    <option value="Others">Others</option>
		</select>
		<?php echo form_error('phoneModel', '<span class="text-danger">', '</span>'); ?>
	</div>
	<div class="form-group" id="otherStoreName" hidden>
		<label for="otherStoreName">Specify Other Store Name: <span class="text text-danger">*</span></label>
		<input type="text" class="form-control" id="otherStoreName" name="otherStoreName" value="<?php echo set_value('otherStoreName'); ?>">
	</div>
	<!-- <div class="form-group">
		<label for="storeName">Store Name and Branch <span class="text text-danger">*</span></label>
		<input type="text" class="form-control" id="storeName" name="storeName" value="<?php echo set_value('storeName'); ?>">
		<?php echo form_error('storeName', '<span class="text-danger">', '</span>'); ?>
	</div> -->
	<div class="form-group">
		<label for="storeReceipt">Photo of Official Receipt or E-Commerce Order Details Screenshot <span class="text text-danger">*</span></label>
		<div class="custom-file">
    		<input type="file" class="custom-file-input" id="storeReceipt" name="storeReceipt" accept="image/x-png,image/gif,image/jpeg">
    		<label class="custom-file-label" for="storeReceipt">Upload your receipt here...</label>
  		</div>
  		<label for="storeReceipt">Only images in png, jpg and jpeg formats are accepted, maximum size of 5MB.</label>
		<?php echo form_error('storeReceipt', '<span class="text-danger">', '</span>'); ?>
	</div>
	<hr class="line">
	<div class="form-group">
		<div class="custom-control custom-checkbox">
	    	<input type="checkbox" class="custom-control-input" id="terms" name="terms" value="1">
	    	<label class="custom-control-label" for="terms">I have read and agree to the <a href="#modalTerms" data-toggle="modal">Terms and Conditions</a>.</label>
	  	</div>
	  	<?php echo form_error('terms', '<span class="text-danger">', '</span>'); ?>
	</div>
	<div class="form-group">
		<div class="custom-control custom-checkbox">
	    	<input type="checkbox" class="custom-control-input" id="dataPrivacy" name="dataPrivacy" value="1">
	    	<label class="custom-control-label" for="dataPrivacy">I have read and agree to the <a href="<?php echo base_url('assets/privacy/Privacy-Policy.pdf'); ?>" target="_blank">Privacy Policy</a>.</label>
	  	</div>
	  	<?php echo form_error('dataPrivacy', '<span class="text-danger">', '</span>'); ?>
	</div>
	<div class="form-group">
		<div class="custom-control custom-checkbox">
	    	<input type="checkbox" class="custom-control-input" id="dataAgreement" name="dataAgreement" value="1">
	    	<label class="custom-control-label" for="dataAgreement" style="text-align: justify">I allow realme Philippines, registered under Runto Technology Inc. to collect and use my provided data and information for the use of this raffle promotion.</label>
	  	</div>
	  	<?php echo form_error('dataAgreement', '<span class="text-danger">', '</span>'); ?>
	</div>
	
	<hr class="line">
	<div class="text-center" >
		<input type="submit" id="btnsubmit" class="btn btn-lg btn-success btn-custom" value="SUBMIT ENTRY" style="width: 50%">
	</div>
</form>

<script src="<?php echo base_url()?>assets/jquery/jquery-3.5.1.js"></script>
<script src="<?php echo base_url()?>assets/jquery/jquery-3.5.1.min.js"></script>
<script src="<?php echo base_url()?>assets/jquery/moment.min.js"></script>
<script src="<?php echo base_url()?>assets/jquery/sweetalert2@11.js"></script>
<!-- <script src="<?php echo base_url()?>assets/pages/js/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script> -->
<link href="<?php echo base_url()?>assets/pages/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function(){
	$('select').select2({

	});

	$('#storeName').on('change', function(e){
		$('#otherStoreName').attr('hidden', false);

	});
	

	$('#registrationForm').on('submit', function(e){
		e.preventDefault()

		let imei_val = $('#imei').val() 
		let form = $('#registrationForm').serialize();
		console.log($("#storeReceipt").val())

	
		if($('#firstName').val() == ""){
			Swal.fire(
				'Warning!',
				'First Name is required!',
				'warning'
			)
		}
		else if($('#lastName').val() == ""){
			Swal.fire(
				'Warning!',
				'Last Name is required!',
				'warning'
			)
		}
		else if($('#email').val() == ""){
			Swal.fire(
				'Warning!',
				'Email is required!',
				'warning'
			)
		}
		else if($('#address').val() == ""){
			Swal.fire(
				'Warning!',
				'Address is required!',
				'warning'
			)
		}
		else if($('#contactNumber').val() == ""){
			Swal.fire(
				'Warning!',
				'Contact Number is required!',
				'warning'
			)
		}
		else if($('#phoneModel').find(":selected").text() == "- Select Phone Model -"){
			Swal.fire(
				'Warning!',
				'Select phone model!',
				'warning'
			)
		}
		else if($('#purchaseDate').val() == ""){
			Swal.fire(
				'Warning!',
				'Purchase date is required!',
				'warning'
			)
		}
		else if($('#storeName').val() == ""){
			Swal.fire(
				'Warning!',
				'Store name and branch is required!',
				'warning'
			)
		}
		else if($('#storeReceipt').val() == ""){
			Swal.fire(
				'Warning!',
				'Store receipt is required!',
				'warning'
			)
		}
		else if($('#imei').val() == ""){
			Swal.fire(
				'Warning!',
				'IMEI is required!',
				'warning'
			)
		}
		else if(!$('#terms').is(":checked")){
				Swal.fire(
				'Warning!',
				'Terms and conditions are required!',
				'warning'
			)
		}
		else if(!$('#dataPrivacy').is(":checked")){
				Swal.fire(
				'Warning!',
				'Data privacy is required!',
				'warning'
			)
		}
		else if(!$('#dataAgreement').is(":checked")){
				Swal.fire(
				'Warning!',
				'Data agreement is required!',
				'warning'
			)
		}
		else{
			$('#btnsubmit').attr('disabled', true);
			// Image upload
				$.ajax({
					url: '<?php echo base_url()?>registration/is_valid_image/',
					type: "POST",
					data: new FormData(this),
					processData:false,
					contentType:false,
				
					success: function(data){
						// ajax opening tag
							$.ajax({
								url: '<?php echo base_url()?>registration/is_valid_imei/'+imei_val,
								type: "POST",
								dataType: "JSON",
							
									success: function(data){
										console.log(data);
										if(data == "Success"){
											// ajax opening tag
												$.ajax({
													url: '<?php echo base_url()?>registration/submit_registration',
													type: "POST",
													data: form,
													dataType: "JSON",
												
													success: function(data){
														$("#registrationForm").trigger("reset");
														
														Swal.fire({
														title: "You're halfway there!",
														text: "Please verify your registration",
														icon: 'success',
														showCancelButton: false,
														confirmButtonColor: '#3085d6',
														confirmButtonText: 'OK!'
														}).then((result) => {
															if (result.isConfirmed) {
																$(location).attr('href', "<?php echo base_url()?>registration/send_code/"+data)
															}
														})
													}
												// ajax closing tag
												})
										}
										else{
											Swal.fire(
												'Warning!',
												data,
												'warning'
											)
											$('#btnsubmit').attr('disabled', false);
										}
									}
								// ajax closing tag
								})
					}
				})
				// end of image upload
			
		}

	})



})
</script>