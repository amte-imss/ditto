<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/img/template_sipimss/apple-icon.png'); ?>" />
        <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/template_sipimss/favicon.ico'); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>
            <?php echo (!is_null($title)) ? "{$title}&nbsp;|" : "" ?>
            <?php echo (!is_null($main_title)) ? $main_title : "CENSO DE PROFESORES" ?>
        </title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />
        <!-- BOOTSTRAP STYLES-->
        <?php echo css('bootstrap.css'); ?>
        <!-- FONTAWESOME ICONS STYLES-->
         <?php echo css('estilo_perfil.css'); ?>
        <?php echo css('font-awesome.css'); ?>
        <?php echo css('template_sipimss/apprise.css'); ?>
        <!--CUSTOM STYLES-->
        <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script type="text/javascript">
            var url = "<?php echo base_url(); ?>";
            var site_url = "<?php echo site_url(); ?>";
            var img_url_loader = "<?php echo base_url('assets/img/loader.gif'); ?>";
        </script>
        <?php //echo css('estilo_perfil.css'); ?>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <?php echo css('style.css'); ?>
        <?php echo js("jquery.js"); ?>
        <?php echo js("jquery.min.js"); ?>
        <?php echo js("jquery.ui.min.js"); ?>

        <!--Let browser know website is optimized for mobile-->
    </head>
    <body>
        <div id="overlay">
            <img src="<?php echo base_url('assets/img/loader.gif'); ?>" alt="Loading" /><br/>
            Cargando...
        </div>

        <div class="modal fade" id="my_modal" tabindex="3" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" id="my_modal_content" role="document">
                <?php
                if (isset($my_modal))
                {
                    ?>
                    <?php echo $my_modal; ?>
<?php } ?>
            </div>
        </div>
        <div id="wrapper">
            <!-- /. NAV TOP  -->
            <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">

                <!-- LLAMAR NAVTOP.PHP -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a  class="navbar-brand" href="index.html">SIPIMSS
                    </a>
                </div>
                <div class="notifications-wrapper">
                    <ul class="nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-tasks">
                                <li>
                                    <a href="#">
                                        <div>
                                            <p>
                                                <strong>Convocatoria</strong>
                                                <span class="pull-right text-muted">Marzo 2017</span>
                                            </p>
                                            <div class="">
                                                <h5>Censo de profesores</h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#">
                                        <div>
                                            <p>
                                                <strong>Validación</strong>
                                                <span class="pull-right text-muted">2017-2019</span>
                                            </p>
                                            <div class="">
                                                <h5>Se ha emitido el fallo</h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a class="text-center" href="#">
                                        <strong></strong>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user-plus"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="index.php"><i class="fa fa-user-plus"></i> Mi perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="info_docente.php"><i class="fa fa-user-plus"></i> Editar perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
                            </ul>
                        </li>

                        <li class="nav pull-right">
                            <ul class="">
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

            <nav  class="navbar-default navbar-side" role="navigation">
                <!-- AQUI VA EL MENU LATERAL -->
                <?php
                if (isset($menu))
                {
                    // pr ($menu);
                    echo $menu;
                }
                ?>



            </nav>
            <!-- /. SIDEBAR MENU (navbar-side) -->
            <div id="main-content" class="page-wrapper-cls">
                <?php
                if (isset($blank))
                {
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <?php
                            echo $blank;
                            ?>
                        </div>
                    </div>
                <?php } //fin blank zone  ?>

<?php ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="">
                            <?php
                            if (isset($sub_title) && !empty($sub_title))
                            {
                                ?>
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">
                                    <?php echo $sub_title; ?>
                                    </h4>
                                    <?php
                                    if (isset($descripcion) && !empty($descripcion))
                                    {
                                        ?>
                                        <p class="category">
                                        <?php echo $descripcion ?>
                                        </p>
                                <?php } ?>
                                </div>
                                <?php
                            }
                            if (isset($main_content))
                            {
                                ?>
                                <div class="card-content">
                                    <?php
                                    echo $main_content;
                                    ?>
                                </div>
<?php } //fin content card      ?>
                        </div>
                    </div>
                </div>


                <!-- /. PAGE WRAPPER  -->
            </div>
        </div>
        <!-- /. WRAPPER  -->
        <!-- /. FOOTER  -->
        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- JQUERY SCRIPTS -->
        <!-- <script src="assets/js/jquery-2.js"></script> -->

        <footer >
            &copy; <a href="#" target="_blank">SIPIMSS 2017</a>
        </footer>

        <!-- BOOTSTRAP SCRIPTS -->
<?php echo js("bootstrap.js"); ?>

        <!-- METISMENU SCRIPTS -->
<?php echo js("jquery.metisMenu.js"); ?>

        <!-- CUSTOM SCRIPTS -->
        <?php echo js("/custom.js"); ?>
        <?php echo js('template_sipimss/general.js'); ?>
<?php echo js('template_sipimss/apprise.js'); ?>

        <!--Import jQuery before materialize.js-->
        <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="assets/js/materialize.min.js"></script> -->

        <script type="text/javascript">
            // Instantiate the Bootstrap carousel
            $('.multi-item-carousel').carousel({
                interval: false
            });
            // for every slide in carousel, copy the next slide's item in the slide.
            // Do the same for the next, next item
        </script>
    </body>
</html>
