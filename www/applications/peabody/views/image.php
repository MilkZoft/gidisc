<form action="<?php echo path("peabody/image/$number"); ?>" method="post" style="text-align: center;">

	<h1><?php echo $word; ?></h1>
	<img src="<?php echo path("www/applications/peabody/views/images/$number.jpg", TRUE); ?>" />
		
	<p>
		<br />
		Elige la opción (1-4): <input name="option" type="text" />
	</p>

	<p>
		<input name="continue" value="Continuar" type="submit" />
	</p>

	<input name="number" value="<?php echo $number; ?>" type="hidden" />
	<input name="word" value="<?php echo $word; ?>" type="hidden" />
</form>