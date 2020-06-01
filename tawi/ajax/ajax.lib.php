<?php
    require_once('../lib/functions.lib.php');
    $datos = new libreria();

    switch ($_REQUEST["origen"]) {
    	case 'buscar':
    		$datos->nombre = $_REQUEST["patron"];
    		$return = $datos->cliente_buscar();
    		break;
        case "verifica":
            $id_pedido = explode("-",$_REQUEST["id_pedido"]);
            $id_pedido = end($id_pedido);
            $result = $datos->pedido_verfica($id_pedido);
            $return = [ "estado" => false ];
            if(is_array($result)){
                foreach ($result as $key => $value) {
                    $estado = $value["estado"];
                }
                $return = [ "estado" => true, "valor" => $value["estado"] ];
            }
            break;
        case "proceso":
            $estado = 3;
            $id_pedido = explode("-",$_REQUEST["codigo"]);
            $id_pedido = end($id_pedido);
            $return = $datos->pedido_acepta($id_pedido, $estado);
            break;
        case "logeo":
            $detalle = $_REQUEST["agregado"];
            foreach ($detalle as $key => $value) {
                $logeo[$value["id"]] = $value["value"];
            }
            $return = $datos->login_ingresoWeb($logeo);
            setcookie("id_cliente", $return["detalle"]["id"], time() + (60 * 60 * 24 * 30), "/");
            setcookie("nombre_cliente", $return["detalle"]["usuario"], time() + (60 * 60 * 24 * 30), "/");
            break;
        case "salir":
            setcookie("id_cliente", "", time() - 1, "/");
            setcookie("nombre_cliente", "", time() - 1, "/");
            $return = true;
            break;
        case "reporte-cliente":
            $result = $datos->dashboard_pedidoReporte(1, 0, $_REQUEST["estado"]);
            $return = $result;
            break;
    	default:
    		# code...
    		break;
    }
    echo json_encode($return);
?>