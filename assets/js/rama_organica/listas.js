var lista_tipo_actividad = null;
var lista_modalidad = null;
var lista_area_enfoque = null;
var lista_delegacion = null;
var lista_tipo_curso = null;
var lista_curso = null;
var lista_rol = null;

var opciones_modalidad = [];
var opciones_area_enfoque = [];
var opciones_delegaciones = [];
var opciones_tipo_curso = [];
var opciones_curso = [];
var opciones_rol = [];

/**
* Da formato a la lista de delegaciones para que pueda ser leida por el jsgrid
* @author CPMS
*/
function delegaciones(){
	opciones_delegaciones = new Array();
    for (var j = 0; j < lista_delegacion.length; j++) {
        opciones_delegaciones.push(lista_delegacion[j]);
    }
    opciones_delegaciones.unshift(JSON.parse('{"clave_delegacional" : "", "nombre" : "Selecciona un delegacion"}'));
}

/**
* Cambia las opciones de la modalidad dependiendo del tipo de actividad
* @author CPMS
* @param id del tipo de actividad
*/
function modalidad(tipo){
	opciones_modalidad = [];
	var c = 0;
	for (var i = 0; i < lista_modalidad.length; i++) {
		if(lista_modalidad[i].id_tipo_actividad == tipo){
			opciones_modalidad[c] = lista_modalidad[i];
			c++;
		}
	}
}

/**
* Cambia las opcioens del area de enfoque dependiendo de la modalidad
* @author CPMS
* @param id del area de enfoque
*/
function area_enfoque(tipo){
	opciones_area_enfoque = [];
	var c = 0;
	for (var i = 0; i < lista_area_enfoque.length; i++) {
		if(lista_area_enfoque[i].id_modalidad == tipo){
			opciones_area_enfoque[c] = lista_area_enfoque[i];
			c++;
		}
	}
}

/**
* Cambia las opciones del tipo de curso dependiendo del area de enfoque
* @author CPMS
* @param id del area de enfoque
*/
function tipos_curso(area){
	opciones_tipo_curso = [];
	var c = 0;
	for (var i = 0; i < lista_tipo_curso.length; i++) {
		if($(lista_tipo_curso[i].id_area_enfoque)[0] == area){
			opciones_tipo_curso[c] = $(lista_tipo_curso[i])[0];
			c++;
		}
	}
}

/**
* Cambia las opciones de los cursos dependiendo del tipo de curso
* @author CPMS
* @param tipo de curso
*/
function cursos(tipo) {
	opciones_curso = [];
	var c = 0;
	for (var i = 0; i < lista_curso.length; i++) {
		if($(lista_curso[i].id_tipo_curso)[0] == tipo){
			//console.log($(lista_tipo_curso[i])[0]);
			opciones_curso[c] = $(lista_curso[i])[0];
			c++;
		}
	}
}

/**
* Cambia las opciones de los roles dependiendo del tipo de curso
* @author CPMS
* @param tipo de curso
*/
function roles(tipo){
	opciones_rol = [];
	var c = 0;
	for (var i = 0; i < lista_rol.length; i++) {
		if(lista_rol[i].id_tipo_curso == tipo){
			opciones_rol[c] = lista_rol[i];
			c++;
		}
	}
}

/** 
* Devuelve el nombre del rol
* @author CPMS
* @param id del rol por tipo de curso
* @return strin
*/
function rol_nombre(id){
	var nombre = '';
	for (var i = 0; i < lista_rol.length; i++){
		if(lista_rol[i].id_rol_tipo_curso == id){
			nombre = lista_rol[i]['nombre_rol'];
			break;
		}
	}
	return nombre;

}
