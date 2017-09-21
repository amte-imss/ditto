<?php
/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
?>
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.js"></script>
<?php 
echo js("rama_organica/rama_organica.js");
?>
hola

<div id="page-inner">
    <div id="sipimss_sede"></div>
    <div id="sipimss_sede1"></div>
</div>
<script type="text/javascript">

    $(function () {
        $('#sipimss_sede').localizador_sedes({
            seleccion: 'checkbox',
            agrupacion: true,
            anio: 2017,
            tipo_unidad: true,
            nivel_atencion: 1,             
            columnas: ['region', 'delegacion', 'cve_unidad', 'nombre_unidad']
        });
        $('#sipimss_sede1').localizador_sedes({            
            seleccion: 'radio', 
            mostrar_nivel_atencion: 0
        });       
    });

</script>