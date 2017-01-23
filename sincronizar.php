<?php

require 'webservice.php';

$idPartido = $_POST['idPartido'];
$idEquipoLocal = consultaIdEquipoLocalPartido($idPartido);
calcula_inserta_puntos($idPartido, $idEquipoLocal);

$idEquipoVisitante = consultaIdEquipoVisitantePartido($idPartido);
calcula_inserta_puntos($idPartido, $idEquipoVisitante);
header("Location: index.php");

?>