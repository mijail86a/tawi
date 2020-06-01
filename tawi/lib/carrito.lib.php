<?php
session_start();
date_default_timezone_set('America/Lima');
class carrito {
	private $date;
	private $carro;

	public function __construct(){
        $this->date = date("Y-m-d H:i:s");
        $carrito = $this->cookie_unserialize($_COOKIE["carrito"]);
        if($carrito["estado"]){
        	$this->carro = $carrito;
        }
    }
    public function add_cart($id, $precio, $cantidad, $mensaje, $plato, $extra){
        if(is_array($this->carro)){
        	$carrito = $this->carro;
            $contador = $this->carro["contador"];
        }
        $contador[$id] += 1;
        $index = $this->id_producto($id);
        $total = 0;
        if($extra["estado"]){
            foreach ($extra["contenido"] as $value) {
                $total += $value["precio"];
            }
        }
        $costo = ($precio + $total) * $cantidad;
        $total = 0;
        $carrito["estado"] = true;
    	$carrito["items"][$index] = [ 
            "dst" => $id, 
            "precio" => $this->format_number($precio), 
            "cantidad" => $cantidad, 
            "costo" => $this->format_number($costo), 
            "mensaje" => $mensaje, 
            "plato" => $plato, 
            "extras" => $extra
        ];
        $carrito["cantidad"][$index] = $costo;
        $total = array_sum($carrito["cantidad"]);
    	$carrito["total"] = $this->format_number($total);
        $carrito["contador"] = $contador;
        $this->cookie_create($carrito);
        //$this->carro = $carrito;
        //$this->session_cart();
    	return [ "estado" => true , "contenido" => $carrito ];
    }
    public function edit_cart($id, $cantidad){
    	$carrito = $this->carro;
    	$carrito["items"][$id]["cantidad"] = $cantidad;
        $carrito["cantidad"][$id] = $cantidad;
        $precio = $carrito["items"][$id]["precio"];
        $extras = "0";
        if($carrito["items"][$id]["extras"]["estado"]){
            foreach ($carrito["items"][$id]["extras"]["contenido"] as $value) {
                $extras += $value["precio"];
            }
        }
        $costo = ($precio + $extras) * $cantidad;
        $carrito["items"][$id]["costo"] = $this->format_number($costo);
        $carrito["cantidad"][$id] = $this->format_number($costo);
    	$total = array_sum($carrito["cantidad"]);
    	$carrito["total"] = $this->format_number($total);
        $this->cookie_create($carrito);
    	//$this->carro = $carrito;
    	//$this->session_cart();
    	return [ "total" => $this->format_number($total) , "costo" => $this->format_number($costo) , "detalle" => $carrito ];
    }
    public function delete_cart($id){
    	$carrito = $this->carro;
    	$contador = $this->carro["contador"];
    	$dst = $carrito["items"][$id]["dst"];
    	unset($carrito["items"][$id]);
        unset($carrito["cantidad"][$id]);
    	$total = array_sum($carrito["cantidad"]);
    	$carrito["total"] = $this->format_number($total);
    	$contador[$dst] -= 1;
    	$carrito["contador"] = $contador;
    	//$this->carro = $carrito;
    	//$this->session_cart();
        $this->cookie_create($carrito);
        $estado = $carrito["contador"][$dst]==0?false:true;
        $return = [ "destino" => $dst, "estado" => $estado, "total" => $total ];
        if($estado){
            $return["cantidad"] = $carrito["contador"][$dst];
        }
    	return $return;
    }
    public function destroy_cart(){
        $carrito["estado"] = false;
        $this->cookie_create($carrito);
    }
    public function create_cart($carrito){
        return $this->cookie_create($carrito);
    }
    public function read_cart(){
        $carrito = $_COOKIE["carrito"];
        return $this->cookie_unserialize($carrito);
    }
    public function tw_format_number($return){
        return $this->format_number($return);
    }
    private function format_number($return){
        return number_format($return, 2, '.', '');
    }
    private function id_producto($id){
    	$id = explode("-",$id);
    	$return = "tw-".time()."-".end($id);
    	return $return;
    }
    private function session_cart(){
    	$carrito = $this->carro;
    	//setcookie("carrito", serialize($carrito) , time() + (86400 * 30), "/");
    	if(is_array($carrito)){
    		$_SESSION["carrito"] = $carrito;
    		return true;
	    }else{
	    	unset($_SESSION["carrito"]);
			return false;
	    }
    }
    private function cookie_create($carrito){
        setcookie("carrito", serialize($carrito) , time() + (86400 * 30), "/");
    }
    private function cookie_unserialize($carrito){
        return unserialize($carrito);
    }
}
?>