<?php
session_start();

if(
    !isset($_SESSION['id_usuario'])
){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "RECEPCIONISTA"){
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
Panel Recepcionista
</title>

<link
rel="stylesheet"
href="../recepcionista/r.css">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="sidebar">

    <div class="logo">

        <i class="fa-solid fa-headset"></i>

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
                Agendar Citas
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-users"></i>
                Clientes
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-phone"></i>
                Contactos
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
            Bienvenida,
            <?php echo $nombre; ?>
        </h1>

    </div>

    <div class="cards">

        <div class="card">

            <i class="fa-solid fa-calendar-plus"></i>

            <h2>15</h2>

            <p>Citas Registradas</p>

        </div>

        <div class="card">

            <i class="fa-solid fa-users"></i>

            <h2>28</h2>

            <p>Clientes Atendidos</p>

        </div>

        <div class="card">

            <i class="fa-solid fa-phone-volume"></i>

            <h2>10</h2>

            <p>Llamadas Pendientes</p>

        </div>

    </div>

    <div class="panel">

        <h2>
            Agenda del Día
        </h2>

        <table>

            <thead>

                <tr>

                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Mascota</th>
                    <th>Estado</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>10:00</td>
                    <td>Carlos Pérez</td>
                    <td>Rocky</td>
                    <td>
                        <span class="status success">
                            Confirmado
                        </span>
                    </td>

                </tr>

                <tr>

                    <td>12:30</td>
                    <td>María López</td>
                    <td>Luna</td>
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

<script src="../recepcionista/ra.js"></script>

</body>
</html>