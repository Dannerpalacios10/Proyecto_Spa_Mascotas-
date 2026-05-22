<?php

ob_start();

session_start();


include("../config/database.php");
include("../config/log.php");

/** @var mysqli $conn */

/* ================= CAPTCHA ================= */

if(!isset($_SESSION['captcha'])){
    $_SESSION['captcha'] = rand(1000,9999);
}

/* ================= CONTROL DE INTENTOS ================= */

if (!isset($_SESSION['intentos'])) {
    $_SESSION['intentos'] = 0;
}

if (!isset($_SESSION['bloqueado_hasta'])) {
    $_SESSION['bloqueado_hasta'] = 0;
}

/* ================= DESBLOQUEAR ================= */

if ($_SESSION['bloqueado_hasta'] > 0 && time() >= $_SESSION['bloqueado_hasta']){
    $_SESSION['bloqueado_hasta'] = 0;
    $_SESSION['intentos'] = 0;
}

$bloqueado = false;
$segundos_restantes = 0;

if ($_SESSION['bloqueado_hasta'] > time()) {
    $bloqueado = true;
    $segundos_restantes = $_SESSION['bloqueado_hasta'] - time();
}

/* ================= LOGIN ================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($bloqueado) {
        $error = "Demasiados intentos. Espera $segundos_restantes segundos.";
    } else {

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $captcha = trim($_POST['captcha']);

        /* ===== VALIDAR CAPTCHA ===== */

        if($captcha != $_SESSION['captcha']){
            $error = "Captcha incorrecto.";
            $_SESSION['captcha'] = rand(1000,9999);
        } else {

            $sql = "
            SELECT usuario.*, rol.nombre AS rol_nombre
            FROM usuario
            INNER JOIN rol ON usuario.id_rol = rol.id_rol
            WHERE usuario.email='$email'
            ";

            $resultado = mysqli_query($conn, $sql);

            if ($resultado && mysqli_num_rows($resultado) > 0){

                $usuario = mysqli_fetch_assoc($resultado);

                /* ===== VALIDACIONES ===== */

                if($usuario['rol_nombre'] == "ADMIN"){
                    $error = "El administrador debe ingresar desde el panel ADMIN.";
                }
                elseif($usuario['estado_activo'] == 0){
                    $error = "Tu cuenta está desactivada. Contacta con el administrador.";
                }
                elseif(!password_verify($password, $usuario['password_hash'])){
                    $error = "Correo o contraseña incorrectos.";
                }
                elseif($usuario['email_verificado'] == 0){
                    $error = "Verifica tu correo antes de iniciar sesión.";
                }
                else{

                    $rolesPermitidos = ["CLIENTE","GROOMER","RECEPCIONISTA"];

                    if(!in_array($usuario['rol_nombre'], $rolesPermitidos)){
                        $error = "Rol no autorizado.";
                    }
                    else{

                        /* ===== LOGIN CORRECTO ===== */

                        $_SESSION['intentos'] = 0;
                        $_SESSION['bloqueado_hasta'] = 0;
                        $_SESSION['id_usuario'] = $usuario['id_usuario'];
                        $_SESSION['nombre'] = $usuario['nombre'];
                        $_SESSION['rol'] = $usuario['rol_nombre'];

                        /* ===== PRIMER CAMBIO PASSWORD ===== */

                        if($usuario['cambio_password'] == 0){
                            header("Location: ../auth/cambiar_password.php");
                            exit();
                        }

                        /* ===== AUDITORIA ===== */

                        $idUsuario = $usuario['id_usuario'];
                        $ipUsuario = $_SERVER['REMOTE_ADDR'];
                        $navegador = $_SERVER['HTTP_USER_AGENT'];

                        $sqlAuditoria = "
                        INSERT INTO auditoria
                        (id_usuario, accion, fecha, ip_usuario, navegador)
                        VALUES
                        ('$idUsuario','Inicio de sesión',NOW(),'$ipUsuario','$navegador')
                        ";

                        mysqli_query($conn, $sqlAuditoria);

                        $_SESSION['captcha'] = rand(1000,9999);

                        /* ===== REDIRECCIÓN ===== */

                        if ($usuario['rol_nombre'] == "GROOMER"){
                            header("Location: ../groomer/groomer.php", true, 303);
                            exit();
                        }
                        elseif ($usuario['rol_nombre'] == "RECEPCIONISTA"){
                            header("Location: ../recepcionista/recepcionista.php", true, 303);
                            exit();
                        }
                        elseif ($usuario['rol_nombre'] == "CLIENTE"){
                            header("Location: ../cliente/cliente.php", true, 303);
                            exit();
                        }

                        exit();
                    }
                }

            } else {
                $error = "Correo o contraseña incorrectos.";
            }

            /* ===== CONTROL DE INTENTOS ===== */

            if(isset($error)){
                $_SESSION['intentos']++;

                if ($_SESSION['intentos'] >= 3) {
                    $_SESSION['bloqueado_hasta'] = time() + 30;
                    $bloqueado = true;
                    $segundos_restantes = 30;
                    $error = "Demasiados intentos. Sistema bloqueado.";
                }
            }
        }
    }
}

ob_end_flush();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>Iniciar Sesión</title>

    <link
rel="stylesheet"
href="http://localhost/SPA/assets/css/login.css">

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<script>

history.pushState(null, null, location.href);

window.onpopstate = function () {

    window.location.href = "../index.php";
};

</script>

<body>

<div class="background"></div>

<div class="login-container">

    <!-- PANEL IZQUIERDO -->

    <div class="left-panel">

        <div class="left-content">

            <h1>SPA PAW PATROL</h1>

            <p>
                Plataforma profesional para
                administrar mascotas,
                grooming, citas y servicios.
            </p>

        </div>

    </div>

    <!-- PANEL DERECHO -->

    <div class="right-panel">

        <div class="login-card">

            <h2>Bienvenido</h2>

            <p class="subtitle">
                Inicia sesión para continuar
            </p>

            <?php if(isset($error)){ ?>

                <div class="error-box">

                    <?php echo $error; ?>

                </div>

            <?php } ?>

            <!-- BLOQUEO -->

            <?php if($bloqueado){ ?>

                <div class="blocked-box">

                    <i class="fa-solid fa-lock"></i>

                    Sistema bloqueado:
                    <span id="countdown">

                        <?php
                        echo $segundos_restantes;
                        ?>

                    </span>s

                </div>

            <?php } ?>

            <!-- FORMULARIO -->

            <form method="POST">

                <!-- EMAIL -->

                <div class="input-box">

                    <i class="fa-solid fa-envelope input-icon"></i>

                    <input
                    type="email"
                    name="email"
                    placeholder="Correo"
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
                    required>

                    <span
                    class="eye"
                    onclick="togglePassword()">

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

                
                <!-- OPCIONES -->

                <div class="options">

                    <a href="recuperar_password.php">
                        ¿Olvidaste tu contraseña?
                    </a>

                </div>

                <!-- BOTÓN -->

                <button
                type="submit"
                class="login-btn"
                <?php
                if($bloqueado) echo "disabled";
                ?>>

                    Ingresar

                </button>

                <!-- DIVISOR -->

                <div class="divider">

                    <span>
                        o continuar con
                    </span>

                </div>

                <!-- GOOGLE -->

                <a href="#" class="google-btn">

                    <img
                    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg"
                    alt="Google">

                    Continuar con Google

                </a>

            </form>

            <!-- REGISTER -->

            <div class="register-link">

                ¿No tienes cuenta?

                <a href="registro.php">
                    Registrarse
                </a>

            </div>

        </div>

    </div>

</div>

<script src="http://localhost/SPA/assets/js/login.js"></script>

</body>

</html>