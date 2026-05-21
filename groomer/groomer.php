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
$nombre = $_SESSION['nombre'];

/* ========================= */
/* CITAS DEL DIA */
/* ========================= */

$sqlHoy = "
SELECT COUNT(*) AS total
FROM cita
WHERE id_groomer='$idGroomer'
AND DATE(fecha_inicio)=CURDATE()
";

$resultHoy = mysqli_query($conn,$sqlHoy);
$totalHoy = mysqli_fetch_assoc($resultHoy)['total'];

/* ========================= */
/* SERVICIOS FINALIZADOS */
/* ========================= */

$sqlFinalizados = "
SELECT COUNT(*) AS total
FROM cita
WHERE id_groomer='$idGroomer'
AND estado='FINALIZADA'
";

$resultFinalizados = mysqli_query($conn,$sqlFinalizados);
$totalFinalizados = mysqli_fetch_assoc($resultFinalizados)['total'];

/* ========================= */
/* EN PROCESO */
/* ========================= */

$sqlProceso = "
SELECT COUNT(*) AS total
FROM cita
WHERE id_groomer='$idGroomer'
AND estado='EN_PROGRESO'
";

$resultProceso = mysqli_query($conn,$sqlProceso);
$totalProceso = mysqli_fetch_assoc($resultProceso)['total'];

/* ========================= */
/* PROXIMAS CITAS */
/* ========================= */

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

WHERE cita.id_groomer='$idGroomer'

AND DATE(cita.fecha_inicio)=CURDATE()

ORDER BY cita.fecha_inicio ASC
";

$citas = mysqli_query($conn,$sqlCitas);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Dashboard Groomer
</title>

<link
rel="stylesheet"
href="../groomer/css/g.css?v=2">

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

            <i class="fa-solid fa-scissors"></i>

            <h2>SPA PAW PATROL</h2>

        </div>

        <ul class="menu">

            <li class="active">

                <a href="groomer.php">

                    <i class="fa-solid fa-house"></i>

                    <span>
                        Inicio
                    </span>

                </a>

            </li>

            <li>

                <a href="agenda.php">

                    <i class="fa-solid fa-calendar-days"></i>

                    <span>
                        Agenda
                    </span>

                </a>

            </li>

            <li>

                <a href="insumos.php">

                    <i class="fa-solid fa-box-open"></i>

                    <span>
                        Insumos
                    </span>

                </a>

            </li>

            <li>

                <a href="../auth/logout.php">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    <span>
                        Cerrar Sesión
                    </span>

                </a>

            </li>

        </ul>

    </div>

    <!-- MAIN -->

    <div class="main-content">

        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h1>

                    Bienvenido,
                    <?php echo $nombre; ?>

                </h1>

                <p>
                    Gestiona tus servicios y mascotas asignadas.
                </p>

            </div>

            <div class="profile">

                <i class="fa-solid fa-user"></i>

            </div>

        </div>

        <!-- CARDS -->

        <div class="cards">

            <div class="card">

                <div class="card-icon blue">

                    <i class="fa-solid fa-calendar-check"></i>

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

            <div class="card">

                <div class="card-icon green">

                    <i class="fa-solid fa-scissors"></i>

                </div>

                <div>

                    <h2>

                        <?php echo $totalFinalizados; ?>

                    </h2>

                    <p>
                        Servicios Finalizados
                    </p>

                </div>

            </div>

            <div class="card">

                <div class="card-icon orange">

                    <i class="fa-solid fa-spinner"></i>

                </div>

                <div>

                    <h2>

                        <?php echo $totalProceso; ?>

                    </h2>

                    <p>
                        En Proceso
                    </p>

                </div>

            </div>

        </div>

        <!-- TABLA -->

        <div class="panel">

            <div class="panel-header">

                <h2>
                    Agenda del Día
                </h2>

            </div>

            <table>

                <thead>

                    <tr>

                        <th>Hora</th>
                        <th>Mascota</th>
                        <th>Servicio</th>
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
                            echo date(
                                "H:i",
                                strtotime($c['fecha_inicio'])
                            );
                            ?>

                        </td>

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

                            <span class="status <?php echo strtolower($c['estado']); ?>">

                                <?php
                                echo $c['estado'];
                                ?>

                            </span>

                        </td>

                        <td>

                            <a
                            href="ficha.php?id=<?php echo $c['id_cita']; ?>"
                            class="btn-action">

                                <i class="fa-solid fa-eye"></i>

                                Ver Ficha

                            </a>

                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="../groomer/js/g.js"></script>

</body>
</html>