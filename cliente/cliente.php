<?php

session_start();

include("../config/database.php");

/** @var mysqli $conn */

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

/* TOTAL MASCOTAS */

$sqlMascotas = "

SELECT COUNT(*) AS total
FROM mascota
WHERE id_cliente='$idCliente'

";

$resultMascotas = mysqli_query($conn,$sqlMascotas);
$totalMascotas = mysqli_fetch_assoc($resultMascotas)['total'];

/* TOTAL CITAS PENDIENTES */

$sqlCitas = "

SELECT COUNT(*) AS total
FROM cita

INNER JOIN mascota
ON cita.id_mascota = mascota.id_mascota

WHERE mascota.id_cliente='$idCliente'
AND cita.estado IN(
'EN_REVISION',
'AGENDADA',
'CONFIRMADA'
)

";

$resultCitas = mysqli_query($conn,$sqlCitas);
$totalCitas = mysqli_fetch_assoc($resultCitas)['total'];

/* TOTAL SERVICIOS ACTIVOS */

$sqlServicios = "

SELECT COUNT(*) AS total
FROM servicio
WHERE estado_activo=1

";

$resultServicios = mysqli_query($conn,$sqlServicios);
$totalServicios = mysqli_fetch_assoc($resultServicios)['total'];

/* ÚLTIMAS ACTIVIDADES */

$sqlHistorial = "

SELECT

cita.fecha_inicio,
cita.estado,

servicio.nombre AS servicio,
mascota.nombre AS mascota

FROM cita

INNER JOIN mascota
ON cita.id_mascota = mascota.id_mascota

INNER JOIN servicio
ON cita.id_servicio = servicio.id_servicio

WHERE mascota.id_cliente='$idCliente'

ORDER BY cita.fecha_inicio DESC

LIMIT 5

";

$resultHistorial = mysqli_query($conn,$sqlHistorial);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Dashboard Cliente
</title>

<link
rel="stylesheet"
href="../cliente/css/c.css?v=2">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <div class="logo">

        <i class="fa-solid fa-paw"></i>

        <h2>SPA PAW PATROL</h2>

    </div>

    <ul class="menu">

        <li class="active">

            <a href="cliente.php">

                <i class="fa-solid fa-house"></i>

                <span>
                    Inicio
                </span>

            </a>

        </li>

        <li>

            <a href="mascotas.php">

                <i class="fa-solid fa-dog"></i>

                <span>
                    Mis Mascotas
                </span>

            </a>

        </li>

        <li>

            <a href="citas.php">

                <i class="fa-solid fa-calendar-days"></i>

                <span>
                    Mis Citas
                </span>

            </a>

        </li>

        <li>

            <a href="servicios.php">

                <i class="fa-solid fa-scissors"></i>

                <span>
                    Servicios
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

                Gestiona tus mascotas y citas fácilmente.

            </p>

        </div>

        <div class="profile">

            <a href="perfil.php" class="profile-link">

                <i class="fa-solid fa-user-pen"></i>

                <span>Editar Perfil</span>

            </a>

        </div>

    </div>

    <!-- CARDS -->

    <div class="cards">

        <!-- MASCOTAS -->

        <div class="card">

            <div class="card-icon blue">

                <i class="fa-solid fa-dog"></i>

            </div>

            <div>

                <h2>

                    <?php echo $totalMascotas; ?>

                </h2>

                <p>

                    Mascotas Registradas

                </p>

            </div>

        </div>

        <!-- CITAS -->

        <div class="card">

            <div class="card-icon green">

                <i class="fa-solid fa-calendar-check"></i>

            </div>

            <div>

                <h2>

                    <?php echo $totalCitas; ?>

                </h2>

                <p>

                    Citas Pendientes

                </p>

            </div>

        </div>

        <!-- SERVICIOS -->

        <div class="card">

            <div class="card-icon orange">

                <i class="fa-solid fa-bath"></i>

            </div>

            <div>

                <h2>

                    <?php echo $totalServicios; ?>

                </h2>

                <p>

                    Servicios Disponibles

                </p>

            </div>

        </div>

    </div>

    <!-- TABLA -->

    <div class="panel">

        <div class="panel-header">

            <h2>

                Últimas Actividades

            </h2>

        </div>

        <table>

            <thead>

                <tr>

                    <th>Fecha</th>
                    <th>Mascota</th>
                    <th>Servicio</th>
                    <th>Estado</th>

                </tr>

            </thead>

            <tbody>

            <?php

            if(mysqli_num_rows($resultHistorial) > 0){

                while($fila = mysqli_fetch_assoc($resultHistorial)){

                    $estado = $fila['estado'];

                    $clase = "pending";

                    if($estado == "COMPLETADA"){
                        $clase = "success";
                    }

                    if($estado == "CANCELADA"){
                        $clase = "cancel";
                    }

            ?>

                <tr>

                    <td>

                        <?php
                        echo date(
                            "d/m/Y H:i",
                            strtotime($fila['fecha_inicio'])
                        );
                        ?>

                    </td>

                    <td>

                        <?php
                        echo $fila['mascota'];
                        ?>

                    </td>

                    <td>

                        <?php
                        echo $fila['servicio'];
                        ?>

                    </td>

                    <td>

                        <span class="status <?php echo $clase; ?>">

                            <?php
                            echo $estado;
                            ?>

                        </span>

                    </td>

                </tr>

            <?php

                }

            }else{

            ?>

                <tr>

                    <td colspan="4">

                        No existen actividades recientes.

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<script src="../cliente/js/c.js"></script>

</body>
</html>
```
