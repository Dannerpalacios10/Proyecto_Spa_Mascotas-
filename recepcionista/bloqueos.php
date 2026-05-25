<?php

session_start();

/** @var mysqli $conn */

include("../config/database.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "RECEPCIONISTA"){
    header("Location: ../auth/login.php");
    exit();
}

$idRecepcionista = $_SESSION['id_usuario'];

$nombre = $_SESSION['nombre'];

/* REGISTRAR BLOQUEO */

if(isset($_POST['registrar_bloqueo'])){

    $tipo = $_POST['tipo'];

    $fecha = $_POST['fecha'];

    $descripcion = $_POST['descripcion'];

    $sqlBloqueo = "
    INSERT INTO bloqueos(
        tipo,
        fecha,
        descripcion
    )
    VALUES(
        '$tipo',
        '$fecha',
        '$descripcion'
    )
    ";

    mysqli_query($conn,$sqlBloqueo);

    $_SESSION['success'] =
    "Bloqueo registrado correctamente.";

    header("Location: recepcionista.php");
    exit();
}

/* LISTAR BLOQUEOS */

$sqlListaBloqueos = "
SELECT *
FROM bloqueos
ORDER BY fecha DESC
LIMIT 5
";

$listaBloqueos =
mysqli_query($conn,$sqlListaBloqueos);

/* CONFIRMAR CITA */

if(isset($_GET['confirmar'])){

    $idCita =
    intval($_GET['confirmar']);

    $idGroomer =
    intval($_GET['groomer']);

    $sqlCita = "
    SELECT *
    FROM cita
    WHERE id_cita='$idCita'
    ";

    $resultCita =
    mysqli_query($conn,$sqlCita);

    $citaData =
    mysqli_fetch_assoc($resultCita);

    if($citaData){

        $fechaInicio =
        $citaData['fecha_inicio'];

        $fechaFin =
        $citaData['fecha_fin'];

        $diaSemana =
        date(
            'N',
            strtotime($fechaInicio)
        );

        if(
            $diaSemana == 6
            ||
            $diaSemana == 7
        ){

            $_SESSION['error'] =
            "Solo se atiende de lunes a viernes.";

            header("Location: recepcionista.php");
            exit();
        }

        $horaInicio =
        date(
            'H:i',
            strtotime($fechaInicio)
        );

        $horaFin =
        date(
            'H:i',
            strtotime($fechaFin)
        );

        $horarioManana = (

            $horaInicio >= '08:00'
            &&
            $horaFin <= '12:00'

        );

        $horarioTarde = (

            $horaInicio >= '14:00'
            &&
            $horaFin <= '18:00'

        );

        if(

            !$horarioManana
            &&
            !$horarioTarde

        ){

            $_SESSION['error'] =
            "Horario fuera de atención.";

            header("Location: recepcionista.php");
            exit();
        }

        if(

            (
                $horaInicio >= '12:00'
                &&
                $horaInicio < '14:00'
            )

            ||

            (
                $horaFin > '12:00'
                &&
                $horaFin <= '14:00'
            )

        ){

            $_SESSION['error'] =
            "Horario bloqueado por descanso.";

            header("Location: recepcionista.php");
            exit();
        }

        $sqlValidar = "
        SELECT *
        FROM cita
        WHERE id_groomer='$idGroomer'
        AND estado IN
        (
            'CONFIRMADA',
            'EN_PROGRESO'
        )
        AND (

            fecha_inicio < '$fechaFin'

            AND

            fecha_fin > '$fechaInicio'

        )
        ";

        $validacion =
        mysqli_query($conn,$sqlValidar);

        $fechaSolo =
        date(
            'Y-m-d',
            strtotime($fechaInicio)
        );

        $sqlBloqueoFecha = "
        SELECT *
        FROM bloqueos
        WHERE fecha='$fechaSolo'
        LIMIT 1
        ";

        $bloqueos =
        mysqli_query($conn,$sqlBloqueoFecha);

        if(
            mysqli_num_rows($validacion) > 0
        ){

            $_SESSION['error'] =
            "El groomer ya tiene una cita.";

        }else if(
            mysqli_num_rows($bloqueos) > 0
        ){

            $bloqueo =
            mysqli_fetch_assoc($bloqueos);

            $_SESSION['error'] =
            "Fecha bloqueada por: "
            .
            ucfirst($bloqueo['tipo']);

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
    }

    header("Location: recepcionista.php");
    exit();
}

/* CANCELAR CITA */

if(isset($_GET['cancelar'])){

    $idCita =
    intval($_GET['cancelar']);

    $sqlCancelar = "
    UPDATE cita
    SET estado='CANCELADA'
    WHERE id_cita='$idCita'
    ";

    mysqli_query($conn,$sqlCancelar);

    $_SESSION['success'] =
    "Cita cancelada correctamente.";

    header("Location: recepcionista.php");
    exit();
}

/* KPIS */

$sqlPendientes = "
SELECT COUNT(*) AS total
FROM cita
WHERE estado='PENDIENTE'
";

$resultPendientes =
mysqli_query($conn,$sqlPendientes);

$totalPendientes =
mysqli_fetch_assoc($resultPendientes)['total'];

$sqlConfirmadas = "
SELECT COUNT(*) AS total
FROM cita
WHERE estado='CONFIRMADA'
";

$resultConfirmadas =
mysqli_query($conn,$sqlConfirmadas);

$totalConfirmadas =
mysqli_fetch_assoc($resultConfirmadas)['total'];

$sqlHoy = "
SELECT COUNT(*) AS total
FROM cita
WHERE DATE(fecha_inicio)=CURDATE()
";

$resultHoy =
mysqli_query($conn,$sqlHoy);

$totalHoy =
mysqli_fetch_assoc($resultHoy)['total'];

/* GROOMERS */

$sqlGroomers = "
SELECT

usuario.id_usuario,

usuario.nombre

FROM usuario

INNER JOIN rol
ON usuario.id_rol = rol.id_rol

WHERE rol.nombre='GROOMER'
";

$groomers =
mysqli_query($conn,$sqlGroomers);

/* CITAS */

$sqlCitas = "
SELECT

cita.*,

mascota.nombre AS mascota_nombre,

servicio.nombre AS servicio_nombre,

usuario.nombre AS cliente_nombre

FROM cita

INNER JOIN mascota
ON cita.id_mascota = mascota.id_mascota

INNER JOIN servicio
ON cita.id_servicio = servicio.id_servicio

INNER JOIN usuario
ON mascota.id_cliente = usuario.id_usuario

WHERE cita.estado='PENDIENTE'

ORDER BY cita.fecha_inicio ASC
";

$citas =
mysqli_query($conn,$sqlCitas);

?>

<script>

function seleccionarTipo(tipo,btn){

    document.getElementById("tipo").value = tipo;

    const botones =
    document.querySelectorAll(".tipo-btn");

    botones.forEach(b=>{

        b.classList.remove("active");
    });

    btn.classList.add("active");
}

</script>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Bloqueos</title>

<link rel="stylesheet" href="../recepcionista/css/bloqueo.css?v=1">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>
<body>

<div class="container">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="logo">

            <h2>SPA PAW PATROL</h2>

        </div>

        <ul class="menu">

            <li>

                <a href="recepcionista.php">

                    <i class="fa-solid fa-house"></i>

                    Inicio

                </a>

            </li>

            <li>

                <a href="pago.php">

                    <i class="fa-solid fa-credit-card"></i>

                    Cobro Servicio

                </a>

            </li>

            <li class="active">

                <a href="bloqueos.php">

                    <i class="fa-solid fa-ban"></i>

                    Bloqueos

                </a>

            </li>

            <li>

                <a href="inventario.php">

                    <i class="fa-solid fa-bag-shopping"></i>

                    Inventario

                </a>

            </li>

        </ul>

        <div class="logout">

            <a href="../auth/logout.php">

                <i class="fa-solid fa-right-from-bracket"></i>

                Cerrar Sesión

            </a>

        </div>

    </div>

    <!-- MAIN -->

    <div class="main-content">

        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h1>
                    Gestión de Bloqueos
                </h1>

                <p>

                    Bienvenido,
                    <?php echo htmlspecialchars($nombre); ?>

                </p>

            </div>

        </div>

        <!-- ALERTA -->

        <?php if(isset($_SESSION['mensaje'])){ ?>

            <div class="alert success">

                <?php

                echo $_SESSION['mensaje'];

                unset($_SESSION['mensaje']);

                ?>

            </div>

        <?php } ?>

        <!-- FORMULARIO -->

        <div class="panel">

            <div class="panel-header">

                <h2>
                    Registrar Bloqueo
                </h2>

            </div>

            <form method="POST">

                <div class="buttons-group">

                    <button
                    type="button"
                    class="tipo-btn"
                    onclick="seleccionarTipo('feriado',this)">

                        <i class="fa-solid fa-calendar-xmark"></i>

                        Feriado

                    </button>

                    <button
                    type="button"
                    class="tipo-btn"
                    onclick="seleccionarTipo('mantenimiento',this)">

                        <i class="fa-solid fa-screwdriver-wrench"></i>

                        Mantenimiento

                    </button>

                    <button
                    type="button"
                    class="tipo-btn"
                    onclick="seleccionarTipo('descanso',this)">

                        <i class="fa-solid fa-mug-hot"></i>

                        Descanso

                    </button>

                </div>

                <input
                type="hidden"
                name="tipo"
                id="tipo"
                required>

                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Fecha
                        </label>

                        <input
                        type="date"
                        name="fecha"
                        required>

                    </div>

                    <div class="form-group full">

                        <label>
                            Descripción
                        </label>

                        <textarea
                        name="descripcion"
                        required></textarea>

                    </div>

                    <div class="form-group full">

                        <button
                        type="submit"
                        name="registrar"
                        class="btn-save">

                            <i class="fa-solid fa-floppy-disk"></i>

                            Guardar Bloqueo

                        </button>

                    </div>

                </div>

            </form>

        </div>

        <!-- TABLA -->

        <div class="table-card">

            <div class="table-header">

                <h2>
                    Bloqueos Registrados
                </h2>

            </div>

            <div class="table-responsive">

                <table>

                    <thead>

                        <tr>

                            <th>Tipo</th>

                            <th>Fecha</th>

                            <th>Descripción</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        while($b = mysqli_fetch_assoc($listaBloqueos)){
                        ?>

                        <tr>

                            <td>

                                <?php
                                echo ucfirst($b['tipo']);
                                ?>

                            </td>

                            <td>

                                <?php
                                echo $b['fecha'];
                                ?>

                            </td>

                            <td>

                                <?php
                                echo htmlspecialchars($b['descripcion']);
                                ?>

                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script>

function seleccionarTipo(tipo,btn){

    document.getElementById("tipo").value = tipo;

    const botones =
    document.querySelectorAll(".tipo-btn");

    botones.forEach(b=>{

        b.classList.remove("active");
    });

    btn.classList.add("active");
}

</script>

</body>
</html>
