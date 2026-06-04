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

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Dashboard Administrador
</title>

<link
rel="stylesheet"
href="../assets/css/dashboard.css?v=3">

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
                <a href="dashboard.php">
                    <i class="fa-solid fa-house"></i>
                    <span>Inicio</span>
                </a>
            </li>

            <li>
                <a href="crear_personal.php">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Registrar Personal</span>
                </a>
            </li>

            <li>
                <a href="ver_personal.php">
                    <i class="fa-solid fa-users"></i>
                    <span>Ver Personal</span>
                </a>
            </li>

            <li>
                <a href="auditoria.php">
                    <i class="fa-solid fa-clipboard-list"></i>
                    <span>Auditoría</span>
                </a>
            </li>

        </ul>

        <div class="logout">
            <a href="../auth/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Cerrar Sesión
            </a>
        </div>

    </div>

    <!-- MAIN -->

    <div class="main-content">

        <div class="topbar">

            <div>

                <h1>
                    Bienvenido Administrador
                </h1>

                <p>
                    Panel de administración del sistema SPA PAW PATROL
                </p>

            </div>

            <div class="admin-user">

                <i class="fa-solid fa-user-shield"></i>

                <?php echo $_SESSION['nombre']; ?>

            </div>

        </div>

        <div class="cards">

            <div class="card">

                <div class="card-icon blue">

                    <i class="fa-solid fa-user-plus"></i>

                </div>

                <div>

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

            </div>

            <div class="card">

                <div class="card-icon purple">

                    <i class="fa-solid fa-users"></i>

                </div>

                <div>

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

            </div>

            <div class="card">

                <div class="card-icon green">

                    <i class="fa-solid fa-clipboard-list"></i>

                </div>

                <div>

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

    </div>

</div>

</body>
</html>