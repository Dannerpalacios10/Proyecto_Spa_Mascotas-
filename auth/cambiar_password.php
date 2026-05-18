
<?php
session_start();

include("../config/database.php");

/* ===================================================== */
/* VALIDAR LOGIN */
/* ===================================================== */

if(
    !isset($_SESSION['id_usuario'])
){
    header("Location: ../auth/login.php");
    exit();
}

$idUsuario = $_SESSION['id_usuario'];

/* ===================================================== */
/* TEMPORIZADOR 10 MINUTOS */
/* ===================================================== */

if(!isset($_SESSION['inicio_cambio_password'])){

    $_SESSION['inicio_cambio_password'] = time();
}

$tiempoLimite = 60;

$tiempoTranscurrido =
(time() - $_SESSION['inicio_cambio_password']);

$segundosRestantes =
$tiempoLimite - $tiempoTranscurrido;

if($segundosRestantes <= 0){

    session_destroy();

    header("Location: ../auth/login.php?expirado=1");
    exit();
}

/* ===================================================== */
/* CAMBIAR PASSWORD */
/* ===================================================== */

$mensaje = "";
$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $passwordActual =
    trim($_POST['password_actual']);

    $passwordNueva =
    trim($_POST['password_nueva']);

    $confirmarPassword =
    trim($_POST['confirmar_password']);

    $sql = "
    SELECT *
    FROM usuario
    WHERE id_usuario = '$idUsuario'
    ";

    $resultado = mysqli_query($conn,$sql);

    $usuario = mysqli_fetch_assoc($resultado);

    if(!password_verify(
        $passwordActual,
        $usuario['password_hash']
    )){

        $error =
        "La contraseña actual es incorrecta.";

    }elseif($passwordNueva != $confirmarPassword){

        $error =
        "Las nuevas contraseñas no coinciden.";

    }elseif(strlen($passwordNueva) < 8 ||

        !preg_match('/[A-Z]/',$passwordNueva) ||

        !preg_match('/[a-z]/',$passwordNueva) ||

        !preg_match('/[0-9]/',$passwordNueva) ||

        !preg_match('/[\W]/',$passwordNueva)
    ){

        $error =
        "La nueva contraseña debe tener los requisitos anteriores";

    }else{

        $passwordHash =
        password_hash(
            $passwordNueva,
            PASSWORD_BCRYPT
        );

        $update = "
        UPDATE usuario
        SET
        password_hash = '$passwordHash',
        cambio_password = 1
        WHERE id_usuario = '$idUsuario'
        ";

        if(mysqli_query($conn,$update)){

            unset($_SESSION['inicio_cambio_password']);

            unset($_SESSION['inicio_cambio_password']);

            session_destroy();

            header("Location: ../auth/login.php?password=updated");
            exit();

        }else{

            $error =
            "Error al actualizar contraseña.";
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
Cliente - Cambio de Contraseña
</title>

<link
rel="stylesheet"
href="../assets/css/cambiar_pas.css?v=2">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="background"></div>

<div class="container">

    <div class="card">

        <div class="logo">
            <i class="fa-solid fa-paw"></i>
        </div>

        <h1>
            Cambio Obligatorio
        </h1>

        <p class="subtitle">
            Debes actualizar tu contraseña para continuar.
        </p>

        <div class="timer-box">

            <i class="fa-solid fa-clock"></i>

            Tiempo restante:

            <span id="timer">
                <?php echo $segundosRestantes; ?>
            </span>

            segundos

        </div>

        <?php if($mensaje != ""){ ?>

            <div class="success-box">
                <?php echo $mensaje; ?>
            </div>

        <?php } ?>

        <?php if($error != ""){ ?>

            <div class="error-box">
                <?php echo $error; ?>
            </div>

        <?php } ?>

        <form method="POST">

        <div class="input-box">

            <i class="fa-solid fa-lock icon"></i>

            <input
            type="password"
            id="password_actual"
            name="password_actual"
            placeholder="Contraseña actual"
            required>

            <span
            class="eye"
            onclick="togglePassword('password_actual', this)">

                <i class="fa-solid fa-eye"></i>

            </span>

        </div>

        <div class="input-box">

            <i class="fa-solid fa-key icon"></i>

            <input
            type="password"
            id="password_nueva"
            name="password_nueva"
            placeholder="Nueva contraseña"
            required>

            <span
            class="eye"
            onclick="togglePassword('password_nueva', this)">

                <i class="fa-solid fa-eye"></i>

            </span>

        </div>

        <div class="input-box">

            <i class="fa-solid fa-shield icon"></i>

            <input
            type="password"
            id="confirmar_password"
            name="confirmar_password"
            placeholder="Confirmar nueva contraseña"
            required>

            <span
            class="eye"
            onclick="togglePassword('confirmar_password', this)">

                <i class="fa-solid fa-eye"></i>

            </span>

        </div>

            <button
            type="submit"
            class="btn-save">

                Guardar Nueva Contraseña

            </button>

        </form>

    </div>

</div>

<script src="../assets/js/cambiar_pas.js?v=2"></script>

</body>
</html>
