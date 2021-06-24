<?php

require_once('Movil.php');

// Clase para conectar a la base de datos. Requiere Producto.php porque declara objetos de ese
// tipo.
class conectorBD {

    //Funcion estatica para ejecutarConsultas
    protected static function ejecutarConsulta($sql) {
        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn = "mysql:host=localhost;dbname=tiendamoviles";
        $usuario = 'root';
        $contrasena = '';

        //Primero conectamos a la base de datos
        try {
            $dwes = new PDO($dsn, $usuario, $contrasena, $opc);
            $resultado = null;
            //Si se consigue conexion
            if (isset($dwes))
            //Almacenamos consulta en resultado
                $resultado = $dwes->query($sql);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
        //Devolvemos las consultas. De aqui se deben extraer las filas.
        return $resultado;
    }

    //Funcion para obtener los productos y sus características.
    public static function obtenerMoviles() {
        //Variable con el script de la consulta
        $sql = "SELECT codMovil, nombre, precio FROM catalogo;";

        //Llamamos a la funcion de arriba que devuelve en $resultado las filas.
        $resultado = self::ejecutarConsulta($sql);

        //Declaramos array de productos.
        $moviles = array();

        //Si hay filas
        if ($resultado) {
            // Añadimos un elemento por cada producto obtenido
            $row = $resultado->fetch();

            while ($row != null) {
                //Metemos en el array obtemos de clase producto(cod,nombre,nombreCorto, PVP)
                $moviles[] = new Movil($row);
                $row = $resultado->fetch();
            }
        }
        return $moviles;
    }

    //Funcion que extrae un producto a partir de su codigo (PK)
    public static function obtenerMovil($codigoMovil) {
        //Sacamos toda al info del producto pasando el $codigo como parametro.
        $sql = "SELECT codMovil, nombre, precio FROM catalogo";
        $sql .= " WHERE codMovil='" . $codigoMovil . "'";
        $resultado = self::ejecutarConsulta($sql);
        $movil = null;

        if (isset($resultado)) {
            $row = $resultado->fetch();
            //Devolvemos objeto producto.
            $movil = new Movil($row);
        }
        return $movil;
    }

    //Funcion Para realizar el login
    public static function verificarCliente($nombre, $contrasena) {

        $sql = "SELECT usuario FROM usuarios WHERE usuario='$nombre' AND contraseña='$contrasena'";
        echo $sql;
        $resultado = self::ejecutarConsulta($sql);
        $verificado = false;

        if (isset($resultado)) {
            // Si existen filas con los parametros identicos a los pasados, es que 
            // el usuario y la contraseña coinciden con los introducidos con el usuario
            //(En la base de datos los usuarios son unicos)
            $fila = $resultado->fetch();
            if ($fila !== false)
                $verificado = true;
        }
        return $verificado;
    }

}
