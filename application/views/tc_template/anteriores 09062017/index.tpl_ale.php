<!doctype html>
<html lang="es">
    <head>
        <!--https://jqueryui.com/download/all/-->
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/img/template_sipimss/apple-icon.png'); ?>" />
        <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/template_sipimss/favicon.ico'); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>
            <?php echo (!is_null($title)) ? "{$title}&nbsp;|" : "" ?>
            <?php echo (!is_null($main_title)) ? $main_title : "SIPIMSS II" ?>
        </title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />

        <!-- Bootstrap core CSS     -->
        <?php echo css('template_sipimss/bootstrap.css'); ?>

        <!--  Material Dashboard CSS    -->
        <?php echo css('template_sipimss/zabuto_calendar.css'); ?>

        <!--  CSS for Demo Purpose, don't include it in your project     -->
        <link href="<?php echo base_url('assets/js/template_sipimss/gritter/css/jquery.gritter.css'); ?>" rel="stylesheet" />

        <!--     Fonts and icons     -->
        <link href="<?php echo base_url('assets/fonts/Roboto-Regular.ttf'); ?>"/>
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">


        <!-- Custom styles for this template -->

        <?php echo css('template_sipimss/style-responsive.css'); ?>
        <?php echo css('template_sipimss/style.css'); ?>
        <?php echo css('template_sipimss/apprise.css'); ?>
        <?php echo css('template_sipimss/jquery-ui-1.9.2.custom.min.css'); ?>
        <?php echo js("template_sipimss/jquery.dataTables_1.10.css"); ?>


        <!--Js ssssssssss-->
        <?php // echo js('jquery/jquery-2.1.4.min.js'); ?>
        <?php echo js('jquery/jquery-2.2.4.min.js'); ?>
        <?php echo js("template_sipimss/bootstrap.min.js"); ?>
        <!-- <?php echo js('jquery/jquery-3.1.1.js'); ?> -->
        <?php echo js('template_sipimss/jquery-ui-1.9.2.custom.min.js'); ?>
        <?php echo js('template_sipimss/chart-master/Chart.js'); ?>
        <?php echo js('template_sipimss/general.js'); ?>
        <?php echo js('template_sipimss/apprise.js'); ?>

        <!--Segunda parte-->
        <?php echo js("template_sipimss/jquery.dcjqaccordion.2.7.js"); ?>
        <?php echo js("template_sipimss/jquery.scrollTo.min.js"); ?>
        <?php echo js("template_sipimss/jquery.nicescroll.js"); ?>
        <?php echo js("template_sipimss/jquery.sparkline.js"); ?>
        <?php echo js("template_sipimss/common-scripts.js"); ?>
        <?php echo js("template_sipimss/gritter/js/jquery.gritter.js"); ?>
        <!--common script for all pages-->
        <?php echo js("template_sipimss/gritter-conf.js"); ?>
        <?php echo js("template_sipimss/sparkline-chart.js"); ?>
        <?php echo js("template_sipimss/zabuto_calendar.js"); ?>

        <?php echo js("template_sipimss/tasks.js"); ?>
        <script type="text/javascript">
            var url = "<?php echo base_url(); ?>";
            var site_url = "<?php echo site_url(); ?>";
            var img_url_loader = "<?php echo base_url('assets/img/loader.gif'); ?>";
        </script>
    </head>

    <body>
        <section id="container" >
            <!-- **********************************************************************************************************************************************************
            TOP BAR CONTENT & NOTIFICATIONS
            *********************************************************************************************************************************************************** -->
            <!--header start-->

            <header id="grad1" class="header black-bg">
                <!-- <div class="fa fa-bars tooltips" data-placement="right" data-original-title=""> -->
                <div class="row">

                    <div class="sidebar-toggle-box">
                        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Menú"></div>
                    </div>
                    <div class="col-xs-1">

                    </div>
                    <div class="col-xs-2 col-sm-1">
                        <a href="#">
                            <img img-responsive src="<?php echo asset_url(); ?>img/template_sipimss/sipimss.png"
                                 height="75px"
                                 class="img-header"
                                 alt="Coordinación de Educación en Salud"
                                 title="Coordinación de Educación en Salud"
                                 target="_blank"/>
                        </a>
                    </div>

                    <div class="col-xs-2 col-sm-1">
                        <a href="http://educacionensalud.imss.gob.mx">
                            <img img-responsive src="<?php echo asset_url(); ?>img/template_sipimss/ces.png"
                                 height="75px"
                                 class="img-header"
                                 alt="Instituto Mexicano del Seguro Social"
                                 title="Instituto Mexicano del Seguro Social"
                                 target="_blank"/>

                        </a>
                    </div>

                    <div class="col-xs-2 col-sm-1">
                        <a href="http://edumed.imss.gob.mx">
                            <img img-responsive src="<?php echo asset_url(); ?>img/template_sipimss/imss.png"
                                 height="75px"
                                 class="img-header"
                                 alt="Instituto Mexicano del Seguro Social"
                                 title="Instituto Mexicano del Seguro Social"
                                 target="_blank"/>

                        </a>
                    </div>

                </div>




                </div>
                <!--logo start-->
                <!-- <a href="index.html" class="logo"><b>SIPIMSS</b></a> -->
                <!--logo end-->

            </header>


            <!--header end-->

            <!-- **********************************************************************************************************************************************************
            MAIN SIDEBAR MENU
            *********************************************************************************************************************************************************** -->
            <!--sidebar start-->
            <aside>

                <?php
                if (isset($menu)) {
                    // pr ($menu);
                    echo $menu;
                }
                ?>

            </aside>
            <!--sidebar end-->
            <section id="main-content">
                <section class="wrapper">


                    <?php
                    if (isset($blank)) {
                        ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <?php
                                echo $blank;
                                ?>
                            </div>
                        </div>
                    <?php } //fin blank zone?>

                    <?php
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="">
                                <?php
                                if (isset($sub_title) && !empty($sub_title)) {
                                    ?>
                                    <div class="card-header" data-background-color="purple">
                                        <h4 class="title">
                                            <?php echo $sub_title; ?>
                                        </h4>
                                        <?php
                                        if (isset($descripcion) && !empty($descripcion)) {
                                            ?>
                                            <p class="category">
                                                <?php echo $descripcion ?>
                                            </p>
                                        <?php } ?>
                                    </div>
                                    <?php
                                }
                                if (isset($main_content)) {
                                    ?>
                                    <div class="card-content">
                                        <?php
                                        echo $main_content;
                                        ?>
                                    </div>
                                <?php } //fin content card   ?>
                            </div>
                        </div>
                    </div>

                </section>
            </section>
            <div class="modal fade" id="my_modal" tabindex="3" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <?php if (isset($my_modal)) { ?>
                        <?php echo $my_modal; ?>
                    <?php } ?>
                </div>
            </div>
            <!-- js placed at the end of the document so the pages load faster -->


<!--            <script type="text/javascript">
                $(document).ready(function () {
                    var unique_id = $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: 'Welcome to Dashgum!',
                        // (string | mandatory) the text inside the notification
                        // text: 'Hover me to enable the Close Button. You can hide the left sidebar clicking on the button next to the logo. Free version for <a href="http://blacktie.co" target="_blank" style="color:#ffd777">BlackTie.co</a>.',
                        // (string | optional) the image to display on the left
                        image: 'assets/img/ui-sam.jpg',
                        // (bool | optional) if you want it to fade out on its own or just sit there
                        sticky: true,
                        // (int | optional) the time you want it to be alive for before fading out
                        time: '',
                        // (string | optional) the class name you want to apply to that specific message
                        class_name: 'my-sticky-class'
                    });

                    return false;
                });
            </script>-->

            <script type="application/javascript">
                $(document).ready(function () {
                $("#date-popover").popover({html: true, trigger: "manual"});
                $("#date-popover").hide();
                $("#date-popover").click(function (e) {
                $(this).hide();
                });

                $("#my-calendar").zabuto_calendar({
                action: function () {
                return myDateFunction(this.id, false);
                },
                action_nav: function () {
                return myNavFunction(this.id);
                },
                ajax: {
                url: "show_data.php?action=1",
                modal: true
                },
                legend: [
                {type: "text", label: "Special event", badge: "00"},
                {type: "block", label: "Regular event", }
                ]
                });
                });


                function myNavFunction(id) {
                $("#date-popover").hide();
                var nav = $("#" + id).data("navigation");
                var to = $("#" + id).data("to");
                console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
                }
            </script>

    </body>


</html>
