var DOMINIO = "https://tawi.com.pe",
    DIRECTORIO = "",
    DIRECTORIO_AJAX = "/ajax",
    SUBDOMINIO = "https://static2.tawi.com.pe",
    IMG = "/img";
/* ------------------------------------------------------------------------------------------- */
$(function() {
    var url = DOMINIO + DIRECTORIO + DIRECTORIO_AJAX + "/ajax.carrito.php",
        //lastId = "",
        numeroPlatos = 1,
        sticky = $("#menu-opt"),
        topMenuHeight = $("#menu-opt").outerHeight(),
        menuItems = sticky.find("a");//,
        //device = is_Mobile.any(),
        /*scrollItems = menuItems.map(function(){
            var item = $($(this).attr("href"));
            if (item.length) { return item; }
        });*/
    //imgDevice(device);
    //$(".tw-scroll").scroll(function(){
    $(window).scroll(function(){
        tw_sticky(sticky,$(this));
        /*
        var fromTop = $(this).scrollTop()+topMenuHeight;
        var current = scrollItems.map(function(){
            if ($(this).offset().top < fromTop){
                return this;
            }
        });
        current = current[current.length-1];
        var id = current && current.length ? current[0].id : "";
        if (lastId !== id) {
            lastId = id;
            menuItems.parent().removeClass("tw-active").end().filter("[href='#"+id+"']").parent().addClass("tw-active");
        }
        */
    });
    /* buscar */
    $('#restaurante-buscar').on({
        "keyup": function(event) {
            //if (event.keyCode == 13) {
                //event.preventDefault();
                var html = "";
                envia = inicaAjax(url, { origen: "buscar", patron: $('#restaurante-buscar').val() });
                envia.done(function(data) {
                    $.each(data, function(index, val) {
                        html += "<div class=\"col-6 col-sm-4 col-md-3 pl-3 pr-0 pb-3\">";
                        html += "    <div id=\""+index+"\" class=\"card\">";
                        html += "    <a href=\"carta.php?id="+index+"\" class=\"card-link\">";
                        html += "        <img class=\"card-img-top\" alt=\"corazon\" src=\""+ SUBDOMINIO + DIRECTORIO + IMG + "/restaurante/" + val.logo +"\">";
                        html += "        <div class=\"p-3\">";
                        html += "            <div class=\"card-title\">"+ val.nombre +"</div>";
                        html += "        </div>";
                        html += "    </a>";
                        html += "    </div>";
                        html += "</div>";
                    });
                    $("#restaurante-resultado").html(html);
                });
            //}
        }
    });
    /* scroll - top 0 */
    menuItems.on('click', function (event) {
        event.stopPropagation();
        event.preventDefault();
        var href = $.attr(this, 'href'),
            offsetTop = $(href).offset().top-topMenuHeight+1;
        $('html, body').animate({scrollTop: offsetTop}, 1000);
    });
    /* accordeon */
    $(".fw-categorias")
    .on({
        "show.bs.collapse": function (e) {
        var destino = e.target,
            obj = $("#"+destino.id),
            obj_dst = $("#"+destino.id+" .tw-cantidades"),
            nivel = obj.prev().data("nivel"),
            nivel_clase = (nivel == "nivel-1")?'text-white tw-bg-a':'text-white tw-bg-b';
            obj.prev().addClass(nivel_clase);
            button = "";
            if(parseInt(obj_dst.length) == parseInt(0)){
                button += "<div class=\"tw-cantidades tw-color-a d-flex justify-content-center align-items-center\" data-collapse=\"#"+destino.id+"\">";
                button += "<i class=\"fas fa-minus-circle tw-fc tw-fi tw-minus\"></i>";
                button += "<span class=\"fa-stack tw-fd\">";
                button += "<span class=\"far fa-circle fa-stack-2x\"></span>";
                button += "<span class=\"fa-stack-1x\">1</span>";
                button += "</span>";
                button += "<i class=\"fas fa-plus-circle tw-fc tw-fi tw-plus\"></i>";
                button += "</div>";
                obj.find("button").before(button);
            }
            obj.slideDown("slow");
        },
        "hide.bs.collapse": function (e) {
        var destino = e.target,
            id = $("#"+destino.id),
            nivel = id.prev().data("nivel"),
            nivel_clase = (nivel == "nivel-1")?'text-white tw-bg-a':'text-white tw-bg-b';
            id.prev().removeClass(nivel_clase);
            id.slideUp("slow");
        }
    });
    /* agregar plato - quitar plato */
    $(document).on("click", ".tw-plus", function() {
        numeroPlatos += 1;
        $(this).prev().find(".fa-stack-1x").text(numeroPlatos);
        tw_action( $(this),numeroPlatos );
    });
    $(document).on("click", ".tw-minus", function() {
        if(numeroPlatos > 1){
            numeroPlatos -= 1;
            $(this).next().find(".fa-stack-1x").text(numeroPlatos);
            tw_action($(this),numeroPlatos);
        }
    });
    /* agregar plato - quitar plato desde carrito */
    $(document).on("click", ".tw-plus-carrito", function() {
        var cantidad = parseInt( $(this).prev().text() );
        cantidad += 1;
        $(this).prev().text(cantidad);
        tw_action_carrito($(this),cantidad);
    });
    $(document).on("click", ".tw-minus-carrito", function() {
        var cantidad = parseInt( $(this).next().text() );
        if(cantidad > 1){
            cantidad -= 1;
            $(this).next().text(cantidad);
            tw_action_carrito($(this),cantidad);
        }
    });
    $(document).on("click", ".tw-delete", function() {
        var id = $(this).parent().parent().parent().prop("id");
        envia = inicaAjax(url, { origen : "delete", id : id });
        envia.done(function(data) {
            $("#"+id).parent().remove();
            if(data.estado){
                $("#"+data.destino+" .tw-cantidad").text(data.cantidad);
            }else{
                $("#"+data.destino+" .tw-cantidad").text("");
            }
            $(".tw-total").text(data.total);
        });
    });
    /* agregar extras */
    $(document).on("click", ".tw-check", function() {
        tw_action($(this),numeroPlatos);
        var collapse = $(this).parent().data("collapse"),
            dst = $(collapse);
        if( obj_existe( dst.prev().find(".badge") ) ){
            dst.prev().append("<span class=\"badge badge-success float-right p-1\">agregado al pedido</span>");
        }
        dst.collapse('hide');
    });
    /* Enviar pedido */
    $(document).on("click", ".tw-btn-carrito", function() {
        //var url = DOMINIO + DIRECTORIO + DIRECTORIO_AJAX + "/ajax.carrito.php";
        var html="",
            cantidad="",
            extras="",
            target = $(this).parent().parent(),
            precio = $(this).data('precio'),
            id = target.prop('id'),
            formInput = target.find("input"),
            formTextArea = target.find("textarea").val(),
            formItems = tw_mapForm(formInput),
            realArray = $.makeArray( formItems ),
            enviar = { origen : "add",id : id, precio : precio, cantidad : numeroPlatos, extras : realArray, plato : target.find(".tw-titulo").text() , mensaje : formTextArea };
        if( parseInt( $("body #panel-lateral").length ) == parseInt(0) ){
            html += "<div id=\"panel-lateral\" class=\"container-fluid h-100 position-fixed overflow-auto tw-fk tw-fo\" data-estado=\"close\">";
            html += "<div class=\"row h-100\">";
            html += "<div class=\"col-12 col-md-3 col-lg-4 ml-auto bg-light h-100 overflow-auto\">";
            html += "<div class=\"conteiner px-3\">";
            html += "<div id=\"tw-container\" class=\"row font-weight-bold\">";
            html += "<div class=\"col-12 text-dark tw-fc tw-fi tw-btn-ver\"><i class=\"fas fa-times\"></i></div>";
            html += "<div class=\"col-12 tw-bg-a text-center text-white\">Resumen de Pedido</div>";
            html += "<div class=\"col-12 p-0 my-3\"><a class=\"btn btn-block tw-btn-a\" href=\"revisar.php\" role=\"button\">CONFIRMAR</a></div>";
            html += "</div></div></div></div></div>";
            $("body").prepend(html);
            html ="";
        }
        envia = inicaAjax(url, enviar);
        envia.done(function(data) {
            if(data.estado){
                var contenido = data.contenido;
                if(formItems.length > 0){
                    $(this).prop('disabled', true);
                }
                numeroPlatos = 1;
                target.find(".fa-stack-1x").text(numeroPlatos);
                target.find("textarea").val("");
                target.find(".collapse").collapse('hide');
                target.find(".badge").remove();
                var total, mensaje;
                html+="<div class=\"col-12 text-dark tw-fc tw-fi tw-btn-ver\"><i class=\"fas fa-times\"></i></div>";
                html+="<div class=\"col-12 tw-bg-a text-center text-white\">Resumen de Pedido</div>";
                $.each(contenido.items, function(index, val) {
                    mensaje = val.mensaje;
                    extras = val.extras;
                    html+="<div class=\"col-12 border-bottom tw-bg-c my-1\">";
                    html+="<form id=\""+index+"\">";
                    html+="<div class=\"row border-left border-right tw-bg-c\">";
                    html+="<div class=\"col-12 tw-color-a\">"+val.plato+"</div>";
                    html+="<div class=\"col-7 pr-0 tw-color-b\">Precio unitario:</div>";
                    html+="<div class=\"col-2 px-0 tw-color-b text-right\">S/.</div>";
                    html+="<div class=\"col-3 pl-0 text-right\">"+val.precio+"</div>";
                    if(extras.estado){
                        html+="<div class=\"col-12 tw-color-b\">Extras</div>";
                        $.each(extras.contenido, function(key, value) {
                            html+="<div class=\"col-7 pr-0 tw-color-b\"><i class=\"fas fa-ellipsis-h\"></i> "+value.nombre+":</div>";
                            html+="<div class=\"col-2 px-0 tw-color-b text-right\">S/.</div>";
                            html+="<div class=\"col-3 pl-0 text-right\">"+ value.precio +"</div>";
                        });
                    }
                    html+="<div class=\"col-7 pr-0 mt-1 tw-color-b\">Cantidad:</div>";
                    html+="<div class=\"col-5 pl-0 mt-1\">";
                    html+="<div class=\"btn-group btn-group-sm d-flex\" role=\"group\">";
                    html+="<button type=\"button\" class=\"btn tw-btn-a tw-minus-carrito\"><i class=\"fas fa-minus-circle\"></i></button>";
                    html+="<button type=\"button\" class=\"btn tw-btn-outline-a\">"+val.cantidad+"</button>";
                    html+="<button type=\"button\" class=\"btn tw-btn-a tw-plus-carrito\"><i class=\"fas fa-plus-circle\"></i></button>";
                    html+="</div>";
                    html+="</div>";
                    html+="<div class=\"col-7 pr-0\"></div>";
                    html+="<div class=\"col-5 pl-0 mt-1\">";
                    html+="<div class=\"btn-group btn-group-sm d-flex tw-delete\" role=\"group\">";
                    html+="<button type=\"button\" class=\"btn tw-btn-outline-a\">Eliminar:</button>";
                    html+="<button type=\"button\" class=\"btn tw-btn-a\"><i class=\"far fa-trash-alt\"></i></button>";
                    html+="</div>";
                    html+="</div>";
                    if(mensaje.length > 0){
                        html+="<div class=\"col-12 tw-color-b\">Instrucciones especiales:</div>";
                        html+="<div class=\"col-12\">"+mensaje+"</div>";
                    }
                    html+="<div class=\"col-7 pr-0 mb-3 tw-color-b\">Total:</div>";
                    html+="<div class=\"col-2 px-0 mb-3 tw-color-b text-right\">S/.</div>";
                    html+="<div class=\"col-3 pl-0 mb-3 text-right tw-precio\">"+val.costo+"</div>";
                    html+="</div>";
                    html+="</form>";
                    html+="</div>";
                });
                total = parseInt(contenido.total);
                html+="<div class=\"col-12 tw-bg-a text-white tw-fj\">";
                html+="<div class=\"row\">";
                html+="<div class=\"col-7\">TOTAL</div>";
                html+="<div class=\"col-2 text-right\">S/.</div>";
                html+="<div class=\"col-3 text-right tw-total\">"+total.toFixed(2)+"</div>";
                html+="</div>";
                html+="</div>";
                html+="<div class=\"col-12 p-0 my-3\">";
                html+="<a class=\"btn btn-block tw-btn-a\" href=\"revisar.php\" role=\"button\">CONFIRMAR</a></div>";
                html+="</div>";
                $("#tw-container").html(html);
                if( obj_existe( $("#"+id+" .tw-cantidad") ) ){
                    cantidad = "<div class=\"tw-cantidad tw-fd d-flex align-items-center\">"+contenido.contador[id]+"</div>";
                    $("#"+id).find(".tw-subtitulo").append(cantidad);
                }else{
                    $("#"+id).find(".tw-cantidad").text(contenido.contador[id]);
                }
                $("#shopping-cart").show();
            }
        });
    });
    /**/
    $(document).on("click", "#tw-logeo", function() {
        event.preventDefault();
        var enlace,
            url = DOMINIO + DIRECTORIO + DIRECTORIO_AJAX + "/ajax.lib.php",
            form = $(this).parent().parent().prop("id"),
            formId = $("#"+form),
            formValida = formId.find(".tw-valida"),
            formInput = formId.find("input"),
            formAll = tw_mapForm(formInput),
            formItemsEmpty = tw_mapValida(formValida);
        formId.find(".tw-valida").removeClass("is-invalid");
        if(formItemsEmpty.length == 0){
            var realArray = $.makeArray( formAll );
            envia = inicaAjax(url, { origen: "logeo", agregado: realArray });
            envia.done(function(data) {
                if(data.estado){
                    obj = obj_existe($("#btn-acciones"));
                    console.log(obj,$("#btn-acciones"));
                    if(obj == false){
                        enlace="<a class=\"btn tw-btn-b flex-grow-1\" href=\"terminar.php\" role=\"button\">Confirmar</a>";
                        $("#btn-acciones").remove();
                        $("#tw-accion").append(enlace);
                    }
                    enlace="<div class=\"btn-group\" role=\"group\">";
                    enlace+="<button type=\"button\" class=\"btn tw-btn-b\">"+ data.detalle.usuario +"</button>";
                    enlace+="<button id=\"btnGroupDrop1\" type=\"button\" class=\"btn tw-btn-b dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"></button>";
                    enlace+="<div class=\"dropdown-menu\" aria-labelledby=\"btnGroupDrop1\">";
                    enlace+="<a class=\"dropdown-item\" href=\"#\"><i class=\"far fa-edit\"></i>&nbsp;Editar</a>";
                    enlace+="<a id=\"tw-salir\" class=\"dropdown-item\"><i class=\"fas fa-sign-out-alt\"></i>&nbsp;Salir</a>";
                    enlace+="</div></div>";
                    $("#tw-cabezera").find('button').remove();
                    $("#tw-cabezera").append(enlace);
                    $("#tw-login").modal('hide');
                }else{
                    formId.find(".tw-valida").addClass("is-invalid");
                }
            });
        }else{
            $.each(formItemsEmpty, function(index, val) {
                val.addClass("is-invalid");
            });
        }
    });
    /**/
    $(document).on("click", "#tw-salir", function(e) {
        e.preventDefault();
        var url = DOMINIO + DIRECTORIO + DIRECTORIO_AJAX + "/ajax.lib.php",
            enlace;
        envia = inicaAjax(url, { origen: "salir" });
        envia.done(function(data) {
            //enlace = "<a class=\"btn tw-btn-b flex-grow-1\" href=\"terminar.php\" role=\"button\" data-toggle=\"modal\" data-target=\"#tw-login\">Confirmar pedido</a>";
            enlace = "<button class=\"btn tw-btn-b\" aria-label=\"inicio de sesión\" data-toggle=\"modal\" data-target=\"#tw-login\">Iniciar sesión</button>";
            $("#tw-cabezera").find('.btn-group').remove();
            $("#tw-cabezera").append(enlace);
        });
    });
    /**/
    $(document).on("click","#tw-registra", function(){
        var enlace,
            url = DOMINIO + DIRECTORIO + DIRECTORIO_AJAX + "/ajax.lib.php",
            form = $(this).parent(),
            formId = form,
            formValida = formId.find(".tw-valida"),
            formInput = formId.find("input"),
            formAll = tw_mapForm(formInput),
            formItemsEmpty = tw_mapValida(formValida);
        console.log(formItemsEmpty.length);
        if(formItemsEmpty.length == 0){
            form.submit();
        }else{
            
        }
    });
    /**/
    //$(".tw-btn-ver").on('click', function () {
    $(document).on("click", ".tw-btn-ver", function() {
        console.log("se inicia");
        panel_lateral();
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
/* agregar o disminuir platos */
var tw_action  = function(obj,numeroPlatos){
    var form = $( obj.parent().data("collapse") ),
        precio = form.find("button").data("precio");
    if(precio == null){
        form = $( obj.parent().data("target") );
        precio =  form.find("button").data("precio");
    }
    var formInput = form.find(".tw-extra"),
        formItems = formInput.map(function(index, elem){
            if (elem.checked) { return elem.value; }
        }),
        extras = parseFloat("0.00"),
        btn_agregar = form.find("button");
    if(formItems.length > 0){
        btn_agregar.prop('disabled', false);
        $.each(formItems , function(indice, valor) {
            extras +=  parseFloat(valor);
        });
    }
    console.log(formItems);
    console.log(precio, extras, numeroPlatos);
    sum = (parseFloat(precio) + parseFloat(extras)) * parseFloat(numeroPlatos);
    btn_agregar.html("<img class=\"img-fluid tw-ff\" src=\""+ SUBDOMINIO + DIRECTORIO + IMG + "/carrito-de-compras-32.png\" alt=\"carrito\"> Agregar "+ numeroPlatos +" al pedido S/. " + sum.toFixed(2));
};
var tw_action_carrito = function(obj,cantidad){
    var url = DOMINIO + DIRECTORIO + DIRECTORIO_AJAX + "/ajax.carrito.php",
        capa = obj.parent().parent(),
        id = capa.parent().parent().prop("id");
    envia = inicaAjax(url, { origen : "edit", id : id, cantidad : cantidad });
    envia.done(function(data) {
        $("#"+id+" .tw-precio").text(data.costo);
        $(".tw-total").text(data.total);
    });
};
/* sticky */
var tw_sticky = function(sticky,obj){
    //var scroll = $(window).scrollTop();
    var scroll = obj.scrollTop();
    if (scroll >= 100){
        sticky.addClass('fixed-top');
        sticky.show();
    }else{
        sticky.removeClass('fixed-top');
        sticky.hide();
    }
};
/* se activa el panel lateral */
var panel_lateral = function() {
    //$("._tooltip").tooltip('hide');
    var panel = $("#panel-lateral"),
        cerrar = $("#cerrar"),
        estado = panel.data("estado"),
        pixel = "0";
    switch (estado) {
        case "close":
            $("body").addClass('overflow-hidden');
            $("#menu-opt").hide();
            panel.data("estado", "open");
            panel.find("#cerrar").removeClass("d-none");
            break;
        default:
            $("body").removeClass('overflow-hidden');
            $("#menu-opt").show();
            pixel = "-" + panel.outerWidth() + "px";
            panel.find("#cerrar").addClass("d-none");
            panel.data("estado", "close");
            break;
    }
    panel.animate({ "right": pixel });
};
/**/
var tw_mapForm = function(formInput){
    var retorna = formInput.map(function(index, elem){
        switch (elem.type) {
            case "radio":
                valor = elem.value;
                label = elem.labels[0];
                if(elem.checked){
                    $("#"+elem.id).prop('checked', false);
                    return { "id" : elem.id , "value" : valor, nombre : label.innerText };
                }
                break;
            case "checkbox":
                valor = elem.value;
                if(elem.checked){
                    return { "id" : elem.id , "value" : valor, nombre : label.innerText };
                }
                break;
            case "select":
                val = $("#" + elem.id + " option:selected").val();
                if(val !== 0){
                    //titulo = $("#" + elem.id + " option:selected").text();
                    return { "id" : elem.id , "value" : val };
                }
                break;
            default:
                valor = elem.value;
                if(valor.length > 0){
                    return { "id" : elem.id , "value" : valor };
                }
                break;
        }
    });
    return retorna;
};
var tw_mapValida = function(formInput){
    var retorna = formInput.map(function(index, elem){
        valor = elem.value;
        console.log(elem.type,"-->",valor);
        switch (elem.type) {
            case "select":
                if(valor == 0 || valor !="" ){
                    return $("#"+elem.id);
                }
                break;
            case "select-one":
                if(valor == 0){
                    return $("#"+elem.id);
                }
                break;
            case "radio":
                if(elem.checked == false){
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
/**/
var timer_pedido = function(){
    var timerPedido = setInterval(buscar, 3000);
    function buscar(){
        var url = DOMINIO + DIRECTORIO + DIRECTORIO_AJAX + "/ajax.lib.php",
            form = $("#form-pagar"),
            id_pedido = form.find("button").prop("id"),
            id_destino = "tw-completa";
        envia = inicaAjax(url, { origen : "verifica", id_pedido : id_pedido });
        envia.done(function(data) {
            console.log(data);
            if(data.estado){
                if(data.valor == "2"){
                    form.find("button").removeClass("d-none");
                }else if(data.valor == "4"){
                    $("#"+id_destino+" .modal-title").text("Pedido rechazado");
                    $("#"+id_destino+" .modal-body").text("Su pedido ha sido rechazado.");
                    $("#"+id_destino).modal('show');
                }
                if(data.valor == "2" || data.valor == "4"){
                    clearInterval(timerPedido);
                }
            }
        });
    }
};
var obj_existe = function(obj){
    var estado = false;
    if(parseInt(obj.length) == parseInt(0)){
        estado = true;
    }
    return estado;
};
var is_Mobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (is_Mobile.Android() || is_Mobile.BlackBerry() || is_Mobile.iOS() || is_Mobile.Opera() || is_Mobile.Windows());
    }
};