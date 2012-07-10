<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
?>
<div class="row bg-white">
    <div class="span17 wrapper">
		<?php $this->load(isset($view) ? $view : NULL, TRUE); ?>
	</div>
</div>