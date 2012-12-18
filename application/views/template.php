<?php
	$this->load->view('_header');
	$this->load->view('_topbar');
?>
<div class="row">
	<div class="twelve columns">
		<?php echo $html; ?>
	</div>
</div>
<?php
	$this->load->view('_footer');
?>