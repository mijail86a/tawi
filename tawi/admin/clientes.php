<?php
    require_once('../lib/functions.lib.php');
    $datos = new libreria();
    if( (isset($_REQUEST["cliente"]) || !empty($_REQUEST["cliente"])) && (isset($_REQUEST["nombre"]) || !empty($_REQUEST["nombre"])) ){
        //setcookie("cliente", $_REQUEST["cliente"], time()+(3600*4), "/");
        $datos->login_usuario($_REQUEST["cliente"]);
        setcookie("cliente_nombre", $_REQUEST["nombre"], time()+(3600*4), "/");
        header('Location: dashboard.php');
    }else{
    //$usuario = $datos->login_usuario();
?>
<!DOCTYPE html>
<html>
    <head>
<?php 
        require_once ("plantilla/header.php");
?>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light tw-bg-a">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown ml-auto">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_COOKIE["nombre"];?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <!--<a class="dropdown-item" href="<?php //echo DOMINIO.ADMIN."perfil.php";?>">Editar Perfil</a>
                            <div class="dropdown-divider"></div>-->
                            <a class="dropdown-item" href="salir.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Salir</a>
                        </div>
                    </li>
                    <li><a class="nav-link text-white" href="clientes.php"><?php echo $cliente_nombre;?></a></li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid p-3 tw-aa">
            <div class="row">
<?php
        $cliente = $datos->clientesSelect(1);
        foreach ($cliente["detalle"] as $key => $value) {
            echo "<div class=\"col-2\"><div class=\"card\">
            <img src=\"".$value["logo"]."\" class=\"card-img-top\" alt=\"".$value["logo"]."\">
            <div class=\"card-body\">
            <h5 class=\"card-title\">".$value["nombre"]."</h5>
            <a href=\"clientes.php?cliente=$key&nombre=".$value["nombre"]."\" class=\"btn btn-primary\">Ingresar</a>
            </div></div></div>";
        }
?>    
            </div>
        </div>
<?php
        require_once ("plantilla/footer.php");
?>
    </body>
</html>
<?php
    }
?>