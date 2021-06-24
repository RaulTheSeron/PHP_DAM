<?php
    // Recuperamos informacion de la sesion
    session_start();
    
    // Y la eliminamos
    session_unset();
    
    // Volvemos a pagina de login
    header("Location: login.php");
?>
