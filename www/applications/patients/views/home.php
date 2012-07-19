<div class="span5 search">	
	<input class="span3" id="" name="search_patients" placeholder="Introduzca su búsqueda..." type="text" />
    <button id="inputsearch_patients" class="btn primary">Buscar</button>
</div>
        
<div class="centers"><h2><?php print __("Patients");?></h2>
	<table class="bordered-table zebra-striped table">
		<thead>
			<tr>
				<th>#</th>
				<th><?php print __("Name");?></th>
				<th><?php print __("Last Name");?></th>
				<th><?php print __("Maiden Name");?></th>
				<th><?php print __("Username");?></th>
				<th><?php print __("Actions");?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($patients as $patient) { ?>
				<tr>
					<td><?php print $patient["ID_Patient"];?></td>
					<td><?php print $patient["Name"];?></td>
					<td><?php print $patient["Last_Name"];?></td>
					<td><?php print $patient["Maiden_Name"];?></td>
					<td><?php print $patient["Username"];?></td>
					
					<td>
						<a href="<?php print path("patients/area/" . $patient["ID_Patient"]);?>" title="Edit" onclick="return confirm('Do you want to do the test?')">
							<span class="no-decoration"><?php print __("Seguimiento");?></span>
						</a>
						
						<a href="<?php print path("test/get/" . $patient["ID_Patient"]);?>" title="Ver seguimientos">
							<span class="no-decoration"><?php print __("Ver Seguimientos");?></span>
						</a>
						
						<a href="<?php print path("quiz/getall/" . $patient["ID_Patient"]);?>" title="Agregar pruebas">
							<span class="no-decoration"><?php print __("Agregar pruebas");?></span>
						</a>
						
						<a href="<?php print path("users/cpanel/edit/" . $patient["ID_User"]);?>" title="Edit" onclick="return confirm('Do you want to edit the record?')">
							<span class="tiny-image tiny-edit no-decoration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
						</a>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<?php print $pagination; ?>
</div>
