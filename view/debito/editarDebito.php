<?php
include_once '../../util/validaSessao.php';
if (!isset($_GET["idDebito"]) || $_GET["idDebito"] == null) {
    
}
?>
<!DOCTYPE html>
<!--
    TELA DE EDITAR Debitos
-->
<html>
    <head>
        <title>EDITAR DÉBITOS</title>
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
                            <div class="alert alert-success">
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
                        require_once '../../dao/DebitoDao.php';
                        require_once '../../model/Debito.php';
                        require_once '../../util/MyExecption.php'; 
                    
                        $dao = new DebitoDao();
                        $dao->abreBanco();
                        $debito = $dao->listaDebitoId($_GET['idDebito'], $_SESSION["ID"]);
                        $dao->fechaConexao();
                        echo "<h3>Editando Débito</h3>";                
                    ?>
                </div>
                
                
                   <div class="container" style="width: 50%;">
                    
                    <form id="formExemplo" data-toggle="validator" role="form" enctype="multipart/form-data" method="post" action="../../controller/DebitoController.php">		  
                        <input type="hidden" value="editarDebito" name="funcao" id="funcao">
                        <input type="hidden" value="<?php echo $_SESSION["ID"];?>" name="usuario" id="usuario">
                        <input type="hidden" value="<?php echo $debito->idCred;?>" name="idCredAnterior" id="creditoAnterior">
                       
                        <div class="form-group">		    
                            <label for="textNome" class="control-label">Identificação</label>		    
                            <input id="debito" name="debito" style="width: 10%;" class="form-control" 
                                   type="text" readonly="" required value="<?php echo $debito->id;?>">		  
                        </div>
                        <div class="form-group">		    
                            <label for="textNome" class="control-label">Descrição</label>		    
                            <input id="textNome" name="descricao" title="ESCREVA UMA DESCRIÇÃO" minlength="4" maxlength="50" class="form-control" 
                                   placeholder="Descrição" type="text"  required value="<?php echo $debito->descricao;?>">		  
                        </div>
                        <div class="form-group">		    
                            <label for="valor" class="control-label">Valor Anterior</label>		    
                            <input name="valorDebitoAnterior" pattern="([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$" title="DIGITE UM VALOR VÁLIDO" maxlength="15" class="form-control campoValor" 
                                   placeholder="Digite um Valor" readonly="" id="debitoAnterior"  value="<?php echo number_format(@$debito->valor,2,",",".");?>" type="tel" data-error="POR FAVOR INFORME UM VALOR VÁLIDO" required>		    
                            <div class="help-block with-errors"></div>		  
                        </div>	
                        <div class="form-group">		    
                            <label for="valor" class="control-label">Digite o Novo Valor</label>		    
                            <input name="valor" pattern="([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$" title="DIGITE UM VALOR VÁLIDO" maxlength="15" class="form-control campoValor" 
                                   placeholder="Digite um Valor"   value="<?php echo number_format(@$debito->valor,2,",",".");?>" type="tel" data-error="POR FAVOR INFORME UM VALOR VÁLIDO" required>		    
                            <div class="help-block with-errors"></div>		  
                        </div>		  		  
                        <div class="form-group">		    
                            <label for="data" class="control-label">Data</label>		    
                            <input type="text" name="dataMovimentacao" class="form-control campoData"  title="INFORME A DATA DO DEBITO" 
                                   required placeholder="Data"  value="<?php echo date('d/m/Y', strtotime(@$debito->data))?>">		    		  
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                            <?php
                               // include '../../util/connectFactory.php';
                                $conexao = new connectFactory();
                                $con = $conexao->connectaBanco();
                                $consulta = $con->prepare("SELECT * FROM credito where id_usuario_fk = ? and valor_credito_atual > 0 and exclusao_logica = 0 and id_credito <> ?;");
                                $consulta->bindParam(1, $_SESSION["ID"], PDO::PARAM_INT);
                                @$consulta->bindParam(2, @$debito->idCred, PDO::PARAM_INT);
                                $consulta->execute();                 
                            ?>
                                <label for="credito" class="control-label">Referente: 		    
                                    <select id="credito" name="credito" required="required" class="form-control">
                                        <option value="<?php echo $debito->idCred?>">
                                            <?php echo $debito->credito?>
                                        </option>
                                        <?php
                                            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {                                     
                                        ?>
                                            
                                            <option value="<?php echo $linha['id_credito']?>"><?php echo $linha['descricao_credito']."- R$: ".$linha['valor_credito_atual'];?></option>
                                        <?php
                                            }
                                            $con = null;
                                        ?>
                                         </select>
                                  </label>
                                <div class="help-block with-errors"></div>                               
                            </div>
                        </div>                         
                        <div class="form-group">		    
                            <button type="submit" class="btn btn-primary">Atualizar</button>		  
                        </div>		
                    </form>
                </div>
            </div>
            <div class="modal-body">
                <div class="fetched-data">
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
            include '../modalClone/editaCredito.php';
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


