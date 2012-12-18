<!-- Top Bar -->
<div class="row fixed">
	<nav class="top-bar">
		<ul>
			<!-- Title Area -->
			<li class="name">
				<h1>
					<a href="/">
						<?php echo $title ?>
					</a>
				</h1>
			</li>
			<li class="toggle-topbar"><a href="#"></a></li>
		</ul>
		<?php if ($this->auth->loggedin()): ?>
		<section>
			<!-- Right Nav Section -->
			<ul class="left">
				<li class="divider"></li>
				<li<?php if (uri_string() == 'home') { echo ' class="active"'; } ?>><?php echo anchor('home', ucfirst(lang('home'))); ?></li>
				<li class="divider"></li>
				<li<?php if (uri_string() == 'members') { echo ' class="active"'; } ?>><?php echo anchor('members', ucfirst(lang('members'))); ?></li>
				<li class="divider"></li>
				<li class="has-dropdown<?php if (stristr(uri_string(), 'admin')) { echo ' active'; } ?>">
					<?php echo anchor('admin', ucfirst(lang('administration'))); ?>
					<ul class="dropdown">
						<li<?php if (uri_string() == 'admin/users') { echo ' class="active"'; } ?>><?php echo anchor('admin/users', ucfirst(lang('users'))); ?></li>
						<li<?php if (uri_string() == 'admin/org') { echo ' class="active"'; } ?>><?php echo anchor('admin/org', ucfirst(($this->system_model->get('org_type')) ? ucfirst($this->system_model->get('org_type').lang('org_pluralizer')) : ucfirst(lang('the_organization')))); ?></li>
					</ul>
				</li>
			</ul>
		</section>
		<section>
			<ul class="right">
				<li class="divider"></li>
				<li><?php echo anchor('user/logout', ucfirst(lang('logout'))); ?></li>
			</ul>
		</section>
		<?php else: ?>
		<section>
			<ul class="right">
				<li class="divider"></li>
				<li><?php echo anchor('user/login', ucfirst(lang('login'))); ?></li>
			</ul>
		</section>
		<?php endif; ?>
	</nav>
</div>