<?php
	$code = code();
	SESSION("ZanUserCode", $code);
?>
<div class="centers">
	<h2>
		<?php print __("Seguimientos");?>
		<?php print ($patient) ? " - " . $patient["Name"] . " " . $patient["Last_Name"] . " " . $patient["Maiden_Name"] : "";?>
	</h2>
	<table class="bordered-table zebra-striped table">
		<thead>
			<tr>
				<th>#ID Format</th>
				<th><?php print __("Area");?></th>
				<th><?php print __("Month");?></th>
				<th><?php print __("Date");?></th>
				<th><?php print __("Actions");?></th>
			</tr>
		</thead>
		<tbody>
			<?php if($formats) { 				 					 
				 	foreach($formats as $format) { ?>
					<tr>
						<td><?php print $format["ID_Format"];?></td>
						<td><?php print $format["Name"];?></td>
						<td><?php print month($format["Month_"]);?></td>
						<td><?php print $format["Text_Date"];?></td>
						
						<td>
							<a href="<?php print path("test/show/" . $format["ID_Format"]);?>" title="View">
								<span class="no-decoration"><?php print __("View");?></span>
							</a>
							
							<!--<a href="<?php print path("test/edit/" . $format["ID_Format"]);?>" title="Edit" onclick="return confirm('Do you want to edit the record?')">
								<span class="tiny-image tiny-edit no-decoration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
							</a>-->
							
							<a href="<?php print path("test/download/" . $patient["ID_Patient"] . "/" . $format["ID_Format"]);?>" title="Download">
								<span class="no-decoration"><?php print __("Download");?></span>
							</a>
							
							<!--<a href="<?php print path("test/delete/" . $patient["ID_Patient"] . "/" . $format["ID_Format"]) . "/" . $code ;?>" title="Edit" onclick="return confirm('Do you want to delete the record?')">
								<span class="tiny-image tiny-trash no-decoration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
							</a>-->
						</td>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="4">
						<span><?php print __("No results :(");?> </span>
						
						<a href="" onclick="history.back(-1);" title="Patients">
							<?php print __("Return");?>
						</a>
					<td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<?php
		if(strlen($fIDs) > 1) {
		?>
			<a href="<?php print path("test/download/" . $patient["ID_Patient"] . "/$fIDs"); ?>" title="Download">
				<span class="no-decoration"><?php print __("Download All");?></span>
			</a>
		<?php
		}

		print $pagination; ?>
</div>
