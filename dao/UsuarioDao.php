<?php
ob_start(); 
    session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioDao
 *
 * @author Dário Nascimento
 */
require_once '../util/connectFactory.php';
require_once '../model/Usuario.php';
require_once '../util/MyExecption.php';

class UsuarioDao {

    private $conexao;

    public function abreBanco() {
        try {
            $con = new connectFactory();
            $this->conexao = $con->connectaBanco();
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

    public function salvarUsuario(Usuario $usuario) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO usuarios (nome_usuario,login_usuario,senha,foto,tipo) 
                VALUES (:nome,:login,:senha,:foto,:tipo)");

            $stmt->bindParam(':nome', $usuario->nome);
            $stmt->bindParam(':login', $usuario->login);
            $stmt->bindParam(':senha', $usuario->senha);
            $stmt->bindParam(':foto', $usuario->foto);
            $stmt->bindParam(':tipo', $usuario->tipo);
            $stmt->execute();
            session_start();
            $_SESSION["msg"] = "USUÁRIO CADASTRADO COM SUCESSO";     
            throw new MyExecption();
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    public function validaLogin(Usuario $usuario) {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM usuarios where login_usuario = ? and senha = ? and exclusao_logica = ?;");
            $stmt->bindParam(1, $usuario->login, PDO::PARAM_STR);
            $stmt->bindParam(2, $usuario->senha, PDO::PARAM_STR);
            $stmt->bindParam(3, $usuario->exclusaoLogica, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                session_start();
                $_SESSION["msg"] = "DADOS INCORRETOS";                
                return false;
            } 
                while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                   // session_start();
                    $_SESSION["ID"] = $linha['id_usuario'];
                    $_SESSION["NOME"] = $linha['nome_usuario'];
                    $_SESSION["LOGIN"] = $linha['login_usuario'];
                    $_SESSION["SENHA"] = $linha['senha'];
                    $_SESSION["TIPO"] = $linha['tipo'];
                    $_SESSION["FOTO"] = $linha['foto'];
                    $_SESSION["msg"] = "BEM VINDO"." ".$linha['nome_usuario'];
                    return true;
                
            }
            throw new MyExecption();
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }
    public function verificaSeLoginExiste($email, $zero) {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM usuarios where login_usuario = ? and exclusao_logica = ?;");
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            $stmt->bindParam(2,$zero, PDO::PARAM_INT);
            $stmt->execute();
            if($stmt->rowCount() == 0){
                return false;
            }
            else{
               // session_start();
                $_SESSION["msgError"] = "E-MAIL JÁ CADASTRADO NO SISTEMA";
                return true;
            }
            throw new MyExecption();
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    public function fechaConexao(){
        $this->conexao = null;
    }
}
