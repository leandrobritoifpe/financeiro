<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @Leandro Brito
 */
class Usuario {

    private $id;
    private $login;
    private $senha;
    private $nome;
    private $foto;
    private $tipo;
    private $exclusaoLogica;
    
    //METODO SET
    public function __set($atrib, $value) {
        $this->$atrib = $value;
    }
    
    //METODO GET
    public function __get($atrib) {
        return $this->$atrib;
    }

}
