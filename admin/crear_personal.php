<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();


include("../config/database.php");


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

    $direccion =
    mysqli_real_escape_string(
    $conn,
    $_POST['direccion']
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

    $password =
    $_POST['password'];

    $verificar =
    $_POST['verificar_password'];

    $rol =
    mysqli_real_escape_string(
    $conn,
    $_POST['rol']
    );

    $turno =
    mysqli_real_escape_string(
    $conn,
    $_POST['turno']
    );

    /* ====================================== */
    /* VALIDAR PASSWORDS */
    /* ====================================== */

    if($password !== $verificar){

        $mensaje =
        "Las contraseñas no coinciden";

        $tipo = "error";

    }else{

        /* ====================================== */
        /* VALIDAR PASSWORD SEGURA */
        /* ====================================== */

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

            /* ====================================== */
            /* VERIFICAR EMAIL */
            /* ====================================== */

            $check =
            mysqli_query(
            $conn,
            "SELECT id_usuario
            FROM usuario
            WHERE email='$email'"
            );

            if(mysqli_num_rows($check) > 0){

                $mensaje =
                "Correo ya registrado";

                $tipo = "error";

            }else{

                /* ====================================== */
                /* HASH PASSWORD */
                /* ====================================== */

                $passwordHash =
                password_hash(
                $password,
                PASSWORD_DEFAULT
                );

                /* ====================================== */
                /* OBTENER ROL */
                /* ====================================== */

                $rolQuery =
                mysqli_query(
                $conn,
                "SELECT id_rol
                FROM rol
                WHERE nombre='$rol'"
                );

                $rolData =
                mysqli_fetch_assoc($rolQuery);

                if(!$rolData){

                    $mensaje =
                    "Rol no encontrado";

                    $tipo = "error";

                }else{

                    $idRol =
                    $rolData['id_rol'];

                    /* ====================================== */
                    /* TOKEN ACTIVACION */
                    /* ====================================== */

                    $token =
                    bin2hex(random_bytes(32));

                    $expira =
                    date(
                        "Y-m-d H:i:s",
                        strtotime("+1 day")
                    );

                    /* ====================================== */
                    /* INSERTAR USUARIO */
                    /* ====================================== */

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
                            "Usuario creado correctamente, Verifique su correo";

                            $tipo = "success";

                        }else{

                            $mensaje =
                            "Usuario creado pero no se pudo enviar el correo";

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

<title>
Crear Personal
</title>

<link
rel="stylesheet"
href="../assets/css/crear_personal.css">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

</head>

<body>

<div class="background-animation"></div>

<div class="container fadeIn">

    <div class="header">

        <h1>
            Crear Personal
        </h1>

        <p>
            Registra nuevos usuarios del sistema
        </p>

    </div>

    <?php if($mensaje != ""): ?>

        <div class="alert <?php echo $tipo; ?>">

            <?php echo $mensaje; ?>

        </div>

    <?php endif; ?>

    <form method="POST" id="formulario">

        <!-- ROL -->

        <div class="input-group">

            <label>
                Rol
            </label>

            <select
            name="rol"
            id="rol"
            required>

                <option value="">
                    Seleccione un rol
                </option>

                <option value="ADMIN">
                    ADMIN
                </option>

                <option value="GROOMER">
                    GROOMER
                </option>

                <option value="RECEPCIONISTA">
                    RECEPCIONISTA
                </option>

                <option value="CLIENTE">
                    CLIENTE
                </option>

            </select>

        </div>

        <!-- TURNO -->

        <div class="input-group">

            <label>
                Turno
            </label>

            <select
            name="turno"
            required
            >
                <option value="Turno">
                    Seleccione un turno
                </option>

                <option value="MAÑANA">
                    MAÑANA
                </option>

                <option value="TARDE">
                    TARDE
                </option>

                <option value="NOCHE">
                    NOCHE
                </option>

            </select>

        </div>

        <!-- CAMPOS DINÁMICOS -->

        <div id="camposRol"></div>

        <!-- NOMBRE Y APELLIDO -->

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

        <!-- DIRECCION -->

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

        <!-- EMAIL Y TELEFONO -->

        <div class="grid-2">

            <div class="input-group">

                <label>
                    Correo Electrónico
                </label>

                <input
                type="email"
                name="email"
                placeholder="@gmail.com"
                required>

            </div>

            <div class="input-group">

                <label>
                    Teléfono
                </label>

                <input
                type="tel"
                name="telefono"
                placeholder="77777777"
                required>

            </div>

        </div>

        <!-- PASSWORD -->

        <div class="input-group">

            <label>
                Contraseña
            </label>

            <div class="password-box">

                <input
                type="password"
                name="password"
                id="password"
                placeholder="Ingresar contraseña"
                required>

                <button
                type="button"
                class="show-btn"
                onclick="togglePassword('password')">

                    👁

                </button>

            </div>

        </div>

        <!-- BARRA -->

        <div class="strength-container">

            <div id="bar"></div>

        </div>

        <!-- REGLAS -->

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

        <!-- VERIFICAR PASSWORD -->

        <div class="input-group">

            <label>
                Verificar Contraseña
            </label>

            <div class="password-box">
        
                <input
                type="password"
                name="verificar_password"
                id="confirmarPassword"
                placeholder="Verificar contraseña"
                required>

                <button
                type="button"
                class="show-btn"
                onclick="togglePassword('confirmarPassword')">

                    👁

                </button>

            </div>

        </div>

        <div id="passwordMatch"></div>

        <!-- BOTON -->

        <button
        type="submit"
        class="btn-submit">

            Crear Usuario

        </button>

    </form>

</div>

<script src="../assets/js/crear_personal.js?v=2"></script>
</body>
</html>