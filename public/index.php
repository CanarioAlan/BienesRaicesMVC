<?php
//en el archivo composer.json definimos el nuevo namespace Model que apunta a la carpeta models, mvc a la raiz y controllers a la carpeta controllers
//en el archivo gulpfile cambiamos la ubiciacion del archivo de salida del build a la carpeta public
//este archivo es el punto de entrada de la aplicacion
// usamos require_once para asegurarnos que solo se incluya una vez
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
//importamos los controladores que usaremos
use Controllers\PropiedadController;

$router = new Router();
// se llama al metodo get del router para registrar una nueva ruta y se pasa la url y la funcion que se ejecutara esta esta asociada a un controlador
$router->get('/admin', [PropiedadController::class, 'index']);
$router->get('/propiedades/crear', [PropiedadController::class, 'crear']);
$router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
//registramos la ruta post para crear una nueva propiedad y darle soporte al metodo post
$router->post('/propiedades/crear', [PropiedadController::class, 'crear']);
$router->post('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/propiedades/eliminar', [PropiedadController::class, 'eliminar']);
//definimos las rutas de la aplicacion
$router->comprobarRutas();
