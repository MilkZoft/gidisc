<?php
	session_start();

	$URL = $_SESSION["btaURL"];
?>
<div class="bta">
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="550" height="450" id="BTA" align="middle">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="movie" value="bta.swf?url=<?php echo $URL; ?>" />
		<param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />
		<embed src="bta.swf?url=<?php echo $URL; ?>" quality="high" bgcolor="#ffffff" width="550" height="450" name="BTA" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</div>