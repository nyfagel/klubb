<div class="active blue title row">
	<div class="twelve columns">
		<h2><?php echo ucfirst(lang('welcome')); ?> <?php echo $firstname; ?>!</h2>
	</div>
</div>
<div class="cyan row">
	<div class="six columns">
		<h5><?php echo ucfirst(lang('members')); ?></h5>
		<p><?php echo $org_name; ?> har totalt <a href="http://uc.nyfagel.se/members"><?php echo $members.' '.lang('members'); ?></a> varav:</p>
		<div class="row">
			<div class="six mobile-two columns">
				<ul class="disc">
					<?php foreach($membertypes as $membertype): ?>
					<li><?php echo $membertype; ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="six mobile-two columns">
				<ul class="no-bullet extra-padding text-right">
					<li><a href="http://uc.nyfagel.se/members" class="radius button"><?php echo ucfirst(lang('administer')).' '.lang('members'); ?></a></li>
					<li><a href="http://uc.nyfagel.se/member/register" class="radius button"><?php echo ucfirst(lang('register_member')); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="six columns">
		<h5><?php echo ucfirst(lang('users')); ?></h5>
		<p><?php echo ucfirst($app_name); ?> har totalt <a href="http://uc.nyfagel.se/admin/users"><?php echo $users.' '.lang('users'); ?></a>.</p>
		<h6><?php echo ucfirst(lang('currently_logged_on')); ?>:</h6>
		<div class="row">
			<div class="six mobile-two columns">
				<ul class="disc">
					<?php foreach ($loggedon as $user): ?>
					<li><?php echo $user; ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="six mobile-two columns">
				<ul class="no-bullet extra-padding text-right">
					<li><a href="http://uc.nyfagel.se/admin/users" class="radius button"><?php echo ucfirst(lang('administer')).' '.lang('users'); ?></a></li>
					<li><a href="http://uc.nyfagel.se/user/create" class="radius button"><?php echo ucfirst(lang('create_user')); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="yellow title row">
	<div class="twelve columns">
		<h3><a href="/members"><?php echo ucfirst(lang('members')); ?></a></h3>
		<div class="yellow bottom">
			<!-- here be dragons -->
		</div>
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