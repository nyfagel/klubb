<?php if (!$ajax): ?>
<div class="blue title row">
	<div class="twelve columns">
		<h3><a href="/">Hem</a></h3>
	</div>
</div>
<div class="yellow title row">
	<div class="twelve columns">
		<h3><a href="/members">Ung Cancers <?php echo lang('members'); ?></a> - Registrera medlem</h3>
		<div class="yellow bottom">
			<!-- here be dragons -->
		</div>
	</div>
</div>
<div class="cyan row">
	<div class="twelve columns">
		<p class="lead">Använd formuläret nedan för att lägga till en ny medlem i <?php echo $org_name; ?>.</p>
<?php endif; ?>
		<?php echo $tabs['tabs']; ?>
		<?php echo $tabs['content']; ?>
<?php if (!$ajax): ?>
	</div>
</div>

<div class="green title row">
	<div class="twelve columns">
		<h3><?php echo ucfirst(lang('administration')); ?></h3>
		<div class="green bottom">
			<!-- here be dragons -->
		</div>
	</div>
</div>
<div class="row">
	<div class="six columns end" style="margin-top: 32px; margin-bottom: 32px;">
		<img src="/assets/img/logga_stor.jpg" alt="Ung Cancer" width="900" height="119" />
	</div>
</div>
<?php endif; ?>
