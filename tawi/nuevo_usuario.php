<?php
    require_once('lib/functions.lib.php');
    $datos = new libreria();
    $cliente = $datos->cliente_lista();
    $id_usuario = isset($_COOKIE["id_usuario"])?$_COOKIE["id_usuario"]:0;
    if(isset($_POST) && !empty($_POST)){
        echo $_POST["genero"]."<br/>";
        echo "<pre>".print_r($_POST,true)."</pre>";
        $id = $datos->cliente_registra($_POST);
        if($id > 0){
            setcookie("id_cliente", $id, time() + (2592000), "/");
            setcookie("nombre_cliente", $_POST["email"], time() + (2592000), "/");
            header('Location: index.php');
        }
    }else{
    //echo "<pre>".print_r($cliente,true)."</pre>";
?>
<!DOCTYPE html>
<html lang="es">
    <head>
<?php
        include_once 'plantilla/header.php';
?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-7 col-lg-4 m-auto">
                    <div class="d-flex justify-content-between align-items-center my-2">
                        <a href="/"><img class="img-fluid" src="<?php echo STATIC2.DIRECTORIO.IMG."logo-tawi.png"; ?>"></a>
                    </div>
                    <div class="conteiner-fluid pb-3">
                        <div class="row">
                            <div class="col-12 h-100 overflow-auto">
<form class="was-validated" method="POST" action="nuevo_usuario.php">
    <div class="form-group">
        <label for="email">Correo</label>
        <input type="email" class="form-control tw-valida" id="email" name="email" placeholder="ingrese correo" required>
        <div class="invalid-feedback">Escriba correctamente el correo electronico</div>
    </div>
    <div class="form-group">
        <label for="clave">Password</label>
        <input type="password" class="form-control tw-valida" id="clave" name="clave" placeholder="Ingrese contraseña" required>
        <div class="invalid-feedback">Escriba correctamente la contraseña</div>
    </div>
    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" class="form-control tw-valida" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
        <div class="invalid-feedback">Escriba correctamente su nombre</div>
    </div>
    <div class="form-group">
        <label for="apellido">Apellido</label>
        <input type="text" class="form-control tw-valida" id="apellido" name="apellido" placeholder="Ingrese su apellido" required>
        <div class="invalid-feedback">Escriba correctamente su apellido</div>
    </div>
    <div class="form-group">
        <label for="clave">Dirección</label>
        <input type="text" class="form-control tw-valida" id="direccion" name="direccion" placeholder="Ingrese direccción" required>
        <div class="invalid-feedback">Escriba correctamente la dirección</div>
    </div>
    <div class="form-group">
        <label for="clave">Teléfono</label>
        <input type="text" class="form-control tw-valida" id="telefono" name="telefono" placeholder="Ingrese teléfono" required>
        <div class="invalid-feedback">Escriba correctamente la dirección</div>
    </div>
    <div class="form-group">
        <label>Sexo</label>
        <select class="custom-select mr-sm-2 tw-valida" id="tw-genero" name="genero" required>
            <option value="">Seleccione genero</option>
            <option value="1">Femenino</option>
            <option value="2">Masculino</option>
        </select>
        <div class="invalid-feedback">Seleccion el genero</div>
    </div>
    <div class="form-group">
        <label>Fecha de nacimiento</label>
        <label class="mr-sm-2 sr-only" for="tw-selectDia">Día</label>
        <select class="custom-select mr-sm-2 tw-valida" id="tw-selectDia" name="selectDia" required>
            <option value="">Seleccione día</option>
<?php
        for ($i=1; $i < 32; $i++) { 
            echo "<option value=\"$i\">$i</option>";
        }
?>
        </select>
        <div class="invalid-feedback">Seleccione el día</div>
    </div>
    <div class="form-group">
        <label class="mr-sm-2 sr-only" for="tw-selectMes">Mes</label>
        <select class="custom-select mr-sm-2 tw-valida" id="tw-selectMes" name="selectMes" required>
            <option value="">Seleccione mes</option>
<?php
        $meses = [ "Enero","Febrero","marzo","abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noiviembre","Diciembre"];
        foreach ($meses as $key => $value) {
            echo "<option value=\"".($key+1)."\">$value</option>";
        }
?>
        </select>
        <div class="invalid-feedback">Seleccione el mes</div>
    </div>
    <div class="form-group">
        <label class="mr-sm-2 sr-only" for="tw-selectAño">Año</label>
        <select class="custom-select mr-sm-2 tw-valida" id="tw-selectAño" name="selectAño" required>
            <option value="">Seleccione año</option>
<?php
    //for ($i=1960; $i < date("Y"); $i++) { 
        $mitad = round((date("Y") - 1960)/2,0,PHP_ROUND_HALF_UP) + 1960;
        for ($i = 1960; $i <=  date("Y"); $i++) { 
            echo "<option value=\"$i\">$i</option>";
        }
?>
        </select>
        <div class="invalid-feedback">Seleccione el año</div>
    </div>
    <button id="tw-registra" type="button" class="btn tw-btn-a float-right">Registrar</button>
</form>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 bg-dark">&nbsp;</div>
                </div>
            </div>
        </div>
<?php
    include_once 'plantilla/footer.php';
?>
        <script type="text/javascript">
            $(".lazy").lazyload();
        </script>
    </body>
</html>
<?php 
    }
?>