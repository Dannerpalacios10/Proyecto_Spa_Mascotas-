<?php

session_start();

/** @var mysqli $conn */

include("../config/database.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../auth/login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

if(!isset($_GET['id'])){
    header("Location: citas.php");
    exit();
}

$id_cita = intval($_GET['id']);

/* ========================================== */
/* OBTENER CITA */
/* ========================================== */

$sql = "

SELECT cita.*
FROM cita
INNER JOIN mascota
ON cita.id_mascota = mascota.id_mascota
WHERE cita.id_cita='$id_cita'
AND mascota.id_cliente='$id_usuario'

";

$resultado = mysqli_query($conn,$sql);

if(mysqli_num_rows($resultado) <= 0){

    header("Location: citas.php");
    exit();
}

$cita = mysqli_fetch_assoc($resultado);

/* ========================================== */
/* VALIDAR TIEMPO */
/* ========================================== */

$fechaCita =
strtotime($cita['fecha_inicio']);

$horaActual =
time();

$diferencia =
$fechaCita - $horaActual;

/* MENOS DE 1 HORA */

if($diferencia < 3600){

    $_SESSION['error_cancelacion'] =
    "La cita solo puede cancelarse con mínimo 1 hora de anticipación.";

    header("Location: citas.php");
    exit();
}

/* ========================================== */
/* CANCELAR */
/* ========================================== */

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $motivo =
    mysqli_real_escape_string(
        $conn,
        $_POST['motivo']
    );

    mysqli_query($conn,"

    UPDATE cita
    SET

    estado='CANCELADA',
    motivo_cancelacion='$motivo',
    fecha_cancelacion=NOW(),
    cancelado_por='$id_usuario'

    WHERE id_cita='$id_cita'

    ");

    $_SESSION['success_cancelacion'] =
    "Cita cancelada correctamente.";

    header("Location: citas.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Cancelar Cita
</title>

<link
rel="stylesheet"
href="../cliente/css/cancelarcita.css">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

</head>

<body>

<div class="container">

    <div class="card">

        <h1>
            Cancelar Cita
        </h1>

        <p>
            Indica el motivo de cancelación.
        </p>

        <form method="POST">

            <div class="input-group">

                <label>
                    Motivo
                </label>

                <select
                name="motivo"
                required>

                    <option value="">
                        Seleccione
                    </option>

                    <option value="Salud">
                        Salud
                    </option>

                    <option value="Emergencia">
                        Emergencia
                    </option>

                    <option value="Tiempo">
                        Falta de tiempo
                    </option>

                    <option value="Otro">
                        Otro
                    </option>

                </select>

            </div>

            <div class="policy">

                <input
                type="checkbox"
                required>

                <span>

                    Acepto la política de cancelación.

                </span>

            </div>

            <button
            type="submit"
            class="btn danger">

                Confirmar Cancelación

            </button>

            <a
            href="citas.php"
            class="btn secondary">

                Volver

            </a>

        </form>

    </div>

</div>

</body>
</html>