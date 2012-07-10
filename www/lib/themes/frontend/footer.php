<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
?>
        	

        	<div class="row footer" title="footer">
        		<div class="span5">
     				<h2>Acerca de Gidi</h2>
            		<p>La opci&oacute;n integral para resolver los transtornos del desarrollo y las dificultades del aprendizaje escolar</p>
        		</div>

        		<div class="span8 users">
        			<img src="<?php print $this->themePath; ?>/images/users.png" alt="Users" />
        		</div>
        	</div>
   		</div>
   		
   		<?php print $this->getJs(); ?>
  	
  	</body>
</html>
