<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController
{
    public static function crear(Router $router)
    {
        $vendedor = new Vendedor();
        $errores = Vendedor::getErrores();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vendedor = new Vendedor($_POST['vendedor']);
            $errores = $vendedor->validar();
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }
        $router->render('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router)
    {
        $id = validaRedireccionar('/admin');
        $vendedor = Vendedor::propFiltrada($id);
        $errores = Vendedor::getErrores();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //asignar los valores
            $args = $_POST['vendedor'];
            $vendedor->sincronizar($args);
            //validacion
            $errores = $vendedor->validar();
            if (empty($errores)) {
                $vendedor->guardar();
                header('Location: /admin?resultado=2');
            }
        }
        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
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
                    $vendedor = Vendedor::propFiltrada($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}
