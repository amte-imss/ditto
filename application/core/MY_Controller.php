<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author: LEAS
 * @version: 1.0
 * @desc: Clase padre de los controladores del sistema
 * */
class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->lang->load('interface', 'spanish');
        $this->load->config('general');
        $usuario = $this->get_datos_sesion(En_datos_sesion::ID_USUARIO);
        if (!is_null($usuario))
        {
            $this->load->model('Menu_model', 'menu');
            $menu = $this->menu->get_menu_usuario($usuario);
            //pr($menu);
            $this->template->setNav($menu);
            //pr($menu);
        }
    }

    private function carga_imagen()
    {
        //carga datos de imagen del docente
        $id_docente = $this->get_datos_sesion(En_datos_sesion::ID_DOCENTE); //Carga identificador del docente
        if (!is_null($id_docente))
        {
            $this->load->model("Docente_model", "dm");
            /* Cargar imagen de perfil */
//            set_datos_imagen_perfil
            $imagen_perfil = $this->dm->get_imagen_perfil($id_docente);
            $this->template->set_datos_imagen_perfil($imagen_perfil); //Obtener imagen del docente
        }
    }

    protected function genera_menu()
    {
        $menu['elementos_menu'] = array(
            1 => array('name_act' => 'Perfil', 'ruta' => 'perfil', 'imagen' => '2.png', 'class' => 'mt'), //mt
            //  1 => array('name_act' => 'Información general', 'ruta' => 'info_gral/mostrar/311091488', 'icono' => 'fa fa-user-md', 'class' => 'sub-menu'), //mt
            2 => array('name_act' => 'Información docente', 'ruta' => 'informacion_imss', 'imagen' => '3.png', 'class' => ''), //mt
            3 => array('name_act' => 'Formación docente', 'ruta' => 'formacion_docente', 'imagen' => '10.png', 'class' => ''),
            4 => array('name_act' => 'Actividad docente', 'ruta' => 'actividad_docente', 'imagen' => '4.png', 'class' => ''),
            5 => array('name_act' => 'Becas', 'ruta' => 'becas_comisiones', 'imagen' => '5.png', 'class' => ''),
            6 => array('name_act' => 'Comisiones', 'ruta' => 'comisiones_academicas', 'imagen' => '6.png', 'class' => ''),
            7 => array('name_act' => 'Dirección de tésis', 'ruta' => 'direccion_tesis', 'imagen' => '9.png', 'class' => ''),
            8 => array('name_act' => 'Material educativo', 'ruta' => 'material_educativo', 'imagen' => '7.png', 'class' => ''),
            9 => array('name_act' => 'Investigación', 'ruta' => 'investigacion', 'imagen' => '8.png', 'class' => ''),
        );
        $this->template->setNav($menu);
    }

    public function new_crud()
    {
        $db_driver = $this->db->platform();
        $model_name = 'Grocery_crud_model_' . $db_driver;
        $model_alias = 'm' . substr(md5(rand()), 0, rand(4, 15));
        unset($this->{$model_name});
        $this->load->library('grocery_CRUD');
        $crud = new Grocery_CRUD();
        if (file_exists(APPPATH . '/models/' . $model_name . '.php'))
        {
            $this->load->model('Grocery_crud_model');
            $this->load->model('Grocery_crud_generic_model');
            $this->load->model($model_name, $model_alias);
            $crud->basic_model = $this->{$model_alias};
        }
        $crud->set_theme('datatables');
        $crud->unset_print();
        return $crud;
    }

    /**
     *
     * @param type $busqueda_especifica
     * @return int
     * @obtiene el array de los datos de session
     */
    protected function get_datos_sesion($busqueda_especifica = '*')
    {
        $data_usuario = $this->session->userdata('usuario');
//        $data_usuario = array(En_datos_sesion::ID_DOCENTE => 1, En_datos_sesion::MATRICULA => '311091488', En_datos_sesion::ID_UNIDAD_INSTITUTO => 1);
        if ($busqueda_especifica == '*')
        {
            return $data_usuario;
        } else
        {
            if (isset($data_usuario[$busqueda_especifica]))
            {
                return $data_usuario[$busqueda_especifica];
            }
        }
        return NULL; //No se encontro  una llave especifica o la session caduco
    }

    /**
     * @author LEAS
     * @param type $configuracion Lllave de configuración para la carga de archivo
     * (archivo general de configuraciones) el cual incluye upload_path, allowed_types,
     *  remove_spaces, max_size, detect_mime, file_name
     * @param type $carpeta Nombre del directorio donde se almacenará el archivo
     * @param type $nombre_file Nombre del archivo despues de guardado
     * @return type
     */
    protected function save_file($configuracion, $carpeta, $nombre_file, $key_name_file = 'userfile')
    {
        if ($_FILES && $this->input->post())
        {
            $string_value = get_elementos_lenguaje(array(En_catalogo_textos::GUARDAR_ACTUALIZAR));
//            $data = $this->input->post(null, true);
            $config = $this->colocar_configuracion($configuracion, $carpeta, $nombre_file); ///Obtener configuración para carga de archivo
//            pr($config);
            $this->load->library('upload', $config); ///Librería que carga y valida(peso, extensión) los archivos
//            pr($key_name_file);
//            pr($_FILES);
            if (!$this->upload->do_upload($key_name_file))
            {
                return array('tp_msg' => En_tpmsg::DANGER, 'mensaje' => $this->upload->display_errors());
            } else
            {
                $data_file_complete = $this->upload->data();
                return array('tp_msg' => En_tpmsg::SUCCESS,
                    'mensaje' => $string_value['guardo_file'],
                    'upload_path' => $config['upload_path'],
                    'raw_name' => $data_file_complete['raw_name'], //Nombre real del archivo
                );
            }
        }
    }

    /**
     * @author LEAS
     * @param type $ruta Ruta hasta el directorio donde se encuentra el archivo
     * @param type $nombre_file Nombre del fichero, si el nombre contiene la extención del archivo, entonces extención debe ser NULL
     * si no, indicar la extención del archivo
     * @param type $extencion exteción del archivo, si el nombre del archivo contene la extención, la variable debe de ser NULL
     * @return boolean True si el archivo no existe o si se elimino correctamente
     */
    protected function delete_file($ruta, $nombre_file, $extencion = null)
    {
        if (is_null($extencion))
        {//La extención viene explicito con el nombre del archivo
            $file_nombre_ = '.' . $ruta . $nombre_file;
        } else
        {//Valida que la extencion exista para concatenar con el nombre del archivo
            $file_nombre_ = '.' . $ruta . $nombre_file . '.' . $extencion;
        }
//        pr($file_nombre_);
        if (file_exists($file_nombre_))
        {//Valida que exista el archivo
            return unlink($file_nombre_); //elmina el fichero anterior, despues de guardar la información anterior
        }
        return true;
    }

    private function colocar_configuracion($key_config = 'comprobantes', $carpeta = null, $nombre_archivo = null)
    {
//        [$configuracion]; //Obtener parámetros definidos en archivo general de configuración
        $configuracion_carga = $this->config->item('upload_config')[$key_config]; //Obtener parámetros definidos en archivo general de configuración
        $ruta = $configuracion_carga['upload_path']; ///Obtener path para carga de archivos
//        pr($ruta);
        if (crea_directorio($ruta . $carpeta))
        {//Valida que se creo el directorio de almacenar files del docente o comprobante
            $ruta_archivos = $ruta . $carpeta . "/"; ///Definir ruta de almacenamiento, se utiliza la matricula

            $nombre_archivo_real = (!is_null($nombre_archivo)) ?
                    $nombre_archivo :
                    $this->session->userdata('matricula') . '_' . time();

            $config['carpeta'] = $carpeta;
            $config['path_simple'] = $ruta;
            $config['upload_path'] = $ruta_archivos;
            $config['allowed_types'] = $configuracion_carga['allowed_types'];
            $config['max_size'] = $configuracion_carga['max_size']; // Definir tamaño máximo de archivo
            $config['detect_mime'] = $configuracion_carga['detect_mime']; // Validar mime type
            $config['file_name'] = $nombre_archivo_real; ///Renombrar archivo

            return $config;
        }
    }

    /**
     *
     * @param type $file
     */
    public function ver_archivo($file = null)
    {
        $string_values = get_elementos_lenguaje(array(En_catalogo_textos::COMPROBANTE));
        if (is_null($file))
        {
            $data_error['heading'] = $string_values['error_404'];
            $data_error['message'] = $string_values['archivo_inexistente'];
            echo $this->load->view('errors/html/error_404.php', $data_error, TRUE);
            exit();
        }

        $file_id = decrypt_base64($file); ///Decodificar url, evitar hack
        $this->load->model("Files_model", "fm");
        $result_file = $this->fm->get_file($file_id); //Se valida que exista registro en base de datos
        if (!empty($result_file))
        {

            $ruta_archivo = '.' . $result_file[0]['ruta'] . $result_file[0]['nombre_fisico'] . '.' . $result_file[0]['nombre_extencion'];
//            pr($ruta_archivo);
            if (file_exists($ruta_archivo))
            {
                //$main_content = $this->load->view('template/pdfjs/viewer', array('ruta_archivo'=>$ruta_archivo), true);
                $url = base_url($ruta_archivo);
                $this->load->view('tc_template/pdfjs/viewer.php', array('ruta_archivo' => $url), false);
//                pr($main_content);
            }
        } else
        {
            $html = '<div role="alert" class="alert alert-success" style="padding:25px; margin-bottom:80px;"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button><h4>' . $string_values['archivo_inexistente'] . '</h4></div>';
        }
        if (isset($html))
        {
            $this->template->setMainContent($html);
            $this->template->getTemplate();
        }
    }

    /**
     *
     * @param type $file
     */
    public function descarga_archivo($file = null)
    {
        $string_values = get_elementos_lenguaje(array(En_catalogo_textos::COMPROBANTE));
        if (is_null($file))
        {
            $html = '<div role="alert" class="alert alert-success" style="padding:25px; margin-bottom:80px;"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button><h4>' . $string_values['archivo_incorrecto'] . '</h4></div>';
            exit();
        }

        if (!is_null($file))
        {
            $file_id = decrypt_base64($file); ///Decodificar url, evitar hack
//            pr($file);
            $this->load->model("Files_model", "fm");
            $result_file = $this->fm->get_file($file_id); //Se valida que exista registro en base de datos
            if (!empty($result_file))
            {
//                $ruta_archivo = base_url($result_file[0]['ruta'] . $result_file[0]['nombre_fisico'] . '.' . $result_file[0]['nombre_extencion']);
                $ruta_archivo = '.' . $result_file[0]['ruta'] . $result_file[0]['nombre_fisico'] . '.' . $result_file[0]['nombre_extencion'];
                if (file_exists($ruta_archivo))
                {
                    $ext = pathinfo($archivo[0]['COM_NOMBRE'], PATHINFO_EXTENSION);
                    header('Content-Description: File Transfer');
                    if ($ext != $this->config->item('upload_config')['comprobantes']['allowed_types'])
                    {
                        header('Content-Type: application/octet-stream');
                    } else
                    {
                        header('Content-type: application/pdf');
                    }
//                    if ($descarga == true) { ///Descargar
//                        header('Content-Disposition: attachment; filename="' . $archivo[0]['COM_NOMBRE'] . '"');
//                    } else { ///Ver en línea
//                    }
                    header('Content-Disposition: inline; filename="' . $result_file[0]['nombre_fisico'] . '.' . $result_file[0]['nombre_extencion'] . '"');
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($ruta_archivo));
                    ob_clean();
                    flush();
                    //readfile($ruta_archivo);
                    echo file_get_contents($ruta_archivo);
                    exit;
                }
            } else
            {
                $html = '<div role="alert" class="alert alert-success" style="padding:25px; margin-bottom:80px;"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button><h4>' . $this->string_values['general']['archivo_inexistente'] . '</h4></div>';
            }
        }
        if (isset($html))
        {
            $this->template->setMainContent($html);
            $this->template->getTemplate();
        }
    }

    /**
     * 
     * @param array $columnas Nombre de las columnas en el archivo
     * @param type $informacion Información o datos de la exportación
     * @param type $orden_columna Orden de las columnas
     * @param type $file_name Nombre del archivo exportado
     * @param type $delimiter delimitador del csv, por default será ","
     * @return type Descriptión documento a exportado ceon extención csv
     */
    protected function exportar_xls($columnas = null, $informacion = null, $column_unset = null, $orden_columna = null, $file_name = 'tmp_file_export_data', $delimiter = ',')
    {//$id_ciclo_evaluacion,$status,$filename
        header("Content-Encoding: UTF-8");
        header("Content-type: application/x-msexcel;charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '.xls";');

        $f = fopen('php://output', 'w');

        fputs($f, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        fputcsv($f, $columnas, $delimiter);

        //pr($info);
        if (!is_null($orden_columna))
        {
            foreach ($informacion as $line)
            {

                $column = [];
                foreach ($orden_columna as $genera)//Recorre las columnas extra que no se imprimen
                {
                    if (isset($line[$genera]))
                    {
                        $column[] = $line[$genera]; //Elimina colunas extra
                    } else
                    {
                        $column[] = ' '; //Elimina colunas extra
                    }
                }
                fputcsv($f, $column, $delimiter);
            }
        } else
        {
            foreach ($informacion as $line)
            {
                if (!is_null($column_unset))
                {

                    foreach ($column_unset as $val_unset)//Recorre las columnas extra que no se imprimen
                    {
                        unset($line[$val_unset]);
                    }
                }
                fputcsv($f, $line, $delimiter);
            }
        }
        fclose($f);
    }

}
