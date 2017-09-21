<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene métodos para la carga de la plantilla base del sistema y creación de la paginación
 * @version 	: 1.1.0
 * @author 	: LEAS.
 * @property    : mixed[] Data arreglo de datos de plantilla con la siguisnte estructura array("title"=>null,"nav"=>null,"main_title"=>null,"main_content"=>null);
 * */
class Template_detalle_censo {

    private $element_detalle;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('html');
        
        $this->element_detalle = array(
            'boton_cerrar_modal' => $this->CI->load->view('tc_template/modal/boton_cerrar.php', null, TRUE),
            'detalle_registro' => null,
            'detalle_validacion_censo' => NULL,
            'detalle_evaluacion_curricular_censo' => null,
        );
    }

    function get_detalle_registro() {
        return $this->element_detalle['detalle_registro'];
    }

    function get_detalle_validacion_censo() {
        return $this->element_detalle['detalle_validacion_censo'];
    }

    function get_detalle_evaluacion_curricular_censo() {
        return $this->element_detalle['detalle_evaluacion_curricular_censo'];
    }

    function get_boton_cerrar_modal() {
        return $this->element_detalle['boton_cerrar_modal'];
    }

    function set_detalle_registro($datos_registro, $tpl = 'tc_template/modal/detalle_registro_censo.php') {
        $this->CI->load->library('Funciones_motor_formulario');
        $vista = $this->CI->load->view($tpl, $datos_registro, TRUE);
//        pr($vista);
        $this->element_detalle['detalle_registro'] = $vista;
    }

    function set_detalle_validacion_censo($detalle_validacion_censo) {
        $this->element_detalle['detalle_validacion_censo'] = $detalle_validacion_censo;
    }

    function set_detalle_evaluacion_curricular_censo($detalle_evaluacion_curricular_censo) {
        $this->element_detalle['detalle_evaluacion_curricular_censo'] = $detalle_evaluacion_curricular_censo;
    }

    function get_template($tpl = 'tc_template/modal/vista_detalle_censo_tpl.php') {
//        pr($this->element_detalle);
        $cuerpo = $this->CI->load->view($tpl, $this->element_detalle, TRUE);
        return $cuerpo;
    }

}
