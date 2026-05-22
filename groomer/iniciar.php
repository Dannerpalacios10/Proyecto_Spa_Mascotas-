<?php

session_start();

/** @var mysqli $conn */

include("../config/database.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "GROOMER"){
    header("Location: ../auth/login.php");
    exit();
}

$idGroomer = $_SESSION['id_usuario'];

if(isset($_GET['id'])){

    $idCita = intval($_GET['id']);

    /* VALIDAR QUE LA CITA SEA DEL GROOMER */

    $sql = "
    SELECT *
    FROM cita
    WHERE id_cita='$idCita'
    AND id_groomer='$idGroomer'
    ";

    $resultado =
    mysqli_query($conn,$sql);

    if(mysqli_num_rows($resultado) > 0){

        $cita =
        mysqli_fetch_assoc($resultado);

        /* SOLO SI ESTA CONFIRMADA */

        if($cita['estado'] == "CONFIRMADA"){

            $sqlUpdate = "
            UPDATE cita
            SET
            estado='EN_PROGRESO'
            WHERE id_cita='$idCita'
            ";

            mysqli_query($conn,$sqlUpdate);
        }
    }
}

header("Location: agenda.php");
exit();

?>