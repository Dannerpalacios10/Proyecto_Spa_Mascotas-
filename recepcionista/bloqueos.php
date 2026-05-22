<?php

session_start();

/** @var mysqli $conn */

include("../config/database.php");

/* REGISTRAR BLOQUEO */

if(isset($_POST['registrar'])){

    $tipo = $_POST['tipo'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    $sql = "
    INSERT INTO bloqueos(
        tipo,
        fecha,
        descripcion
    )
    VALUES(
        '$tipo',
        '$fecha',
        '$descripcion'
    )
    ";

    mysqli_query($conn,$sql);

    $_SESSION['mensaje'] = "Bloqueo registrado correctamente";

    header("Location: bloqueo.php");
    exit();
}

/* LISTAR BLOQUEOS */

$sqlBloqueos = "
SELECT *
FROM bloqueos
ORDER BY fecha DESC
";

$bloqueos = mysqli_query($conn,$sqlBloqueos);

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Bloqueos</title>

<link rel="stylesheet" href="../recepcionista/css/bloqueo.css">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>
<body>

<div class="container">

    <div class="card">

        <h1>
            <i class="fa-solid fa-lock"></i>
            Gestión de Bloqueos
        </h1>

        <?php if(isset($_SESSION['mensaje'])){ ?>

            <div class="success">

                <?php
                echo $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
                ?>

            </div>

        <?php } ?>

        <form method="POST">

            <div class="buttons-group">

                <button
                type="button"
                class="tipo-btn"
                onclick="seleccionarTipo('feriado')">

                    <i class="fa-solid fa-calendar-xmark"></i>
                    Feriado

                </button>

                <button
                type="button"
                class="tipo-btn"
                onclick="seleccionarTipo('mantenimiento')">

                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    Mantenimiento

                </button>

                <button
                type="button"
                class="tipo-btn"
                onclick="seleccionarTipo('descanso')">

                    <i class="fa-solid fa-mug-hot"></i>
                    Hora de Descanso

                </button>

            </div>

            <input
            type="hidden"
            name="tipo"
            id="tipo"
            required>

            <div class="input-group">

                <label>
                    Fecha
                </label>

                <input
                type="date"
                name="fecha"
                required>

            </div>

            <div class="input-group">

                <label>
                    Descripción
                </label>

                <textarea
                name="descripcion"
                placeholder="Detalle del bloqueo..."
                required></textarea>

            </div>

            <button
            type="submit"
            name="registrar"
            class="btn-save">

                <i class="fa-solid fa-floppy-disk"></i>
                Guardar Bloqueo

            </button>

        </form>

    </div>

    <div class="table-card">

        <h2>
            Bloqueos Registrados
        </h2>

        <table>

            <thead>

                <tr>

                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Descripción</th>

                </tr>

            </thead>

            <tbody>

                <?php while($b = mysqli_fetch_assoc($bloqueos)){ ?>

                <tr>

                    <td>
                        <?php echo ucfirst($b['tipo']); ?>
                    </td>

                    <td>
                        <?php echo $b['fecha']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($b['descripcion']); ?>
                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<script>

function seleccionarTipo(tipo){

    document.getElementById("tipo").value = tipo;

    const botones = document.querySelectorAll(".tipo-btn");

    botones.forEach(btn=>{

        btn.classList.remove("active");
    });

    event.target.closest("button").classList.add("active");
}

</script>

</body>
</html>
