<?php
error_reporting(E_ALL ^ E_NOTICE);
define('INCLUDE_CHECK', true);

require 'funciones.php';

session_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6 ielt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7 ielt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> 
<html lang="en"> <!--<![endif]--> 
    <head>
        <?php include("head.php"); ?>
    </head>
    <body>
        <!-- Main -->
                <div id="main">

                    <!-- One -->
                        <section id="one">

                        <div class="container">
        <div class="container">
            <section id="content">
                <h1>Comunio Or&aacute;culo</h1>
                <form action="recogeLogin.php" method="post">
                    
                    <div>
                        <input type="text" placeholder="Username" required="required" id="username" name="loginUser"/>
                    </div>
                    <div>
                        <input type="password" placeholder="Password" required="required" id="password" name="loginPass"/>
                    </div>
                    <div>
                        <input type="submit" name="login-submit" value="Login" />                              
                    </div>
                    <?php mostrarError(); ?>

                </form><!-- form -->
            </section><!-- content -->
        </div><!-- container -->
            </section><!-- content -->
        </div><!-- container -->
    </body>
</html>
