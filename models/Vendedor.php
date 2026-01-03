<?php

namespace Model;

class Vendedor extends ActiveRecord
{
    protected static $tabla = 'vendedores';
    // creamos un arreglo para poder iterrarlos 
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];
    // metodos
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    //constructor
    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? '';
        $this->nombre = $args["nombre"] ?? '';
        $this->apellido = $args["apellido"] ?? '';
        $this->telefono = $args["telefono"] ?? '';
    }
    public function validar()
    {
        //usamos this porq es parte de la instancia y self porq es un elemento estatico
        if (!$this->nombre) {
            self::$errores[] = "Debes añadir un nombre";
        }
        if (!$this->apellido) {
            self::$errores[] = "Debes añadir un apellido";
        }
        if (!$this->telefono) {
            self::$errores[] = "Debes añadir un teléfono";
        }
        // validar el formato del telefono con expresion regular
        if (!preg_match('/[0-9]{10}/', $this->telefono)) {
            self::$errores[] = "Formato de teléfono no válido. debe tener 10 dígitos y ser solo números";
        }
        return self::$errores;
    }
};
