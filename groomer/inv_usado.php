<?php

session_start();

/** @var mysqli $conn */

include("../config/database.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "GROOMER"){
    header("Location: ../auth/login.php");
    exit();
}

$idGroomer = $_SESSION['id_usuario'];
$nombre = $_SESSION['nombre'];

/* REGISTRAR INSUMO */

if(isset($_POST['registrar'])){

    $id_ficha = $_POST['id_ficha'];
    $id_insumo = $_POST['id_insumo'];

    $cantidad_usada = $_POST['cantidad_usada'];
    $cantidad_devuelta = $_POST['cantidad_devuelta'];
    $cantidad_desperdiciada = $_POST['cantidad_desperdiciada'];

    $sqlInsert = "
    INSERT INTO uso_inventario
    (
        id_ficha,
        id_insumo,
        cantidad_usada,
        cantidad_devuelta,
        cantidad_desperdiciada
    )
    VALUES
    (
        '$id_ficha',
        '$id_insumo',
        '$cantidad_usada',
        '$cantidad_devuelta',
        '$cantidad_desperdiciada'
    )
    ";

    if(mysqli_query($conn,$sqlInsert)){

        $stockDescontar =
        $cantidad_usada - $cantidad_devuelta;

        $sqlStock = "
        UPDATE inventario
        SET stock = stock - '$stockDescontar'
        WHERE id_insumo='$id_insumo'
        ";

        mysqli_query($conn,$sqlStock);

        $sqlFicha = "
        UPDATE ficha_grooming
        SET consumido_inventario='1'
        WHERE id_ficha='$id_ficha'
        ";

        mysqli_query($conn,$sqlFicha);

        $success =
        "Insumo registrado correctamente";

    }else{

        $error =
        "Error al registrar insumo";

    }

}

/* FICHAS FINALIZADAS */

$sqlFichas = "
SELECT
fg.id_ficha,
m.nombre AS mascota_nombre,
s.nombre AS servicio_nombre

FROM ficha_grooming fg

INNER JOIN cita c
ON fg.id_cita = c.id_cita

INNER JOIN mascota m
ON c.id_mascota = m.id_mascota

INNER JOIN servicio s
ON c.id_servicio = s.id_servicio

WHERE c.id_groomer='$idGroomer'
AND fg.estado_final='FINALIZADO'

ORDER BY fg.id_ficha DESC
";

$fichas = mysqli_query($conn,$sqlFichas);

/* INVENTARIO */

$sqlInventario = "
SELECT *
FROM inventario
ORDER BY nombre ASC
";

$inventario = mysqli_query($conn,$sqlInventario);

/* HISTORIAL */

$sqlHistorial = "
SELECT
ui.*,
i.nombre AS insumo_nombre

FROM uso_inventario ui

INNER JOIN inventario i
ON ui.id_insumo = i.id_insumo

ORDER BY ui.fecha_registro DESC
";

$historial = mysqli_query($conn,$sqlHistorial);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Inventario Usado
</title>

<link
rel="stylesheet"
href="../groomer/css/inv_usado.css?v=2">

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

                <a href="groomer.php">

                    <i class="fa-solid fa-house"></i>

                    <span>Inicio</span>

                </a>

            </li>

            <li>

                <a href="agenda.php">

                    <i class="fa-solid fa-calendar-days"></i>

                    <span>Agenda</span>

                </a>

            </li>

            <li class="active">

                <a href="inv_usado.php">

                    <i class="fa-solid fa-box-open"></i>

                    <span>Inventario</span>

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

                    Inventario Usado

                </h1>

                <p>

                    REGISTRA LOS INSUMOS UTILIZADOS EN EL SERVICIO.

                </p>

            </div>

            <div class="profile">

                <a
                href="../groomer/editgroomer.php"
                class="profile-link">

                    <i class="fa-solid fa-user-pen"></i>

                    <span>Editar Perfil</span>

                </a>

            </div>

        </div>

        <!-- ALERTAS -->

        <?php if(isset($success)){ ?>

            <div class="alert success">

                <?php echo $success; ?>

            </div>

        <?php } ?>

        <?php if(isset($error)){ ?>

            <div class="alert error">

                <?php echo $error; ?>

            </div>

        <?php } ?>

        <!-- FORMULARIO -->

        <div class="panel">

            <div class="panel-header">

                <h2>

                    Registrar Insumo

                </h2>

            </div>

            <form method="POST" class="form-grid">

                <div class="form-group">

                    <label>
                        Ficha Grooming
                    </label>

                    <select
                    name="id_ficha"
                    required>

                        <option value="">
                            Seleccione
                        </option>

                        <?php
                        while($f = mysqli_fetch_assoc($fichas)){
                        ?>

                        <option
                        value="<?php echo $f['id_ficha']; ?>">

                            #<?php echo $f['id_ficha']; ?>

                            -

                            <?php echo $f['mascota_nombre']; ?>

                            -

                            <?php echo $f['servicio_nombre']; ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="form-group">

                    <label>
                        Insumo
                    </label>

                    <select
                    name="id_insumo"
                    required>

                        <option value="">
                            Seleccione
                        </option>

                        <?php
                        while($i = mysqli_fetch_assoc($inventario)){
                        ?>

                        <option
                        value="<?php echo $i['id_insumo']; ?>">

                            <?php echo $i['nombre']; ?>

                            -

                            Stock:

                            <?php echo $i['stock']; ?>

                            <?php echo $i['unidad']; ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="form-group">

                    <label>
                        Cantidad Usada
                    </label>

                    <input
                    type="number"
                    step="0.01"
                    name="cantidad_usada"
                    required>

                </div>

                <div class="form-group">

                    <label>
                        Cantidad Devuelta
                    </label>

                    <input
                    type="number"
                    step="0.01"
                    name="cantidad_devuelta"
                    value="0">

                </div>

                <div class="form-group">

                    <label>
                        Desperdicio
                    </label>

                    <input
                    type="number"
                    step="0.01"
                    name="cantidad_desperdiciada"
                    value="0">

                </div>

                <div class="form-group full">

                    <button
                    type="submit"
                    name="registrar"
                    class="btn-save">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Registrar Insumo

                    </button>

                </div>

            </form>

        </div>

        <!-- HISTORIAL -->
         <div class="table-responsive">

            <table>

                <thead>

                    <tr>

                        <th>Ficha</th>
                        <th>Insumo</th>
                        <th>Usado</th>
                        <th>Devuelto</th>
                        <th>Desperdicio</th>
                        <th>Fecha</th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    while($h = mysqli_fetch_assoc($historial)){
                    ?>

                    <tr>

                        <td>
                            #<?php echo $h['id_ficha']; ?>
                        </td>

                        <td>
                            <?php echo $h['insumo_nombre']; ?>
                        </td>

                        <td>
                            <?php echo $h['cantidad_usada']; ?>
                        </td>

                        <td>
                            <?php echo $h['cantidad_devuelta']; ?>
                        </td>

                        <td>
                            <?php echo $h['cantidad_desperdiciada']; ?>
                        </td>

                        <td>
                            <?php echo $h['fecha_registro']; ?>
                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>