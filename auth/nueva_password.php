<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include("../config/database.php");

$mensaje = "";
$tipo = "";
$icono = "";

$tokenValido = false;

/* VALIDAR TOKEN */

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

    /* BUSCAR TOKEN */

    $sql = "

    SELECT *
    FROM usuario
    WHERE token_recuperacion='$token'

    ";

    $resultado =
    mysqli_query($conn,$sql);

    if(mysqli_num_rows($resultado) <= 0){

        $mensaje =
        "Token inválido o expirado.";

        $tipo =
        "error";

        $icono =
        "❌";

    }else{

        $usuario =
        mysqli_fetch_assoc($resultado);

        /* VALIDAR EXPIRACIÓN */
        

        if(

            $usuario['token_expira'] !== null &&

            strtotime($usuario['token_expira']) < time()

        ){

            $mensaje =
            "El enlace ha expirado.";

            $tipo =
            "error";

            $icono =
            "⏰";

        }else{

            $tokenValido = true;

            /* CAMBIAR PASSWORD */
            

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $password =
                $_POST['password'];

                $verificar =
                $_POST['verificar_password'];

                if($password !== $verificar){

                    $mensaje =
                    "Las contraseñas no coinciden.";

                    $tipo =
                    "error";

                    $icono =
                    "❌";

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

                        $tipo =
                        "error";

                        $icono =
                        "⚠️";

                    }else{

                        $hash =
                        password_hash(
                            $password,
                            PASSWORD_DEFAULT
                        );

                        mysqli_query($conn,"

                        UPDATE usuario
                        SET

                        password_hash='$hash',
                        token_recuperacion=NULL,
                        token_expira=NULL

                        WHERE token_recuperacion='$token'

                        ");

                        $mensaje =
                        "Contraseña actualizada correctamente.";

                        $tipo =
                        "success";

                        $icono =
                        "✅";
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
Nueva Contraseña
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

/* FONDO */


.background{

    position:absolute;

    width:100%;
    height:100%;
}

.circle{

    position:absolute;

    border-radius:50%;

    background:
    rgba(255,255,255,0.08);

    animation:float 8s infinite ease-in-out;
}

.circle:nth-child(1){

    width:240px;
    height:240px;

    top:-90px;
    left:-90px;
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

/* CARD */


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

/* TITULOS */


.logo{

    font-size:55px;

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

/* INPUTS */


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

/* PASSWORD BOX */

.password-box{

    position:relative;
}

.password-box input{

    padding-right:55px !important;
}

.show-btn{

    position:absolute;

    right:12px;
    top:50%;

    transform:translateY(-50%);

    border:none;
    background:none;

    cursor:pointer;

    font-size:18px;

    color:white;
}

/* BARRA */


.strength-container{

    width:100%;

    height:8px;

    background:
    rgba(255,255,255,0.15);

    border-radius:10px;

    overflow:hidden;

    margin-bottom:15px;
}

#bar{

    height:100%;
    width:0%;

    border-radius:10px;

    transition:.3s;
}

/* REGLAS */

.password-rules{

    display:flex;

    justify-content:center;

    align-items:center;

    flex-wrap:wrap;

    gap:10px;

    margin-bottom:20px;

    font-size:13px;
}

.password-rules span{

    padding:6px 12px;

    border-radius:20px;

    background:
    rgba(255,255,255,0.12);

    transition:.3s;
}

.valid{

    color:#22c55e;

    background:
    rgba(34,197,94,.15);
}

.invalid{

    color:#ef4444;

    background:
    rgba(239,68,68,.15);
}

#passwordMatch{

    margin-bottom:20px;

    font-size:14px;

    text-align:center;
}

/* BOTÓN */

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

/* ALERTAS */


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

/* FOOTER */

.footer{

    margin-top:25px;

    font-size:12px;

    opacity:.7;
}

/* LOGIN BUTTON */

.login-btn{

    display:inline-block;

    margin-top:20px;

    padding:12px 25px;

    border-radius:10px;

    background:#2563eb;

    color:white;

    text-decoration:none;

    font-weight:600;

    transition:.3s;
}

.login-btn:hover{

    background:#1d4ed8;
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
        🔒
    </div>

    <h1>
        Nueva Contraseña
    </h1>

    <p class="subtitle">

        Crea una nueva contraseña segura para proteger tu cuenta.

    </p>

    <?php if($mensaje != ""): ?>

        <div class="alert <?php echo $tipo; ?>">

            <strong>
                <?php echo $icono; ?>
            </strong>

            <?php echo $mensaje; ?>

        </div>

    <?php endif; ?>

    <?php if($tipo != "success"): ?>

    <form method="POST">

        <!-- PASSWORD -->

        <div class="input-group">

            <label>
                Nueva Contraseña
            </label>

            <div class="password-box">

                <input
                type="password"
                name="password"
                id="password"
                placeholder="Ingrese nueva contraseña"
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

        <!-- CONFIRMAR PASSWORD -->

        <div class="input-group">

            <label>
                Confirmar Contraseña
            </label>

            <div class="password-box">

                <input
                type="password"
                name="verificar_password"
                id="confirmarPassword"
                placeholder="Repita contraseña"
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

        <button
        type="submit"
        class="btn">

            Guardar Contraseña

        </button>

    </form>

    <?php else: ?>

        <a
        href="login.php"
        class="login-btn">

            Iniciar Sesión

        </a>

    <?php endif; ?>

    <div class="footer">

        © 2026 SPA PAW PATROL
        <br>
        Plataforma segura de gestión veterinaria

    </div>

</div>

<script>

/* VER PASSWORD */

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

password.addEventListener("input",function(){

    let val = this.value;

    let strength = 0;

    const rules = {

        rule1: val.length >= 8,

        rule2: /[A-Z]/.test(val),

        rule3: /[a-z]/.test(val),

        rule4: /[0-9]/.test(val),

        rule5: /[\W]/.test(val)
    };

    Object.keys(rules).forEach(id => {

        const element =
        document.getElementById(id);

        if(rules[id]){

            element.classList.add("valid");
            element.classList.remove("invalid");

            strength++;

        }else{

            element.classList.add("invalid");
            element.classList.remove("valid");
        }
    });

    bar.style.width =
    (strength * 20) + "%";

    if(strength <= 2){

        bar.style.background =
        "#ef4444";

    }else if(strength <= 4){

        bar.style.background =
        "#f59e0b";

    }else{

        bar.style.background =
        "#22c55e";
    }
});

/* VERIFICAR PASSWORD */
const confirmarPassword =
document.getElementById("confirmarPassword");

const passwordMatch =
document.getElementById("passwordMatch");

confirmarPassword.addEventListener("keyup",function(){

    if(confirmarPassword.value === password.value){

        passwordMatch.innerHTML =
        "✅ Las contraseñas coinciden";

        passwordMatch.style.color =
        "#22c55e";

    }else{

        passwordMatch.innerHTML =
        "❌ Las contraseñas no coinciden";

        passwordMatch.style.color =
        "#ef4444";
    }
});

</script>

</body>
</html>