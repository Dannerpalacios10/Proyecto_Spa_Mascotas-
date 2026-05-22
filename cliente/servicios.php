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

/* OBTENER SERVICIOS */

$sql = "
SELECT *
FROM servicio
ORDER BY nombre ASC
";

$resultado = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Servicios
</title>

<link
rel="stylesheet"
href="../cliente/css/servicios.css?v=1">

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

            <li class="active">

                <a href="servicios.php">

                    <i class="fa-solid fa-scissors"></i>

                    <span>
                        Servicios
                    </span>

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

    <div class="main">

        <div class="topbar">

            <div>

                <h1>
                    Servicios Disponibles
                </h1>

                <p>
                    Consulta todos los servicios disponibles para tus mascotas.
                </p>

            </div>

        </div>

        <!-- GRID SERVICIOS -->

        <div class="services-grid">

            <?php while($servicio = mysqli_fetch_assoc($resultado)){ ?>

                <div class="service-card">

                    <div class="service-icon">

                        <i class="fa-solid fa-bath"></i>

                    </div>

                    <h2>

                        <?php
                        echo $servicio['nombre'];
                        ?>

                    </h2>

                    <div class="service-info">

                        <p>

                            <strong>
                                Precio:
                            </strong>

                            Bs.

                            <?php
                            echo number_format(
                                $servicio['precio_base'],
                                2
                            );
                            ?>

                        </p>

                        <p>

                            <strong>
                                Duración:
                            </strong>

                            <?php
                            echo $servicio['duracion_base'];
                            ?>

                            min

                        </p>

                    </div>

                    <div class="service-footer">

                        <a
                        href="citas.php"
                        class="btn">

                            <i class="fa-solid fa-calendar-plus"></i>

                            Solicitar Cita

                        </a>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</div>

</body>
</html>