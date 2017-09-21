<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene métodos para siap
 * @version 	: 1.0.0
 * @author      : Pablo José
 * */
class Empleados_siap {

    public function __construct() {
        $this->CI = & get_instance();
    }

    /*     * *********Buscar usuario siap
     * Función que genera una imagen captcha
     * recibe dos parametros (informacion de registro de aspirantes)
     * @method: void buscar_usuario_siap()
     */

    function buscar_usuario_siap($delegacion, $matricula) {
        $return_info = false;
        $result = array('resp_info' => null, 'resultado' => 'false');
        $params = array("Delegacion" => "{$delegacion}", "Matricula" => "{$matricula}", "RFC" => '');

        $client = new SoapClient("http://172.26.18.156/ServiciosWeb/wsSIED.asmx?WSDL");
        $resultado_siap = $client->__soapCall("ConsultaSIED", array($params));
        $resultado = simplexml_load_string($resultado_siap->ConsultaSIEDResult->any); //obtenemos la consulta xml
        $res_json = json_encode($resultado); // la codificamos en json
        $array_result = json_decode($res_json); // y la decodificamos en un arreglo compatible php

        $return_info['empleado'] = array();
        $return_info['tp_msg'] = En_tpmsg::DANGER;
        if (isset($resultado->EMPLEADOS)) {
            $result['resultado'] = true;
            $result['resp_info'] = $resultado;
            $return_info['empleado'] = $this->regresa_datos($result, $delegacion);
            $return_info['tp_msg'] = En_tpmsg::SUCCESS;
        }
        return $return_info;
    }

    public function regresa_datos($result, $delegacion) {

        if ($result['resultado'] == 1) {
            foreach ($result['resp_info'] as $aspirante) {
                $fecha_curp = str_split($aspirante->EMP_RECURP, 2);
                /*
                 * //str_pad($datos_resgistro['reg_delegacion'], 4,"0" , STR_PAD_LEFT); $fecha_actual = now();
                 *  * despues actualizar por fechas mas reales
                 * */
                $anio = $fecha_curp[2];
                $anio_completo = ($anio > 59) ? str_pad($anio, 4, "19", STR_PAD_LEFT) : str_pad($anio, 4, "20", STR_PAD_LEFT);
                $mes = $fecha_curp[3];
                $dia = $fecha_curp[4];
                $fecha_nacimiento = $anio_completo . '/' . $mes . '/' . $dia;
//                pr($aspirante->SEXO);
                switch ($aspirante->SEXO) {
                    case'Femenino':
                        $sexo = En_sexo::FEMENINO;
                        break;
                    case'Masculino':
                        $sexo = En_sexo::MASCULINO;
                        break;
                }

//                $sexo_asp = str_split($aspirante->SEXO, 1);
//                $sexo = $sexo_asp[0];
                $datos = array(
                    'matricula' => (array) $aspirante->MATRICULA,
                    'nombre' => $aspirante->NOMBRE,
                    'paterno' => $aspirante->APE_PATERNO,
                    'materno' => $aspirante->APE_MATERNO,
                    'sexo' => $sexo,
                    'curp' => $aspirante->EMP_RECURP,
                    'rfc' => $aspirante->RFC,
                    'nacimiento' => $fecha_nacimiento,
                    'status' => $aspirante->EMP_STATUS,
                    //'delegacion' => $aspirante->DELEGACION,
                    'delegacion' => $delegacion,
                    'antiguedad' => $aspirante->ANTIGUEDAD,
                    'adscripcion' => $aspirante->ADSCRIPCION,
                    'descripcion' => $aspirante->DESCRIPCION,
                    'emp_regims' => $aspirante->EMP_REGIMS,
                    'emp_keypue' => $aspirante->EMP_KEYPUE,
                    'pue_despue' => $aspirante->PUE_DESPUE,
                    'fecha_ingreso' => $aspirante->FECHAINGRESO
                );

                return $datos;
            }
        } else {
            return false;
        }
    }

}
