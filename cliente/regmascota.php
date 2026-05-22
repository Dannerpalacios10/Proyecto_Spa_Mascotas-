<?php

session_start();

/** @var mysqli $conn */

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "CLIENTE"){
    header("Location: ../auth/login.php");
    exit();
}

include("../config/database.php");

$idCliente = $_SESSION['id_usuario'];

$mensaje = "";
$tipo = "";

/* REGISTRAR MASCOTA */

if($_SERVER['REQUEST_METHOD'] == "POST"){

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

    $peso =
    mysqli_real_escape_string(
        $conn,
        $_POST['peso']
    );

    $fechaNacimiento =
    mysqli_real_escape_string(
        $conn,
        $_POST['fecha_nacimiento']
    );

    $temperamento =
    mysqli_real_escape_string(
        $conn,
        $_POST['temperamento']
    );

    $alergias =
    mysqli_real_escape_string(
        $conn,
        $_POST['alergias']
    );

    $restricciones =
    mysqli_real_escape_string(
        $conn,
        $_POST['restricciones']
    );

    $carnetVacunas = "";

    /* SUBIR CARNET */

    if(isset($_FILES['carnet_vacunas']) &&
       $_FILES['carnet_vacunas']['error'] == 0){

        $carpeta =
        "../uploads/carnets/";

        if(!file_exists($carpeta)){
            mkdir($carpeta,0777,true);
        }

        $nombreArchivo =
        time() .
        "_" .
        basename($_FILES['carnet_vacunas']['name']);

        $ruta =
        $carpeta .
        $nombreArchivo;

        move_uploaded_file(
            $_FILES['carnet_vacunas']['tmp_name'],
            $ruta
        );

        $carnetVacunas =
        $ruta;
    }

    /* INSERT */

    $sql = "

    INSERT INTO mascota
    (

    nombre,
    especie,
    raza,
    tamano,
    peso,
    temperamento,
    fecha_nacimiento,
    restricciones,
    alergias,
    carnet_vacunas,
    id_cliente

    )

    VALUES
    (

    '$nombre',
    '$especie',
    '$raza',
    '$tamano',
    '$peso',
    '$temperamento',
    '$fechaNacimiento',
    '$restricciones',
    '$alergias',
    '$carnetVacunas',
    '$idCliente'

    )

    ";

    if(mysqli_query($conn,$sql)){

        $mensaje =
        "Mascota registrada correctamente.";

        $tipo =
        "success";

    }else{

        $mensaje =
        "Error al registrar mascota.";

        $tipo =
        "error";
    }
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
Registrar Mascota
</title>

<link
rel="stylesheet"
href="../cliente/css/regmascota.css?v=1">

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

                <a href="cliente.php">

                    <i class="fa-solid fa-house"></i>

                    Inicio

                </a>

            </li>

            <li class="active">

                <a href="mascotas.php">

                    <i class="fa-solid fa-dog"></i>

                    Mis Mascotas

                </a>

            </li>

            <li>

                <a href="citas.php">

                    <i class="fa-solid fa-calendar-days"></i>

                    Mis Citas

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

    <div class="main">

        <div class="topbar">

            <h1>

                Registrar Mascota

            </h1>

            <a
            href="mascotas.php"
            class="back-btn">

                <i class="fa-solid fa-arrow-left"></i>

                Volver

            </a>

        </div>

        <?php if($mensaje != ""){ ?>

            <div class="alert <?php echo $tipo; ?>">

                <?php echo $mensaje; ?>

            </div>

        <?php } ?>

        <!-- FORM -->

        <div class="form-card">

            <form
            method="POST"
            enctype="multipart/form-data">

                <div class="grid">

                    <!-- NOMBRE -->

                    <div class="input-group">

                        <label>

                            Nombre de la mascota

                        </label>

                        <input
                        type="text"
                        name="nombre"
                        required>

                    </div>

                    <!-- ESPECIE -->

                    <div class="input-group">

                        <label>

                            Especie

                        </label>

                        <select
                        name="especie"
                        required>

                            <option value="">
                                Seleccione
                            </option>

                            <option value="Perro">
                                Perro
                            </option>

                            <option value="Gato">
                                Gato
                            </option>

                            <option value="Otro">
                                Otro
                            </option>

                        </select>

                    </div>

                    <!-- RAZA -->

                    <div class="input-group">

                        <label>

                            Raza

                        </label>

                        <input
                        type="text"
                        name="raza"
                        required>

                    </div>

                    <!-- TAMAÑO -->

                    <div class="input-group">

                        <label>

                            Tamaño

                        </label>

                        <select
                        name="tamano"
                        required>

                            <option value="">
                                Seleccione
                            </option>

                            <option value="Pequeño">
                                Pequeño
                            </option>

                            <option value="Mediano">
                                Mediano
                            </option>

                            <option value="Grande">
                                Grande
                            </option>

                            <option value="Gigante">
                                Gigante
                            </option>

                        </select>

                    </div>

                    <!-- PESO -->

                    <div class="input-group">

                        <label>

                            Peso (Kg)

                        </label>

                        <input
                        type="number"
                        step="0.01"
                        name="peso"
                        required>

                    </div>

                    <!-- FECHA -->

                    <div class="input-group">

                        <label>

                            Fecha de nacimiento

                        </label>

                        <input
                        type="date"
                        name="fecha_nacimiento"
                        required>

                    </div>

                    <!-- TEMPERAMENTO -->

                    <div class="input-group">

                        <label>

                            Temperamento

                        </label>

                        <select
                        name="temperamento"
                        required>

                            <option value="">
                                Seleccione
                            </option>

                            <option value="Tranquilo">
                                Tranquilo
                            </option>

                            <option value="Nervioso">
                                Nervioso
                            </option>

                            <option value="Agresivo">
                                Agresivo
                            </option>

                            <option value="Inquieto">
                                Inquieto
                            </option>

                        </select>

                    </div>

                    <!-- CARNET -->

                    <div class="input-group">

                        <label>

                            Carnet de vacunas

                        </label>

                        <input
                        type="file"
                        name="carnet_vacunas"
                        accept=".pdf,.jpg,.jpeg,.png">

                    </div>

                </div>

                <!-- ALERGIAS -->

                <div class="input-group">

                    <label>

                        Alergias

                    </label>

                    <textarea
                    name="alergias"
                    rows="4"></textarea>

                </div>

                <!-- RESTRICCIONES -->

                <div class="input-group">

                    <label>

                        Restricciones médicas

                    </label>

                    <textarea
                    name="restricciones"
                    rows="4"></textarea>

                </div>

                <!-- BOTON -->

                <button
                type="submit"
                class="btn">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Registrar Mascota

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>