<?php

namespace Model;


class ActiveRecord
{
    //la conexion a la base de datos en portected para que solo acedamos desde la clase y static ya que es la misma conexion
    protected static $db;
    // creamos un arreglo para poder iterrarlos, sera definido en cada clase hija
    protected static $columnasDB = [];
    // creamos una propiedad estatica para la tabla y que sera definida en cada clase hija
    protected static $tabla = '';
    //sera protected ya que es la clase la que dira si ahi o no errores 
    protected static $errores = [];

    //definiendo la conexion a la base de datos
    public static function setDB($database)
    {
        //con selft accedemos a la propiedad estatica de la clase y aca si se coloca el $ a diferencia de cuando usamos this
        self::$db = $database;
    }
    //al llamar el metodo guardar este detecta si existe o no un id para llamar el metodo correspondiente. al crear no existiria id y se llamaria crear, al actualizar si existiria id y se llamaria actualizar
    public function guardar()
    {
        if (!empty($this->id)) {
            //llamamos a actualizar
            $this->actualizar();
        } else {
            $this->crear();
        }
    }
    public function crear()
    {
        //para llamar un metodo dentro de otro es this->nombre()
        //sanetizar los datos enviados
        $atributos = $this->sanitizarAtributos();
        //lo que hacemos es usar join que se encarga agarrar un arreglo y combertirlo en string usando comillas sensillas '' dentor con que lo vamos a separar
        // y array_keys es la funcion que extrae solo las llaves del arreglo. por lo tanto extraemos las llaves del arreglo y despues lo convertimos en un simple string con el join separado por ,  y un espacio
        $stringKeys = join(', ', array_keys($atributos));
        $stringValue = join("', '", array_values($atributos));
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= $stringKeys;
        $query .= " ) VALUES (' ";
        $query .= $stringValue;
        $query .= " ') ";
        $resultado = self::$db->query($query);
        if ($resultado) {
            header('Location: /admin?resultado=1');
        }
    }
    public function actualizar()
    {
        $atributos = $this->sanitizarAtributos();
        //recorre los valores en memoria y los une con lo que viene de la base de datos
        $valor = [];
        foreach ($atributos as $key => $value) {
            //esto nos deberia de dejar un codigo muy similar al de update, se procede ha utulizar join
            $valores[] = "{$key}='{$value}'";
        }
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .=  join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= "LIMIT 1";
        $resultado = self::$db->query($query);
        if ($resultado) {
            header('Location: /admin?resultado=2');
        }
    }
    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        if ($resultado) {
            $this->borrarImagen();
            //redireccionar al usuario
            header('Location: /admin?resultado=3');
        }
    }
    // en este metodo identificamos y unimos los atributos de la db 
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            //con esto hacemos que el cuando itere en el id lo saltee y no lo mapee ya que nos puede ocacionar problemas si lo ingresamos o sanetizamos y tambien porq aun no existe
            if ($columna === 'id') continue;
            //lo que hacemos es unir los atributos con lo datos del objeto
            //y en this->$columna aca accedemos con $ porq es una variable y no un atributo
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        // es inportante hacer el recorrido manteniendo el arreglo de forma asociativo
        foreach ($atributos as $key => $value) {
            // llamamos al arreglo sanetizado y le asignamos la llave y sanetizamos el valor
            //sanetizamos el valor con el atributo de escape_string
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
    //validaciones
    public static function getErrores()
    {
        return static::$errores;
    }
    public function validar()
    {
        //reiniciamos el arreglo de errores
        static::$errores = [];
        return static::$errores;
    }
    public function setImagen($imagen)
    {
        //validamos si existe un id 
        if (isset($this->id)) {
            // verificamos si existe dicho archivo, pasando la ubicacion y el nombre
            $this->borrarImagen();
        }
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }
    public function borrarImagen()
    {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }
    //traemos todas los registros
    public static function All()
    {
        //en static hace referencia a la clase que lo llama si usariamos self siempre haria referencia a la clase padre
        $query = "SELECT * FROM " . static::$tabla . ";";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    //trae la cantidad de registros que le pedimos
    public static function get($cantidad)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad . ";";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    //filtra la propiedad por su idd
    public static function propFiltrada($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id};";
        $resultado = self::consultarSQL($query);
        //el array shift muestra solo el primer elemento de un arreglo
        return array_shift($resultado);
    }
    public static function consultarSQL($query)
    {
        //consultar la base de datos
        $resultado = self::$db->query($query);
        //iterrar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObj($registro);
        }
        //liberar memoria ayuda en el perfomace
        $resultado->free();
        //retornar los resultados
        return $array;
    }
    protected static function crearObj($registro)
    {
        //crea un nuevo objeto gracias a la claseactual
        $objeto = new static;
        foreach ($registro as $key => $value) {
            //lo que hacemos es comprar si en el objeto tiene un valor igual al de key se introduzca el valor
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
    //sincromizaops el onjeto en memoria con los cmabios realizados en actualizar
    //se encarga de leer el post  y reescribe las que fueron editadas
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
