<?php
session_start();
require_once('conexion.lib.php');
require_once('constant.php');
date_default_timezone_set('America/Lima');

class libreria extends conexion{
    public $estado = 1;
    public $nombre = "";
    
    public $id = 0;
    public $usuario = 0;

    private $individual = "";
    private $date_time = "";
    private $date = "";

    public function __construct(){
        parent::__construct();
        $this->date_time = $this->tw_isNull(date("Y-m-d H:i:s"));
        $this->date = $this->tw_isNull(date("Y-m-d"));
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    private function mysqli_close(){
        $this->conexion->close();
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    private function select_expandido($nombre, $valor){
        return $valor > 0 || !empty($valor)?"$nombre = \"$valor\"":"$valor";
    }
    private function select_expandido_clave($nombre, $valor){
        return "$nombre = aes_encrypt(\"$valor\",\"edigital\")";
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function cliente_lista(){
        $result[0] = "id <> 3";
        $result[1] = $this->select_expandido("estado",1);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->clienteLista($result);
    }
    private function clienteLista($result){
        $select = "SELECT `id`, `nombre`, `logo`, `fondo` FROM `p4u_cliente` $result ORDER BY id ASC";
        $query = $this->conexion->query($select);
        while ($row = $query->fetch_array(MYSQLI_ASSOC)){
            $return[$row["id"]] = [ "nombre" => $row["nombre"], "logo" => $row["logo"], "fondo" => $row["fondo"] ];
        }
        return $return;
    }
    public function cliente_individual($id_cliente){
        $result[0] = $this->select_expandido("id",$id_cliente);
        $result[1] = $this->select_expandido("estado",1);
        $result[2] = "id <> 3";
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->clienteIndividual($result);
    }
    private function clienteIndividual($result){
        $select = "SELECT `id`, `nombre`, `logo`, `fondo` FROM `p4u_cliente` $result ORDER BY id ASC";
        $query = $this->conexion->query($select);
        while ($row = $query->fetch_array(MYSQLI_ASSOC)){
            $return = [ "id" => $row["id"], "nombre" => $row["nombre"], "logo" => $row["logo"], "fondo" => $row["fondo"] ];
        }
        return $return;
    }
    public function cliente_buscar(){
        return $this->clienteBuscar();
    }
    private function clienteBuscar(){
        $select = "SELECT `id`,`nombre`,`logo` FROM `p4u_cliente` WHERE `nombre` LIKE ('%$this->nombre%') AND `estado` = $this->estado ORDER BY id ASC";
        $query = $this->conexion->query($select);
        while ($row = $query->fetch_array(MYSQLI_ASSOC)){
            $return[$row["id"]] = [ "nombre" => $row["nombre"] , "logo" => $row["logo"] ];
        }
        return $return;
    }
    public function producto_lista(){
        return $this->productoLista();
    }
    private function productoLista(){
        $select = "SELECT `id`,`nombre`,`logo` FROM `p4u_cliente` WHERE `nombre` LIKE ('%$this->nombre%') AND `estado` = $this->estado ORDER BY id ASC";
        $query = $this->conexion->query($select);
        while ($row = $query->fetch_array(MYSQLI_ASSOC)){
            $return[$row["id"]] = [ "nombre" => $row["nombre"] , "logo" => $row["logo"] ];
        }
        return $return;
    }
    public function cliente_registra($datos){
        $email = $this->tw_isNull($datos["email"]);
        $clave = $this->tw_isNull($datos["clave"]);
        $nombre = $this->tw_isNull($datos["nombre"]);
        $apellido = $this->tw_isNull($datos["apellido"]);
        $direccion = $this->tw_isNull($datos["direccion"]);
        $genero = $this->tw_isNull($datos["genero"]);
        $fecha = $this->tw_isNull($datos["selectAño"]."-".$datos["selectMes"]."-".$datos["selectDia"]);
        $telefono = $datos["telefono"];
        return $this->cliente_insert($email, $clave, $nombre, $apellido, $direccion, $genero, $fecha, $telefono);
    }
    public function cliente_insert($email, $clave, $nombre, $apellido, $direccion, $genero, $fecha, $telefono){
        $insert = "INSERT INTO tw_usuario VALUES (NULL,$email, aes_encrypt($clave,\"edigital\"), $nombre, $apellido, $direccion, $genero, $fecha, $telefono, $this->date_time,1)";
        $this->conexion->query($insert);
        return $this->conexion->insert_id;
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function cliente_correo($correo){
        $result[0] = $this->select_expandido("usuario",$correo);
        $result[1] = $this->select_expandido("estado",1);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->cliente_usuario($result);
    }
    public function cliente_clave($usuario, $clave){
        $clave = "aes_encrypt(\"$clave\",\"edigital\")";
        $update = "UPDATE tw_usuario SET clave = $clave WHERE id = $usuario";
        $this->conexion->query($update);
    }
    private function cliente_usuario($result){
        $select = "SELECT id, usuario, nombre, apellido, direccion, genero, nacimiento, telefono, creado, estado FROM tw_usuario $result";
        $query = $this->conexion->query($select);
        $return["estado"] = false;
        if($query){
            $return["estado"] = true;
            while ($row = $query->fetch_array(MYSQLI_ASSOC)){
                $return["contenido"][] = [ 
                    "id" => $row["id"], 
                    "usuario" => $row["usuario"], 
                    "nombre" => $row["nombre"], 
                    "apellido" => $row["apellido"], 
                    "direccion" => $row["direccion"], 
                    "genero" => $row["genero"], 
                    "nacimiento" => $row["nacimiento"], 
                    "telefono" => $row["telefono"], 
                    "creado" => $row["creado"], 
                    "estado" => $row["estado"]
                ];
            }
        }
        return $return;
    } 
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function insertTwcategoria($categoria){
        $id = $this->insert_twcategoria($categoria);
        return $id;
    }
    private function insert_twcategoria($categoria){
        $insert = "INSERT INTO tw_categoria VALUES (NULL,".$_COOKIE["id_usuario"].",\"$categoria\",$this->date_time,1)";
        $this->conexion->query($insert);
        return $this->conexion->insert_id;
    }
    public function updateTwcategoria($id,$estado){
        return $this->update_twcategoria($id,$estado);
    }
    private function update_twcategoria($id,$estado){
        $update = "UPDATE tw_categoria SET estado = $estado WHERE id = $id";
        $this->conexion->query($update);
        return $this->conexion->affected_rows;
    }
    public function select_twcategoria_idusuario($id_usuario){
        $result[0] = $this->select_expandido("id_usuario",$id_usuario);
        $result[1] = $this->select_expandido("estado",1);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->select_twcategoria($result);
    }
    public function select_twcategoria_estado($estado){
        $result = $this->select_expandido("estado",$estado);
        $result = "WHERE ".$result;
        return $this->select_twcategoria($result);
    }
    public function select_twcategoria_idusuario_lista($estado){
        $result[0] = $this->select_expandido("id_usuario", $_COOKIE["generico"]);
        $result[1] = $this->select_expandido("estado",$estado);
        $result = "WHERE ".$result[0]." AND ".$result[1];
        return $this->select_twcategoria($result);
    }
    private function select_twcategoria($result){
        $select = "SELECT id, id_usuario, categoria, creacion, estado FROM tw_categoria $result ORDER BY id asc";
        $query = $this->conexion->query($select);
        while ($row = $query->fetch_array(MYSQLI_ASSOC)){
            $return[$row["id"]] = [ "id_usuario" => $row["id_usuario"] ,"nombre" => $row["categoria"] , "creacion" => $row["creacion"] , "estado" => $row["estado"] ];
        }
        return $return;
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function insertTwproducto($id_categoria, $producto, $precio, $imagen, $descripcion){
        $id_categoria = $this->tw_isNull($id_categoria);
        $producto = $this->tw_isNull($producto);
        $precio = $this->tw_isNull($precio);
        $imagen = $this->tw_isNull($imagen);
        $descripcion = $this->tw_isNull($descripcion);
        $id = $this->insert_twproducto($id_categoria, $producto, $precio, $imagen, $descripcion);
        return $id;
    }
    private function insert_twproducto($id_categoria, $producto, $precio, $imagen, $descripcion){
        $insert = "INSERT INTO tw_producto VALUES (NULL,$this->usuario,$id_categoria,$producto,$precio, $imagen, $descripcion,$this->date_time,NULL,NULL,1)";
        $this->conexion->query($insert);
        return $this->conexion->insert_id;
    }
    public function updateTwproducto($id,$estado){
        return $this->update_twproducto($id,$estado);
    }
    private function update_twproducto($id,$estado){
        $update = "UPDATE tw_producto SET estado = $estado WHERE id = $id";
        $this->conexion->query($update);
        return $this->conexion->affected_rows;
    }
    public function select_twproducto_idusuario($usuario){
        $result = $this->select_expandido("id_usuario", $usuario);
        $result = "WHERE ".$result;
        //echo "select_twproducto_idusuario->".$usuario."->".$result."<br/>";
        return $this->select_twproducto($result);
    }
    public function select_twproducto_estado($estado){
        $result = $this->select_expandido("estado",$estado);
        $result = "WHERE ".$result;
        //echo "select_twproducto_estado".$estado."->".$result;
        return $this->select_twproducto($result);
    }
    public function select_twproducto_idcategoriaEstado($id_categoria,$estado){
        $result_idcategoria = $this->select_expandido("id_categoria", $id_categoria);
        $result_estado = $this->select_expandido("estado", $estado);
        $result = "WHERE ".$result_idcategoria." AND ".$result_estado;
        //echo "select_twproducto_idcategoriaEstado".$id_categoria."->".$estado."->".$result;
        return $this->select_twproducto($result);
    }
    public function select_twproducto_idcategoria($id_categoria){
        $result_idcategoria = $this->select_expandido("id_categoria", $id_categoria);
        $result = "WHERE ".$result_idcategoria;
        //echo "select_twproducto_idcategoria".$id_categoria."->".$result;
        return $this->select_twproducto($result);
    }
    public function select_twproducto_id($id_producto){
        $result = $this->select_expandido("id", $id_producto);
        $result = "WHERE ".$result;
        //echo "select_twproducto_id".$id_producto."->".$result;
        return $this->select_twproducto($result);
    }
    private function select_twproducto($result){
        $select = "SELECT id, id_categoria, producto, precio, imagen, descripcion, creacion, estado FROM tw_producto $result ORDER BY id asc";
        //echo $select;
        $query = $this->conexion->query($select);
        while ($row = $query->fetch_array(MYSQLI_ASSOC)){
            $return[$row["id"]] = [ "id_categoria" => $row["id_categoria"] ,"nombre" => $row["producto"] ,"precio" => $row["precio"] , "imagen" => $row["imagen"] , "descripcion" => $row["descripcion"] , "creacion" => $row["creacion"] , "estado" => $row["estado"] ];
        }
        return $return;
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function insertTwagregado($id_producto, $extras, $obligatorio, $descripcion){
        $id_producto = $this->tw_isNull($id_producto);
        $extras = $this->tw_isNull($extras);
        $descripcion = $this->tw_isNull($descripcion);
        $id = $this->insert_twagregado($id_producto, $extras, $obligatorio, $descripcion);
        return $id;
    }
    public function insert_twagregado($id_producto, $extras, $obligatorio, $descripcion){
        $insert = "INSERT INTO tw_agregado VALUES (NULL, $id_producto, $extras, $obligatorio, $descripcion, $this->date_time, $this->date_time, 1)";
        $this->conexion->query($insert);
        return $this->conexion->insert_id;
    }
    public function updateTwagregado($id,$estado){
        return $this->update_twagregado($id,$estado);
    }
    private function update_twagregado($id,$estado){
        $update = "UPDATE tw_agregado SET estado = $estado, edicion = $this->date_time WHERE id = $id";
        $this->conexion->query($update);
        return $this->conexion->affected_rows;
    }
    public function tw_agregado_idproducto($id_producto){
        $result = $this->select_expandido("id_producto",$id_producto);
        $result = "WHERE ".$result;
        return $this->select_twagregado($result);
    }
    public function tw_agregado_idproductoEstado($id_producto,$estado){
        $result[0] = $this->select_expandido("id_producto",$id_producto);
        $result[1] = $this->select_expandido("estado",$estado);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->select_twagregado($result);
    }
    private function select_twagregado($result){
        $select = "SELECT id, id_producto, agregado, obligatorio, descripcion, creacion, edicion, estado FROM tw_agregado $result ORDER BY id asc";
        $query = $this->conexion->query($select);
        while ($row = $query->fetch_array(MYSQLI_ASSOC)){
            $return[$row["id"]] = [ "id_producto" => $row["id_producto"] ,"nombre" => $row["agregado"] ,"obligatorio" => $row["obligatorio"] , "descripcion" => $row["descripcion"] , "creacion" => $row["creacion"] , "estado" => $row["estado"] ];
        }
        return $return;
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function insertTwextra($id_agregado, $extras, $precio, $descripcion){
        $id_agregado = $this->tw_isNull($id_agregado);
        $extras = $this->tw_isNull($extras);
        $precio = $this->tw_isNull($precio);
        $descripcion = $this->tw_isNull($descripcion);
        $id = $this->insert_twextra($id_agregado, $extras, $precio, $descripcion);
        return $id;
    }
    public function insert_twextra($id_agregado, $extras, $precio, $descripcion){
        $insert = "INSERT INTO tw_extras VALUES (NULL, $id_agregado, $extras, $precio, $descripcion, $this->date_time, $this->date_time, 1)";
        $this->conexion->query($insert);
        return $this->conexion->insert_id;
    }
    public function updateTwextra($id,$estado){
        return $this->update_twextra($id,$estado);
    }
    private function update_twextra($id,$estado){
        $update = "UPDATE tw_extras SET estado = $estado, edicion = $this->date_time WHERE id = $id";
        $this->conexion->query($update);
        return $this->conexion->affected_rows;
    }
    public function tw_extras_idagregado($id_agregado){
        $result = $this->select_expandido("id_agregado",$id_agregado);
        $result = "WHERE ".$result;
        return $this->select_twextras($result);
    }
    public function tw_extras_idagregadoEstado($id_agregado,$estado){
        $result[0] = $this->select_expandido("id_agregado",$id_agregado);
        $result[1] = $this->select_expandido("estado",$estado);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->select_twextras($result);
    }
    public function select_twextras_id($id_extra){
        $result = $this->select_expandido("id",$id_extra);
        $result = "WHERE ".$result;
        return $this->select_twextras($result);
    }
    private function select_twextras($result){
        $select = "SELECT id, id_agregado, extra, precio, mensaje, creacion, edicion, estado FROM tw_extras $result ORDER BY id asc";
        $query = $this->conexion->query($select);
        while ($row = $query->fetch_array(MYSQLI_ASSOC)){
            $return[$row["id"]] = [ "id_agregado" => $row["id_agregado"] ,"nombre" => $row["extra"] ,"precio" => $row["precio"] , "descripcion" => $row["mensaje"] , "creacion" => $row["creacion"] , "estado" => $row["estado"] ];
        }
        return $return;
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function dashboard_pedido($creado,$estado){
        $result[] = $this->select_expandido("id_cliente",$_COOKIE["generico"]);
        $result[] = "creado LIKE ('".$creado."%')";
        $result[] = $this->select_expandido("estado",$estado);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->dashboard_pedido_select($result);
    }
    public function dashboard_pedidoReporte($start, $end, $estado){
        switch ($start) {
            case 0:
                $pedido = $this->dashboard_pedido_reporte();
                break;
            case 1:
                $pedido = $this->dashboard_pedido_reporte_cliente();
                break;
            default:
                $pedido = $this->dashboard_pedido_reporte_fecha($start, $end, $estado);
                break;
        }
        $return["estado"] = false;
        if(is_array($pedido)){
            $return["estado"] = true;
            $i = 0;
            foreach ($pedido as $key => $value) {
                $restaurant = $this->cliente_individual($value["id_cliente"]);
                $return["records"][$i]["nombre"] = $restaurant["nombre"];
                if($start == 1 && $value["estado"] != 2){
                    $return["records"][$i]["acción"] = "Repeticua";
                }else{
                    $detalle = $this->login_cliente($value["id_usuario"]);
                    $return["records"][$i]["telefono"] = $detalle["detalle"]["telefono"];
                    $return["records"][$i]["nombre"] = $detalle["detalle"]["nombre"]." ".$detalle["detalle"]["apellido"];
                }
                $return["records"][$i]["id"] = $key;
                $return["records"][$i]["codigo"] = $value["codigo_pedido"];
                $return["records"][$i]["creado"] = $value["creado"];
                $return["records"][$i]["estado"] = $value["estado"];
                $return["records"][$i]["total"] = ($value["total"] * 100);
                $i++;
            }
            //$return["records"]["queryRecordCount"] = count($pedido);
            //$return["records"]["totalRecordCount"] = count($pedido);
        }
        return $return;
    }
    private function pedido_estado($estado) {
        switch ($estado) {
            case 1:
                $return = "<button type=\"button\" class=\"btn btn-secondary btn-block\">Por aprobar</button>";
                break;
            case 2:
                $return = "Pendiente de pago";
                break;
            case 3:
                $return = "<button type=\"button\" class=\"btn btn-success btn-block\">Pagado</button>";
                break;
            case 4:
                $return = "<button type=\"button\" class=\"btn btn-danger btn-block\">Rechazado</button>";
                break;
            default:
                $return = "Sin identificar";
                break;
        }
        return $return;
    }
    private function dashboard_pedido_reporte(){
        $result[] = "creado LIKE ('".date("Y-m-d")."%')";
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->dashboard_pedido_select($result);
    }
    private function dashboard_pedido_reporte_cliente(){
        $result[] = $this->select_expandido("id_usuario",$_COOKIE["id_cliente"]);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->dashboard_pedido_select($result);
    }
    private function dashboard_pedido_reporte_fecha($start, $end, $estado){
        $result[] = "creado BETWEEN  '$start' AND '$end'";
        if($estado > 0){
            $result[] = $this->select_expandido("estado",$estado);
        }
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->dashboard_pedido_select($result);
    }
    public function dashboard_pedido_tienda($id_usuario,$creado,$estado){
        $result[] = $this->select_expandido("id_usuario",$id_usuario);
        $result[] = "creado LIKE ('".$creado."%')";
        $result[] = $this->select_expandido("estado",$estado);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->dashboard_pedido_select($result);
    }
    public function dashboard_pedidoDetalle($id_pedido){
        $result = $this->dashboard_pedido_detalle($id_pedido);
        foreach ($result as $key => $value) {
            switch ($value["data2"]) {
                case "extra":
                    $detalle = $this->select_twextras_id($value["data3"]);
                    $return[$value["data1"]]["extra"][] = $detalle[$value["data3"]]["nombre"];
                    $cantidad = 0;
                    break;
                default:
                    $result = $this->select_twproducto_id($value["data1"]);
                    $return[$value["data1"]]["producto"]["nombre"] = $result[$value["data1"]]["nombre"];
                    $return[$value["data1"]]["producto"]["cantidad"] = $value["data3"];
                    $comentario = !empty($value["data4"]) ? $value["data4"]:"";
                    $return[$value["data1"]]["comentario"] = $comentario;
                    break;
            }
        }
        return $return;
    }
    public function dashboard_pedido_detalle($id_pedido){
        $result = $this->select_expandido("id_pedido",$id_pedido);
        $result = "WHERE ".$result;
        return $this->dashboard_pedido_detalle_select($result);
    }
    public function dashboard_pedido_estado($estado, $visto){
        $result[] = $this->select_expandido("id_cliente", $_COOKIE["generico"]);
        $result[] = $this->select_expandido("estado", $estado);
        $result[] = $this->select_expandido("visto", $visto);
        $result[] = "creado LIKE ('".date("Y-m-d")."%')";
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        $return["estado"] = false;
        $contenido = $this->dashboard_pedido_select($result);
        if(is_array($contenido)){
            $return["contenido"] = $contenido;
            $return["estado"] = true;
            return $return;
        }else{
            return $return;
        }
    }
    private function dashboard_pedido_select($result){
        $select = "SELECT id, id_usuario, id_cliente, codigo_pedido, creado, total, estado, visto FROM tw_pedido $result ORDER BY creado ASC";
        $query = $this->conexion->query($select);
        while ($row = $query->fetch_array(MYSQLI_ASSOC)){
            $return[$row["id"]] = [ "id_usuario" => $row["id_usuario"], "id_cliente" => $row["id_cliente"] ,"codigo_pedido" => $row["codigo_pedido"], "creado" => $row["creado"] ,"total" => $row["total"], "estado" => $row["estado"], "visto" => $row["visto"] ];
        }
        return $return;
    }
    private function dashboard_pedido_detalle_select($result){
        $select = "SELECT id, data1, data2, data3, data4 FROM tw_pedido_detalle $result ORDER BY id ASC";
        $query = $this->conexion->query($select);
        while ($row = $query->fetch_array(MYSQLI_ASSOC)){
            $return[$row["id"]] = [ "data1" => $row["data1"] , "data2" => $row["data2"] , "data3" => $row["data3"] , "data4" => $row["data4"] ];
        }
        return $return;
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */    
    public function genera_carrito($pedido){
        $pedido = $this->carrito_pedido($pedido);
        foreach ($pedido as $key => $value) {
            $pedido_detalle = $this->carrido_pedido_detalle($key);
            foreach ($pedido_detalle as $index => $val) {
                if($val["data2"] == "producto"){
                    $a = "tw-".time()."-".$val["data1"];
                    $b = "fr-".$val["data1"];
                    $c = $val["data3"];
                    $d = $val["data4"];
                    $producto = $this->select_twproducto_id($val["data1"]);
                    $e = $producto[$val["data1"]]["nombre"];
                    $f = number_format($producto[$val["data1"]]["precio"], 2, '.', '');
                    $g = number_format($f * $c, 2, '.', '');
                    $return["items"][$a] = [
                        "dst" => $b,
                        "precio" => $f,
                        "cantidad" => $c,
                        "costo" => $g,
                        "mensaje" => $d,
                        "plato" => $e,
                        "extras" => [
                            "estado" => false
                        ]
                    ];
                }elseif($val["data2"] == "extra"){
                    $g = "radio-".$val["data3"];
                    $extra = $this->select_twextras_id($val["data3"]);
                    $h = $extra[$val["data3"]]["nombre"];
                    $i = $extra[$val["data3"]]["precio"];
                    $return["items"][$a]["extras"]["estado"] = true;
                    $return["items"][$a]["extras"]["contenido"][$g] = [
                        "precio" => number_format($i, 2, '.', ''),
                        "nombre" => $h
                    ];
                }
            }
        }
        $return["total"] = number_format($value["total"], 2, '.', '');
        $return["tienda"] = $value["id_cliente"];
        return $return;
    }
    private function carrito_pedido($pedido){
        $result[] = $this->select_expandido("id",$pedido);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->dashboard_pedido_select($result);
    } 
    private function carrido_pedido_detalle($pedido){
        $result[] = $this->select_expandido("id_pedido",$pedido);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        return $this->dashboard_pedido_detalle_select($result);
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function pedido_select($id_usuario,$creado,$estado){
        $result = $this->dashboard_pedido_tienda($id_usuario,$creado,$estado);
        $return["estado"] = false;
        if(is_array($result)){
            foreach ($result as $key => $value) {
                $return["id"] = $key;
            }
            $return["estado"] = true;
        }
        return $return;
    }
    public function pedido_acepta($id,$estado){
        $update = "UPDATE tw_pedido SET estado = $estado, visto = 1 WHERE id = $id";
        return $this->conexion->query($update);
    }
    public function pedido_extraer($id){
        $result = $this->select_expandido("id",$id);
        $result = "WHERE ".$result;
        $result = $this->dashboard_pedido_select($result);
        return [ "pedido" => $id , "codigo" => $result[$id]["codigo_pedido"] , "total" => $result[$id]["total"] ];
    }
    public function pedido_verfica($id_pedido){
        $result[0] = $this->select_expandido("id",$id_pedido);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        $result = $this->dashboard_pedido_select($result);
        return $result;
    }
    public function pedido_automatiza($estado,$visto){
        $result[0] = $this->select_expandido("id", $_COOKIE["generico"]);
        $result[1] = $this->select_expandido("estado", $estado);
        $result[2] = $this->select_expandido("visto", $visto);
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        $return = $this->dashboard_pedido_select($result);
        if(is_array($return)){
            $result = $this->pedido_automatiza_multiUpdate($return);
            if($result){
                return $return;
            }
        }
    }
    public function pedido_automatiza_multiUpdate($result){
        foreach ($result["contenido"] as $key => $value) {
            $multi[] = "UPDATE tw_pedido SET visto = 2 WHERE id = $key";
        }
        return $this->consulta_multi_query($multi);
    }
    public function pedido_grabar(){
        $carr = unserialize($_COOKIE["carrito"]);
        if(is_array($carr)){
            $this->carro = $carr;
            $codigo = $this->pedido_codigo();
            $total = $this->carro["total"];
            $id_pedido = $this->pedido_grabarInsert($codigo, $total, $_COOKIE["id_restaurante"]);
            foreach ($this->carro["items"] as $key => $value) {
                $producto = $this->id_return($key);
                $multi[] = $this->pedido_multiquery($id_pedido,$producto,"producto",$value["cantidad"],$value["mensaje"]);
                if($value["extras"]["estado"]){
                    foreach ($value["extras"]["contenido"] as $key => $value) {
                        $extra = $this->id_return($key);
                        $multi[] = $this->pedido_multiquery($id_pedido,$producto,"extra",$extra,$mensaje);
                    }
                }
            }
            $valida = $this->consulta_multi_query($multi);
            if($valida){
                //unset($_SESSION["carrito"]);
                $carrito["estado"] = false;
                setcookie("carrito", serialize($carrito) , time() + (86400 * 30), "/");
                return [ "estado" => true , "pedido" => $id_pedido , "codigo" => $codigo , "total" => $total ];
            }else{
                return [ "estado" => false ];
            }
        }else{
            return [ "estado" => false ];
        }
    }
    private function pedido_codigo(){
        $codigo = $this->codigoA();
        $codigo = "JS".str_pad($codigo, 4, "0", STR_PAD_LEFT);
        $codigo = $this->tw_isNull($codigo);
        return $codigo;
    }
    private function pedido_grabarInsert($codigo,$total,$id_restaurante){
        $insert = "INSERT INTO tw_pedido VALUES (NULL,".$_COOKIE["id_cliente"].",$id_restaurante,$codigo,$total,$this->date_time,1,1,1)";
        $this->conexion->query($insert);
        return $this->conexion->insert_id;
    }
    private function pedido_multiquery($id_pedido, $campo1, $evento, $campo2, $mensaje){
        $id_pedido = $this->tw_isNull($id_pedido);
        $campo1 = $this->tw_isNull($campo1);
        $evento = $this->tw_isNull($evento);
        $campo2 = $this->tw_isNull($campo2);
        $mensaje = $this->tw_isNull($mensaje);
        $insert = "INSERT INTO tw_pedido_detalle VALUES (NULL,$id_pedido,$campo1,$evento,$campo2,$mensaje)";
        return $insert;
    }
    private function consulta_multi_query($multi){
        $multi = implode(";",$multi);
        $return = $this->conexion->multi_query($multi);
        $this->mysqli_close();
        return $return;
    }
    private function id_return($key){
        $detalle = explode("-",$key);
        $detalle = end($detalle);
        return $detalle;
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function clientesSelect($estado){
        $result = $this->select_expandido("estado", $estado);
        $result = "WHERE ".$result;
        return $this->clientes_select($result);
    }
    private function clientes_select($result){
        $select = "SELECT id, nombre, usuario, logo FROM p4u_cliente $result";
        $query = $this->conexion->query($select);
        $return["estado"] = false;
        if($query){
            $return["estado"] = true;
            while ($row = $query->fetch_array(MYSQLI_ASSOC)){
                if($row["id"] !=3){
                    $return["detalle"][$row["id"]] = [ "usuario" => $row["usuario"], "nombre" => $row["nombre"], "logo" => $row["logo"] ];
                }
            }
        }
        return $return;
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function login_ingresoAdmin($usuario,$clave){
        $result[0] = $this->select_expandido( "estado", 1 );
        $result[1] = $this->select_expandido( "usuario", $usuario );
        $result[2] = $this->select_expandido_clave( "clave", $clave );
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        $return = $this->login_ingreso_selectAdmin($result);
        return $return;
    }
    private function login_ingreso_selectAdmin($result){
        $select = "SELECT id, nombre, usuario, logo FROM p4u_cliente $result";
        $query = $this->conexion->query($select);
        $return["estado"] = false;
        if($query){
            $return["estado"] = true;
            while ($row = $query->fetch_array(MYSQLI_ASSOC)){
                $return["detalle"] = [ "id" => $row["id"], "usuario" => $row["usuario"], "nombre" => $row["nombre"], "logo" => $row["logo"] ];
            }
        }
        return $return;
    }
    public function login_ingresoWeb($logeo){
        $result[0] = $this->select_expandido( "estado", 1 );
        $result[1] = $this->select_expandido( "usuario", $logeo["tw-usuario"] );
        $result[2] = $this->select_expandido_clave( "clave", $logeo["tw-clave"] );
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        $return = $this->login_select($result);
        return $return;
    }
    public function login_cliente($id){
        $result[] = $this->select_expandido( "id", $id );
        $result = implode(" AND ",$result);
        $result = "WHERE ".$result;
        $return = $this->login_select($result);
        return $return;
    }
    private function login_select($result){
        $select = "SELECT id, usuario, nombre, apellido, direccion, genero, nacimiento, telefono, creado FROM tw_usuario $result";
        $query = $this->conexion->query($select);
        $return["estado"] = false;
        if($query){
            $return["estado"] = true;
            while ($row = $query->fetch_array(MYSQLI_ASSOC)){
                $return["detalle"] = [ 
                    "id" => $row["id"], 
                    "usuario" => $row["usuario"], 
                    "nombre" => $row["nombre"], 
                    "apellido" => $row["apellido"], 
                    "direccion" => $row["direccion"], 
                    "genero" => $row["genero"],
                    "nacimiento" => $row["nacimiento"], 
                    "telefono" => $row["telefono"], 
                    "creado" => $row["creado"]
                ];
            }
        }
        return $return;
    }
    public function carta_usuario($usuario){
        $detalle = [
            "1" => [ 
                "nombre" => "La Bonbonniere", 
                "imagen" => "https://www.labonbonniere.pe/wp-content/uploads/2016/10/local_opt-300x300.jpg" 
            ],
            "2" => [ 
                "nombre" => "La verdad de la milanesa", 
                "imagen" => "https://laverdaddelamilanesa.com.pe/wp-content/uploads/2015/09/location-2.jpg" 
            ]
        ];
        $return = is_array($detalle[$usuario])?$detalle[$usuario]:"";
        return $return;
    }
    public function login_usuario($usuario){
        setcookie("generico", $usuario, time()+(60 * 60 * 24), "/");
    }
    public function login_existe(){
        if(!isset($_COOKIE["generico"]) && empty($_COOKIE["generico"])){
            header('Location: index.php');
        }
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function tw_buttons($producto){
        if(is_array($producto)){
            $button = "";
            foreach ($producto as $key => $value) {
                if($value["estado"] == 1){
                    $estilo = [ "estado" => "tw-activo" , "icono" => "<i class=\"fas fa-check\"></i>" , "color" => "btn-success" , "color-outline" => "btn-outline-success" ];
                }else{
                    $estilo = [ "estado" => "tw-inactivo" , "icono" => "<i class=\"fas fa-times\"></i>" , "color" => "btn-danger" , "color-outline" => "btn-outline-danger"];
                }
                $id = "tw-button-".$key;
                $button.="<div id=\"$id\" class=\"mr-1 mt-1 btn-group btn-group-sm ".$estilo["estado"]."\" role=\"group\">";
                $button.="    <button type=\"button\" class=\"btn ".$estilo["color-outline"]." tw-out btn-estado\">".$value["nombre"]."</button>";
                $button.="    <button type=\"button\" class=\"btn ".$estilo["color"]." tw-in tw-icono btn-estado\">".$estilo["icono"]."</button>";
                $button.="</div>";
            }
            return $button;
        }
    }
/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    public function codigo(){
        return rand(999,99999);
    }
    public function codigoA(){
        return rand(100,9999);
    }
    private function tw_isNull($result){
        return empty($result)?"NULL":'"'.$result.'"';
    }
}
