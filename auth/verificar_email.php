<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';

$mensaje = "";
$tipo = "";
$icono = "";

if(!isset($_GET['token'])){

    $mensaje =
    "Token inválido.";

    $tipo =
    "error";

    $icono =
    "❌";

}else{

    $token =
    mysqli_real_escape_string(
        $conn,
        $_GET['token']
    );

    $sql = "

    SELECT *
    FROM usuario
    WHERE token_activacion='$token'

    ";

    $resultado =
    mysqli_query(
        $conn,
        $sql
    );

    if(!$resultado){

        $mensaje =
        "Error en la consulta.";

        $tipo =
        "error";

        $icono =
        "⚠️";

    }else{

        if(mysqli_num_rows($resultado) > 0){

            $usuario =
            mysqli_fetch_assoc($resultado);

            /* ====================================== */
            /* VALIDAR EXPIRACIÓN */
            /* ====================================== */

            if(

                $usuario['token_expira'] !== null &&

                strtotime(
                    $usuario['token_expira']
                ) < time()

            ){

                $mensaje =
                "El enlace de verificación ha expirado.";

                $tipo =
                "error";

                $icono =
                "⌛";

            }

            /* ====================================== */
            /* YA VERIFICADO */
            /* ====================================== */

            elseif($usuario['email_verificado'] == 1){

                $mensaje =
                "Este correo ya fue verificado anteriormente.";

                $tipo =
                "info";

                $icono =
                "ℹ️";

            }

            /* ====================================== */
            /* VERIFICAR CUENTA */
            /* ====================================== */

            else{

                $update = "

                UPDATE usuario
                SET

                email_verificado = 1,
                token_activacion = NULL,
                token_expira = NULL

                WHERE id_usuario = '".$usuario['id_usuario']."'

                ";

                if(mysqli_query($conn,$update)){

                    $mensaje =
                    "Correo verificado correctamente.";

                    $tipo =
                    "success";

                    $icono =
                    "✅";

                }else{

                    $mensaje =
                    "Error al actualizar la cuenta.";

                    $tipo =
                    "error";

                    $icono =
                    "❌";
                }
            }

        }else{

            $mensaje =
            "Token inválido o ya utilizado.";

            $tipo =
            "error";

            $icono =
            "❌";
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
Verificación de Cuenta
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

    height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    overflow:hidden;
}

/* ====================================== */
/* EFECTOS FONDO */
/* ====================================== */

.background-circle{

    position:absolute;

    border-radius:50%;

    background:rgba(255,255,255,0.08);

    animation:float 8s infinite ease-in-out;
}

.circle1{
    width:250px;
    height:250px;
    top:-80px;
    left:-80px;
}

.circle2{
    width:180px;
    height:180px;
    bottom:-60px;
    right:-60px;
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

    width:450px;

    background:rgba(255,255,255,0.12);

    backdrop-filter:blur(15px);

    border:1px solid rgba(255,255,255,0.2);

    border-radius:22px;

    padding:45px;

    text-align:center;

    box-shadow:
    0 10px 35px rgba(0,0,0,0.35);

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
/* ICONO */
/* ====================================== */

.icon{

    font-size:70px;

    margin-bottom:20px;
}

/* ====================================== */
/* TITULO */
/* ====================================== */

.title{

    font-size:28px;

    font-weight:700;

    margin-bottom:15px;
}

/* ====================================== */
/* MENSAJE */
/* ====================================== */

.message{

    font-size:15px;

    line-height:1.8;

    opacity:.95;
}

/* ====================================== */
/* COLORES */
/* ====================================== */

.success{
    color:#22c55e;
}

.error{
    color:#ef4444;
}

.info{
    color:#38bdf8;
}

/* ====================================== */
/* BOTÓN */
/* ====================================== */

.btn{

    display:inline-block;

    margin-top:35px;

    padding:14px 28px;

    background:#22c55e;

    color:white;

    text-decoration:none;

    border-radius:10px;

    font-weight:600;

    transition:.3s;
}

.btn:hover{

    transform:translateY(-3px);

    box-shadow:
    0 10px 20px rgba(34,197,94,.35);
}

/* ====================================== */
/* FOOTER */
/* ====================================== */

.footer{

    margin-top:30px;

    font-size:12px;

    opacity:.7;
}

</style>

</head>

<body>

<div class="background-circle circle1"></div>
<div class="background-circle circle2"></div>

<div class="card">

    <div class="icon">
        <?php echo $icono; ?>
    </div>

    <h1 class="title <?php echo $tipo; ?>">

        SPA PAW PATROL

    </h1>

    <p class="message">

        <?php echo $mensaje; ?>

    </p>

    <?php if($tipo == "success"): ?>

        <a
        href="login.php"
        class="btn">

            Iniciar Sesión

        </a>

    <?php endif; ?>

    <div class="footer">

        © 2026 SPA PAW PATROL
        <br>
        Plataforma profesional de gestión veterinaria y grooming

    </div>

</div>

</body>
</html>