<?php

/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Perfil
 *
 * @author chrigarc
 */
class Perfil extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->config('form_validation');     
        $this->load->model('Usuario_model', 'usuario');
    }

    public function index()
    {
        $usuario = $this->session->userdata('usuario');
        $filtros['where'] = array(
            'usuarios.id_usuario' => $usuario['id_usuario']
        );
        $filtros['select'] = array(
            'usuarios.id_usuario', 'docentes.matricula', 'docentes.nombre',
            'docentes.apellido_p', 'docentes.apellido_m', 'sexo',
            'docentes.fecha_nacimiento', 'D.id_departamento_instituto', 'D.nombre departamento',
            'F.id_categoria', 'F.nombre categoria', 'C.cve_tipo_contratacion',
            'docentes.curp', 'docentes.rfc', 'docentes.telefono_particular',
            'docentes.telefono_laboral', 'docentes.email'
        );

        $output['usuario'] = $this->usuario->get_usuarios($filtros)[0];
        $output['datos_basicos'] = $this->load->view('perfil/datos_basicos.tpl.php', $output, true);
        $output['campo_password'] = $this->load->view('perfil/campo_password.tpl.php', $output, true);
//        pr($usuario);
        $main_content = $this->load->view('perfil/usuario.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    public function password()
    {        
        if ($this->input->post() && $this->input->is_ajax_request())
        {
            $usuario = $this->session->userdata('usuario');
            $params = $this->input->post();
            $params['id_usuario'] = $usuario['id_usuario'];
            $validations = $this->config->item('form_user_update_password'); //Obtener validaciones de archivo general                               
            $this->form_validation->set_rules($validations); //Añadir validaciones
            if ($this->form_validation->run() == TRUE)
            {
                $salida['tp_msg'] = $this->usuario->update('password', $params);                
            }else{
                $salida['tp_msg'] = En_tpmsg::DANGER;
                $salida['msg'] = validation_errors();
            }
            $output['status'] = $salida;            
            $view = $this->load->view('perfil/campo_password.tpl.php', $output, true);
            $salida['html'] = $view;
            echo json_encode($salida);
        }
    }

}
