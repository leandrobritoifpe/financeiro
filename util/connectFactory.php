<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of connectFactory
 *
 * @Leandro Brito
 */
class connectFactory {

    public function connectaBanco() {
        $servername = "localhost";
        $username = "id3144935_leandrobritocorreia";
        $password = "root0840";

        try {
            $conexao = new PDO("mysql:host=$servername;dbname=id3144935_financeiro", $username, $password);
            // set the PDO error mode to exception
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $conexao;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

}
