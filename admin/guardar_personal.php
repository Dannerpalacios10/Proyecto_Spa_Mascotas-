<?php
session_start();

include("../config/database.php");

/** @var mysqli $conn */



$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$password = $_POST['password'];
$rol = $_POST['rol'];

/* VALIDACIÓN FUERTE */

if(
strlen($password) < 8 ||
!preg_match('/[A-Z]/',$password) ||
!preg_match('/[a-z]/',$password) ||
!preg_match('/[0-9]/',$password) ||
!preg_match('/[\W]/',$password)
){
    die("Password inseguro.");
}

/* HASH SEGURO */
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

/* TOKEN 15 MIN */
$token = bin2hex(random_bytes(32));
$expira = date("Y-m-d H:i:s", strtotime("+15 minutes"));

/* OBTENER ID ROL */
$rolQuery = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT id_rol FROM rol WHERE nombre='$rol'")
);
$idRol = $rolQuery['id_rol'];

/* INSERT USUARIO */
mysqli_query($conn,"
INSERT INTO usuario 
(nombre,email,password_hash,telefono,id_rol,estado_activo,token_activacion,token_expira)
VALUES
('$nombre','$email','$passwordHash','$telefono','$idRol',0,'$token','$expira')
");

$idUsuario = mysqli_insert_id($conn);

/* INSERT SEGÚN ROL */
if($rol=="GROOMER"){
    $especialidad = $_POST['especialidad'];
    mysqli_query($conn,"
    INSERT INTO groomer(id_groomer,especialidad,estado_activo)
    VALUES('$idUsuario','$especialidad',1)
    ");
}

if($rol=="RECEPCIONISTA"){
    $turno = $_POST['turno'];
    mysqli_query($conn,"
    INSERT INTO recepcionista(id_recepcionista,turno,activo)
    VALUES('$idUsuario','$turno',1)
    ");
}

echo "Usuario creado. Falta activar vía correo.";
?>