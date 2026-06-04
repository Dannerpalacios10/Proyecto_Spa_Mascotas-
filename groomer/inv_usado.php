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


/* FICHAS FINALIZADAS */

$sqlFichas = "
SELECT
fg.id_ficha,
m.nombre AS mascota_nombre,
s.nombre AS servicio_nombre

FROM ficha_grooming fg

INNER JOIN cita c
ON fg.id_cita = c.id_cita

INNER JOIN mascota m
ON c.id_mascota = m.id_mascota

INNER JOIN servicio s
ON c.id_servicio = s.id_servicio

WHERE c.id_groomer='$idGroomer'
AND fg.estado_final='FINALIZADO'

ORDER BY fg.id_ficha DESC
";

$fichas = mysqli_query($conn,$sqlFichas);

/* HISTORIAL */

$sqlHistorial = "
SELECT

ui.id_uso,
ui.cantidad_usada,
ui.fecha_registro,

p.nombre AS producto_nombre,

fg.id_ficha,

m.nombre AS mascota_nombre,

s.nombre AS servicio_nombre

FROM uso_inventario ui

INNER JOIN producto p
ON ui.id_producto = p.id_producto

INNER JOIN ficha_grooming fg
ON ui.id_ficha = fg.id_ficha

INNER JOIN cita c
ON fg.id_cita = c.id_cita

INNER JOIN mascota m
ON c.id_mascota = m.id_mascota

INNER JOIN servicio s
ON c.id_servicio = s.id_servicio

WHERE c.id_groomer='$idGroomer'

ORDER BY ui.fecha_registro DESC
";

$historial = mysqli_query($conn,$sqlHistorial);

if(!$historial){
    die(mysqli_error($conn));
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
Inventario Usado
</title>

<link
rel="stylesheet"
href="../groomer/css/inv_usado.css?v=3">

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

            <li>

                <a href="groomer.php">

                    <i class="fa-solid fa-house"></i>

                    <span>Inicio</span>

                </a>

            </li>

            <li>

                <a href="agenda.php">

                    <i class="fa-solid fa-calendar-days"></i>

                    <span>Agenda</span>

                </a>

            </li>

            <li class="active">

                <a href="inv_usado.php">

                    <i class="fa-solid fa-box-open"></i>

                    <span>Inventario</span>

                </a>

            </li>

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
                    Historial de Insumos
                </h1>

                <p>
                    CONSULTA LOS INSUMOS UTILIZADOS EN LOS SERVICIOS REALIZADOS.
                </p>

            </div>

            <div class="profile">

                <a
                href="../groomer/editgroomer.php"
                class="profile-link">

                    <i class="fa-solid fa-user-pen"></i>

                    <span>Editar Perfil</span>

                </a>

            </div>

        </div>

        <!-- ALERTAS -->

        <?php if(isset($success)){ ?>

            <div class="alert success">

                <?php echo $success; ?>

            </div>

        <?php } ?>

        <?php if(isset($error)){ ?>

            <div class="alert error">

                <?php echo $error; ?>

            </div>

        <?php } ?>

        <!-- HISTORIAL -->
         <div class="table-responsive">

            <table>

                <thead>

                    <tr>

                        <th>Ficha</th>
                        <th>Mascota</th>
                        <th>Servicio</th>
                        <th>Insumo</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    while($h = mysqli_fetch_assoc($historial)){
                    ?>

                    <tr>

                        <td>
                            #<?php echo $h['id_ficha']; ?>
                        </td>

                        <td>
                            <?php echo $h['mascota_nombre']; ?>
                        </td>

                        <td>
                            <?php echo $h['servicio_nombre']; ?>
                        </td>

                        <td>
                            <?php echo $h['producto_nombre']; ?>
                        </td>

                        <td>
                            <?php echo $h['cantidad_usada']; ?>
                        </td>

                        <td>
                            <?php echo $h['fecha_registro']; ?>
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