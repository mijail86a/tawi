<?php
    require_once('../lib/functions.lib.php');
    $datos = new libreria();
    $datos->login_existe();
?>
<!DOCTYPE html>
<html>
    <head>
<?php 
    require_once ("plantilla/header.php");
?>
    </head>
    <body>
<?php 
    require_once ("plantilla/header-navbar-x.php");
?>
        <div class="container-fluid p-3 tw-bg-b tw-aa">
            <div class="card w-100 h-100">
                <div class="card-header text-white tw-bg-a">CATEGORIAS</div>
                <div class="card-body h-100">
                    <div class="container-fluid h-100">
                        <div class="row h-100">
                            <div class="col-3">
                                <form id="categoria-1">
                                    <div class="form-group">
                                        <label class="tw-color-a" for="exampleFormControlInput1">CATEGORIA</label>
                                        <input type="text" class="form-control" id="tw-categoria" placeholder="ingrese nombre de categoria">
                                        <div class="invalid-feedback">Ingrese el nombre de categoria</div>
                                    </div>
                                    <button id="btn-registro-cat" type="button" class="btn tw-btn-a mb-2">GRABAR</button>
                                </form>
                            </div>
                            <div class="col-9 border-left border-black">
                                <div id="categoria-2" class="container-fluid">
                                    <div id="tw-destino" class="row">
<?php
    $usuario = $_COOKIE["generico"];
    $return = $datos->select_twcategoria_idusuario($usuario);
    if(is_array($return)){
        $boton = $datos->tw_buttons($return);
        echo $boton;
    }
?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php 
    require_once ("plantilla/footer.php");
?>
    </body>
</html>