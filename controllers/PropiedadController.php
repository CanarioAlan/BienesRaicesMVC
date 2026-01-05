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
        $resultado = $_GET['resultado'] ?? null;
        //llamamos al metodo render del router para mostrar la vista y le pasamos el nombre de la vista
        $router->render('propiedades/admin', [
            //pasamos un arreglo asociativo con los datos que queremos enviar a la vista
            "propiedades" => $propiedades,
            "resultado" => $resultado,
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
            // debugear(CARPETA_IMAGENES);
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
        echo "actualizar";
    }
}
