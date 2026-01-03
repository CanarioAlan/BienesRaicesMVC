<?php

namespace MVC;

class Router
{
    //definimos dos arregglos para guardar las rutas GET y POST, las almacenamos de esta manera para facilitar depsues cuando usemos una funcion que toma solo arreglos como parametro
    public $rutasGET = [];
    public $rutasPOST = [];
    //metodo para registrar los endpoints de tipo GET

    public function get($url, $fn)
    {
        //asignamos a la posicion del arreglo correspondiente a la url la funcion que se ejecutara cuando se acceda a esa ruta 
        $this->rutasGET[$url] = $fn;
    }
    public function post($url, $fn)
    {
        //asignamos a la posicion del arreglo correspondiente a la url la funcion que se ejecutara cuando se acceda a esa ruta 
        $this->rutasPOST[$url] = $fn;
    }
    //aca validaremos las rutas y los requests mettods (GET, POST, etc)
    public function comprobarRutas()
    {
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];
        if ($metodo === 'GET') {
            //asignamos a la variable fb a la funcion que corresponde a la ruta y si no existe asignamos un null
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            //al ser otro metodo (POST) asignamos la funcion correspondiente a la ruta
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }
        if ($fn) {
            //usamos call_user_func para llamar a la funcion que corresponde a la ruta
            //le pasamos tanto la funcion como el objeto router para que pueda ser usado dentro de la funcion ya q no sabremos si es post o get
            call_user_func($fn, $this);
        } else {
            // podemos redirigir a una pagina de error 404
            echo "pagina no encontrada";
        }
    }
    //muestra la vista
    public function render($view, $datos = [])
    {
        //recorremos el arreglo de datos y creamos variables con el nombre de la llave y le asignamos el valor correspondiente
        foreach ($datos as $key => $value) {
            //colocamos dos signos de dolar para crear variables dinamicamente
            $$key = $value;
        }
        //iniciamos un almacenamiento en memoria temporal
        ob_start();
        include __DIR__ . "/views/$view.php";
        //almacenamos en una variable el contenido que se genero en memoria
        $contenido = ob_get_clean();
        //incluimos el layout donde mostramos el contenido
        include __DIR__ . "/views/layout.php";
    }
}
