<div class="blue title row">
	<div class="twelve columns">
		<h2>Hem</h2>
	</div>
</div>
<div class="yellow title row">
	<div class="twelve columns">
		<h2>Registrera medlem</h2>
		<div class="yellow bottom">
			<!-- here be dragons -->
		</div>
	</div>
</div>

<div class="cyan row">
	<div class="twelve columns">
		<p class="lead">Använd formuläret nedan för att lägga till en ny medlem i <?php echo $org_name; ?>.</p>
		<dl class="contained tabs" id="register-tabs">
			<dd class="contained active"><a href="#type1" id="type1">Medlem</a></dd>
			<dd class="contained"><a href="#type2" id="type2">Anhörigmedlem</a></dd>
			<dd class="contained"><a href="#type3" id="type3">Stödmedlem</a></dd>
		</dl>
		<ul class="contained tabs-content" id="register-content">
			<li class="contained active" id="type1Tab">
				<form action="http://uc.nyfagel.se/member/register" method="post" accept-charset="utf-8" class="custom">
					<div style="display:none">
						<input type="hidden" name="csrf_test_b161b65b854ffa7e1f25337aa782bd7c" value="e4147e3a686fbf2fbf1e2880d1e8baa3">
					</div>
					<div class="row">
						<div class="eight columns">
							<input type="hidden" name="type" value="1">
							<div class="row">
								<div class="end six columns">
									<label for="ssid" class="">Personnummer:<span class="required">*</span></label><input type="text" name="ssid" value="" id="ssid" class="expand" placeholder="ååmmddxxxx" size="10" maxlength="10">
								</div>
							</div>
							<div class="row name" id="name_row">
								<div class="six columns">
									<label for="firstname">Förnamn:<span class="required">*</span></label><input type="text" name="firstname" value="" id="firstname" class="expand">
								</div>
								<div class="six columns">
									<label for="lastname">Efternamn:<span class="required">*</span></label><input type="text" name="lastname" value="" id="lastname">
								</div>
							</div>
							<div class="row">
								<div class="six columns">
									<label for="email" class="">E-postadress:<span class="required">*</span></label><input type="email" name="email" value="" id="email" class="expand">
								</div>
								<div class="six columns">
									<label for="phone">Telefonnummer:<span class="required">*</span></label><input type="tel" name="phone" value="" id="phone" class="expand">
								</div>
							</div>
							<div class="row">
								<div class="end six columns">
									<label for="address" class="">Adress:<span class="required">*</span></label><input type="text" name="address" value="" id="address" class="expand">
								</div>
							</div>
							<div class="row">
								<div class="two columns">
									<label for="zipcode" class="">Postnummer:<span class="required">*</span></label><input type="text" name="zipcode" value="" id="zipcode" class="expand">
								</div>
								<div class="end four columns">
									<label for="city" class="">Ort:<span class="required">*</span></label><input type="text" name="city" value="" id="city" class="expand">
								</div>
							</div>
							<div class="row">
								<div class="six columns">
									<label for="diagnos" class="">Diagnos år:<span class="required">*</span></label><input type="text" name="diagnos" value="" id="diagnos" class="expand">
								</div>
								<div class="six columns">
									<label for="cancer">Cancersjukdom:<span class="required">*</span></label><input type="text" name="cancer" value="" id="cancer" class="expand">
								</div>
							</div>
							<ul class="radius left button-group">
								<li><a href="http://uc.nyfagel.se/members" class="radius button">Avbryt</a></li>
								<li><input type="submit" name="" value="Spara" class="radius button"></li>
							</ul>
						</div>
						<div class="four columns">
							<h6>Kan tänka sig att</h6>
							<label for="tell">
								<input type="checkbox" name="tell" value="" id="tell" style="display: none;">&nbsp;berätta min historia på ungcancer.se för andra att ta del av</label>
							<label for="participate">
								<input type="checkbox" name="participate" value="" id="participate" style="display: none;">&nbsp;delta på möten, föreläsningar och/eller andra aktiviteter</label>
							<label for="talking_partner">
								<input type="checkbox" name="talking_partner" value="" id="talking_partner" style="display: none;">&nbsp;bli samtalsvän och låta Ung Cancer ge ut min mailadress till andra medlemmar</label>
								<hr>
								<label for="other">övrigt:</label>
								<textarea name="other" cols="40" rows="10" id="other"></textarea>
							</div>
						</div>
					</form>
				</li>
				<li class="contained" id="type2Tab">
					<form action="http://uc.nyfagel.se/member/register" method="post" accept-charset="utf-8" class="custom">
						<div style="display:none">
							<input type="hidden" name="csrf_test_b161b65b854ffa7e1f25337aa782bd7c" value="e4147e3a686fbf2fbf1e2880d1e8baa3">
						</div>
						<div class="row">
							<div class="eight columns">
								<input type="hidden" name="type" value="2">
								<div class="row">
									<div class="end six columns">
										<label for="ssid" class="">Personnummer:<span class="required">*</span></label><input type="text" name="ssid" value="" id="ssid" class="expand" placeholder="ååmmddxxxx" size="10" maxlength="10">
									</div>
								</div>
								<div class="row name" id="name_row">
									<div class="six columns">
										<label for="firstname">Förnamn:<span class="required">*</span></label><input type="text" name="firstname" value="" id="firstname" class="expand">
									</div>
									<div class="six columns">
										<label for="lastname">Efternamn:<span class="required">*</span></label><input type="text" name="lastname" value="" id="lastname">
									</div>
								</div>
								<div class="row">
									<div class="six columns">
										<label for="email" class="">E-postadress:<span class="required">*</span></label><input type="email" name="email" value="" id="email" class="expand">
									</div>
									<div class="six columns">
										<label for="phone">Telefonnummer:<span class="required">*</span></label><input type="tel" name="phone" value="" id="phone" class="expand">
									</div>
								</div>
								<div class="row">
									<div class="end six columns">
										<label for="address" class="">Adress:<span class="required">*</span></label><input type="text" name="address" value="" id="address" class="expand">
									</div>
								</div>
								<div class="row">
									<div class="two columns">
										<label for="zipcode" class="">Postnummer:<span class="required">*</span></label><input type="text" name="zipcode" value="" id="zipcode" class="expand">
									</div>
									<div class="end four columns">
										<label for="city" class="">Ort:<span class="required">*</span></label><input type="text" name="city" value="" id="city" class="expand">
									</div>
								</div>
								<div class="row">
									<div class="six columns">
										<label for="diagnos" class="">Diagnos år:<span class="required">*</span></label><input type="text" name="diagnos" value="" id="diagnos" class="expand">
									</div>
									<div class="six columns">
										<label for="cancer">Cancersjukdom:<span class="required">*</span></label><input type="text" name="cancer" value="" id="cancer" class="expand">
									</div>
								</div>
								<ul class="radius left button-group">
									<li><a href="http://uc.nyfagel.se/members" class="radius button">Avbryt</a></li>
									<li><input type="submit" name="" value="Spara" class="radius button"></li>
								</ul>
							</div>
							<div class="four columns">
								<h6>Kan tänka sig att</h6>
								<label for="tell">
									<input type="checkbox" name="tell" value="" id="tell" style="display: none;">&nbsp;berätta min historia på ungcancer.se för andra att ta del av</label>
								<label for="participate">
									<input type="checkbox" name="participate" value="" id="participate" style="display: none;">&nbsp;delta på möten, föreläsningar och/eller andra aktiviteter</label>
								<label for="talking_partner">
									<input type="checkbox" name="talking_partner" value="" id="talking_partner" style="display: none;">&nbsp;bli samtalsvän och låta Ung Cancer ge ut min mailadress till andra medlemmar</label>
								<hr>
								<label for="other">övrigt:</label>
								<textarea name="other" cols="40" rows="10" id="other"></textarea>
							</div>
						</div>
					</form>
				</li>
				<li class="contained" id="type3Tab">
					<form action="http://uc.nyfagel.se/member/register" method="post" accept-charset="utf-8" class="custom">
						<div style="display:none">
							<input type="hidden" name="csrf_test_b161b65b854ffa7e1f25337aa782bd7c" value="e4147e3a686fbf2fbf1e2880d1e8baa3">
						</div>
						<div class="row">
							<div class="eight columns">
								<input type="hidden" name="type" value="3">
								<div class="row">
									<div class="end six columns">
										<label for="ssid" class="">Personnummer:<span class="required">*</span></label><input type="text" name="ssid" value="" id="ssid" class="expand" placeholder="ååmmddxxxx" size="10" maxlength="10">
									</div>
								</div>
								<div class="row name" id="name_row">
									<div class="six columns">
										<label for="firstname">Förnamn:<span class="required">*</span></label><input type="text" name="firstname" value="" id="firstname" class="expand">
									</div>
									<div class="six columns">
										<label for="lastname">Efternamn:<span class="required">*</span></label><input type="text" name="lastname" value="" id="lastname">
									</div>
								</div>
								<div class="row">
									<div class="six columns">
										<label for="email" class="">E-postadress:<span class="required">*</span></label><input type="email" name="email" value="" id="email" class="expand">
									</div>
									<div class="six columns">
										<label for="phone">Telefonnummer:<span class="required">*</span></label><input type="tel" name="phone" value="" id="phone" class="expand">
									</div>
								</div>
								<div class="row">
									<div class="end six columns">
										<label for="address" class="">Adress:<span class="required">*</span></label><input type="text" name="address" value="" id="address" class="expand">
									</div>
								</div>
								<div class="row">
									<div class="two columns">
										<label for="zipcode" class="">Postnummer:<span class="required">*</span></label><input type="text" name="zipcode" value="" id="zipcode" class="expand">
									</div>
									<div class="end four columns">
										<label for="city" class="">Ort:<span class="required">*</span></label><input type="text" name="city" value="" id="city" class="expand">
									</div>
								</div>
								<div class="row">
									<div class="six columns">
										<label for="diagnos" class="">Diagnos år:<span class="required">*</span></label><input type="text" name="diagnos" value="" id="diagnos" class="expand">
									</div>
									<div class="six columns">
										<label for="cancer">Cancersjukdom:<span class="required">*</span></label><input type="text" name="cancer" value="" id="cancer" class="expand">
									</div>
								</div>
								<ul class="radius left button-group">
									<li><a href="http://uc.nyfagel.se/members" class="radius button">Avbryt</a></li>
									<li><input type="submit" name="" value="Spara" class="radius button"></li>
								</ul>
							</div>
							<div class="four columns">
								<h6>Kan tänka sig att</h6>
								<label for="tell">
									<input type="checkbox" name="tell" value="" id="tell" style="display: none;">&nbsp;berätta min historia på ungcancer.se för andra att ta del av</label>
								<label for="participate">
									<input type="checkbox" name="participate" value="" id="participate" style="display: none;">&nbsp;delta på möten, föreläsningar och/eller andra aktiviteter</label>
								<label for="talking_partner">
									<input type="checkbox" name="talking_partner" value="" id="talking_partner" style="display: none;">&nbsp;bli samtalsvän och låta Ung Cancer ge ut min mailadress till andra medlemmar</label>
								<hr>
								<label for="other">övrigt:</label>
								<textarea name="other" cols="40" rows="10" id="other"></textarea>
							</div>
						</div>
					</form>
				</li>
			</ul>
		
		<?php echo $tabs['content']; ?>
	</div>
</div>

<div class="green title row">
	<div class="twelve columns">
		<h2><?php echo ucfirst(lang('administration')); ?></h2>
		<div class="green bottom">
			<!-- here be dragons -->
		</div>
	</div>
</div>