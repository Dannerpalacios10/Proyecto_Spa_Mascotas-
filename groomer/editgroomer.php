<?php

session_start();

/** @var mysqli $conn */

include("../config/database.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['rol'] != "GROOMER"){
    header("Location: ../auth/login.php");
    exit();
}

$idUsuario = $_SESSION['id_usuario'];
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];

$mensaje = "";
$tipo = "";

/* OBTENER DATOS */

$sql = "
SELECT *
FROM usuario
WHERE id_usuario='$idUsuario'
";

$resultado = mysqli_query($conn,$sql);

$usuario = mysqli_fetch_assoc($resultado);

/* ACTUALIZAR PERFIL */

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $nuevoNombre =
    mysqli_real_escape_string(
        $conn,
        $_POST['nombre']
    );

    $nuevoApellido =
    mysqli_real_escape_string(
        $conn,
        $_POST['apellido']
    );

    $nuevoEmail =
    mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );

    $nuevoTelefono =
    mysqli_real_escape_string(
        $conn,
        $_POST['telefono']
    );

    $nuevaDireccion =
    mysqli_real_escape_string(
        $conn,
        $_POST['direccion']
    );

    $nuevaPassword =
    trim($_POST['password']);

    $verificarPassword =
    trim($_POST['verificar_password']);

    /* VALIDAR EMAIL REPETIDO */

    $sqlEmail = "
    SELECT *
    FROM usuario
    WHERE email='$nuevoEmail'
    AND id_usuario != '$idUsuario'
    ";

    $resultEmail =
    mysqli_query($conn,$sqlEmail);

    if(mysqli_num_rows($resultEmail) > 0){

        $mensaje =
        "El correo ya está registrado.";

        $tipo =
        "error";

    }
    elseif(
        !empty($nuevaPassword)
        &&
        (
            strlen($nuevaPassword) < 8 ||
            !preg_match('/[A-Z]/', $nuevaPassword) ||
            !preg_match('/[a-z]/', $nuevaPassword) ||
            !preg_match('/[0-9]/', $nuevaPassword) ||
            !preg_match('/[\W]/', $nuevaPassword)
        )
    ){

        $mensaje =
        "La contraseña debe tener mínimo 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.";

        $tipo =
        "error";
    }
    elseif(
        !empty($nuevaPassword)
        &&
        $nuevaPassword != $verificarPassword
    ){

        $mensaje =
        "Las contraseñas no coinciden.";

        $tipo =
        "error";
    }
    else{

        /* SIN CAMBIAR PASSWORD */

        if(empty($nuevaPassword)){

            $sqlUpdate = "
            UPDATE usuario
            SET
            nombre='$nuevoNombre',
            apellido='$nuevoApellido',
            email='$nuevoEmail',
            telefono='$nuevoTelefono',
            direccion='$nuevaDireccion'
            WHERE id_usuario='$idUsuario'
            ";

        }else{

            $passwordHash =
            password_hash(
                $nuevaPassword,
                PASSWORD_DEFAULT
            );

            $sqlUpdate = "
            UPDATE usuario
            SET
            nombre='$nuevoNombre',
            apellido='$nuevoApellido',
            email='$nuevoEmail',
            telefono='$nuevoTelefono',
            direccion='$nuevaDireccion',
            password_hash='$passwordHash'
            WHERE id_usuario='$idUsuario'
            ";
        }

        if(mysqli_query($conn,$sqlUpdate)){

            $_SESSION['nombre'] =
            $nuevoNombre;

            $mensaje =
            "Perfil actualizado correctamente.";

            $tipo =
            "success";

            /* RECARGAR DATOS */

            $sql = "
            SELECT *
            FROM usuario
            WHERE id_usuario='$idUsuario'
            ";

            $resultado =
            mysqli_query($conn,$sql);

            $usuario =
            mysqli_fetch_assoc($resultado);

        }else{

            $mensaje =
            "Error al actualizar perfil: "
            . mysqli_error($conn);

            $tipo =
            "error";
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
Perfil Groomer
</title>

<link
rel="stylesheet"
href="../groomer/css/editgroomer.css">

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

            <i class="fa-solid fa-scissors"></i>

            <h2>SPA PAW PATROL</h2>

        </div>

        <ul class="menu">

            <li>

                <a href="../groomer/groomer.php">

                    <i class="fa-solid fa-house"></i>

                    <span>Dashboard</span>

                </a>

            </li>

            <li class="active">

                <a href="../groomer/perfil.php">

                    <i class="fa-solid fa-user"></i>

                    <span>Mi Perfil</span>

                </a>

            </li>

            <li>

                <a href="../auth/logout.php">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    <span>Salir</span>

                </a>

            </li>

        </ul>

    </div>

    <!-- MAIN -->

    <div class="main-content">

        <div class="topbar">

            <div>

                <h1>
                    Editar Perfil Groomer
                </h1>

                <p>
                    Actualiza tu información personal
                </p>

            </div>

        </div>

        <?php if($mensaje != ""){ ?>

        <div class="alert <?php echo $tipo; ?>">

            <?php echo $mensaje; ?>

        </div>

        <?php } ?>

        <div class="profile-card">

            <div class="profile-header">

                <div class="avatar">

                    <i class="fa-solid fa-user"></i>

                </div>

                <h2>

                    <?php echo $usuario['nombre']; ?>

                </h2>

                <p>

                    <?php echo $rol; ?>

                </p>

            </div>

            <form method="POST">

                <div class="form-grid">

                    <div class="input-group">

                        <label>
                            Nombre
                        </label>

                        <input
                        type="text"
                        name="nombre"
                        value="<?php echo $usuario['nombre']; ?>"
                        required>

                    </div>

                    <div class="input-group">

                        <label>
                            Apellido
                        </label>

                        <input
                        type="text"
                        name="apellido"
                        value="<?php echo $usuario['apellido']; ?>"
                        required>

                    </div>

                </div>

                <div class="form-grid">

                    <div class="input-group">

                        <label>
                            Correo Electrónico
                        </label>

                        <input
                        type="email"
                        name="email"
                        value="<?php echo $usuario['email']; ?>"
                        required>

                    </div>

                    <div class="input-group">

                        <label>
                            Teléfono
                        </label>

                        <input
                        type="text"
                        name="telefono"
                        value="<?php echo $usuario['telefono']; ?>"
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
                    value="<?php echo $usuario['direccion']; ?>"
                    required>

                </div>

                <div class="form-grid">

                    <div class="input-group">

                        <label>
                            Nueva Contraseña
                        </label>

                        <div class="password-box">

                            <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Dejar vacío para no cambiar">

                            <button
                            type="button"
                            class="show-btn"
                            onclick="togglePassword('password')">

                                👁

                            </button>

                        </div>

                        <div class="strength-container">

                            <div id="bar"></div>

                        </div>

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
                            placeholder="Confirmar contraseña">

                            <button
                            type="button"
                            class="show-btn"
                            onclick="togglePassword('confirmPassword')">

                                👁

                            </button>

                        </div>

                    </div>

                </div>

                <button
                type="submit"
                class="btn-save">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Guardar Cambios

                </button>

            </form>

        </div>

    </div>

</div>

<script>

function togglePassword(id){

    const input =
    document.getElementById(id);

    if(input.type === "password"){

        input.type = "text";

    }else{

        input.type = "password";
    }
}

/* FUERZA PASSWORD */

const password =
document.getElementById("password");

const bar =
document.getElementById("bar");

password.addEventListener("keyup",()=>{

    let value = password.value;

    let strength = 0;

    if(value.length >= 8){

        strength++;

        document.getElementById("rule1")
        .classList.add("valid");

    }else{

        document.getElementById("rule1")
        .classList.remove("valid");
    }

    if(/[A-Z]/.test(value)){

        strength++;

        document.getElementById("rule2")
        .classList.add("valid");

    }else{

        document.getElementById("rule2")
        .classList.remove("valid");
    }

    if(/[a-z]/.test(value)){

        strength++;

        document.getElementById("rule3")
        .classList.add("valid");

    }else{

        document.getElementById("rule3")
        .classList.remove("valid");
    }

    if(/[0-9]/.test(value)){

        strength++;

        document.getElementById("rule4")
        .classList.add("valid");

    }else{

        document.getElementById("rule4")
        .classList.remove("valid");
    }

    if(/[\W]/.test(value)){

        strength++;

        document.getElementById("rule5")
        .classList.add("valid");

    }else{

        document.getElementById("rule5")
        .classList.remove("valid");
    }

    let width = strength * 20;

    bar.style.width = width + "%";

    if(strength <= 2){

        bar.style.background = "#ef4444";

    }else if(strength <= 4){

        bar.style.background = "#f59e0b";

    }else{

        bar.style.background = "#22c55e";
    }
});

</script>

</body>
</html>