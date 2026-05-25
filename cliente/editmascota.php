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

/* OBTENER MASCOTA */

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

/* ACTUALIZAR */

if(isset($_POST['guardar'])){

    $nombre =
    mysqli_real_escape_string(
        $conn,
        $_POST['nombre']
    );

    $especie =
    mysqli_real_escape_string(
        $conn,
        $_POST['especie']
    );

    $raza =
    mysqli_real_escape_string(
        $conn,
        $_POST['raza']
    );

    $tamano =
    mysqli_real_escape_string(
        $conn,
        $_POST['tamano']
    );

    $temperamento =
    mysqli_real_escape_string(
        $conn,
        $_POST['temperamento']
    );

    $fechaNacimiento =
    $_POST['fecha_nacimiento'];

    $sqlUpdate = "

    UPDATE mascota

    SET

    nombre='$nombre',
    especie='$especie',
    raza='$raza',
    tamano='$tamano',
    temperamento='$temperamento',
    fecha_nacimiento='$fechaNacimiento'

    WHERE id_mascota='$idMascota'

    ";

    mysqli_query($conn,$sqlUpdate);

    $_SESSION['success'] =
    "Mascota actualizada correctamente.";

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
Editar Mascota
</title>

<link
rel="stylesheet"
href="../cliente/css/editmascota.css?v=2">

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

            <li>

                <a href="citas.php">

                    <i class="fa-solid fa-calendar-days"></i>

                    <span>Mis Citas</span>

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

        <div class="topbar">

            <div>

                <h1>
                    Editar Mascota
                </h1>

                <p>
                    Actualiza la información de tu mascota.
                </p>

            </div>

        </div>

        <!-- FORM -->

        <div class="form-card">

            <form method="POST">

                <div class="form-grid">

                    <div class="input-group">

                        <label>
                            Nombre
                        </label>

                        <input
                        type="text"
                        name="nombre"
                        value="<?php echo $mascota['nombre']; ?>"
                        required>

                    </div>

                    <div class="input-group">

                        <label>
                            Especie
                        </label>

                        <select
                        name="especie"
                        required>

                            <option
                            value="Perro"
                            <?php
                            if($mascota['especie']=="Perro"){
                                echo "selected";
                            }
                            ?>>

                                Perro

                            </option>

                            <option
                            value="Gato"
                            <?php
                            if($mascota['especie']=="Gato"){
                                echo "selected";
                            }
                            ?>>

                                Gato

                            </option>

                        </select>

                    </div>

                    <div class="input-group">

                        <label>
                            Raza
                        </label>

                        <input
                        type="text"
                        name="raza"
                        value="<?php echo $mascota['raza']; ?>"
                        required>

                    </div>

                    <div class="input-group">

                        <label>
                            Tamaño
                        </label>

                        <select
                        name="tamano"
                        required>

                            <option
                            value="Pequeño"
                            <?php
                            if($mascota['tamano']=="Pequeño"){
                                echo "selected";
                            }
                            ?>>

                                Pequeño

                            </option>

                            <option
                            value="Mediano"
                            <?php
                            if($mascota['tamano']=="Mediano"){
                                echo "selected";
                            }
                            ?>>

                                Mediano

                            </option>

                            <option
                            value="Grande"
                            <?php
                            if($mascota['tamano']=="Grande"){
                                echo "selected";
                            }
                            ?>>

                                Grande

                            </option>

                        </select>

                    </div>

                    <div class="input-group">

                        <label>
                            Fecha de nacimiento
                        </label>

                        <input
                        type="date"
                        name="fecha_nacimiento"
                        value="<?php echo $mascota['fecha_nacimiento']; ?>">

                    </div>

                    <div class="form-group">

                    <label>
                        Temperamento
                    </label>

                    <select
                    name="temperamento"
                    required>

                        <option value="">
                            Temperamento
                        </option>

                        <option value="Tranquilo"
                        <?php if($mascota['temperamento']=="Tranquilo") echo "selected"; ?>>

                            Tranquilo

                        </option>

                        <option value="Nervioso"
                        <?php if($mascota['temperamento']=="Nervioso") echo "selected"; ?>>

                            Nervioso

                        </option>

                        <option value="Agresivo"
                        <?php if($mascota['temperamento']=="Agresivo") echo "selected"; ?>>

                            Agresivo

                        </option>

                        <option value="Agresivo"
                        <?php if($mascota['temperamento']=="Inquieto") echo "selected"; ?>>

                            Inquieto

                        </option>

                    </select>

                </div>

                </div>

                <div class="actions">

                    <a
                    href="mascotas.php"
                    class="btn cancel">

                        Cancelar

                    </a>

                    <button
                    type="submit"
                    name="guardar"
                    class="btn save">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Guardar Cambios

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>