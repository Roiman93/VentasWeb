
<div class="ui  stackable mini menu" style="margin: 0 auto 0 auto; background-color:#0FDDE5;">
  <div  class="item left" > 
  <a href="?opcion=inicio" style="display: block; text-align: center;  color:#000000;"> <h4><?php print $cfg[0]->nombre;?></h4> </a>
  </div>
           <div class="right menu" >
            <a  class="item">
           <p>	<?php print $f_larga; ?> 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php 
					if(!isset($_SESSION['ih_id'])){?>
                       <?php print"invitado" ?></a> <a href='?opcion=login' class="item"><button class="mini ui red button" >Iniciar sesión</button> </a>
					<?php }else{?>
						<?php print "<i class='user white icon'></i> ".$_SESSION['ih_nombre']."&nbsp;&nbsp;&nbsp;&nbsp;";?> </p>
						<a href="?opcion=closini" class="item"> <button class="mini ui red button" >Salir </button></a>
						
					  
				<?php }?>  
           </div>
</div>
