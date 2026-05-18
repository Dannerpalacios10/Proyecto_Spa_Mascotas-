<?php

session_start();
include("../config/database.php");
include("../config/log.php");

if(isset($_SESSION['id_usuario'])){

    registrarLog(
        $conn,
        $_SESSION['id_usuario'],
        "Cerró sesión del sistema"
    );
}

session_unset();
session_destroy();

header("Location: ../index.php");
exit();

?>