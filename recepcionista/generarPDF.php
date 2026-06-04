<?php

session_start();

/** @var mysqli $conn */
include("../config/database.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once(__DIR__ . "/../vendor/autoload.php");

use Dompdf\Dompdf;

$tipo = $_GET['tipo'] ?? '';

$html = '';

/* REPORTE DE SERVICIOS */
if ($tipo == 'servicio') {

    $sql = "
    SELECT
        c.id_cita,
        u.nombre AS cliente,
        m.nombre AS mascota,
        s.nombre AS servicio,
        s.precio_base,
        c.fecha_inicio
    FROM cita c
    INNER JOIN mascota m ON c.id_mascota = m.id_mascota
    INNER JOIN usuario u ON m.id_cliente = u.id_usuario
    INNER JOIN servicio s ON c.id_servicio = s.id_servicio
    WHERE c.estado='COMPLETADA'
    ORDER BY c.id_cita DESC
    ";

    $resultado = mysqli_query($conn, $sql);

    $filas = '';
    $total = 0;

    while ($r = mysqli_fetch_assoc($resultado)) {

        $total += $r['precio_base'];

        $filas .= "
        <tr>
            <td>{$r['id_cita']}</td>
            <td>{$r['cliente']}</td>
            <td>{$r['mascota']}</td>
            <td>{$r['servicio']}</td>
            <td>Bs. ".number_format($r['precio_base'],2)."</td>
            <td>{$r['fecha_inicio']}</td>
        </tr>";
    }

    $html = "
    <h1>REPORTE DE SERVICIOS</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Mascota</th>
            <th>Servicio</th>
            <th>Precio</th>
            <th>Fecha</th>
        </tr>

        $filas
    </table>

    <h2>Total Facturado: Bs. ".number_format($total,2)."</h2>
    ";
}

/* REPORTE DE PRODUCTOS UTILIZADOS */
elseif ($tipo == 'consumo') {

    $sql = "
    SELECT
        fg.id_cita,
        p.nombre,
        ui.cantidad_usada,
        p.precio
    FROM uso_inventario ui
    INNER JOIN ficha_grooming fg
        ON ui.id_ficha = fg.id_ficha
    INNER JOIN producto p
        ON ui.id_producto = p.id_producto
    ORDER BY fg.id_cita DESC
    ";

    $resultado = mysqli_query($conn, $sql);

    $filas = '';
    $total = 0;

    while ($r = mysqli_fetch_assoc($resultado)) {

        $subtotal =
        $r['cantidad_usada'] *
        $r['precio'];

        $total += $subtotal;

        $filas .= "
        <tr>
            <td>{$r['id_cita']}</td>
            <td>{$r['nombre']}</td>
            <td>{$r['cantidad_usada']}</td>
            <td>Bs. ".number_format($r['precio'],2)."</td>
            <td>Bs. ".number_format($subtotal,2)."</td>
        </tr>";
    }

    $html = "
    <h1>REPORTE DE PRODUCTOS UTILIZADOS</h1>

    <table>
        <tr>
            <th>Cita</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
        </tr>

        $filas
    </table>

    <h2>Total Consumido: Bs. ".number_format($total,2)."</h2>
    ";
}

/* REPORTE DE VENTAS */
elseif ($tipo == 'venta') {

    $sql = "
    SELECT
        c.id_carrito,
        c.fecha_creacion,
        u.nombre AS cliente,
        p.nombre AS producto,
        dc.cantidad,
        dc.precio_unitario
    FROM carrito c
    INNER JOIN usuario u
        ON c.id_cliente = u.id_usuario
    INNER JOIN detalle_carrito dc
        ON c.id_carrito = dc.id_carrito
    INNER JOIN producto p
        ON dc.id_producto = p.id_producto
    ORDER BY c.id_carrito DESC
    ";

    $resultado = mysqli_query($conn, $sql);

    $filas = '';
    $total = 0;

    while ($r = mysqli_fetch_assoc($resultado)) {

        $subtotal =
        $r['cantidad'] *
        $r['precio_unitario'];

        $total += $subtotal;

        $filas .= "
        <tr>
            <td>{$r['id_carrito']}</td>
            <td>{$r['cliente']}</td>
            <td>{$r['producto']}</td>
            <td>{$r['cantidad']}</td>
            <td>Bs. ".number_format($r['precio_unitario'],2)."</td>
            <td>Bs. ".number_format($subtotal,2)."</td>
            <td>{$r['fecha_creacion']}</td>
        </tr>";
    }

    $html = "
    <h1>REPORTE DE VENTAS DE TIENDA</h1>

    <table>
        <tr>
            <th>Compra</th>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th>Fecha</th>
        </tr>

        $filas
    </table>

    <h2>Total Vendido: Bs. ".number_format($total,2)."</h2>
    ";
}

else {
    die("Tipo de reporte no válido.");
}

/* ESTILOS PDF */

$html = "
<html>
<head>
<meta charset='UTF-8'>

<style>

body{
    font-family: Arial, sans-serif;
    margin:20px;
    color:#333;
}

h1{
    text-align:center;
    color:#1f4e79;
}

h2{
    text-align:right;
    margin-top:20px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th{
    background:#1f4e79;
    color:white;
}

th,td{
    border:1px solid #ccc;
    padding:8px;
    text-align:left;
}

</style>

</head>

<body>

$html

</body>
</html>
";

/* DOMPDF */

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'landscape');

$dompdf->render();

$dompdf->stream(
    "Reporte_".$tipo.".pdf",
    ["Attachment" => false]
);

exit();