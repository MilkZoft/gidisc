<?php if(!defined("_access")) { die("Error: You don't have permission to access here..."); } ?>

<div id="home">
	<br />
	<p class="resalt">
		<?php print __("Home"); ?>
	</p>
	
	<?php
		print $lastUsers;
		print $lastCenters;		
	?>	
</div>