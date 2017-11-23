<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Debito
 *
 * @author Dário Nascimento
 */
class Debito {

    private $id;
    private $descricao;
    private $valor;
    private $credito;
    private $data;
    private $usuario;
    private $idCred;

    //METODO SET
    public function __set($atrib, $value) {
        $this->$atrib = $value;
    }

    //METODO GET
    public function __get($atrib) {
        return $this->$atrib;
    }

}
