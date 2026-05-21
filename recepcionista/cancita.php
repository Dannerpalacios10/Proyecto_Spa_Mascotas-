<?php

session_start();

include("../config/database.php");

/** @var mysqli $conn */

if(!isset($_GET['id'])){
    header("Location: recepcionista.php");
    exit();
}

$id = intval($_GET['id']);

$sql = "
UPDATE cita
SET estado='CANCELADA'
WHERE id_cita='$id'
";

mysqli_query($conn,$sql);

$_SESSION['success'] =
"Cita cancelada correctamente.";

header("Location: recepcionista.php");
exit();

?>