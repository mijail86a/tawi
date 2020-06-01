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
<?php
    if( isset($_COOKIE["cliente_nombre"]) || !empty($_COOKIE["cliente_nombre"]) ){
?>
                    <li><a class="nav-link text-white" href="clientes.php"><?php echo $_COOKIE["cliente_nombre"];?></a></li>
<?php
    }
?>
                    <li class="nav-item active">
                        <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Agregar productos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="categoria.php">Nivel 1</a>
                            <a class="dropdown-item" href="producto.php">Nivel 2</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="agregado.php">Nivel 3</a>
                            <a class="dropdown-item" href="extra.php">Nivel 4</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Reportes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="reporte-total.php">Total Pedidos</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="reporte-pagados.php">Pagados</a>
                            <a class="dropdown-item" href="reporte-pendientes.php">Pendientes</a>
                            <a class="dropdown-item" href="reporte-cancelados.php">Cancelados</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>