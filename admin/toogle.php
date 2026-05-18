<?php
session_start();
include("../config/database.php");

if(!isset($_GET['id'])){
    die("ID no válido");
}

$id = intval($_GET['id']);

// Verificar que el usuario exista
$consulta = mysqli_query($conn, "SELECT estado_activo FROM usuario WHERE id_usuario = $id");

if(mysqli_num_rows($consulta) == 0){
    die("Usuario no encontrado");
}

$usuario = mysqli_fetch_assoc($consulta);

// Cambiar estado automáticamente
$nuevo_estado = ($usuario['estado_activo'] == 1) ? 0 : 1;

// Actualizar
$update = mysqli_query($conn, "
    UPDATE usuario 
    SET estado_activo = $nuevo_estado 
    WHERE id_usuario = $id
");

if($_SESSION['id_usuario'] == $id){
    die("No puedes desactivar tu propia cuenta");
}

if($update){
    header("Location: ver_personal.php");
    exit();
}else{
    echo "Error al actualizar: " . mysqli_error($conn);
}
?>