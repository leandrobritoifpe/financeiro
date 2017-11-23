<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DebitoDao
 *
 * @author Dário Nascimento
 */
class DebitoDao {

    private $conexao;

    public function abreBanco() {
        try {
            $con = new connectFactory();
            $this->conexao = $con->connectaBanco();
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

    public function salvarDebito(Debito $debito) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO debitos (descricao_debito,valor_debito,data_debito,id_credito_fk,id_usuario_fk) 
                VALUES (:descricao,:valor,:data,:credito,:usuario)");

            $stmt->bindParam(':descricao', $debito->descricao);
            $stmt->bindParam(':valor', $debito->valor);
            $stmt->bindParam(':data', $this->dataConverter($debito->data));
            $stmt->bindParam(':credito', $debito->credito);
            $stmt->bindParam(':usuario', $debito->usuario);
            $stmt->execute();

            $stmt = $this->conexao->prepare("UPDATE credito set valor_credito_atual = valor_credito_atual - ? where id_credito = ?;");
            $stmt->bindParam(1, $debito->valor, PDO::PARAM_STR);
            $stmt->bindParam(2, $debito->credito, PDO::PARAM_INT);
            $stmt->execute();

            //session_start();
            $_SESSION["msg"] = "DEBITO CADASTRADO COM SUCESSO";
            header("Location: ../home.php");
            throw new MyExecption();
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    public function debitoMaiorQueCredito(Debito $debito) {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM credito where id_credito = ? and valor_credito_atual >= ?;");
            $stmt->bindParam(1, $debito->credito, PDO::PARAM_INT);
            $stmt->bindParam(2, $debito->valor, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return true;
            }
            return false;
            throw new MyExecption();
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    public function listaDebitoReferente($dataInicial, $dataFinal, $idUser, $credito) {
        try {
            $listaDebito = array();
            $stmt = @$this->conexao->prepare("SELECT d.id_debito,d.descricao_debito,d.data_debito,d.valor_debito,c.descricao_credito as 'desc',c.id_credito "
                            . "from debitos d left join credito c on c.id_credito = d.id_credito_fk where d.data_debito BETWEEN ? and ? "
                            . "and id_credito_fk = ? and d.id_usuario_fk = ? and d.exclusao_logica = 0;");
            @$stmt->bindParam(1, @$this->dataConverter($dataInicial), PDO::PARAM_STR);
            @$stmt->bindParam(2, $this->dataConverter($dataFinal), PDO::PARAM_STR);
            $stmt->bindParam(3, $credito, PDO::PARAM_INT);
            $stmt->bindParam(4, $idUser, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                $listaDebito = 0;
                return $listaDebito;
            }
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $debito = new Debito();
                $debito->id = $linha['id_debito'];
                $debito->descricao = $linha['descricao_debito'];
                $debito->data = $linha['data_debito'];
                $debito->valor = $linha['valor_debito'];
                $debito->credito = $linha['desc'];
                $debito->idCred = $linha['id_credito'];
                $listaDebito[] = $debito;
            }
            return $listaDebito;
            throw new MyExecption();
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    public function listaDebitoId($idDebito, $idUser) {
        try {
            $stmt = @$this->conexao->prepare("SELECT d.id_debito,d.descricao_debito,d.data_debito,d.valor_debito,c.descricao_credito as 'desc',c.id_credito "
                            . "from debitos d left join credito c on c.id_credito = d.id_credito_fk where "
                            . "d.id_debito = ? and d.id_usuario_fk = ? and d.exclusao_logica = 0");
            $stmt->bindParam(1, $idDebito, PDO::PARAM_INT);
            $stmt->bindParam(2, $idUser, PDO::PARAM_INT);
            $stmt->execute();
            $debitoCompleto = 0;
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $debito = new Debito();
                $debito->id = $linha['id_debito'];
                $debito->descricao = $linha['descricao_debito'];
                $debito->data = $linha['data_debito'];
                $debito->valor = $linha['valor_debito'];
                $debito->credito = $linha['desc'];
                $debito->idCred = $linha['id_credito'];
                $debitoCompleto = $debito;
            }
            return $debitoCompleto;
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    public function editarDebito(Debito $debito, $valorDebitoAnterior) {
        try {
            $dadosFuncao = array();
            $credito = $this->retornaObjetoCredito($debito->usuario, $debito->credito);
            $diferencaDebitoCredito = $this->diferencaDebitoCredito($debito->valor, $credito->valor);

            if (($credito->valor < $debito->valor || $credito->valorAtual < $diferencaDebitoCredito || $credito->data > $this->dataConverter($debito->data)) && $debito->valor >= $valorDebitoAnterior) {            
                $dadosFuncao[0] = 0;
                $dadosFuncao[1] = "OS VALORES NÃO CONFEREM, LEMBRE-SE: O VALOR DO DÉBITO DEVE SER MENOR QUE O O VALOR DO CRÉDITO CADASTRADO "
                        . "E O SALDO ATUAL DO CRÉDITO REFERENCIADO , DEVE SER MAIR O QUE A DIFERENÇA ENTRE DÉBITO E CRÉDITO, DATA DO DÉBITO DEVE SER MAIOR QUE "
                        . "DATA DO CRÉDITO";
                return $dadosFuncao;
            } elseif ($credito->data > $this->dataConverter($debito->data)) {
                $dadosFuncao[0] = 0;
                $dadosFuncao[1] = "A DATA CADASTRADA NÃO PODE SER MENOR QUE A DATA DO CRÉDITO";
                return $dadosFuncao;
            }

            $novoValorCreditoAtual = $this->retornaSaldoAtualCredito($valorDebitoAnterior, $debito->valor, $credito->valorAtual);

            $this->conexao->beginTransaction();

            $stmt1 = $this->conexao->prepare("UPDATE credito set valor_credito_atual = ? where id_credito = ?;");
            $stmt1->bindParam(1, $novoValorCreditoAtual, PDO::PARAM_STR);
            $stmt1->bindParam(2, $debito->credito, PDO::PARAM_INT);
            
            $stmt2 = $this->conexao->prepare("UPDATE debitos set valor_debito = ?, descricao_debito = ?, data_debito =?, id_credito_fk = ?  where id_debito = ?;");
            $stmt2->bindParam(1, $debito->valor, PDO::PARAM_STR);
            $stmt2->bindParam(2, $debito->descricao, PDO::PARAM_STR);
            $stmt2->bindParam(3, @$this->dataConverter($debito->data), PDO::PARAM_STR);
            $stmt2->bindParam(4, $debito->credito, PDO::PARAM_INT);
            $stmt2->bindParam(5, $debito->id, PDO::PARAM_INT);

            if (!$stmt1->execute() || !$stmt2->execute()) {
                $this->conexao->rollBack();
                throw new MyExecption();
            } else {
                $this->conexao->commit();
                $dadosFuncao[0] =1;
                $dadosFuncao[1] = "DÉBITO ATUALIZADO COM SUCESSO";
                return $dadosFuncao;
            }

            $dadosFuncao[0] = 1;
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    public function editarDebitoDiferente(Debito $debito, $idCredAnterior, $valorDebitoAnterior) {
        try {
            $dadosFuncao = array();
            $credito = $this->retornaObjetoCredito($debito->usuario, $debito->credito);
            //$diferencaDebitoCredito = $this->diferencaDebitoCredito($debito->valor, $credito->valor);

            echo "valor Credito : " . $credito->valor . "</br>";
            echo "valor Credito atual : " . $credito->valorAtual . "</br>";
            echo "valor debito - " . $debito->valor . "</br>";
            echo "valor dataDEbito : " . $debito->data . "</br>";
            echo "valor data Credito : " . $credito->data . "</br>";
            if ($credito->valorAtual < $debito->valor || $credito->data > $this->dataConverter($debito->data)) {
                $dadosFuncao[0] = 0;
                $dadosFuncao[1] = "OS VALORES NÃO CONFEREM, LEMBRE-SE: O VALOR DO DÉBITO DEVE SER MENOR QUE O O VALOR DO CRÉDITO CADASTRADO "
                        . "E O SALDO ATUAL DO CRÉDITO REFERENCIADO. A DATA DO BÉDITO NÃO PODE SER ANTERIOR A DATA DO CRÉDITO CADASTRADO";
                return $dadosFuncao;
            }
            $this->conexao->beginTransaction();

            $stmt1 = $this->conexao->prepare("UPDATE credito set valor_credito_atual = valor_credito_atual - ? where id_credito = ?;");
            $stmt1->bindParam(1, $debito->valor, PDO::PARAM_STR);
            $stmt1->bindParam(2, $debito->credito, PDO::PARAM_INT);
                       
            $stmt2 = $this->conexao->prepare("UPDATE credito set valor_credito_atual = valor_credito_atual + ? where id_credito = ?;");
            $stmt2->bindParam(1, $valorDebitoAnterior, PDO::PARAM_STR);
            $stmt2->bindParam(2, $idCredAnterior, PDO::PARAM_INT);
                       
            $stmt3 = $this->conexao->prepare("UPDATE debitos set valor_debito = ?, descricao_debito = ?, data_debito =?, id_credito_fk = ?  where id_debito = ?;");
            $stmt3->bindParam(1, $debito->valor, PDO::PARAM_STR);
            $stmt3->bindParam(2, $debito->descricao, PDO::PARAM_STR);
            $stmt3->bindParam(3, @$this->dataConverter($debito->data), PDO::PARAM_STR);
            $stmt3->bindParam(4, $debito->credito, PDO::PARAM_INT);
            $stmt3->bindParam(5, $debito->id, PDO::PARAM_INT);

            if (!$stmt1->execute() || !$stmt2->execute() || !$stmt3->execute()) {
                $this->conexao->rollBack();
                throw new MyExecption();
            } else {
                $this->conexao->commit();
                $dadosFuncao[0] =1;
                $dadosFuncao[1] = "DÉBITO ATUALIZADO COM SUCESSO";
                return $dadosFuncao;
            }

            $dadosFuncao[0] = 1;
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    public function deletarDebito($idDebito, $idCred, $valor, $idUser) {
        try {
            $this->conexao->beginTransaction();

            $stmt = $this->conexao->prepare("UPDATE debitos set exclusao_logica = 1 where id_debito = ? and id_usuario_fk = ?;");
            $stmt->bindParam(1, $idDebito, PDO::PARAM_INT);
            $stmt->bindParam(2, $idUser, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $this->conexao->prepare("UPDATE credito set valor_credito_atual = valor_credito_atual + ? where id_credito = ?");
            $stmt->bindParam(1, $valor, PDO::PARAM_INT);
            $stmt->bindParam(2, $idCred, PDO::PARAM_INT);
            $stmt->execute();

            if ($this->conexao->commit()) {
                return true;
            } else {
                throw new MyExecption();
            }
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    public function fechaConexao() {
        $this->conexao = null;
    }

    private function dataConverter($_date = null) {
        $format = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/';
        if ($_date != null && preg_match($format, $_date, $partes)) {
            return $partes[3] . '-' . $partes[2] . '-' . $partes[1];
        }
        return false;
    }

    private function retornaObjetoCredito($idUser, $idCred) {
        try {
            $creditoObject = 0;
            $stmt = @$this->conexao->prepare("SELECT * FROM credito where id_usuario_fk= ? and exclusao_logica = 0 and id_credito = ?;");
            $stmt->bindParam(1, @$idUser, PDO::PARAM_INT);
            $stmt->bindParam(2, @$idCred, PDO::PARAM_INT);
            $stmt->execute();
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $credito = new Credito();
                $credito->id = $linha['id_credito'];
                $credito->descricao = $linha['descricao_credito'];
                $credito->data = $linha['data_credito'];
                $credito->valor = $linha['valor_credito'];
                $credito->valorAtual = $linha['valor_credito_atual'];
                $credito->usuario = $linha['id_usuario_fk'];
                $creditoObject = $credito;
            }
            return $creditoObject;
        } catch (MyExecption $exc) {
            echo $exc->erroSql();
        }
    }

    private function diferencaDebitoCredito($valorDebito, $valorCredito) {
        return $valorCredito - $valorDebito;
    }

    private function retornaSaldoAtualCredito($valorDebitoAnterior, $valorDebitoAtual, $valorCreditoAtual) {
        if ($valorDebitoAnterior <= $valorDebitoAtual) {
            $diferenca = $valorDebitoAtual - $valorDebitoAnterior;
            return $valorCreditoAtual - $diferenca;
        } else {
            $diferenca = $valorDebitoAnterior - $valorDebitoAtual;
            return $valorCreditoAtual + $diferenca;
        }
    }

}
