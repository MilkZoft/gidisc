<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
?>
        	<div class="row bottom-menu" title="bottom-menu">
     			<ul>
          			<li><a href="#" title="Enlace 1">Centros</a></li>
          			<li><a href="#" title="Enlace 1">Reportes</a></li>
          			<li><a href="#" title="Enlace 1">Diagnósticos</a></li>
          			<li><a href="#" title="Enlace 1">Medicamentos</a></li>
          			<li><a href="#" title="Enlace 1">Pacientes</a></li>
          			<li><a href="#" title="Enlace 1">Maestros</a></li>
          			<li><a href="#" title="Enlace 1">Padres</a></li>
      			</ul>
        	</div>

        	<div class="row footer" title="footer">
        		<div class="span5">
     				<h2>Acerca de Gidi</h2>
                <p>La opción integral para resolver los trastornos del desarrollo y las dificultades del aprendizaje escolar.</p>
        		</div>

        		<div class="span8 users">
              <?php print $this->execute("Users_Controller", "showPatients", NULL, "controller"); ?>
        		</div>
        	</div>
   		</div>
      <script>
        $(document).on("ready", function() {
          $("#action2").on("click", function(){
            $(".day-input").val('');
            $(".days-input").val('');
            $(".obsv").val('');
          });
        });
      </script>
   		<?php print getScript("www/lib/scripts/js/check.js");?>
   		<?php print getScript("www/lib/scripts/js/jquery-ui-1.8.17.custom.min.js");?>
   		
   		<?php $this->js("search", "search"); ?>
   		<?php print $this->getJs(); ?>
   		
   		<?php print getScript("www/lib/scripts/js/bootstrap-dropdown.js");?>
   		<script>
			$('#menu').dropdown();
   		</script>
  	</body>
</html>
