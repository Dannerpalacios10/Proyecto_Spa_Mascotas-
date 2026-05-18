<?php
session_start();

if(
    !isset($_SESSION['id_usuario'])
){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "GROOMER"){
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
Panel Groomer
</title>

<link
rel="stylesheet"
href="../groomer/g.css">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="sidebar">

    <div class="logo">

        <i class="fa-solid fa-scissors"></i>

        <h2>SPA PET</h2>

    </div>

    <ul class="menu">

        <li class="active">
            <a href="#">
                <i class="fa-solid fa-house"></i>
                Inicio
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-calendar-days"></i>
                Mis Citas
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-dog"></i>
                Mascotas
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-bath"></i>
                Servicios
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-user"></i>
                Perfil
            </a>
        </li>

        <li>
            <a href="../auth/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Cerrar Sesión
            </a>
        </li>

    </ul>

</div>

<div class="main-content">

    <div class="topbar">

        <h1>
            Bienvenido Groomer,
            <?php echo $nombre; ?>
        </h1>

    </div>

    <div class="cards">

        <div class="card">

            <i class="fa-solid fa-calendar-check"></i>

            <h2>8</h2>

            <p>Citas Hoy</p>

        </div>

        <div class="card">

            <i class="fa-solid fa-scissors"></i>

            <h2>12</h2>

            <p>Servicios Realizados</p>

        </div>

        <div class="card">

            <i class="fa-solid fa-star"></i>

            <h2>4.9</h2>

            <p>Calificación</p>

        </div>

    </div>

    <div class="panel">

        <h2>
            Próximas Citas
        </h2>

        <table>

            <thead>

                <tr>

                    <th>Hora</th>
                    <th>Mascota</th>
                    <th>Servicio</th>
                    <th>Estado</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>09:00</td>
                    <td>Firulais</td>
                    <td>Baño Premium</td>
                    <td>
                        <span class="status pending">
                            Pendiente
                        </span>
                    </td>

                </tr>

                <tr>

                    <td>11:00</td>
                    <td>Michi</td>
                    <td>Corte Completo</td>
                    <td>
                        <span class="status success">
                            Confirmado
                        </span>
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

<script src="../groomer/g.js"></script>

</body>
</html>