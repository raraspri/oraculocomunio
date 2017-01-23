<?php

function connBD() {
    $conn = mysql_connect('localhost', 'comunioraculo_e', 'oraculo',true);
    if (!$conn) {
        die('Imposible conectar a BD: ' . mysql_error());
    }
    $bd = mysql_select_db("comunioraculo_e", $conn);
    if (!$bd) {
        mysql_close($conn);
        die("Error en BD: " . mysql_error());
    }

    return $conn;
}


function consultaJornadaActiva() {
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
			SELECT `id_jornada` FROM `jornada` WHERE `activa` = '" . $valor . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $id_jornada = "";
    while ($row = mysql_fetch_array($q)) {
        $id_jornada = $row['id_jornada'];
    }
    mysql_close($conn);
    return $id_jornada;
}

function consultaJornada($id) {
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
			SELECT `numero` FROM `jornada` WHERE `id_jornada` = '" . $id . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $numero = $row['numero'];
    }
    mysql_close($conn);
    return $numero;
}

function desactivarJornadas() {
    $conn = connBD();
    $sql = "UPDATE jornada SET activa=0 WHERE activa=1";
    $q = mysql_query($sql);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    mysql_close($conn);
}

function activarJornada($numero) {
  $conn = connBD();
  $valor=1;
  $sql = "INSERT INTO jornada (numero, activa)
               VALUES ($numero,$valor)";
   $q = mysql_query($sql);
   if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    mysql_close($conn);
}

function equipos() {
    $conn = connBD();
    $items = array();
    $q = mysql_query("
			SELECT * FROM `equipo`", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $items[$row['id_equipo']] = $row['nombre'];
    }
    mysql_close($conn);
    return $items;
}


function consultaEquipo($nombre) {
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
			SELECT `id_equipo` FROM `equipo` WHERE `nombre` = '" . $nombre . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $id_equipo = $row['id_equipo'];
    }
    mysql_close($conn);
    return $id_equipo;
}

function anadirPartido($jornada,$local,$visitante) {
    $conn = connBD();
    $sql = "INSERT INTO partido (jornada_id,equipo1, equipo2)
               VALUES ($jornada,$local,$visitante)";
    $q = mysql_query($sql);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    $id_partido = mysql_insert_id();
    mysql_close($conn);
    return $id_partido;
}

function jugadores($equipo_id) {
    $conn = connBD();
    $items = array();
    $q = mysql_query("
			SELECT * FROM `jugador` WHERE  `equipo_id`=  '" . $equipo_id . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $items[$row['id_jugador']] = $row['nombre'];
    }
    mysql_close($conn);
    return $items;
}

function consultaJugador($nombre) {
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
			SELECT `id_jugador` FROM `jugador` WHERE `nombre` = '" . $nombre . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $id_jugador = $row['id_jugador'];
    }
    mysql_close($conn);
    return $id_jugador;
}

function crearPuntuacion($partido,$jugador,$punt,$equipo) {
  $conn = connBD();
  $valor=1;
  $sql = "INSERT INTO puntuacion (jugador_id, partido_id, equipo_id, puntuacion)
               VALUES ($jugador,$partido,$equipo,$punt)";
   $q = mysql_query($sql);
   if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    mysql_close($conn);
}

function puntuacionesPartido($equipo_id,$partido_id) {
    $conn = connBD();
    $items = array();
    $q = mysql_query("
			SELECT * FROM `puntuacion` WHERE  `equipo_id`=  '" . $equipo_id . "'  AND `partido_id`=  '" . $partido_id . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    $i=1;
    while ($row = mysql_fetch_array($q)) {
        $items[$i] = $row['puntuacion'];
	$i++;
    }
    mysql_close($conn);
    return $items;
}

function jugadoresPartido($partido_id,$equipo_id) {
    $conn = connBD();
    $items = array();
    $q = mysql_query("
			SELECT * FROM `puntuacion` WHERE  `partido_id`=  '" . $partido_id . "'  AND `equipo_id`=  '" . $equipo_id . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    $i=1;
    while ($row = mysql_fetch_array($q)) {
        $items[$i] = $row['jugador_id'];
	$i++;
    }
    mysql_close($conn);
    return $items;
}

function consultaIdJugadorFromNombre($nombre) {

    $conn = connBD();
    $valor=1;
    $cons = "SELECT `id_jugador` FROM `jugador` WHERE `nombre` LIKE '" . $nombre . "'";

    $q = mysql_query($cons, $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $id_jugador ="";
    while ($row = mysql_fetch_array($q)) {
        $id_jugador = $row['id_jugador'];
    }

    mysql_close($conn);
    return $id_jugador;
}

function consultaJugadorId($id) {
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
			SELECT `nombre` FROM `jugador` WHERE `id_jugador` = '" . $id . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $nombre = $row['nombre'];
    }
    mysql_close($conn);
    return $nombre;
}

function partidosJornada($jornada_id) {
    $conn = connBD();
    $valor=1;
    $items = array();
    $q = mysql_query("
			SELECT `id_partido` FROM `partido` WHERE `jornada_id` = '" . $jornada_id . "' 
            AND `estado` = 'visible_usuario' ORDER BY `id_partido` ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $items[$row['id_partido']] = $row['id_partido'];
    }
    mysql_close($conn);
    return $items;
}

function local($id) {
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
			SELECT `equipo1` FROM `partido` WHERE `id_partido` = '" . $id . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $local = $row['equipo1'];
    }
    mysql_close($conn);
    return $local;
}

function visitante($id) {
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
			SELECT `equipo2` FROM `partido` WHERE `id_partido` = '" . $id . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $visitante = $row['equipo2'];
    }
    mysql_close($conn);
    return $visitante;
}

function nombreEquipo($id) {
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
			SELECT `nombre` FROM `equipo` WHERE `id_equipo` = '" . $id . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $nombre = $row['nombre'];
    }
    mysql_close($conn);
    return $nombre;
}

function limpiar_caracteres_especiales($string) {
    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    /*$string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "),
        '',
        $string
    );*/

    return $string;
}


/**
*
* Recibe el nombre del equipo en formato de la url    
* Retorna el nombre del equipo normal
*
**/
function consultaNombreJugadorAlg($nombreEquipoWebservice){
    $res = "";
    if(strpos($nombreEquipoWebservice, "-")){
        $equipoPart = explode("-", $nombreEquipoWebservice);

        for($i = 0; $i < count($equipoPart); $i++){
            if($i == 0){
                $res .= ucwords($equipoPart[$i]);
            }else{
                $res .= " " . ucwords($equipoPart[$i]);
            }
        }
        
        /*$res = ucwords($equipoPart[0]);
        $res .= " " . ucwords($equipoPart[1]);*/
    }else{
        $res = ucwords($nombreEquipoWebservice);
    }

    return $res;
}

/**
*
* Recibe el numero de la jornada
* Retorna el id de la jornada
**/
function consultaIdJornada($numero){
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `id_jornada` FROM `jornada` WHERE `numero` = '" . $numero . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $id_jornada = "";
    while ($row = mysql_fetch_array($q)) {
        $id_jornada = $row['id_jornada'];
    }
    mysql_close($conn);
    return $id_jornada;
}


/**
*
* Recibe la jornada y los equipos
*
* Retorna el id del partido
*
**/
function consultaIdPartido($id_jornada, $idEquipoLocal, $idEquipoVisitante) {
    $conn = connBD();
    $valor=1;
    $items = array();
    $q = mysql_query("
            SELECT `id_partido` FROM `partido` WHERE `jornada_id` = '" . $id_jornada . "' 
                    AND  `equipo1` = '" . $idEquipoLocal . "'
                    AND `equipo2` = '" . $idEquipoVisitante . "'", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $idPartido ="";
    while ($row = mysql_fetch_array($q)) {
        $idPartido = $row['id_partido'];
    }
    mysql_close($conn);
    return $idPartido;
}

/**
* Recibe el nombre del equipo
*
* Retorna el id del equipo
**/
function consultaIdEquipo($nombre) {
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `id_equipo` FROM `equipo` WHERE `nombre` LIKE '%" . $nombre . "%' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $id_equipo = $row['id_equipo'];
    }
    mysql_close($conn);
    return $id_equipo;
}

/**
*
* Funcion para la gestion de partidos
*
*
**/

function partidosJornadaAdmin($jornada_id) {
    $conn = connBD();
    $valor=1;
    $items = array();
    $q = mysql_query("
            SELECT `id_partido` FROM `partido` WHERE `jornada_id` = '" . $jornada_id . "' 
            AND `estado` = 'visible_admin' ORDER BY `id_partido` ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $items[$row['id_partido']] = $row['id_partido'];
    }
    mysql_close($conn);
    return $items;
}

/**
 * Funcion que muestra los errores en la cabecera
 * Author: Rafa Rastrero
 * Date: 01/04/2013
 */
function mostrarError() {
    if (isset($_SESSION['errores'])) {
        echo '<div class="err">' . $_SESSION['errores'] . '</div>';
        unset($_SESSION['errores']);
    }
}


/**
*
* Dado la id de un jugador y los dos retorna su puncuaion subjetiva en el partido
*
*
**/
function consultarPuntuaionSubjetivaJugador($partido_id,$idJugador) {
    $conn = connBD();
    $items = array();
    $q = mysql_query("
            SELECT `puntuacion` FROM `puntuacion` WHERE  `jugador_id`=  '" . $idJugador . "'  AND `partido_id`=  '" . $partido_id . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    $punt = "-";
    while ($row = mysql_fetch_array($q)) {
        $punt = $row['puntuacion'];
    }
    mysql_close($conn);
    return $punt;
}


/**
*
* Dado la id de un jugador y los dos retorna su puncuaion objetiva en el partido
*
*
**/
function consultarPuntuaionObjetivaJugador($partido_id,$idJugador) {
    $conn = connBD();
    $items = array();
    $q = mysql_query("
            SELECT `puntuacionFinal` FROM `puntuaciones_alg` WHERE  `id_jugador`=  '" . $idJugador . "'  AND `id_partido`=  '" . $partido_id . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    $punt = "-";
    while ($row = mysql_fetch_array($q)) {
        $punt = $row['puntuacionFinal'];
    }
    mysql_close($conn);
    return $punt;
}


/**
*
* Consulta datos jugador
*
**/
function consultaJugadoresEquipo($equipo_id) {
    $conn = connBD();
    $items = array();
    $q = mysql_query("
            SELECT * FROM `jugador` WHERE  `equipo_id`=  '" . $equipo_id . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $i = 0;
    while ($row = mysql_fetch_array($q)) {
        $items[$i][0] = $row['id_jugador'];
        $items[$i][1] = $row['nombre'];
        $i++;
    }
    mysql_close($conn);
    return $items;
}


/**
*
* Funcion que anade un partido con el estado = 'visible_admin'
*
*
**/
function anadirPartidoAdmnin($jornada,$local,$visitante, $golesLocal, $golesVisitante) {
    $conn = connBD();
    $estado = 'visible_admin';
    $sql = "INSERT INTO partido (jornada_id,equipo1, equipo2, estado, golesEquipo1, golesEquipo2, mostrarPuntuacion)
               VALUES ($jornada,$local,$visitante,'$estado', $golesLocal, $golesVisitante, 'objetiva')";
               
    $q = mysql_query($sql);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    $id_partido = mysql_insert_id();
    mysql_close($conn);
    return $id_partido;
}

/**
*
* Cambia el estado del partido
*
**/
function cambiarEstadoPartido($idPartido, $estado){
    $conn = connBD();
    $sql = "UPDATE partido SET estado='$estado' WHERE id_partido='$idPartido'";
    $q = mysql_query($sql);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    mysql_close($conn);
}

/**
 * @param [int] $id_equipo Recibe el id del equipo
 * @return [string] devuelve el nombre del equipo alg
 */
function consultaNombreEquipoAlg($id_equipo){

    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `nombreAlg` FROM `equipo` WHERE `id_equipo` = '" . $id_equipo . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $nombre = $row['nombreAlg'];
    }
    mysql_close($conn);
    return $nombre;
}


/**
 * @param [int] $id_equipo Recibe el id del equipo
 * @return [string] devuelve el id alg
 */
function consultaIdEquipoAlg($id_equipo){

    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `id_alg` FROM `equipo` WHERE `id_equipo` = '" . $id_equipo . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    while ($row = mysql_fetch_array($q)) {
        $id_alg = $row['id_alg'];
    }
    mysql_close($conn);
    return $id_alg;
}

//Estadisticas algoritmo
function anadirEstadisticasAlgoritmo($id_jugador,$id_jornada,$id_partido,$idEquipo,$MJ,$G,$R,$A,$RG,$CA,$FJ,$IP,$D,$BR,$BP,$FC,$FR,$TA,$TR) {
    $conn = connBD();
    $id_punt_alg = "";
    $select_query = mysql_query("
            SELECT * FROM `puntuaciones_alg` WHERE `id_partido` = '" . $id_partido . "' AND id_jugador='". $id_jugador ."'", $conn);

    $result = mysql_num_rows($select_query);
    if(!$result){

        $sql = "INSERT INTO puntuaciones_alg (id_jugador,id_jornada, id_partido,idEquipo, MJ, G, R, A, RG, CA, FJ, IP, D, BR, BP, FC, FR, TA, TR)
                   VALUES ($id_jugador,$id_jornada,$id_partido,$idEquipo,$MJ,$G,$R,$A,$RG,$CA,$FJ,$IP,$D,$BR,$BP,$FC,$FR,$TA,$TR)";
        $q = mysql_query($sql);
        if (!$q) {
            die("Error al leer datos: " . mysql_error());
        }
        $id_punt_alg = mysql_insert_id();
    }else{
        $sql = "UPDATE puntuaciones_alg 
                SET
               MJ='$MJ', G='$G', R='$R', A='$A', RG='$RG', CA='$CA',FJ='$FJ',IP='$IP',D='$D',BR='$BR',BP='$BP',FC='$FC',FR='$FR',TA='$TA',TR='TR'
               WHERE 
               id_jugador='$id_jugador' AND id_jornada='$id_jornada' AND id_partido='$id_partido' AND idEquipo='$idEquipo'";
    }
    
    mysql_close($conn);
    return $id_punt_alg;
}

/**
 * @param [int] $idPartido identificador del partido
 * @return Devuelve las estadisticas de todos los jugadores de un partido
 */
function consultaEstadisticasAlgoritmo($idPartido, $idEquipo){
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT * FROM `puntuaciones_alg` WHERE `id_partido` = '" . $idPartido . "' AND `idEquipo` = '". $idEquipo ."'", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $jugadores = array();
    while ($row = mysql_fetch_array($q)) {
        $jugadores[$row['id_jugador']][] = $row['MJ'];
        $jugadores[$row['id_jugador']][] = $row['G'];
        $jugadores[$row['id_jugador']][] = $row['R'];
        $jugadores[$row['id_jugador']][] = $row['A'];
        $jugadores[$row['id_jugador']][] = $row['RG'];
        $jugadores[$row['id_jugador']][] = $row['CA'];
        $jugadores[$row['id_jugador']][] = $row['FJ'];
        $jugadores[$row['id_jugador']][] = $row['IP'];
        $jugadores[$row['id_jugador']][] = $row['D'];
        $jugadores[$row['id_jugador']][] = $row['BR'];
        $jugadores[$row['id_jugador']][] = $row['BP'];
        $jugadores[$row['id_jugador']][] = $row['FC'];
        $jugadores[$row['id_jugador']][] = $row['FR'];
        $jugadores[$row['id_jugador']][] = $row['TA'];
        $jugadores[$row['id_jugador']][] = $row['TR'];
    }
    mysql_close($conn);
    return $jugadores;
}

/**
 * Obtiene la posicion de un jugador dada su id
 */
function consultaPosicionJugador($idJugador){
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `posicion` FROM `jugador` WHERE `id_jugador` = '" . $idJugador . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $posicion = "";
    while ($row = mysql_fetch_array($q)) {
        $posicion = $row['posicion'];
    }

    mysql_close($conn);
    return $posicion;
}

/**
 * Obtiene los goles del equipo local
 */
function consultaGolesEquipoLocal($idPartido){
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `golesEquipo1` FROM `partido` WHERE `id_partido` = '" . $idPartido . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $golesEquipo1 = "";
    while ($row = mysql_fetch_array($q)) {
        $golesEquipo1 = $row['golesEquipo1'];
    }
    mysql_close($conn);
    return $golesEquipo1;
}

/**
 * Obtiene los goles del equipo visitante
 */
function consultaGolesEquipoVisitante($idPartido){
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `golesEquipo2` FROM `partido` WHERE `id_partido` = '" . $idPartido . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $golesEquipo2 = "";
    while ($row = mysql_fetch_array($q)) {
        $golesEquipo2 = $row['golesEquipo2'];
    }
    mysql_close($conn);
    return $golesEquipo2;
}


/**
 * Obtiene la id del equipo local del partido
 */
function consultaIdEquipoLocalPartido($idPartido){
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `equipo1` FROM `partido` WHERE `id_partido` = '" . $idPartido . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $equipo1 = "";
    while ($row = mysql_fetch_array($q)) {
        $equipo1 = $row['equipo1'];
    }
    mysql_close($conn);
    return $equipo1;
}

/**
 * Obtiene la id del equipo visitante del partido
 */
function consultaIdEquipoVisitantePartido($idPartido){
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `equipo2` FROM `partido` WHERE `id_partido` = '" . $idPartido . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $equipo2 = "";
    while ($row = mysql_fetch_array($q)) {
        $equipo2 = $row['equipo2'];
    }
    mysql_close($conn);
    return $equipo2;
}

/**
 * Obtiene la id del equipo del jugador
 */
function consultaIdEquipoJugador($idJugador){
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `equipo_id` FROM `jugador` WHERE `id_jugador` = '" . $idJugador . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $equipo_id = "";
    while ($row = mysql_fetch_array($q)) {
        $equipo_id = $row['equipo_id'];
    }
    mysql_close($conn);
    return $equipo_id;
}


/**
*
* Se insertan los puntos
*
*/
function insertarPuntosAlgoritmo($id_jugador, $idPartido, $ptos_jug){
    $conn = connBD();
    $sql = "UPDATE puntuaciones_alg SET puntuacionFinal='$ptos_jug' WHERE id_partido='$idPartido' AND id_jugador = '$id_jugador'";
    $q = mysql_query($sql);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    mysql_close($conn);
}

/**
*
* Actualiza puntuacion a mostrar
*/
function actualizaTipoPuntuacionPartido($idPartido, $tipoPuntuacion = "objetiva"){
    $conn = connBD();
    $sql = "UPDATE partido SET mostrarPuntuacion='$tipoPuntuacion' WHERE id_partido='$idPartido'";
    $q = mysql_query($sql);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    mysql_close($conn);
}

/**
*
* 
*
*
**/
function partidosJornadaAlgoritmo($jornada_id, $visibilidad) {
    $conn = connBD();
    $valor=1;
    $items = array();
    $q = mysql_query("
            SELECT * FROM `partido` WHERE `jornada_id` = '" . $jornada_id . "' 
            AND `estado` = '".$visibilidad."' ORDER BY `id_partido` ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    $items = array();
    while ($row = mysql_fetch_array($q)) {
        $items[$row['id_partido']][] = $row['id_partido'];
        $items[$row['id_partido']][] = $row['mostrarPuntuacion'];
    }
    mysql_close($conn);
    return $items;
}


/**
*
* Obtiene las puntuaciones del algoritmo
*
**/
function puntuacionesPartidoAlgoritmo($equipo_id,$partido_id) {
    $conn = connBD();
    $items = array();
    $q = mysql_query("SELECT jug.nombre, pto.puntuacionFinal 
                    FROM `puntuaciones_alg` AS `pto` 
                    JOIN `jugador` AS `jug` 
                    WHERE (pto.id_jugador = jug.id_jugador) 
                        AND (`idEquipo` = '$equipo_id') 
                        AND (`id_partido`= '$partido_id')
                        AND (pto.puntuacionFinal <> 100)
                        ORDER BY FIELD(jug.posicion,'POR','DEF','MED','DEL')"
                    );
    //$q = mysql_query("SELECT (SELECT jug.nombre FROM `jugador` AS `jug` WHERE pto.id_jugador = jug.id_jugador) AS `nombre`, pto.puntuacionFinal FROM `puntuaciones_alg` AS `pto` WHERE `idEquipo` = '$equipo_id' AND `id_partido`= '$partido_id'"); 
    
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $i=0;
    while ($row = mysql_fetch_array($q)) {
        $items[$i][] = $row['nombre'];
        $items[$i][] = $row['puntuacionFinal'];
    $i++;
    }
    mysql_close($conn);

    return $items;
}

function consultaOpcionMostrarPartido($idPartido){
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `mostrarPuntuacion` FROM `partido` WHERE `id_partido` = '" . $idPartido . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $mostrarPuntuacion = "";
    while ($row = mysql_fetch_array($q)) {
        $mostrarPuntuacion = $row['mostrarPuntuacion'];
    }
    mysql_close($conn);
    return $mostrarPuntuacion;
}

/**
*
* Obtiene las puntuaciones subjetivas
*
**/
function puntuacionesPartidoSubjetivas($equipo_id,$partido_id) {
    $conn = connBD();
    $items = array();
    $q = mysql_query("SELECT (SELECT jug.nombre FROM `jugador` AS `jug` WHERE pto.jugador_id = jug.id_jugador) AS `nombre`, pto.puntuacion FROM `puntuacion` AS `pto` WHERE `equipo_id` = '$equipo_id' AND `partido_id`= '$partido_id'"); 
    
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $i=0;
    while ($row = mysql_fetch_array($q)) {
        $items[$i][] = $row['nombre'];
        $items[$i][] = $row['puntuacion'];
    $i++;
    }
    mysql_close($conn);
    return $items;
}


function partidosJornadaEquipos($idJornada){
   $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `id_partido`, `equipo1`, `equipo2` FROM `partido` WHERE `jornada_id` = '" . $idJornada . "' ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $partidos = array();
    $i = 0;
    while ($row = mysql_fetch_array($q)) {
        $partidos[$i][] = $row['id_partido'];
        $partidos[$i][] = nombreEquipo($row['equipo1']);
        $partidos[$i][] = nombreEquipo($row['equipo2']);

        $i++;
    }
    mysql_close($conn);
    return $partidos; 
}

function consultaTodasJornadas(){
    $conn = connBD();
    $valor=1;
    $q = mysql_query("
            SELECT `id_jornada`, `numero` FROM `jornada` ORDER BY `numero` ", $conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $jornadas = array();
    $i = 0;
    while ($row = mysql_fetch_array($q)) {
        $jornadas[$i][] = $row['id_jornada'];
        $jornadas[$i][] = $row['numero'];

        $i++;
    }
    mysql_close($conn);
    return $jornadas; 
}


/**
*
*
* Inserta los goles del equipo local
*
**/
function insertarGolesEquipoLocal($idPartido, $goles){
    $conn = connBD();
    $sql = "UPDATE partido SET golesEquipo1='$goles' WHERE id_partido='$idPartido'";
    $q = mysql_query($sql);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    mysql_close($conn);
}
/**
*
*
* Inserta los goles del equipo visitante
*
**/
function insertarGolesEquipoVisitante($idPartido, $goles){
    $conn = connBD();
    $sql = "UPDATE partido SET golesEquipo2='$goles' WHERE id_partido='$idPartido'";
    $q = mysql_query($sql);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    mysql_close($conn);
}

/**
*
* Actualiza puntuacion de un jugador
*
**/
function actualizaPuntuacionFinalJugador($idJugador, $ptos, $idPartido){
    $conn = connBD();
    $sql = "UPDATE puntuaciones_alg SET puntuacionFinal='$ptos' WHERE id_partido='$idPartido' AND id_jugador='$idJugador'";
    
    $q = mysql_query($sql);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }
    mysql_close($conn);
}


function consultaUsuariosAdministracion($user, $pass){
    $conn = connBD();
    $sql = "SELECT `usuario` FROM `administracion` WHERE `usuario`='$user' AND `password`='$pass'";

    $q = mysql_query($sql,$conn);
    if (!$q) {
        die("Error al leer datos: " . mysql_error());
    }

    $result = mysql_num_rows($q);
    mysql_close($conn);
    if($result>0){
        return true;
    }
    else{
        return false;
    }
    
}
?>