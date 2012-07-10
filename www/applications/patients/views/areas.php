<form action="<?php print path("patients/test/" . $IDPatient);?>" method="POST">
	<p>
		<span><?php print __("Select area");?></span><br />
		
		<select name="area">
			<?php foreach($areas as $area) { ?>
				<option value="<?php print $area["ID_Area"];?>"><?php print ucfirst(strtolower($area["Name"]));?> - <?php print ucfirst(strtolower($area["Parent"]));?></option>
			<?php } ?>
		</select>
	</p>
	
	<p>
		<input type="hidden" value="<?php print $IDPatient;?>" name="IDPatient">
		<input id="send" class="btn btn-success" type="submit" value="<?php print __("Send");?>" name="send">
	</p>
</form>
