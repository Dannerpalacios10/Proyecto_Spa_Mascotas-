<?php

session_start();

/** @var mysqli $conn */

include("../config/database.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "RECEPCIONISTA"){
    header("Location: ../auth/login.php");
    exit();
}

$nombre = $_SESSION['nombre'];

/* REGISTRAR PAGO */

if(isset($_POST['registrar_pago'])){

    $idCita =
    intval($_POST['id_cita']);

    $metodoPago =
    $_POST['metodo_pago'];

    $monto =
    floatval($_POST['monto']);

    $referencia =
    mysqli_real_escape_string(
        $conn,
        $_POST['referencia']
    );

    $sqlPago = "
    INSERT INTO pago
    (
        id_cita,
        metodo_pago,
        monto,
        referencia,
        fecha_pago
    )
    VALUES
    (
        '$idCita',
        '$metodoPago',
        '$monto',
        '$referencia',
        NOW()
    )
    ";

    mysqli_query($conn,$sqlPago);

    /* ACTUALIZAR CITA */

    $sqlUpdate = "
    UPDATE cita
    SET estado='PAGADA'
    WHERE id_cita='$idCita'
    ";

    mysqli_query($conn,$sqlUpdate);

    $_SESSION['success'] =
    "Pago registrado correctamente.";

    header("Location: pagos.php");
    exit();
}

/* CITAS CONFIRMADAS */

$sqlCitas = "
SELECT

cita.id_cita,

cita.fecha_inicio,

servicio.nombre AS servicio,

servicio.precio_base AS precio_base,

mascota.nombre AS mascota,

usuario.nombre AS cliente

FROM cita

INNER JOIN mascota
ON cita.id_mascota = mascota.id_mascota

INNER JOIN usuario
ON mascota.id_cliente = usuario.id_usuario

INNER JOIN servicio
ON cita.id_servicio = servicio.id_servicio

WHERE cita.estado='CONFIRMADA'

ORDER BY cita.fecha_inicio ASC
";

$citas =
mysqli_query($conn,$sqlCitas);

/* HISTORIAL DE PAGOS */

$sqlPagos = "
SELECT

pago.*,

usuario.nombre AS cliente,

servicio.nombre AS servicio

FROM pago

INNER JOIN cita
ON pago.id_cita = cita.id_cita

INNER JOIN mascota
ON cita.id_mascota = mascota.id_mascota

INNER JOIN usuario
ON mascota.id_cliente = usuario.id_usuario

INNER JOIN servicio
ON cita.id_servicio = servicio.id_servicio

ORDER BY pago.id_pago DESC
";

$pagos =
mysqli_query($conn,$sqlPagos);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Pagos
</title>

<link
rel="stylesheet"
href="../recepcionista/css/pago.css?v=1">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div>

            <div class="logo">

                <h2>SPA PAW PATROL</h2>

            </div>

            <ul class="menu">

                <li>

                    <a href="recepcionista.php">

                        <i class="fa-solid fa-house"></i>

                        Inicio

                    </a>

                </li>

                <li class="active">

                    <a href="pagos.php">

                        <i class="fa-solid fa-credit-card"></i>

                        Cobro Servicio

                    </a>

                </li>

                <li>

                    <a href="bloqueos.php">

                        <i class="fa-solid fa-ban"></i>

                        Bloqueos

                    </a>

                </li>

                <li>

                    <a href="inventario.php">

                    <i class="fa-solid fa-bag-shopping"></i>

                        Inventario

                    </a>

                 </li>

            </ul>

        </div>

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
                    Gestión de Cobros
                </h1>

                <p>

                    Bienvenida,
                    <?php echo htmlspecialchars($nombre); ?>

                </p>

            </div>

        </div>

        <!-- ALERTA -->

        <?php
        if(isset($_SESSION['success'])){
        ?>

        <div class="alert success">

            <?php

            echo $_SESSION['success'];

            unset($_SESSION['success']);

            ?>

        </div>

        <?php } ?>

        <!-- COBROS -->

        <div class="table-card">

            <h2>
                Cobrar Servicios
            </h2>

            <table>

                <thead>

                    <tr>

                        <th>Cliente</th>

                        <th>Mascota</th>

                        <th>Servicio</th>

                        <th>Monto</th>

                        <th>Método</th>

                        <th>Acción</th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    while($c = mysqli_fetch_assoc($citas)){
                    ?>

                    <tr>

                        <td>

                            <?php
                            echo htmlspecialchars($c['cliente']);
                            ?>

                        </td>

                        <td>

                            <?php
                            echo htmlspecialchars($c['mascota']);
                            ?>

                        </td>

                        <td>

                            <?php
                            echo htmlspecialchars($c['servicio']);
                            ?>

                        </td>

                        <td>

                            Bs.
                            <?php
                            echo number_format(
                                $c['precio_base'],
                                2
                            );
                            ?>

                        </td>

                        <td>

                            <form method="POST">

                                <input
                                type="hidden"
                                name="id_cita"
                                value="<?php echo $c['id_cita']; ?>">

                                <input
                                type="hidden"
                                name="monto"
                                value="<?php echo $c['precio_base']; ?>">

                                <select
                                name="metodo_pago"
                                required>

                                    <option value="">
                                        Método
                                    </option>

                                    <option value="EFECTIVO">
                                        Efectivo
                                    </option>

                                    <option value="QR">
                                        QR
                                    </option>

                                    <option value="TARJETA">
                                        Tarjeta
                                    </option>

                                </select>

                        </td>

                        <td>

                                <input
                                type="text"
                                name="referencia"
                                placeholder="Referencia">

                                <button
                                type="submit"
                                name="registrar_pago"
                                class="btn-pay">

                                    <i class="fa-solid fa-money-check-dollar"></i>

                                    Cobrar

                                </button>

                            </form>

                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

        <!-- HISTORIAL -->

        <div class="table-card">

            <h2>
                Historial de Pagos
            </h2>

            <table>

                <thead>

                    <tr>

                        <th>Cliente</th>

                        <th>Servicio</th>

                        <th>Monto</th>

                        <th>Método</th>

                        <th>Referencia</th>

                        <th>Fecha</th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    while($p = mysqli_fetch_assoc($pagos)){
                    ?>

                    <tr>

                        <td>

                            <?php
                            echo htmlspecialchars($p['cliente']);
                            ?>

                        </td>

                        <td>

                            <?php
                            echo htmlspecialchars($p['servicio']);
                            ?>

                        </td>

                        <td>

                            Bs.
                            <?php
                            echo number_format(
                                $p['monto'],
                                2
                            );
                            ?>

                        </td>

                        <td>

                            <?php
                            echo htmlspecialchars($p['metodo_pago']);
                            ?>

                        </td>

                        <td>

                            <?php
                            echo htmlspecialchars($p['referencia']);
                            ?>

                        </td>

                        <td>

                            <?php
                            echo $p['fecha_pago'];
                            ?>

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