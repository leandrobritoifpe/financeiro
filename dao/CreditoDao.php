<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreditoDao
 *
 * @author Dário Nascimento
 */
class CreditoDao {

    private $conexao;

    public function abreBanco() {
        try {
            $con = new connectFactory();
            $this->conexao = $con->connectaBanco();
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

    public function fechaConexao() {
        $this->conexao = null;
    }

    public function salvarCredito(Credito $credito) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO credito (descricao_credito,valor_credito,data_credito,id_usuario_fk,valor_credito_atual) 
                VALUES (:descricao,:valor,:data,:usuario,:creditoAtual)");

            $stmt->bindParam(':descricao', $credito->descricao);
            $stmt->bindParam(':valor', $credito->valor);
            $stmt->bindParam(':data', $this->dataConverter($credito->data));
            $stmt->bindParam(':usuario', $credito->usuario);
            $stmt->bindParam(':creditoAtual', $credito->valor);
            $stmt->execute();

            //session_start();
            $_SESSION["msg"] = "CREDITO CADASTRADO COM SUCESSO";
            header("Location: ../home.php");
            throw new MyExecption();
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    public function listaCredito($dataInicial, $dataFinal, $idUser) {
        try {
            $listaCredito = array();
            $stmt = @$this->conexao->prepare("SELECT * FROM credito where id_usuario_fk= ? and exclusao_logica = 0 and data_credito between ? and ?;");
            $stmt->bindParam(1, $idUser, PDO::PARAM_INT);
            @$stmt->bindParam(2, @$this->dataConverter($dataInicial), PDO::PARAM_STR);
            @$stmt->bindParam(3, @$this->dataConverter($dataFinal), PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                $listaCredito = 0;
                return $listaCredito;
            }
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $credito = new Credito();
                $credito->id = $linha['id_credito'];
                $credito->descricao = $linha['descricao_credito'];
                $credito->data = $linha['data_credito'];
                $credito->valor = $linha['valor_credito'];
                $credito->valorAtual = $linha['valor_credito_atual'];
                $credito->usuario = $linha['id_usuario_fk'];
                $listaCredito[] = $credito;
            }
            return $listaCredito;
            
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }
    public function listaCreditoId($idCredito,$idUser) {
        try {                
            $stmt = @$this->conexao->prepare("SELECT * FROM credito where id_usuario_fk= ? and exclusao_logica = 0 and id_credito = ?;");
            $stmt->bindParam(1, $idUser, PDO::PARAM_INT);
            $stmt->bindParam(2, $idCredito, PDO::PARAM_INT);
            $stmt->execute();
            $creditoCompleto = 0;
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $credito = new Credito();
                $credito->id = $linha['id_credito'];
                $credito->descricao = $linha['descricao_credito'];
                $credito->data = $linha['data_credito'];
                $credito->valor = $linha['valor_credito'];
                $credito->valorAtual = $linha['valor_credito_atual'];
                $credito->usuario = $linha['id_usuario_fk'];
                $creditoCompleto = $credito;
            }
            return $creditoCompleto;
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }
    public function atualizarCredito(Credito $credito) {
        try {
            $this->conexao->beginTransaction();
            
            $stmt = $this->conexao->prepare("UPDATE credito set descricao_credito = ?, valor_credito = ?, valor_credito_atual = ?, data_credito = ? where id_usuario_fk = ? and id_credito = ?;");
            @$stmt->bindParam(1, @$credito->descricao, PDO::PARAM_STR);
            @$stmt->bindParam(2, @$credito->valor, PDO::PARAM_STR);
            @$stmt->bindParam(3, @$credito->valorAtual, PDO::PARAM_STR);
            @$stmt->bindParam(4, @$this->dataConverter($credito->data), PDO::PARAM_STR);
            @$stmt->bindParam(5, @$credito->usuario, PDO::PARAM_INT);
            @$stmt->bindParam(6, @$credito->id, PDO::PARAM_INT);
            $stmt->execute();           
            if (!$stmt->execute()) {        
                $this->conexao->rollBack();                
                 throw new MyExecption(); 
           }
           else{
               $this->conexao->commit();
              return true; 
          }   
            
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    public function deletarCredito($idCredito,$idUser) {
        try {
            //echo $idUser;
            
            $this->conexao->beginTransaction();
            
            $stmt = $this->conexao->prepare("UPDATE credito set exclusao_logica = 1 where id_credito = ? and id_usuario_fk = ?;");
            $stmt->bindParam(1, $idCredito, PDO::PARAM_INT);
            $stmt->bindParam(2, $idUser, PDO::PARAM_INT);
            $stmt->execute();
            
            $stmt = $this->conexao->prepare("UPDATE debitos set exclusao_logica = 1 where id_credito_fk = ?");           
            $stmt->bindParam(1, $idCredito, PDO::PARAM_INT);           
            $stmt->execute();
                  
            
         if (!$stmt->execute()) {        
                $this->conexao->rollBack();                
                 throw new MyExecption(); 
           }
           else{
               $this->conexao->commit();
              return true; 
          }    
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }
    private function dataConverter($_date = null) {
        $format = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/';
        if ($_date != null && preg_match($format, $_date, $partes)) {
            return $partes[3] . '-' . $partes[2] . '-' . $partes[1];
        }
        return false;
    }

}
