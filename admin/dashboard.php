<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "ADMIN") {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Dashboard Administrador</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../assets/css/dashboard.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="background-animation"></div>

<header class="navbar">

    <div class="logo">

        SPA PAW PATROL

    </div>

    <nav class="menu">

        <a
        class="menu-item active"
        href="dashboard.php">

        Dashboard

        </a>

        <a
        class="menu-item"
        href="crear_personal.php">

        Crear Personal

        </a>

        <a
        class="menu-item"
        href="ver_personal.php">

        Ver Personal

        </a>

        <a
        class="menu-item"
        href="auditoria.php">

        Auditoría

        </a>

    </nav>

    <div class="user-section">

        <span>

            <?php echo $_SESSION['nombre']; ?>

            (Admin)

        </span>

        <button
        onclick="window.location.href='../auth/logout.php'">

        Cerrar Sesión

        </button>

    </div>

</header>

<main class="main">

    <div class="dashboard-container fadeIn">

        <div class="welcome">

            <h1>
                Bienvenido Administrador
            </h1>

            <p>
                Panel de administración del sistema SPA PAW PATROL
            </p>

        </div>

        <div class="cards">

            <div class="card blue">

                <h2>
                    Crear Personal
                </h2>

                <p>
                    Registrar nuevos empleados
                </p>

                <a href="crear_personal.php">

                    Ir →

                </a>

            </div>

            <div class="card purple">

                <h2>
                    Ver Personal
                </h2>

                <p>
                    Gestionar usuarios registrados
                </p>

                <a href="ver_personal.php">

                    Ir →

                </a>

            </div>

            <div class="card green">

                <h2>
                    Auditoría
                </h2>

                <p>
                    Ver historial de acciones
                </p>

                <a href="auditoria.php">

                    Ir →

                </a>

            </div>

        </div>

    </div>

</main>

<script src="../assets/js/dashboard.js"></script>

</body>
</html>