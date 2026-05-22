<?php

session_start();

/** @var mysqli $conn */

include("../config/database.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "CLIENTE"){
    header("Location: ../auth/login.php");
    exit();
}

$idCliente = $_SESSION['id_usuario'];
$nombre = $_SESSION['nombre'];

/* OBTENER MASCOTAS */
$sql = "

SELECT *
FROM mascota
WHERE id_cliente='$idCliente'
ORDER BY id_mascota DESC

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
Mis Mascotas
</title>

<link
rel="stylesheet"
href="../cliente/css/mascotas.css?v=1">

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

        <h3>SPA PAW PATROL</h3>

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

        <li class="active">

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

        <li>

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

<div class="main-content">

    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h1>
                Mis Mascotas
            </h1>

            <p>
                Gestiona todas tus mascotas registradas.
            </p>

        </div>

        <a
        href="regmascota.php"
        class="btn-add">

            <i class="fa-solid fa-plus"></i>

            Registrar Mascota

        </a>

    </div>

    <!-- GRID -->

    <div class="pets-grid">

    <?php

    if(mysqli_num_rows($resultado) > 0){

        while($mascota = mysqli_fetch_assoc($resultado)){

            $edad = "";

            if($mascota['fecha_nacimiento']){

                $fechaNacimiento =
                new DateTime($mascota['fecha_nacimiento']);

                $hoy =
                new DateTime();

                $edad =
                $hoy->diff($fechaNacimiento)->y . " años";
            }

    ?>

        <!-- CARD -->

        <div class="pet-card">

            <div class="pet-header">

                <div class="pet-icon">

                    <i class="fa-solid fa-dog"></i>

                </div>

                <div>

                    <h2>

                        <?php
                        echo $mascota['nombre'];
                        ?>

                    </h2>

                    <span>

                        <?php
                        echo $mascota['especie'];
                        ?>

                    </span>

                </div>

            </div>

            <div class="pet-info">

                <p>

                    <strong>Raza:</strong>

                    <?php
                    echo $mascota['raza'];
                    ?>

                </p>

                <p>

                    <strong>Tamaño:</strong>

                    <?php
                    echo $mascota['tamano'];
                    ?>

                </p>

                <p>

                    <strong>Temperamento:</strong>

                    <?php
                    echo $mascota['temperamento'];
                    ?>

                </p>

                <p>

                    <strong>Edad:</strong>

                    <?php
                    echo $edad;
                    ?>

                </p>

            </div>

            <div class="pet-actions">

                <a
                href="editar_mascota.php?id=<?php echo $mascota['id_mascota']; ?>"
                class="edit-btn">

                    <i class="fa-solid fa-pen"></i>

                    Editar

                </a>

                <a
                href="eliminar_mascota.php?id=<?php echo $mascota['id_mascota']; ?>"
                class="delete-btn"
                onclick="return confirm('¿Eliminar mascota?')">

                    <i class="fa-solid fa-trash"></i>

                    Eliminar

                </a>

            </div>

        </div>

    <?php

        }

    }else{

    ?>

        <div class="empty">

            <i class="fa-solid fa-dog"></i>

            <h2>
                No tienes mascotas registradas
            </h2>

            <p>
                Registra tu primera mascota.
            </p>

        </div>

    <?php } ?>

    </div>

</div>

<script src="../cliente/mascota.js"></script>

</body>
</html>
