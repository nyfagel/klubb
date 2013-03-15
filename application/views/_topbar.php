<!-- Top Bar -->
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
		<?php else: ?>
		<?php endif; ?>
	</nav>