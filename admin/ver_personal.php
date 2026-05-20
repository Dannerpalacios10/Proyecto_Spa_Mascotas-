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
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Ver Personal</title>

<link rel="stylesheet" href="../assets/css/ver_personal.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="background-animation"></div>

<div class="container fadeIn">

    <div class="header">

        <h1>Personal Registrado</h1>

        <p>
            Lista dinámica del personal del sistema
        </p>

    </div>

    <div class="table-container">

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
                        echo $row['nombre']." ".
                        $row['apellido'];
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

<script src="../assets/js/ver_personal.js"></script>

</body>
</html>