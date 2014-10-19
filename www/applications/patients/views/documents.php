<div class="documents">
	<h1>Documentos</h1>

	<ol>
	<?php
		if (isset($documents)) {
			foreach ($documents as $document) {
			?>
				<li><a href="<?=$document["url"];?>" target="_blank"><?=$document["filename"];?></a> - <a href="<?=path("patients/upload/$userId/". $document["filename"] ."");?>">X</a></li>
			<?php
			}
		}
	?>
	</ol>

	<h2>Subir archivos</h2>

	<form action="<?=path("patients/upload/$userId");?>" method="post" enctype="multipart/form-data">
		<p>
			<input type="file" name="files[]" multiple="multiple" /> 
		</p>

		<p>
			<input type="submit" class="btn btn-info" value="Subir" name="upload" />
		</p>
	</form>
</div>