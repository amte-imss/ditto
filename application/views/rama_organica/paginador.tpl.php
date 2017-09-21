<?php
/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
//pr($config);
$h = (isset($height)) ? $height : '400px';
$w = (isset($width)) ? $width : '100%';
$element = (isset($id_form)) ? $id_form . $config['data_index'] : 'form_rama_organica' . $config['data_index'];
?>
<script type="text/javascript">

    var rama_datos = <?php echo json_encode($datos); ?>;
    var rama_campos = <?php echo json_encode($campos); ?>;
<?php
//pr($datos);
if (isset($config['config']['configuraciones']['seleccion']) && $config['config']['configuraciones']['seleccion'] == 'radio')
{
    ?>

        rama_campos.push({name: 'clave_unidad', title: 'Seleccionado', align: "center", itemTemplate: function (value, item) {
                return $("<input>").attr("type", "radio")
                        .attr("checked", item.Checked)
                        .attr('data-index', <?php echo $config['data_index'] ?>)
                        .attr('data-cve', value)
                        .on("change", function () {
                            item.Checked = $(this).is(":checked");
                            localizador_sede_check(this);
                        })
                        .attr('name', 'sede');
            }});

    <?php
} else if (isset($config['config']['configuraciones']['seleccion']) && $config['config']['configuraciones']['seleccion'] == 'checkbox')
{
    ?>
        rama_campos.push({name: 'clave_unidad', title: 'Seleccionado', align: "center", itemTemplate: function (value, item) {
                return $("<input>").attr("type", "checkbox")
                        .attr("checked", item.Checked)
                        .attr('data-index', <?php echo $config['data_index'] ?>)
                        .attr('data-cve', value)
                        .on("change", function () {
                            item.Checked = $(this).is(":checked");
                            localizador_sede_check(this);
    <?php
    if (isset($config['config']['configuraciones']['funcion_auxiliar']))
    {
        echo $config['config']['configuraciones']['funcion_auxiliar'];
        ?>(this);<?php
    }
    ?>

                        });
            }});
    <?php
}
?>

    $(function () {

        $("#<?php echo $element; ?>").jsGrid({
            height: "200px",
            width: "100%",
            sorting: true,
            paging: true,
            data: rama_datos,
            fields: rama_campos
        });

    });
</script>    