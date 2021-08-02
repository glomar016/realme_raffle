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
	<script src="<?php echo base_url('assets/jquery/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/popper/popper.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
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