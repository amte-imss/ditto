<?php
$actividad_docente = array(
    0 => array('name_act' => 'Actividad docente','ruta'=>'index.php/actividad_docente', 'icono'=>'fa fa-calendar'),
    1 => array('name_act' => 'Formación docente','ruta'=>'index.php/formacion_docente', 'icono'=>'fa fa-graduation-cap'),
    2 => array('name_act' => 'Becas y comisiones laborales','ruta'=>'index.php/becas_laborales','icono'=>'fa fa-book'),
    3 => array('name_act' => 'Dirección de tesis','ruta'=>'index.php/direccion_tesis','icono'=>'fa fa-bar-chart-o'),
    3 => array('name_act' => 'Comisiones acádemicas','ruta'=>'index.php/direccion_tesis','icono'=>'fa fa-tasks'),
    4 => array('name_act' => 'Material educativo','ruta'=>'index.php/mat_edu_escrito','icono'=>'fa fa-bar-chart-o'),
    5 => array('name_act' => 'Investigación', 'ruta'=>'index.php/investigacion','icono'=>'fa fa-th'),
);
?>
<div id="sidebar"  class="nav-collapse ">
    <ul class="sidebar-menu" id="nav-accordion">

        <p class="centered"><a href="profile.html"><img src="<?php echo base_url(); ?>assets/img/template_sipimss/ui-zac.jpg" class="img-circle" width="70"></a></p>
        <h5 class="centered">Mario Lopez</h5>

        <li class="mt">
            <a class="active" href="<?php echo base_url(); ?>views/docente/actividad_docente/perfil_usuario.php">
                <i class="fa fa-user-md"></i>
                <span>Perfil</span>
            </a>
        </li>

        <li class="sub-menu">
            <a href="javascript:;" >
                <i class="fa fa-graduation-cap"></i>
                <span>Formación</span>
            </a>
            <ul class="sub">
                <!-- <li><a  href="general.html">General</a></li>
                <li><a  href="buttons.html">Buttons</a></li>
                <li><a  href="panels.html">Panels</a></li> -->
            </ul>
        </li>

        <li class="sub-menu">
            <a href="javascript:;" >
                <i class="fa fa-calendar"></i>
                <span>Actividad docente</span>
            </a>
            <ul class="sub">
                <li><a  href="<?php echo base_url('index.php/') . 'actividad_docente'; ?>">Calendar</a></li>
                <li><a  href="gallery.html">Gallery</a></li>
                <li><a  href="todo_list.html">Todo List</a></li>
            </ul>
        </li>
        <li class="sub-menu">
            <a href="javascript:;" >
                <i class="fa fa-book"></i>
                <span>Becas y comisiones</span>
            </a>
            <ul class="sub">
                <li><a  href="blank.html">Blank Page</a></li>
                <li><a  href="login.html">Login</a></li>
                <li><a  href="lock_screen.html">Lock Screen</a></li>
            </ul>
        </li>
        <li class="sub-menu">
            <a href="javascript:;" >
                <i class="fa fa-tasks"></i>
                <span>Comisiones académicas</span>
            </a>
            <ul class="sub">
                <li><a  href="form_component.html">Form Components</a></li>
            </ul>
        </li>
        <li class="sub-menu">
            <a href="javascript:;" >
                <i class="fa fa-th"></i>
                <span>Investigación</span>
            </a>
            <ul class="sub">
                <li><a  href="basic_table.html">Basic Table</a></li>
                <li><a  href="responsive_table.html">Responsive Table</a></li>
            </ul>
        </li>
        <li class="sub-menu">
            <a href="javascript:;" >
                <i class=" fa fa-bar-chart-o"></i>
                <span>Direccion de tésis</span>
            </a>
            <ul class="sub">
                <li><a  href="morris.html">Morris</a></li>
                <li><a  href="chartjs.html">Chartjs</a></li>
            </ul>
        </li>
        <li class="sub-menu">
            <a href="javascript:;" >
                <i class="fa fa-bar-chart-o"></i>
                <span>Material educativo</span>
            </a>
            <ul class="sub">
                <li><a  href="morris.html">Morris</a></li>
                <li><a  href="chartjs.html">Chartjs</a></li>
            </ul>
        </li>


    </ul>
</div>
