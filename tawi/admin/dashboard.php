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
        <div class="container-fluid p-3 tw-aa">
            <div class="row h-100">
                <div class="col-2">
                    <div class="nav flex-column nav-pills" id="v-tawi-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link actualizar active" id="v-activo-tab" data-toggle="pill" href="#v-activo" role="tab" aria-controls="v-activo" aria-selected="true">Activos</a>
                        <a class="nav-link actualizar" id="v-espera-tab" data-toggle="pill" href="#v-espera" role="tab" aria-controls="v-espera" aria-selected="false">En espera</a>
                        <a class="nav-link actualizar" id="v-pagados-tab" data-toggle="pill" href="#v-pagados" role="tab" aria-controls="v-pagados" aria-selected="false">Pagados</a>
                        <a class="nav-link actualizar" id="v-cancelado-tab" data-toggle="pill" href="#v-cancelado" role="tab" aria-controls="v-cancelado" aria-selected="false">Cancelado</a>
                    </div>
                </div>
                <div class="col-10">
                    <div class="tab-content h-100" id="v-tawi-tabContent">
<?php
    $pestañas = ["activo" => [1, "bg-secondary", "border-secondary"], "espera" => [2, "bg-warning", "border-warning"], "pagados" => [3, "bg-success", "border-success"], "cancelado" => [4, "bg-danger", "border-danger"]];
    foreach ($pestañas as $llave => $valor) {
        $active = ($llave == "activo") ? "show active" : "";
        echo "<div class=\"tab-pane fade h-100 $active\" id=\"v-$llave\" role=\"tabpanel\" aria-labelledby=\"v-$llave-tab\">";
        echo "<div class=\"row h-100 overflow-auto flex-nowrap\">";
        $pedidos = $datos->dashboard_pedido(date("Y-m-d"), $valor[0]);
        if (is_array($pedidos)) {
            foreach ($pedidos as $key => $value) {
?>
                        <div class="col-3 pl-0 pb-3">
                            <div id="<?php echo $key; ?>" class="card h-100 w-100 <?php echo $valor[2]; ?>">
                                <div class="card-header text-center text-white font-weight-bold <?php echo $valor[1]; ?>">
<?php
                if ($valor[0] == 1) {
?>                    
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-secondary text-white"><?php echo $value["codigo_pedido"]; ?></button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">&nbsp;</button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <a id="aceptar" class="dropdown-item">Aceptar</a>
                                                <a id="cancelar" class="dropdown-item">Rechazar</a>
                                            </div>
                                        </div>
                                    </div>
<?php
                } else {
                    echo $value["codigo_pedido"];
                }
?>
                                </div>
                                <div class="card-body tw-ac overflow-auto">
<?php
                $detalle = $datos->dashboard_pedidoDetalle($key);
                //echo "<pre>".print_r($detalle,true)."</pre>";
                $paquete = "";
                foreach ($detalle as $index => $val) {
                    $paquete .= "<div class=\"w-100 border-top border-bottom border-dark\">";
                    $paquete .= "<div class=\"d-flex\"><div class=\"mr-auto\">" . $val["producto"]["nombre"] . "</div><div> x ". $val["producto"]["cantidad"] . "</div></div>";
                    if(is_array($val["extra"])){
                        $paquete .= "<div class=\"\">";
                        foreach ($val["extra"] as $valores) {
                            $paquete .= "<div class=\"w-100\">" . $valores . "</div>";
                        }
                        $paquete .= "</div>";
                    }
                    $paquete .= !empty($val["comentario"])?"<div class=\"mr-auto\"><small>Comentario(s): </small>" . $val["comentario"] . "</div>":"";
                    $paquete .= "</div>";
                }
                echo $paquete;
?>
                                </div>
                                <div class="card-footer d-flex text-white <?php echo $valor[1]; ?>">
                                    <div class="mr-auto"><small><?php echo $value["creado"]; ?></small></div>
                                    <div class="font-weight-bold"><?php echo $value["total"]; ?></div>
                                </div>
                            </div>
                        </div>
<?php
            }
        } else {
            echo "<h3>En espera</h3>";
        }
        echo "</div>";
        echo "</div>";
    }
?>
                    </div>
                </div>
            </div>
        </div>
<?php
    require_once ("plantilla/footer.php");
?>
        <script type="text/javascript">
            $(function() {
                timer_dashboard();
            });
        </script>
    </body>
</html>