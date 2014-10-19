	<?php
	if(SESSION("ZanUserTypeID") == 1) {
	?>
		<form action="<?php echo path("patients"); ?>" method="post" class="form-results-search" enctype="multipart/form-data">
			<fieldset>
				<span class="Bold">Buscar nombre: </span><input name="name" class="small-input" type="text"> <input name="seek" value="Buscar" type="submit"> 
			</fieldset>
		</form>
	<?php
	}
	?>
        
<div class="centers"><h2><?php print __("Patients");?></h2>
	<table class="bordered-table zebra-striped table">
		<thead>
			<tr>
				<th>#</th>
				<th><?php print __("Name");?></th>
				<th><?php print __("Last Name");?></th>
				<th><?php print __("Maiden Name");?></th>
				<th><?php print __("Actions");?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if(!is_array($patients)) {
					echo "No tienes ningún paciente asignado";
				} else {
					foreach($patients as $patient) { ?>
					<tr>
						<td><?php print $patient["ID_User"];?></td>
						<td><?php print $patient["Name"];?></td>
						<td><?php print $patient["Last_Name"];?></td>
						<td><?php print $patient["Maiden_Name"];?></td>
						
						<td>
							<?php
								if(SESSION("ZanUserTypeID") == 1) {
									?>
									<a href="<?php print path("patients/permissions/" . $patient["ID_User"]);?>">
										<span class="no-decoration"><?php print __("Asignar permisos");?></span>
									</a>
									<?php
								}
							?>

							<a href="<?php print path("patients/centers/" . $patient["ID_User"]);?>">
								<span class="no-decoration"><?php print __("Asignar centro");?></span>
							</a>

							<a href="<?php print path("patients/area/" . $patient["ID_User"]);?>" title="Edit" onclick="return confirm('Do you want to do the test?')">
								<span class="no-decoration"><?php print __("Seguimiento");?></span>
							</a>
							
							<a href="<?php print path("test/get/" . $patient["ID_User"]);?>" title="Ver seguimientos">
								<span class="no-decoration"><?php print __("Ver Seguimientos");?></span>
							</a>


							<?php
							if(SESSION("ZanUserTypeID") != 8 and SESSION("ZanUserTypeID") != 3 and SESSION("ZanUserTypeID") != 5) {
							?>
								<a href="<?php print path("quiz/getall/" . $patient["ID_User"]);?>" title="Agregar pruebas">
									<span class="no-decoration"><?php print __("Agregar pruebas");?></span>
								</a>
							<?php
							}
							?>

							<a href="<?php print path("patients/upload/" . $patient["ID_User"]);?>" title="Ver seguimientos">
								<span style="color: red;" class="no-decoration"><?php print __("Subir Documentos");?></span>
							</a>
							
							<a href="<?php print path("users/cpanel/edit/" . $patient["ID_User"]);?>" title="Edit" onclick="return confirm('Do you want to edit the record?')">
								<span class="tiny-image tiny-edit no-decoration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
							</a>
						</td>
					</tr>
				<?php 
				} 
			}
			?>
		</tbody>
	</table>

	<?php print $pagination; ?>
</div>
