			<form action="http://dev.xxw.ca/send_sms.php" method="post" class="pure-form pure-form-stacked"> 
				<a class="pure-menu-heading" href="/">Your Kitty Fuel Vehicle Ranking!</a>
				<label for="To">Please enter a Mobile Number with international code attached, example 1 is added in front to US/CAN number</label>
				<input type="text" name="To" maxlength="13" placeholder="Enter Your Mobile Number" class="pure-u-4-5 pure-input-rounded"> 
				<input type="hidden" name="Security" maxlength="10" value="meow" placeholder="" class="pure-u-4-5 pure-input-rounded"> 
				<input type="hidden" name="From" maxlength="10" value="16474979319" placeholder="" class="pure-u-4-5 pure-input-rounded"> 
				<input type="hidden" name="Text" value="<?php echo $personalized_message;?>">
				<input type="submit" value="Get Personalized Ranking!" class="pure-button pure-button-primary pure-u-4-5">
			</form>