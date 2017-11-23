<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 */

require_once '../util/VerificaVariavelFuncao.php';
require_once '../model/Usuario.php';
require_once '../dao/UsuarioDao.php';

$verificaFuncao = new VerificaVariavelFuncao();

$funcao = $verificaFuncao->verificaVariavelFuncao();

$dao = new UsuarioDao();
$usuario = new Usuario();
switch ($funcao) {
    case "salvarUsuario":
        $dao->abreBanco();
        $usuario->exclusaoLogica = 0;
        $usuario->nome = $_POST['nome'];
        $usuario->login = $_POST['login'];
        $usuario->senha = md5($_POST['senha']);
        $usuario->foto = $_FILES['foto']['tmp_name'];
        $usuario->tipo = $_POST['tipo'];
        if ($dao->verificaSeLoginExiste($usuario->login,0)) {
            $dao->fechaConexao();
            header("Location: ../home.php");
        } else {
            //CODIGO PARA MOVER IMAGEM PARA DIRETORIO
            foreach ($_FILES['foto']['tmp_name'] as $key => $tmp_name) {
                ( $file_name = $key . $_FILES['foto']['name'][$key]);
                ( $file_size = $_FILES['foto']['size'][$key]);
                ( $file_tmp = $_FILES['foto']['tmp_name'][$key]);
                ( $file_type = $_FILES['foto']['type'][$key]);
                $nomeCorrigido = utf8_encode($file_name);
                move_uploaded_file($file_tmp, "../imgUser/" . $nomeCorrigido);

                $usuario->foto = $nomeCorrigido;
            }         
            $dao->salvarUsuario($usuario);
            $dao->fechaConexao();
            header("Location: ../home.php");
        }
        break;
    case "validaLogin":
        $dao->abreBanco();
        $usuario->login = $_POST['login'];
        $usuario->senha = md5($_POST['senha']);
        $usuario->exclusaoLogica = 0;
        if (!$dao->validaLogin($usuario)) {
            $dao->fechaConexao();
            header("Location: ../index.php");
        }
        else{
             header("Location: ../home.php");
        }       
        break;
    case "encerrarSessao";
        session_start();
        session_destroy();
        header("Location: ../index.php");
    default:
        break;
}    


