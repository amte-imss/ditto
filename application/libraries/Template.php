<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Clase que contiene métodos para la carga de la plantilla base del sistema y creación de la paginación
 * @version 	: 1.1.0
 * @author 	: LEAS
 * @property    : mixed[] Data arreglo de datos de plantilla con la siguisnte estructura array("title"=>null,"nav"=>null,"main_title"=>null,"main_content"=>null);
 * */
class Template {

    private $elements;
    private $element_seccion;
    private $comprobante;
    private $elements_comprobante;
    private $elements_modal;
    var $lang;
    var $lang_text;
    var $multiligual;
    private $datos_imagen_perfil;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('html');
        $this->CI->load->helper('menu_helper');
        $this->lang = "spanish";
        $this->new_tpl = FALSE;
        $this->lang_text = array();
        $this->element_seccion = array(
            "seccion" => null,
            "formulario" => null,
            "tabla" => null,
            "tabla_tpl" => NULL,
            "titulo_seccion" => null,
            "titulo_form" => null,
            "rutas_js" => null,
            "boton_agregar" => null,
            "boton_cancelar" => null,
            "boton_submit" => null, //Guardar u actalizar
            "ruta_accion_boton_agregar" => null,
            "ruta_controller" => null,
        );
        $this->elements = array(
            "title" => null, //Titulo de de la sección
            "menu" => null, //Pinta todo el cuerpo del menú en el template
            "main_title" => null, //Pinta un titulo, el titulo del "main_content", puede o no existir
            "sub_title" => null, //Pinta un subtitulo, el sub_titulo del "main_content", puede o no existir
            "descripcion" => null, //
            "main_content" => null, //contenido del template, información relevante de la sección en cuestion
            "css_files" => null, //Carga rutas de archivos css que se llamarán al pintar el formulario de core
            "js_files" => null, //Carga rutas de archivos js que se llmaran al pintar el formulario de core
            "css_script" => null,
            "cuerpo_modal" => null,
            "blank" => null,
        );

        $this->comprobante = null;
        $this->elements_comprobante = array(
            "folio" => null, //Folio del comprobante (alfa numérico)
            "nombre_comprobante" => null, //Nombre del comprobante en el sistema
            "ruta" => null, //Ruta de acceso al archivo
            "id_file" => null, //Identificador del archivo en la base de datos
            "nombre_extencion" => null, //Extención del archivo
            "is_carga_sistema" => null, //Indica que el comprobante fue cargado por sistema (de ser así,  no podrá ser modificado),
            "id_validacion_registro" => null, //Indica el estado de la validación del registro, si el registro ya fue evaluado por profesionalización, no podrá ser modificado
        );
        $this->elements_modal = array(
            "modal_titulo" => null, //Titulo del modal
            "modal_cuerpo" => null, //Cuerpo del modal, contenido reelevante
            "modal_pie" => null, //Píe del modal, normalmente se usa para disponer de un botón de cerrar y/o botones de guardado u actualización de algun formulario
        );
        $this->set_Boton_cancelar();
    }

    /**
     * @author LEAS
     * @fecha 08/05/2017
     * @param type $boton Vista de botón con todas las acciones ya definidas
     * @param type String Ruta de la vista template del botón que cancela la acción de editar
     * o guardar un nuevo registro del censo en cualquiera de las secciones
     * @descripcion Asigna a elementos_seccion el atributo "boton_cancear" que cancela y cierra la vista
     * de un formulario de sección en su estado de edición o guardado
     *      */
    public function set_Boton_cancelar($parametros = null, $tpl = 'tc_template/btn_cancelar_nueva_actividad') {
        if (is_null($parametros)) {
            $string_value = get_elementos_lenguaje(array(En_catalogo_textos::GENERAL));
            $parametros['titulo'] = $string_value['cancelar'];
        }
        $this->element_seccion['boton_cancelar'] = $this->CI->load->view($tpl, $parametros, TRUE);
    }

    /**
     * @author LEAS
     * @fecha 08/05/2017
     * @param type $parametros Vista de botón con todas las acciones ya definidas para guardar
     * nuevo registro del censo, contiene los siguientes argumentos
     * Array(
     *      [id_censo] => 1
     *      [formulario] => 1
     * );
     * @descripcion Asigna a elementos_seccion el atributo "boton_guardar" que guarda la vista
     * del botón guardar cualquier información de formuario de censo
     */
    public function set_boton_guardar($parametros = null, $tpl = 'tc_template/btn_guardar_editar_actividad') {
//        pr($parametros);
        $this->element_seccion['boton_submit'] = $this->CI->load->view($tpl, $parametros, TRUE);
//        pr($this->element_seccion['boton_submit']);
    }

    /**
     * @author LEAS
     * @fecha 31/05/2017
     * @Descripcion Obtiene la vista del botón
     */
    public function get_boton_guardar() {
        return $this->element_seccion['boton_submit'];
    }

    /**
     * @author LEAS
     * @fecha 08/05/2017
     * @param type $boton Vista de botón con todas las acciones ya definidas para ejecutar el primer
     * elemento del arbol que lleve a una sección de registros de actividades del docente
     * @descripcion Asigna a elementos_seccion el atributo "boton_agregar nuevo registro" el cual dispara el
     * llamado al primer elemento hijo de una seccion (secciónes Actividad docente, Formación, Becas, Investigación,
     * Dirección de tesis, Comisiones, Material educativo), es decir, los "elementos_seccion" hijos.
     */
    public function setBotonAgregar($boton) {
        $this->element_seccion['boton_agregar'] = $boton;
    }

    /**
     * @author LEAS
     * @fecha 8/05/2017
     * @return type String
     * @Descripcion Obtiene la vista del componente comprobante y folio del registro censo
     */
    public function get_comprobante() {
        return $this->comprobante;
    }

    /**
     *
     * @author LEAS
     * @param type Array $elementos_comprobante
     * @param type String $tpl template que genera la vista del componente comprobante y folio
     * con los siguiente estructura
     * Array(
      [id_censo] => 108
      [is_carga_sistema] =>
      [folio] => 5g7k8h9l
      [id_file] => 108
      [nombre_comprobante] => 3342165412_1495119429
      [ruta] => /assets/us/uploads/3342165412/
      [nombre_extencion] => pdf
      [id_validacion_registro] => 1
      [nombre_validacion] => Registro usuario
     * actividad del docente en el modulo registro de censo
     * @descripcion Genera y asigna a la variable "elements_comprobante" la vista del componente
     * comprobante y folio del registro del censo
     */
    public function set_comprobante($elementos_comprobante = null, $tpl = 'tc_template/formulario_carga_archivo') {
        if (!is_null($elementos_comprobante)) {//Valida que exista el elemento comprobante
            $this->elements_comprobante = $elementos_comprobante;
        }
        $this->comprobante = $this->CI->load->view($tpl, $this->elements_comprobante, TRUE);
    }

    /**
     * @author LEAS
     * @fecha 08/05/2017
     * @param Array type $parametros parametros de configuración del botón que inicia
     * el árbol de secciones
     * Array(
     *      [titulo] => Agregar
     *      [nombre_boton] => btn_agregar
     *      [tipo_evento_js] => onclick
     *      [funcion_js] => carga_hijo_seccion(this)
     *      [seccion] => 2
     * );
     * @param type $tpl
     * @param type String $ruta_accion_js
     */
    public function setBotonAgregarGeneral($parametros, $tpl = 'tc_template/btn_agregar_nueva_actividad', $ruta_accion_js = "assets/js/docente/template_docente.js") {
//        pr($parametros);
        $this->element_seccion['boton_agregar'] = $this->CI->load->view($tpl, $parametros, TRUE);
        $this->element_seccion['ruta_accion_boton_agregar'] = $ruta_accion_js;
    }

    /**
     * @author: LEAS
     * @fecha: 08/05/2017
     * @return type Array con los parametros basicos para generar botón de
     * agregar un nuevo registro de la sección, es decir, m
     *
     */

    /**
     * @author LEAS
     * @fecha 08/05/2017
     * @param type $boton Vista de botón con todas las acciones ya definidas para ejecutar el primer
     * elemento del arbol que lleve a una sección de registros de actividades del docente
     * @descripcion Asigna a elementos_seccion el atributo "boton_agregar nuevo registro" el cual dispara el
     * llamado al primer elemento hijo de una seccion (secciónes Actividad docente, Formación, Becas, Investigación,
     * Dirección de tesis, Comisiones, Material educativo), es decir, los "elementos_seccion" hijos.
     */
    public function getParametrorBoton() {
        return array(
            'titulo' => 'Agregar',
            'nombre_boton' => 'btn_agregar',
            'tipo_evento_js' => 'onclick',
            'funcion_js' => 'carga_hijo_seccion(this)',
            'seccion' => null,
        );
    }

    /*
     * @method: array setFormularioSecciones()
     * @param: $elementos_seccion elementos que definen la estructura de una secccion,
     * (rutas, data_table, boton de cancelar guardado etc) con la siguiente estructura del array
     * array(
     *         "seccion" => null,
     *         "formulario" => null,
     *         "tabla" => null,
     *         "tabla_tpl" => NULL,
     *         "titulo_seccion" => null,
     *         "titulo_form" => null,
     *         "rutas_js" => null,
     *         "boton_agregar" => null,
     *         "boton_cancelar" => null,
     *         "boton_submit" => null, //Guardar u actalizar
     *         "ruta_accion_boton_agregar" => null,
     *         "ruta_controller" => null,
     *     )
     * @descripcion:Genera la vista de la sección en cuestión(datatable, agregar nuevo registro) y
     * lo asigna a la propiedad "main_content" (cuerpo del template)
     */

    public function setFormularioSecciones($elementos_seccion, $tpl = 'tc_template/secciones.tpl.php') {
        //  $this->elementos_seccion = $elementos_seccion;
//        pr($elementos_seccion);
        foreach ($elementos_seccion as $key => $value) {
            $this->element_seccion[$key] = $value;
        }
//        pr($this->elementos_seccion['componente_comprobante']);
        //  pr ($this->elementos_seccion);
        $this->elements["main_content"] = $this->CI->load->view($tpl, $this->element_seccion, TRUE);
    }

    /* Retorna el atributo elements_sección
     * @author LEAS
     * @return: mixed[] Data arreglo de datos de plantilla con la siguiente estructura array("title"=>null,"nav"=>null,"main_title"=>null,"main_content"=>null);
     */

    function get_elements_seccion() {
        return $this->element_seccion;
    }

    /**
     *
     * @author LEAS
     * @param type $key
     * @param type $dato
     */
    function add_elements_seccion($key, $dato) {
        $this->element_seccion[$key] = $dato;
    }

    /* Retorna el atributo elements
     * @method: array getData()
     * @return: mixed[] Data arreglo de datos de plantilla con la siguiente estructura array("title"=>null,"nav"=>null,"main_title"=>null,"main_content"=>null);
     */

    function getElements() {
        return $this->elements;
    }

    /* regresa en pantalla el contenido de la plantilla
     * @method: array getData()
     * @return: mixed[] Data arreglo de datos de plantilla con la siguisnte estructura array("title"=>null,"nav"=>null,"main_title"=>null,"main_content"=>null);
     */

    function getTemplate($tipo = FALSE, $tpl = 'tc_template/index.tpl.php') {
        if ($this->multiligual) {
            $this->CI->lang->load('interface', $this->lang);
            $this->elements["string_tpl"] = $this->CI->lang->line('interface_tpl');
            // pr($this->elements);
        }
        if (empty($this->elements["menu"])) {//Genera menú vacio
            $menu_data['datos_imagen'] = $this->get_datos_imagen_perfil(); //Agrega datos de la imagen para el menu
            $this->setNav($menu_data);
        }
        if ($tipo) {
            $this->CI->load->view($tpl, $this->elements, TRUE);
        }
        $this->CI->load->view($tpl, $this->elements);
    }

    /**
     * Método que carga datos en la plantilla base del sistema
     * @author 		: Jesús Díaz P.
     * @modified 	: Miguel Guagnelli
     * @access 		: public
     * @method:     : void
     * @param 		: mixed[] $elements Elementos configurables en la plantilla
     */
    public function setTemplate($elements = array()) {
        $this->elements['title'] = (array_key_exists('title', $elements)) ? $elements['title'] : null;
        $this->elements['menu'] = $this->templete_menu(); //(array_key_exists('menu', $elements)) ? $elements['menu'] : null;
        $this->elements['main_title'] = (array_key_exists('main_title', $elements)) ? $elements['main_title'] : null;
        $this->elements['sub_title'] = (array_key_exists('sub_title', $elements)) ? $elements['sub_title'] : null;
        $this->elements['descipcion'] = (array_key_exists('descipcion', $elements)) ? $elements['descipcion'] : null;
        $this->elements['blank'] = (array_key_exists('blank', $elements)) ? $elements['blank'] : null;
        $this->elements['main_content'] = (array_key_exists('main_content', $elements)) ? $elements['main_content'] : null;
        $this->elements['css_files'] = (array_key_exists('css_files', $elements)) ? $elements['css_files'] : null;
        $this->elements['js_files'] = (array_key_exists('js_files', $elements)) ? $elements['js_files'] : null;
        $this->elements['css_script'] = (array_key_exists('css_script', $elements)) ? $elements['css_script'] : null;
        $this->elements['myModal'] = (array_key_exists('myModal', $elements)) ? $elements['myModal'] : null;
    }

    /*
     * Asigna valores a la propiedad Titulo de la plantilla
     * @author  : Miguel Guagnelli
     * @method  : void setTitle($title)
     * @access  : public
     * @param   : string $title Es el título de la pestaña de la plantilla.
     */

    function setTitle($title = null) {
        $this->elements["title"] = $title;
    }

    /*
     * Asigna la propiedad de opciones de menú de la plantilla
     * @author  : CAQZ
     * @method  : void setNav($nav)
     * @access  : public
     * @param   : mixed[] $nav Arreglo compuesto de n elementos con la sig estructura array("link"=>"","titulo"=>"","attribs"=>array())",
     */

    function setNav($menu = NULL) {
        //$vista_menu = $this->CI->load->view('tc_template/menu.tpl.php', $menu, TRUE);

        //$this->elements["menu"] = $vista_menu;
        $this->elements["menu"] = $menu;
    }

    /*
     * Asigna la propiedad de título de la sección en la plantilla
     * @author  : Miguel Guagnelli
     * @method: void setMainTitle($main_title)
     * @param: string $main_title Titulo de la sección en la que se encuentra el usuario
     */

    function setMainTitle($main_title = null) {
        $this->elements["main_title"] = $main_title;
    }

    /*
     * Asigna la propiedad de contenido principal en la plantilla
     * @author  : Miguel Guagnelli
     * @method: void setMainContent($main_content)
     * @param: string $main_content Contenido principal de la plantill
     */

    function setMainContent($main_content = null, $options = null, $isProcesed = true) {
        if ($isProcesed) {
            $this->elements["main_content"] = $main_content;
            return true;
        }

        if (!is_null($main_content)) {
            $this->elements["main_content"] = $this->CI->load->view($main_content, $options, true);
            return true;
        } else {
            return false;
        }
    }

    /*
     * Asigna la propiedad de pie_modal de la sección en la plantilla de modal
     * @author  : LEAS
     * @fecha 15/05/2017
     * @method: void setMainTitle($cuerpo_modal)
     * @param: string $pie código HTML del modal, botones u texto simplemente
     * @Descripcion: Asigana a la variable elements_modal["modal_pie"] texto o código html del modal
     */

    function set_pie_modal($pie = '') {
        $this->elements_modal["modal_pie"] = $pie;
    }

    /*
     * Asigna la propiedad de cuerpo_modal de la sección en la plantilla
     * @author  : LEAS
     * @method: void setMainTitle($cuerpo_modal)
     * @param: String $titulo titulo del modal
     * @descripcion: Asigna un titulo al modal
     */

    function set_titulo_modal($titulo = '') {
        $this->elements_modal["modal_titulo"] = $titulo;
    }

    /*
     * Asigna la propiedad de cuerpo_modal de la sección en la plantilla
     * @author  : LEAS
     * @method: void setMainTitle($cuerpo_modal)
     * @param: string $cuerpo cuerpo del modal HTML
     * @descripcion: Asigna el cuerpo del modal HTML para definir modal
     */

    function set_cuerpo_modal($cuerpo = '') {
        $this->elements_modal["modal_cuerpo"] = $cuerpo;
    }

    /**
     *
     * @author  : LEAS
     * @fecha 15/05/2017
     * @param type $tpl ruta del template modal
     * @descripcion: pinta el esquema Html del modal dividido en las secciones
     * de ttulo, cuerpo y píe
     */
    function get_modal($tpl = 'tc_template/modal/modal_template') {
        $this->CI->load->view($tpl, $this->elements_modal, FALSE);
    }

    private function get_datos_imagen_perfil() {
        return $this->datos_imagen_perfil;
    }

    /**
     *
     * @param type $id_docente
     * @descripcion: Consulta información del docente al modelo "Docente_model"
     * y asigna a la variable "datos_imagen_perfil" en type array las
     * siguiente estructura:
     *  Array
     *  (
     *      [id_file] => 113
     *      [nombre_fisico] => 311091488_1495824833
     *      [ruta] => /assets/us/perfil/311091488/
     *      [extencion] => jpg
     *      [nombre_docente] => DIANNA PATRICIA ANGELES GUALITO
     *      [matricula] => 311091488
     *  )
     */
    function set_datos_imagen_perfil($imagen_perfil) {
        /* Cargar imagen de perfil */
        $this->datos_imagen_perfil = $imagen_perfil; //Obtener imagen del docente
    }

    /**
     * Método que crea links de paginación y mensaje sobre registros mostrados
     * @autor 		: Jesús Díaz P.
     * @modified 	:
     * @access 		: public
     * @param 		: mixed[] $pagination_data Parámetros usados para generar las ligas
     * @return 		: midex[] links -> Ligas para la paginación
     * 						total -> Mensaje sobre registros mostrados
     */
    function pagination_data($pagination_data) {
        $this->CI->load->library(array('pagination', 'table'));
        $config['base_url'] = (array_key_exists('controller', $pagination_data) && array_key_exists('action', $pagination_data)) ? site_url(array($pagination_data['controller'], $pagination_data['action'])) : site_url(array('buscador', 'get_data_ajax')); //Path que se utilizará en la generación de los links
        $config['total_rows'] = $pagination_data['total']; //Número total de registros
        $config['per_page'] = $pagination_data['per_page']; //Sobreescribir número de registros a mostrar
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="disabled"><span><strong>';
        $config['cur_tag_close'] = '</strong></span></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->CI->pagination->initialize($config);

        return array('links' => "<div class='dataTables_paginate paging_simple_numbers  pull-right'>" . $this->CI->pagination->create_links() . "</div>",
            'total' => "Mostrando " . ($pagination_data['current_row'] + 1) . " a " . ((($pagination_data['current_row'] + $config['per_page']) > $pagination_data['total']) ? $pagination_data['total'] : $pagination_data['current_row'] + $config['per_page']) . " de " . $pagination_data['total']
        );
    }

}
