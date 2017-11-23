<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VerificaVariavelFuncao
 *
 * @author
 */
class VerificaVariavelFuncao {
    private $funcao;

    public function verificaVariavelFuncao() {
        if (isset($_GET["funcao"]) || isset($_POST["funcao"])) {
            if (isset($_GET["funcao"])) {
                $this->funcao = $_GET["funcao"];
            } else {
                $this->funcao = $_POST["funcao"];
            }
            return $this->funcao;
        }
        else{
            header("Location: ../home.php");
        }
    }
}
