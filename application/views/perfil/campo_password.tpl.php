<?php
if (isset($status) && $status['tp_msg'])
{
    echo html_message('Contraseña actualizada con éxito', 'success');
} else if (isset($status))
{
    echo html_message('Datos inválidos', 'danger');
}
?>
<div class="form-group">
  <div class="col-md-4">
  </div>
    <label class="col-md-4 control-label">Contraseña: </label>
    <div class="col-md-4 input-group">
        <span class="input-group-addon"></span>
        <?php
        echo $this->form_complete->create_element(array('id' => 'pass', 'type' => 'password', 'value' => '', 'attributes' => array('name' => 'pass', 'class' => 'form-control', 'autocomplete' => 'off')));
        ?>
    </div>
    <?php echo form_error_format('pass'); ?>
</div>
<div class="form-group">
  <div class="col-md-4">
  </div>
    <label class="col-md-4 control-label">Confirmar contraseña: </label>
    <div class="col-md-4 input-group">
        <span class="input-group-addon"></span>
        <?php
        echo $this->form_complete->create_element(array('id' => 'pass_confirm', 'type' => 'password', 'attributes' => array('name' => 'pass_confirm', 'class' => 'form-control')));
        ?>
    </div>
    <?php echo form_error_format('pass_confirm'); ?>
</div>

<br>
<div class="form-group">
  <div class="col-md-5">
  </div>
    <label class="col-md-4 control-label"></label>
    <button id="submit" name="submit" type="submit" class="btn btn-success"  style=" background-color:#008EAD">Guardar <span class=""></span></button>
</div>
