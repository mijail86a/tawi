<?php
	setcookie("id_usuario", "", time()-1, "/");
    setcookie("nombre", "", time()-1, "/");
    header('Location: index.php');
?>