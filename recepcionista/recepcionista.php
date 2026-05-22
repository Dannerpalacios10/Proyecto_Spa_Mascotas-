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

/* CONFIRMAR CITA */

if(isset($_GET['confirmar'])){

    $idCita =
    intval($_GET['confirmar']);

    $idGroomer =
    intval($_GET['groomer']);

    /* OBTENER DATOS DE LA CITA */

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

        /* VALIDAR DÍA*/

        $diaSemana =
        date(
            'N',
            strtotime($fechaInicio)
        );

        /* 6 = SÁBADO 7 = DOMINGO */

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

        /* VALIDAR HORARIOS */

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

        /* HORARIO MAÑANA */

        $horarioManana = (

            $horaInicio >= '08:00'
            &&
            $horaFin <= '12:00'

        );

        /* HORARIO TARDE */

        $horarioTarde = (

            $horaInicio >= '14:00'
            &&
            $horaFin <= '18:00'

        );

        /* VALIDAR HORARIO */

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

        /* VALIDAR DESCANSO */

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
            "Horario bloqueado por descanso de 12:00 a 14:00.";

            header("Location: recepcionista.php");
            exit();
        }

        /* VALIDAR SI EL GROOMER YA TIENE CITA */

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

        /* VALIDAR BLOQUEOS */

        $fechaSolo =
        date(
            'Y-m-d',
            strtotime($fechaInicio)
        );

        $sqlBloqueo = "
        SELECT *
        FROM bloqueos
        WHERE fecha='$fechaSolo'
        LIMIT 1
        ";

        $bloqueos =
        mysqli_query($conn,$sqlBloqueo);

        /* RESULTADO FINAL */

        if(
            mysqli_num_rows($validacion) > 0
        ){

            $_SESSION['error'] =
            "El groomer ya tiene una cita en ese horario.";

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

            /* CONFIRMAR CITA */

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

/* KPIs */

$sqlPendientes = "
SELECT COUNT(*) AS total
FROM cita
WHERE estado='PENDIENTE'
";

$resultPendientes =
mysqli_query($conn,$sqlPendientes);

$totalPendientes =
mysqli_fetch_assoc($resultPendientes)['total'];

/* CONFIRMADAS */

$sqlConfirmadas = "
SELECT COUNT(*) AS total
FROM cita
WHERE estado='CONFIRMADA'
";

$resultConfirmadas =
mysqli_query($conn,$sqlConfirmadas);

$totalConfirmadas =
mysqli_fetch_assoc($resultConfirmadas)['total'];

/* CITAS HOY */

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

/* CITAS PENDIENTES */

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

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Recepción
</title>

<link
rel="stylesheet"
href="../recepcionista/css/r.css?v=2">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

</head>

<body>

<div class="container">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="logo">

            <h2>SPA PAW PATROL</h2>

        </div>

        <ul class="menu">

            <li class="active">

                <a href="recepcionista.php">

                    <i class="fa-solid fa-house"></i>

                    Inicio

                </a>

            </li>

            <!--
            <li>

                <a href="calendario.php">

                    <i class="fa-solid fa-calendar-days"></i>

                    Calendario

                </a>

            </li>
            -->

            <li>

                <a href="pago.php">

                    <i class="fa-solid fa-credit-card"></i>

                    Cobro Servicio

                </a>

            </li>

            <li>

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

            <!--
            <li>

                <a href="promociones.php">

                    <i class="fa-solid fa-tags"></i>

                    Promociones

                </a>

            </li>
            -->

        </ul>

        <div class="logout">

            <a href="../auth/logout.php">

                <i class="fa-solid fa-right-from-bracket"></i>

                Cerrar Sesion

            </a>

        </div>

    </div>

    <!-- MAIN -->

    <div class="main-content">

        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h1>

                    Bienvenida Recepcionista,
                    <?php echo $nombre; ?>

                </h1>

                <p>
                    Gestión Operativa del Sistema 
                </p>

            </div>

            <div class="profile">

            <a href="../recepcionista/editar.php" class="profile-link">

                <i class="fa-solid fa-user-pen"></i>

                <span>Editar Perfil</span>

            </a>

        </div>

        </div>

        <!-- ALERTAS -->

        <?php if(isset($_SESSION['success'])){ ?>

        <div class="alert success">

            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>

        </div>

        <?php } ?>

        <?php if(isset($_SESSION['error'])){ ?>

        <div class="alert error">

            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>

        </div>

        <?php } ?>

        <!-- CARDS -->

        <div class="cards">

            <div class="card">

                <div class="icon blue">

                    <i class="fa-solid fa-clock"></i>

                </div>

                <div>

                    <h2>

                        <?php echo $totalPendientes; ?>

                    </h2>

                    <p>
                        Pendientes
                    </p>

                </div>

            </div>

            <div class="card">

                <div class="icon green">

                    <i class="fa-solid fa-calendar-check"></i>

                </div>

                <div>

                    <h2>

                        <?php echo $totalConfirmadas; ?>

                    </h2>

                    <p>
                        Confirmadas
                    </p>

                </div>

            </div>

            <div class="card">

                <div class="icon orange">

                    <i class="fa-solid fa-calendar-day"></i>

                </div>

                <div>

                    <h2>

                        <?php echo $totalHoy; ?>

                    </h2>

                    <p>
                        Citas Hoy
                    </p>

                </div>

            </div>

        </div>

        <!-- TABLA -->

        <div class="table-card">

            <div class="table-header">

                <h2>
                    Solicitudes Pendientes
                </h2>

            </div>

            <table>

                <thead>

                    <tr>

                        <th>Mascota</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Fecha</th>
                        <th>Asignar Groomer</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                <?php
                while($c = mysqli_fetch_assoc($citas)){
                ?>

                <tr>

                    <td>

                        <?php
                        echo $c['mascota_nombre'];
                        ?>

                    </td>

                    <td>

                        <?php
                        echo $c['cliente_nombre'];
                        ?>

                    </td>

                    <td>

                        <?php
                        echo $c['servicio_nombre'];
                        ?>

                    </td>

                    <td>

                        <?php
                        echo date(
                            "d/m/Y H:i",
                            strtotime($c['fecha_inicio'])
                        );
                        ?>

                    </td>

                    <!-- GROOMER -->

                    <td>

                        <form action="confcita.php" method="GET" class="form-actions">

                            <input
                            type="hidden"
                            name="id"
                            value="<?php echo $c['id_cita']; ?>">

                            <select
                            name="groomer"
                            required>

                                <option value="">
                                    Groomer
                                </option>

                                <?php

                                mysqli_data_seek($groomers,0);

                                while($g = mysqli_fetch_assoc($groomers)){
                                ?>

                                <option value="<?php echo $g['id_usuario']; ?>">

                                    <?php echo $g['nombre']; ?>

                                </option>

                                <?php } ?>

                            </select>

                    </td>

                    <!-- ACCIONES -->

                    <td class="actions">

                            <button
                            type="submit"
                            class="btn confirm">

                                <i class="fa-solid fa-check"></i>

                                Confirmar

                            </button>

                        </form>

                        <a
                        href="cancita.php?id=<?php echo $c['id_cita']; ?>"
                        class="btn cancel">

                            <i class="fa-solid fa-xmark"></i>

                            Cancelar

                        </a>

                    </td>


                </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>