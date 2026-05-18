<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "CLIENTE"){
    header("Location: ../auth/login.php");
    exit();
}

$nombre = $_SESSION['nombre'];
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
href="../cliente/c.css">

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

            <a href="#">

                <i class="fa-solid fa-house"></i>

                <span>
                    Inicio
                </span>

            </a>

        </li>

        <li>

            <a href="#">

                <i class="fa-solid fa-dog"></i>

                <span>
                    Mis Mascotas
                </span>

            </a>

        </li>

        <li>

            <a href="#">

                <i class="fa-solid fa-calendar-days"></i>

                <span>
                    Mis Citas
                </span>

            </a>

        </li>

        <li>

            <a href="#">

                <i class="fa-solid fa-scissors"></i>

                <span>
                    Servicios
                </span>

            </a>

        </li>

        <li>

            <a href="#">

                <i class="fa-solid fa-user"></i>

                <span>
                    Perfil
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

            <i class="fa-solid fa-user"></i>

        </div>

    </div>

    <!-- CARDS -->

    <div class="cards">

        <div class="card">

            <div class="card-icon blue">

                <i class="fa-solid fa-dog"></i>

            </div>

            <div>

                <h2>3</h2>

                <p>Mascotas Registradas</p>

            </div>

        </div>

        <div class="card">

            <div class="card-icon green">

                <i class="fa-solid fa-calendar-check"></i>

            </div>

            <div>

                <h2>5</h2>

                <p>Citas Pendientes</p>

            </div>

        </div>

        <div class="card">

            <div class="card-icon orange">

                <i class="fa-solid fa-bath"></i>

            </div>

            <div>

                <h2>2</h2>

                <p>Servicios Activos</p>

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
                    <th>Servicio</th>
                    <th>Estado</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>10/05/2026</td>

                    <td>Baño Completo</td>

                    <td>

                        <span class="status success">

                            Finalizado

                        </span>

                    </td>

                </tr>

                <tr>

                    <td>11/05/2026</td>

                    <td>Corte de Pelo</td>

                    <td>

                        <span class="status pending">

                            Pendiente

                        </span>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

<script src="../cliente/c.js"></script>

</body>
</html>