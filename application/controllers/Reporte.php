<?php

/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Reporte
 *
 * @author chrigarc
 */
class Reporte extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Reporte_model', 'reporte');
    }

    public function nivel_central($export = '')
    {
        $this->load->model('Catalogo_model', 'catalogo');
        $output['delegaciones'] = $this->catalogo->get_delegaciones();
        $output['reporte'] = $this->reporte->get_reporte_nivel_central();
        $reporte = $output['reporte'];
        switch ($export)
        {
            case Reporte_model::Delegacion:
                $columnas = array(
                    'Clave delegación', 'Delegación', 'Número de profesores'
                );
                $file_name = 'registros_docentes_cursos_' . date('Ymd_his', time());
                $this->exportar_xls($columnas, $reporte['delegaciones'], null, null, $file_name);
                break;
            case Reporte_model::Unidad:
                $columnas = array(
                    'Clave delegación', 'Delegación', 'Clave unidad', 'Unidad/UMAE', 'Número de profesores'
                );
                $file_name = 'registros_docentes_cursos_' . date('Ymd_his', time());
                $this->exportar_xls($columnas, $reporte['unidades'], null, null, $file_name);
                break;
            default:
                $this->load->model('Catalogo_model', 'catalogo');
                $output['delegaciones'] = $this->catalogo->get_delegaciones();
//        $main_content = $this->load->view('inicio/demo.tpl.php', null, true);
                $main_content = $this->load->view('reporte/nivel_central.tpl.php', $output, true);
                $this->template->setMainContent($main_content);
                $this->template->getTemplate();
                break;
        }
    }

    public function n1()
    {
        $datos_sesion = $this->get_datos_sesion();
        if ($datos_sesion)//Valida sesión iniciada 
        {
            $id_usuario = $datos_sesion[En_datos_sesion::ID_USUARIO];
            $tmp = '(N.clave_unidad=\'' . $this->get_datos_sesion(En_datos_sesion::CLAVE_UNIDAD) . '\' or id_unidad_instituto=' . $this->get_datos_sesion(En_datos_sesion::ID_UNIDAD_INSTITUTO) . ')';
            $filtros[$tmp] = null;
            //***** Valida tipo de usuario
            $this->load->library('LNiveles_acceso');
            $this->load->model('Modulo_model', 'modulo');
            $niveles = $this->modulo->get_niveles_acceso($id_usuario, 'usuario');
            if ($this->lniveles_acceso->nivel_acceso_valido(array(LNiveles_acceso::Super, LNiveles_acceso::Admin), $niveles))
            {//Valida un nivel central
//            pr('adsads');
                unset($filtros[$tmp]); //Quita el filtro para que se exporten todos los datos
            }
            //***** Fin de validación de tipo de usuario
//          pr($filtros);
//          exit();
            $total_cursos_unidad = $this->reporte->get_cantidad_cursos_unidad($filtros);
            $datos['total_cursos_unidad'] = $total_cursos_unidad;
            $main_content = $this->load->view('reporte/n1.tpl.php', $datos, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        }
    }

    public function get_informacion_curso_unidad($tipo = null, $identificador = null)
    {
        $id_usuario = $this->get_datos_sesion(En_datos_sesion::ID_USUARIO);
        $tmp = '(N.clave_unidad=\'' . $this->get_datos_sesion(En_datos_sesion::CLAVE_UNIDAD) . '\' or RD.id_unidad_instituto=' . $this->get_datos_sesion(En_datos_sesion::ID_UNIDAD_INSTITUTO) . ')';
        $filtro[$tmp] = null;
//        $filtro['RD.id_unidad_instituto'] = $this->get_datos_sesion(En_datos_sesion::ID_UNIDAD_INSTITUTO);
//        $filtro['N.clave_unidad'] = $this->get_datos_sesion(En_datos_sesion::CLAVE_UNIDAD);
        if ($id_usuario)
        {
            $this->load->library('LNiveles_acceso');
            $this->load->model('Modulo_model', 'modulo');
            $niveles = $this->modulo->get_niveles_acceso($id_usuario, 'usuario');
            if ($this->lniveles_acceso->nivel_acceso_valido(array(LNiveles_acceso::Super, LNiveles_acceso::Admin), $niveles))
            {//Valida un nivel central
                unset($filtro[$tmp]); //Quita el filtro para que se exporten todos los datos
            }
            switch ($tipo)
            {
                case Reporte_model::TIPO_1://
                    if (!empty($identificador))
                    {
                        $filtro[Reporte_model::TIPO_1_TEXT] = $identificador;
                    }
                    break;
                case Reporte_model::TIPO_2://
                    if (!empty($identificador))
                    {
                        $filtro[Reporte_model::TIPO_2_TEXT] = $identificador;
                    }
                    break;
                case Reporte_model::TIPO_3://
                    if (!empty($identificador))
                    {
                        $filtro[Reporte_model::TIPO_3_TEXT] = $identificador;
                    }
                    break;
            }
            $result['cursos'] = $this->reporte->get_reporte_curso_unidad($filtro); //Reporte de cursos 
            $countries_tc = $this->reporte->get_tipos_cursos_unidad($filtro); //Tipos de curso
//        exit();
            array_unshift($countries_tc, ['id_tc' => '', 'tipo_curso' => 'Todos']);
            $result['countries_tc'] = $countries_tc; //Tipos de curso
//            exit();
            header('Content-Type: application/json; charset=utf-8;');
            $json = json_encode($result);
//        pr($json);
            echo $json;
        }
    }

    public function exportar_datos_detalle_cursos_registros()
    {
        //Columnas
        $columnas = array(
            'Tipo de curso', 'Nombre del curso', 'Cantidad'
        );
        $orden_columnas = ['nombre_tipo_curso', 'nombre_curso', 'cantidad'];
        $columnas_unset = array('id_tipo_curso', 'clave_curso');

        $id_usuario = $this->get_datos_sesion(En_datos_sesion::ID_USUARIO); //Identificador del usuario
        $tmp = '(N.clave_unidad=\'' . $this->get_datos_sesion(En_datos_sesion::CLAVE_UNIDAD) . '\' or RD.id_unidad_instituto=' . $this->get_datos_sesion(En_datos_sesion::ID_UNIDAD_INSTITUTO) . ')';
        $filtro[$tmp] = null;
        //Carga modelo de modulos
        $this->load->library('LNiveles_acceso');
        $this->load->model('Modulo_model', 'modulo');
        $niveles = $this->modulo->get_niveles_acceso($id_usuario, 'usuario');
        if ($this->lniveles_acceso->nivel_acceso_valido(array(LNiveles_acceso::Super, LNiveles_acceso::Admin), $niveles))
        {//Valida un nivel central
//        pr($clave_unidad);
            unset($filtro[$tmp]); //Quita el filtro para que se exporten todos los datos
        }


        $file_name = 'reporte_docentes_cursos_' . date('Ymd_his', time());
        $resultado = $this->reporte->get_reporte_curso_unidad($filtro);
//        exit();
        $this->exportar_xls($columnas, $resultado, $columnas_unset, $orden_columnas, $file_name);
    }

}
