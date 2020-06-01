<?php
    session_start();
    //echo "<pre>".print_r($_SESSION, true)."</pre>";
    //echo "##########################################################################################################################<br/>";
    echo "<pre>".print_r(unserialize($_COOKIE["carrito"]), true)."</pre>";
?>