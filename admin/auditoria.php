<?php

session_start();

include("../config/database.php");

/** @var mysqli $conn */


/* CONSULTA AUDITORIA */

$sql = "

SELECT

a.accion,
a.fecha,
a.ip_usuario,
a.navegador,

u.nombre,
u.apellido,

r.nombre AS rol

FROM auditoria a

INNER JOIN usuario u
ON a.id_usuario = u.id_usuario

INNER JOIN rol r
ON u.id_rol = r.id_rol

ORDER BY a.fecha DESC

";

$resultado =
mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Auditoría
</title>

<link
rel="stylesheet"
href="../assets/css/auditoria.css">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

</head>

<body>

<div class="background-animation"></div>

<!-- NAVBAR -->

<header class="navbar">

    <div class="logo">

        SPA PET SYSTEM

    </div>

    <nav class="menu">

        <a
        class="menu-item"
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
        class="menu-item active"
        href="auditoria.php">

            Auditoría

        </a>

    </nav>

    <div class="user-section">

        <span>

            <?php
            echo $_SESSION['nombre'];
            ?>

            (Admin)

        </span>

        <button
        onclick="window.location.href='../auth/logout.php'">

            Cerrar Sesión

        </button>

    </div>

</header>

<!-- MAIN -->

<main class="main">

    <div class="container fadeIn">

        <div class="header-page">

            <h1>
                Auditoría del Sistema
            </h1>

            <p>

                Historial completo
                de actividades del sistema

            </p>

        </div>

        <!-- TABLA -->

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            Usuario
                        </th>

                        <th>
                            Rol
                        </th>

                        <th>
                            Acción
                        </th>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Dirección IP
                        </th>

                        <th>
                            Navegador
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php if(mysqli_num_rows($resultado) > 0): ?>

                    <?php while($row = mysqli_fetch_assoc($resultado)): ?>

                        <tr>

                            <!-- USUARIO -->

                            <td>

                                <?php

                                echo
                                $row['nombre']." ".
                                $row['apellido'];

                                ?>

                            </td>

                            <!-- ROL -->

                            <td>

                                <span class="role-badge">

                                    <?php
                                    echo $row['rol'];
                                    ?>

                                </span>

                            </td>

                            <!-- ACCION -->

                            <td>

                                <span class="action-badge">

                                    <?php
                                    echo $row['accion'];
                                    ?>

                                </span>

                            </td>

                            <!-- FECHA -->

                            <td>

                                <?php
                                echo $row['fecha'];
                                ?>

                            </td>

                            <!-- IP -->

                            <td>

                                <?php
                                echo $row['ip_usuario'];
                                ?>

                            </td>

                            <!-- NAVEGADOR -->

                            <td class="browser">

                                <?php
                                echo $row['navegador'];
                                ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="6">

                            No existen registros.

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</main>

<script src="../assets/js/auditoria.js"></script>

</body>
</html>