<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
//creamos al controlador de propiedades
class PropiedadController
{
    //creamos el motodo index static para poder llamarlo sin instanciar la clase
    //recibe como parametro el objeto router para poder usarlo dentro del metodo, este objeto es pasado desde el metodo comprobarRutas del router
    public static function index(Router $router)
    {
        //del modelo propiedad traemos todas las propiedades
        $propiedades = Propiedad::all();
        $resultado = Null;
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            debugear("hola");
        }
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores
        ]);
    }
    public static function actualizar(Router $router)
    {
        echo "actualizar";
    }
}
