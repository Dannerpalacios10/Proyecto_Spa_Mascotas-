<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

function enviarRecuperacion($correo,$token){

    $mail = new PHPMailer(true);

    try{

        /* CONFIGURACIÓN SMTP */

        $mail->isSMTP();

        $mail->Host =
        'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username =
        'obitopalacios10@gmail.com';

        $mail->Password =
        'shrs jwri rtky muwz';

        $mail->SMTPSecure =
        'tls';

        $mail->Port = 587;

        /* REMITENTE */

        $mail->setFrom(
            'obitopalacios10@gmail.com',
            'SPA PAW PATROL'
        );

        /* DESTINATARIO */

        $mail->addAddress($correo);

        /* FORMATO */

        $mail->isHTML(true);

        $mail->CharSet =
        'UTF-8';

        /* ASUNTO */

        $mail->Subject =
        'SPA PAW PATROL | Recuperación de Contraseña';

        /* LINK */

        $link =
        "http://localhost/SPA/auth/nueva_password.php?token=$token";

        /* CUERPO HTML */

        $mail->Body = "

        <div style='
        font-family: Arial, sans-serif;
        background:#f4f6f9;
        padding:40px;
        '>

            <div style='
            max-width:600px;
            margin:auto;
            background:white;
            border-radius:12px;
            overflow:hidden;
            box-shadow:0 4px 15px rgba(0,0,0,0.1);
            '>

                <!-- HEADER -->

                <div style='
                background:#2563eb;
                padding:30px;
                text-align:center;
                color:white;
                '>

                    <h1 style='margin:0;'>
                        SPA PAW PATROL
                    </h1>

                    <p style='margin-top:10px;'>
                        Recuperación de Contraseña
                    </p>

                </div>

                <!-- BODY -->

                <div style='padding:40px;'>

                    <h2 style='color:#111827;'>
                        Hola 👋
                    </h2>

                    <p style='
                    color:#374151;
                    font-size:16px;
                    line-height:1.7;
                    '>

                        Hemos recibido una solicitud
                        para restablecer la contraseña
                        de tu cuenta.

                    </p>

                    <p style='
                    color:#374151;
                    font-size:16px;
                    line-height:1.7;
                    '>

                        Haz clic en el siguiente botón
                        para crear una nueva contraseña:

                    </p>

                    <div style='
                    text-align:center;
                    margin:35px 0;
                    '>

                        <a href='$link'
                        style='
                        background:#2563eb;
                        color:white;
                        text-decoration:none;
                        padding:15px 35px;
                        border-radius:8px;
                        font-size:16px;
                        font-weight:bold;
                        display:inline-block;
                        '>

                            Cambiar Contraseña

                        </a>

                    </div>

                    <p style='
                    color:#6b7280;
                    font-size:14px;
                    line-height:1.6;
                    '>

                        Este enlace expirará
                        en 1 hora por seguridad.

                    </p>

                    <p style='
                    color:#6b7280;
                    font-size:14px;
                    line-height:1.6;
                    '>

                        Si no solicitaste este cambio,
                        puedes ignorar este correo.

                    </p>

                </div>

                <!-- FOOTER -->

                <div style='
                background:#f3f4f6;
                padding:20px;
                text-align:center;
                color:#6b7280;
                font-size:13px;
                '>

                    © 2026 SPA PAW PATROL
                    <br>
                    Sistema de Gestión para Mascotas

                </div>

            </div>

        </div>

        ";

        /* ENVIAR */

        $mail->send();

        return true;

    }catch(Exception $e){

        return false;
    }
}
?>