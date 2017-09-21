<?php foreach($categorias as $categoria){
    ?>
<li class="li-autocomplete" onclick="set_value_categoria(<?php echo $categoria['id_categoria']; ?>, '<?php echo $categoria['nombre']; ?>')" ><?php echo $categoria['nombre']; ?></li>
<?php
}
