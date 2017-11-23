<?php
    include_once './util/validaSessao.php';
    $funcao = null;
?>
<html>
    <head>
        <title>Pagina Inicial</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- BOSTRAP E JQUERY DO CALENDARIO DO CAMPO DATA -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link type="text/css" href="jquery/css/base/jquery-ui-1.9.2.custom.css" rel="stylesheet" />
        <!-- -->
        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/styeMenuFotoUser.css">
        <script src="js/jquery-2.1.4.js"></script>
        <script src="bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="js/validator.min.js"></script>
        <script src="js/jquery.maskMoney.js"></script>
        <script src="js/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="jquery/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
        <link rel="stylesheet" href="css/styleHome.css">   
        <script type="text/javascript">
            $(document).ready(function () {
                $(".campoData").datepicker({
                    dateFormat: 'dd/mm/yy',
                    dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
                    dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
                    dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    nextText: 'Próximo',
                    prevText: 'Anterior'
                });
            });                                
        </script>          
    </head>
    <body>
        <?php include './util/menuFotoUser.php'?>
        <br><br>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="home.php"><i class="fa fa-home fa-fw"></i>Home</a></li>
                        <?php
                            include_once './util/menuLateral.php';
                        ?>
                        <li>
                            <a href="controller/UsuarioController.php?funcao=encerrarSessao">
                                <i class="glyphicon glyphicon-off"></i>&nbsp;&nbsp;&nbsp;SAIR
                            </a>
                        </li>
                    </ul>
                </div>
                    <div class="col-md-9 well">
                        <?php
                            if (isset($_SESSION["msg"]) && ($_SESSION["msg"] != null || $_SESSION["msg"] != '')) {
                        ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        ×
                                    </button>
                                    <strong>ATENÇÃO:</strong> <?php echo $_SESSION["msg"]; ?>
                                </div>
                        <?php
                            }
                            $_SESSION["msg"] = null;
                            if (isset($_SESSION["msgError"]) && ($_SESSION["msgError"] != null || $_SESSION["msgError"] != '')) {
                        ?>
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        ×
                                    </button>
                                    <strong>ATENÇÃO:</strong> <?php echo $_SESSION["msgError"]; ?>
                                </div>
                        <?php
                            }
                            $_SESSION["msgError"] = null;
                        ?>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <span class="glyphicon glyphicon-bookmark"></span> Escolha uma Opção
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-6 col-md-6">
                                                <a href="#" class="btn btn-info btn-lg" data-toggle="modal" data-target="#consultaDebitos" role="button">
                                                    <span class="glyphicon glyphicon-list-alt"></span><br/>Tabela<br/>Debitos
                                                </a>
                                                <a href="#" class="btn btn-success btn-lg" data-toggle="modal" data-target="#tabelaUsuario" role="button">
                                                    <span class="glyphicon glyphicon-list-alt"></span><br/>Tabela<br/>Usuários
                                                </a>
                                                <a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#consultaCreditos" role="button">
                                                    <span class="glyphicon glyphicon-list-alt"></span> <br/>Tabela<br/>Creditos
                                                </a> 
                                            </div>
                                            <div class="col-xs-6 col-md-6">
                                                <a href="#" class="btn btn-info btn-lg" data-toggle="modal" data-target="#cadastraDebito" role="button">
                                                    <span class="glyphicon glyphicon-pencil"></span><br/>Cadastrar <br/>Debito
                                                </a>
                                                <a href="#" class="btn btn-success btn-lg" data-toggle="modal" data-target="#cadastraUsuario" role="button">
                                                    <span class="glyphicon glyphicon-user"></span><br/>Cadastrar <br/>Usuários
                                                </a>  
                                                <a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#cadastraCredito" role="button">
                                                    <span class="glyphicon glyphicon-pencil"></span> <br/>Cadsatrar<br/>Creditos
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            include 'util/connectFactory.php';
            if ($_SESSION["TIPO"] != 1) {
                include './util/modalBlock.php';
            }else{
                include './view/usuario/cadastraUsuario.php';
            }
            include './view/credito/cadastraCredito.php';
            include './view/debito/cadastraDebito.php';
            include './view/credito/formConsultaCredito.php';
            include './view/debito/formConsultaDebitos.php';
        ?>
        <script type="text/javascript">	
            $(document).ready(function(){
		$(".campoData").mask("99/99/9999");
		$('.campoValor').numeric();
                $('.campoValor').maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});          
	});
        </script> 
    </body>
</html>
