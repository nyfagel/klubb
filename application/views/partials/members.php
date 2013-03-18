    <div class="blue title row">
        <div class="twelve columns">
            <h3><a href="/">Hem</a></h3>
        </div>
    </div>

    <div class="green title row">
        <div class="twelve columns">
            <h2><a href="/members">Ung Cancers <?php echo lang('members'); ?></a></h2>

            <div class="green bottom">
                <!-- here be dragons -->
            </div>
        </div>
    </div>

    <div class="cyan row">
        <div class="twelve columns">
        	<div class="row">
        		<div class="twelve columns">
            <?php echo $filters; ?>
        		</div>
        	</div>
        	<div class="row">
        		<div class="twelve columns">
        		<a href="/members">Visa alla</a><br><br>
            <?php echo $table; ?>
            </div>
        	</div>
            <div class="row">
                <div class="six columns" id="pager">
                    <form class="notcustom">
                        <div class="row">
                            <div class="four columns">
                                <select class="pagesize expand" title="Resultat per sida" name="results">
                                    <option value="10">
                                        10
                                    </option>

                                    <option selected="selected" value="20">
                                        20
                                    </option>

                                    <option value="30">
                                        30
                                    </option>

                                    <option value="40">
                                        40
                                    </option>
                                    <option value="50">
                                        50
                                    </option>
                                    <option value="100">
                                        100
                                    </option>
                                </select>
                            </div>

                            <div class="four columns text-center"><img src="/assets/js/tablesorter/addons/pager/icons/first.png" class="first" width="16" height="16"> <img src="/assets/js/tablesorter/addons/pager/icons/prev.png" class="prev" width="16" height="16"> <img src="/assets/js/tablesorter/addons/pager/icons/next.png" class="next" width="16" height="16"> <img src="/assets/js/tablesorter/addons/pager/icons/last.png" alt="last" width="16" height="16"></div>

                            <div class="four columns">
                                <select class="expand gotoPage" title="Hoppa till sida">
                                    <option selected="selected" value="1">
                                        1
                                    </option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
        </div>
    </div>
<div class="row">
	<div class="six columns end" style="margin-top: 32px; margin-bottom: 32px;">
		<img src="/assets/img/logga_stor.jpg" alt="Ung Cancer" width="900" height="119" />
	</div>
</div>