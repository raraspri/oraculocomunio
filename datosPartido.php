<?php
require 'funciones.php';
require 'twitter.php';

$idPartido = $_POST['idPartido'];
$visibilidadPartido = $_POST['visibilidadPartido'];

//actualizaTipoPuntuacionPartido($idPartido);

$contL = $_POST['contL'];
$contV = $_POST['contV'];



//$jugPtsLocal = array();
for ($i=0; $i < $contL; $i++) { 
	$nombreL = $_POST["0_".$i];
	$ptosL = $_POST["1_".$i];

	$idJugadorL = consultaIdJugadorFromNombre($nombreL);
	actualizaPuntuacionFinalJugador($idJugadorL, $ptosL, $idPartido);
	//$jugPtsLocal[$idJugadorL] = $ptosL;
}

//$jugPtsVisitante = array();
for ($i=0; $i < $contV; $i++) { 
	$nombreV = $_POST["3_".$i];
	$ptosV = $_POST["4_".$i];

	$idJugadorV = consultaIdJugadorFromNombre($nombreV);
	actualizaPuntuacionFinalJugador($idJugadorV, $ptosV, $idPartido);
	//$jugPtsVisitante[$idJugadorV] = $ptosV;
}

//Se cambia el estado para que lo puedan ver los usuarios
cambiarEstadoPartido($idPartido, $visibilidadPartido);

//Si es el inicio del partido se pone el tweet
if(isset($_POST['inicioPartido'])){
	if ($_POST['inicioPartido'] == "true") {
		$equipoLocal = nombreEquipo(consultaIdEquipoLocalPartido($idPartido));
		$equipoVisitante = nombreEquipo(consultaIdEquipoVisitantePartido($idPartido));

		$mensaje = 'Comienza el partido entre #'.$equipoLocal.' - #'.$equipoVisitante.'. Al finalizar posibles puntos en http://comunioraculo.es/';
		//writeTweet($mensaje);
	}
}
//Si es el final del partido se pone el tweet
elseif(isset($_POST['finPartido'])){
	if ($_POST['finPartido'] == "true") {
		$equipoLocal = nombreEquipo(consultaIdEquipoLocalPartido($idPartido));
		$equipoVisitante = nombreEquipo(consultaIdEquipoVisitantePartido($idPartido));

		$mensaje = 'Ya están disponibles los posibles puntos del partido #'.$equipoLocal.' - #'.$equipoVisitante.' en http://comunioraculo.es/';
		//writeTweet($mensaje);
	}
}

header("Location: index.php");
?>