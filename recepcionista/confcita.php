<?php

session_start();

include("../config/database.php");

/** @var mysqli $conn */

if(
!isset($_GET['id'])
||
!isset($_GET['groomer'])
){
    header("Location: recepcionista.php");
    exit();
}

$idCita = intval($_GET['id']);
$idGroomer = intval($_GET['groomer']);

$idRecepcionista = $_SESSION['id_usuario'];

/* OBTENER CITA */

$sqlCita = "
SELECT *
FROM cita
WHERE id_cita='$idCita'
";

$resultCita =
mysqli_query($conn,$sqlCita);

$cita =
mysqli_fetch_assoc($resultCita);

if(!$cita){

    $_SESSION['error'] =
    "La cita no existe.";

    header("Location: recepcionista.php");
    exit();
}

$fechaInicio = $cita['fecha_inicio'];
$fechaFin = $cita['fecha_fin'];

/* VALIDAR DISPONIBILIDAD */

$sqlValidar = "
SELECT *
FROM cita

WHERE id_groomer='$idGroomer'

AND estado IN
(
    'CONFIRMADA',
    'EN_PROGRESO'
)

AND
(
    fecha_inicio < '$fechaFin'
    AND
    fecha_fin > '$fechaInicio'
)
";

$resultValidar =
mysqli_query($conn,$sqlValidar);

/* VALIDAR BLOQUEOS */

$sqlBloqueo = "
SELECT *
FROM bloqueo_horario

WHERE
(
    id_groomer='$idGroomer'
    OR id_groomer IS NULL
)

AND
(
    fecha_inicio < '$fechaFin'
    AND
    fecha_fin > '$fechaInicio'
)
";

$resultBloqueo =
mysqli_query($conn,$sqlBloqueo);

if(
mysqli_num_rows($resultValidar) > 0
||
mysqli_num_rows($resultBloqueo) > 0
){

    $_SESSION['error'] =
    "El groomer no está disponible.";

}else{

    $sqlConfirmar = "
    UPDATE cita

    SET
    estado='CONFIRMADA',
    id_groomer='$idGroomer',
    notificado='1',
    fecha_confirmacion=NOW(),
    confirmado_por='$idRecepcionista'

    WHERE id_cita='$idCita'
    ";

    mysqli_query($conn,$sqlConfirmar);

    $_SESSION['success'] =
    "Cita confirmada correctamente.";
}

header("Location: recepcionista.php");
exit();

?>