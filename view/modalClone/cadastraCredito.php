<!-- #### MODAL CADASTRA CREDITO #### -->
<div class="modal fade bs-example-modal-lg" id="cadastraCredito" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>              
                <div class="container" style="width: 50%; margin-bottom: 3%; margin-top: 2%;">
                    <h1> Cadastro de Crédito</h1>
                    <form id="formExemplo" data-toggle="validator" role="form" enctype="multipart/form-data" method="post" action="../../controller/CreditoController.php">		  
                        <input type="hidden" value="salvarCredito" name="funcao" id="funcao">
                        <input type="hidden" value="<?php echo $_SESSION["ID"];?>" name="usuario" id="usuario">                        
                        <div class="form-group">		    
                            <label for="textNome" class="control-label">Descrição</label>		    
                            <input id="textNome" name="descricao" title="ESCREVA UMA DESCRIÇÃO" minlength="4" maxlength="50" class="form-control" 
                                   placeholder="Descrição" type="text" required>		  
                        </div>		  		  
                        <div class="form-group">		    
                            <label for="valor" class="control-label">Valor</label>		    
                            <input  name="valor" pattern="([0-9]{1,3}\.)?[0-9]{1,3},[0-9]{2}$" title="DIGITE UM VALOR VÁLIDO" 
                                   maxlength="15" class="form-control campoValor" placeholder="Digite um Valor" type="tel" 
                                   data-error="POR FAVOR INFORME UM VALOR VÁLIDO" required>		    
                            <div class="help-block with-errors"></div>		  
                        </div>		  		  
                        <div class="form-group">		    
                            <label for="data" class="control-label">Data</label>		    
                            <input type="text" name="data" class="form-control campoData"  title="INFORME A DATA DO CREDITO" accept="" required placeholder="Data">		    		  
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
</div>
<!-- -->


