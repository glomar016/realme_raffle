		</div>
		<div class="footer">
		    <img src="<?php echo base_url('assets/img/Agreement.png'); ?>" style="width: 100%; max-width: 600px">
		    <img src="<?php echo base_url('assets/img/mechanics.jpg'); ?>" style="width: 100%; max-width: 600px">
		</div>
	</div>

	<div id="modalTerms" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Terms and Conditions</h5>
				</div>
				<div class="modal-body" style="max-height: 450px; overflow-y: auto;">
					<?php $this->load->view('_shared/terms'); ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div id="modalPrivacy" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Terms and Conditions</h5>
				</div>
				<div class="modal-body" style="max-height: 450px; overflow-y: auto;">
					<?php $this->load->view('_shared/privacy'); ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php
	//Javascript for every controller function
	if (!($script === FALSE)) {
		foreach($script as $s) {
	?>
	<script src="<?php echo base_url('assets/pages/js/'.$s.'.js'); ?>"></script>
	<?php
		}
	}
?>
</body>
</html>