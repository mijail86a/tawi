<?php
    require_once('lib/functions.lib.php');
    $datos = new libreria();
    $cliente = $datos->cliente_lista();
    $id_usuario = isset($_COOKIE["id_cliente"]) || !empty($_COOKIE["id_cliente"])?$_COOKIE["id_cliente"]:0;
    //echo "<pre>".print_r($cliente,true)."</pre>";
?>
<!DOCTYPE html>
<html lang="es">
    <head>
<?php
    include_once 'plantilla/header.php';
?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-7 col-lg-4 m-auto">
                    <div id="tw-cabezera" class="d-flex justify-content-between align-items-center my-2">
                        <a href="/"><img class="img-fluid" src="<?php echo STATIC2.DIRECTORIO.IMG."logo-tawi.png"; ?>"></a>
<?php
    if($id_usuario == 0){
        echo "<button class=\"btn tw-btn-b\" aria-label=\"inicio de sesión\" data-toggle=\"modal\" data-target=\"#tw-login\">Iniciar sesión</button>";
    }else{
        echo "<div class=\"btn-group\" role=\"group\">
        <button type=\"button\" class=\"btn tw-btn-b\">".$_COOKIE["nombre_cliente"]."</button>
        <button id=\"btnGroupDrop1\" type=\"button\" class=\"btn tw-btn-b dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"></button>
        <div class=\"dropdown-menu\" aria-labelledby=\"btnGroupDrop1\">
        <a class=\"dropdown-item\" href=\"cambiar.php\"><i class=\"fas fa-key\"></i>&nbsp;Cambiar contraseña</a>
        <a class=\"dropdown-item\" href=\"historial.php\"><i class=\"fas fa-list\"></i>&nbsp;Historial de pedidos</a>
        <a id=\"tw-salir\" class=\"dropdown-item\"><i class=\"fas fa-sign-out-alt\"></i>&nbsp;Salir</a>
        </div></div>";
    }
    //    <a class=\"dropdown-item\" href=\"#\"><i class=\"far fa-edit\"></i>&nbsp;Editar</a>
?>
                    </div>
                    <nav class="navbar navbar-light px-0">
                        <form class="form-inline w-100">
                            <div class="input-group w-100">
                                <input type="text" class="form-control" placeholder="Buscar restaurantes" aria-label="Buscar restaurantes" aria-describedby="Buscar restaurantes o comida">
                                <div class="input-group-append">
                                    <button class="btn tw-btn-a" type="button" id="button-addon2">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </nav>
                    <div class="conteiner-fluid">
                        <div class="row">
                            <div class="col-12 h-100 overflow-auto">
<?php
    foreach ($cliente as $key => $value) {
?>
                                <div id="<?php echo $key;?>" class="card border-0">
                                    <a href="carta.php?id=<?php echo $key;?>" class="card-link">
                                        <figure class="img-fluid">
                                            <div class="w-100 h-100">
                                                <img class="w-100 h-100 tw-fb tw-fg" alt="<?php echo $value["nombre"]?>" src="<?php echo $value["logo"]?>">
                                            </div>
                                        </figure>
                                        <h4 class="card-title tw-color-a"><?php echo $value["nombre"]?></h4>
                                    </a>
                                </div>
<?php
    }
?>
                            </div>
                        </div>
                        
                    </div>
                    <div class="w-100 bg-dark">&nbsp;</div>
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
                            <button type="button" id="tw-logeo" class="btn tw-btn-b">Login</button>
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