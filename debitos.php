<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Débitos</title>
	<script type="text/javascript" src="js/jquery-2.1.4.js"></script>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
	<script type="text/javascript" src="js/jquery.maskMoney.js"></script>
	<script type="text/javascript" src="js/jquery.alphanumeric.js"></script>
</head>
<body>
	<?php 
		include 'menu.php';
	?>
	<div class="container"> 
        <div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Cadastro de Debito</div>                            
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" role="form" action="../controler/processaDebito.php" method="post">                          	                          
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>                                                                                     
                                <div class="form-group">
                                    <label for="descricao" class="col-md-3 control-label">Descricao</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="descricao" required="required" maxlength="50">
                                    </div>
                                </div>                                  
                                <div class="form-group">
                                    <label for="data" class="col-md-3 control-label">Data:</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="data" riquered="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="valor" class="col-md-3 control-label">Valor R$:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="valor" id="valor" riquered="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="estado" class="col-md-3 control-label">Estado</label>
                                    <div class="col-md-9">
                                        <select name="opcoes" class="form-control">
                                        	<option value="Ativo">Ativo</option>
                                        	<option value="Inativo">Inativo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="referente" class="col-md-3 control-label">Referente:</label>
                                    <div class="col-md-9">
                                        <?php 
                                        	$conect = mysql_connect("127.0.0.1","root","");
											if(!$conect) {
												echo "Erro ao se conectar com o banco";
											}
											mysql_select_db("financeiro", $conect);
								
											#seleciona os dados da tabela produto
											$query = mysql_query("SELECT cod, descricao FROM creditos");
                                        ?>
                                        <select class="form-control" name="referente">
                                        	<?php while($prod = mysql_fetch_array($query)) { ?>
						 						<option value="<?php echo $prod['cod'] ?>"><?php echo $prod['descricao'] ?></option>
						 					<?php } mysql_close($conect); ?>
                                        </select>
                                    </div>
                                </div>                                              
                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Cadastrar</button>
                                      	<button id="btn-signup" type="reset" class="btn btn-info"><i class="icon-hand-right"><i>&nbsp Limpar Formulario</i></button>
                                    </div>
                                </div>                                                                   
                            </form>
                         </div>
                    </div>
         </div> 
    </div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#valor').numeric();
			$('#valor').maskMoney({showSymbol:true, symbol:"R$", decimal:".", thousands:"."});		
		});
	</script> 
</body>
</html>