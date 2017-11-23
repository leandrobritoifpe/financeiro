<?php
ob_start(); 
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once '../util/VerificaVariavelFuncao.php';
require_once '../model/Debito.php';
require_once '../dao/DebitoDao.php';
require_once '../util/connectFactory.php';
require_once '../model/Debito.php';
require_once '../model/Credito.php';
require_once '../util/MyExecption.php';


$verificaFuncao = new VerificaVariavelFuncao();

$funcao = $verificaFuncao->verificaVariavelFuncao();

$debito = new Debito();
$dao = new DebitoDao();

switch ($funcao) {
    case "salvarDebito":
        $dao->abreBanco();
        $debito->valor = str_replace(",", ".", $_POST['valor'] = str_replace(".", "", $_POST['valor']));
        $debito->credito = $_POST['credito'];
        if ($dao->debitoMaiorQueCredito($debito)) {
            $dao->fechaConexao();
           // session_start();
            $_SESSION["msgError"] = "O VALOR DO DÉBITO É MAIOR QUE O SALDO ATUAL DO CRÉDITO";
            header("Location: ../home.php");
        }
        $debito->descricao = $_POST['descricao'];
        $debito->data = $_POST['dataMovimentacao'];
        $debito->usuario = $_POST['usuario'];
        $dao->salvarDebito($debito);
        $dao->fechaConexao();
        break;
    case "consultarDebitos":
        $dataInicial = $_POST['dataInicial'];
        $dataFinal = $_POST['dataFinal'];
        $idUser = $_POST['usuario'];
        $credito = $_POST['credito'];
        $dao->abreBanco();
        $listaDebito = $dao->listaDebitoReferente($dataInicial, $dataFinal, $idUser, $credito);
        if ($listaDebito == 0) {
            $dao->fechaConexao();
           // session_start();
            $_SESSION["msgError"] = "VOCÊ POSSUI DEBITOS CADASTRADO NESSE PERIDOD, REFERENTE AO CREDITO SELECIONADO";
            header("Location:../home.php");
        } else {
           // session_start();
            $_SESSION["dataInicial"] = $dataInicial;
            $_SESSION["dataFinal"] = $dataFinal;
            $_SESSION["credito"] = $credito;
            header("Location: ../view/debito/tabelaDedebitos.php");
        }
        break;
    case "deletarDebito":
        $idCred = $_GET['idCred'];
        $idDebito = $_GET['idDebito'];
        $valor = $_GET['val'];
       // session_start();
        $idUser = $_SESSION["ID"];
        $dao->abreBanco();
        if ($dao->deletarDebito($idDebito, $idCred, $valor, $idUser)) {
           // session_start();
           $dao->fechaConexao();
           echo "<script>window.location='../home.php';alert('DÉBITO DELETADO COM SUCESSO');</scrip>";
        }
        $dao->fechaConexao();
    case "editarDebito":
        $debito->valor = str_replace(",", ".", $_POST['valor'] = str_replace(".", "", $_POST['valor']));
        $debito->credito = $_POST['credito'];
        $debito->descricao = $_POST['descricao'];
        $debito->data = $_POST['dataMovimentacao'];
        $debito->usuario = $_POST['usuario'];
        $debito->id = $_POST['debito'];
        $valorDebitoAnterior = str_replace(",", ".", $_POST['valorDebitoAnterior'] = str_replace(".", "", $_POST['valorDebitoAnterior']));      
        $idCredAnterior = $_POST['idCredAnterior'];
        if ($idCredAnterior == $debito->credito) {
            $dao->abreBanco();
            $dadosFuncao = $dao->editarDebito($debito,$valorDebitoAnterior);
            if ($dadosFuncao[0] == 0) {
                echo "entrou aqui";
              // session_start();
               $_SESSION["msgError"] = $dadosFuncao[1];
               header("Location: ../view/debito/editarDebito.php?idDebito=$debito->id");              
            }
            else{
             //  session_start();
               $_SESSION["msg"] = $dadosFuncao[1];
               header("Location: ../view/debito/editarDebito.php?idDebito=$debito->id"); 
            }
        }
        else{
            $dao->abreBanco();
            $dadosFuncao = $dao->editarDebitoDiferente($debito, $idCredAnterior, $valorDebitoAnterior);
            if ($dadosFuncao[0] == 0) {
               // echo "entrou aqui";
              // session_start();
               $_SESSION["msgError"] = $dadosFuncao[1];
               header("Location: ../view/debito/editarDebito.php?idDebito=$debito->id");              
            }
            else{
               //session_start();
               $_SESSION["msg"] = $dadosFuncao[1];
               header("Location: ../view/debito/editarDebito.php?idDebito=$debito->id"); 
            }
        }
        echo "deu merda";
    default:
        break;
}

