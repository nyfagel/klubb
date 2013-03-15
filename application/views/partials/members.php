<div class="blue title row">
	<div class="twelve columns">
		<h3><a href="/">Hem</a></h3>
	</div>
</div>
<div class="active yellow title row">
	<div class="twelve columns">
		<h2><a href="/members"><?php echo ucfirst(lang('members')); ?></a></h2>
		<div class="yellow bottom">
			<!-- here be dragons -->
		</div>
	</div>
</div>
<div class="cyan row">
	<div class="twelve columns">
		<br>
		<?php echo $filters; ?>
		<?php echo $table; ?>
		<div class="row">
		<div class="six columns" id="pager">
			<form class="custom">
			<div class="row">
			<div class="four columns">
			<select class="pagesize expand" title="Resultat per sida" name="results"> 
            <option selected="selected" value="10">10</option> 
            <option value="20">20</option> 
            <option value="30">30</option> 
            <option value="40">40</option> 
        </select>
			</div>
			<div class="four columns text-center">
        			<img src="/assets/js/tablesorter/addons/pager/icons/first.png" class="first" width="16" height="16" />
			<img src="/assets/js/tablesorter/addons/pager/icons/prev.png" class="prev" width="16" height="16" />
			<img src="/assets/js/tablesorter/addons/pager/icons/next.png" class="next" width="16" height="16" />
			<img src="/assets/js/tablesorter/addons/pager/icons/last.png" alt="last" width="16" height="16" />
			</div>
			<div class="four columns">
        <select class="expand gotoPage" title="Hoppa till sida">
	        <option selected="selected" value="1">1</option> 
        </select>
			</div>
			</div>
			</form>
		</div>
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