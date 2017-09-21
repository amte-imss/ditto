<?php echo js('perfil/index.js'); ?>
<div id="page-inner">
    <div class="col-sm-12">
        <h1 class="page-head-line">
            Información general</h1>
    </div>
    <div class="col-sm-12">
        <div class=""> <br><br>

            <div class="">
                <!--form usuario completo-->               
                <div id="area_datos_basicos" class="col-md-12">
                    <?php echo $datos_basicos; ?>
                </div>                
            </div>
        </div>

    </div>


    <div>
        <br><br>
        <div class="row">
            <div class="col-sm-12">
                <br><br>
                <div class="col-sm-12">
                    <h6 class="page-head-line">
                        Contraseña de usuario</h6>
                </div>


                <div class="col-md-12">
                    <div class="" style="text-aligne:center; width: 650px; text-align: left;">
                        <!--form usuario completo-->
                        <?php
                        echo form_open('perfil/password', array('id' => 'form_actualizar_password'));
                        ?>
                        <div id="campo_password">
                            <?php echo $campo_password; ?>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>    
</div>
