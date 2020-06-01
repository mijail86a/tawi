var DOMINIO = "https://tawi.com.pe/",
    ADMIN = "admin/",
    DIRECTORIO_AJAX = "ajax/",
    SUBDOMINIO = "https://static1.tawi.com.pe/",
    IMG = "img/",
    url = DOMINIO + ADMIN + DIRECTORIO_AJAX + "ajax.lib.php";

$(function() {
	var url = DOMINIO + ADMIN + DIRECTORIO_AJAX + "ajax.lib.php";
    var button = "";
    $("#v-pills-tab")
    .on({
        "shown.bs.tab": function (e) {
            var actual = e.target,
                anterior = e.relatedTarget,
                id_actual = $("#" + actual.id),
                id_anterior = $("#" + anterior.id),
                form_actual = id_actual.data("destino");
            id_actual.addClass("tw-btn-a");
            id_anterior.removeClass("tw-btn-a");
            if(actual.id === "tw-all-tab"){
                $(form_actual + " radio,input,textarea,button").prop('disabled', true);
                $("#tw-identidad").val("");
            }else{
                $(form_actual + " radio,input,textarea,button").prop('disabled', false);
                $("#tw-identidad").val(actual.id);
            }
        }
    });
	$("#btn-registro-cat").on('click', function (event) {
		event.preventDefault();
		var form = $(this).parent().prop("id"),
            formId = $("#"+form),
			categoria = formId.find("input").val();
        formId.find("input").removeClass("is-invalid");
		if(categoria.length > 0){
			envia = inicaAjax(url, { origen: form, categoria: categoria });
	    	envia.done(function(data) {
	    		formId.find("input").val("");
	    		//$("#tw-destino form").append("<button id=\""+data.id+"\" type=\"button\" class=\"btn btn-success mr-1 mb-1 btn-estado\">"+data.titulo+" <i class=\"fas fa-check\"></i></button>");
                button+="<div id=\"tw-button-"+data.id+"\" class=\"btn-group btn-group-sm mr-1 mt-1 tw-activo\" role=\"group\">";
                button+="    <button type=\"button\" class=\"btn btn-outline-success tw-out btn-estado\">"+data.titulo+"</button>";
                button+="    <button type=\"button\" class=\"btn btn-success tw-in tw-icono btn-estado\"><i class=\"fas fa-check\"></i></button>";
                //button+="    <button type=\"button\" class=\"btn btn-success tw-in btn-edit\"><i class=\"far fa-edit\"></i></button>";
                //button+="    <button type=\"button\" class=\"btn btn-success tw-in btn-estado\"><i class=\"far fa-trash-alt\"></i></button>";
                button+="</div>";
                console.log($("#tw-destino"),button);
                $("#tw-destino").append(button);
                button="";
	    	});
    	}else{
    		formId.find("input").addClass("is-invalid");
    	}
	});
    $("#btn-registro-pro").on('click', function (event) {
        event.preventDefault();
        event.preventBubble=true;
        var form = $(this).parent().prop("id"),
            valor = 0,titulo,
            formId = $("#"+form),
            formInput = formId.find(".tw-valida"),
            formItems = tw_mapForm(formInput),
            formItemsEmpty = tw_mapValida(formInput);
        if(formItemsEmpty.length == 0){
            var realArray = $.makeArray( formItems );
            envia = inicaAjax(url, { origen: form, producto: realArray });
            envia.done(function(data) {
                button+="<div id=\"tw-button-"+data.id+"\" class=\"btn-group btn-group-sm mr-1 mb-1 tw-activo\" role=\"group\">";
                button+="    <button type=\"button\" class=\"btn btn-outline-success tw-out btn-estado\">"+data.titulo+"</button>";
                button+="    <button type=\"button\" class=\"btn btn-success tw-in tw-icono btn-estado\"><i class=\"fas fa-check\"></i></button>";
                //button+="    <button type=\"button\" class=\"btn btn-success tw-in btn-edit\"><i class=\"far fa-edit\"></i></button>";
                //button+="    <button type=\"button\" class=\"btn btn-success tw-in btn-estado\"><i class=\"far fa-trash-alt\"></i></button>";
                button+="</div>";
                $("#tw-"+data.destino).append(button);
                button="";
            });
        }else{
            $.each(formItemsEmpty, function(index, val) {
                val.addClass("is-invalid");
            });
        }
    });
    $("#btn-registro-agr").on('click', function (event) {
        event.preventDefault();
        var form = $(this).parent().prop("id"),
            formId = $("#"+form),
            formValida = formId.find(".tw-valida"),
            formInput = formId.find("radio,input,textarea"),
            formAll = tw_mapForm(formInput),
            formItems = tw_mapForm(formValida),
            formItemsEmpty = tw_mapValida(formValida);
        formId.find(".tw-valida").removeClass("is-invalid");
        if(formItemsEmpty.length == 0){
            var realArray = $.makeArray( formAll );
            envia = inicaAjax(url, { origen: form, agregado: realArray });
            envia.done(function(data) {
                //formId.find("input").val("");
                $("#tw-"+data.destino).find('.alert').remove();
                button+="<div id=\"tw-button-"+data.id+"\" class=\"btn-group btn-group-sm mr-1 mb-1 tw-activo\" role=\"group\">";
                button+="    <button type=\"button\" class=\"btn btn-outline-success tw-out btn-estado\">"+data.titulo+"</button>";
                button+="    <button type=\"button\" class=\"btn btn-success tw-in tw-icono btn-estado\"><i class=\"fas fa-check\"></i></button>";
                //button+="    <button type=\"button\" class=\"btn btn-success tw-in btn-edit\"><i class=\"far fa-edit\"></i></button>";
                //button+="    <button type=\"button\" class=\"btn btn-success tw-in btn-estado\"><i class=\"far fa-trash-alt\"></i></button>";
                button+="</div>";
                $("#tw-"+data.destino).append(button);
                button="";
            });
        }else{
            formId.find(".tw-valida").addClass("is-invalid");
        }
    });
    $("#btn-registro-ext").on('click', function (event) {
        event.preventDefault();
        var form = $(this).parent().prop("id"),
            formId = $("#"+form),
            formValida = formId.find(".tw-valida"),
            formInput = formId.find("input,textarea"),
            formAll = tw_mapForm(formInput),
            formItems = tw_mapForm(formValida),
            formItemsEmpty = tw_mapValida(formValida),
            precio = $("#tw-precio").val();
        formId.find(".tw-valida").removeClass("is-invalid");
        if(formItemsEmpty.length == 0){
            var realArray = $.makeArray( formAll );
            envia = inicaAjax(url, { origen: form, extra: realArray });
            envia.done(function(data) {
                //formId.find("input").val("");
                $("#tw-"+data.destino).find('.alert').remove();
                button+="<div id=\"tw-button-"+data.id+"\" class=\"btn-group btn-group-sm mr-1 mt-1 tw-activo\" role=\"group\">";
                button+="    <button type=\"button\" class=\"btn btn-outline-success tw-out btn-estado\">"+data.titulo+"</button>";
                button+="    <button type=\"button\" class=\"btn btn-success tw-in tw-icono btn-estado\"><i class=\"fas fa-check\"></i></button>";
                //button+="    <button type=\"button\" class=\"btn btn-success tw-in btn-edit\"><i class=\"far fa-edit\"></i></button>";
                //button+="    <button type=\"button\" class=\"btn btn-success tw-in btn-estado\"><i class=\"far fa-trash-alt\"></i></button>";
                button+="</div>";
                $("#tw-"+data.destino).append(button);
                button="";
            });
        }else{
            formId.find(".tw-valida").addClass("is-invalid");
        }
    });
	$(document).on("click", ".btn-estado", function() {
        console.log($(this).parent().parent().parent());
		var origen = $(this).parent().parent().parent().prop("id"),
			id = $(this).parent().prop("id"),
			estado = $(this).parent().hasClass("tw-activo")?"2":"1",
            class_remove_in = "btn-success",
            class_remove_out = "btn-success",
            add_class_in = "btn-danger",
            add_class_out = "btn-outline-danger",
            find_i = "fas fa-check",
            remove_i = "fa-check";
            add_i = "fa-times";
		envia = inicaAjax(url, { origen: origen, id: id , "estado" : estado });
    	envia.done(function(data) {
    		if(data){
    			if(estado==1){
    				class_remove_in = "btn-danger";
                    class_remove_out = "btn-outline-danger";
                    add_class_in = "btn-success";
                    add_class_out = "btn-outline-success";
                    find_i = "fas fa-times";
                    remove_i = "fa-times";
                    add_i = "fa-check";
                    $( "#" + id ).addClass("tw-activo");
    			}else{
                    $( "#" + id ).removeClass("tw-activo");
                }
                $( "#" + id + " .tw-in" ).removeClass(class_remove_in).addClass(add_class_in);
                $( "#" + id + " .tw-out" ).removeClass(class_remove_out).addClass(add_class_out);
                $( "#" + id + " .tw-icono i" ).removeClass(remove_i).addClass(add_i);
    		}
    	});
	});
    $(document).on("click", "#aceptar", function() {
        cambia_estado($(this),2);
    });
    $(document).on("click", "#cancelar", function() {
        cambia_estado($(this),4);
    });
    $("#v-tawi-tab")
    .on({
        "shown.bs.tab": function (e) {
            var destino = e.target,
                destino_id = destino.id,
                destino_hash = destino.hash;
            panel_actualiza(destino_id, $(destino_hash));
        }
    });
});
/* ------------------------------------------------------------------------------------------- */
/* var AJAX */
var inicaAjax = function(url, data) {
    return $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: 'json',
    }).fail(function(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus);
    });
};
var cambia_estado = function(obj, estado){
    var id = obj.parent().parent().parent().parent().parent().prop("id"),
        url = DOMINIO + ADMIN + DIRECTORIO_AJAX + "ajax.lib.php";
    envia = inicaAjax(url, { origen: "pedido-estado", id: id , "estado" : estado });
    envia.done(function(data) {
        $("#"+id).parent().remove();
    });
};
var tw_mapForm = function(formInput){
    var retorna = formInput.map(function(index, elem){
            valor = elem.value;
            $("#" + elem.id).removeClass("is-invalid");
            switch (elem.type) {
                case "checkbox":
                   if(elem.checked){
                        valor = 1;
                        return { "id" : elem.id , "valor" : valor };
                    }else{
                        valor = 0;
                        return { "id" : elem.id , "valor" : valor };
                    }
                    break;
                case "select":
                    if(valor !== 0){
                        titulo = $("#" + elem.id + " option:selected").text();
                        return { "id" : elem.id , "valor" : $("#" + elem.id + " option:selected").val() };
                    }
                    break;
                default:
                    if(valor.length > 0){
                        return { "id" : elem.id , "valor" : valor };
                    }
                    break;
            }
        });
    return retorna;
};
var tw_mapValida = function(formInput){
    var retorna = formInput.map(function(index, elem){
        valor = elem.value;
        switch (elem.localName) {
            case "select":
                if(valor == 0){
                    return $("#"+elem.id);
                }
                break;
            default:
                if(valor.length == 0){
                    return $("#"+elem.id);
                }
                break;
        }
    });
    return retorna;
};
var timer_dashboard = function(){
    console.log("inicia");
    var timerDashboard = setInterval(actualiza, 3000);
    function actualiza(){
        panel_actualiza("v-activo-tab", $("#v-activo"));
    }
};
var panel_actualiza = function(destino, destino_id) {
    var d = new Date();
    console.log(d.toLocaleTimeString());
    //console.log($(this).prop("id"));
    var color_fondo = "bg-secondary",
        color_borde = "border-secondary",
        panel = "", codigo, posicion;
    envia = inicaAjax(url, { origen: "pedido-visto", destino: destino });
    envia.done(function(data) {
        if(data.estado){
            $.each(data.contenido, function(index, val) {
                codigo = val.codigo_pedido; 
                switch (data.destino){
                    case 1:
                        codigo = panel_boton(val.codigo_pedido);
                        posicion = 1;
                        break;
                    case 2:
                        color_fondo = "bg-warning";
                        color_borde = "border-warning";
                        posicion = 1;
                        break;
                    case 3:
                        valida_pago = $("#v-espera").find("#"+index);
                        if(valida_pago.length > 0){
                            valida_pago.parent().remove();
                        }
                        color_fondo = "bg-success";
                        color_borde = "border-success";
                        posicion = 2;
                        break;
                    case 4:
                        color_fondo = "bg-danger";
                        color_borde = "border-danger";
                        posicion = 2;
                        break;
                    default:
                        break;
                }
                panel+="<div class=\"col-3 pl-0 pb-3\">";
                panel+="<div id=\""+index+"\" class=\"card h-100 w-100 "+color_borde+"\">";
                panel+=panel_top(color_fondo, codigo);
                panel+=panel_middle(val.extras);
                panel+=panel_bottom(color_fondo, val.creado, val.total);
                panel+="</div>";
                panel+="</div>";
                destino_h = destino_id.find("h3");
                if(destino_h.length > 0){
                    destino_h.remove();
                }
                switch (posicion){
                    case 1:
                        destino_id.find(".row").append(panel);
                        break;
                    case 2:
                        destino_id.find(".row").prepend(panel);
                        break;
                    default:
                        break;
                }
                //console.log(panel);console.log(panel_top(color_fondo, codigo));console.log(panel_middle());console.log(panel_bottom(color_fondo, val.creado, val.total));
            });
        }
    });
    function panel_boton(codigo_pedido){
        var panel="<div class=\"btn-group\" role=\"group\">";
        panel+="<button type=\"button\" class=\"btn btn-secondary text-white\">"+codigo_pedido+"</button>";
        panel+="<div class=\"btn-group\" role=\"group\">";
        panel+="<button id=\"btnGroupDrop1\" type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">&nbsp;</button>";
        panel+="<div class=\"dropdown-menu\" aria-labelledby=\"btnGroupDrop1\">";
        panel+="<a id=\"aceptar\" class=\"dropdown-item\">Aceptar</a>";
        panel+="<a id=\"cancelar\" class=\"dropdown-item\">Rechazar</a>";
        panel+="</div></div></div>";
        return panel;
    }
    function panel_top(color_fondo, codigo){
        var panel="<div class=\"card-header text-center text-white font-weight-bold "+color_fondo+"\">";
        panel+=codigo;
        panel+="</div>";
        return panel;
    }
    function panel_middle(contenido){
        console.log(contenido);
        var panel ="<div class=\"card-body tw-ac overflow-auto\">",
            paquete="";
        $.each(contenido, function(index, val) {
            paquete += "<div class=\"w-100 border-top border-bottom border-dark\">";
            paquete += "<div class=\"d-flex\"><div class=\"mr-auto\">" + val.producto.nombre + "</div><div> x " + val.producto.cantidad + "</div></div>";
            if((val.extra).length > 0){
                paquete += "<div class=\"\">";
                $.each(val.extra, function(key, value) {
                    paquete += "<div class=\"w-100\">" + value + "</div>";
                });
                paquete += "</div>";
            }
            paquete += (val.comentario).length>0?"<div class=\"mr-auto\"><small>Comentario(s): </small>" + val.comentario + "</div>":"";
            paquete += "</div>";
            /*
            switch (val.tipo) {
                case "extra":
                    panel+="<div class=\"w-100 d-flex\"><div class=\"mr-auto pl-3\">" + val.nombre + "</div></div>";
                    break;
                default:
                    panel+="<div class=\"w-100 border-top border-bottom border-dark d-flex\"><div class=\"mr-auto\">" +val.nombre+ "</div><div>" + val.cantidad + "</div></div>";
                    var mensaje = val.mensaje;
                    if ( mensaje != null) {
                        panel+="<div class=\"w-100 d-flex\"><div class=\"w-100\">" + val.mensaje + "</div></div>";
                    }
                    break;
            }
            */
        });
        console.log(paquete);
        panel+=paquete;
        panel+="</div>";
        return panel;
    }
    function panel_bottom(color_fondo, creado, total){
        var panel="<div class=\"card-footer d-flex text-white "+color_fondo+"\">";
        panel+="<div class=\"mr-auto\"><small>"+creado+"</small></div>";
        panel+="<div class=\"font-weight-bold\">"+total+"</div>";
        panel+="</div>";
        return panel;
    }
};