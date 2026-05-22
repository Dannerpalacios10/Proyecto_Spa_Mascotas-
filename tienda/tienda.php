<?php

session_start();

/** @var mysqli $conn */

include("../config/database.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../auth/login.php");
    exit();
}

$nombre = $_SESSION['nombre'];

/* PRODUCTOS */

$sqlProductos = "
SELECT *
FROM producto

LEFT JOIN categoria_producto
ON producto.id_categoria = categoria_producto.id_categoria

ORDER BY producto.id_producto DESC
";

$productos = mysqli_query($conn,$sqlProductos);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Tienda Pet Spa
</title>

<link
rel="stylesheet"
href="../tienda/css/tienda.css?v=1">

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

            <i class="fa-solid fa-paw"></i>

            <h2>SPA PAW PATROL</h2>

        </div>

        <ul class="menu">

            <li>

                <a href="../cliente/dashboard.php">

                    <i class="fa-solid fa-house"></i>

                    <span>
                        Inicio
                    </span>

                </a>

            </li>

            <li class="active">

                <a href="../tienda/tienda.php">

                    <i class="fa-solid fa-store"></i>

                    <span>
                        Tienda
                    </span>

                </a>

            </li>

            <li>

                <a href="../cliente/citas.php">

                    <i class="fa-solid fa-calendar-days"></i>

                    <span>
                        Mis Citas
                    </span>

                </a>

            </li>

            <li>

                <a href="../cliente/perfil.php">

                    <i class="fa-solid fa-user"></i>

                    <span>
                        Mi Perfil
                    </span>

                </a>

            </li>

            <li>

                <a href="../auth/logout.php">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    <span>
                        Cerrar Sesión
                    </span>

                </a>

            </li>

        </ul>

    </div>

    <!-- MAIN -->

    <div class="main-content">

        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h1>
                    Tienda Pet Spa
                </h1>

                <p>
                    Bienvenido,
                    <?php echo htmlspecialchars($nombre); ?>
                </p>

            </div>

            <div class="search-box">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                type="text"
                id="searchInput"
                placeholder="Buscar productos...">

            </div>

        </div>

        <!-- PRODUCTOS -->

        <div class="products-grid" id="productsGrid">

            <?php
            while($p = mysqli_fetch_assoc($productos)){
            ?>

            <div class="product-card">

                <span class="badge">

                    Nuevo

                </span>

                <div class="product-image">

                    <img
                    src="../uploads/productos/<?php echo $p['imagen']; ?>"
                    alt="Producto">

                </div>

                <div class="product-content">
                    
                    <p class="product-category">

                        <?php

                        if(isset($p['categoria'])){

                            echo htmlspecialchars($p['categoria']);

                        }else{

                            echo "Sin categoría";
                        }

                        ?>

                    </p>

                    <h2 class="product-title">

                        <?php echo htmlspecialchars($p['nombre']); ?>

                    </h2>

                    <p class="product-description">

                        <?php echo htmlspecialchars($p['descripcion']); ?>

                    </p>

                    <div class="product-footer">

                        <span class="price">

                            Bs.
                            <?php echo number_format($p['precio'],2); ?>

                        </span>

                        <button class="btn-buy">

                            <i class="fa-solid fa-cart-shopping"></i>

                            Comprar

                        </button>

                    </div>

                    <p class="stock">

                        Stock disponible:
                        <?php echo $p['stock']; ?>

                    </p>

                </div>

            </div>

            <?php } ?>

        </div>

    </div>

</div>

<script>

/* BUSCADOR */

const searchInput =
document.getElementById("searchInput");

searchInput.addEventListener("keyup",()=>{

    const filter =
    searchInput.value.toLowerCase();

    const cards =
    document.querySelectorAll(".product-card");

    cards.forEach(card=>{

        const title =
        card.querySelector(".product-title")
        .textContent
        .toLowerCase();

        const category =
        card.querySelector(".product-category")
        .textContent
        .toLowerCase();

        if(
            title.includes(filter)
            ||
            category.includes(filter)
        ){

            card.style.display = "block";

        }else{

            card.style.display = "none";
        }
    });
});

</script>

</body>
</html>