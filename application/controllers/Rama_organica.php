<?php

/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Rama_organica
 *
 * @author chrigarc
 */
class Rama_organica extends MY_Controller {
    const AREA_ENFOQUE = 'area_enfoque';
    const DELEGACIONES = 'delegaciones';
    const CURSO = 'curso';
    const TIPO_CURSO = 'tipo_curso';
    const ROL = 'rol';

    function __construct() {
        parent::__construct();
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->library('rama');
        $this->config->load('general');
        $this->load->model('catalogo_model','catalogo');
    }

    public function get_detalle($tipo_elemento = Rama::UNIDAD, $clave = '', $periodo = 2017) {
        $salida = [];
        if ($clave != '') {
            switch ($tipo_elemento) {
                case Rama::UNIDAD:
                    $filtros['periodo'] = $periodo;
                    $filtros['clave_unidad'] = $clave;
                    $salida = $this->rama->get_unidades($filtros);
                    break;
            }
        }
        echo json_encode($salida);
    }

    public function get_localizador() {
        if ($this->input->post()) {

            if ($this->input->post('view') != null && $this->input->post('view', true) == 1) {
//                pr("renderrrrrrrrrr");
//                pr($this->input->post());
                $this->render_localizador();
            } else {
                $filtros = $this->input->post(null, true);
                $filtros['config'] = json_decode(base64_decode($filtros['config']), true);
//                pr($filtros);
                $filtros_unidades = $this->procesa_filtros_unidades($filtros);
                $output['datos'] = $this->rama->get_unidades($filtros_unidades);
                $output['config'] = $filtros;
                $output['campos'] = $this->get_campos_unidad($filtros);
//                pr($output['datos']);
                $output['id_form'] = 'localizador_sede_table_';
                $this->load->view('rama_organica/paginador.tpl.php', $output);
            }
        } else {
            echo 'Configuración invalida';
        }
    }

    private function procesa_filtros_unidades($filtros) {
        $filtros_nuevos = [];
        $filtros_unidades = $this->config->item('filtros_unidades');
        foreach ($filtros_unidades as $kf => $fu) {
            foreach ($filtros as $key => $value) {
                if (startsWith($key, $kf)) {
                    $filtros_nuevos[$fu] = $value;
                }
            }
        }
        if (!isset($filtros_nuevos['periodo'])) {
            $filtros_nuevos['periodo'] = date('Y');
        }
        return $filtros_nuevos;
    }

    private function get_campos_unidad(&$filtros = []) {        
        $campos_unidades = $this->config->item('columnas_unidades_grid');
        if($filtros['localizador_sede_id_servicio_'.$filtros['data_index']] == 2){
            $campos_unidades = $this->config->item('columnas_umae_grid');
        }
        $campos = array();
        pr($filtros);
        foreach ($filtros['config']['configuraciones']['columnas'] as $val) {
            if (isset($campos_unidades[$val])) {
                $campos[] = $campos_unidades[$val];
            }
        }
        if (empty($campos)) {
            $campos[] = $campos_unidades['cve_unidad'];
        }
//        pr($campos);
        return $campos;
    }

    private function render_localizador() {
        $config = $this->input->post(null, true);
//        pr($config);
        $output['config'] = $config;
        $output['niveles'] = $this->rama->get_niveles_atencion(false);
        $output['servicios'] = $this->rama->get_niveles_servicios();
        $output['delegaciones'] = dropdown_options($this->rama->get_delegaciones(), 'id', 'nombre');
        $this->load->view('rama_organica/localizador.tpl.php', $output);
    }

    public function tests() {
        $vista = $this->load->view('rama_organica/tests.tpl.php', [], true);
        $this->template->setTitle("Pruebas rama organica");
        $this->template->setMainContent($vista);
        $this->template->getTemplate();
    }

    public function get_lista($catalogo,$param1=null)
    {
        $resultado = array();

        switch ($catalogo) {
            case Rama_organica::AREA_ENFOQUE:
                $resultado = $this->catalogo->get_areas_enfoque(null,'nombre_area_enfoque');
                break;
            
            case Rama_organica::DELEGACIONES:
                $resultado = $this->rama->get_delegaciones();
                break;

            case Rama_organica::TIPO_CURSO:
                $get = $this->input->get(null,true);
                $filtros = array();
                if(isset($get['area_enfoque']))
                    $filtros['id_area_enfoque'] = $get['area_enfoque'];
                if(isset($get['proceso']))
                    $filtros['id_proceso_educativo'] = $get['proceso'];

                $tipos_curso = $this->catalogo->get_tipos_curso($filtros,'nombre_tipo_curso');
                foreach ($tipos_curso as $key => $value) {
                    $value['nombre_completo'] = $value['clave'] . ":" . $value['nombre_tipo_curso'];
                    $tipos_curso[$key] = $value;
                }
                $resultado = $tipos_curso;
                break;

            case Rama_organica::CURSO:
                $filtros = null;
                if(!is_null($param1)){
                    $filtros = array('id_tipo_curso'=>$param1);
                    
                }
                $resultado = $this->catalogo->get_cursos($filtros,'nombre_curso');
                break;

            case Rama_organica::ROL:
                $get = $this->input->get(null,true);
                $filtros = array();
                if(isset($get['area_enfoque']))
                    $filtros['id_area_enfoque'] = $get['area_enfoque'];
                if(isset($get['tipo_curso']))
                    $filtros['id_tipo_curso'] = $get['tipo_curso'];
                $resultado = $this->catalogo->get_rol_curso($filtros,'nombre_rol');
                break;
        }

        $resultado['length'] = count($resultado);
        header('Content-Type: application/json; charset=utf-8;');
        echo json_encode($resultado);
    }

    /**
    * Devuelve un json con toda la informacion relacionada con 
    * el tipo de actividad, la modalidad, el area de enfoque y las delegaciones
    * @author CPMS
    * @date 08/09/2017
    * @return json
    */
    public function get_lista_rama()
    {
        $resultado = array();
        $resultado['tipos_actividad'] = $this->catalogo->get_tipos_actividad(null,'nombre_tipo_actividad');
        $resultado['modalidades'] = $this->catalogo->get_modalidades(null,'nombre_modalidad');
        $resultado['areas_enfoque'] = $this->catalogo->get_areas_enfoque(null,'nombre_area_enfoque');
        $resultado['delegaciones'] = $this->catalogo->get_delegaciones();
        header('Content-Type: application/json; charset=utf-8;');
        echo json_encode($resultado);
    }


    /**
    * Devuelve toda la informacion relacionada con los cursos 
    * (tipo de curso, roles de curso y cursos)
    * dependiendo del area de enfoque
    * @author CPMS
    * @date 08/09/2017
    * @param id del area de enfoque, si es nulo se trae todo
    * @return json
    */
    public function get_info_cursos($area=null)
    {
        $resultado = array();
        $filtros = null;
        if(!is_null($area)){
            $filtros['id_area_enfoque'] = $area;
        }
        $resultado['tipos_curso'] = $this->catalogo->get_tipos_curso($filtros,'nombre_tipo_curso');
        $resultado['cursos'] = $this->catalogo->get_cursos($filtros,'nombre_curso');
        $resultado['roles'] = $this->catalogo->get_rol_curso($filtros,'nombre_rol');
        header('Content-Type: application/json; charset=utf-8;');
        echo json_encode($resultado);
    }
}
