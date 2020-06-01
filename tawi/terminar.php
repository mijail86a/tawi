<?php
require_once('lib/functions.lib.php');
$datos = new libreria();
if(isset($_REQUEST["codigo"]) || !empty($_REQUEST["codigo"]) ){
    $return = $datos->pedido_extraer($_REQUEST["codigo"]);
    $estado = false;
    if(is_array($return)){
        $codigo = $return["codigo"];
        $id_pedido = $return["pedido"];
        $costo = $return["total"]*100;
        $visible = "";
        $estado = true;
    }
}else{
    if(is_array($_SESSION["repeticua"])){
        $repeticua = $_SESSION["repeticua"];
        unset($_SESSION["repeticua"]);
        $_SESSION["carrito"] = $repeticua;
        //echo "<pre>".print_r($repeticua,true)."</pre>";
        //echo "<br/>".$repeticua["tienda"];
        setcookie("id_restaurante", $repeticua["tienda"], time() + (60 * 60 * 24), "/");

    }
    $return = $datos->pedido_grabar();
    $estado = false;
    if($return["estado"]){
        $codigo = $return["codigo"];
        $id_pedido = $return["pedido"];
        $costo = $return["total"]*100;
        $visible = "d-none";
        $estado = true;
    }
}
if( $estado ){
?>
<!DOCTYPE html>
<html>
    <head>
<?php
    include_once 'plantilla/header.php';
?>
    </head>
    <body>
        <!-- ------------------------------------------------------------------------------------------------------------------------ -->
        <div class="fixed-top p-3 d-flex justify-content-between align-items-center bd-highlight">
            <a href="/"><img class="img-fluid" src="<?php echo STATIC2.DIRECTORIO.IMG."/logo-tawi.png"; ?>"></a>
        </div>
        <div id="tw-contenedor" class="container-fluid h-100 d-flex">
            <div id="form-pagar" class="w-100 m-auto text-center">
                <input type="hidden" value="<?php echo $costo;?>">
                <div class="rounded-circle d-flex justify-content-center align-items-center m-auto" style="height: 20rem;width: 20rem;background-image: radial-gradient(circle, #799093, #26373A);">
                    <div class="text-white tw-fn"><?php echo $codigo;?></div>
                </div>
<?php
    if(!isset($_REQUEST["codigo"]) || empty($_REQUEST["codigo"]) ){
        echo "<p class=\"text-center\">Avísale al mozo tu número de pedido</p>";
    }
?>
                <button id="tw-p-<?php echo $id_pedido;?>" class="buyButton btn btn-success mt-1 <?php echo $visible;?>" data-tienda="<?php echo $_COOKIE["id_restaurante"]; ?>">Listo, tu pedido ha sido aceptado; presiona aquí para realizar el pago.</button>
            </div>
        </div>
        <div id="tw-completa" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<?php
    include_once 'plantilla/footer.php';
    if($estado){
?>
        <script type="text/javascript">
            $(function() {
                timer_pedido();
            });
        </script>
<?php 
    }
?>
        <!--<script src="https://checkout.culqi.com/js/v3" defer></script>-->
        <script src="https://checkout.culqi.com/js/v3"></script>
        <script>
            var id_destino = "tw-completa",
                precio = $("#form-pagar input").val();
            console.log(id_destino, precio);
            Culqi.publicKey = 'pk_test_EeucYTYu9dOKgNiX';
            Culqi.settings({
                title: 'TAWI',
                currency: 'PEN',
                amount: precio
            });
            $('.buyButton').on('click', function(e) {
                Culqi.open();
                e.preventDefault();
            });
            function culqi() {
                console.log("inicia");
                if (Culqi.token) {
                    // ¡Token creado exitosamente!
                    // Get the token ID:
                    var token = Culqi.token.id,
                        correo = Culqi.token.email;
                    console.log(correo, token, Culqi);
                    $.ajax({
                        url: 'https://tawi.com.pe/completar.php',
                        data: {
                            "source_id": token,
                            "amount": precio,
                            "currency_code": "PEN",
                            "email": correo
                        },
                        error: function (err) {
                            alert('Lo sentimos, a ocurrido un error');
                        },
                        dataType: 'json',
                        success: function (data) {
                            //var titulo = data.titulo,
                            //mensaje = data.mensaje;
                            //$("#"+id_destino+" .modal-title").text(mensaje);
                            //$("#"+id_destino+" .modal-body").text(titulo);
                            if(data.estado){
                                var codigo = $("#form-pagar button").prop("id");
                                $.ajax({
                                    url: 'https://tawi.com.pe/ajax/ajax.lib.php',
                                    data: { origen: "proceso", codigo: codigo },
                                    dataType: 'json',
                                    type: 'POST',
                                    success: function (data) {
                                        if(data){
                                            tienda = $(".buyButton").data("tienda");
                                            $(".buyButton").remove();
                                            $("#form-pagar").append("<a class=\"btn btn-success\" href=\"carta.php?id="+tienda+"\" role=\"button\">Gracias por realizar tu pago, seguir comprando.</a>");
                                            //$("#"+id_destino).modal('show');
                                        }else{
                                            alert("Error en la tarjeta intente con otra.");
                                        }
                                    }
                                });
                            }
                        },
                        type: 'POST'
                    });
                } else { // ¡Hubo algún problema!
                    // Mostramos JSON de objeto error en consola
                    console.log(Culqi.error);
                    console.log(Culqi.error.mensaje);
                    alert("Error en la tarjeta intente con otra.");
                }
            }
            $("#"+id_destino).on('hidden.bs.modal', function (e) {
                window.location.href = "https://tawi.com.pe/";
            });
        </script>
    </body>
</html>
<?php
    }else{
        header("location:index.php?id=".$_COOKIE["id_restaurante"]);
    }
?>