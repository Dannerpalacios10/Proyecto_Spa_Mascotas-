<?php

session_start();

/** @var mysqli $conn */
include("../config/database.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../auth/login.php");
    exit();
}

$nombre = $_SESSION['nombre'];

/* AGREGAR PRODUCTO */

if (isset($_POST['agregar'])) {

    $nombreProducto = mysqli_real_escape_string($conn, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $estado = $_POST['estado'];
    $categoria = intval($_POST['categoria']);

    // VALIDACIÓN IMPORTANTE (EVITA ERROR FOREIGN KEY)
    if ($categoria <= 0) {
        $_SESSION['error'] = "Debes seleccionar una categoría válida.";
        header("Location: inventario.php");
        exit();
    }

    $imagen = "";

    if (isset($_FILES['imagen']) && $_FILES['imagen']['name'] != "") {

        $imagen = time() . "_" . $_FILES['imagen']['name'];

        $targetDir = "../uploads/productos/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        move_uploaded_file(
            $_FILES['imagen']['tmp_name'],
            $targetDir . $imagen
        );
    }

    $sqlInsert = "
        INSERT INTO producto
        (
            nombre,
            descripcion,
            precio,
            stock,
            estado,
            imagen,
            id_categoria
        )
        VALUES
        (
            '$nombreProducto',
            '$descripcion',
            '$precio',
            '$stock',
            '$estado',
            '$imagen',
            '$categoria'
        )
    ";

    $result = mysqli_query($conn, $sqlInsert);

    if ($result) {
        $_SESSION['success'] = "Producto agregado correctamente.";
    } else {
        $_SESSION['error'] = "Error al agregar producto: " . mysqli_error($conn);
    }

    header("Location: inventario.php");
    exit();
}

/* ELIMINAR PRODUCTO */

if (isset($_GET['eliminar'])) {

    $idProducto = intval($_GET['eliminar']);

    $sqlDelete = "
        DELETE FROM producto
        WHERE id_producto='$idProducto'
    ";

    mysqli_query($conn, $sqlDelete);

    $_SESSION['success'] = "Producto eliminado.";

    header("Location: inventario.php");
    exit();
}

/* EDITAR PRODUCTO */

if (isset($_POST['editar'])) {

    $idProducto = intval($_POST['id_producto']);
    $nombreProducto = mysqli_real_escape_string($conn, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $estado = $_POST['estado'];

    $sqlUpdate = "
        UPDATE producto
        SET
            nombre='$nombreProducto',
            descripcion='$descripcion',
            precio='$precio',
            stock='$stock',
            estado='$estado'
        WHERE id_producto='$idProducto'
    ";

    mysqli_query($conn, $sqlUpdate);

    $_SESSION['success'] = "Producto actualizado.";

    header("Location: inventario.php");
    exit();
}

/* CATEGORIAS */

$sqlCategorias = "SELECT * FROM categoria";
$categorias = mysqli_query($conn, $sqlCategorias);

/* PRODUCTOS */

$sqlProductos = "
    SELECT producto.*, categoria.nombre AS categoria_nombre
    FROM producto
    LEFT JOIN categoria
    ON producto.id_categoria = categoria.id_categoria
    ORDER BY producto.id_producto DESC
";

$productos = mysqli_query($conn, $sqlProductos);

?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Inventario</title>

<link rel="stylesheet" href="../recepcionista/css/inventario.css?v=6">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="container">

    <div class="sidebar">

        <div class="logo">
            <h3>SPA PAW PATROL</h3>
        </div>

        <ul class="menu">
            <li>
                <a href="recepcionista.php">
                    <i class="fa-solid fa-house"></i>
                     Inicio
                </a>
            </li>

            <li>
                <a href="pago.php">
                    <i class="fa-solid fa-credit-card"></i>
                     Cobro servicio
                </a>
            </li>

            <li>
                <a href="bloqueos.php">
                    <i class="fa-solid fa-ban"></i>
                     Bloqueos
                </a>
            </li>

            <li class="active">
                <a href="inventario.php">
                    <i class="fa-solid fa-bag-shopping"></i>
                     Inventario
                </a>
            </li>

            <li>
                <a href="reportes.php">
                    <i class="fa-solid fa-file-pdf"></i>
                    Reportes
                </a>
            </li>

        </ul>

        <div class="logout">
            <a href="../auth/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
            </a>
        </div>

    </div>

    <div class="main-content">

        <div class="topbar">
            <h1>Inventario</h1>
            <p>Bienvenida Recepcionista, <?php echo htmlspecialchars($nombre); ?></p>
        </div>

        <!-- MENSAJES -->
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php } ?>

        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert error">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php } ?>

        <?php

        $sqlStockBajo = "
        SELECT nombre, stock
        FROM producto
        WHERE stock <= 5
        ORDER BY stock ASC
        ";

        $stockBajo = mysqli_query($conn, $sqlStockBajo);

        while($producto = mysqli_fetch_assoc($stockBajo)){

        ?>

        <div class="alert warning">

            <i class="fa-solid fa-triangle-exclamation"></i>

            <?php echo htmlspecialchars($producto['nombre']); ?>

            tiene stock bajo. Solo quedan

            <strong><?php echo $producto['stock']; ?></strong>

            unidades disponibles.

        </div>

        <?php } ?>

        <!-- FORMULARIO -->
        <div class="card">

            <h2>Agregar Producto</h2>

            <form method="POST" enctype="multipart/form-data">

                <div class="grid">

                    <input type="text" name="nombre" placeholder="Nombre" required>

                    <input type="number" step="0.01" name="precio" placeholder="Precio" required>

                    <input type="number" name="stock" placeholder="Stock" required>

                    <select name="categoria" required>
                        <option value="0" disabled selected>Seleccione categoría</option>

                        <?php while ($c = mysqli_fetch_assoc($categorias)) { ?>
                            <option value="<?php echo $c['id_categoria']; ?>">
                                <?php echo $c['nombre']; ?>
                            </option>
                        <?php } ?>

                    </select>

                    <select name="estado">
                        <option value="DISPONIBLE">Disponible</option>
                        <option value="NO_DISPONIBLE">No disponible</option>
                    </select>

                    <input type="file" name="imagen" required>

                </div>

                <textarea name="descripcion" placeholder="Descripción" required></textarea>

                <button type="submit" name="agregar" class="btn-save">
                    <i class="fa-solid fa-plus"></i> Agregar Producto
                </button>

            </form>

        </div>

        <!-- TABLA -->
        <div class="table-card">

            <div class="table-responsive">

                <table>

                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php while ($p = mysqli_fetch_assoc($productos)) { ?>

                        <tr>

                            <td>
                                <img class="table-img" src="../uploads/productos/<?php echo $p['imagen']; ?>">
                            </td>

                            <td><?php echo $p['nombre']; ?></td>
                            <td>Bs. <?php echo number_format($p['precio'], 2); ?></td>
                            <td><?php echo $p['stock']; ?></td>
                            <td><?php echo $p['estado']; ?></td>

                            <td>

                                <div class="actions">

                                    <a class="btn edit" href="peditar.php?id=<?php echo $p['id_producto']; ?>">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <a class="btn delete" href="?eliminar=<?php echo $p['id_producto']; ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                </div>

                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>