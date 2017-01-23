<?php

    if (is_file('funciones.php'))
    {
        require_once('funciones.php');
    }
    /*
    $result = file_get_contents($url);
    */

    function gestionaPuntuacionesAlg($idEquipoLocal, $idEquipoVisitante, $idJornada, $idPartido, $estadoPartido = "final"){

        //Estos datos vienen por get o post
        $estadoPartido = "final"; //directo o final para mostrar los datos o guardarlos
        $temporada = "2014-2015";

        /*$equipo_local = "getafe";
        $id_alg_local = "00218";
        
        $equipo_visitante = "real-madrid";
        $id_alg_visitante = "00013";*/

        $equipo_local = consultaNombreEquipoAlg($idEquipoLocal);
        $id_alg_local = consultaIdEquipoAlg($idEquipoLocal);
        
        $equipo_visitante = consultaNombreEquipoAlg($idEquipoVisitante);
        $id_alg_visitante = consultaIdEquipoAlg($idEquipoVisitante);

        $id_liga = "01171";
        $jornada = consultaJornada($idJornada);

        if(strlen($jornada) == 1){
            $jornada = "0".$jornada;
        }

        //if(intval($jornada) <= 19){
            $partido_ida = "00";            
        /*}else{
            $partido_vuelta = "01";
        }*/

        $url = 'http://www.superdeporte.es/deportes/futbol/primera-division/'.$temporada.'/'.$equipo_local.'-'.$equipo_visitante.'-'.$id_liga.'_'.$partido_ida.'_'.$jornada.'_'.$id_alg_local.'_'.$id_alg_visitante.'.html';
        //$url_old = 'http://www.superdeporte.es/deportes/futbol/primera-division/2014-2015/getafe-real-madrid-01171_00_19_00218_00013.html';
        //$url = 'http://www.superdeporte.es/deportes/futbol/primera-division/2014-2015/malaga-valencia-01171_00_21_00133_00020.html';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        /* 
         * XXX: This is not a "fix" for your problem, this is a work-around.  You 
         * should fix your local CAs 
         */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        /* Set a browser UA so that we aren't told to update */
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36');

        $res = curl_exec($ch);

        if ($res === false) {
            die('error: ' . curl_error($ch));
        }

        curl_close($ch);

        $d = new DOMDocument();
        @$d->loadHTML($res);
           
        actualizaResultado($d, $idPartido);

        //Se obtiene y guardan las estadisticas
        calcula_inserta_estatisticas($d,'capa_jg1',$idEquipoLocal, $idEquipoVisitante, $idEquipoLocal, $idJornada);
        //Una vez se obtienen las estadtisticas se calculan los puntos
        calcula_inserta_puntos($idPartido, $idEquipoLocal);

        calcula_inserta_estatisticas($d,'capa_jg2',$idEquipoLocal, $idEquipoVisitante, $idEquipoVisitante, $idJornada);
        //Una vez se obtienen las estadtisticas se calculan los puntos
        calcula_inserta_puntos($idPartido, $idEquipoVisitante);


}
    

function actualizaResultado($d, $idPartido){
    $div = $d->getElementById("tablaresultados")->nodeValue;
    //Separamos jugadores y puntos
    $div = trim($div);
    $datos = explode("\n", $div);
    $resultado = $datos[4];
    $resultadoFinal = explode("-", $resultado);

    $golLocal = intval($resultadoFinal[0]);
    $golVisitante = intval($resultadoFinal[1]);

    insertarGolesEquipoLocal($idPartido, $golLocal);
    insertarGolesEquipoVisitante($idPartido, $golVisitante);
}

function calcula_inserta_estatisticas($d, $capa, $idEquipoLocal, $idEquipoVisitante, $idEquipoAlg, $id_jornada){
    //Obtenemos la tabla del div con el id capa_jg1 y capa_jg2
    $div = $d->getElementById($capa)->nodeValue;    

    //Separamos el string para quedarnos solo con la parte del tbody (los jugadores y los datos)
    $datos_todo = explode("TR", $div);
    
    //Quitamos espacios en blanco del string
    $datos_todo[1] = trim($datos_todo[1]);

    //Separamos jugadores y puntos
    $datos_jugadores = explode("\n", $datos_todo[1]);

    //Recorremos el array para tener los datos de cada jugador por separado
    $jugadores = array();
    $jugador = "";
    for($i = 0; $i < count($datos_jugadores); $i++) {
         $elemento = $datos_jugadores[$i];

         //Si no es numerico significa que es un jugador, por tanto se crea una posicion en el array con key = nombre
         if(is_numeric($elemento) == false){
            $jugador = $elemento;
         }else{
            $jugadores[$jugador][] = $elemento;
         }
    } 

    //$idEquipoLocal = consultaIdEquipo($equipo_local);
    //$idEquipoVisitante = consultaIdEquipo($equipo_visitante);
    //$id_jornada = consultaIdJornada($jornada);
    $id_partido = consultaIdPartido($id_jornada, $idEquipoLocal, $idEquipoVisitante);

    if(empty($id_partido)){
        $equipo_local = consultaNombreEquipoAlg($idEquipoLocal);
        $equipo_visitante = consultaNombreEquipoAlg($idEquipoVisitante);
        $jornada = consultaJornada($id_jornada);
        error_log("No se ha podido encontrar la id del partido: " .$equipo_local."(".$idEquipoLocal.") VS ".$equipo_visitante."(".$idEquipoVisitante.") -> J".$jornada ."(".$id_jornada.")");
    }
    else{
        //Guardamos los datos en la BD
        foreach ($jugadores as $jugador => $datos) {
            $id_jugador = consultaIdJugadorFromNombre(consultaNombreJugadorAlg(limpiar_caracteres_especiales($jugador)));
            $MJ = $datos[0];
            $G = $datos[1];
            $R = $datos[2];
            $A = $datos[3];
            $RG = $datos[4];
            $CA = $datos[5];
            $FJ = $datos[6];
            $IP = $datos[7];
            $D = $datos[8];
            $BR = $datos[9];
            $BP = $datos[10];
            $FC = $datos[11];
            $FR = $datos[12];
            $TA = $datos[12];
            $TR = $datos[14];

            if(empty($id_jugador)){
                error_log("No se ha podido encontrar al jugador: " .$jugador);
            }else{
                anadirEstadisticasAlgoritmo($id_jugador,$id_jornada,$id_partido,$idEquipoAlg,$MJ,$G,$R,$A,$RG,$CA,$FJ,$IP,$D,$BR,$BP,$FC,$FR,$TA,$TR);
            }       
        }
    }
}


function calcula_inserta_puntos($idPartido, $idEquipo){
    $jugadores = consultaEstadisticasAlgoritmo($idPartido, $idEquipo);

    foreach ($jugadores as $id_jugador => $estadisticas) {
        $MJ = $estadisticas[0];
        $G = $estadisticas[1];
        $R = $estadisticas[2];
        $A = $estadisticas[3];
        $RG = $estadisticas[4];
        $CA = $estadisticas[5];
        $FJ = $estadisticas[6];
        $IP = $estadisticas[7];
        $D = $estadisticas[8];
        $BR = $estadisticas[9];
        $BP = $estadisticas[10];
        $FC = $estadisticas[11];
        $FR = $estadisticas[12];
        $TA = $estadisticas[12];
        $TR = $estadisticas[14];

        //Se calculan los puntos
        $ptos_jug = algoritmo_calcular_ptos($idPartido, $id_jugador,$MJ,$G,$R,$A,$RG,$CA,$FJ,$IP,$D,$BR,$BP,$FC,$FR,$TA,$TR);

        //Se insertan los puntos
        insertarPuntosAlgoritmo($id_jugador, $idPartido, $ptos_jug);
    }
}


/**
 * $idPartido
 * $id_jugador
 * $MJ => minutos jugados
 * $G => goles
 * $R => remates
 * $A => asistencias
 * $RG => regates
 * $CA => centros al area
 * $FJ => fueras de juego
 * $IP => intervenciones del portero
 * $D => despejes
 * $BR => balones recuperados
 * $BP => balones perdidos
 * $FC => faltas cometidas
 * $FR => faltas recibidas
 * $TA => tarjeta amarilla
 * $TR => tarjeta roja
 */
function algoritmo_calcular_ptos($idPartido, $id_jugador,$MJ,$G,$R,$A,$RG,$CA,$FJ,$IP,$D,$BR,$BP,$FC,$FR,$TA,$TR){

    $MJ = intval($MJ);
    $G = intval($G);
    $R = intval($R);
    $A = intval($A);
    $RG = intval($RG);
    $CA = intval($CA);
    $FJ = intval($FJ);
    $IP = intval($IP);
    $D = intval($D);
    $BR = intval($BR);
    $BP = intval($BP);
    $FC = intval($FC);
    $FR = intval($FR);
    $TA = intval($TA);
    $TR = intval($TR);

    $posicionJugador = consultaPosicionJugador($id_jugador);
    $golesLocal = consultaGolesEquipoLocal($idPartido);
    $golesVisitante = consultaGolesEquipoVisitante($idPartido); 

    $idEquipoLocal = consultaIdEquipoLocalPartido($idPartido);   
    $idEquipoVisitante = consultaIdEquipoVisitantePartido($idPartido); 

    $idEquipoJugador = consultaIdEquipoJugador($id_jugador);  

    $ptosBaremo = 0;
    $ptosFinales = 0;

    //Si ha jugado
    if($MJ > 0){

        

        //-------------------- PORTEROS --------------------
        if($posicionJugador == "POR"){
            $ptosBaremo += $IP;
            $ptosBaremo += ($BR*0.5);
            $ptosBaremo += ($D*0.5);
            $ptosBaremo += ($RG*0.5);

            //Es local
            if($idEquipoJugador == $idEquipoLocal){
                //Si no le han marcado ningun gol
                if($golesVisitante == 0){
                    $ptosBaremo += 3;
                }else{
                    $ptosBaremo += ($golesVisitante*(-1));
                }

                //Si pierde en casa
                if($golesVisitante > $golesLocal){
                    $ptosBaremo += -1;
                }
            }
            //Es visitante
            else{
                //Si no le han marcado ningun gol
                if($golesLocal == 0){
                    $ptosBaremo += 3;
                }else{
                    $ptosBaremo += ($golesLocal*(-1));
                }

                //Si ganas fuera
                if($golesVisitante > $golesLocal){
                    $ptosBaremo += 1;
                }
            }

            //Goles
            $ptosBaremo += ($G * 3);
            
        }
        // -------------------- DEFENSAS --------------------
        elseif ($posicionJugador == "DEF") {
            $ptosBaremo += ($G * 4);
            $ptosBaremo += ($R * 3);
            $ptosBaremo += ($A * 3);
            $ptosBaremo += ($CA * 2);
            $ptosBaremo += ($RG * 2);
            $ptosBaremo += ($D);
            $ptosBaremo += ($BR * 2.5);
            $ptosBaremo += ($BP * (-1));
            $ptosBaremo += ($FC * (-0.5));
            $ptosBaremo += ($FR);
            $ptosBaremo += ($TA * (-2));


            //Es local
            if($idEquipoJugador == $idEquipoLocal){
                //Si no le han marcado ningun gol
                if($golesVisitante == 0){
                    $ptosBaremo += 2;
                }else{
                    $ptosBaremo += ($golesVisitante*(-1));
                }

                //Si pierde en casa
                if($golesVisitante > $golesLocal){
                    $ptosBaremo += -1;
                }
            }
            //Es visitante
            else{
                //Si no le han marcado ningun gol
                if($golesLocal == 0){
                    $ptosBaremo += 3;
                }else{
                    $ptosBaremo += ($golesLocal*(-1));
                }

                //Si ganas fuera
                if($golesVisitante > $golesLocal){
                    $ptosBaremo += 1;
                }
            }
        }
        //-------------------- MEDIOS --------------------
        elseif ($posicionJugador == "MED") {
            $ptosBaremo += ($G * 4);
            $ptosBaremo += ($R * 3);
            $ptosBaremo += ($A * 3);
            $ptosBaremo += ($CA * 1);
            $ptosBaremo += ($RG * 2);
            $ptosBaremo += ($BR * 2);
            $ptosBaremo += ($BP * (-1));
            $ptosBaremo += ($FR);
            $ptosBaremo += ($TA * (-2));

            //Es local
            if($idEquipoJugador == $idEquipoLocal){
                //Si pierde en casa
                if($golesVisitante > $golesLocal){
                    $ptosBaremo += -1;
                }
            }
            //Es visitante
            else{
                //Si ganas fuera
                if($golesVisitante > $golesLocal){
                    $ptosBaremo += 1;
                }
            }
        }
        //-------------------- DELANTEROS --------------------
        elseif ($posicionJugador == "DEL") {
            $ptosBaremo += ($G * 5);
            $ptosBaremo += ($R * 4);
            $ptosBaremo += ($A * 3);
            $ptosBaremo += ($CA * 2);
            $ptosBaremo += ($RG * 2);
            $ptosBaremo += ($BR * 1);
            $ptosBaremo += ($BP * (-1));
            $ptosBaremo += ($FR);

            //Es local
            if($idEquipoJugador == $idEquipoLocal){
                //Si pierde en casa
                if($golesVisitante > $golesLocal){
                    $ptosBaremo += -1;
                }
            }
            //Es visitante
            else{
                //Si ganas fuera
                if($golesVisitante > $golesLocal){
                    $ptosBaremo += 1;
                }
            }
        }

        // -*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-

        //REGLAS GENERALES
        if((intval($MJ) >= 45) && ((intval($MJ) <= 89))){
            $ptosBaremo += 3;
        }elseif((intval($MJ) >= 10) && (intval($MJ) < 45)) {
            if($ptosBaremo != 0){
                $ptosBaremo = ((90 * $MJ) / $ptosBaremo);
            }
        }else{
            $ptosBaremo += 0;
        }

        //Doble amarilla
        if($TA == 2){
            $ptosBaremo += -3;
        }

        //Tarjeta roja
        $ptosBaremo += ($TR * (-6));

        
        // **********************************************
        //----------- Puntos finales --------------------
        // **********************************************
        //Portero
        if($posicionJugador == "POR"){
            if($ptosBaremo < 3){
                $ptosFinales = 0;
            }elseif (($ptosBaremo >= 3) && ($ptosBaremo <= 12)) {
                $ptosFinales = 2;
            }elseif (($ptosBaremo > 12) && ($ptosBaremo <= 22)) {
                $ptosFinales = 6;
            }elseif ($ptosBaremo > 22) {
                $ptosFinales = 10;
            }
        }
        //Defensas
        elseif ($posicionJugador == "DEF") {
            if($ptosBaremo < 10){
                $ptosFinales = -2;
            }elseif (($ptosBaremo >= 10) && ($ptosBaremo <= 20)) {
                $ptosFinales = 2;
            }elseif (($ptosBaremo > 20) && ($ptosBaremo <= 30)) {
                $ptosFinales = 6;
            }elseif ($ptosBaremo > 30) {
                $ptosFinales = 10;
            }
        }
        //Medios
        elseif ($posicionJugador == "MED") {
            if($ptosBaremo < 10){
                $ptosFinales = -2;
            }elseif (($ptosBaremo >= 10) && ($ptosBaremo <= 20)) {
                $ptosFinales = 2;
            }elseif (($ptosBaremo > 20) && ($ptosBaremo <= 30)) {
                $ptosFinales = 6;
            }elseif ($ptosBaremo > 30) {
                $ptosFinales = 10;
            }
        }
        //Delanteros
        elseif ($posicionJugador == "DEL") {
            if($ptosBaremo < 10){
                $ptosFinales = -2;
            }elseif (($ptosBaremo >= 10) && ($ptosBaremo <= 20)) {
                $ptosFinales = 2;
            }elseif (($ptosBaremo > 20) && ($ptosBaremo <= 30)) {
                $ptosFinales = 6;
            }elseif ($ptosBaremo > 30) {
                $ptosFinales = 10;
            }
        }

    }
    else{
        //Para saber que no ha jugado
        $ptosFinales = 100;
    }
    return $ptosFinales;

}

?>