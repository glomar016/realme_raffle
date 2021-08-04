<?php echo form_open('registration/verify/'.$id); ?>
	<div class="form-group">
		<label for="verification">Check your email. We have sent you a verification code.<span class="text text-danger">*</span></label>
		<input type="text" class="form-control" id="verification" name="verification" value="<?php echo set_value('verification'); ?>">
		<?php echo form_error('verification', '<span class="text-danger">', '</span>'); ?>
	</div>
	<a href="<?php echo base_url('registration/send_code/'.$id); ?>">Resend Verification Code</a>
	<hr class="line">
	<button type="submit" id="btnsubmit" class="btn btn-lg btn-success btn-custom">SUBMIT</button>
<?php echo form_close(); ?>