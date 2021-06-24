<?php

require_once('conectorBD.php');

class CestaCompra {

    protected $moviles = array();

    // Introduce un nuevo artículo en la cesta de la compra
    public function nuevo_movil($codigoMovil) {
        $movil = conectorBD::obtenerMovil($codigoMovil);
        //Mete en el array de productos un nuevo producto
        $this->moviles[] = $movil;
    }

    // Obtiene los artículos en la cesta
    public function get_moviles() {
        return $this->moviles;
    }

    // Obtiene el coste total de los artículos en la cesta
    public function get_coste() {
        $coste = 0;
        foreach ($this->moviles as $movil)
            $coste += $movil->getprecio();
        return $coste;
    }

    // Devuelve true si la cesta está vacía
    public function esta_vacia() {
        if (count($this->moviles) == 0)
            return true;
        return false;
    }

    // Guarda la cesta de la compra en la sesión del usuario
    public function guardar_cesta() {
        $_SESSION['cesta'] = $this;
    }

    // Recupera la cesta de la compra almacenada en la sesión del usuario
    public static function cargar_cesta() {
        if (!isset($_SESSION['cesta']))
            return new CestaCompra();
        else
            return $_SESSION['cesta'];
    }

}

?>