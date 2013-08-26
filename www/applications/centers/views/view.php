<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
	$ID 	   = $center["ID_Center"];
	$name 	   = $center["Name"];
	$address   = $center["Address"];
	$country   = $center["Country"];
	$district  = $center["District"];
	$phone     = $center["Phone"];
	$contact   = $center["Contact"];
	$situation = $center["Situation"];
	$href	   = get("webBase") . _sh . get("webLang") . _sh . "centers" . _sh . "cpanel" . _sh . "results" . _sh;
?>	
	<div class="span6">
		<h4><?php print __(_("Name"));?></h4>
		<p><?php print $name;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Address"));?></h4>
		<p><?php print $address;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("District"));?></h4>
		<p><?php print $district;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Country"));?></h4>
		<p><?php print $country;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Phone"));?></h4>
		<p><?php print $phone;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Contact"));?></h4>
		<p><?php print $contact;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Type"));?></h4>
		<p><?php print $type;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Situation"));?></h4>
		<p><?php print $situation;?></p>
	</div>
	
	<a href="<?php print $href;?>" title="<?php print __(_("Return"));?>"><?php print __(_("Return"));?></a>

	<br />
	
	<?php if (isset($patients) and is_array($patients)) { ?>
		<div class="centers"><h2><?php print __("Pacientes, Maestros y Directivos");?></h2>
		<table class="bordered-table zebra-striped table">
			<thead>
				<tr>
					<th>#</th>
					<th><?php print __("Tipo");?></th>
					<th><?php print __("Nombre");?></th>
					<th><?php print __("Apellido Paterno");?></th>
					<th><?php print __("Apellido Materno");?></th>
					<th><?php print __("Acciones");?></th>
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
							<td>
							<?php 
								if ($patient["ID_Type_User"] == 1) {
									echo "Administrador";
								} elseif ($patient["ID_Type_User"] == 2) {
									echo "Centro";
								} elseif ($patient["ID_Type_User"] == 3) {
									echo "Maestro";
								} elseif ($patient["ID_Type_User"] == 4) {
									echo "Paciente";
								} elseif ($patient["ID_Type_User"] == 5) {
									echo "Familiar";
								} elseif ($patient["ID_Type_User"] == 6) {
									echo "Terapeuta";
								} elseif ($patient["ID_Type_User"] == 7) {
									echo "Psicólogo";
								} elseif ($patient["ID_Type_User"] == 8) {
									echo "Doctor";
								}
							?>
							</td>
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
								
								<a href="<?php print path("quiz/getall/" . $patient["ID_User"]);?>" title="Agregar pruebas">
									<span class="no-decoration"><?php print __("Agregar pruebas");?></span>
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
	</div>
	<?php } ?>
