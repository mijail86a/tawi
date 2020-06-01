<?php
    require_once('lib/functions.lib.php');
    require_once('lib/carrito.lib.php');
    $datos = new libreria();
    $carrito = new carrito();
    $id = $_REQUEST["id"];
    $id_usuario = isset($_COOKIE["id_cliente"]) || !empty($_COOKIE["id_cliente"])?$_COOKIE["id_cliente"]:0;
    setcookie("id_restaurante", $id, time() + (60 * 60 * 24), "/");
    $detalle = $datos->cliente_individual($id);
    $carr = $carrito->read_cart();
    $items = $carr["items"];
    //echo "<pre>".print_r($carr, true)."</pre>";
    $display = is_array($carr["items"]) ? "block" : "none";
?>
<!DOCTYPE html>
<html lang="es">
    <head>
<?php
    include_once 'plantilla/header.php';
?>
    </head>
    <body>
<?php 
    if (is_array($items)) {
?>
        <div id="panel-lateral" class="container-fluid h-100 position-fixed overflow-auto tw-fk tw-fo" data-estado="close">
            <div class="row h-100">
                <div class="col-12 col-md-3 col-lg-4 ml-auto bg-light h-100 overflow-auto">
                    <div class="conteiner px-3">
                        <div id="tw-container" class="row font-weight-bold">
                            <div class="col-12 text-dark tw-fc tw-fi tw-btn-ver"><i class="fas fa-times"></i></div>
                            <div class="col-12 tw-bg-a text-center text-white">Resumen de Pedido</div>
<?php
        $html = "";
        foreach ($items as $key => $value) {
            $html .= "<div class=\"col-12 border-bottom tw-bg-c my-1\">";
            $html .= "<form id=\"$key\">";
            $html .= "<div class=\"row border-left border-right tw-bg-c\">";
            $html .= "<div class=\"col-12 tw-color-a\">" . $value["plato"] . "</div>";
            $html .= "<div class=\"col-7 pr-0 tw-color-b\">Precio unitario:</div>";
            $html .= "<div class=\"col-2 px-0 tw-color-b text-right\">S/.</div>";
            $html .= "<div class=\"col-3 pl-0 text-right\">" . $carrito->tw_format_number($value["precio"]) . "</div>";
            if ($value["extras"]["estado"]) {
                $html .= "<div class=\"col-12 tw-color-b\">Extras</div>";
                foreach ($value["extras"]["contenido"] as $index => $val) {
                    $html .= "<div class=\"col-7 pr-0 tw-color-b\"><i class=\"fas fa-ellipsis-h\"></i> " . $val["nombre"] . ":</div>";
                    $html .= "<div class=\"col-2 px-0 tw-color-b text-right\">S/.</div>";
                    $html .= "<div class=\"col-3 pl-0 text-right\">" . $val["precio"] . "</div>";
                }
            }
            $html .= "<div class=\"col-7 pr-0 mt-1 tw-color-b\">Cantidad:</div>";
            $html .= "<div class=\"col-5 pl-0 mt-1\">";
            $html .= "<div class=\"btn-group btn-group-sm d-flex\" role=\"group\">";
            $html .= "<button type=\"button\" class=\"btn tw-btn-a tw-minus-carrito\"><i class=\"fas fa-minus-circle\"></i></button>";
            $html .= "<button type=\"button\" class=\"btn tw-btn-outline-a\">" . $value["cantidad"] . "</button>";
            $html .= "<button type=\"button\" class=\"btn tw-btn-a tw-plus-carrito\"><i class=\"fas fa-plus-circle\"></i></button>";
            $html .= "</div>";
            $html .= "</div>";
            $html .= "<div class=\"col-7 pr-0\"></div>";
            $html .= "<div class=\"col-5 pl-0 mt-1\">";
            $html .= "<div class=\"btn-group btn-group-sm d-flex tw-delete\" role=\"group\">";
            $html .= "<button type=\"button\" class=\"btn tw-btn-outline-a\">Eliminar:</button>";
            $html .= "<button type=\"button\" class=\"btn tw-btn-a\"><i class=\"far fa-trash-alt\"></i></button>";
            $html .= "</div>";
            $html .= "</div>";
            if (!empty($value["mensaje"])) {
                $html .= "<div class=\"col-12 tw-color-b\">Instrucciones especiales:</div>";
                $html .= "<div class=\"col-12\">" . $value["mensaje"] . "</div>";
            }
            $html .= "<div class=\"col-7 pr-0 mb-3 tw-color-b\">Total:</div>";
            $html .= "<div class=\"col-2 px-0 mb-3 tw-color-b text-right\">S/.</div>";
            $html .= "<div class=\"col-3 pl-0 mb-3 text-right tw-precio\">" . $carrito->tw_format_number($value["costo"]) . "</div>";
            $html .= "</div>";
            $html .= "</form>";
            $html .= "</div>";
        }
        $html .= "<div class=\"col-12 tw-bg-a text-white tw-fj\">";
        $html .= "<div class=\"row\">";
        $html .= "<div class=\"col-7\">TOTAL</div>";
        $html .= "<div class=\"col-2 text-right\">S/.</div>";
        $html .= "<div class=\"col-3 text-right tw-total\">" . $carrito->tw_format_number($_SESSION["carrito"]["total"]) . "</div>";
        $html .= "</div>";
        $html .= "</div>";
        echo $html;
?>
                            <div class="col-12 p-0 my-3"><a class="btn btn-block tw-btn-a" href="revisar.php" role="button">CONFIRMAR</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
?>
    <div class="row">
        <div id="menu-opt" class="col-12 col-md-6 col-lg-4 m-auto bg-white overflow-auto px-0 pb-2" style="display: none;">
            <div class="btn-group btn-group m-1" role="group">
<?php
    $categoria = $datos->select_twcategoria_idusuario($id);
    foreach ($categoria as $key => $value) {
        echo "<a role=\"button\" class=\"btn tw-btn-outline-b tw-fh\" href=\"#" . str_replace(" ", "-", $value["nombre"]) . "\">" . ucfirst($value["nombre"]) . "</a>";
    }
?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-7 col-lg-4 m-auto h-100">
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
?>
                </div>
                <img class="img-fluid w-100 lazy mb-3" data-src="<?php echo $detalle["fondo"]; ?>" alt="<?php echo $detalle["nombre"] ?>">
                <div id="shopping-cart" class="text-right mb-3" style="display: <?php echo $display; ?>">
                    <div class="btn-group btn-group tw-btn-ver" role="group" aria-label="Carrito de compra">
                        <button class="btn tw-btn-b" type="button">VER CARRITO</button>
                        <button class="btn tw-btn-outline-b" type="button">
                            <img class="img-fluid lazy bg-white tw-fa tw-ff" data-src="<?php echo STATIC2 . DIRECTORIO . IMG . "notas-32.png"; ?>" alt="notas">
                        </button>
                    </div>
                </div>
                <h4 class="tw-color text-center font-weight-bold"><?php echo $detalle["nombre"] ?></h4>
<?php
    foreach ($categoria as $key => $value) {
        $id_nivel_1 = "fw-cat-1-" . $key;
?>
                    <div id="<?php echo str_replace(" ", "-", $value["nombre"]); ?>" class="w-100">
                        <h5 class="tw-color my-2 text-center font-weight-bold"><?php echo ucfirst($value["nombre"]); ?></h5>
<?php
        $producto = $datos->select_twproducto_idcategoriaEstado($key, 1);
        if (is_array($producto)) {
?>
                        <div id="<?php echo $id_nivel_1; ?>" class="accordion fw-categorias">
<?php
            foreach ($producto as $index => $val) {
                $codigo = $index;
                $dst_nivel_2 = "dst-" . $codigo;
                $he_nivel_2 = "he-" . $codigo;
                $id_nivel_3 = "fw-cat-2-" . $index;
                $form = "fr-" . $index;
?>
                            <div id="<?php echo $form; ?>" class="card border-0 ">
                                <div id="<?php echo $he_nivel_2; ?>" class="border-bottom border-dark p-2 collapsed tw-fi" data-toggle="collapse" data-target="#<?php echo $dst_nivel_2; ?>" data-nivel="nivel-1" aria-expanded="true">
                                    <div class="d-flex tw-subtitulo">
                                        <div class="mr-auto">
                                            <div class="tw-titulo"><?php echo ucfirst($val["nombre"]); ?></div>
                                            <div class="tw-fl">S/. <?php echo $val["precio"]; ?></div>
                                        </div>
<?php 
                $cantidad = $carr["contador"];
                if( is_array($carr["contador"]) && $cantidad[$form] > 0 ){
                    echo "<div class=\"tw-cantidad tw-fd d-flex align-items-center\">$cantidad[$form]</div>";
                }
?>
                                    </div>
                                </div>
                                <div id="<?php echo $dst_nivel_2; ?>" class="collapse border-bottom border-dark" data-parent="#<?php echo $id_nivel_1; ?>">
<?php
                if (!empty($val["imagen"])) { echo "<img class=\"img-fluid w-100 lazy\" data-src=\"".$val["imagen"]."\" alt=\"".$val["nombre"]."\">"; }
                if (!empty($val["descripcion"])) { echo "<p>".$val["descripcion"]."</p>"; }
                $agregado = $datos->tw_agregado_idproductoEstado($index, 1);
                if (is_array($agregado)) {
?>
                                    <div id="<?php echo $id_nivel_3; ?>" class="accordion">
<?php
                    unset($disabled);
                    $disabled = array();
                    foreach ($agregado as $indices => $valores) {
                        $codigo = $indices;
                        $dst_nivel_3 = "dst-" . $codigo;
                        $he_nivel_3 = "he-" . $codigo;
                        $obliga = $valores["obligatorio"];
?>
                                        <div class="p-2 border-bottom border-dark collapsed tw-color tw-fi" data-toggle="collapse" data-target="#<?php echo $dst_nivel_3; ?>" data-nivel="nivel-2" aria-expanded="true" aria-controls="<?php echo $he_nivel_3; ?>">
<?php
                        echo ucfirst($valores["nombre"]);
                        $disabled[] = $obliga;
                        switch ($obliga) {
                            case '1':
                                echo "<br/><span class=\"tw-fl\">Obligatorio</span>";
                                break;
                            default:
                                if (!empty($valores["mensaje"])){
                                    echo "<br/><span class=\"tw-fl\">" . $valores["mensaje"] . "</span>";
                                }
                                break;
                        }
?>
                                        </div>
                                        <div id="<?php echo $dst_nivel_3; ?>" class="card-body collapse" aria-labelledby="<?php echo $he_nivel_3; ?>" data-parent="#<?php echo $id_nivel_3; ?>">
<?php
                        $extras = $datos->tw_extras_idagregadoEstado($indices, 1);
                        if (is_array($extras)) {
                            foreach ($extras as $indice => $valor) {
                                $indice_rand = $indice;
                                $type = $obliga == 1 ? "radio" : "checkbox";
                                $form_check = $type . "-" . $indice_rand;
?>
                                            <div class="d-flex justify-content-between">
                                                <div class="custom-control custom-<?php echo $type; ?>" data-collapse="#<?php echo $dst_nivel_3; ?>" data-target="#<?php echo $dst_nivel_2; ?>">
                                                    <input id="<?php echo $form_check; ?>" class="custom-control-input tw-extra tw-check" name="<?php echo "extras-" . $codigo; ?>" type="<?php echo $type; ?>" value="<?php echo $valor["precio"]; ?>">
                                                    <label class="custom-control-label" for="<?php echo $form_check; ?>"><?php echo $valor["nombre"]; ?></label>
                                                </div>
                                                <?php echo ($valor["precio"] > 0) ? "S./ ".$carrito->tw_format_number($valor["precio"]) : ""; ?>
                                            </div>
<?php
                            }
                        }
?>
                                        </div>
<?php
                    }
?> 
                                    </div>
<?php
                }
                if(is_array($disabled)){
                    $disabled = in_array( 1, $disabled )?"disabled":"";
                }else{
                    $disabled = "";
                }
?>
                                    <div class="form-group">
                                        <label class="tw-bg-b w-100 text-white py-2 px-3">Instrucciones especiales</label>
                                        <textarea class="form-control " rows="3"></textarea>
                                    </div>
                                    <button type="button" class="btn btn-block tw-btn-b tw-btn-carrito my-3" data-precio="<?php echo $val["precio"]; ?>" <?php echo $disabled; ?>><img class="img-fluid lazy tw-ff" data-src="<?php echo STATIC2 . DIRECTORIO . IMG . "carrito-de-compras-32.png"; ?>" alt="carrito"> <?php echo "Agregar 1 al pedido S/. " . $carrito->tw_format_number($val["precio"]); ?></button>
                                </div>
                            </div>
<?php
            }
?>
                        </div>
<?php
        }
?>
                    </div>
<?php
    }
?>
                    <div class="w-100 mt-3 tw-bg-e" style="height: 4rem;"></div>
                </div>
            </div>
        </div>
    <!-- MODAL -->
        <div id="tw-recomendacion" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Recomendación:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <p>¿Qué se te antoja hoy?, te recomendamos realizar todas las ordenes de tu mesa en un solo pedido.</p>
                        <p>¡Buen Provecho!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                                <input type="email" class="form-control tw-valida" id="tw-usuario" aria-describedby="usuario" placeholder="Ingrese usuario" autocomplete="username">
                                <div class="invalid-feedback">Escriba correctamente el usuario</div>
                            </div>
                            <div class="form-group">
                                <label for="tw-clave">Contraseña</label>
                                <input type="password" class="form-control tw-valida" id="tw-clave" placeholder="Ingrese contraseña" autocomplete="current-password">
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

            $(function() {
                $("#tw-recomendacion").modal('show');
            });
            //alert("se actualizo la pagina");
        </script>
    </body>
</html>