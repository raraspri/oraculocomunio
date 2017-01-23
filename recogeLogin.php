<?php

require 'funciones.php';
session_start();

if (isset($_POST['login-submit'])) {
    if ($_POST['login-submit'] == 'Login') {

        $err = array();
        // para guardar los errores que se vaya obteniendo

        if (!$_POST['loginUser'] || !$_POST['loginPass']) {
            $err[] = 'Error al iniciar sesi&oacuten';
        }

        if (!count($err)) {
            //Hacer todas las consultas a la BD
            $userLogin = $_POST['loginUser'];
            $passwordLogin = $_POST['loginPass'];

            
            //$userOK = "manteca92";
            //$passOK = "jarmanteca92";
            if (consultaUsuariosAdministracion($userLogin, $passwordLogin)) {                
                    $_SESSION['usuario'] = "logado";
            } else {
                $err[] = 'Error al iniciar sesi&oacuten';
            }
        }
    }
} else {
    $err[] = 'Error al iniciar sesi&oacuten';
}

if ($err) {
    $_SESSION['errores'] = implode('<br />', $err);

    header("Location: login.php");
    exit;
} else {
    header("Location: admin.php");
}
?>