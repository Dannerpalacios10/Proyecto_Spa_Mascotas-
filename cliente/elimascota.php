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

if(!isset($_GET['id'])){
    header("Location: mascotas.php");
    exit();
}

$idMascota = intval($_GET['id']);

/* VERIFICAR MASCOTA */

$sqlMascota = "

SELECT *
FROM mascota
WHERE id_mascota='$idMascota'
AND id_cliente='$idCliente'

";

$resultado = mysqli_query($conn,$sqlMascota);

if(mysqli_num_rows($resultado) == 0){

    header("Location: mascotas.php");
    exit();
}

$mascota = mysqli_fetch_assoc($resultado);

/* ELIMINAR */

if(isset($_POST['eliminar'])){

    /* ELIMINAR PAGOS */

    $sqlPagos = "

    DELETE pago
    FROM pago

    INNER JOIN cita
    ON pago.id_cita = cita.id_cita

    WHERE cita.id_mascota='$idMascota'

    ";

    mysqli_query($conn,$sqlPagos);

    /* ELIMINAR CITAS */

    $sqlCitas = "

    DELETE FROM cita
    WHERE id_mascota='$idMascota'

    ";

    mysqli_query($conn,$sqlCitas);

    /* ELIMINAR MASCOTA */

    $sqlEliminar = "

    DELETE FROM mascota
    WHERE id_mascota='$idMascota'

    ";

    mysqli_query($conn,$sqlEliminar);

    $_SESSION['success'] =
    "Mascota eliminada correctamente.";

    header("Location: mascotas.php");
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
Eliminar Mascota
</title>

<link
rel="stylesheet"
href="../cliente/css/elimascota.css?v=2">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="logo">

            <h3>SPA PAW PATROL</h3>

        </div>

        <ul class="menu">

            <li>

                <a href="cliente.php">

                    <i class="fa-solid fa-house"></i>

                    <span>Inicio</span>

                </a>

            </li>

            <li class="active">

                <a href="mascotas.php">

                    <i class="fa-solid fa-dog"></i>

                    <span>Mis Mascotas</span>

                </a>

            </li>

        </ul>

        <div class="logout">

            <a href="../auth/logout.php">

                <i class="fa-solid fa-right-from-bracket"></i>

                <span>Cerrar Sesión</span>

            </a>

        </div>

    </div>

    <!-- MAIN -->

    <div class="main-content">

        <div class="delete-wrapper">

            <div class="delete-card">

                <div class="delete-icon">

                    <i class="fa-solid fa-trash"></i>

                </div>

                <h1>
                    Eliminar Mascota
                </h1>

                <p>

                    Estás a punto de eliminar a

                    <strong>
                        <?php echo $mascota['nombre']; ?>
                    </strong>

                    del sistema.

                    <br><br>

                    También se eliminarán sus citas y pagos relacionados.

                </p>

                <form method="POST">

                    <div class="actions">

                        <a
                        href="mascotas.php"
                        class="btn cancel">

                            Cancelar

                        </a>

                        <button
                        type="submit"
                        name="eliminar"
                        class="btn delete">

                            <i class="fa-solid fa-trash"></i>

                            Eliminar

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>