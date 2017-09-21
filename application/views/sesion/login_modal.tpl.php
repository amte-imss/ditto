<div class="">
    <div class="modal fade" id="registro-modal" tabindex="-1" role="dialog"  style="display: none;">
        <div class="modal-dialog" id="registro_modal_content">                    
        </div>
    </div>
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog"  style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-lock"></span>Iniciar sesión</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <div class="login-page">
                        <div class="form">
                            <?php echo form_open('inicio/index', array('id' => 'session_form', 'autocomplete' => 'off')); ?>
                            <div class="sign-in-htm">
                                <div class="form-group">
                                    <label for="user" class="pull-left"><span class="glyphicon glyphicon-user"></span> Matrícula:</label>
                                    <input id="usuario"
                                           name="usuario"
                                           type="text"
                                           class="input form-control"
                                           placeholder="<?php echo $texts['user']; ?>:">

                                </div>
                                <?php
                                echo form_error_format('usuario');
                                if ($this->session->flashdata('flash_usuario'))
                                {
                                    ?>
                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <?php echo $this->session->flashdata('flash_usuario');
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="form-group">
                                    <label for="pass" class="pull-left"><span class="glyphicon glyphicon-eye-open"></span> Contraseña:</label>
                                    <input id="password"
                                           name="password"
                                           type="password"
                                           class="input form-control"
                                           data-type="password"
                                           placeholder="<?php echo $texts['passwd']; ?>:">
                                </div>
                                <?php
                                echo form_error_format('password');
                                if ($this->session->flashdata('flash_password'))
                                {
                                    ?>

                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <?php echo $this->session->flashdata('flash_password'); ?>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="form-group" style="text-align:center;">
                                    <label for="pass" class="pull-left"><span class="glyphicon glyphicon-text-width"></span> Escribe el texto de la imagen:</label>
                                    <input id="captcha"

                                           name="captcha"
                                           type="text"
                                           class="input form-control "
                                           placeholder="<?php echo $texts['captcha']; ?>">
                                           <?php
                                           echo form_error_format('captcha');
                                           ?>
                                    <br>
                                    <div class="captcha-container" id="captcha_first">
                                        <img id="captcha_img" src="<?php echo site_url(); ?>/inicio/captcha" alt="CAPTCHA Image" />
                                        <a class="btn btn-lg btn-success pull-right" onclick="new_captcha()">
                                            <span class="glyphicon glyphicon-refresh"></span>
                                        </a>
                                    </div>
                                </div>
                                <br>
                                <div class="">
                                    <input type="submit" class="btn btn-success btn-block" value="Iniciar sesión">
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="">

                        <p><!-- <a href="#">¿Necesita ayuda? <span class="glyphicon glyphicon-question-sign"></span></a> --><br>
                            ¿Olvidó su contraseña?<br>
                            <a href="<?php echo site_url('inicio/recuperar_password'); ?>">Solicitela aquí</a></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //echo js("jquery.js"); ?>
<?php //echo js("jquery.min.js"); ?>
<?php //echo js("jquery.ui.min.js"); ?>
<?php //echo js('template_sipimss/general.js'); ?>
<?php //echo js("login.js"); ?>
<?php //echo js("bootstrap.js"); ?>
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