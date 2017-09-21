<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo isset($texts["title"]) ? $texts["title"] . "::" : ""; ?> SIPIMSS</title>
        <?php echo css('bootstrap.css'); ?>
        <?php echo css('style_login.css'); ?>
        <?php echo js('captcha.js'); ?>
        <script type="text/javascript">
            var url = "<?php echo base_url(); ?>";
            var site_url = "<?php echo site_url(); ?>";
            var img_url_loader = "<?php echo base_url('assets/img/loader.gif'); ?>";
        </script>
        <?php echo js("jquery.js"); ?>
        <?php echo js("jquery.min.js"); ?>
        <?php echo js("jquery.ui.min.js"); ?>
        <?php echo js('template_sipimss/general.js'); ?>
        <?php echo js("login.js"); ?>
        <?php echo js("bootstrap.js"); ?>
    </head>
    <style type="text/css">
    /*==============================================
    FOOTER  STYLES
    =============================================*/
    footer {
        background-color:rgb(54, 158, 129);
        padding:15px 50px;
        color:#fff;
        font-size:12px;
    }

    footer a {
        color:#fff;
    }
    footer a:hover, footer a:focus {
        color:#fff;
        text-decoration:none;
    }
    .wrapper{
        top:40%;
        height: 600px;
    }
    .menu{
        background-color: #d1d5d6;
        height: 52px;
    }
    .nav{
        padding-bottom: 1px;
    }
    .navbar{
        margin-bottom: 0px;
        z-index: 1;
    }
    .navbar-default{
        background-color: #d1d5d6;
    }
    .carousel_background{
        background-color: #3d3d3d;
    }
    .navbar-header{
        background-color: #d1d5d6;
    }
    .navbar-default .navbar-toggle{
        border-color: #3d3d3d;
    }
    .lema{
        background-color: #006a62;
        color: #FFF;
        padding: 20px;
        /*margin: 10px;*/
    }
    </style>
    <body>
        <div class="col-md-14">
            <!-- /. NAV TOP  -->
            <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">

                <!-- LLAMAR NAVTOP.PHP -->
                <div class="navbar-header">

                </div>
                <div class="notifications-wrapper">
                    <ul class="nav">

                        <li class="nav pull-right">
                            <ul class="">
                                <!-- <li>
                                    <button type="button" name="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#login-modal">
                                        Inicio de sesión
                                    </button>
                                </li> -->
                                <li>
                                  <!-- <a href="#"><img img-responsive class"logos" height="70px" src="assets/img/template_sipimss/sipimss.png" alt=""></a> -->
                                    <a href="#">
                                        <img img-responsive src="<?php echo asset_url(); ?>img/template_sipimss/sipimss.png"
                                             height="70px"
                                             class="logos"
                                             alt="SIPIMSS"
                                             title="SIPIMSS"
                                             target="_blank"/>
                                    </a>
                                </li>
                                <li>
                                  <!-- <a href="#"><img img-responsive class"logos" height="70px" src="assets/img/template_sipimss/ces.png" alt=""></a> -->
                                    <a href="http://educacionensalud.imss.gob.mx">
                                        <img img-responsive src="<?php echo asset_url(); ?>img/template_sipimss/ces.png"
                                             height="70px"
                                             class="logos"
                                             alt="CES"
                                             title="CES"
                                             target="_blank"/>
                                    </a>
                                </li>
                                <li>
                                  <!-- <a href="#"><img img-responsive class"logos" height="70px" src="assets/img/template_sipimss/imss.png" alt=""></a> -->
                                    <a href="http://www.imss.gob.mx/">
                                        <img img-responsive src="<?php echo asset_url(); ?>img/template_sipimss/imss.png"
                                             height="70px"
                                             class="logos"
                                             alt="IMSS"
                                             title="IMSS"
                                             target="_blank"/>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>


            </nav>
            <!-- <div class="col-md-7">
  
            </div>
            <div class="col-md-2">
              <button type="button" name="button" class="btn btn-success" data-toggle="modal" data-target="#login-modal">
                Login
              </button> -->

        </div>

    </div>
    <div class="col-md-14 menu">
        <div class="col-md-2"></div>
        <!-- <img class="img-responsive" src="<?php echo asset_url(); ?>img/ditto/menu.png">-->
        <div class="col-md-8">
            <!-- <img src="<?php echo asset_url(); ?>img/ditto/inicio.png"> -->
            <nav class="navbar navbar-default">
              <div class="container-fluid">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span> 
                  </button>
                  <!-- <a class="navbar-brand" href="#"></a> -->
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                      <li class=""><a href="<?php echo site_url(); ?>">INICIO</a></li>
                      <li><a href="#" data-toggle="modal" data-target="#login-modal">INICIO DE SESIÓN</a></li>
                      <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">AYUDA
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#">CONTACTO</a></li>
                          <li><a href="#">GUÍA RÁPIDA</a></li>
                          <li><a href="#" data-toggle="modal" data-target="#mesa-ayuda-modal">MESA DE AYUDA</a></li>
                          <!-- <li><a href="#">Page 1-3</a></li> -->
                        </ul>
                      </li>
                      <!-- <li><a href="#">Page 2</a></li>
                      <li><a href="#">Page 3</a></li> -->
                    </ul>
                </div>
              </div>
            </nav>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="clearfix"></div>
    <div class="carousel_background">
        <div class="col-md-14 text-center container-fluid">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <!-- <img class="img-responsive" src="<?php echo asset_url(); ?>img/ditto/carrusel.png"> -->
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                    <div class="item active">
                      <img src="<?php echo asset_url(); ?>img/ditto/SIPIMSS_carrusel01.jpg" alt="Eleva tu reconocimiento profesional actualizando tu información personal, profesional, tus actividades docentes y de investigación en el IMSS">
                      <div class="carousel-caption">
                        <h3>Eleva tu reconocimiento profesional actualizando</h3>
                        <p>tu información personal, profesional, tus actividades docentes y de investigación en el IMSS</p>
                      </div>
                    </div>

                    <div class="item">
                      <img src="<?php echo asset_url(); ?>img/ditto/SIPIMSS_carrusel02.jpg" alt="Eleva tu reconocimiento profesional actualizando tu información personal, profesional, tus actividades docentes y de investigación en el IMSS">
                      <div class="carousel-caption">
                        <h3>Eleva tu reconocimiento profesional actualizando</h3>
                        <p>tu información personal, profesional, tus actividades docentes y de investigación en el IMSS</p>
                      </div>
                    </div>

                    <div class="item">
                      <img src="<?php echo asset_url(); ?>img/ditto/SIPIMSS_carrusel03.jpg" alt="Eleva tu reconocimiento profesional actualizando tu información personal, profesional, tus actividades docentes y de investigación en el IMSS">
                      <div class="carousel-caption">
                        <h3>Eleva tu reconocimiento profesional actualizando</h3>
                        <p>tu información personal, profesional, tus actividades docentes y de investigación en el IMSS</p>
                      </div>
                    </div>
                  </div>

                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Anterior</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Siguiente</span>
                  </a>
                </div>

            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-14 text-center">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <h4 class="lema">El SIPIMSS contribuye a la misión de avanzar en la docencia y la investigación 
            al posibilitar la identificación de oportunidades y la optimización de los recursos humanos.</h4>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-14 text-justify">
        <div class="col-md-2"></div>
        <div class="col-md-4"><h4>¿QUÉ ES?</h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent quis ante sed tortor condimentum consectetur. </div>
        <div class="col-md-4"><img class="img-responsive" src="<?php echo asset_url(); ?>img/ditto/SIPIMSS_carrusel03.jpg" alt="Eleva tu reconocimiento profesional actualizando tu información personal, profesional, tus actividades docentes y de investigación en el IMSS"></div>
        <!-- <div class="col-md-2"><h4>TUTORIALES</h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent quis ante sed tortor condimentum consectetur. </div>
        <div class="col-md-2"><img class="img-responsive" src="<?php echo asset_url(); ?>img/ditto/SIPIMSS_carrusel03.jpg" alt="Eleva tu reconocimiento profesional actualizando tu información personal, profesional, tus actividades docentes y de investigación en el IMSS"></div> -->
        <div class="col-md-2"></div>
    </div>
    <div class="clearfix"></div><br><br><br><br>
    
    <?php
    if (isset($my_modal)) { ?>
        <?php echo $my_modal; ?>
    <?php } ?>

    <div class="modal fade" id="mesa-ayuda-modal" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-lock"></span>Mesa de ayuda</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <div class="login-page">
                      <p>¿Tienes alguna duda? Comunícate con nosotros:</p>
                      <p><strong>Teléfono:</strong> 56 27 69 00 Ext. 21146, 21147 y 21148<br><strong>RED:</strong> 865021146, 865021147, 865021148<br><strong>Email:</strong> <a href="mailto:soporte.innovaedu@imss.gob.mx">soporte.innovaedu@imss.gob.mx</a><br><strong>Horario:</strong>&nbsp;de lunes a&nbsp;viernes, de&nbsp;8h&nbsp;a 17h</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar navbar-fixed-bottom">
        <footer >
            &copy; <a href="#" target="_blank">SIPIMSS 2017</a>
            <br>
            <div>Este sitio se visualiza correctamente apartir Mozila Firefox 50 y Google Chrome 55.</div>
        </footer>
    </div>
    <script>
    <?php
    if (isset($errores))
    {
        ?>
        $('#login-modal').modal({show: true});
        <?php
    }

    if (isset($user_recovery) || isset($code_recovery))
    {
        ?>
        $('#modalRecovery').modal({show: true});
        <?php
    }
    ?>
    </script>
</body>
</html>