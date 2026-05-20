<?php

session_start();

include("../config/database.php");
include("../config/log.php");

/** @var mysqli $conn */




if(!isset($_SESSION['captcha'])){

    $_SESSION['captcha'] =
    rand(1000,9999);
}


$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email =
    trim($_POST['email']);

    $password =
    trim($_POST['password']);

    $captcha =
    trim($_POST['captcha']);

    if($captcha != $_SESSION['captcha']){

        $error =
        "Captcha incorrecto.";

        $_SESSION['captcha'] =
        rand(1000,9999);

    }else{

        $sql = "

        SELECT

        usuario.*,
        rol.nombre AS rol_nombre

        FROM usuario

        INNER JOIN rol
        ON usuario.id_rol = rol.id_rol

        WHERE usuario.email='$email'

        ";

        $resultado =
        mysqli_query($conn, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {

            $usuario =
            mysqli_fetch_assoc($resultado);

            if (
            password_verify(
            $password,
            $usuario['password_hash']
            )) {

                if (
                $usuario['rol_nombre']
                != "ADMIN"
                ){

                    $error =
                    "Acceso restringido solo para administradores.";

                } else {

                    /* ===================================================== */
                    /* SESSION */
                    /* ===================================================== */

                    $_SESSION['id_usuario'] =
                    $usuario['id_usuario'];

                    $_SESSION['nombre'] =
                    $usuario['nombre'];

                    $_SESSION['rol'] =
                    $usuario['rol_nombre'];

                    /* ===================================================== */
                    /* AUDITORIA */
                    /* ===================================================== */

                    $idUsuario =
                    $usuario['id_usuario'];

                    $ipUsuario =
                    $_SERVER['REMOTE_ADDR'];

                    $navegador =
                    $_SERVER['HTTP_USER_AGENT'];

                    $accion =
                    "Inicio de sesión ADMIN";

                    $sqlAuditoria = "

                    INSERT INTO auditoria
                    (

                        id_usuario,
                        accion,
                        fecha,
                        ip_usuario,
                        navegador

                    )

                    VALUES
                    (

                        '$idUsuario',
                        '$accion',
                        NOW(),
                        '$ipUsuario',
                        '$navegador'

                    )

                    ";

                    mysqli_query(
                    $conn,
                    $sqlAuditoria
                    );

                    /* ===================================================== */
                    /* NUEVO CAPTCHA */
                    /* ===================================================== */

                    $_SESSION['captcha'] =
                    rand(1000,9999);

                    /* ===================================================== */
                    /* REDIRECT */
                    /* ===================================================== */

                    header("Location: dashboard.php");
                    exit();
                }

            } else {

                $error =
                "Credenciales incorrectas.";
            }

        } else {

            $error =
            "Credenciales incorrectas.";
        }
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
        Admin Login
    </title>

    <!-- CSS -->

    <link
    rel="stylesheet"
    href="http://localhost/SPA/assets/css/loginadmin.css">

    <!-- FONT AWESOME -->

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="background"></div>

<div class="login-card">

    <div class="logo">

        <i class="fa-solid fa-shield-dog"></i>

    </div>

    <h2>
        ADMIN PANEL
    </h2>

    <p class="subtitle">

        Acceso exclusivo para administradores

    </p>

    <?php if($error){ ?>

        <div class="error-box">

            <?= $error ?>

        </div>

    <?php } ?>

    <form method="POST">

        <!-- EMAIL -->

        <div class="input-box">

            <i class="fa-solid fa-envelope input-icon"></i>

            <input
            type="email"
            name="email"
            placeholder="Correo administrador"
            required>

        </div>

        <!-- PASSWORD -->

            <div class="input-box">
                <i class="fa-solid fa-lock input-icon"></i>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Contraseña"
                    required
                >

                <span class="eye" onclick="togglePassword()">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>

        <!-- CAPTCHA -->

        <div class="captcha-box">

            <label class="captcha-label">
                Código de Seguridad
            </label>

            <div class="captcha-wrapper">

                <div class="captcha-code">

                    <?php
                    echo $_SESSION['captcha'];
                    ?>

                </div>

                <input
                type="text"
                name="captcha"
                class="captcha-input"
                placeholder="Ingrese el código"
                required>

            </div>

        </div>

        <!-- BOTON -->

        <button
        type="submit"
        class="login-btn">

            Ingresar al Panel

        </button>

    </form>

    <div class="footer">

        SPA PET SYSTEM • ADMIN SECURITY

    </div>

</div>

<script
src="http://localhost/SPA/assets/js/loginadmin.js"></script>

</body>
</html>