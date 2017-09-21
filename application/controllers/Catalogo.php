<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogo extends MY_Controller
{

    const ADMIN = 'admin';
    const FILTRO = 'filtro';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('grocery_CRUD');
        $this->load->model('catalogo_model', 'catalogo');
        $this->load->library('form_complete');
    }

    public function index()
    {   
        try{
            $output = array();
            $vista = $this->load->view('catalogo/catalogos.tpl.php', $output, true);
            $this->template->setTitle("Administración de Catálogos");
            $this->template->setMainContent($vista);
            $this->template->getTemplate();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function area_enfoque()
    {
        try{
            $data_view = array();

            $this->db->schema = 'catalogo';
            $crud = $this->new_crud();
            $crud->set_table('area_enfoque');
            $crud->set_subject('área de enfoque');
            $crud->set_primary_key('id_area_enfoque');

            $crud->columns( 'id_area_enfoque', 'nombre_area_enfoque','id_modalidad',  'activo');
            $crud->callback_column('id_modalidad',array($this,'modalidad_columna'));

            $crud->add_fields('nombre_area_enfoque','id_modalidad');
            $crud->callback_add_field('id_modalidad',array($this,'modalidad_add_fields'));

            $crud->edit_fields('nombre_area_enfoque','id_modalidad','activo');
            $crud->callback_edit_field('id_modalidad',array($this,'modalidad_edit_fields'));

            $crud->required_fields('nombre_area_enfoque');
            $crud->set_rules('id_modalidad', 'Rama modalidad', 'callback_select_requerido');

            $crud->display_as('nombre_area_enfoque', 'Nombre');
            $crud->display_as('id_modalidad', 'Rama modalidad');
            $crud->display_as('id_area_enfoque', '# area enfoque');
            $crud->change_field_type('activo', 'true_false', array(0 => 'No', 1 => 'Si'));

            $crud->unset_read();
            $crud->unset_export();
            $data_view['output'] = $crud->render();
    
            $vista = $this->load->view('catalogo/admin.tpl.php', $data_view, true);
            $this->template->setMainContent($vista);
            $this->template->getTemplate();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function modalidad_columna($value,$row)
    {
        $rama = $this->catalogo->get_rama_modalidad($row->id_modalidad)[0];
        $str = $rama['nombre_tipo_actividad'] . " -> " . $rama['nombre_modalidad'];
        return $str;
    }

    public function select_requerido($str)
    {
        return $str != '';
    }

    public function modalidad_opciones()
    {
        $res = $this->catalogo->get_rama_modalidad();
        $opciones = array();

        foreach ($res as $key => $value) {
            $opciones[$value['id_modalidad']] = $value['nombre_tipo_actividad'] . " -> " . $value['nombre_modalidad'];
        }

        return $opciones;
    }

    public function modalidad_add_fields()
    {
        $opciones = $this->modalidad_opciones();
        return $this->form_complete->create_element(
                    array(
                        'id' => 'id_modalidad',
                        'type' => 'dropdown',
                        'first' => array('' => 'Selecciona una opción'),
                        'options' => $opciones,
                        'attributes' => array(
                                'class' => 'form-control'
                            )
                    )
                );

    }

    public function modalidad_edit_fields($value,$pk)
    {
        $opciones = $this->modalidad_opciones();
        return $this->form_complete->create_element(
                    array(
                        'id' => 'id_modalidad',
                        'type' => 'dropdown',
                        'first' => array('' => 'Selecciona una opción'),
                        'options' => $opciones,
                        'value' => $value,
                        'attributes' => array(
                                'class' => 'form-control'
                            )
                    )
                );

    }


    public function tipo_curso()
    {
        try{
            $data_view = array();

            $this->db->schema = 'catalogo';
            $crud = $this->new_crud();
            $crud->set_table('tipo_curso');
            $crud->set_subject('tipo de curso');
            $crud->set_primary_key('id_tipo_curso');

            $crud->columns( 'id_tipo_curso', 'clave', 'nombre_tipo_curso','id_area_enfoque', 'id_proceso_educativo', 'activo');
            $crud->callback_column('id_area_enfoque',array($this,'area_enfoque_columna'));
            $crud->callback_column('id_proceso_educativo',array($this,'proceso_educativo_columna'));
            
            $crud->add_fields('clave','nombre_tipo_curso','id_area_enfoque','id_proceso_educativo');
            $crud->callback_add_field('id_area_enfoque',array($this,'area_enfoque_add_fields'));
            $crud->callback_add_field('id_proceso_educativo',array($this,'proceso_educativo_add_fields'));
            
            $crud->edit_fields('clave','nombre_tipo_curso','id_area_enfoque','id_proceso_educativo','activo');
            $crud->callback_edit_field('id_area_enfoque',array($this,'area_enfoque_edit_fields'));
            $crud->callback_edit_field('id_proceso_educativo',array($this,'proceso_educativo_edit_fields'));
            

            $crud->required_fields('clave','nombre_tipo_curso');
            $crud->set_rules('id_proceso_educativo', 'Proceso educativo', 'callback_select_requerido');
            $crud->set_rules('id_area_enfoque', 'Área de enfoque', 'callback_select_requerido');
            
            $crud->display_as('id_tipo_curso','# tipo de curso');
            $crud->display_as('nombre_tipo_curso', 'Nombre');
            $crud->display_as('id_proceso_educativo', 'Proceso educativo');
            $crud->display_as('id_area_enfoque', 'Rama área de enfoque');
            $crud->change_field_type('activo', 'true_false', array(0 => 'No', 1 => 'Si'));
            
            $crud->unset_read();
            $crud->unset_export();
            $data_view['output'] = $crud->render();
    
            $vista = $this->load->view('catalogo/admin.tpl.php', $data_view, true);
            $this->template->setMainContent($vista);
            $this->template->getTemplate();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
        
    }


    public function proceso_educativo_columna($value,$row)
    {
        $pe = $row->id_proceso_educativo;
        $res = $this->catalogo->get_proceso_educativo(array('id_proceso_educativo'=>$pe))[0];
        $str = $res['nombre_proceso_educ'];
        return $str;
    }


    public function area_enfoque_columna($value,$row)
    {
        $rama = $this->catalogo->get_rama_area_enfoque($row->id_area_enfoque)[0];
        $str = $rama['nombre_tipo_actividad'] . " -> " . $rama['nombre_modalidad']. " -> " . $rama['nombre_area_enfoque'];
        return $str;
    }


    public function area_enfoque_opciones()
    {
        $res = $this->catalogo->get_rama_area_enfoque();
        $opciones = array();

        foreach ($res as $key => $value) {
            $opciones[$value['id_area_enfoque']] = $value['nombre_tipo_actividad'] . " -> " . $value['nombre_modalidad'] . " -> " . $value['nombre_area_enfoque'];
        }
        return $opciones;
    }


    public function proceso_educativo_opciones()
    {
        $res = $this->catalogo->get_proceso_educativo();
        $opciones = array();

        foreach ($res as $key => $value) {
            $opciones[$value['id_proceso_educativo']] = $value['nombre_proceso_educ'];
        }
        return $opciones;
    }

    public function proceso_educativo_add_fields()
    {
       
        $opciones = $this->proceso_educativo_opciones();
        return $this->form_complete->create_element(
                    array(
                        'id' => 'id_proceso_educativo',
                        'type' => 'dropdown',
                        'first' => array('' => 'Selecciona una opción'),
                        'options' => $opciones,
                        'attributes' => array(
                                'class' => 'form-control'
                            )
                    )
                );

    }

    public function proceso_educativo_edit_fields($value,$pk)
    {
        $opciones = $this->proceso_educativo_opciones();
        return $this->form_complete->create_element(
                    array(
                        'id' => 'id_proceso_educativo',
                        'type' => 'dropdown',
                        'first' => array('' => 'Selecciona una opción'),
                        'options' => $opciones,
                        'value' => $value,
                        'attributes' => array(
                                'class' => 'form-control'
                            )
                    )
                );

    }

    public function area_enfoque_add_fields()
    {
       
        $opciones = $this->area_enfoque_opciones();
        return $this->form_complete->create_element(
                    array(
                        'id' => 'id_area_enfoque',
                        'type' => 'dropdown',
                        'first' => array('' => 'Selecciona una opción'),
                        'options' => $opciones,
                        'attributes' => array(
                                'class' => 'form-control'
                            )
                    )
                );

    }

    public function area_enfoque_edit_fields($value,$pk)
    {
        $opciones = $this->area_enfoque_opciones();
        return $this->form_complete->create_element(
                    array(
                        'id' => 'id_area_enfoque',
                        'type' => 'dropdown',
                        'first' => array('' => 'Selecciona una opción'),
                        'options' => $opciones,
                        'value' => $value,
                        'attributes' => array(
                                'class' => 'form-control'
                            )
                    )
                );

    }

    public function curso()
    {
        try{
            $data_view = array();

            $this->db->schema = 'catalogo';
            $crud = $this->new_crud();
            $crud->set_table('curso');
            $crud->set_subject('curso');
            $crud->set_primary_key('clave_curso');
            $crud->set_relation('clave_division','division','nombre_division');

            $crud->columns( 'clave_curso', 'nombre_curso','clave_division', 'id_tipo_curso','activo');
            $crud->callback_column('id_tipo_curso',array($this,'tipo_curso_columna'));

            $crud->add_fields( 'clave_curso', 'nombre_curso','clave_principal','clave_division', 'id_tipo_curso','fecha_inicio','fecha_fin');
            $crud->callback_add_field('id_tipo_curso',array($this,'tipo_curso_add_fields'));
            
            $crud->edit_fields( 'clave_curso', 'nombre_curso','clave_principal','clave_division', 'id_tipo_curso','fecha_inicio','fecha_fin','activo');
            $crud->callback_edit_field('id_tipo_curso',array($this,'tipo_curso_edit_fields'));

            $crud->required_fields('clave_curso','nombre_curso','clave_division');
            $crud->set_rules('id_tipo_curso', 'Tipo curso', 'callback_select_requerido');
            
            $crud->display_as('clave_curso', 'Clave');
            $crud->display_as('nombre_curso', 'Nombre');
            $crud->display_as('clave_division', 'División');
            $crud->display_as('id_tipo_curso', 'Rama tipo de curso');
            $crud->change_field_type('activo', 'true_false', array(0 => 'No', 1 => 'Si'));

            $crud->unset_export();
            $data_view['output'] = $crud->render();
    
            $vista = $this->load->view('catalogo/admin.tpl.php', $data_view, true);
            $this->template->setMainContent($vista);
            $this->template->getTemplate();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function tipo_curso_columna($value,$row)
    {
        $rama = $this->catalogo->get_rama_tipo_curso($row->id_tipo_curso)[0];
        $str = $rama['nombre_tipo_actividad'] . " -> " . $rama['nombre_modalidad'] . " -> " . $rama['nombre_area_enfoque'] . " -> " . $rama['nombre_tipo_curso'];
        return $str;
    }
    
    public function tipo_curso_opciones()
    {
        $res = $this->catalogo->get_rama_tipo_curso();
        $opciones = array();

        foreach ($res as $key => $value) {
            $opciones[$value['id_tipo_curso']] = $value['nombre_tipo_actividad'] . " -> " . $value['nombre_modalidad'] . " -> " . $value['nombre_area_enfoque'] . " -> " . $value['nombre_tipo_curso'];
        }

        return $opciones;
    }

    public function tipo_curso_add_fields()
    {
        $opciones = $this->tipo_curso_opciones();
        return $this->form_complete->create_element(
                    array(
                        'id' => 'id_tipo_curso',
                        'type' => 'dropdown',
                        'first' => array('' => 'Selecciona una opción'),
                        'options' => $opciones,
                        'attributes' => array(
                                'class' => 'form-control'
                            )
                    )
                );

    }

    public function tipo_curso_edit_fields($value,$pk)
    {
        $opciones = $this->tipo_curso_opciones();
        return $this->form_complete->create_element(
                    array(
                        'id' => 'id_tipo_curso',
                        'type' => 'dropdown',
                        'first' => array('' => 'Selecciona una opción'),
                        'options' => $opciones,
                        'value' => $value,
                        'attributes' => array(
                                'class' => 'form-control'
                            )
                    )
                );

    }

    public function rol_tipo_curso()
    {
        try{
            $data_view = array();

            $this->db->schema = 'catalogo';
            $crud = $this->new_crud();
            $crud->set_table('rol_tipo_curso');
            $crud->set_subject('rol por tipo de curso');
            $crud->set_primary_key('id_rol_tipo_curso');
            $crud->set_relation('id_rol','rol','nombre_rol');

            $crud->columns( 'id_rol_tipo_curso', 'id_rol','id_tipo_curso');
            $crud->callback_column('id_tipo_curso',array($this,'tipo_curso_columna'));

            $crud->fields('id_rol','id_tipo_curso');
            $crud->callback_add_field('id_tipo_curso',array($this,'tipo_curso_add_fields'));
            $crud->callback_edit_field('id_tipo_curso',array($this,'tipo_curso_edit_fields'));

            $crud->required_fields('id_rol');
            $crud->set_rules('id_tipo_curso', 'Tipo curso', 'callback_select_requerido');
            
            $crud->display_as('id_rol_tipo_curso', '#');
            $crud->display_as('id_rol', 'Nombre');
            $crud->display_as('id_tipo_curso', 'Rama tipo de curso');

            $crud->unset_read();
            $crud->unset_export();
            $data_view['output'] = $crud->render();
    
            $vista = $this->load->view('catalogo/admin.tpl.php', $data_view, true);
            $this->template->setMainContent($vista);
            $this->template->getTemplate();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }


    public function rol()
    {
        try{
            $data_view = array();

            $this->db->schema = 'catalogo';
            $crud = $this->new_crud();
            $crud->set_table('rol');
            $crud->set_subject('rol');
            $crud->set_primary_key('id_rol');

            $crud->columns( 'id_rol', 'nombre_rol');

            $crud->fields('nombre_rol');

            $crud->required_fields('nombre_rol');
            
            $crud->display_as('id_rol', '#');
            $crud->display_as('nombre_rol', 'Nombre');

            $crud->unset_read();
            $crud->unset_export();
            $data_view['output'] = $crud->render();
    
            $vista = $this->load->view('catalogo/admin.tpl.php', $data_view, true);
            $this->template->setMainContent($vista);
            $this->template->getTemplate();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function tipo_actividad()
    {
        try{
            $data_view = array();

            $this->db->schema = 'catalogo';
            $crud = $this->new_crud();
            $crud->set_table('tipo_actividad');
            $crud->set_subject('tipo de actividad');
            $crud->set_primary_key('id_tipo_actividad');

            $crud->columns( 'id_tipo_actividad', 'nombre_tipo_actividad', 'activo');
            $crud->add_fields('nombre_tipo_actividad');
            $crud->edit_fields('nombre_tipo_actividad','activo');

            $crud->required_fields('nombre_tipo_actividad');
            
            $crud->display_as('id_tipo_actividad', '#');
            $crud->display_as('nombre_tipo_actividad', 'Nombre');
            $crud->change_field_type('activo', 'true_false', array(0 => 'No', 1 => 'Si'));

            $crud->unset_read();
            $crud->unset_export();
            $data_view['output'] = $crud->render();
    
            $vista = $this->load->view('catalogo/admin.tpl.php', $data_view, true);
            $this->template->setMainContent($vista);
            $this->template->getTemplate();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function modalidad()
    {
        try{
            $data_view = array();

            $this->db->schema = 'catalogo';
            $crud = $this->new_crud();
            $crud->set_table('modalidad');
            $crud->set_subject('modalidad');
            $crud->set_primary_key('id_modalidad');
            $crud->set_relation('id_tipo_actividad','tipo_actividad','nombre_tipo_actividad');

            $crud->columns( 'id_modalidad', 'clave_modalidad','nombre_modalidad', 'id_tipo_actividad','descripcion');
            $crud->add_fields('clave_modalidad', 'nombre_modalidad', 'id_tipo_actividad', 'descripcion');
            $crud->edit_fields('clave_modalidad', 'nombre_modalidad', 'id_tipo_actividad', 'descripcion','activo');

            $crud->required_fields('clave_modalidad','nombre_modalidad','id_tipo_actividad');
            
            $crud->unset_texteditor('descripcion','full_text');

            $crud->display_as('id_modalidad', '#');
            $crud->display_as('clave_modalidad', 'Clave');
            $crud->display_as('nombre_modalidad', 'Nombre');
            $crud->display_as('descripcion', 'Descripción');
            $crud->display_as('id_tipo_actividad','Tipo de actividad');

            $crud->unset_read();
            $crud->unset_export();
            $data_view['output'] = $crud->render();
    
            $vista = $this->load->view('catalogo/admin.tpl.php', $data_view, true);
            $this->template->setMainContent($vista);
            $this->template->getTemplate();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
    
}
?>