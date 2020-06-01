<?php
	require 'vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

    require_once('lib/functions.lib.php');

    $datos = new libreria();
    //$id_usuario = isset($_COOKIE["id_cliente"]) || !empty($_COOKIE["id_cliente"])?$_COOKIE["id_cliente"]:0;
    if(isset($_POST) && !empty($_POST)){
        $correo = $datos->cliente_correo($_POST["correo"]);
        echo "<pre>".print_r($correo, true)."</pre>";
        if($correo["estado"]){
        	$correo_tawi = utf8_decode($correo["contenido"]["usuario"]);
        	$usuario_tawi = utf8_decode($correo["contenido"]["nombre"]." ".$correo["contenido"]["apellido"]);
        	$ahora = time();
        	$mañana = time() + (60 * 60 * 24); 
        	$detalle = ["correo" => $correo_tawi, "inicia" => $ahora ,"termina" => $mañana];
        	$encode_64 = base64_encode(serialize($detalle));
        	/*
        		$decode_64 = base64_decode ($encode_64, true);
        		var_dump(unserialize($decode_64));
        	*/
        	enviar_correo($correo_tawi, $usuario_tawi ,$encode_64);
        	header('Location: index.php');
        }
    }else{
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
				<form class="m-auto w-100" action="cambiar.php" method="post">
					<div class="form-group">
						<label for="tw-email">Dirección de correo</label>
						<input type="email" class="form-control" id="tw-email" placeholder="Correo" name="correo" required>
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
<?php 
    }
	function enviar_mail($correo, $usuario){
	    $mail = new PHPMailer();
	    $mail->IsSMTP();
	    $mail->Host = "mail.edigital-testing.tk";
	    $mail->SMTPSecure = 'ssl';
	    $mail->SMTPDebug  = 0;
	    $mail->SMTPAuth   = true;
	    $mail->Port       = 465;
	    $mail->Username   = "no-reply@edigital-testing.tk";
	    $mail->Password   = "nL*l!+7zX3~x";
	//    $mail->AddAttachment("aprende-a-exportar-e-importar.pdf", $name = 'aprende-a-exportar-e-importar.pdf', $encoding = 'base64', $type = 'application/pdf');
	//    $mail->AddAttachment("../AC_file/scrum.pdf", $name = 'scrum.pdf');
	    $mail->SetFrom("no-reply@edigital-testing.tk", "Tawi");
	    //Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
//	    $mail->AddReplyTo("andes_info@usmp.pe", "ANDES - USMP");
	    $mail->CharSet = 'UTF-8';
	    $mail->AddAddress($correo, $usuario);
	    $mail->Subject = "Cambiar Contrase&ntilde;a";
	    $mail->WordWrap = 50; // Ajuste de texto
	    $mail->IsHTML(true); //establece formato HTML para el contenido
	    $contenido_html = 'demo de correo';
	    $mail->Body    = $contenido_html; //contenido con etiquetas HTML
	    $mail->AltBody = strip_tags($contenido_html); //Contenido para servidores que no aceptan HTML
	    if (!$mail->Send()) {
	        return "Hubo un error: " . $mail->ErrorInfo;
	    } else {
	        return "enviado";
	    }
	}
	function enviar_correo($correo, $usuario, $link){
		$mail = new PHPMailer(true);
		try {
		    //Server settings
		    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
		    $mail->isSMTP();                                            // Set mailer to use SMTP
		    $mail->Host       = 'mail.edigital-testing.tk';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = 'no-reply@edigital-testing.tk';                     // SMTP username
		    $mail->Password   = 'nL*l!+7zX3~x';                               // SMTP password
		    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
		    $mail->Port       = 465;                                    // TCP port to connect to

		    //Recipients
		    $mail->CharSet = 'UTF-8';
		    $mail->setFrom('no-reply@edigital-testing.tk', 'tawi');
		    $mail->addAddress($correo, $usuario);     // Add a recipient

		    // Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Cambio de contraseña';
		    $mail->Body    = "
				Hola $usuario:<br/><br/>
				Haga clic en el bot&oacute;n a continuaci&oacute;n para cambiar la contrase&ntilde;a de su cuenta.<br/><br/>
				<a href=\"".DOMINIO.DIRECTORIO."cambiar_correo.php?a=".$link."\" target=\"_blank\" style=\"width : 20rem;font-size:16px; color:#ffffff; background:#175e90; text-align:center; text-transform:uppercase; text-decoration:none; color:#ffffff; display:block; line-height:50px\">CAMBIAR DE CONTRASE&Ntilde;A</a><br/>
				Si no solicit&oacute; un restablecimiento de contrase&ntilde;a, ignore este correo electr&oacute;nico.
		    ";
		    $mail->send();
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
?>