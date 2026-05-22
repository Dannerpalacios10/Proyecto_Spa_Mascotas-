<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/Exception.php';
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';

function enviarVerificacion($correo, $token){

    $mail = new PHPMailer(true);

    try{

        /* CONFIGURACIÓN SMTP */

        $mail->isSMTP();

        $mail->Host =
        'smtp.gmail.com';

        $mail->SMTPAuth =
        true;

        $mail->Username =
        'obitopalacios10@gmail.com';

        $mail->Password =
        'shrs jwri rtky muwz';

        $mail->SMTPSecure =
        PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port =
        587;

        $mail->CharSet =
        'UTF-8';

        /* REMITENTE */

        $mail->setFrom(
            'obitopalacios10@gmail.com',
            'SPA PET SYSTEM'
        );

        /* DESTINATARIO */

        $mail->addAddress($correo);

        /* CONTENIDO */

        $mail->isHTML(true);

        $mail->Subject =
        'SPA PAW PATROL | Verificación de Cuenta';

        $link =
        "http://localhost/SPA/auth/verificar_email.php?token=" .
        urlencode($token);

        /* BODY HTML */

        $mail->Body = "

        <div style='
        background:#f4f6f9;
        padding:40px 0;
        font-family:Arial, Helvetica, sans-serif;
        '>

            <div style='
            max-width:600px;
            margin:auto;
            background:#ffffff;
            border-radius:14px;
            overflow:hidden;
            box-shadow:0 6px 18px rgba(0,0,0,0.10);
            '>

                <!-- HEADER -->

                <div style='
                background:#2563eb;
                padding:35px;
                text-align:center;
                color:white;
                '>

                    <h1 style='
                    margin:0;
                    font-size:30px;
                    '>

                        SPA PAW PATROL

                    </h1>

                    <p style='
                    margin-top:10px;
                    font-size:15px;
                    opacity:.95;
                    '>

                        Sistema Profesional de Gestión para Mascotas

                    </p>

                </div>

                <!-- CONTENIDO -->

                <div style='padding:40px;'>

                    <h2 style='
                    color:#111827;
                    margin-bottom:20px;
                    '>

                        Bienvenido 👋

                    </h2>

                    <p style='
                    color:#374151;
                    font-size:16px;
                    line-height:1.8;
                    '>

                        Gracias por registrarte en
                        <strong>SPA PAW PATROL</strong>.

                    </p>

                    <p style='
                    color:#374151;
                    font-size:16px;
                    line-height:1.8;
                    '>

                        Para activar tu cuenta y comenzar
                        a utilizar el sistema, debes verificar
                        tu correo electrónico.

                    </p>

                    <!-- BOTÓN -->

                    <div style='
                    text-align:center;
                    margin:35px 0;
                    '>

                        <a href='$link'
                        style='
                        display:inline-block;
                        background:#22c55e;
                        color:white;
                        text-decoration:none;
                        padding:15px 35px;
                        border-radius:8px;
                        font-size:16px;
                        font-weight:bold;
                        '>

                            Verificar Cuenta

                        </a>

                    </div>

                    <p style='
                    color:#6b7280;
                    font-size:14px;
                    line-height:1.7;
                    '>

                        Este enlace de verificación
                        expirará en 24 horas
                        por motivos de seguridad.

                    </p>

                    <p style='
                    color:#6b7280;
                    font-size:14px;
                    line-height:1.7;
                    '>

                        Si no realizaste este registro,
                        puedes ignorar este mensaje.

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
                    Plataforma de Administración Veterinaria y Grooming

                </div>

            </div>

        </div>

        ";

        /* VERSIÓN TEXTO */

        $mail->AltBody = "

        SPA PET SYSTEM

        Verifica tu cuenta ingresando al siguiente enlace:

        $link

        ";

        /* ENVIAR */

        $mail->send();

        return true;

    }catch(Exception $e){

        error_log(
            'Error PHPMailer: ' .
            $mail->ErrorInfo
        );

        return false;
    }
}
?>