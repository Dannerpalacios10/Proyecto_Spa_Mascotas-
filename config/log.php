<?php

function registrarLog($conn, $idUsuario, $accion){

    $ip = $_SERVER['REMOTE_ADDR'];
    $navegador = $_SERVER['HTTP_USER_AGENT'];

    $sql = "INSERT INTO auditoria
            (id_usuario, accion, fecha, ip_usuario, navegador)
            VALUES
            ('$idUsuario', '$accion', NOW(), '$ip', '$navegador')";

    mysqli_query($conn, $sql);
}

?>