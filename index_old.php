<?php

require 'funciones.php';
include_once("analyticstracking.php");

$x = consultaJornadaActiva();
if (!$x){
	print 'No hay jornada';
}
else{
	$partidos= partidosJornada($x);
	$njornada = consultaJornada($x);
	if(!$partidos){
		print 'No hay partidos';
	}
	else{
	}
}
?>

<!DOCTYPE HTML>
<!--
	Read Only by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
	    <!-- TradeDoubler site verification 2474268 -->
		<title>Comunio Oráculo </title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.scrollzer.min.js"></script>
		<script src="js/jquery.scrolly.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body>
	<?php include_once("analyticstracking.php") ?>
		<div id="wrapper">

			<!-- Header -->
				<section id="header" class="skel-layers-fixed">
					<header>
						<span class="image avatar"><img src="images/avatar.jpg" alt="" /></span>
						<h1 id="logo"><a href="#">Comunio Oráculo</a></h1>
						<p>Pagina Web Oficial<br />
						@comunio_oraculo</p>
					</header>
					<nav id="nav">
						<ul>
							<li><a href="#one" class="active">Puntos</a></li>
							<li><a href="#two">Twitter</a></li>
						</ul>
					</nav>
					<footer>
						
					</footer>
				</section>

			<!-- Main -->
				<div id="main">

					<!-- One -->
						<section id="one">
						<?php
  
                            $tablet_browser = 0;
                            $mobile_browser = 0;
                            $body_class = 'desktop';
                             
                            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
                                $tablet_browser++;
                                $body_class = "tablet";
                            }
                             
                            if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
                                $mobile_browser++;
                                $body_class = "mobile";
                            }
                             
                            if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
                                $mobile_browser++;
                                $body_class = "mobile";
                            }
                             
                            $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
                            $mobile_agents = array(
                                'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
                                'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
                                'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
                                'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
                                'newt','noki','palm','pana','pant','phil','play','port','prox',
                                'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
                                'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
                                'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
                                'wapr','webc','winw','winw','xda ','xda-');
                             
                            if (in_array($mobile_ua,$mobile_agents)) {
                                $mobile_browser++;
                            }
                             
                            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
                                $mobile_browser++;
                                //Check for tablets on opera mini alternative headers
                                $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
                                if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                                  $tablet_browser++;
                                }
                            }
                            if ($tablet_browser > 0) {
								?>
									<script>
										//TABLET
										var medida = 0;
										//document.write(screen.height);
										//document.write(screen.width);
										if(screen.width == "320" && screen.height == "480"){
											//4 Pulgadas
											medida = screen.height - 433;
										}	
										if(screen.width == "360" && screen.height == "640"){
											//4,7 Pulgadas
											medida = screen.height - 573;
										}	
										var uri = 'http://impes.tradedoubler.com/imp?type(img)g(22293598)a(2474268)' + new String (Math.random()).substring (2, 11);
										document.write('<a href="http://clk.tradedoubler.com/click?p=9591&a=2474268&g=22293598" target="_BLANK"><img height="'+medida+'" src="'+uri+'" border=0></a>');
									</script>
								<?php                        }
                            else if ($mobile_browser > 0) {
								?>
									<script>
										//MOVIL
										var medida = 0;
										//document.write(screen.height);
										//document.write(screen.width);
										if(screen.width == "320" && screen.height == "480"){
											//3,5 Pulgadas
											medida = screen.height - 433;
										}
										if(screen.width == "320" && screen.height == "534"){
											//4 Pulgadas
											medida = screen.height - 488;
										}
										if(screen.width == "360" && screen.height == "640"){
											//4,7 Pulgadas
											medida = screen.height - 573;
										}	
										var uri = 'http://impes.tradedoubler.com/imp?type(img)g(22293598)a(2474268)' + new String (Math.random()).substring (2, 11);
										document.write('<a href="http://clk.tradedoubler.com/click?p=9591&a=2474268&g=22293598" target="_BLANK"><img height="'+medida+'" src="'+uri+'" border=0></a>');
									</script>
								<?php
							}
                            else {
                                ?>
									<script>
										//COMPUTER
										var medida = screen.height - 627;
										//document.write(screen.height);
										var uri = 'http://impes.tradedoubler.com/imp?type(img)g(22293598)a(2474268)' + new String (Math.random()).substring (2, 11);
										document.write('<a href="http://clk.tradedoubler.com/click?p=9591&a=2474268&g=22293598" target="_BLANK"><img height="'+medida+'" src="'+uri+'" border=0></a>');
									</script>
								<?php
                            } 
                        ?>
						<div class="container">
								<header class="major">
									<a href="http://clk.tradedoubler.com/click?p=9591&a=2474268&g=22293598" target="_BLANK"><h2>Jornada <?=$njornada ?></h2></a>
									
								</header>
								<?php
						   		foreach (array_reverse($partidos) as $p){
								$local = local($p);
								$visitante =visitante($p);
								$nlocal = nombreEquipo($local);
								$nvisitante = nombreEquipo($visitante);
								$plocal = puntuacionesPartido($local,$p);
							$pvisitante = puntuacionesPartido($visitante,$p);
								$jlocal = jugadoresPartido($p,$local);
								$jvisitante = jugadoresPartido($p,$visitante);
						     ?>
							<table border="1">
								<tr>
									<td colspan="2"><img src="equipos/<?=$nlocal ?>.png" width="50px;"/><h3><?=$nlocal ?></h3></td>
									<td colspan="2"><img src="equipos/<?=$nvisitante ?>.png" width="50px;"/><h3><?=$nvisitante ?></h3></td>
								</tr>
								
								<?php
									for($i=1;$i<=14;$i++){ 
									?><tr><?php
										if(!isset($jlocal[$i])&&isset($jvisitante[$i])){
?>
<td></td><td></td>
<?php
}
elseif(!isset($jlocal[$i])&&!isset($jvisitante[$i])){
										}
										else{ 
										$jloc= $jlocal[$i];
										$njl = consultaJugadorId($jloc);
										?>  
											<td><?php
												print $njl?></td>
																	<td><?php
												print $plocal[$i] ?></td>
					<?php
					}
										if (!isset($jvisitante[$i])){
										}
										else{ 
										$jvis = $jvisitante[$i];
									$njv = consultaJugadorId($jvis);
					?>
											<td><?php
												print $njv ?></td>
					<td><?php
												print $pvisitante[$i] ?></td>
					<?php
					}?>
					</tr>
								<?php	
			

					}

					?>
							</table>
							<?php } ?>
							</div>
						</section>
						
						
					<!-- Two -->
						<section id="two">
							<div class="container">
								<h3>Síguenos en Twitter</h3>
								<a class="twitter-timeline" href="https://twitter.com/comunio_oraculo" data-widget-id="552842687569985538">Tweets por el @comunio_oraculo.</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
							</div>
						</section>
				
				</div>

			<!-- Footer -->
				<section id="footer">
					<div class="container">
						<ul class="copyright">
							<li>&copy; 2015 Oráculo Comunio.</li><li><a href="http://www.twitter.com/comunio_oraculo">Twitter Oficial</a></li>
						</ul>
					</div>
				</section>
			
		</div>
	</body>

</html>