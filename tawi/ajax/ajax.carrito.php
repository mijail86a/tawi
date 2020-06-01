<?php
    require_once('../lib/carrito.lib.php');
    $datos = new carrito();
    switch ($_REQUEST["origen"]) {
    	case "add":
            $id = $_REQUEST["id"];
            $precio = $_REQUEST["precio"];
            $cantidad = $_REQUEST["cantidad"];
            $mensaje = $_REQUEST["mensaje"];
            $plato = $_REQUEST["plato"];
            $extras = $_REQUEST["extras"];
            $extra["estado"] = false;
            if(is_array($extras)){
                $extra["estado"] = true;
                foreach ($extras as $value) {
                    $precio_extra = $value["value"]!==""?$value["value"]:"0.00";
                    $extra["contenido"][$value["id"]] = [ "precio" => $datos->tw_format_number($precio_extra) , "nombre" => $value["nombre"] ];
                }
            }
            $return = $datos->add_cart($id, $precio, $cantidad, $mensaje, $plato, $extra);
            break;
        case "edit":
            $id = $_REQUEST["id"];
            $cantidad = $_REQUEST["cantidad"];
            $return = $datos->edit_cart($id, $cantidad);
            break;
        case "delete":
            $id = $_REQUEST["id"];
            $return = $datos->delete_cart($id);
            break;
    	default:
    		# code...
    		break;
    }
    echo json_encode($return);
?>