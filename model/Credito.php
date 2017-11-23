<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Credito
 *
 * @author Dário Nascimento
 */
class Credito {

    private $descricao;
    private $id;
    private $valor;
    private $data;
    private $usuario;
    private $valorAtual;

    //METODO SET
    public function __set($atrib, $value) {
        $this->$atrib = $value;
    }

    //METODO GET
    public function __get($atrib) {
        return $this->$atrib;
    }

}
