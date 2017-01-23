<?php

require 'funciones.php';

if (isset($_POST['anadir'])) {
	if ($_POST['anadir'] == 'Subir') {
        $err = array();
        // para guardar los errores que se vaya obteniendo

        if (!$_POST['Local'] || !$_POST['Visitante']) {
            $err[] = 'No se ha especificado los dos equipos';
        }
	else{
		$nlocal = $_POST['Local'];
		$nvisitante = $_POST['Visitante'];
    		$local = consultaEquipo($_POST['Local']);
   		$visitante = consultaEquipo($_POST['Visitante']);
                $jornada = consultaJornadaActiva();
		$id =anadirPartido($jornada,$local,$visitante);
		$jugadoresLocal = jugadores($local);
		$jugadoresVisitante = jugadores($visitante);
	
	}
}
}
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6 ielt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7 ielt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> 
<html lang="en"> <!--<![endif]--> 
    <head>
        <meta charset="utf-8">
        <title>Añadir Partido</title>
        <link rel="stylesheet" type="text/css" href="diseno/css/style.css" />
    </head>
    <body>
        <div class="container">
            <section id="content">

<h2>Partido</h2>
                
                <div>
                    <form action="puntuacion.php" method="post">
		    <h3><?php echo $nlocal ?></h3>
		    <?php for ($i = 1; $i <= 14; $i++) { ?>
		    
		    <select name="j<?php echo $i;?>"> 
             		<?php foreach($jugadoresLocal as $f): ?>                 
                	<option value="<?php echo $f ?>"><?php echo $f ?></option> 
             		<?php endforeach; ?>     
			<input type="text"  name="n<?php echo $i ?>"  maxlength="2" onkeypress="return soloNumeros(event)"><br />
			<?php } ?> 
			<input type="hidden" name="local" id="local" value=" <?=$local ?>" >
		<br /><br />
		<h3><?php echo $nvisitante ?></h3>
		<?php for ($i = 15; $i <= 28; $i++) { ?>
		   
		    <select name="j<?php echo $i;?>"> 
             		<?php foreach($jugadoresVisitante as $f): ?>                 
                	<option value="<?php echo $f ?>"><?php echo $f ?></option> 
             		<?php endforeach; ?>     
			<input type="text"  name="n<?php echo $i ?>"  maxlength="2" onkeypress="return soloNumeros(event)"><br />
			<?php } ?> 
		    	<input type="hidden" name="visitante" id="visitante" value=" <?=$visitante ?>" >
		    	<input type="hidden" name="partido" id="partido" value=" <?=$id ?>" >
                    <input style="text-align: center; margin-left: 35%;" type="submit" name="puntuacion" value="Subir" />
                    </form>
                </div>
                
            </section><!-- content -->
        </div><!-- container -->
    </body>
</html>