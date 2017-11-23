<?php
ob_start(); 
session_start();
/*
 APLICAÇÃO QUE FAZ O CONTROLLE DE SISTEMAS
 */

require_once '../util/VerificaVariavelFuncao.php';
require_once '../model/Credito.php';
require_once '../dao/CreditoDao.php';
require_once '../util/connectFactory.php';
require_once '../model/Credito.php';
require_once '../util/MyExecption.php';

$verificaFuncao = new VerificaVariavelFuncao();

$funcao = $verificaFuncao->verificaVariavelFuncao();

$dao = new CreditoDao();
$credito = new Credito();

switch ($funcao) {
    case "salvarCredito":
        // tira os pontos(.) caso o usuário tenha colocado. Ex: "1.000" fica assim "1000" $valor = str_replace(".","",$valor);// troca a vírgula(,) decimal pelo ponto(.). Ex.: "1000,00" fica assim "1000.00"$valor = str_replace(",",".",$valor );// aí insere no BD// Depois pra mostrar$valor = number_format($valor,2,",",".");// Ficaria assim: "1.000,00" no formato brasileiro
        $credito->valor = str_replace(",", ".", $_POST['valor'] = str_replace(".", "", $_POST['valor']));
        $credito->descricao = $_POST['descricao'];
        $credito->data = $_POST['data'];
        $credito->usuario = $_POST['usuario'];
        $dao->abreBanco();
        $dao->salvarCredito($credito);
        $dao->fechaConexao();
        //$valor = number_format($valor, 2, ",", ".");
        break;
    case "consultarCreditos":
        $dataInicial = $_POST['dataInicial'];
        $dataFinal = $_POST['dataFinal'];
        $idUser = $_POST['usuario'];
        $dao->abreBanco();
        $listaCredito = $dao->listaCredito($dataInicial, $dataFinal, $idUser);
        if ($listaCredito == 0) {
            $dao->fechaConexao();
           // session_start();
            $_SESSION["msgError"] = "VOCÊ NÃO POSSUI CRÉDITOS CADASTRADO NESSE PERIODO";
            header("Location:../home.php");
        }
        else{
           // session_start();
            $_SESSION["dataInicial"] = $dataInicial;
            $_SESSION["dataFinal"] = $dataFinal;
            $_SESSION["array"] = $listaCredito;
            header("Location: ../view/credito/tabelaDeCreditos.php");
        }
    case "deletarCredito":
        echo "teste";
        $idCredito = $_GET['idCredito'];
        session_start();
        $idUser = $_SESSION["ID"];
        $dao->abreBanco(); 
        $resultado = $dao->deletarCredito($idCredito, $idUser);
        if($resultado){         
           $dao->fechaConexao();
           echo "<script>window.location='../home.php';alert('CRÉDITO DELETADO COM SUCESSO');</script>";
       } 
       $dao->fechaConexao();
    case "editarCredito":     
        $credito->valor = str_replace(",", ".", $_POST['valor'] = str_replace(".", "", $_POST['valor']));
        $credito->valorAtual = str_replace(",", ".", $_POST['valorAtual'] = str_replace(".", "", $_POST['valorAtual']));
        $credito->descricao = $_POST['descricao'];
        $credito->data = $_POST['data'];
        $credito->usuario = $_POST['usuario'];
        $credito->id = $_POST['credito'];
        $dao->abreBanco();
        if($dao->atualizarCredito($credito)){            
            $dao->fechaConexao();
           echo "<script>window.location='../home.php';alert('CRÉDITO ATUALIZADO COM SUCESSO');</script>";
        }
        else{
           $dao->fechaConexao();
           echo "<script>window.location='../view/credito/editarCredito.php?idCredito=$credito->id';alert('OCORREU UM ERRO INESPERADO, VERIFIQUE OS DADOS E TENTE NOVAMENTE');</script>";
        }
        
    default:
        break;
}