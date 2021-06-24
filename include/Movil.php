<?php

class Movil {

    protected $codigo;
    protected $nombre;
    protected $precio;

    public function getcodigo() {
        return $this->codigo;
    }

    public function getnombre() {
        return $this->nombre;
    }

    public function getprecio() {
        return $this->precio;
    }

    public function __construct($row) {
        $this->codigo = $row['codMovil'];
        $this->nombre = $row['nombre'];
        $this->precio = $row['precio'];
    }

}
