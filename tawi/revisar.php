<?php
require_once('lib/functions.lib.php');
require_once('lib/carrito.lib.php');
$datos = new libreria();
$carrito = new carrito();
$id_usuario = isset($_COOKIE["id_cliente"]) || !empty($_COOKIE["id_cliente"])?$_COOKIE["id_cliente"]:0;
?>
<!DOCTYPE html>
<html>
    <head>
<?php
    include_once 'plantilla/header.php';
?>
    </head>
    <body>
        <div class="container-fluid tw-color-a">
            <div class="row h-100">
                <div class="col-12 col-md-7 col-lg-4 m-auto bg-light h-100 overflow-auto">
                    <div id="tw-cabezera" class="d-flex justify-content-between align-items-center my-2">
                        <a href="/"><img class="img-fluid lazy" data-src="<?php echo STATIC2 . DIRECTORIO . IMG . "logo-tawi.png"; ?>" alt="logo"></a>
<?php
    if($id_usuario == 0){
        echo "<button class=\"btn tw-btn-b\" aria-label=\"inicio de sesión\" data-toggle=\"modal\" data-target=\"#tw-login\">Iniciar sesión</button>";
    }else{
        echo "<div class=\"btn-group\" role=\"group\">
        <button type=\"button\" class=\"btn tw-btn-b\">".$_COOKIE["nombre_cliente"]."</button>
        <button id=\"btnGroupDrop1\" type=\"button\" class=\"btn tw-btn-b dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"></button>
        <div class=\"dropdown-menu\" aria-labelledby=\"btnGroupDrop1\">
        <a class=\"dropdown-item\" href=\"historial.php\"><i class=\"fas fa-list\"></i></i>&nbsp;Historial de pedidos</a>
        <a id=\"tw-salir\" class=\"dropdown-item\"><i class=\"fas fa-sign-out-alt\"></i>&nbsp;Salir</a>
        </div></div>";
    }
        //<a class=\"dropdown-item\" href=\"#\"><i class=\"far fa-edit\"></i>&nbsp;Editar</a>
?>
                    </div>
                    <div class="conteiner px-3">
                        <div id="tw-container" class="row font-weight-bold">
                            <div class="col-12 text-center text-white tw-bg-e tw-fj">Resumen de Pedido</div>
<?php
    $html="";
    $activo = "disabled=\"\"";
    $repetir = $_REQUEST["repetir"];
    $pedido = $_REQUEST["codigo"];
    if( $repetir == 1 || $repetir == 2 ){
        $carr = $datos->genera_carrito($pedido);
        $_SESSION["repeticua"] = $carr;
        //echo "<pre>".print_r($carr ,true)."</pre>";
        //echo "<pre>".print_r($carr,true)."</pre>";
    }else{
        $carr = $carrito->read_cart();
        //echo "<pre>".print_r($carr, true)."</pre>";
    }
    if( is_array($carr["items"]) ){
        $activo = "";
        foreach ($carr["items"] as $key => $value) {
            $html.="<div class=\"col-12 border-bottom tw-color-b tw-bg-f my-1\">";
            $html.="<form id=\"$key\">";
            $html.="<div class=\"row border-left border-right tw-bg-f\">";
            $html.="<div class=\"col-12 tw-color-a\">".$value["plato"]."</div>";
            $html.="<div class=\"col-7 pr-0\">Precio unitario:</div>";
            $html.="<div class=\"col-2 px-0 text-right\">S/.</div>";
            $html.="<div class=\"col-3 pl-0 tw-color-a text-right\">".$carrito->tw_format_number($value["precio"])."</div>";
            if($value["extras"]["estado"]){
                $html.="<div class=\"col-12\">Extras</div>";
                foreach ($value["extras"]["contenido"] as $index => $val) {
                    $html.="<div class=\"col-7 pr-0\"><i class=\"fas fa-ellipsis-h\"></i> ".$val["nombre"].":</div>";
                    $html.="<div class=\"col-2 px-0 text-right\">S/.</div>";
                    $html.="<div class=\"col-3 pl-0 tw-color-a text-right\">".$val["precio"]."</div>";
                }
            }
            if( $repetir == 1 || $repetir == 2 ){
                $html.="<div class=\"col-7 pr-0 mt-1\">Cantidad:</div>";
                $html.="<div class=\"col-5 pl-0 mt-1 tw-color-a text-right\">".$value["cantidad"]."</div>";
            }else{
                $html.="<div class=\"col-7 pr-0 mt-1\">Cantidad:</div>";
                $html.="<div class=\"col-5 pl-0 mt-1\">";
                $html.="<div class=\"btn-group btn-group-sm d-flex\" role=\"group\">";
                $html.="<button type=\"button\" class=\"btn tw-btn-b tw-minus-carrito\"><i class=\"fas fa-minus-circle\"></i></button>";
                $html.="<button type=\"button\" class=\"btn tw-btn-outline-b\">".$value["cantidad"]."</button>";
                $html.="<button type=\"button\" class=\"btn tw-btn-b tw-plus-carrito\"><i class=\"fas fa-plus-circle\"></i></button>";
                $html.="</div>";
                $html.="</div>";
                $html.="<div class=\"col-5 pl-0 offset-7 mt-1\">";
                $html.="<div class=\"btn-group btn-group-sm d-flex tw-delete\" role=\"group\">";
                $html.="<button type=\"button\" class=\"btn tw-btn-outline-b\">Eliminar:</button>";
                $html.="<button type=\"button\" class=\"btn tw-btn-b\"><i class=\"far fa-trash-alt\"></i></button>";
                $html.="</div>";
                $html.="</div>";
            }
            if(!empty($value["mensaje"])){
                $html.="<div class=\"col-12\">Instrucciones especiales:</div>";
                $html.="<div class=\"col-12 tw-color-a\">".$value["mensaje"]."</div>";
            }
            $html.="<div class=\"col-7 pr-0\">Total:</div>";
            $html.="<div class=\"col-2 px-0 text-right\">S/.</div>";
            $html.="<div class=\"col-3 pl-0 tw-precio text-right tw-color-a\">".$carrito->tw_format_number($value["costo"])."</div>";
            $html.="</div>";
            $html.="</form>";
            $html.="</div>";
        }
        $html.="<div class=\"col-12 tw-bg-e text-white tw-fj\">";
        $html.="<div class=\"row\">";
        $html.="<div class=\"col-7 pr-0\">TOTAL</div>";
        $html.="<div class=\"col-2 px-0 text-right\">S/.</div>";
        $html.="<div class=\"col-3 pl-0 tw-total text-right\">".$carrito->tw_format_number($carr["total"])."</div>";
        $html.="</div>";
        $html.="</div>";
        echo $html;
    }
?>
                            <div class="col-12 p-0 my-3">
<?php
    if($repetir == 1){
        echo "<a class=\"btn btn-block tw-btn-b\" href=\"historial.php\" role=\"button\" $activo >Regresar</a>";
    }elseif($repetir == 2){
        echo "<a class=\"btn btn-block tw-btn-b\" href=\"terminar.php\" role=\"button\" $activo >Confirmar pedido</a>";
    }else{
        echo "<div id=\"tw-accion\" class=\"btn-group d-flex\" role=\"group\">";
        echo "<a class=\"btn tw-btn-b flex-grow-1\" href=\"carta.php?id=".$_COOKIE["id_restaurante"]."\" role=\"button\">Seguir Comprando</a>";
        if($id_usuario > 0){
            echo "<a class=\"btn tw-btn-b flex-grow-1\" href=\"terminar.php\" role=\"button\" $activo >Confirmar pedido</a>";
        }else{
            echo "<button id=\"btn-acciones\" type=\"button flex-grow-1\" class=\"btn tw-btn-b\" data-toggle=\"modal\" data-target=\"#tw-login\">Confirmar pedido</button>";
        }
        echo "</div>";
        echo "</div>";
    }
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL -->
        <div id="tw-login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="tw-ingreso">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">INGRESAR</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tw-usuario">Usuario (correo)</label>
                                <input type="email" class="form-control tw-valida" id="tw-usuario" aria-describedby="usuario" placeholder="Ingrese usuario">
                                <div class="invalid-feedback">Escriba correctamente el usuario</div>
                            </div>
                            <div class="form-group">
                                <label for="tw-clave">Contraseña</label>
                                <input type="password" class="form-control tw-valida" id="tw-clave" placeholder="Ingrese contraseña">
                                <div class="invalid-feedback">Escriba correctamente la contraseña</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-primary tw-btn-b mr-auto rounded-0" href="nuevo_usuario.php" role="button">Nuevo usuario</a>
                            <a class="btn btn-primary tw-btn-b rounded-0" href="cambiar.php" role="button">Cambiar contraseña</a>
                            <button type="button" class="btn tw-btn-a" data-dismiss="modal">Cerrar</button>
                            <button id="tw-logeo" type="button" class="btn tw-btn-b">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
    include_once 'plantilla/footer.php';
?>
        <script type="text/javascript">
            $(".lazy").lazyload();
        </script>
    </body>
</html>
<?php

?>