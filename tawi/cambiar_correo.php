<?php
	require_once('lib/functions.lib.php');
	if( isset($_REQUEST["a"]) && !empty($_REQUEST["a"]) ){
		$b = $_REQUEST["a"];
	}
	if( isset($_REQUEST["b"]) && !empty($_REQUEST["b"]) ){
		$datos = new libreria();
		//$id_usuario = isset($_COOKIE["id_cliente"]) || !empty($_COOKIE["id_cliente"])?$_COOKIE["id_cliente"]:0;
		$decode_64 = base64_decode ($_REQUEST["b"], true);
		$detalle = unserialize($decode_64);
		$ahora = time();
		echo "<pre>".print_r($detalle,true)."</pre>";
		echo $detalle["inicia"]." < ".$ahora." < ".$detalle["termina"]."<br/>";
		if($detalle["inicia"] < $ahora && $detalle["termina"] > $ahora ){
			$correo = $datos->cliente_correo($detalle["correo"]);
			if($correo["estado"]){
				$usuario = $correo["contenido"][0]["id"];
				$clave = $_REQUEST["clave"];
				$datos->cliente_clave($usuario, $clave);
				setcookie("id_cliente", $usuario, time() + (60 * 60 * 24 * 30), "/");
            	setcookie("nombre_cliente", $detalle["correo"], time() + (60 * 60 * 24 * 30), "/");
            	header('Location: index.php');
			}else{
				echo "no existe";
			}
		}else{
			echo "fuera de hora";
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
<?php
    include_once 'plantilla/header.php';
?>
	<style type="text/css">
		.da {
			margin-left: auto;
			margin-right: auto;
			padding-left: 15px;
			padding-right: 15px;
		}
		@media only screen and (max-width: 992px) and (orientation: landscape) {
			.da {
				max-width: 100%;
				width: 48rem;
			}
		}
		@media only screen and (min-width: 993px) and (max-width: 1200px) and (orientation: landscape) {
			.da {
				max-width: 100%;
				width: 43rem;
			}
		}
		@media only screen and (min-width: 1201px) and (orientation: landscape) {
			.da {
				max-width: 100%;
				width: 38rem;
			}
		}
	</style>
    </head>
    <body>
        <div class="da">
	    	<div class="py-3 d-flex justify-content-between align-items-center bd-highlight">
	        	<a href="/"><img class="img-fluid" src="<?php echo STATIC2.DIRECTORIO.IMG."/logo-tawi.png"; ?>"></a>
	    	</div>
	    	<div class="d-flex">
				<form class="m-auto w-100" action="cambiar_correo.php?b=<?php echo $b;?>" method="post">
					<div class="form-group">
						<label for="tw-contra">Escriba su contraseña</label>
						<input type="password" class="form-control" id="tw-contra" name="clave" required>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
        </div>
<?php
    include_once 'plantilla/footer.php';
?>
    </body>
</html>