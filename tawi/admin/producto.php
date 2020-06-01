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
                <div class="card-header text-white tw-bg-a">PRODUCTOS</div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div id="tw-destino" class="col-12">
                                <div class="row">
                                    <div class="col-2 pl-0">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link active tw-color-a tw-btn-a" id="tw-all-tab" data-toggle="pill" href="#tw-all" role="tab" aria-controls="tw-all" aria-selected="true">Todos los productos</a>
<?php 
    $categoria = $datos->select_twcategoria_idusuario_lista(1);
    if(is_array($categoria)){
        foreach ($categoria as $key => $value) {
            $destino = "tw-".$key;
            $tabs = "tab-".$key;
            echo "<a class=\"nav-link tw-color-a\" id=\"$tabs\" data-toggle=\"pill\" data-destino=\"#producto-1\" href=\"#$destino\" role=\"tab\" aria-controls=\"$destino\" aria-selected=\"false\">".$value["nombre"]."</a>";
        }
    }
?>
                                        </div>
                                    </div>
                                    <div class="col-10 pr-0 border-left border-black">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-3 pl-0">
                                                    <form id="producto-1">
                                                        <input class="tw-valida" type="hidden" id="tw-identidad" value="">
                                                        <div class="form-group">
                                                            <label class="tw-color-a" for="exampleFormControlInput1">PRODUCTO</label>
                                                            <input type="text" class="form-control tw-valida" id="tw-producto" placeholder="ingrese nombre de producto" disabled>
                                                            <div class="invalid-feedback">Ingrese el nombre de producto</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="tw-color-a" for="exampleFormControlInput1">PRECIO</label>
                                                            <input type="text" class="form-control tw-valida" id="tw-precio" placeholder="ingrese precio de producto" disabled>
                                                            <div class="invalid-feedback">Ingrese el precio de producto</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="tw-color-a" for="exampleFormControlInput1">URL DE IMAGEN</label>
                                                            <textarea class="form-control" id="tw-imagen tw-valida" rows="3" placeholder="ingrese url de imagen de producto" disabled></textarea>
                                                            <div class="invalid-feedback">Ingrese la url de imagen producto</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="tw-color-a" for="exampleFormControlInput1">DESCRIPCIÓN</label>
                                                            <textarea class="form-control" id="tw-descripcion" rows="3" placeholder="ingrese url de imagen de descripción" disabled></textarea>
                                                            <div class="invalid-feedback">Ingrese la descripción de producto</div>
                                                        </div>
                                                        <button id="btn-registro-pro" type="button" class="btn tw-btn-a mb-2" disabled>GRABAR</button>
                                                    </form>
                                                </div>
                                                <div class="col-9 pr-0 border-left border-black">
                                                    <div class="tab-content" id="producto-2">
                                                        <div class="tab-pane fade show active" id="tw-all" role="tabpanel" aria-labelledby="tw-all-tab">
<?php
    $tab = "";
    $usuario = $_COOKIE["generico"];
    $producto = $datos->select_twproducto_idusuario($usuario);
    if(is_array($producto)){
        $button = $datos->tw_buttons($producto);
        echo $button;
    }
?>
                                                        </div>
<?php
    if(is_array($categoria)){
        foreach ($categoria as $key => $value) {
            $button = "";
            $destino = "tw-".$key;
            $tabs = "tab-".$key;
            $producto = $datos->select_twproducto_idcategoria($key);
            $button = $datos->tw_buttons($producto);
            $tab .= "<div class=\"tab-pane fade\" id=\"$destino\" role=\"tabpanel\" aria-labelledby=\"$tabs\">$button</div>";
        }
        echo $tab;
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
                    </div>
                </div>
            </div>
        </div>
<?php 
    require_once ("plantilla/footer.php");
?>
    </body>
</html>
<?php
function tw_buttons($producto){
    $button = "";
    foreach ($producto as $key => $value) {
        if($value["estado"] == 1){
            $estilo = [ "estado" => "tw-activo" , "icono" => "<i class=\"fas fa-check\"></i>" , "color" => "btn-success" , "color-outline" => "btn-outline-success" ];
        }else{
            $estilo = [ "estado" => "tw-inactivo" , "icono" => "<i class=\"fas fa-times\"></i>" , "color" => "btn-danger" , "color-outline" => "btn-outline-danger"];
        }
        $id = "tw-button-".$key;
        $button.="<div id=\"$id\" class=\"btn-group btn-group-sm mr-1 mb-1 ".$estilo["estado"]."\" role=\"group\">";
        $button.="    <button type=\"button\" class=\"btn ".$estilo["color"]." tw-in tw-icono btn-estado\">".$estilo["icono"]."</button>";
        $button.="    <button type=\"button\" class=\"btn ".$estilo["color-outline"]." tw-out btn-estado\">".$value["producto"]."</button>";
        $button.="    <button type=\"button\" class=\"btn ".$estilo["color"]." tw-in btn-edit\"><i class=\"far fa-edit\"></i></button>";
        $button.="    <button type=\"button\" class=\"btn ".$estilo["color"]." tw-in btn-estado\"><i class=\"far fa-trash-alt\"></i></button>";
        $button.="</div>";
    }
    return $button;
}
?>