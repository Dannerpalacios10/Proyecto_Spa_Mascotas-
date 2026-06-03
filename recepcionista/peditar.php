<?php

session_start();

/** @var mysqli $conn */
include("../config/database.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: inventario.php");
    exit();
}

$idProducto = intval($_GET['id']);

$sql = "
SELECT *
FROM producto
WHERE id_producto='$idProducto'
";

$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: inventario.php");
    exit();
}

$producto = mysqli_fetch_assoc($resultado);

/* CATEGORIAS */

$sqlCategorias = "
SELECT *
FROM categoria
";

$categorias = mysqli_query($conn, $sqlCategorias);

/* GUARDAR CAMBIOS */

if (isset($_POST['guardar'])) {

    $nombre = mysqli_real_escape_string(
        $conn,
        $_POST['nombre']
    );

    $descripcion = mysqli_real_escape_string(
        $conn,
        $_POST['descripcion']
    );

    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $estado = $_POST['estado'];
    $categoria = intval($_POST['categoria']);

    $sqlUpdate = "
    UPDATE producto
    SET
        nombre='$nombre',
        descripcion='$descripcion',
        precio='$precio',
        stock='$stock',
        estado='$estado',
        id_categoria='$categoria'
    WHERE id_producto='$idProducto'
    ";

    if (mysqli_query($conn, $sqlUpdate)) {

        $_SESSION['success'] =
        "Producto actualizado correctamente.";

        header("Location: inventario.php");
        exit();

    } else {

        $error = mysqli_error($conn);

    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Editar Producto</title>

<link rel="stylesheet"
href="../recepcionista/css/peditar.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

    <div class="card">

        <h2>Editar Producto</h2>

        <?php if(isset($error)){ ?>

        <div class="alert error">
            <?php echo $error; ?>
        </div>

        <?php } ?>

        <form method="POST">

            <div class="grid">

                <input
                type="text"
                name="nombre"
                value="<?php echo htmlspecialchars($producto['nombre']); ?>"
                required>

                <input
                type="number"
                step="0.01"
                name="precio"
                value="<?php echo $producto['precio']; ?>"
                required>

                <input
                type="number"
                name="stock"
                value="<?php echo $producto['stock']; ?>"
                required>

                <select
                name="categoria"
                required>

                    <?php
                    while($c = mysqli_fetch_assoc($categorias)){
                    ?>

                    <option
                    value="<?php echo $c['id_categoria']; ?>"
                    <?php
                    if($c['id_categoria'] == $producto['id_categoria']){
                        echo "selected";
                    }
                    ?>>

                        <?php echo $c['nombre']; ?>

                    </option>

                    <?php } ?>

                </select>

                <select name="estado">

                    <option
                    value="DISPONIBLE"
                    <?php
                    if($producto['estado']=="DISPONIBLE"){
                        echo "selected";
                    }
                    ?>>
                    Disponible
                    </option>

                    <option
                    value="NO_DISPONIBLE"
                    <?php
                    if($producto['estado']=="NO_DISPONIBLE"){
                        echo "selected";
                    }
                    ?>>
                    No disponible
                    </option>

                </select>

            </div>

            <textarea
            name="descripcion"
            required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>

            <button
            type="submit"
            name="guardar"
            class="btn-save">

                <i class="fa-solid fa-floppy-disk"></i>

                Guardar Cambios

            </button>

            <a
            href="inventario.php"
            class="btn delete">

                Cancelar

            </a>

        </form>

    </div>

</div>

</body>
</html>