<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Usuario
 *
 * @author chrigarc
 */
class Usuario extends MY_Controller
{

    const LIMIT = 10, LISTA = 'lista', BASICOS = 'basico', PASSWORD = 'password',
            NIVELES_ACCESO = 'niveles';

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_complete');
        $this->load->library('seguridad');
        $this->load->library('empleados_siap');
        $this->load->library('form_validation');
        $this->load->model('Usuario_model', 'usuario');
        $this->template->setTitle('Usuarios');
    }

    public function index()
    {
        redirect('usuario/get_usuarios/' . Usuario_model::LISTA);
    }

    public function get_usuarios($usuario = Usuario_model::LISTA, $limit = Usuario_model::LIMIT, $order_by = 'asc', $page_number = 0)
    {
        $output['limit'] = $limit;
        $params = array(
            'select' => array(
                'usuarios.id_usuario', 'docentes.id_docente', 'docentes.matricula', 'docentes.email'
                , 'concat("docentes".nombre, $$ $$, "docentes".apellido_p, $$ $$, "docentes".apellido_m) nombre_completo',
                'G.nombre delegacion', 'E.nombre unidad', 'usuarios.activo usuario_activo',
                'F.id_categoria', 'F.nombre categoria',
                'E.id_unidad_instituto'
            )
        );
        if ($usuario != Usuario_model::LISTA)
        {
            $params['where'] = array(
                'usuarios.id_usuario' => $usuario
            );
            $params['select'] = array(
                'usuarios.id_usuario', 'docentes.matricula', 'docentes.nombre',
                'docentes.apellido_p', 'docentes.apellido_m', 'sexo',
                'docentes.fecha_nacimiento', 'D.id_departamento_instituto', 'D.nombre departamento',
                'F.id_categoria', 'F.nombre categoria', 'C.cve_tipo_contratacion',
                'docentes.curp', 'docentes.rfc', 'docentes.telefono_particular',
                'docentes.telefono_laboral', 'docentes.email'
            );
            $resultado = $this->usuario->get_usuarios($params);
            if (count($resultado) == 1)
            {
                $output['usuario'] = $resultado[0];
            }
            $output['datos_basicos'] = $this->load->view('usuario/datos_basicos.tpl.php', $output, true);
            $output['grupos_usuario'] = $this->usuario->get_niveles_acceso($output['usuario']['id_usuario']);
            $output['campo_password'] = $this->load->view('usuario/campo_password.tpl.php', $output, true);
            $output['view_grupos_usuario'] = $this->load->view('usuario/tabla_niveles.tpl.php', $output, true);
            $output['campo_niveles_acceso'] = $this->load->view('usuario/niveles_acceso.tpl.php', $output, true);

            $view = $this->load->view('usuario/usuario.tpl.php', $output, true);
        } else
        {
            if ($this->input->post())
            {
                $limit = $this->input->post('per_page', true);
                $orden = $this->input->post('order', true);
                $order_by = $orden == 2 ? 'desc' : 'asc';
                $key = $this->input->post('filtro_texto', true);
                $value = $this->input->post('keyword', true);
                if ($value != '')
                {
                    $params['like'] = array($key => $value);
                }
            }
            $params['limit'] = $limit;
            $params['order_by'] = $order_by;
            $params['offset'] = $page_number;
            $output['usuarios'] = $this->usuario->get_usuarios($params);
            $output['tabla_usuarios'] = $this->load->view('usuario/tabla_usuarios.tpl.php', $output, true);

            $params['total'] = true;
            $filtros['total'] = $this->usuario->get_usuarios($params)[0]['total'];
            //pr($params);            
            //$filtros['total'] = 100;
            $filtros['per_page'] = $limit;
            $filtros['current_row'] = $page_number;
            $filtros['controller'] = 'usuario';
            $filtros['action'] = 'get_usuarios/' . Usuario_model::LISTA . '/' . $limit . '/' . $order_by;
//            pr($filtros);
            $paginacion = $this->template->pagination_data($filtros);
            $output['paginacion'] = $paginacion;
            $view = $this->load->view('usuario/get_usuarios.tpl.php', $output, true);
        }
        $this->template->setMainContent($view);
        $this->template->getTemplate();
//        $this->output->enable_profiler(true);
    }

    public function editar($id_usuario = 0, $tipo = Usuario_model::BASICOS)
    {
        $salida = [];
        $view = '';
        if ($this->input->post() && $this->input->is_ajax_request())
        {
            $this->config->load('form_validation'); //Cargar archivo con validaciones
            switch ($tipo)
            {
                case Usuario_model::BASICOS:
                    $view = $this->get_datos_basicos($id_usuario);
                    $validations = $this->config->item('form_actualizar'); //Obtener validaciones de archivo general                    
                    break;
                case Usuario_model::PASSWORD:
                    $view = $this->load->view('usuario/campo_password.tpl.php', array(), true);
                    $validations = $this->config->item('form_user_update_password'); //Obtener validaciones de archivo general                   
                    break;
                case Usuario_model::NIVELES_ACCESO:
                    $validations = $this->config->item('form_niveles_acceso_usuario');
                    $view = $this->get_niveles($id_usuario);
                    break;
            }
            $this->form_validation->set_rules($validations); //Añadir validaciones
            if ($this->form_validation->run() == TRUE)
            {
                $params = $this->input->post();
                $params['id_usuario'] = $id_usuario;
                $salida['tp_msg'] = $this->usuario->update($tipo, $params);
                $output['status'] = $salida;
                switch ($tipo)
                {
                    case Usuario_model::BASICOS:
                        $view = $this->get_datos_basicos($id_usuario);
                        break;
                    case Usuario_model::PASSWORD:
                        $view = $this->load->view('usuario/campo_password.tpl.php', $output, true);
                        break;
                    case Usuario_model::NIVELES_ACCESO:
                        $view = $this->get_niveles($id_usuario);
                        break;
                }
            } else
            {
                $salida['tp_msg'] = En_tpmsg::DANGER;
                $salida['msg'] = validation_errors();
            }
        }
        $salida['html'] = $view;
        echo json_encode($salida);
    }

    private function get_datos_basicos($id_usuario = 0)
    {
        $params['where'] = array(
            'usuarios.id_usuario' => $id_usuario
        );
        $params['select'] = array(
            'usuarios.id_usuario', 'docentes.matricula', 'docentes.nombre',
            'docentes.apellido_p', 'docentes.apellido_m', 'sexo',
            'docentes.fecha_nacimiento', 'D.id_departamento_instituto', 'D.nombre departamento',
            'F.id_categoria', 'F.nombre categoria', 'C.cve_tipo_contratacion',
            'docentes.curp', 'docentes.rfc', 'docentes.telefono_particular',
            'docentes.telefono_laboral', 'docentes.email'
        );
        $resultado = $this->usuario->get_usuarios($params);
        if (count($resultado) == 1)
        {
            $output['usuario'] = $resultado[0];
        }
        return $this->load->view('usuario/datos_basicos.tpl.php', $output, true);
    }

    private function get_niveles($id_usuario = 0)
    {
        $output['grupos_usuario'] = $this->usuario->get_niveles_acceso($id_usuario);
        $output['view_grupos_usuario'] = $this->load->view('usuario/tabla_niveles.tpl.php', $output, true);
        return $this->load->view('usuario/niveles_acceso.tpl.php', $output, true);
    }

    public function nuevo()
    {
        if ($this->input->post())
        {
            $this->config->load('form_validation'); //Cargar archivo con validaciones
            $validations = $this->config->item('form_registro'); //Obtener validaciones de archivo general
            $this->form_validation->set_rules($validations); //Añadir validaciones
            if ($this->form_validation->run() == TRUE)
            {
                $data = array(
                    'matricula' => $this->input->post('matricula', TRUE),
                    'delegacion' => $this->input->post('delegacion', TRUE),
                    'email' => $this->input->post('email', true),
                    'password' => $this->input->post('pass', TRUE),
                    'grupo' => $this->input->post('niveles', TRUE)
                );
                $output['registro_valido'] = $this->usuario->nuevo($data);
            }
        }
        $this->load->model('Catalogo_model', 'catalogo');
        $this->load->model('Administracion_model', 'administrador');
        $output['delegaciones'] = dropdown_options($this->catalogo->get_delegaciones(), 'clave_delegacional', 'nombre');
        $output['nivel_atencion'] = dropdown_options($this->administrador->get_niveles_acceso(), 'id_grupo', 'nombre');
        $main_content = $this->load->view('usuario/nuevo.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    public function carga_usuarios()
    {
        if ($this->input->post())
        {     // SI EXISTE UN ARCHIVO EN POST
            $config['upload_path'] = './uploads/';      // CONFIGURAMOS LA RUTA DE LA CARGA PARA LA LIBRERIA UPLOAD
            $config['allowed_types'] = 'csv';           // CONFIGURAMOS EL TIPO DE ARCHIVO A CARGAR
            $config['max_size'] = '1000';               // CONFIGURAMOS EL PESO DEL ARCHIVO
            $this->load->library('upload', $config);    // CARGAMOS LA LIBRERIA UPLOAD
            $view['status']['result'] = false;
            if ($this->upload->do_upload())
            { //Se ejecuta la validación de datos
                $this->load->library('csvimport');
                $file_data = $this->upload->data();     //BUSCAMOS LA INFORMACIÓN DEL ARCHIVO CARGADO
                $file_path = './uploads/' . $file_data['file_name'];         // CARGAMOS LA URL DEL ARCHIVO

                if ($this->csvimport->get_array($file_path))
                {              // EJECUTAMOS EL METODO get_array() DE LA LIBRERIA csvimport PARA BUSCAR SI EXISTEN DATOS EN EL ARCHIVO Y VERIFICAR SI ES UN CSV VALIDO
                    $csv_array = $this->csvimport->get_array($file_path);   //SI EXISTEN DATOS, LOS CARGAMOS EN LA VARIABLE $csv_array                    
                    $view['status'] = $this->usuario->carga_masiva($csv_array);
                    //pr($view['status']);
                    $this->reporte_registro($view['status']);
                } else
                {
                    $view['status']['msg'] = "Formato inválido";
                }
            } else
            {
                $view['status']['msg'] = "Formato inválido";
            }
        }
        $main_content = $this->load->view('usuario/formulario_carga.tpl.php', array(), true);
        $this->template->setMainContent($main_content);        
        $this->template->getTemplate();
    }

    private function reporte_registro(&$datos)
    {
        $filename = "Registro_" . date("d-m-Y_H-i-s") . ".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $this->load->view('usuario/reporte_registro.tpl.php', $datos, TRUE);
        exit();
    }

}
