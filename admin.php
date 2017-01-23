<?php

session_start();

if(empty($_SESSION['usuario']) || $_SESSION['usuario'] != "logado"){
    header("Location: login.php");
}

require 'funciones.php';

$error = "";
$x = consultaJornadaActiva();
if (!$x){
    $error = 'No hay jornada';
}
else{
    $partidos = partidosJornadaEquipos($x);
    $njornada = consultaJornada($x);
    if(!$partidos){
        $error = 'No hay partidos';
    }
    else{
    }
}

$equipos = equipos();
$equipos = json_encode(array_values($equipos));

?>
<!DOCTYPE HTML>
<!--
    Read Only by HTML5 UP
    html5up.net | @n33co
    Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
    <head>

    <?php include("head.php"); ?>
      <script>
      $(function() {
        var availableTags = <?php echo $equipos; ?>;
        $( "#local" ).autocomplete({
          source: availableTags
        });
        $( "#visitante" ).autocomplete({
          source: availableTags
        });
      });
      </script>
    </head>
    <body>
        <!-- Main -->
                <div id="main">

                    <!-- One -->
                        <section id="one">

                        <div class="container">
                        <header>
                            <form action="logout.php" method="POST">
                                <input type="image" name="logout" src="diseno/images/icon_logout.gif" width="20px" style="float: right">
                            </form>
                        </header>
                <h2>Admistracion</h2>
                        
                <h3>Activar Jornada</h3>
                
                <div>
                    <form action="activarJornada.php" method="post">
		              <input type="text"  name="Numero" id="celda" required="required" maxlength="2" onkeypress="return soloNumeros(event)">
					  <br/>
                    <input style="text-align: center; margin-left: 43%;" type="submit" name="activar" value="Activar" />
                    </form>
                </div>


<h3>Añadir Partido</h3>
                <!-- <form action="partido.php" method="post"> -->
                    <form action="gestionPartidos.php" method="post">
                <input id="local" name="Local" style="width: 388px;">
    		    <input id="visitante" name="Visitante" style="width: 388px;">
					<p><p/>
                    <input style="text-align: center; margin-left: 44%;" type="submit" name="anadir" value="Subir" />
                    </form>
					
					<h3>Sincronizar Partido</h3>
                
                <div>
                    <form action="gestionPartidos.php" method="POST">
                        <select name="idPartido">
                            <?php
                            foreach ($partidos as $key) {
                                $idPartido = $key[0];
                                $equipo1 = $key[1];
                                $equipo2 = $key[2];

                                ?>
                                <option value="<?php echo $idPartido ?>"><?php echo $equipo1 ?> - <?php echo $equipo2 ?></option> 
								
                                <?php
                            }
                            ?>
                        </select>
						<?=$error?>
						<br/>
                        <input type="submit" name="sincronizar" value="Sincronizar" style="text-align: center; margin-left: 41%;">
                    </form>
                </div>
                
            </section><!-- content -->
        </div><!-- container -->
	<br/>
	<div style="margin-left:410px;">
		<a style="margin-left: 25px" class="twitter-timeline" href="https://twitter.com/comunio_oraculo" data-widget-id="552842687569985538">Tweets por el @comunio_oraculo.</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>
	</body>
</html>