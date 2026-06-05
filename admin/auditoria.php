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
href="../assets/css/auditoria.css?v=2">

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

            <li class="active">
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
                    Auditoría del Sistema
                </h1>

                <p>
                    Historial completo de actividades del sistema
                </p>

            </div>

        </div>

        <div class="panel">

            <div class="panel-header">

                <h2>
                    Registro de Actividades
                </h2>

            </div>

            <table>

                <thead>

                    <tr>

                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Acción</th>
                        <th>Fecha</th>
                        <th>IP</th>
                        <th>Navegador</th>

                    </tr>

                </thead>

                <tbody>

                <?php if(mysqli_num_rows($resultado) > 0): ?>

                    <?php while($row = mysqli_fetch_assoc($resultado)): ?>

                        <tr>

                            <td>

                                <?php
                                echo $row['nombre']." ".$row['apellido'];
                                ?>

                            </td>

                            <td>

                                <span class="role-badge">

                                    <?php echo $row['rol']; ?>

                                </span>

                            </td>

                            <td>

                                <span class="action-badge">

                                    <?php echo $row['accion']; ?>

                                </span>

                            </td>

                            <td>

                                <?php echo $row['fecha']; ?>

                            </td>

                            <td>

                                <?php echo $row['ip_usuario']; ?>

                            </td>

                            <td class="browser">

                                <?php echo $row['navegador']; ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                       <td colspan="6" class="empty-table">
                            No existen registros de auditoría.
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="../assets/js/auditoria.js"></script>

</body>
</html>