<div class="active blue title row">
	<div class="twelve columns">
		<h2>Hem</h2>
	</div>
</div>
<div class="cyan row">
	<div class="four columns">
		<h5><?php echo ucfirst(lang('members')); ?></h5>
		<p><?php echo $org_name; ?> har totalt <?php echo $members.' '.lang('members'); ?> varav:</p>
				<ul class="disc">
					<?php foreach($membertypes as $membertype): ?>
					<li><?php echo $membertype; ?></li>
					<?php endforeach; ?>
				</ul>
	</div>
	<div class="four columns">
			statistik
		</div>
	<div class="four columns">
		<h5><?php echo ucfirst(lang('users')); ?></h5>
		<p>Medlemsregistret har totalt <?php echo $users.' '.lang('users'); ?>.</p>
		<h6><?php echo ucfirst(lang('currently_logged_on')); ?>:</h6>
				<ul class="disc">
					<?php foreach ($loggedon as $user): ?>
					<li><?php echo $user; ?></li>
					<?php endforeach; ?>
				</ul>
	</div>
</div>
	<div class="cyan row">
		<div class="six columns centered text-center">
				<a href="#" class="radius dropdown button" onclick="registerMember('ajax-receiver-register-member', this);"><?php echo ucfirst(lang('register_member')); ?></a></dd>
		</div>
	</div>
	<div class="cyan row">
	<div class="twelve columns" id="ajax-receiver-register-member" style="display: none;">
	</div>
	</div>

<div class="green title row">
	<div class="twelve columns">
		<h3><a href="/members">Ung Cancers <?php echo lang('members'); ?></a></h3>
		<div class="green bottom">
			<!-- here be dragons -->
		</div>
	</div>
</div>

<div class="yellow title row">
	<div class="twelve columns">
		<h3><a href="/admin/users">Systemanvändare</a></h3>
		<div class="yellow bottom">
			<!-- here be dragons -->
		</div>
	</div>
</div>

<div class="pink title row">
	<div class="twelve columns">
		<h3><a href="/user/logout"><?php echo ucfirst(lang('logout')); ?></a></h3>
		<div class="pink bottom">
			<!-- here be dragons -->
		</div>
	</div>
</div>