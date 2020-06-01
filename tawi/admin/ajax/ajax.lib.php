<?php
    require_once('../../lib/functions.lib.php');
    $datos = new libreria();
    $datos->usuario = 1;
    switch ($_REQUEST["origen"]) {
    	case 'categoria-1':
    		$categoria = $_REQUEST["categoria"];
            $id = $datos->insertTwcategoria($categoria);
    		$return = [ "id" => $id , "titulo" => $categoria];
    		break;
        case 'categoria-2':
            $result = explode("-",$_REQUEST["id"]);
            $id = end($result);
            $result = $datos->updateTwcategoria($id,$_REQUEST["estado"]);
            $return = $result > 0?true:false;
            break;
        case 'producto-1':
            $producto = $_REQUEST["producto"];
            foreach ($producto as $value) {
                $productos[$value["id"]] = $value["valor"];
            }
            $result = explode("-",$productos["tw-identidad"]);
            $id_dst = end($result);
            $id = $datos->insertTwproducto($id_dst, $productos["tw-producto"], $productos["tw-precio"], $productos["tw-imagen"], $productos["tw-descripcion"]);
            $return = [ "id" => $id , "destino" => $id_dst , "titulo" => $productos["tw-producto"]];
            //$return = $productos;
            break;
        case 'producto-2':
            $result = explode("-",$_REQUEST["id"]);
            $id = end($result);
            $result = $datos->updateTwproducto($id,$_REQUEST["estado"]);
            $return = $result > 0?true:false;
            break;
        case 'agregado-1':
            $agregado = $_REQUEST["agregado"];
            foreach ($agregado as $value) {
                $agregados[$value["id"]] = $value["valor"];
            }
            $result = explode("-",$agregados["tw-identidad"]);
            $id_dst = end($result);
            $id = $datos->insertTwagregado( $id_dst, $agregados["tw-nombre"], $agregados["tw-obligatorio"], $agregados["tw-descripcion"] );
            $return = [ "id" => $id , "destino" => $id_dst , "titulo" => $agregados["tw-nombre"] , "result" => $result ];
            //$return = false;
            break;
        case 'agregado-2':
            $result = explode("-",$_REQUEST["id"]);
            $id = end($result);
            $result = $datos->updateTwagregado($id,$_REQUEST["estado"]);
            $return = $result > 0?true:false;
            break;
        case 'extra-1':
            $extra = $_REQUEST["extra"];
            foreach ($extra as $value) {
                $extras[$value["id"]] = $value["valor"];
            }
            $result = explode("-",$extras["tw-identidad"]);
            $id_dst = end($result);
            $id = $datos->insertTwextra( $id_dst, $extras["tw-nombre"], $extras["tw-precio"], $extras["tw-descripcion"] );
            $return = [ "id" => $id , "destino" => $id_dst , "titulo" => $extras["tw-nombre"] , "result" => $result ];
            //$return = false;
            break;
        case 'extra-2':
            $result = explode("-",$_REQUEST["id"]);
            $id = end($result);
            $result = $datos->updateTwextra($id,$_REQUEST["estado"]);
            $return = $result > 0?true:false;
            break;
        case "pedido-estado":
            $result = $datos->pedido_acepta($_REQUEST["id"], $_REQUEST["estado"]);
            break;
        case "pedido-visto":
            $destino = $_REQUEST["destino"];
            switch ($destino) {
                case 'v-activo-tab':
                    $estado = 1;
                    break;
                case 'v-espera-tab':
                    $estado = 2;
                    break;
                case 'v-pagados-tab':
                    $estado = 3;
                    break;
                case 'v-cancelado-tab':
                    $estado = 4;
                    break;
            }
            $pedido = $datos->dashboard_pedido_estado($estado,1);
            if($pedido["estado"]){
                $pedido["destino"] = $estado;
                foreach ($pedido["contenido"] as $key => $value) {
                    $detalle = $datos->dashboard_pedidoDetalle($key);
                    $pedido["contenido"][$key]["extras"] = $detalle;
                }
                $datos->pedido_automatiza_multiUpdate($pedido);
            }
            $return = $pedido;
            break;
        case "reporte-automatico":
            $result = $datos->dashboard_pedidoReporte(0, 0, $_REQUEST["estado"]);
            $return = $result;
            break;
        case "reporte":
            $result = $datos->dashboard_pedidoReporte($_REQUEST["start"], $_REQUEST["end"], $_REQUEST["estado"]);
            $return = $result;
            break;
    	default:
    		# code...
    		break;
    }
    echo json_encode($return);
?>