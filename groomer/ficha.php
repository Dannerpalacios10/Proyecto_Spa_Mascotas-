<?php

session_start();

include("../config/database.php");

/** @var mysqli $conn */

if(!isset($_SESSION['id_usuario'])){

    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "GROOMER"){

    header("Location: ../auth/login.php");
    exit();
}

/* VALIDAR ID */

if(!isset($_GET['id'])){

    die("ID de cita no recibido.");
}

$idCita = intval($_GET['id']);

/* OBTENER DATOS */

$sql = "
SELECT

cita.*,

mascota.nombre AS mascota_nombre,
mascota.raza,
mascota.tamano,

servicio.nombre AS servicio_nombre,

usuario.nombre AS cliente_nombre

FROM cita

INNER JOIN mascota
ON cita.id_mascota = mascota.id_mascota

INNER JOIN servicio
ON cita.id_servicio = servicio.id_servicio

INNER JOIN usuario
ON mascota.id_cliente = usuario.id_usuario

WHERE cita.id_cita = '$idCita'
";

$resultado = mysqli_query($conn,$sql);

if(!$resultado){

    die(mysqli_error($conn));
}

$cita = mysqli_fetch_assoc($resultado);

if(!$cita){

    die("No se encontró la cita.");
}

/* PRODUCTO */

$sqlInventario = "
SELECT *
FROM producto
WHERE estado='DISPONIBLE'
ORDER BY nombre ASC
";

$inventario = mysqli_query($conn,$sqlInventario);

if(!$inventario){
    die(mysqli_error($conn));
}

/* GUARDAR */

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $estadoIngreso =
    mysqli_real_escape_string(
    $conn,
    $_POST['estado_ingreso']
    );

    $observaciones =
    mysqli_real_escape_string(
    $conn,
    $_POST['observaciones']
    );

    $recomendaciones =
    mysqli_real_escape_string(
    $conn,
    $_POST['recomendaciones']
    );

    $checkBano =
    isset($_POST['check_bano']) ? 1 : 0;

    $checkCorte =
    isset($_POST['check_corte']) ? 1 : 0;

    $checkUnas =
    isset($_POST['check_unas']) ? 1 : 0;

    $checkOidos =
    isset($_POST['check_oidos']) ? 1 : 0;

    $checkGlandulas =
    isset($_POST['check_glandulas']) ? 1 : 0;

    $checkPerfume =
    isset($_POST['check_perfume']) ? 1 : 0;

    if ($checkBano == 0 && $checkCorte == 0 && $checkUnas == 0 && $checkOidos == 0 && $checkGlandulas == 0 && $checkPerfume == 0) {
        die("Error: Debe seleccionar al menos un elemento del checklist para poder finalizar el servicio.");
    }

    /* FOTO ANTES */

    $fotoAntes = "";

    if(!empty($_FILES['foto_antes']['name'])){

        $fotoAntes =
        time() . "_antes_" .
        basename($_FILES['foto_antes']['name']);

        move_uploaded_file(
            $_FILES['foto_antes']['tmp_name'],
            "../groomer/subidas/" . $fotoAntes
        );
    }

    /* FOTO DESPUES */

    $fotoDespues = "";

    if(!empty($_FILES['foto_despues']['name'])){

        $fotoDespues =
        time() . "_despues_" .
        basename($_FILES['foto_despues']['name']);

        move_uploaded_file(
            $_FILES['foto_despues']['tmp_name'],
            "../groomer/subidas/" . $fotoDespues
        );
    }

    /* VALIDAR SI YA EXISTE FICHA */

    $sqlExiste = "
    SELECT id_ficha
    FROM ficha_grooming
    WHERE id_cita='$idCita'
    ";

    $resultExiste = mysqli_query($conn,$sqlExiste);

    if(mysqli_num_rows($resultExiste) > 0){

        die("La ficha de esta cita ya fue registrada.");
    }

    /* INSERTAR FICHA */
    
    $sqlFicha = "
    INSERT INTO ficha_grooming
    (
        id_cita,
        estado_ingreso,
        observaciones,

        check_bano,
        check_corte,
        check_unas,
        check_oidos,
        check_glandulas,
        check_perfume,

        foto_antes,
        foto_despues,

        recomendaciones,

        estado_final,

        fecha_inicio,
        fecha_cierre
    )
    VALUES
    (
        '$idCita',

        '$estadoIngreso',

        '$observaciones',

        '$checkBano',
        '$checkCorte',
        '$checkUnas',
        '$checkOidos',
        '$checkGlandulas',
        '$checkPerfume',

        '$fotoAntes',
        '$fotoDespues',

        '$recomendaciones',

        'FINALIZADO',

        NOW(),
        NOW()
    )
    ";

    if(mysqli_query($conn,$sqlFicha)){

        $idFicha = mysqli_insert_id($conn);

        /* INVENTARIO */

        if(isset($_POST['inventario'])){

            foreach($_POST['inventario'] as $idProducto => $cantidad){

                if($cantidad > 0){

                    $sqlUso = "
                    INSERT INTO uso_inventario
                    (
                        id_ficha,
                        id_producto,
                        cantidad_usada
                    )
                    VALUES
                    (
                        '$idFicha',
                        '$idProducto',
                        '$cantidad'
                    )
                    ";

                    mysqli_query($conn,$sqlUso);

                    /* DESCONTAR STOCK */

                    mysqli_query(
                        $conn,
                        "
                        UPDATE inventario
                        SET stock = stock - $cantidad
                        WHERE id_insumo='$idProducto'
                        "
                    );
                }
            }
        }

        /* FINALIZAR CITA */

        mysqli_query(
            $conn,
            "
            UPDATE cita
            SET estado='COMPLETADA'
            WHERE id_cita='$idCita'
            "
        );

        header("Location: agenda.php");
        exit();
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
Ficha Grooming
</title>

<link
rel="stylesheet"
href="../groomer/css/ficha.css?v=3">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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

            <li>
                <a href="inv_usado.php">
                    <i class="fa-solid fa-box-open"></i>
                    <span>Inventario</span>
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

    <!-- CONTENIDO DERECHO -->

    <div class="main-content">

        <div class="topbar">

            <div>
                <h1>Ficha Técnica Grooming</h1>
                <p>Registro de atención y seguimiento del servicio</p>
            </div>

        </div>

        <div class="profile-card">

            <div class="profile-header">

                <div class="avatar">
                    <i class="fa-solid fa-dog"></i>
                </div>

                <h2>
                    <?php echo htmlspecialchars($cita['mascota_nombre']); ?>
                </h2>

                <p>
                    Cliente:
                    <?php echo htmlspecialchars($cita['cliente_nombre']); ?>
                </p>

            </div>

            <form method="POST" enctype="multipart/form-data" onsubmit="return validarChecklist()">

                <div class="form-grid">

                    <div class="input-group">
                        <label>Servicio</label>
                        <input type="text"
                               value="<?php echo htmlspecialchars($cita['servicio_nombre']); ?>"
                               readonly>
                    </div>

                    <div class="input-group">
                        <label>Raza</label>
                        <input type="text"
                               value="<?php echo htmlspecialchars($cita['raza']); ?>"
                               readonly>
                    </div>

                </div>

                <div class="form-grid">

                    <div class="input-group">
                        <label>Tamaño</label>
                        <input type="text"
                               value="<?php echo htmlspecialchars($cita['tamano']); ?>"
                               readonly>
                    </div>

                    <div class="input-group">
                        <label>Estado de Ingreso</label>
                        <textarea name="estado_ingreso" required></textarea>
                    </div>

                </div>

                <div class="input-group">
                    <label>Observaciones</label>
                    <textarea name="observaciones"></textarea>
                </div>

                <h3>Checklist del Servicio</h3>

                <div class="checklist">

                    <label><input type="checkbox" name="check_bano"> BAÑO Y LIMPIEZA</label>

                    <label><input type="checkbox" name="check_corte"> CORTE DE PELO</label>

                    <label><input type="checkbox" name="check_unas"> TRATAMIENTOS</label>

                    <label><input type="checkbox" name="check_oidos"> SERVICIO COMPLETO</label>

                </div>

                <h3>Fotografías</h3>

                <div class="form-grid">

                    <div class="input-group">
                        <label>Foto Antes</label>
                        <input type="file"
                               name="foto_antes"
                               accept="image/*">
                    </div>

                    <div class="input-group">
                        <label>Foto Después</label>
                        <input type="file"
                               name="foto_despues"
                               accept="image/*">
                    </div>

                </div>

                <h3>Inventario Utilizado</h3>

                <?php
                echo "Productos encontrados: " . mysqli_num_rows($inventario);
                ?>

                <div class="inventario">

                    <?php while($i = mysqli_fetch_assoc($inventario)){ ?>

                    <div class="inventario-item">

                        <label>
                            <?php echo $i['nombre']; ?>
                            (Stock: <?php echo $i['stock']; ?>)
                        </label>

                        <input
                        type="number"
                        min="0"
                        value="0"
                        name="inventario[<?php echo $i['id_producto']; ?>]">

                    </div>

                    <?php } ?>

                </div>

                <div class="input-group">

                    <label>Recomendaciones</label>

                    <textarea
                    name="recomendaciones"></textarea>

                </div>

                <button
                type="submit"
                class="btn-save">

                    <i class="fa-solid fa-check"></i>

                    Finalizar Servicio

                </button>

            </form>

        </div>

    </div>

</div>

<script>
function validarChecklist() {
    const checkboxes = document.querySelectorAll('.checklist input[type="checkbox"]');
    let checked = false;
    checkboxes.forEach(function(cb) {
        if (cb.checked) {
            checked = true;
        }
    });
    if (!checked) {
        alert("Debe seleccionar al menos un elemento del checklist para finalizar el servicio.");
        return false;
    }
    return true;
}
</script>

</body>
</html>