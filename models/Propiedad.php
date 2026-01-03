<?php

namespace Model;
//heredamos la clase de active record
class Propiedad extends ActiveRecord
{
    protected static $tabla = 'propiedades';
    // creamos un arreglo para poder iterrarlos 
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];
    // metodos
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;
    //constructor
    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? '';
        $this->titulo = $args["titulo"] ?? '';
        $this->precio = $args["precio"] ?? '';
        $this->imagen = $args["imagen"] ?? '';
        $this->descripcion = $args["descripcion"] ?? '';
        $this->habitaciones = $args["habitaciones"] ?? '';
        $this->wc = $args["wc"] ?? '';
        $this->estacionamiento = $args["estacionamiento"] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args["vendedores_id"] ?? '';
    }
    public function validar()
    {
        //usamos this porq es parte de la instancia y self porq es un elemento estatico
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un título";
        }
        if (!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
        }
        if (strlen($this->descripcion) < 5) {
            self::$errores[] = "El descripcion es obligatorio y debe tener al menos 35 caracteres";
        }
        if (!$this->habitaciones) {
            self::$errores[] = "El numero de habitaciones es obligatorio";
        }
        if (!$this->wc) {
            self::$errores[] = "El numero de baños es obligatorio";
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "El numero de estacionamiento es obligatorio";
        }
        if (!$this->vendedores_id) {
            self::$errores[] = "El vendedor es obligatorio";
        }
        if (!$this->imagen) {
            self::$errores[] = "La imagen de la propiedad es obligatoria";
        }
        return self::$errores;
    }
}
