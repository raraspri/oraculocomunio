<?php

require 'funciones.php';

if (isset($_POST['activar'])) {
	if ($_POST['activar'] == 'Activar') {
        $err = array();
        // para guardar los errores que se vaya obteniendo

        if (!$_POST['Numero']) {
            $err[] = 'No se ha especificado el numero de la jornada';
        }
	else{
		desactivarJornadas();
		$numero = $_POST['Numero'];
		activarJornada($numero);
	}
}
}

header("Location: admin.php");

?>