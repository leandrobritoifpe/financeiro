<?php
    include_once '../../util/validaSessao.php';
    if (!isset($_SESSION["dataInicial"]) || !isset($_SESSION["dataFinal"]) || $_SESSION["dataInicial"] == null || $_SESSION["dataFinal"] == null) {
        header("Location: ../../home.php");
}
?>
<!DOCTYPE html>
<!--
    TELA QUE MOSTRA AS TABELAS DE CREDITOS
-->

<html>
    <head>
        <title>Tabela de Credito</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- BOSTRAP E JQUERY DO CALENDARIO DO CAMPO DATA -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link type="text/css" href="../../jquery/css/base/jquery-ui-1.9.2.custom.css" rel="stylesheet" />
        <!-- -->        
        <link rel="stylesheet" href="../../bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/styeMenuFotoUser.css">
        <script src="../../js/jquery-2.1.4.js"></script>
        <script src="../../bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../../js/validator.min.js"></script>
        <script src="../../js/jquery.maskMoney.js"></script>
        <script src="../../js/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="../../js/jquery.maskedinput.js"></script>      
        <link rel="stylesheet" href="../../css/styleHome.css">     
	<!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.8/css/jquery.dataTables.css"> 
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.8/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../../js/table.js"></script>
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
        <?php include '../modalClone/menuFotoUser.php'?>
        <br><br>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="../../home.php"><i class="fa fa-home fa-fw"></i>Home</a></li>
                        <?php
                            include_once '../../util/menuLateral.php';
                        ?>
                        <li>
                            <a href="../../controller/UsuarioController.php?funcao=encerrarSessao">
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
                        require_once '../../util/connectFactory.php';
                        require_once '../../dao/CreditoDao.php';
                        require_once '../../model/Credito.php';
                        require_once '../../util/MyExecption.php'; 
                    
                        $dao = new CreditoDao();
                        $dao->abreBanco();
                        $listaCredito = $dao->listaCredito($_SESSION["dataInicial"], $_SESSION["dataFinal"], $_SESSION["ID"])                  
                    ?>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6" style="width: 73%;">
                            <div class="panel panel-primary" style="padding: 2%;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                    <span class="glyphicon glyphicon-bookmark"></span> TABELAS DE CRÉDITOS</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="container" style="width:100%">
                                            <div class="table-responsive">
                                                <table class="table table-responsive table-striped" id="tabela" border='1'>
                                                    <thead style="text-align: center;">
                                                            <tr style='background-color: #0080FF;'>
                                                                <th style='width: 5%; color : black;' class="alinhaTexto">ID</th>
                                                                <th style='width: 10%;color : black;' class="alinhaTexto">DATA</th>
                                                                <th style='width: 15%;color : black' class="alinhaTexto">DESCRICAO</th>
                                                                <th style='width: 10%;color : black' class="alinhaTexto">VALOR</th>
                                                                <th style='width: 10%;color : black' class="alinhaTexto">VALOR ATUAL</th>
                                                                <th style='width: 10%;color : black' class="alinhaTexto">EDITAR</th>
                                                                <th style='width: 10%;color : black' class="alinhaTexto">REMOVER</th>
                                                                </tr>
                                                         </thead>
                                                         <?php                                                
                                                            for ($index = 0; $index < count($listaCredito); $index++) {
                                                                $credito = $listaCredito[$index];
                                                         ?>
                                                         <tr style="text-align: center">
                                                            <td class="alinhaTexto" style="color : black"><?php echo @$credito->id?></td>
                                                            <td class="alinhaTexto" style="color : black"><?php echo date('d/m/Y', strtotime(@$credito->data)) ?></td>
                                                            <td class="alinhaTexto" style="color : black"><?php echo @$credito->descricao?></td>
                                                            <td class="alinhaTexto" style="color : black"><?php echo "R$ ".number_format(@$credito->valor,2,",",".");?></td>
                                                            <td class="alinhaTexto" style="color : black"><?php echo "R$ ".number_format(@$credito->valorAtual,2,",",".");?></td>
                                                            <td>
                                                                <a href="editarCredito.php?idCredito=<?php echo @$credito->id?>"                                                         
                                                                   class="glyphicon glyphicon-pencil" style="text-decoration: none;" 
                                                                   target="_blank" class="well well-sm" style="margin-bottom:5px;"
                                                                   />     
                                                            </td>
                                                            <td>
                                                                <a href="../../controller/CreditoController.php?funcao=deletarCredito&idCredito=<?php echo @$credito->id?>"
                                                                   onclick="return confirm('Tem certeza que deseja deletar esse registro?')" 
                                                                   class="glyphicon glyphicon-trash" style="text-decoration: none;"                                                            
                                                                />     
                                                            </td>
                                                         </tr>
                                                         <?php
                                                            }
                                                         ?>
                                                </table>
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
            if ($_SESSION["TIPO"] != 1) {
                include '../modalClone/modalBlock.php';
            } else {
                include '../modalClone/cadastraUsuario.php';
            }
            include '../modalClone/cadastraCredito.php';
            include '../modalClone/cadastraDebito.php';
            include '../modalClone/formConsultaCredito.php';
            include '../modalClone/formConsultaDebitos.php';
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

