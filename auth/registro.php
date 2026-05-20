<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

include("../config/database.php");

/** @var mysqli $conn */



$mensaje = "";
$tipo = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $nombre =
    mysqli_real_escape_string(
    $conn,
    $_POST['nombre']
    );

    $apellido =
    mysqli_real_escape_string(
    $conn,
    $_POST['apellido']
    );

    $email =
    mysqli_real_escape_string(
    $conn,
    $_POST['email']
    );

    $telefono =
    mysqli_real_escape_string(
    $conn,
    $_POST['telefono']
    );

    $direccion =
    mysqli_real_escape_string(
    $conn,
    $_POST['direccion']
    );

    $password =
    $_POST['password'];

    $verificar =
    $_POST['verificar_password'];

    /* VALIDAR PASSWORD */


    if($password !== $verificar){

        $mensaje =
        "Las contraseñas no coinciden";

        $tipo = "error";

    }else{

        if(

            strlen($password) < 8 ||

            !preg_match('/[A-Z]/',$password) ||

            !preg_match('/[a-z]/',$password) ||

            !preg_match('/[0-9]/',$password) ||

            !preg_match('/[\W]/',$password)

        ){

            $mensaje =
            "La contraseña debe tener mínimo 8 caracteres, mayúscula, minúscula, número y símbolo.";

            $tipo = "error";

        }else{

            /* VERIFICAR EMAIL */

            $check =
            mysqli_query(
            $conn,
            "SELECT id_usuario
            FROM usuario
            WHERE email='$email'"
            );

            if(mysqli_num_rows($check) > 0){

                $mensaje =
                "El correo ya existe";

                $tipo = "error";

            }else{

                /* HASH PASSWORD */

                $passwordHash =
                password_hash(
                $password,
                PASSWORD_DEFAULT
                );

                /* OBTENER ROL CLIENTE */
                
                $rolQuery =
                mysqli_query(
                $conn,
                "SELECT id_rol
                FROM rol
                WHERE nombre='CLIENTE'"
                );

                $rolData =
                mysqli_fetch_assoc($rolQuery);

                if(!$rolData){

                    $mensaje =
                    "El rol CLIENTE no existe";

                    $tipo = "error";

                }else{

                    $idRol =
                    $rolData['id_rol'];

                /* TOKEN */

                $token =
                bin2hex(random_bytes(32));

                $expira =
                date(
                    "Y-m-d H:i:s",
                    strtotime("+1 day")
                );

                /* INSERTAR CLIENTE */

                $sql = "

                INSERT INTO usuario
                (

                    nombre,
                    apellido,
                    direccion,
                    email,
                    telefono,
                    password_hash,
                    estado_activo,
                    id_rol,
                    token_activacion,
                    token_expira,
                    email_verificado

                )

                VALUES
                (

                    '$nombre',
                    '$apellido',
                    '$direccion',
                    '$email',
                    '$telefono',
                    '$passwordHash',
                    1,
                    '$idRol',
                    '$token',
                    '$expira',
                    0

                )

                ";

                if(mysqli_query($conn,$sql)){

                    include("../auth/correo_enviado.php");

                    if(
                        enviarVerificacion(
                            $email,
                            $token
                        )
                    ){

                        $mensaje =
                        "Cuenta creada. Revisa tu correo para verificar.";

                        $tipo = "success";

                    }else{

                        $mensaje =
                        "Cuenta creada pero no se pudo enviar correo.";

                        $tipo = "error";
                    }

                }else{

                    $mensaje =
                    "Error SQL: ".
                    mysqli_error($conn);

                    $tipo = "error";
                }

                }
            }
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

<title>Registro Cliente</title>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link
rel="stylesheet"
href="../assets/css/registro.css">

</head>

<body>

<div class="background-animation"></div>

<div class="container fadeIn">

    <div class="header">

        <h1>
            Registro Cliente
        </h1>

        <p>
            Crea tu cuenta para SPA PET SYSTEM
        </p>

    </div>

    <?php if($mensaje != ""): ?>

        <div class="alert <?php echo $tipo; ?>">

            <?php echo $mensaje; ?>

        </div>

    <?php endif; ?>

    <form method="POST" id="formulario">

        <div class="grid-2">

            <div class="input-group">

                <label>
                    Nombre
                </label>

                <input
                type="text"
                name="nombre"
                placeholder="Ingrese nombre"
                required>

            </div>

            <div class="input-group">

                <label>
                    Apellido
                </label>

                <input
                type="text"
                name="apellido"
                placeholder="Ingrese apellido"
                required>

            </div>

        </div>

        <div class="input-group">

            <label>
                Dirección
            </label>

            <input
            type="text"
            name="direccion"
            placeholder="Ingrese dirección"
            required>

        </div>

        <div class="grid-2">

            <div class="input-group">

                <label>
                    Correo Electrónico
                </label>

                <input
                type="email"
                name="email"
                placeholder="ejemplo@gmail.com"
                required>

            </div>

            <div class="input-group">

                <label>
                    Teléfono
                </label>

                <input
                type="text"
                name="telefono"
                placeholder="77777777"
                required>

            </div>

        </div>

        <div class="input-group">

            <label>
                Contraseña
            </label>

            <div class="password-box">

                <input
                type="password"
                name="password"
                id="password"
                placeholder="Ingrese contraseña"
                required>

                <button
                type="button"
                class="show-btn"
                onclick="togglePassword()">

                    👁

                </button>

            </div>

        </div>

        <div class="strength-container">

            <div id="bar"></div>

        </div>

        <div class="password-rules">

            <span id="rule1">
                • 8 caracteres
            </span>

            <span id="rule2">
                • Mayúscula
            </span>

            <span id="rule3">
                • Minúscula
            </span>

            <span id="rule4">
                • Número
            </span>

            <span id="rule5">
                • Símbolo
            </span>

        </div>

        <div class="input-group">

            <label>
                Confirmar Contraseña
            </label>

            <div class="password-box">

                <input
                type="password"
                name="verificar_password"
                id="confirmPassword"
                placeholder="Ingrese contraseña"
                required>

                <button
                type="button"
                class="show-btn"
                onclick="togglePassword('confirmPassword')">

                    👁

                </button>

            </div>

        </div>

        <div id="passwordMatch"></div>

        <button
        type="submit"
        class="btn-submit">

            Registrarse

        </button>

        <!-- DIVISOR -->

        <div class="divider">

            <span>
                o continuar con
            </span>

        </div>

        <!-- GOOGLE -->

        <a href="#"
        class="google-btn">

    <img
    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg"
    alt="Google">

    Continuar con Google

</a>

    </form>

</div>

<script src="../assets/js/registro.js?v=2"></script>

</body>
</html>