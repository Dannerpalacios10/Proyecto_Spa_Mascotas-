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

/* INVENTARIO */

$sqlInventario = "
SELECT *
FROM inventario
ORDER BY nombre ASC
";

$inventario = mysqli_query($conn,$sqlInventario);

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

    /* INSERTAR FICHA */

    $sqlFicha = "
    INSERT INTO ficha_grooming
    (
        id_cita,
        estado_ingreso,
        observaciones,
        checklist_bano,
        checklist_corte,
        checklist_unas,
        checklist_oidos,
        checklist_glandulas,
        checklist_perfume,
        foto_antes,
        foto_despues,
        recomendaciones,
        estado_servicio,
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

            foreach($_POST['inventario'] as $idInsumo => $cantidad){

                if($cantidad > 0){

                    $sqlUso = "
                    INSERT INTO uso_inventario
                    (
                        id_ficha,
                        id_insumo,
                        cantidad_usada
                    )
                    VALUES
                    (
                        '$idFicha',
                        '$idInsumo',
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
                        WHERE id_insumo='$idInsumo'
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
href="../groomer/css/ficha.css">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<div class="card">

<h1>
Ficha Técnica Grooming
</h1>

<div class="info">

<p>
<strong>Mascota:</strong>
<?php echo htmlspecialchars($cita['mascota_nombre']); ?>
</p>

<p>
<strong>Cliente:</strong>
<?php echo htmlspecialchars($cita['cliente_nombre']); ?>
</p>

<p>
<strong>Servicio:</strong>
<?php echo htmlspecialchars($cita['servicio_nombre']); ?>
</p>

<p>
<strong>Raza:</strong>
<?php echo htmlspecialchars($cita['raza']); ?>
</p>

<p>
<strong>Tamaño:</strong>
<?php echo htmlspecialchars($cita['tamano']); ?>
</p>

</div>

<form
method="POST"
enctype="multipart/form-data">

<div class="input-group">

<label>
Estado de ingreso
</label>

<textarea
name="estado_ingreso"
required></textarea>

</div>

<div class="input-group">

<label>
Observaciones
</label>

<textarea
name="observaciones"></textarea>

</div>

<h2>
Checklist
</h2>

<div class="checklist">

<label><input type="checkbox" name="check_bano"> Baño</label>

<label><input type="checkbox" name="check_corte"> Corte</label>

<label><input type="checkbox" name="check_unas"> Uñas</label>

<label><input type="checkbox" name="check_oidos"> Oídos</label>

<label><input type="checkbox" name="check_glandulas"> Glándulas</label>

<label><input type="checkbox" name="check_perfume"> Perfume</label>

</div>

<h2>
Fotos
</h2>

<div class="grid">

<div class="input-group">

<label>
Foto Antes
</label>

<input
type="file"
name="foto_antes">

</div>

<div class="input-group">

<label>
Foto Después
</label>

<input
type="file"
name="foto_despues">

</div>

</div>

<h2>
Inventario Utilizado
</h2>

<div class="inventario">

<?php
while($i = mysqli_fetch_assoc($inventario)){
?>

<div class="inventario-item">

<label>

<?php echo $i['nombre']; ?>

(Stock:
<?php echo $i['stock']; ?>)

</label>

<input
type="number"
step="1"
min="0"
name="inventario[<?php echo $i['id_insumo']; ?>]"
value="0">

</div>

<?php } ?>

</div>

<div class="input-group">

<label>
Recomendaciones
</label>

<textarea
name="recomendaciones"></textarea>

</div>

<button
type="submit"
class="btn">

Finalizar Servicio

</button>

</form>

</div>

</div>

</body>
</html>