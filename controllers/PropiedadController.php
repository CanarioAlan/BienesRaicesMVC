<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;
//creamos al controlador de propiedades
class PropiedadController
{
    //creamos el motodo index static para poder llamarlo sin instanciar la clase
    //recibe como parametro el objeto router para poder usarlo dentro del metodo, este objeto es pasado desde el metodo comprobarRutas del router
    public static function index(Router $router)
    {
        //del modelo propiedad traemos todas las propiedades
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::All();
        $resultado = $_GET['resultado'] ?? null;
        //llamamos al metodo render del router para mostrar la vista y le pasamos el nombre de la vista
        $router->render('propiedades/admin', [
            //pasamos un arreglo asociativo con los datos que queremos enviar a la vista
            "propiedades" => $propiedades,
            "resultado" => $resultado,
            "vendedores" => $vendedores
        ]);
    }
    public static function crear(Router $router)
    {
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $propiedad = new Propiedad($_POST['propiedad']);
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);
            }
            $errores = $propiedad->validar();
            if (empty($errores)) {
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                $image->save(CARPETA_IMAGENES . $nombreImagen);
                $propiedad->guardar();
            }
        }
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router)
    {
        //creamos una funcion para validar el id y redireccionar en caso de no ser valido
        //llamamos a la funcion validaRedireccionar y le pasamos la url a la que redireccionar en caso de no ser valido
        $id = validaRedireccionar('/admin');
        $propiedad = Propiedad::propFiltrada($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args);
            $errores = $propiedad->validar();
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            $imagen = null;
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);
            }
            if (empty($errores)) {
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $propiedad->guardar();
            }
        }
        $router->render('/propiedades/actualizar', [
            "propiedad" => $propiedad,
            'vendedores' => $vendedores,
            "errores" => $errores
        ]);
    }
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $tipo =  $_POST['tipo'];
                if (validarContenido($tipo)) {
                    $propiedad = Propiedad::propFiltrada($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}
