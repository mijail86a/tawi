<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "class.phpmailer.php";
    include_once "class.smtp.php";
    date_default_timezone_set('America/Lima');
    $nombres = utf8_decode($_POST["your-name"]);
    $correo = utf8_decode($_POST["your-email"]);
    $telefono = utf8_decode($_POST["your-fone"]);
    $ciudad = utf8_decode($_POST["your-ciudad"]);
    $titulo = utf8_decode($_POST["your-titulo"]);
    $link_video = utf8_decode($_POST["your-video"]);
    //plantilla
    $plantilla_name = $_FILES['adjunto']['name'];
    $plantilla_tmp = $_FILES['adjunto']['tmp_name'];
//    move_uploaded_file($plantilla_tmp,"../ac_adjunto/".$plantilla_name);
    $datos = array("nombre"=>$nombres,"correo"=>$correo,"titulo"=>$titulo,"telefono"=>$telefono,"ciudad"=>$ciudad,"video"=>$link_video,"plantilla_tmp"=>$plantilla_tmp,"plantilla_name"=>$plantilla_name);
    $envio = (empty($nombres))?0:enviarMail($datos);
    $envio2 = enviarDetalle($datos);
    $data = array("nombre"=>$nombres,"correo"=>$correo,"telefono"=>$telefono,"data1"=>$titulo,"data2"=>$ciudad,"data3"=>$link_video);
    $data["landing"]="emprende-arequipa-sector-retail";
    $data["envioCliente"]=$envio;
    $data["envioAndes"]=$envio2;
//    $data["envioAndes"]=0;
//    $json_text = $nombres.",".$correo.",".$telefono.",".$ciudad.",".$titulo.",".$sector.",".$link_video.",".$plantilla_name.",".$adjunto_name.",".date("Y-m-d H:m:s").",".$envio.",".$envio2.PHP_EOL;
//    rc_create_txt($json_text, "emprende-arequipa-sector-retail");
    $json = json_encode($data,JSON_PRETTY_PRINT);
    echo $json;
}
function rc_create_txt($txt,$name) {
    $archivo = $name.".txt";
    $file = fopen($archivo, "a+") or exit("Unable to open file!");
    fwrite($file, $txt);
    fclose($file);
}
function enviarMail($detalle){
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = true;
    $mail->Port       = 465;
    $mail->Username   = "pandesv@usmpvirtual.edu.pe";
    $mail->Password   = "@nd3SUv1rtual2018";
//    $mail->AddAttachment("aprende-a-exportar-e-importar.pdf", $name = 'aprende-a-exportar-e-importar.pdf', $encoding = 'base64', $type = 'application/pdf');
//    $mail->AddAttachment("../AC_file/scrum.pdf", $name = 'scrum.pdf');
    $mail->SetFrom("andes_info@usmp.pe", "ANDES - USMP");
    //Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
    $mail->AddReplyTo("andes_info@usmp.pe", "ANDES - USMP");
    $mail->CharSet = 'UTF-8';
    $mail->AddAddress($detalle["correo"], $detalle["nombre"]);
    $mail->Subject = "Emprende Arequipa 2018";
    $mail->WordWrap = 50; // Ajuste de texto
    $mail->IsHTML(true); //establece formato HTML para el contenido
    $contenido_html = '<h1 style="text-align: left;">Estimada(o) '. $detalle["nombre"].'</h1><br><br>
        Gracias por registrarte a Emprende Arequipa, nos estaremos comunicando contigo según los plazos del concurso.<br/>
        DETALLE DE REGISTRO:<br/>
        nombre: '.$detalle["nombre"].'<br/>
        correo: '.$detalle["correo"].'<br/>
        telefono: '.$detalle["telefono"].'<br/>
        ciudad: '.$detalle["ciudad"].'<br/>
        empresa: '.$detalle["titulo"].'<br/>
        video: '.$detalle["video"];
    $mail->Body    = $contenido_html; //contenido con etiquetas HTML
    $mail->AltBody = strip_tags($contenido_html); //Contenido para servidores que no aceptan HTML
    if (!$mail->Send()) {
        return "Hubo un error: " . $mail->ErrorInfo;
    } else {
        return "enviado";
    }
}
function enviarDetalle($detalle){
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = true;
    $mail->Port       = 465;
    $mail->Username   = "pandesv@usmpvirtual.edu.pe";
    $mail->Password   = "@nd3SUv1rtual2018";
    $mail->AddAttachment($detalle["plantilla_tmp"], $detalle["plantilla_name"]);
//    $mail->AddAttachment('images/FICHA DE INSRIPCIÓN marzo.xlsx', $name = 'FICHA DE INSRIPCIÓN.xlsx',  $encoding = 'base64', $type = 'application/vnd.ms-excel');--
    $mail->SetFrom($detalle["correo"], $detalle["nombre"]."-".$detalle["titulo"]);
    $mail->AddReplyTo($detalle["correo"], $detalle["nombre"]."-".$detalle["titulo"]);
    $mail->CharSet = 'UTF-8';
    $mail->AddAddress("andes_info@usmp.pe", "emilriosc@gmail.com");
    $mail->AddBCC("andes@usmp.pe");
    $mail->AddBCC("emilriosc@gmail.com");
//    $mail->AddAddress("gssombra@gmail.com");
//    $mail->AddBCC("gssombra@gmail.com");
    $mail->Subject = "Emprende Arequipa";
    $mail->WordWrap = 50; // Ajuste de texto
    $mail->IsHTML(true); //establece formato HTML para el contenido
    $contenido_html = '
        DETALLE DE REGISTRO:<br/>
        nombre: '.$detalle["nombre"].'<br/>
        correo: '.$detalle["correo"].'<br/>
        telefono: '.$detalle["telefono"].'<br/>
        ciudad: '.$detalle["ciudad"].'<br/>
        empresa: '.$detalle["titulo"].'<br/>
        video: '.$detalle["video"].'
    ';
    $mail->Body    = $contenido_html; //contenido con etiquetas HTML
    $mail->AltBody = strip_tags($contenido_html); //Contenido para servidores que no aceptan HTML
    if (!$mail->Send()) {
        return "Hubo un error: " . $mail->ErrorInfo;
    } else {
        return "enviado";
    }
}

//andes@usmp.pe
//"emilriosc@gmail.com"