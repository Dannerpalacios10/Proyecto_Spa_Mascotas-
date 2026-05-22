<?php

session_start();

/** @var mysqli $conn */

include("../config/database.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "CLIENTE"){
    header("Location: ../auth/login.php");
    exit();
}

$idCliente = $_SESSION['id_usuario'];
$nombre = $_SESSION['nombre'];

$mensaje = "";
$tipo = "";

/* REGISTRAR CITA */

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $idMascota =
    mysqli_real_escape_string(
    $conn,
    $_POST['id_mascota']
    );

    $idServicio =
    mysqli_real_escape_string(
    $conn,
    $_POST['id_servicio']
    );

    $idGroomer =
    !empty($_POST['id_groomer'])
    ? $_POST['id_groomer']
    : "NULL";

    $fecha =
    $_POST['fecha'];

    $hora =
    $_POST['hora'];

    $fechaInicio =
    $fecha . " " . $hora . ":00";

    /* VALIDAR FECHA Y HORA */

    $fechaActual = date("Y-m-d");
    $horaActual = date("H:i");

    if(
        $fecha == $fechaActual
        &&
        $hora < $horaActual
    ){

        $mensaje =
        "No puedes reservar una hora pasada.";

        $tipo =
        "error";

    }else{

        /* SERVICIO */

        $sqlServicio = "
        SELECT *
        FROM servicio
        WHERE id_servicio='$idServicio'
        ";

        $resultadoServicio =
        mysqli_query($conn,$sqlServicio);

        $servicio =
        mysqli_fetch_assoc($resultadoServicio);

        $duracion =
        $servicio['duracion_base'];

        $fechaFin =
        date(
            "Y-m-d H:i:s",
            strtotime($fechaInicio . " +$duracion minutes")
        );

        /* VALIDAR HORARIO */

        $sqlValidar = "

        SELECT *
        FROM cita

        WHERE

        id_mascota = '$idMascota'

        AND fecha_inicio = '$fechaInicio'

        AND estado IN
        (
            'PENDIENTE',
            'CONFIRMADA',
            'EN_PROGRESO'
        )

        ";

        $resultadoValidar =
        mysqli_query($conn,$sqlValidar);

        if(mysqli_num_rows($resultadoValidar) > 0){

            $mensaje =
            "La mascota ya tiene una cita en ese horario.";

            $tipo =
            "error";

        }else{

            /* INSERTAR CITA */

            $sqlInsert = "
            INSERT INTO cita
            (
                id_mascota,
                id_groomer,
                id_servicio,
                fecha_inicio,
                fecha_fin,
                estado,
                creado_por
            )
            VALUES
            (
                '$idMascota',
                $idGroomer,
                '$idServicio',
                '$fechaInicio',
                '$fechaFin',
                'PENDIENTE',
                '$idCliente'
            )
            ";

            if(mysqli_query($conn,$sqlInsert)){

                $mensaje =
                "Solicitud de cita enviada correctamente.";

                $tipo =
                "success";

            }else{

                $mensaje =
                "Error al registrar cita.";

                $tipo =
                "error";
            }
        }
    }
}

/* MASCOTAS */

$sqlMascotas = "
SELECT *
FROM mascota
WHERE id_cliente='$idCliente'
ORDER BY nombre ASC
";

$mascotas =
mysqli_query($conn,$sqlMascotas);

/* SERVICIOS */

$sqlServicios = "
SELECT *
FROM servicio
ORDER BY nombre ASC
";

$servicios =
mysqli_query($conn,$sqlServicios);

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

servicio.nombre AS servicio_nombre

FROM cita

INNER JOIN mascota
ON cita.id_mascota = mascota.id_mascota

INNER JOIN servicio
ON cita.id_servicio = servicio.id_servicio

WHERE mascota.id_cliente='$idCliente'

ORDER BY cita.fecha_inicio DESC
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
Mis Citas
</title>

<link
rel="stylesheet"
href="../cliente/css/citas.css?v=3">

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

            <i class="fa-solid fa-paw"></i>

            <h2>SPA PAW PATROL</h2>

        </div>

        <ul class="menu">

            <li>

                <a href="cliente.php">

                    <i class="fa-solid fa-house"></i>

                    <span>Inicio</span>

                </a>

            </li>

            <li>

                <a href="mascotas.php">

                    <i class="fa-solid fa-dog"></i>

                    <span>Mascotas</span>

                </a>

            </li>

            <li class="active">

                <a href="citas.php">

                    <i class="fa-solid fa-calendar-days"></i>

                    <span>Citas</span>

                </a>

            </li>

            <li>

                <a href="servicios.php">

                    <i class="fa-solid fa-scissors"></i>

                    <span>Servicios</span>

                </a>

            </li>

            <li>

                <a href="../auth/logout.php">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    <span>Salir</span>

                </a>

            </li>

        </ul>

    </div>

    <!-- MAIN -->

    <div class="main">

        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h1>
                    Gestión de Citas
                </h1>

                <p>
                    Solicita y administra las citas de tus mascotas.
                </p>

            </div>

        </div>

        <!-- ALERTAS -->

        <?php if(isset($_SESSION['success_cancelacion'])){ ?>

        <div class="alert success">

            <?php
            echo $_SESSION['success_cancelacion'];
            unset($_SESSION['success_cancelacion']);
            ?>

        </div>

        <?php } ?>

        <?php if(isset($_SESSION['error_cancelacion'])){ ?>

        <div class="alert error">

            <?php
            echo $_SESSION['error_cancelacion'];
            unset($_SESSION['error_cancelacion']);
            ?>

        </div>

        <?php } ?>

        <?php if($mensaje != ""){ ?>

        <div class="alert <?php echo $tipo; ?>">

            <?php echo $mensaje; ?>

        </div>

        <?php } ?>

        <!-- FORMULARIO -->

        <div class="form-card">

            <h2>
                Solicitar Nueva Cita
            </h2>

            <form method="POST">

                <div class="grid">

                    <!-- MASCOTA -->

                    <div class="input-group">

                        <label>
                            Mascota
                        </label>

                        <select
                        name="id_mascota"
                        required>

                            <option value="">
                                Seleccione mascota
                            </option>

                            <?php
                            while($m = mysqli_fetch_assoc($mascotas)){
                            ?>

                            <option value="<?php echo $m['id_mascota']; ?>">

                                <?php echo $m['nombre']; ?>

                            </option>

                            <?php } ?>

                        </select>

                    </div>

                    <!-- SERVICIO -->

                    <div class="input-group">

                        <label>
                            Servicio
                        </label>

                        <select
                        name="id_servicio"
                        required>

                            <option value="">
                                Seleccione servicio
                            </option>

                            <?php
                            while($s = mysqli_fetch_assoc($servicios)){
                            ?>

                            <option value="<?php echo $s['id_servicio']; ?>">

                                <?php echo $s['nombre']; ?>

                            </option>

                            <?php } ?>

                        </select>

                    </div>

                    <!-- GROOMER -->

                    <div class="input-group">

                        <label>
                            Groomer Preferido
                        </label>

                        <select
                        name="id_groomer">

                            <option value="">
                                Sin preferencia
                            </option>

                            <?php
                            while($g = mysqli_fetch_assoc($groomers)){
                            ?>

                            <option value="<?php echo $g['id_usuario']; ?>">

                                <?php echo $g['nombre']; ?>

                            </option>

                            <?php } ?>

                        </select>

                    </div>

                    <!-- FECHA -->

                    <div class="input-group">

                        <label>
                            Fecha
                        </label>

                        <input
                        type="date"
                        name="fecha"
                        required>

                    </div>

                    <!-- HORA -->

                    <div class="input-group">

                        <label>
                            Franja Horaria
                        </label>

                        <select
                        name="hora"
                        required>

                            <option value="">
                                Seleccione horario
                            </option>

                            <option value="08:00">08:00 AM</option>
                            <option value="09:00">09:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="14:00">12:00 AM</option>
                            <option value="15:00">13:00 PM</option>
                            <option value="16:00">14:00 PM</option>
                            <option value="08:00">15:00 PM</option>
                            <option value="09:00">16:00 PM</option>
                            <option value="10:00">17:00 PM</option>
                            <option value="11:00">18:00 AM</option>
                            <option value="14:00">19:00 PM</option>
                            <option value="15:00">20:00 PM</option>

                        </select>

                    </div>

                </div>

                <button
                type="submit"
                class="btn">

                    <i class="fa-solid fa-calendar-plus"></i>

                    Solicitar Cita

                </button>

            </form>

        </div>

        <!-- TABLA -->

        <div class="table-card">

            <div class="table-header">

                <h2>
                    Historial de Citas
                </h2>

            </div>

            <table>

                <thead>

                    <tr>

                        <th>Mascota</th>
                        <th>Servicio</th>
                        <th>Fecha</th>
                        <th>Estado</th>
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

                    <td>

                        <span class="estado <?php echo strtolower($c['estado']); ?>">

                            <?php
                            echo $c['estado'];
                            ?>

                        </span>

                    </td>

                    <td>

                    <?php if(
                    $c['estado'] != 'CANCELADA'
                    &&
                    $c['estado'] != 'COMPLETADA'
                    ){ ?>

                    <a
                    href="cancelarcita.php?id=<?php echo $c['id_cita']; ?>"
                    class="cancel-btn">

                        Cancelar

                    </a>

                    <?php }else{ ?>

                    <span class="disabled-action">

                        No disponible

                    </span>

                    <?php } ?>

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