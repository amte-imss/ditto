<?php

/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */

/**
 * Description of Inicio
 *
 * @author chrigarc
 */
class Inicio extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->library('seguridad');
        $this->load->library('empleados_siap');
        $this->load->helper(array('secureimage'));
        $this->load->model('Sesion_model', 'sesion');
        $this->load->model('Usuario_model', 'usuario');
    }

    public function index()
    {
        //load idioma
        $data["texts"] = $this->lang->line('formulario'); //textos del formulario
        //validamos si hay datos
        if ($this->input->post())
        {
            $post = $this->input->post(null, true);

            $this->config->load('form_validation'); //Cargar archivo con validaciones
            $validations = $this->config->item('login'); //Obtener validaciones de archivo general
            $this->form_validation->set_rules($validations);

            if ($this->form_validation->run() == TRUE)
            {
                $valido = $this->sesion->validar_usuario($post["usuario"], $post["password"]);
                $mensajes = $this->lang->line('mensajes');
                switch ($valido)
                {
                    case 1:
                        //redirect to home //load menu...etc etc
                        $params = array(
                            'where' => array('matricula' => $post['usuario']),
                            'select' => array(
                                'usuarios.id_usuario', 'docentes.matricula', 'docentes.id_docente', 'docentes.nombre',
                                'docentes.apellido_p', 'docentes.apellido_m', 'sexo',
                                'E.id_unidad_instituto', 'E.nombre unidad', 'E.clave_unidad', 
                                'docentes.fecha_nacimiento', 'D.id_departamento_instituto', 'D.nombre departamento',
                                'F.id_categoria', 'F.nombre categoria', 'C.cve_tipo_contratacion',
                                'docentes.curp', 'docentes.rfc', 'docentes.telefono_particular',
                                'docentes.telefono_laboral', 'docentes.email'
                            )
                        );
                        $usuario = $this->usuario->get_usuarios($params)[0];
                        $this->session->set_userdata('usuario', $usuario);
//                        pr($usuario);
                        redirect(site_url() . '/inicio/dashboard');
                        break;
                    case 2:
                        $this->session->set_flashdata('flash_password', $mensajes[$valido]);
                        break;
                    case 3:
                        $this->session->set_flashdata('flash_usuario', $mensajes[$valido]);
                        break;
                    default :
                        break;
                }
            } else
            {
//                pr(validation_errors());
                $data['errores'] = validation_errors();
            }
        }

        $usuario = $this->session->userdata('usuario');
        if (isset($usuario['id_usuario']))
        {
            redirect(site_url() . '/inicio/dashboard');
        } else
        {
            //cargamos plantilla
//            pr(validation_errors());
            $data['my_modal'] = $this->load->view("sesion/login_modal.tpl.php", $data, TRUE);
            $this->load->view("sesion/login.tpl.php", $data);
        }
//        $this->output->enable_profiler(true);
    }

    function captcha()
    {
        new_captcha();
    }

    public function cerrar_sesion()
    {
        $this->session->sess_destroy();
        redirect(site_url());
    }

    public function recuperar_password($code = null)
    {
        $datos = array();
        if ($this->input->post() && $code == null)
        {
            $usuario = $this->input->post("usuario", true);
            $this->form_validation->set_rules('usuario', 'Usuario', 'required');
            if ($this->form_validation->run() == TRUE)
            {
                $this->sesion->recuperar_password($usuario);
                $datos['recovery'] = true;
            }
        } else if ($this->input->post() && $code != null)
        {
            $this->form_validation->set_rules('new_password', 'Constraseña', 'required');
            $this->form_validation->set_rules('new_password_confirm', 'Confirmar constraseña', 'required');
            if ($this->form_validation->run() == TRUE)
            {
                $new_password = $this->input->post('new_password', true);
                $datos['success'] = $this->sesion->update_password($code, $new_password);
            }
        } else if ($code != null)
        {
            $datos['code'] = $code;
            $datos['form_recovery'] = true;
        }
        $datos['my_modal'] = $this->load->view("sesion/recuperar_password.tpl.php", $datos, TRUE);
        $datos["texts"] = $this->lang->line('formulario'); //textos del formulario
        $datos['my_modal'] .= $this->load->view("sesion/login_modal.tpl.php", $datos, TRUE);
        $this->load->view("sesion/login.tpl.php", $datos);
        //$this->load->view("sesion/recuperar_password.tpl.php", $datos);
    }

    public function manteminiemto()
    {
        echo 'En mantenimiento';
    }

    public function dashboard()
    {
        $id_usuario = $this->get_datos_sesion(En_datos_sesion::ID_USUARIO);
        $this->load->model('Modulo_model', 'modulo');
        $this->load->library('LNiveles_acceso');
        $niveles = $this->modulo->get_niveles_acceso($id_usuario, 'usuario');        
        if($this->lniveles_acceso->nivel_acceso_valido(array(LNiveles_acceso::Super, LNiveles_acceso::Admin), $niveles)){
            redirect('reporte/nivel_central');
        }else{
            redirect('reporte/n1');
        }                
    }
       
}