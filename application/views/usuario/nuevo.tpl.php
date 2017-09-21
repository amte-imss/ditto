
    <div id="page-inner">
    <div class="">
        <div class="row">
          <div class="col col-sm-12">
            <h1 class="page-head-line">
              <br>
              Registro de usuarios
            </h1>
          </div>
          <div class="panel-default">
            <?php
            if (isset($registro_valido['result']))
            {
                //pr($registro_valido);
                $tipo_msg = $registro_valido['result']? 'success' : 'danger';
                echo html_message($registro_valido['msg'], $tipo_msg);
            }
            ?>

            <?php
            echo form_open('usuario/nuevo', array('id' => 'form_registro'));
            ?>

          </div>
          <div class="form-inline" role="form" id="informacion_general">

              <form class="form-horizontal" id="form_datos_generales" method="post" accept-charset="utf-8">

                  <br>

                  <div class="row">
                    <div class="col-md-1">
                    </div>
                      <div class="col-md-5">
                          <div class="row">
                              <div class="col-md-4">
                                  <label for="paterno" class="righthoralign control-label">
                                      <b class="rojo">*</b>
                                    Matrícula: </label>
                              </div>
                              <div class="col-md-8">
                                  <div class="input-group">
                                      <span class="input-group-addon">
                                          <span class="fa fa-male"> </span>
                                      </span>
                                      <input id="matricula" name="matricula" placeholder="Escriba su matrícula" class="form-control"  type="number" required>
                                  </div>
                              </div>
                              <?php echo form_error_format('matricula'); ?>
                          </div>
                                  </div>
                      <div class="col-md-6" style="display: 1">
                          <div class="row">
                              <div class="col-md-4">
                                  <label for="materno" class="control-label">
                                      <b class="rojo">*</b>
                                      Correo electrónico:</label>
                              </div>
                              <div class="col-md-8">
                                  <div class="input-group">
                                      <span class="input-group-addon">
                                          <span class="fa fa-female"> </span>
                                      </span>
                                      <input id="email" name="email" placeholder="correo@imss.com" class="form-control"  type="email" required>
                                  </div>
                              </div>
                              <?php echo form_error_format('email'); ?>
                          </div>
                                  </div>
                  </div>
                   <br>


                     <div class="row">
                       <div class="col-md-1">
                       </div>
                         <div class="col-md-5">
                             <div class="row">
                                 <div class="col-md-4">
                                     <label for="paterno" class="righthoralign control-label">
                                         <b class="rojo">*</b>
                                       Contraseña: </label>
                                 </div>
                                 <div class="col-md-8">
                                     <div class="input-group">
                                         <span class="input-group-addon">
                                             <span class="fa fa-male"> </span>
                                         </span>
                                         <input id="pass" name="pass" placeholder="Escribe tu contraseña" class="form-control" type="password" required>
                                     </div>
                                 </div>
                                 <?php echo form_error_format('pass'); ?>
                             </div>
                                     </div>
                         <div class="col-md-6" style="display: 1">
                             <div class="row">
                                 <div class="col-md-4">
                                     <label for="materno" class="control-label">
                                         <b class="rojo">*</b>
                                         Confirmar contraseña:</label>
                                 </div>
                                 <div class="col-md-8">
                                     <div class="input-group">
                                         <span class="input-group-addon">
                                             <span class="fa fa-female"> </span>
                                         </span>
                                         <input id="repass" name="repass" placeholder="Repite tu contraseña" class="form-control" type="password" required >
                                     </div>
                                 </div>
                                 <?php echo form_error_format('repass'); ?>
                             </div>
                                     </div>
                     </div>
                     <br>

                     <div class="row">
                       <div class="col-md-1">
                       </div>
                         <div class="col-md-5">
                             <div class="row">
                                 <div class="col-md-4">
                                     <label for="paterno" class="righthoralign control-label">
                                         <b class="rojo">*</b>
                                       Delegación: </label>
                                 </div>
                                 <div class="col-md-8">
                                     <div class="input-group">
                                         <span class="input-group-addon">
                                             <span class="fa fa-male"> </span>
                                         </span>
                                         <?php
                                         echo $this->form_complete->create_element(array('id' => 'delegacion', 'type' => 'dropdown', 'options' => $delegaciones, 'first' => array('' => 'Seleccione una opción'), 'attributes' => array('name' => 'delegacion', 'class' => 'form-control')));
                                         ?>
                                     </div>
                                 </div>
                                 <?php echo form_error_format('delegacion'); ?>
                             </div>
                                     </div>
                         <div class="col-md-6" style="display: 1">
                             <div class="row">
                                 <div class="col-md-4">
                                     <label for="materno" class="control-label">
                                         <b class="rojo">*</b>
                                         Nivel de atención:</label>
                                 </div>
                                 <div class="col-md-8">
                                     <div class="input-group">
                                         <span class="input-group-addon">
                                             <span class="fa fa-female"> </span>
                                         </span>
                                         <?php
                                         echo $this->form_complete->create_element(array('id' => 'niveles', 'type' => 'dropdown', 'options' => $nivel_atencion, 'first' => array('' => 'Seleccione una opción'), 'attributes' => array('name' => 'niveles', 'class' => 'form-control')));
                                         ?>                           </div>
                                 </div>
                                 <?php echo form_error_format('niveles'); ?>
                             </div>
                                     </div>
                     </div>
                     <br><br>
                     <div class="col-md-5">

                     </div>

                     <div class="form-group">

                         <label class="col-md-4 control-label"></label>
                         <!-- <div class="col-md-4"> -->
                         <button id="submit" name="submit" type="submit" class="btn btn-tpl" data-idmodal="#divModal" >Registrar   <span class="glyphicon glyphicon-send"></span></button>
                     </div>
                     <!-- </div> -->
                     <?php echo form_close(); ?>


              </form>
              <br>
          </div>








    </div>
</div>
</div>
