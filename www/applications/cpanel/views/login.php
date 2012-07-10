<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
?>
<!DOCTYPE html>
<html lang="<?php print get("webLang"); ?>">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Login</title>
		
		<link href="<?php print path("www/lib/css/frameworks/bootstrap/bootstrap.min.css", TRUE); ?>" rel="stylesheet">
		<link href="<?php print path("www/lib/themes/gidi/css/style.css", TRUE); ?>" rel="stylesheet">

		<script type="text/javascript">
			var PATH = "<?php print path(); ?>";
			
			var URL  = "<?php print get('webURL'); ?>";
		</script>

		<style>
			body {
				background-color: #EEE;
			}
		</style>
	</head>

	<body>
		<div style="width: 500px; margin: 0 auto; margin-top: 10%; border: 1px solid #666; background-color: #FFF;">    
			<form style="text-align: center;" action="<?php print path("cpanel/login/"); ?>" method="post">
				<fieldset>				
					<?php
						if(isset($error) and $error === TRUE) {
							print showError(__("Incorrect Login"));
						}
					?>
					
					<p>
						<img src="<?php print path("www/lib/themes/gidi/images/logo.png", TRUE); ?>" alt="Gidi" />
 					</p>

					<p>
						<?php print __("Authentification"); ?>
					</p>
					
					<p>
						<strong><?php print __("Username"); ?>:</strong><br />
	              		<input id="username" name="username" type="text" tabindex="1">
	            	</p>
					
					<p>
						<strong><?php print __("Password"); ?>:</strong><br />
						<input id="password" class="password" name="password" type="password" tabindex="2" />
					</p>	
					
					<p>
						<input class="btn primary" name="connect" type="submit" value="<?php print __("Connect"); ?>" tabindex="3" />
					</p>
					
					<input name="URL" type="hidden" value="<?php print $URL; ?>" />
				</fieldset>
			</form>
        
        	<div style="text-align: center">
        		<p>Desarrollado por <a href="http://www.milkzoft.com" target="_blank">MilkZoft</a></p>
        	</div>
  		</div>
  	</body>
</html>
