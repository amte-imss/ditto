/*
 * JavaScript Load Image Demo JS
 * https://github.com/blueimp/JavaScript-Load-Image
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

/* global loadImage, HTMLCanvasElement, $ */

var file_f;
$(function () {
    'use strict'

    var result = $('#result');
    var exifNode = $('#exif');
    var thumbNode = $('#thumbnail');
    var actionsNode = $('#actions');
    var eliminaImagen = $('#elimina_foto');
    var currentFile
    var coordinates

    function displayExifData(exif) {
        var thumbnail = exif.get('Thumbnail')
        var tags = exif.getAll()
        var table = exifNode.find('table').empty()
        var row = $('<tr></tr>')
        var cell = $('<td></td>')
        var prop
        if (thumbnail) {
            thumbNode.empty()
            loadImage(thumbnail, function (img) {
                thumbNode.append(img).show()
            }, {orientation: exif.get('Orientation')})
        }
        for (prop in tags) {
            if (tags.hasOwnProperty(prop)) {
                table.append(
                        row.clone()
                        .append(cell.clone().text(prop))
                        .append(cell.clone().text(tags[prop]))
                        )
            }
        }
        exifNode.show()
    }

    function updateResults(img, data) {
        var content;
        var content_hidden;
        if (!(img.src || img instanceof HTMLCanvasElement)) {
            content = $('<span>Loading image file failed</span>')
        } else {
            content = $('<a target="_blank">').append(img)
                    .attr('download', currentFile.name)
                    .attr('href', img.src || img.toDataURL());
            //Agrega la imagen nueva a base 64 en componente
//            $('#img_tmp').val(img.src || img.toDataURL());
            //*****************Todo referente a imagen ************************/
//            var img_b64 = img.toDataURL();

            //*****************************************************************/

        }
        result.children().replaceWith(content)
        if (img.getContext) {
            actionsNode.show();
//            actionsNode.appendTo(eliminaImagen.clone());
//            eliminaImagen.clone().appendTo();
            if (eliminaImagen.length) {//Valida que existe el botón imagen
                $('#elimina_foto').appendTo('#actions');//Mueve el botón al final del div
            }

        }
        if (data && data.exif) {
            displayExifData(data.exif);
        }
//        file_f = img.toDataURL();
    }

    function displayImage(file, options) {
        currentFile = file
        if (!loadImage(
                file,
                updateResults,
                options
                )) {
            result.children().replaceWith(
                    $('<span>' +
                            'Your browser does not support the URL or FileReader API.' +
                            '</span>')
                    )
        }
    }


    function dropChangeHandler(e) {
        e.preventDefault()
        e = e.originalEvent
        var target = e.dataTransfer || e.target
        file_f = target && target.files && target.files[0]
        var options = {
            maxWidth: result.width(),
            canvas: true,
            pixelRatio: window.devicePixelRatio,
            downsamplingRatio: 0.5,
            orientation: true
        }
        if (!file_f) {
            return;
        }
        exifNode.hide();
        thumbNode.hide();
        displayImage(file_f, options);

    }

    // Hide URL/FileReader API requirement message in capable browsers:
    if (window.createObjectURL || window.URL || window.webkitURL ||
            window.FileReader) {
//        result.children().hide()
    }

    $(document)
            .on('dragover', function (e) {
                e.preventDefault()
                e = e.originalEvent
                e.dataTransfer.dropEffect = 'copy'
            })
            .on('drop', dropChangeHandler)

    $('#file-input')
            .on('change', dropChangeHandler)

    $('#edit')
            .on('click', function (event) {
                event.preventDefault()
                var imgNode = result.find('img, canvas')
                var img = imgNode[0]
                var pixelRatio = window.devicePixelRatio || 1
                imgNode.Jcrop({
                    setSelect: [
                        40,
                        40,
                        (img.width / pixelRatio) - 40,
                        (img.height / pixelRatio) - 40
                    ],
                    onSelect: function (coords) {
                        coordinates = coords
                    },
                    onRelease: function () {
                        coordinates = null
                    }
                }).parent().on('click', function (event) {
                    event.preventDefault()
                })
            })

    $('#crop')
            .on('click', function (event) {
                event.preventDefault()
                var img = result.find('img, canvas')[0]
                var pixelRatio = window.devicePixelRatio || 1
                if (img && coordinates) {
                    updateResults(loadImage.scale(img, {
                        left: coordinates.x * pixelRatio,
                        top: coordinates.y * pixelRatio,
                        sourceWidth: coordinates.w * pixelRatio,
                        sourceHeight: coordinates.h * pixelRatio,
                        minWidth: result.width(),
                        maxWidth: result.width(),
                        pixelRatio: pixelRatio,
                        downsamplingRatio: 0.5
                    }))
                    coordinates = null
                }
            })

    $('#guarda_cambios_imagen')
            .on('click', function (event) {
                apprise('Confirme que realmente desea continuar', {verify: true}, function (btnClick) {
                    if (btnClick) {//Continua con el guardado de las secciones
                        var button_obj = $(this); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
//                        var url = button_obj.data('url');
                        var form_data = 'form_imagen_perfil';//Obtiene el nombre del formuario
                        var div_respuesta = '#div_result_imagen'
                        var formData = new FormData($('#' + form_data)[0]);
                        formData.append("userfile", file_f);
                        $.ajax({
//                url: site_url + '/actividad_docente/datos_actividad',
                            url: site_url + '/informacion_imss/actualiza_imagen',
                            data: formData,
                            type: 'POST',
                            mimeType: "multipart/form-data",
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function (xhr) {
                                $(div_respuesta).html(create_loader());
                            }
                        })
                                .done(function (data) {
                                    try {//Cacha el error
                                        $(div_respuesta).empty();
                                        var resp = $.parseJSON(data);
//                                        if (typeof resp.html !== 'undefined') {
//                                            $(div_respuesta).html(resp.html);//Actualiza datos html
//                                            if (typeof resp.mensaje !== 'undefined') {//Muestra mensaje al usuario si este existe
//                                                get_mensaje_general(resp.mensaje, resp.tp_msg, 5000);
//                                            }
//                                        }
//                                $(div_respuesta).append(resp.html);
                                        if (typeof resp.mensaje !== 'undefined') {//Muestra mensaje al usuario si este existe
                                            get_mensaje_general(resp.mensaje, resp.tp_msg, 5000);
                                            if (resp.tp_msg == 'success') {
                                                // Recargo la página
                                                window.location.reload(true);
                                            }
                                        }
                                    } catch (e) {
                                        $(div_respuesta).html(data);
                                    }

                                })
                                .fail(function (jqXHR, response) {
//                        $(div_respuesta).html(response);
                                    get_mensaje_general('Ocurrió un error durante el proceso, inténtelo más tarde.', 'warning', 5000);
                                })
                                .always(function () {
                                    remove_loader();
                                });

                    } else {
                        return false;
                    }
                });
            })
    $('#elimina_foto')
            .on('click', function (event) {
                apprise('Confirme que realmente desea continuar', {verify: true}, function (btnClick) {
                    if (btnClick) {//Continua con el guardado de las secciones
                        var button_obj = $(this); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
//                        var url = button_obj.data('url');
                        var div_respuesta = '#div_result_imagen'
                        var form_data = '#form_imagen_perfil';//Obtiene el nombre del formuario
                        var formData = $(form_data).serialize();
//                        formData.append("userfile", file_f);
                        $.ajax({
//                url: site_url + '/actividad_docente/datos_actividad',
                            url: site_url + '/informacion_imss/elimina_imagen',
                            data: formData,
                            method: 'POST',
                            beforeSend: function (xhr) {
                                mostrar_loader();
                            }
                        })
                                .done(function (data) {
                                    try {//Cacha el error
                                        $(div_respuesta).empty();
                                        var resp = $.parseJSON(data);
//                                        if (typeof resp.html !== 'undefined') {
//                                            $(div_respuesta).html(resp.html);//Actualiza datos html
//                                            if (typeof resp.mensaje !== 'undefined') {//Muestra mensaje al usuario si este existe
//                                                get_mensaje_general(resp.mensaje, resp.tp_msg, 5000);
//                                            }
//                                        }
//                                $(div_respuesta).append(resp.html);
                                        if (typeof resp.mensaje !== 'undefined') {//Muestra mensaje al usuario si este existe
                                            get_mensaje_general(resp.mensaje, resp.tp_msg, 5000);
                                            if (resp.tp_msg == 'success') {
                                                // Recargo la página
                                                window.location.reload(true);
                                            }
                                        }
                                    } catch (e) {
                                        $(div_respuesta).html(data);
                                        remove_loader();
                                    }

                                })
                                .fail(function (jqXHR, response) {
//                        $(div_respuesta).html(response);
                                    get_mensaje_general('Ocurrió un error durante el proceso, inténtelo más tarde.', 'warning', 5000);
//                                    remove_loader();
                                })
                                .always(function () {
                                    ocultar_loader();
                                });

                    } else {
                        return false;
                    }
                });
            })
})
