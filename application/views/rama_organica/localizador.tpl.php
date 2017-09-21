<?php
/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 * Oh!   pero que pasa, no creí que fuera posible pero ahora alguien más sabe lo 
 * que te fumaste ese día y creo que fue de la buena
 */
//pr($config);
?>
<div>
    <!--<p>Localizador de sede</p>-->            
    <input id="localizador_sede_config_<?php echo $config['data_index']; ?>" type="hidden" data-index="<?php echo $config['data_index']; ?>" name="config" value="<?php echo base64_encode(json_encode($config)); ?>">
    <div class="form-group">                
        <div class="col-md-4">
            <div class="input-group input-group">
                <span class="input-group-addon">Localizar por:</span>
                <?php
                echo $this->form_complete->create_element(
                        array('id' => 'localizador_sede_id_servicio_' . $config['data_index'],
                            'type' => 'dropdown',
                            'first' => array('' => 'Seleccione...'),
                            'options' => $servicios,
                            'attributes' => array(
                                'class' => 'form-control',
                                'data-toggle' => 'tooltip',
                                'title' => 'Nivel de atención',
                                'data-index' => $config['data_index'],
                                'onchange' => 'localizador_sede_servicio(this)')
                        )
                );
                ?>
            </div>
        </div>
        <?php
        if (!isset($config['configuraciones']['mostrar_nivel_atencion']) || $config['configuraciones']['mostrar_nivel_atencion'] == 1)
        {
            ?>
            <div class="col-md-4" style="display:none;">
                <div class="input-group input-group">
                    <span class="input-group-addon">Tipo:</span>
                    <?php
                    echo $this->form_complete->create_element(
                            array('id' => 'localizador_sede_id_nivel_' . $config['data_index'],
                                'type' => 'dropdown',
                                'first' => array('' => 'Seleccione...'),
                                'options' => $niveles,
                                'attributes' => array(
                                    'class' => 'form-control',
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Nivel de atención',
                                    'data-index' => $config['data_index'],
                                    'onchange' => 'localizador_sede_nivel(this)')
                            )
                    );
                    ?>
                </div>
            </div>
            <?php
        }
        ?>

        <div class="col-md-4" style="display:none;">
            <div class="input-group input-group">
                <span class="input-group-addon">Delegación:</span>
                <?php
                echo $this->form_complete->create_element(
                        array('id' => 'localizador_sede_id_delegacion_' . $config['data_index'],
                            'type' => 'dropdown',
                            'first' => array('' => 'Seleccione...'),
                            'options' => $delegaciones,
                            'attributes' => array(
                                'class' => 'form-control',
                                'data-toggle' => 'tooltip',
                                'title' => 'Delegaciones',
                                'data-index' => $config['data_index'],
                                'onchange' => 'localizador_sede_delegacion(this)')
                        )
                );
                ?>
            </div>
        </div>
    </div>    
    <br>
    <div id="localizador_sede_table_<?php echo $config['data_index']; ?>">

    </div>    
</div>
