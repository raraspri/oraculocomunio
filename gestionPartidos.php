<?php


require 'funciones.php';
require 'webservice.php';

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
			$local = consultaEquipo($_POST['Local']);//idEquipo
			$visitante = consultaEquipo($_POST['Visitante']);//idEquipo
			$golesLocal = 0;
			$golesVisitante = 0;
			$jornada = consultaJornadaActiva();//idJornada
			$idPartido = anadirPartidoAdmnin($jornada,$local,$visitante, $golesLocal, $golesVisitante);
			$jugadoresLocal = consultaJugadoresEquipo($local);
			$jugadoresVisitante = consultaJugadoresEquipo($visitante);

			gestionaPuntuacionesAlg($local, $visitante,$jornada, $idPartido);
		}
	}
}

elseif (isset($_POST['sincronizar'])) {
	if ($_POST['sincronizar'] == 'Sincronizar') {
		$idPartido = $_POST['idPartido'];

		$local = consultaIdEquipoLocalPartido($idPartido);
		$nlocal = nombreEquipo($local);
		$visitante = consultaIdEquipoVisitantePartido($idPartido);
		$nvisitante = nombreEquipo($visitante);
		$jornada = consultaJornadaActiva();//idJornada
		$jugadoresLocal = consultaJugadoresEquipo($local);
		$jugadoresVisitante = consultaJugadoresEquipo($visitante);

		gestionaPuntuacionesAlg($local, $visitante,$jornada, $idPartido);
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
        <?php //include("head.php"); ?>
        <!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
        <link rel="stylesheet" type="text/css" href="diseno/css/style.css" />
        <!-- DataTables CSS -->
		<link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.4/media/css/jquery.dataTables.css">
		  
		<!-- jQuery -->
		<script type="text/javascript" charset="utf8" src="lib/DataTables-1.10.4/media/js/jquery.js"></script>
		  
		<!-- DataTables -->
		<script type="text/javascript" charset="utf8" src="lib/DataTables-1.10.4/media/js/jquery.dataTables.js"></script>

		<style type="text/css">
			#content{
				width: 95% !important;
			}
			.container{
				width: 100%;
			}
			#tablaPuntuaciones_wrapper{
				margin: 30px;
			}
		</style>

    </head>
    <body>
    <!-- Main -->
                <div id="main">

                    <!-- One -->
                        <section id="one">
        <div class="container">
            <section id="content">
            <form action="datosPartido.php" method="POST">
            <select name="visibilidadPartido">
            	<option value="visible_admin" >Visible Admin</option>
            	<option value="visible_usuario" selected="selected">Visible Usuarios</option>
            </select>
            <div style="margin: 10px;">
            	<input type="checkbox"  id="finPartido" name="finPartido" value="true" onclick="onClickFinPartido()">Fin del Partido<br>
            	<input type="checkbox"  id="inicioPartido" name="inicioPartido" value="true" onclick="onClickInicioPartido()">Inicio del Partido<br>
            </div>	

            	<input type="hidden" name="idPartido" value="<?php echo $idPartido; ?>">
				<h2>Partido <?php echo $nlocal ?> - <?php echo $nvisitante ?></h2>
				<?php
					$countJugLocal = count($jugadoresLocal)-1;
					$contL = 0; 
					$countJugVisitante = count($jugadoresVisitante)-1;
					$contV = 0; 
				?>
				<input type="hidden" name="contL" value="<?=$countJugLocal?>">
				<input type="hidden" name="contV" value="<?=$countJugVisitante?>">
				<table id="tablaPuntuaciones">
					<thead>
						<tr>
							<th>Jugador <?php echo $nlocal ?></th>
							<th>Puntuacion Objetiva</th>
							<!--<th>Puntuacion Subjetiva</th>-->
							<th></th>
							<th>Jugador <?php echo $nvisitante ?></th>
							<th>Puntuacion Objetiva</th>
							<!--<th>Puntuacion Subjetiva</th>-->
						</tr>
					</thead>

					<tbody>
						<?php

						$res = "";
						while( ($contL <= $countJugLocal) || ($contV <= $countJugVisitante) ){
							$res .= "<tr>";

								if($contL <= $countJugLocal){
									$id_jugLocal = $jugadoresLocal[$contL][0];
									$nombre_jugLocal = $jugadoresLocal[$contL][1];
									$puntSubLocal = consultarPuntuaionSubjetivaJugador($idPartido, $id_jugLocal);
									$puntObjLocal = consultarPuntuaionObjetivaJugador($idPartido, $id_jugLocal);

									$res .= "<td>$nombre_jugLocal<input type='text' name='0_$contL' value='$nombre_jugLocal' style='display: none'/></td>";
									$res .= "<td><input type='text' name='1_$contL' value='$puntObjLocal'/></td>";
									//$res .= "<td><input type='tel' name='2_$contL' value='$puntSubLocal' maxlength='2'/></td>";
								}else{
									$res .= "<td></td>";
									$res .= "<td></td>";
									//$res .= "<td></td>";
								}

									$res .= "<td></td>";
								if($contV <= $countJugVisitante){
									$id_jugVis = $jugadoresVisitante[$contL][0];
									$nombre_jugVis = $jugadoresVisitante[$contL][1];
									$puntSubVis = consultarPuntuaionSubjetivaJugador($idPartido, $id_jugVis);
									$puntObjVis = consultarPuntuaionObjetivaJugador($idPartido, $id_jugVis);

									$res .= "<td>$nombre_jugVis<input type='text' name='3_$contV' value='$nombre_jugVis' style='display: none'/></td>";
									$res .= "<td><input type='text' name='4_$contV' value='$puntObjVis'/></td>";
									//$res .= "<td><input type='tel' name='5_$contL' value='$puntSubVis' maxlength='2'/></td>";
								}else{
									$res .= "<td></td>";
									$res .= "<td></td>";
									//$res .= "<td></td>";
								}

								$contL++;
								$contV++;

							$res .= "</tr>";
						}
						echo $res;

						?>
					</tbody>
				</table>

				<input type="submit" name="enviar" value="Enviar">
			</form>
          </section><!-- content -->
        </div><!-- container -->
         </section><!-- content -->
        </div><!-- container -->
    </body>
    		<script type="text/javascript">
			$(document).ready( function () {
			    $('#tablaPuntuaciones').DataTable({
			    	paging: false
			    });
			} );

			function onClickFinPartido(){
				if ($("#finPartido").prop('checked') == true) {	
					$("#finPartido").prop('disabled', false);
			    	$("#inicioPartido").prop('disabled', true);
				}else{
					$("#finPartido").prop('disabled', true);
			    	$("#inicioPartido").prop('disabled', false);
				}
			}

			function onClickInicioPartido(){
				if ($("#inicioPartido").prop('checked') == true) {	
					$("#finPartido").prop('disabled', true);
			    	$("#inicioPartido").prop('disabled', false);
				}else{
					$("#finPartido").prop('disabled', false);
			    	$("#inicioPartido").prop('disabled', true);
				}
			}
		</script>
</html>