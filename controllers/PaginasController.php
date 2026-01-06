<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {
        $router->render('paginas/index', [
            'propiedades' => Propiedad::get(3),
            'inicio' => true
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }
    public static function anuncios(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('paginas/anuncios', [
            'propiedades' => $propiedades
        ]);
    }
    public static function anuncio(Router $router)
    {
        $id = validaRedireccionar('/anuncios');
        $propiedad = Propiedad::propFiltrada($id);
        $router->render('paginas/anuncio', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog');
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router)
    {
        $mensaje  = null;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $repuesta = $_POST['contacto'];
            //configurar y enviar el email
            $phpmailer = new PHPMailer();
            //protocolo smtp que se usa para enviar emails
            $phpmailer->isSMTP();
            //configuracion del servidor smtp
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            //habilitar autenticacion smtp
            $phpmailer->SMTPAuth = true;
            //puerto smtp seguro para mailtrap
            $phpmailer->Port = 2525;
            //credenciales de mailtrap
            $phpmailer->Username = "";
            $phpmailer->Password = '';
            //tipo de encriptacion
            $phpmailer->SMTPSecure = 'tls';
            //conteneido del email
            $phpmailer->setFrom('admin@bienesraices.com');
            $phpmailer->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            //el subject del email es lo primero que se ve
            $phpmailer->Subject = 'Tienes un nuevo mensaje';
            //habilitar formato html
            $phpmailer->isHTML(true);
            //es para habilitar los acentos y caracteres especiales
            $phpmailer->CharSet = 'UTF-8';
            $conteneido = '<html>';
            $conteneido .= '<p>Tienes un nuevo mensaje</p>';
            $conteneido .= '<p>Nombre: ' . $repuesta['nombre'] . '</p>';
            //añadimos tipo de contacto dependiendo lo que elegio el usuario
            if ($repuesta['contacto'] === "telefono") {
                $conteneido .= '<p>Eligió ser contactado por Teléfono</p>';
                $conteneido .= '<p>Telefono: ' . $repuesta['telefono'] . '</p>';
                $conteneido .= '<p>y desa ser llamado en esta fecha y horario</p>';
                $conteneido .= '<p>Fecha: ' . $repuesta['fecha'] . '</p>';
                $conteneido .= '<p>Hora: ' . $repuesta['hora'] . '</p>';
            } else {
                $conteneido .= '<p>Eligio ser contactado por Email</p>';
                $conteneido .= '<p>Email: ' . $repuesta['email'] . '</p>';
            }
            $conteneido .= '<p>vende o compra: ' . $repuesta['tipo'] . '</p>';
            $conteneido .= '<p>Prefiere ser contactado por: ' . $repuesta['contacto'] . '</p>';
            $conteneido .= '<p>Precio o presupuesto $: ' . $repuesta['precio'] . '</p>';
            $conteneido .= '</html>';
            $phpmailer->Body = $conteneido;
            $phpmailer->AltBody = "esto es sin html";
            //enviar el correo
            if ($phpmailer->send()) {
                $mensaje = 'Mensaje enviado correctamente';
            } else {
                $mensaje = 'El mensaje no se pudo enviar';
            }
        }
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje,
        ]);
    }
    public static function iniciarSesion(Router $router)
    {
        $router->render('paginas/iniciarSesion');
    }
}
