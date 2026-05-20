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

$idGroomer = $_SESSION['id_usuario'];
$nombre = $_SESSION['nombre'];

/* ===================================== */
/* FILTRO */
/* ===================================== */

$filtro = isset($_GET['filtro'])
? $_GET['filtro']
: 'HOY';

/* ===================================== */
/* CONSULTA */
/* ===================================== */

$whereFecha = "";

if($filtro == "HOY"){

    $whereFecha =
    "AND DATE(cita.fecha_inicio)=CURDATE()";

}
elseif($filtro == "SEMANA"){

    $whereFecha =
    "AND YEARWEEK(cita.fecha_inicio,1)=YEARWEEK(CURDATE(),1)";
}

/* ===================================== */
/* CITAS */
/* ===================================== */

$sql = "
SELECT

cita.*,

mascota.nombre AS mascota_nombre,
mascota.raza,
mascota.tamano,

servicio.nombre AS servicio_nombre,

usuario.nombre AS cliente_nombre

FROM cita

INNER JOIN mascota
ON cita.id_mascota = mascota.id_mascota

INNER JOIN servicio
ON cita.id_servicio = servicio.id_servicio

INNER JOIN usuario
ON mascota.id_cliente = usuario.id_usuario

WHERE cita.id_groomer='$idGroomer'

$whereFecha

ORDER BY cita.fecha_inicio ASC
";

$citas = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Agenda Groomer
</title>

<link
rel="stylesheet"
href="../groomer/css/agenda.css">

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

                <a href="groomer.php">

                    <i class="fa-solid fa-house"></i>

                    <span>
                        Dashboard
                    </span>

                </a>

            </li>

            <li class="active">

                <a href="agenda.php">

                    <i class="fa-solid fa-calendar-days"></i>

                    <span>
                        Agenda
                    </span>

                </a>

            </li>

            <li>

                <a href="#">

                    <i class="fa-solid fa-clipboard-list"></i>

                    <span>
                        Fichas
                    </span>

                </a>

            </li>

            <li>

                <a href="#">

                    <i class="fa-solid fa-box-open"></i>

                    <span>
                        Insumos
                    </span>

                </a>

            </li>

            <li>

                <a href="../auth/logout.php">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    <span>
                        Cerrar Sesión
                    </span>

                </a>

            </li>

        </ul>

    </div>

    <!-- MAIN -->

    <div class="main-content">

        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h1>
                    Agenda Groomer
                </h1>

                <p>
                    Gestiona tus servicios asignados.
                </p>

            </div>

        </div>

        <!-- FILTROS -->

        <div class="filters">

            <a
            href="?filtro=HOY"
            class="<?php echo ($filtro=='HOY') ? 'active-filter' : ''; ?>">

                Hoy

            </a>

            <a
            href="?filtro=SEMANA"
            class="<?php echo ($filtro=='SEMANA') ? 'active-filter' : ''; ?>">

                Semana

            </a>

        </div>

        <!-- TABLA -->

        <div class="table-card">

            <div class="table-header">

                <h2>
                    Servicios Asignados
                </h2>

            </div>

            <table>

                <thead>

                    <tr>

                        <th>Hora</th>
                        <th>Mascota</th>
                        <th>Raza</th>
                        <th>Tamaño</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Estado</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    while($c = mysqli_fetch_assoc($citas)){
                    ?>

                    <tr>

                        <td>

                            <?php
                            echo date(
                                "d/m/Y H:i",
                                strtotime($c['fecha_inicio'])
                            );
                            ?>

                        </td>

                        <td>

                            <?php
                            echo $c['mascota_nombre'];
                            ?>

                        </td>

                        <td>

                            <?php
                            echo $c['raza'];
                            ?>

                        </td>

                        <td>

                            <?php
                            echo $c['tamano'];
                            ?>

                        </td>

                        <td>

                            <?php
                            echo $c['cliente_nombre'];
                            ?>

                        </td>

                        <td>

                            <?php
                            echo $c['servicio_nombre'];
                            ?>

                        </td>

                        <td>

                            <span class="status <?php echo strtolower($c['estado']); ?>">

                                <?php
                                echo $c['estado'];
                                ?>

                            </span>

                        </td>

                        <td class="actions">

                            <!-- INICIAR -->

                            <?php if(
                            $c['estado'] == 'CONFIRMADA'
                            ||
                            $c['estado'] == 'AGENDADA'
                            ){ ?>

                            <a
                            href="iniciar_servicio.php?id=<?php echo $c['id_cita']; ?>"
                            class="btn start">

                                <i class="fa-solid fa-play"></i>

                                Iniciar

                            </a>

                            <?php } ?>

                            <!-- FICHA -->

                            <?php
                            while($c = mysqli_fetch_assoc($citas)){
                            ?>

                            <tr>

                            <td>
                            <?php echo $c['mascota_nombre']; ?>
                            </td>

                            <td>
                            <?php echo $c['servicio_nombre']; ?>
                            </td>

                            <td>
                            <?php echo $c['estado']; ?>
                            </td>

                            <td>

                            <a
                            href="ficha.php?id=<?php echo $c['id_cita']; ?>"
                            class="btn-ficha">

                            Abrir Ficha

                            </a>

                            </td>

                            </tr>

                            <?php } ?>

                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>