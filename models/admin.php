<?php

namespace Model;

class Admin extends ActiveRecord
{
    //base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;
    public function __construct($args)
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }
    public function validar()
    {
        if (!$this->email) {
            self::$errores[] = "El email es obligatorio";
        }
        if (!$this->password) {
            self::$errores[] = "El email es obligatorio";
        }
        return self::$errores;
    }
    public function existeUsuario()
    {
        //podemos usar this porq ya instanciamos y lo tenemos en memeria a lo que escribio el usuario
        //revisar si el usuario existe
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        if (!$resultado->num_rows) {
            self::$errores[] = "El usuario no existe";
            return;
        }
        return $resultado;
    }
    public function comprobarPassword($resultado)
    {
        $usuario = $resultado->fetch_object();
        //password_verify verifica si la contraseña coinciden, pasando primero la contraseña que paso el usuario y depsues lo que tenemos en la base de datos
        $autenticado = password_verify($this->password, $usuario->password);
        if (!$autenticado) {
            self::$errores[] = "La contraseña no es correcta";
        }
        return $autenticado;
    }
    public function autenticar()
    {
        session_start();
        //llenamos el arreglo de session
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;
        header("Location: /admin");
    }
}
