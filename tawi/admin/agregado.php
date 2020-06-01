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
                <div class="card-header text-white tw-bg-a">CATEGORIA - EXTRA</div>
                <div class="card-body tw-ab">
                    <div class="container-fluid h-100">
                        <div class="row h-100">
                            <div id="tw-destino" class="col-12 h-100">
                                <div class="row h-100">
                                    <div class="col-3 h-100 overflow-auto">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link active tw-color-a tw-btn-a" id="tw-all-tab" data-toggle="pill" data-destino="#agregado-1" href="#tw-all" role="tab" aria-controls="tw-all" aria-selected="true">Inicio</a>
<?php 
    $categoria = $datos->select_twcategoria_idusuario_lista(1);
    if(is_array($categoria)){
        foreach ($categoria as $key => $value) {
            $producto = $datos->select_twproducto_idcategoria($key);
            echo "<div class=\"border-bottom border-dark m-2 font-weight-bold\">".$value["nombre"]."</div>";
            foreach ($producto as $llave => $valor) {
                $destino = "tw-".$llave;
                $tabs = "tab-".$llave;
                echo "<a class=\"nav-link tw-color-a\" id=\"$tabs\" data-toggle=\"pill\" data-destino=\"#agregado-1\" href=\"#$destino\" role=\"tab\" aria-controls=\"$destino\" aria-selected=\"false\">".$valor["nombre"]."</a>";
            }
        }
    }
?>
                                        </div>
                                    </div>
                                    <div class="col-9 h-100 border-left border-black">
                                        <div class="container-fluid h-100">
                                            <div class="row h-100">
                                                <div class="col-4 h-100 overflow-auto">
                                                    <form id="agregado-1">
                                                        <input class="tw-valida" type="hidden" id="tw-identidad" value="">
                                                        <div class="form-group">
                                                            <label class="tw-color-a" for="exampleFormControlInput1">Extra</label>
                                                            <input type="text" class="form-control tw-valida" id="tw-nombre" placeholder="ingrese nombre del agregado" disabled>
                                                            <div class="invalid-feedback">Ingrese el nombre del agregado</div>
                                                        </div>
                                                        <div class="form-group custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="tw-obligatorio" disabled>
                                                            <label class="custom-control-label" for="tw-obligatorio">OBLIGATORIO *</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="tw-color-a" for="exampleFormControlInput1">DESCRIPCIÓN</label>
                                                            <textarea class="form-control" id="tw-descripcion" rows="3" placeholder="ingrese la descripción opcional" disabled></textarea>
                                                            <div class="invalid-feedback">Ingrese la descripción opcional</div>
                                                        </div>
                                                        <button id="btn-registro-agr" type="button" class="btn tw-btn-a mb-2" disabled>GRABAR</button>
                                                    </form>
                                                    <span class="mb-1 badge badge-light text-wrap text-left">* Al activar esta opcion no se mostraran el mensaje ingresado</span>
                                                </div>
                                                <div class="col-8 h-100 overflow-auto border-left border-black">
                                                    <div class="tab-content" id="agregado-2">
                                                        <div class="tab-pane fade show active" id="tw-all" role="tabpanel" aria-labelledby="tw-all-tab">
                                                            <div class="alert alert-success" role="alert">
                                                                <h4 class="alert-heading">Agregar extras a los productos</h4>
                                                                <p>Seleccione un producto de la lista de la izquierda para agregar categoria de extra.</p>
                                                                <hr>
                                                                <p class="mb-0">Puede agregar tantos extras como desee</p>
                                                            </div>
                                                        </div>
<?php
    if(is_array($categoria)){
        foreach ($categoria as $key => $value) {
            $producto = $datos->select_twproducto_idcategoria($key);
            if(is_array($producto)){
                foreach ($producto as $llave => $valor) {
                    $agregado = $datos->tw_agregado_idproducto($llave);
                    $button = "";
                    $destino = "tw-".$llave;
                    $tabs = "tab-".$llave;
                    $tab .= "<div class=\"tab-pane fade\" id=\"$destino\" role=\"tabpanel\" aria-labelledby=\"$tabs\">";
                    if(is_array($agregado)){
                        $tab .= $datos->tw_buttons($agregado);
                    }else{
                        $tab .= "<div class=\"alert alert-success\" role=\"alert\">";
                        $tab .= "    <h4 class=\"alert-heading\">Extras - ". $valor["nombre"] ."</h4>";
                        $tab .= "    <p>No hay extras registrados.</p>";
                        $tab .= "    <hr>";
                        $tab .= "    <p class=\"mb-0\">Agregue extras utilizando el formulario de la izquierda.</p>";
                        $tab .= "</div>";
                    }
                    $tab .= "</div>";
                }
                //$button = $datos->tw_buttons($producto);
                //$tab .= $button;
            }
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