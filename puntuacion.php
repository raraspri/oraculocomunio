<?php

require 'funciones.php';

if (isset($_POST['puntuacion'])) {
	if ($_POST['puntuacion'] == 'Subir') {
        $err = array();
        // para guardar los errores que se vaya obteniendo
        if (!$_POST['local'] || !$_POST['visitante']) {
            $err[] = 'No se ha especificado los dos equipos';
        }
	else{
		$id_local = $_POST['local'];
		$id_visitante = $_POST['visitante'];
		$id_partido = $_POST['partido'];
		for($i=1;$i<=28;$i++){
			$jug = 'j'.$i;
			$punt = 'n'.$i;
			
			if (!$_POST[$jug] || !$_POST[$punt]) {
        		}else{
	
				$puntuacion = $_POST[$punt];
				
$id_jugador = consultaJugador($_POST[$jug]);
			if ($i<=14){
				$equipo = $id_local;
			}
			else{
				$equipo = $id_visitante;
			}
	crearPuntuacion($id_partido,$id_jugador,$puntuacion,$equipo);
			}
		}
	
	}
}
}
?>