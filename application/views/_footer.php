<footer>
		<div class="row">
			<div class="six columns">
				<p>Copyright &copy; 2013 <?php echo $this->system_model->get('org_name'); ?>.</p>
			</div>
			<div class="six columns">
				<ul class="inline-list right">
					<li><a href="http://www.nyfagel.se/" target="_blank">With <i class="general-foundicon-heart"></i> from Ny fågel</a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>
<?php echo (isset($library_src)) ? "<!-- Load JQuery -->\n".$library_src."<!-- End Load JQuery -->\n" : ''; ?>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.accordion.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.alerts.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.buttons.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.clearing.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.forms.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.joyride.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.magellan.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.mediaQueryToggle.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.navigation.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.orbit.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.reveal.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.tabs.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.tooltips.js'); ?>"></script>
<script src="<?php echo asset_url('js/foundation/jquery.foundation.topbar.js'); ?>"></script>

<script src="<?php echo asset_url('js/gridster/dist/jquery.gridster.min.js'); ?>"></script>
<script src="<?php echo asset_url('js/tablesorter/js/jquery.metadata.js'); ?>"></script>
<script src="<?php echo asset_url('js/tablesorter/js/jquery.tablesorter.js'); ?>"></script>
<script src="<?php echo asset_url('js/tablesorter/js/jquery.tablesorter.widgets.js'); ?>"></script>
<script src="<?php echo asset_url('js/tablesorter/addons/pager/jquery.tablesorter.pager.js'); ?>"></script>

<script src="<?php echo asset_url('js/foundation/app.js'); ?>"></script>
<?php echo (isset($script_foot)) ? "<!-- Compiled JQuery -->\n".$script_foot."<!-- End Compiled JQuery -->\n" : ''; ?>
</body>
</html>