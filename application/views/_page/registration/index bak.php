<?php echo form_open_multipart('registration'); ?>
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
		<label for="storeName">Store Name and Branch <span class="text text-danger">*</span></label>
		<input type="text" class="form-control" id="storeName" name="storeName" value="<?php echo set_value('storeName'); ?>">
		<?php echo form_error('storeName', '<span class="text-danger">', '</span>'); ?>
	</div>
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
	<button type="submit" id="btnsubmit" class="btn btn-custom">SUBMIT ENTRY</button>
<?php echo form_close(); ?>