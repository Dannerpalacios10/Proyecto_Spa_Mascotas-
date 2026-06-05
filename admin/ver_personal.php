<?php

include("../config/database.php");

/** @var mysqli $conn */

$sql = mysqli_query($conn,"
SELECT 
u.id_usuario,
u.nombre,
u.apellido,
u.email,
u.telefono,
u.estado_activo,
r.nombre AS rol

FROM usuario u
INNER JOIN rol r
ON u.id_rol = r.id_rol
");

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Ver Personal
</title>

<link
rel="stylesheet"
href="../assets/css/ver_personal.css?v=5">

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

            <li class="active">
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
                    Personal Registrado
                </h1>

                <p>
                    Lista dinámica del personal del sistema
                </p>

            </div>

        </div>

        <div class="panel">

            <div class="panel-header">

                <h2>
                    Lista de Usuarios
                </h2>

            </div>

            <table>

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acción</th>

                    </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($sql)): ?>

                    <tr>

                        <td>

                            <?php echo $row['id_usuario']; ?>

                        </td>

                        <td>

                            <?php
                            echo $row['nombre']." ".$row['apellido'];
                            ?>

                        </td>

                        <td>

                            <?php echo $row['email']; ?>

                        </td>

                        <td>

                            <?php echo $row['telefono']; ?>

                        </td>

                        <td>

                            <span class="badge role">

                                <?php echo $row['rol']; ?>

                            </span>

                        </td>

                        <td>

                            <?php if($row['estado_activo']==1): ?>

                                <span class="badge active">

                                    Activo

                                </span>

                            <?php else: ?>

                                <span class="badge inactive">

                                    Inactivo

                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <a
                            class="btn-toggle"
                            href="toogle.php?id=<?php echo $row['id_usuario']; ?>">

                                Cambiar Estado

                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="../assets/js/ver_personal.js"></script>

</body>
</html>