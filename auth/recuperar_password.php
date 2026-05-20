<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include("../config/database.php");

/** @var mysqli $conn */


$mensaje = "";
$tipo = "";
$icono = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email =
    mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );

    $sql = "

    SELECT *
    FROM usuario
    WHERE email='$email'

    ";

    $resultado =
    mysqli_query($conn,$sql);

    if(mysqli_num_rows($resultado) > 0){

        /* ====================================== */
        /* GENERAR TOKEN */
        /* ====================================== */

        $token =
        bin2hex(random_bytes(32));

        $expira =
        date(
            "Y-m-d H:i:s",
            strtotime("+1 hour")
        );

        /* ====================================== */
        /* ACTUALIZAR TOKEN */
        /* ====================================== */

        mysqli_query($conn,"

        UPDATE usuario
        SET

        token_recuperacion='$token',
        token_expira='$expira'

        WHERE email='$email'

        ");

        /* ====================================== */
        /* ENVIAR CORREO */
        /* ====================================== */

        include("correo_recuperacion.php");

        if(
            enviarRecuperacion(
                $email,
                $token
            )
        ){

            $mensaje =
            "Hemos enviado un enlace de recuperación a tu correo electrónico.";

            $tipo =
            "success";

            $icono =
            "📩";

        }else{

            $mensaje =
            "No se pudo enviar el correo de recuperación.";

            $tipo =
            "error";

            $icono =
            "❌";
        }

    }else{

        $mensaje =
        "El correo ingresado no existe.";

        $tipo =
        "error";

        $icono =
        "⚠️";
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
Recuperar Contraseña
</title>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:'Poppins',sans-serif;

    background:
    linear-gradient(
    135deg,
    #0f172a,
    #1e3a8a,
    #2563eb
    );

    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    overflow:hidden;
}

/* ====================================== */
/* FONDO */
/* ====================================== */

.background{

    position:absolute;

    width:100%;
    height:100%;

    overflow:hidden;
}

.circle{

    position:absolute;

    border-radius:50%;

    background:
    rgba(255,255,255,0.08);

    animation:float 8s infinite ease-in-out;
}

.circle:nth-child(1){

    width:260px;
    height:260px;

    top:-100px;
    left:-100px;
}

.circle:nth-child(2){

    width:180px;
    height:180px;

    bottom:-70px;
    right:-70px;

    animation-delay:2s;
}

@keyframes float{

    0%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-20px);
    }

    100%{
        transform:translateY(0px);
    }
}

/* ====================================== */
/* CARD */
/* ====================================== */

.card{

    position:relative;

    width:430px;

    background:
    rgba(255,255,255,0.12);

    backdrop-filter:blur(15px);

    border:
    1px solid rgba(255,255,255,0.15);

    border-radius:22px;

    padding:45px;

    box-shadow:
    0 10px 35px rgba(0,0,0,.35);

    text-align:center;

    color:white;

    animation:fadeIn 1s ease;
}

@keyframes fadeIn{

    from{
        opacity:0;
        transform:translateY(20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* ====================================== */
/* TITULOS */
/* ====================================== */

.logo{

    font-size:52px;

    margin-bottom:15px;
}

h1{

    font-size:28px;

    margin-bottom:10px;
}

.subtitle{

    font-size:14px;

    opacity:.9;

    margin-bottom:30px;

    line-height:1.6;
}

/* ====================================== */
/* INPUT */
/* ====================================== */

.input-group{

    text-align:left;

    margin-bottom:20px;
}

.input-group label{

    display:block;

    margin-bottom:8px;

    font-size:14px;

    font-weight:500;
}

.input-group input{

    width:100%;

    padding:14px;

    border:none;

    outline:none;

    border-radius:10px;

    font-size:15px;

    background:
    rgba(255,255,255,0.18);

    color:white;
}

.input-group input::placeholder{

    color:
    rgba(255,255,255,0.7);
}

/* ====================================== */
/* BOTÓN */
/* ====================================== */

.btn{

    width:100%;

    padding:14px;

    border:none;

    border-radius:10px;

    background:#22c55e;

    color:white;

    font-size:16px;

    font-weight:600;

    cursor:pointer;

    transition:.3s;
}

.btn:hover{

    transform:translateY(-2px);

    box-shadow:
    0 10px 20px rgba(34,197,94,.35);
}

/* ====================================== */
/* ALERTAS */
/* ====================================== */

.alert{

    margin-bottom:20px;

    padding:14px;

    border-radius:10px;

    font-size:14px;

    line-height:1.5;
}

.success{

    background:
    rgba(34,197,94,.18);

    border:
    1px solid rgba(34,197,94,.4);

    color:#bbf7d0;
}

.error{

    background:
    rgba(239,68,68,.18);

    border:
    1px solid rgba(239,68,68,.4);

    color:#fecaca;
}

/* ====================================== */
/* FOOTER */
/* ====================================== */

.footer{

    margin-top:25px;

    font-size:12px;

    opacity:.7;
}

</style>

</head>

<body>

<div class="background">

    <div class="circle"></div>
    <div class="circle"></div>

</div>

<div class="card">

    <div class="logo">
        🔐
    </div>

    <h1>
        Recuperar Contraseña
    </h1>

    <p class="subtitle">

        Ingresa tu correo electrónico y te enviaremos
        un enlace seguro para restablecer tu contraseña.

    </p>

    <?php if($mensaje != ""): ?>

        <div class="alert <?php echo $tipo; ?>">

            <strong>
                <?php echo $icono; ?>
            </strong>

            <?php echo $mensaje; ?>

        </div>

    <?php endif; ?>

    <form method="POST">

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

        <button
        type="submit"
        class="btn">

            Enviar Enlace

        </button>

    </form>

    <div class="footer">

        © 2026 SPA PAW PATROL
        <br>
        Plataforma segura de gestión veterinaria

    </div>

</div>

</body>
</html>