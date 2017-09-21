<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// HELPER General
/**
 * Clase que ejecuta condiciones para mostrar notificaciones del motor formulario,ç
 * en particular se guardaran en la base de datos y tabla "ui.campos_formulario"
 * con el campo "regla_notificacion" ejemplo:
 * {"funcion":"valida_fecha_mayor_actual", "parametros":"value"} donde value es 
 * actualmente el valor del campo en el formulario
 * @autor 		: LEAS.
 * @param 		: mixed $mix Cadena, objeto, arreglo a mostrar
 * @return  	: Cadena preformateada
 */
class Funciones_motor_formulario {

    public function __construct() {
        $this->CI = & get_instance();
//        pr('sjjajsjajnsnajsja   Funciones_motor_formulario ');
//        pr($this->valida_fecha_mayor_actual('11/08/1988'));
    }

    /**
     * @author LEAS
     * @fecha 9/06/2017
     * @param type $fecha valor de fecha que será comparada con la fecha actual,
     * para el caso de que la fecha sea menor a la actual, desplegara un mensaje 
     * indicando modificar el archivo de certificación
     * @return string mensaje, en caso de que la condición no se cumpla, 
     * si se cumple la condición entonces retorna NULL
     */
    public function valida_fecha_mayor_actual($fecha = NULL) {
        $string_value = get_elementos_lenguaje(array(En_catalogo_textos::NOTIFICACIONES_FORMULARIO_CENSO));
        $resultado = valida_fecha_mayor_actual($fecha);
        if ($resultado) {
            return null;
        }
        return $string_value['nf_caducidad_certificado_consejo'];
    }

}
