<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyExecption
 *
 * @author Dário Nascimento
 */
class MyExecption extends PDOException{
     
    public function erroSql() {
        $errorMsg = 'Erro na linha '.$this->getLine()
        .' em '.$this->getFile()
        .': <b>'.$this->getMessage()
        .'</b> Falha na execução do sql';
        return $errorMsg;
    }
}
