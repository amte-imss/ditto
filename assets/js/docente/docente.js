$(document).ready(function () {
	mostrar_loader();
	$('#js_grid_exportar').on('click', function () {
		document.location.href = site_url + '/docente/exportar_datos/';
	});

	$('#modalidad').attr('disabled', true);
	$('#modalidad').append('<option value="">Selecciona una opción</option>');
	$('#area_enfoque').attr('disabled', true);
	$('#area_enfoque').append('<option value="">Selecciona una opción</option>');

	$('#boton_filtro').attr('disabled', true);

	$('.ditto-column').change(ditto_column_event);

	$.ajax({
		url: site_url + '/rama_organica/get_lista_rama',
		type: "POST",
		dataType: "json"
	})
	.done(function (data) {
		lista_tipo_actividad = data['tipos_actividad'];
		lista_modalidad = data['modalidades'];
		lista_area_enfoque = data['areas_enfoque'];
		lista_delegacion = data['delegaciones'];
		delegaciones();

		$('#tipo_actividad').append('<option value="">Selecciona una opción</option>');
		$.each(lista_tipo_actividad, function (key, value) {
			$('#tipo_actividad').append('<option value="' + value['id_tipo_actividad'] + '">' + value['nombre_tipo_actividad'] + '</option>');
		});

		ocultar_loader();

		$('#tipo_actividad').on('change', function(event){
			event.preventDefault();
			event.stopImmediatePropagation();
			var tipo = $(this).val();
			mostrar_loader();
			$('#jsGrid').empty();

			if(tipo){
				select_modalidad(tipo);
				$('#modalidad').attr('disabled', false);
			}else{
				$('#modalidad').attr('disabled', true);
				$('#modalidad').empty();
				$('#modalidad').append('<option value="">Selecciona una opción</option>');
			}
			$('#area_enfoque').attr('disabled', true);
			$('#area_enfoque').empty();
			$('#area_enfoque').append('<option value="">Selecciona una opción</option>');

			ocultar_loader();

		});

	})
	.fail(function (jqXHR, error, errorThrown) {
		console.log("error carga rama");
		console.log(jqXHR);
		console.log(error);
		console.log(errorThrown);
	});
});

function select_modalidad(tipo) {
	modalidad(tipo);
	$('#modalidad').empty();

	$('#modalidad').append('<option value="">Selecciona una opción</option>');
	$.each(opciones_modalidad, function (key, value) {
		$('#modalidad').append('<option value="' + value['id_modalidad'] + '">' + value['nombre_modalidad'] + '</option>');
	});

	$('#modalidad').on('change', function(event){
		event.preventDefault();
		event.stopImmediatePropagation();
		var tipo = $(this).val();
		mostrar_loader();
		$('#jsGrid').empty();
		if(tipo){
			select_area_enfoque(tipo);
			$('#area_enfoque').attr('disabled', false);
		}else{
			$('#area_enfoque').attr('disabled', true);
			$('#area_enfoque').empty();
			$('#area_enfoque').append('<option value="">Selecciona una opción</option>');
		}
		ocultar_loader();
	});

}

function select_area_enfoque(tipo) {
	area_enfoque(tipo);
	$('#area_enfoque').empty();

	$('#area_enfoque').append('<option value="">Selecciona una opción</option>');
	$.each(opciones_area_enfoque, function (key, value) {
		$('#area_enfoque').append('<option value="' + value['id_area_enfoque'] + '">' + value['nombre_area_enfoque'] + '</option>');
	});

	$('#area_enfoque').on('change', function(event){
		event.preventDefault();
		event.stopImmediatePropagation();
		var area = $(this).val();
		if(area){
			mostrar_loader();
			get_info_cursos(area);
			ocultar_loader();
		}
	});

}

function get_info_cursos(area){
	$.ajax({
		url: site_url + '/rama_organica/get_info_cursos/' + area ,
		type: 'POST',
		dataType: 'json',
	})
	.done(function(data) {
		lista_tipo_curso = data['tipos_curso'];
		lista_curso = data['cursos'];
		lista_rol = data['roles'];
		tipos_curso(area);
		grid_docente(area);
	})
	.fail(function (jqXHR, error, errorThrown) {
		console.log("error carga rama");
		console.log(jqXHR);
		console.log(error);
		console.log(errorThrown);
	});
}

function grid_docente(area) {
	var curso_edit_value = null;
	var curso_add_value = null;
	var rol_edit_value = null;
	var rol_add_value = null;

	opciones_curso = [];
	opciones_rol = [];

	var grid = $('#jsGrid').jsGrid({
		height: "800px",
		width: "100%",

		deleteConfirm: "¿Deseas eliminar este registro?",

		filtering: true,
		inserting: true,
		editing: true,
		sorting: true,
		selecting: false,
		paging: true,
		autoload: true,
		rowClick: null,

		pageLoading: true,
		pageSize: 5,
		pageButtonCount: 3,
		pagerFormat: "Paginas: {pageIndex} de {pageCount}    {first} {prev} {pages} {next} {last}   Total: {itemCount}",
		pagePrevText: "Anterior",
		pageNextText: "Siguiente",
		pageFirstText: "Primero",
		pageLastText: "Último",
		pageNavigatorNextText: "...",
		pageNavigatorPrevText: "...",

		noDataContent: "No se encontraron datos",
		invalidMessage: "",
		loadMessage: "Por favor espere",
		onItemUpdating: function (args) {
			grid._lastPrevItemUpdate = args.previousItem;
		},
		controller: {
			loadData: function (filter) {
                //console.log(filter);
                var d = $.Deferred();
                //var result = null; 

                $.ajax({
                	type: "GET",
                	url: site_url + "/docente/registros/lista/" + area,
                	data: filter,
                	dataType: "json"
                })
                .done(function (result) {
                    //console.log(result);

                    d.resolve({
                    	data: result['data'],
                    	itemsCount: result['length']

                    });
                });

                return d.promise();
            },
            insertItem: function (item) {
            	mostrar_loader();
            	var di = $.Deferred();
                var datos_nuevos_registro = {
                	matricula: item['matricula'],
                    rol: rol_add_value,
                    delegacion: item['delegacion'],
                    curso: curso_add_value
                }

                $.ajax({
                	type: "POST",
                	url: site_url + "/docente/registros/insertar",
                	data: datos_nuevos_registro
                })
                .done(function (json) {
                	console.log('success');
                	alert(json['message']);
                	grid.insertSuccess = json['success'];
                	di.resolve(json['data']);
                })
                .fail(function (jqXHR, error, errorThrown) {
                	console.log("error");
                	console.log(jqXHR);
                	console.log(error);
                	console.log(errorThrown);
                });

                curso_add_value = '';
                rol_add_value = null;
                opciones_curso = [];
                opciones_rol = [];
                ocultar_loader();
                return di.promise();
            },
            updateItem: function (item) {
            	var de = $.Deferred();
            	var datos_nuevos_registro = {
            		id_registro_docente: item['id_registro_docente'],
            		matricula: item['matricula'],
                    rol: rol_edit_value,
                    delegacion: item['delegacion'],
                    curso: curso_edit_value
                }

                $.ajax({
                	type: "POST",
                	url: site_url + "/docente/registros/editar",
                	data: datos_nuevos_registro
                })
                .done(function (json) {
                	console.log('success');
                	alert(json['message']);
                	if (json['success']) {
                		de.resolve(json['data']);
                	} else {
                		de.resolve(grid._lastPrevItemUpdate);
                	}
                })
                .fail(function (jqXHR, error, errorThrown) {
                	console.log("error");
                	console.log(jqXHR);
                	console.log(error);
                	console.log(errorThrown);
                });
                curso_edit_value = '';
                rol_edit_value = null;
                opciones_curso = [];
                opciones_rol = [];
                return de.promise();

            },
            deleteItem: function (item) {
            	return $.ajax({
            		type: "POST",
            		url: site_url + "/docente/registros/eliminar/",
            		data: item
            	});
            }
        },

        fields: [
        	{name: "matricula", title: "Matrícula", type: "text", align: "center",
		        validate: [
			        {
			        	validator: "required",
			        	message: function (value, item) {
			        		return "El campo matrícula no puede ser vacío.";
			        	}
			        },
			        {
			        	validator: "maxLength",
			        	message: function (value, item) {
			        		return "El número máximo de caracteres en matrícula es 15.";
			        	},
			        	param: 15
			        }
			    ]
		    },
    		{name: "delegacion", title: "Delegación", type: "select", align: "center",
    			items: opciones_delegaciones, valueField: "clave_delegacional", textField: "nombre",
    			validate: {
    				validator: "required",
    				message: function (value, item) {
    					return "Elige una delegación.";
    				}
    			}
			},
			{name: "tipo_curso", title: "Tipo de Curso", align: "center",
				sorting: false,
				itemTemplate: function (value, item) {
					return item['nombre_tipo_curso'];
				},
				insertTemplate: function (value) {
					var cursoField = this._grid.fields[3];
					var rolField = this._grid.fields[4];

					select_tipo_curso_add = $("<select name='tipo_curso' id='tipo_curso'>");
					select_tipo_curso_add.append("<option value=''>Selecciona un tipo de curso</option>");
					$.each(opciones_tipo_curso, function (key, value) {
						$(select_tipo_curso_add).append('<option value="' + value['id_tipo_curso'] + '">' + value['nombre_tipo_curso'] + '</option>');
					});

					$(select_tipo_curso_add).on('change', function () {
						var tipo = $(this).val();
						cursos(tipo);
						curso_add_value = null;
						roles(tipo);
						rol_add_value = null;
						$(".curso-insertcss").empty().append(cursoField.insertTemplate());
						$(".rol-insertcss").empty().append(rolField.insertTemplate());
					});
					return select_tipo_curso_add;
				},
				insertValue: function () {
					return $('#tipo_curso').val();
				},
				editTemplate: function (value, item) {
					var cursoField = this._grid.fields[3];
					var rolField = this._grid.fields[4];

                    select_tipo_curso_edit = $("<select name='tipo_curso' id='tipo_curso'>");
                    $.each(opciones_tipo_curso, function (key, value) {
                    	if (item['id_tipo_curso'] == value['id_tipo_curso']) {
                    		$(select_tipo_curso_edit).append('<option value="' + value['id_tipo_curso'] + '" selected>' + value['nombre_tipo_curso'] + '</option>');
                    		cursos(item['id_tipo_curso']);
                    		roles(item['id_tipo_curso']);
                    	} else {
                    		$(select_tipo_curso_edit).append('<option value="' + value['id_tipo_curso'] + '">' + value['nombre_tipo_curso'] + '</option>');
                    	}
                    });

                    $(select_tipo_curso_edit).on('change', function () {
                    	var tipo = $(this).val();
                    	cursos(tipo);
                    	curso_edit_value = opciones_curso[0]['clave_curso'];
                    	roles(tipo);
                    	rol_edit_value = opciones_rol[0]['id_rol_tipo_curso'];
                    	$(".curso-editcss").empty().append(cursoField.editTemplate());
                    	$(".rol-editcss").empty().append(rolField.editTemplate());
                    });
                    return select_tipo_curso_edit;
                },
                filterTemplate: function () {
                	var cursoField = this._grid.fields[3];
                	var rolField = this._grid.fields[4];

                	select_tipo_curso_filter = $("<select name='tipo_curso' id='tipo_curso'>");
                	select_tipo_curso_filter.append("<option value=''>Selecciona un tipo de curso</option>");
                	$.each(opciones_tipo_curso, function (key, value) {
                		$(select_tipo_curso_filter).append('<option value="' + value['id_tipo_curso'] + '">' + value['nombre_tipo_curso'] + '</option>');
                	});

                	$(select_tipo_curso_filter).on('change', function () {
                		var tipo = $(this).val();
                		cursos(tipo);
                		roles(tipo);
                		$(".curso-filtercss").empty().append(cursoField.filterTemplate());
                		$(".rol-filtercss").empty().append(rolField.filterTemplate());
                	});

                	return select_tipo_curso_filter;
                },
                filterValue: function () {
                	return $('#tipo_curso').val();
                }
            },
            {name: "curso", title: "Curso", align: "center",
	            insertcss: "curso-insertcss",
	            editcss: "curso-editcss",
	            filtercss: "curso-filtercss",
	            sorting: false,
	            itemTemplate: function (value, item) {
	            	return item['nombre_curso'];
	            },
	            insertTemplate: function (value) {
	            	select_curso_add = $("<select name='curso' id='curso'>");
	            	select_curso_add.append("<option value=''>Selecciona un curso</option>");
	            	$.each(opciones_curso, function (key, value) {
	            		$(select_curso_add).append('<option value="' + value['clave_curso'] + '">' + value['nombre_curso'] + '</option>');
	            	});
	            	$(select_curso_add).on('change', function () {
	            		curso_add_value = $(this).val();
	            	});
	            	return select_curso_add;
	            },
	            editTemplate: function (value, item) {
	            	select_curso_edit = $("<select name='curso' id='curso'>");
	            	$.each(opciones_curso, function (key, value) {
	            		if (typeof item != 'undefined') {
	            			if (value['clave_curso'] == item['clave_curso']) {
	            				curso_edit_value = item['clave_curso'];
	            				$(select_curso_edit).append('<option value="' + value['clave_curso'] + '" selected>' + value['nombre_curso'] + '</option>');
	            			} else {
	            				$(select_curso_edit).append('<option value="' + value['clave_curso'] + '">' + value['nombre_curso'] + '</option>');
	            			}
	            		} else {
	            			$(select_curso_edit).append('<option value="' + value['clave_curso'] + '">' + value['nombre_curso'] + '</option>');
	            		}

	            	});
	            	$(select_curso_edit).on('change', function () {
	            		curso_edit_value = $(this).val();
	                    });
	            	return select_curso_edit;
	            },
	            filterTemplate: function (value) {
	            	select_curso_filter = $("<select name='curso' id='curso'>");
	            	select_curso_filter.append("<option value=''>Selecciona un curso</option>");
	            	$.each(opciones_curso, function (key, value) {
	            		$(select_curso_filter).append('<option value="' + value['clave_curso'] + '">' + value['nombre_curso'] + '</option>');
	            	});
	            	return select_curso_filter;
	            },
	            filterValue: function (argument) {
	            	return $('#curso').val();
	            },
	            validate: {
	            	message: "Elige un curso.",
	            	validator: function (value) {
	            		var add = (curso_add_value != null) && (curso_add_value != '');
	            		var edit = (curso_edit_value != null) && (curso_edit_value != '');
	            		return add || edit;
	            	}
	            }
	        },
        	{name: "rol", title: "Rol", align: "center",
		        insertcss: "rol-insertcss",
		        editcss: "rol-editcss",
		        filtercss: "rol-filtercss",
		        sorting: false,
		        itemTemplate: function(value,item){
		        	return rol_nombre(item['id_rol']);
		        },
		        insertTemplate: function (value) {
		        	select_rol_add = $("<select name='rol' id='rol'>");
		        	select_rol_add.append("<option value=''>Selecciona un rol</option>");
		        	$.each(opciones_rol, function (key, value) {
		        		$(select_rol_add).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
		        	});
		        	$(select_rol_add).on('change', function () {
		        		rol_add_value = $(this).val();
		        	});
		        	return select_rol_add;
		        },
		        editTemplate: function (value, item) {
		        	select_rol_edit = $("<select name='rol' id='rol'>");
		        	$.each(opciones_rol, function (key, value) {
		        		if (typeof item != 'undefined') {
		        			if (value['id_rol_tipo_curso'] == item['id_rol']) {
		        				rol_edit_value = item['id_rol'];
		        				$(select_rol_edit).append('<option value="' + value['id_rol_tipo_curso'] + '" selected>' + value['nombre_rol'] + '</option>');
		        			} else {
		        				$(select_rol_edit).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
		        			}
		        		} else {
		        			$(select_rol_edit).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
		        		}

		        	});
		        	$(select_rol_edit).on('change', function () {
		        		rol_edit_value = $(this).val();
		        	});
		        	return select_rol_edit;
		        },
		        filterTemplate: function (value) {
	            	select_rol_filter = $("<select name='rol' id='rol'>");
	            	select_rol_filter.append("<option value=''>Selecciona un rol</option>");
	            	$.each(opciones_rol, function (key, value) {
	            		$(select_rol_filter).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
	            	});
	            	return select_rol_filter;
	            },
	            filterValue: function (argument) {
	            	return $('#rol').val();
	            },
	            validate: {
	            	message: "Eligo un rol.",
	            	validator: function (value) {
	            		var add = (rol_add_value != null) && (rol_add_value != '');
	            		var edit = (rol_edit_value != null) && (rol_edit_value != '');
	            		return add || edit;
	            	}
	            }
    		},
            {name: "nombre_completo", title: "Nombre", align: "center", type: "text", inserting: false, editing: false},
            {name: "clave_unidad", title: "Clave de unidad", align: "center", type: "text", inserting: false, editing: false},
            {name: "unidad", title: "Unidad", align: "center", type: "text", inserting: false, editing: false},
            {name: "clave_categoria", title: "Clave de categoría", align: "center", type: "text", inserting: false, editing: false},
            {name: "categoria", title: "Categoría", align: "center", type: "text", inserting: false, editing: false},
            {type: "control", editButton: true, deleteButton: true,
                searchModeButtonTooltip: "Cambiar a modo búsqueda", // tooltip of switching filtering/inserting button in inserting mode
                insertModeButtonTooltip: "Cambiar a insertar", // tooltip of switching filtering/inserting button in filtering mode
                editButtonTooltip: "Editar", // tooltip of edit item button
                deleteButtonTooltip: "Eliminar", // tooltip of delete item button
                searchButtonTooltip: "Buscar", // tooltip of search button
                clearFilterButtonTooltip: "Limpiar filtros de búsqueda", // tooltip of clear filter button
                insertButtonTooltip: "Agregar", // tooltip of insert button
                updateButtonTooltip: "Actualizar", // tooltip of update item button
                cancelEditButtonTooltip: "Cancelar", // tooltip of cancel editing button
            }
        ]
    }).data("JSGrid");

var origFinishInsert = jsGrid.loadStrategies.DirectLoadingStrategy.prototype.finishInsert;
jsGrid.loadStrategies.DirectLoadingStrategy.prototype.finishInsert = function (insertedItem) {
        if (!this._grid.insertSuccess) { // define insertFailed on done of delete ajax request in insertFailed of controller            
        	return;
        }
        origFinishInsert.apply(this, arguments);
    }
}

function ditto_column_event() {
	var data_id = $(this).attr('data-id');
	var status = $(this).is(':checked');
	$("#jsGrid").jsGrid("fieldOption", data_id, "visible", status);
}

function exportar_grid(area) {
	document.location.href = site_url + '/docente/exportar_datos/' + area;
}
