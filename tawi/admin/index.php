<?php
    require_once('../lib/functions.lib.php');
    if(isset($_POST) && !empty($_POST)){
        $datos = new libreria();
        $login = $datos->login_ingresoAdmin( $_POST["usuario"], $_POST["clave"] );
        if($login["estado"]){
            //setcookie("id_usuario", $login["detalle"]["id"], time()+(60*60*24), "/");
            setcookie("nombre", $login["detalle"]["nombre"], time()+(60*60*24*30), "/");
            if($login["detalle"]["id"] == 3){
                header('Location: clientes.php');
            }else{
                $datos->login_usuario($login["detalle"]["id"]);
                header('Location: dashboard.php');
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
<?php 
    require_once ("plantilla/header.php");
?>
    <link href="<?php echo STATIC2.ADMIN."css/login.css"?>" rel="stylesheet">
    </head>
    <body class="d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Sign In</h5>
                        <form class="form-signin" action="index.php" method="POST">
                            <div class="form-label-group">
                                <input type="email" id="inputEmail" name="usuario" class="form-control" placeholder="Email address" required autofocus>
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="form-label-group">
                                <input type="password" id="inputPassword" name="clave" class="form-control" placeholder="Password" required>
                                <label for="inputPassword">Password</label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
    require_once ("plantilla/footer.php");
?>
    </body>
</html>