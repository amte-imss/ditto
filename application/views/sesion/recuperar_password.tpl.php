<div class="wrappe">
  <div class="containe">
    <!-- Modal recovery pass-->
    <div class="modal" aria-hidden="true" id="modalRecovery" tabindex="-1" role="document" >
     <div class="modal-dialog">
       <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span>Recuperar contraseña</h4>
        </div>
        <div id="modal_recovery" class="modal-body" style="padding:40px 50px;">
          <div class="login-page">
            <div class="form">
              <?php
              if (!isset($recovery) && !isset($form_recovery) && !isset($success)) {
                  ?>
                  <div class="login-form">
                      <p >¿Perdiste tu constraseña? Por favor introduce tu nombre de usuario o correo electrónico. Recibirás un enlace para crear una contraseña nueva por correo electronico.</p>
                      <?php echo form_open('inicio/recuperar_password', array('id' => 'session_form')); ?>
                      <div class="sign-in-htm">
                          <div class="group">
                              <label for="user">Nombre de usuario o correo electrónico:</label>
                              <br>
                              <input id="usuario" name="usuario" type="text" class="input form-control">
                          </div>
                          <br>
                          <?php echo form_error_format('usuario'); ?>
                          <div class="group">
                            <button  onclick="data_ajax(site_url + 'inicio/recuperar_password', null, '#modal_recovery');" class="btn btn-success btn-block" value="Restablecer contraseña">
                              Restablecer contraseña
                            </button>
                              <!-- <input type="submit" class="btn btn-success btn-block" value="Restablecer contraseña"> -->
                          </div>
                          <?php echo form_close(); ?>
                      </div>

                  </div>
                  <?php
              } else if (isset($form_recovery)) {
                  ?>
                  <div class="login-form">
                      <p style="color: #fff;">Por favor indica cual será tu nueva contraseña</p>
                      <?php echo form_open('inicio/recuperar_password/' . $code, array('id' => 'session_form')); ?>
                      <div class="sign-in-htm">
                          <div class="group">
                              <label for="new_password" class="label">Contraseña:</label>
                              <input id="new_password" name="new_password" type="password" class="input" data-type="password">
                          </div>
                          <?php echo form_error_format('new_password'); ?>

                          <div class="group">
                              <label for="new_password_confirm" class="label">Confirmar Contraseña:</label>
                              <input id="new_password_confirm" name="new_password_confirm" type="password" class="input" data-type="password">
                          </div>
                          <?php echo form_error_format('new_password_confirm'); ?>
                          <div class="group">
                              <input type="submit" class="btn btn-success btn-login" value="Restablecer contraseña">
                          </div>
                          <?php echo form_close(); ?>
                      </div>

                  </div>
                  <?php
              } else if (isset($success)) {
                  ?>
                  <p >Contraseña actualizada con éxito</p>
                  <?php
              } else {
                  ?>
                  <p >El sistema ha recibido tu solicud con éxito, recibirás un enlace para crear una contraseña nueva por correo electrónico.</p>
                  <?php
              }
              ?>
            </div>
            </div>
        </div>
        </div>
      </div>
      </div>
    <!-- /Modal recovery pass -->
  </div>
</div>
<?php //echo js("jquery.js"); ?>
<?php //echo js("jquery.min.js"); ?>
<?php //echo js("jquery.ui.min.js"); ?>
<?php //echo js("login.js"); ?>
<?php //echo js("bootstrap.js"); ?>
<script type="text/javascript">
  $('#modalRecovery').modal('show');
</script>
