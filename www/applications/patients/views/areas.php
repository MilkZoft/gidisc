<form action="<?php print path("patients/test/" . $IDPatient);?>" method="POST">
	<p>
		<span>Selecciona una área</span><br />
		
		<select name="area">
			<?php foreach($areas as $area) { 
				if($area["ID_Area"] == 32 and SESSION("ZanUserTypeID") == 3) {
				?>
					<option value="<?php print $area["ID_Area"];?>"><?php print ucfirst(strtolower($area["Name"]));?> - <?php print ucfirst(strtolower($area["Parent"]));?></option>
				<?php 
					break;
				} elseif (SESSION("ZanUserTypeID") == 6 and $area["ID_Area"] < 32) {
				?>
					<option value="<?php print $area["ID_Area"];?>"><?php print ucfirst(strtolower($area["Name"]));?> - <?php print ucfirst(strtolower($area["Parent"]));?></option>
				<?php
				} elseif (SESSION("ZanUserTypeID") == 7 and $area["ID_Area"] == 34) {
				?>
					<option value="<?php print $area["ID_Area"];?>"><?php print ucfirst(strtolower($area["Name"]));?> - <?php print ucfirst(strtolower($area["Parent"]));?></option>
				<?php
				} elseif (SESSION("ZanUserTypeID") == 8 and $area["ID_Area"] == 33) {
				?>
					<option value="<?php print $area["ID_Area"];?>"><?php print ucfirst(strtolower($area["Name"]));?> - <?php print ucfirst(strtolower($area["Parent"]));?></option>
				<?php
				} elseif (SESSION("ZanUserTypeID") == 3 and $area["ID_Area"] == 32) {
				?>
					<option value="<?php print $area["ID_Area"];?>"><?php print ucfirst(strtolower($area["Name"]));?> - <?php print ucfirst(strtolower($area["Parent"]));?></option>
				<?php
				} elseif (SESSION("ZanUserTypeID") == 1) {
				?>
					<option value="<?php print $area["ID_Area"];?>"><?php print ucfirst(strtolower($area["Name"]));?> - <?php print ucfirst(strtolower($area["Parent"]));?></option>
				<?php
				}
			}
				?>
		</select>
	</p>
	
	<p>
		<input type="hidden" value="<?php print $IDPatient;?>" name="IDPatient">
		<input id="send" class="btn btn-success" type="submit" value="<?php print __("Send");?>" name="send">
	</p>
</form>
