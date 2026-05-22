<!-- index.php -->

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>SPA PAW PATROL</title>

    <!-- CSS -->
    <link rel="stylesheet"
    href="assets/css/index.css">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<!-- HEADER -->

<header class="header">

    <!-- LOGO -->

    <div class="logo">

        <h2>

            <i class="fa-solid fa-paw"></i>

            SPA PAW PATROL

        </h2>

    </div>

    <!-- NAV -->

    <nav>

        <a href="#">
            INICIO
        </a>

        <a href="#servicios">
            SERVICIOS
        </a>

        <a href="#nosotros">
            NOSOTROS
        </a>

         <a href="tienda/tienda.php">
            TIENDA
        </a>


        <a href="#contacto">
            CONTACTO
        </a>

    </nav>

    <!-- BOTONES -->

    <div class="buttons-header">

        <!-- LOGIN -->

        <a href="auth/login.php"
        class="btn-login">

            <i class="fa-solid fa-user"></i>

            INICIAR SESION

        </a>

        <!-- REGISTER -->

        <a href="auth/registro.php"
        class="btn-register">

            <i class="fa-solid fa-user-plus"></i>

            REGISTRARSE

        </a>

        <!-- ADMIN -->

        <a href="admin/loginadmin.php"
        class="btn-login">

            <i class="fa-solid fa-shield-dog"></i>

            ADMIN

        </a>

    </div>

</header>

<!-- HERO -->

<section class="hero">

    <div class="hero-overlay">

        <div class="hero-content">

            <h1>

                EL MEJOR CUIDADO PARA TU MASCOTA

            </h1>

            <p>

                AGENDA BAÑOS, CORTES,
                TRATAMIENTOS Y TAMBIEN COMPRA 
                ESPECIALIZADOS PARA TU MASCOTA.

            </p>

            <div class="hero-buttons">

                <!-- CREAR CUENTA -->

                <a href="auth/registro.php"
                class="btn-main">

                    CREAR CUENTA

                </a>

                <!-- LOGIN -->

                <a href="auth/login.php"
                class="btn-secondary">

                    INICIAR SESION

                </a>

            </div>

        </div>

    </div>

</section>

<!-- SERVICIOS -->

<section class="services"
id="servicios">

    <h2>

        NUESTROS SERVICIOS

    </h2>

    <div class="services-container">

        <!-- SERVICIO 1 -->

        <div class="service-card">

            <img
            src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?q=80&w=1200&auto=format&fit=crop"
            alt="Baño y limpieza">

            <div class="service-info">

                <h4>

                    BAÑO Y LIMPIEZA

                </h4>

                <p>

                    Limpieza profesional
                    con productos especializados.

                </p>

            </div>

        </div>

        <!-- SERVICIO 2 -->

        <div class="service-card">

            <img
            src="https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=1200&auto=format&fit=crop"
            alt="Corte de pelo">

            <div class="service-info">

                <h4>

                    CORTE DE PELO

                </h4>

                <p>

                    Grooming profesional
                    para todas las razas.

                </p>

            </div>

        </div>

        <div class="service-card">

            <img
            src="https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=1200&auto=format&fit=crop"
            alt="Corte de pelo">

            <div class="service-info">

                <h4>

                    TRATAMIENTOS

                </h4>

                <p>

                    Grooming profesional
                    para todas las razas.

                </p>

            </div>

        </div>

        <div class="service-card">

            <img
            src="https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=1200&auto=format&fit=crop"
            alt="Corte de pelo">

            <div class="service-info">

                <h5>

                    LIMPIEZA DE DIENTES

                </h5>

                <p>

                    Grooming profesional
                    para todas las razas.

                </p>

            </div>

        </div>

        <div class="service-card">

            <img
            src="https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=1200&auto=format&fit=crop"
            alt="Corte de pelo">

            <div class="service-info">

                <h4>
                    VACUNAS
                </h4>

                <p>

                    Grooming profesional
                    para todas las razas.

                </p>

            </div>

        </div>

        <!-- SERVICIO 3 -->

        <div class="service-card">

            <img
            src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?q=80&w=1200&auto=format&fit=crop"
            alt="Cuidado especial">

            <div class="service-info">

                <h4>
                    CUIDADO ESPECIAL
                </h4>

                <p>

                    Atención personalizada
                    y tratamientos premium.

                </p>

            </div>

        </div>

    </div>

</section>

<!-- NOSOTROS -->

<section class="about"
id="nosotros">

    <!-- IMAGEN -->

   <div class="about-image"> 

    <img src="https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=1200&auto=format&fit=crop" alt="Pet Spa">
 
    </div>

    <!-- TEXTO -->

    <div class="about-text">

        <h2>

            SOBRE NOSOTROS

        </h2>

        <p>

            Somos un spa especializado
            en mascotas, enfocados
            en brindar bienestar,
            higiene y cuidado profesional.

        </p>

        <p>

            Nuestro sistema permite
            gestionar citas, clientes,
            mascotas y servicios
            de manera eficiente.

        </p>

    </div>

</section>

<!-- FOOTER -->

<footer class="footer"
id="contacto">

    <div class="footer-content">

        <!-- INFO -->

        <div>

            <h3>

                SPA PAW PATROL

            </h3>

            <p>

                Sistema Web Profesional
                para spa de mascotas.

            </p>

        </div>

        <!-- CONTACTO -->

        <div>

            <h4>

                Contacto

            </h4>

            <p>

                Email: petspa@gmail.com

            </p>

            <p>

                Teléfono: 77777777

            </p>

        </div>

        <!-- REDES -->

        <div>

            <h4>

                Redes Sociales

            </h4>

            <div class="socials">

                <!-- FACEBOOK -->

                <a href="#">

                    <i class="fa-brands fa-facebook"></i>

                </a>

                <!-- INSTAGRAM -->

                <a href="#">

                    <i class="fa-brands fa-instagram"></i>

                </a>

                <!-- ADMIN FOOTER -->

                <a href="admin/loginadmin.php"
                class="admin-footer-link">

                    <i class="fa-solid fa-shield-dog"></i>

                </a>

            </div>

        </div>

    </div>

    <!-- FOOTER BOTTOM -->

    <div class="footer-bottom">

        © 2026 SPA PAW PATROL
        - Todos los derechos reservados

    </div>

</footer>


<script src="assets/js/index.js"></script>

</body>

</html>