<?php
session_start();

/** @var mysqli $conn */
include("../config/database.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION['rol'] != "RECEPCIONISTA") {
    header("Location: ../auth/login.php");
    exit();
}

$nombre = $_SESSION['nombre'] ?? 'Recepcionista';

/* TOTAL SERVICIOS */
$sqlServicios = "
SELECT COUNT(*) total
FROM cita
WHERE estado='COMPLETADA'
";

$resServicios = mysqli_query($conn,$sqlServicios);
$totalServicios = mysqli_fetch_assoc($resServicios)['total'];

/* TOTAL PRODUCTOS USADOS */

$sqlConsumos = "
SELECT COUNT(*) total
FROM uso_inventario
";

$resConsumos = mysqli_query($conn,$sqlConsumos);
$totalConsumos = mysqli_fetch_assoc($resConsumos)['total'];

/* COMPRAS TIENDA */

$sqlVentas = "
SELECT DISTINCT
    c.id_carrito,
    u.nombre AS cliente,
    c.fecha_creacion
FROM carrito c
INNER JOIN usuario u
    ON c.id_cliente = u.id_usuario
INNER JOIN detalle_carrito dc
    ON c.id_carrito = dc.id_carrito
ORDER BY c.id_carrito DESC
";

$ventas = mysqli_query($conn, $sqlVentas);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Centro de Reportes</title>

<link rel="stylesheet" href="../recepcionista/css/reportes.css?v=2">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
                <a href="recepcionista.php">
                    <i class="fa-solid fa-house"></i>
                    Inicio
                </a>
            </li>

            <li>
                <a href="pagos.php">
                    <i class="fa-solid fa-credit-card"></i>
                    Cobro Servicio
                </a>
            </li>

            <li>
                <a href="inventario.php">
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

            <li class="active">
                <a href="reportes.php">
                    <i class="fa-solid fa-file-pdf"></i>
                    Reportes
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

    <!-- CONTENIDO -->
    <div class="main-content">

        <div class="topbar">

            <h1>Centro de Reportes</h1>

            <p>
                Bienvenida Recepcionista,
                <?php echo htmlspecialchars($nombre); ?>
            </p>

        </div>

        <!-- SERVICIOS -->

        <div class="table-card">

            <h1>
                Reporte de Servicios
            </h1>

            <p>
                Servicios completados registrados:
                <strong><?php echo $totalServicios; ?></strong>
            </p>

            <a
            class="pdf-link"
            href="generarPDF.php?tipo=servicio"
            target="_blank">

                <i class="fa-solid fa-file-pdf"></i>
                Generar PDF

            </a>

        </div>

        <!-- PRODUCTOS USADOS -->

        <div class="table-card">

            <h1>
                Productos Utilizados por Groomers
            </h1>

            <p>
                Registros encontrados:
                <strong><?php echo $totalConsumos; ?></strong>
            </p>

            <a
            class="pdf-link"
            href="generarPDF.php?tipo=consumo"
            target="_blank">

                <i class="fa-solid fa-file-pdf"></i>
                Generar PDF

            </a>

        </div>

        <div class="table-card">

            <h1>Compras de Tienda</h1>

            <table>

                <thead>
                    <tr>
                        <th>ID Compra</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>PDF</th>
                    </tr>
                </thead>

                <tbody>

                <?php while($v = mysqli_fetch_assoc($ventas)) { ?>

                <tr>

                    <td><?php echo $v['id_carrito']; ?></td>

                    <td>
                        <?php echo htmlspecialchars($v['cliente']); ?>
                    </td>

                    <td>
                        <?php echo $v['fecha_creacion']; ?>
                    </td>

                    <td>

                        <a class="pdf-link"
                        href="generarPDF.php?tipo=venta&id=<?php echo $v['id_carrito']; ?>"
                        target="_blank">

                            <i class="fa-solid fa-file-pdf"></i>
                            PDF

                        </a>

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