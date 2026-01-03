<?php
// verificamos si la sesion ya esta iniciada para evitar errores
if (!isset($_SESSION)) {
    //si no esta iniciada la iniciamos
    session_start();
}
$auth = $_SESSION['login'] ?? false;
if (!isset($inicio)) {
    $inicio = false;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="../build/css/app.css">
</head>

<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''  ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="../Index.php">
                    <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>
                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono de munu responsivo">
                </div>
                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="icono de dark mode">
                    <nav class="navegacion">
                        <a href="Nosotros.php">Nosotros</a>
                        <a href="Anuncios.php">Anuncios</a>
                        <a href="Blog.php">Blog</a>
                        <a href="Contacto.php">Contactos</a>
                        <!-- creamos un elemento validando si existe una sesion activa -->
                        <?php if ($auth) : ?>
                            <a href="cerrarSesion.php">Cerrar Sesión</a>
                        <?php else: ?>
                            <a href="login.php">Iniciar Sesión</a>
                        <?php endif; ?>
                    </nav>
                    <!-- cierra el div barra -->
                </div>
            </div>
            <?php echo $inicio ? '<h1>Venta de Casas y Departamento Exclusivos de Lujo</h1>' : "" ?>
        </div>
    </header>
    <?php echo $contenido; ?>
    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="Nosotros.php">Nosotros</a>
                <a href="Anuncios.php">Anuncios</a>
                <a href="Blog.php">Blog</a>
                <a href="Contacto.php">Contactos</a>
            </nav>
            <p class="copyright">Todos los derechos Reservados <?php echo date('Y') ?> &copy;</p>
        </div>
    </footer>
    <script src="../build/js/bundle.min.js"></script>
</body>

</html>