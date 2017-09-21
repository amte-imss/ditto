$(document).ready(function() {
	$('#modalidad_filtro').attr('disabled', true);	
	$('#btn_filtro').attr('disabled', true);	

	$('#tipo_actividad_filtro').on('change',function(){
        var ta = $(this).val();

        if(anio){
            get_lista_cursos(anio);
            $('#curso').attr('disabled', false);
        }else{
            $('#curso').attr('disabled', true);
            $('#boton_curso').attr('disabled', true);
            $('#curso').empty();
        }
    });

    $('#curso').on('change', function() {
    	var curso = $(this).val();

    	if(curso){
    		$('#boton_curso').attr('disabled', false);
    	}else{
    		$('#boton_curso').attr('disabled', true);
    	}
    });

});