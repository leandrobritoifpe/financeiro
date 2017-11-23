<!-- #### MODAL CADASTRA CREDITO #### -->
<div class="modal fade bs-example-modal-lg" id="consultaCreditos" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>              
                <div class="container" style="width: 50%; margin-bottom: 3%; margin-top: 2%;">
                    <h1> Consulte Seu Credito</h1>
                    <form id="formExemplo" data-toggle="validator" role="form" enctype="multipart/form-data" method="post" action="../../controller/CreditoController.php">		  
                        <input type="hidden" value="consultarCreditos" name="funcao" id="funcao">
                        <input type="hidden" value="<?php echo $_SESSION["ID"];?>" name="usuario" id="usuarioConsultaCredito">	  		  
                        <div class="form-group">		    
                            <label for="dataInicial" class="control-label">Data Inicial</label>		    
                            <input type="text" name="dataInicial" class="form-control campoData"  title="INFORME A DATA INICIAL"required placeholder="Data">		    		  
                        </div>
                        <div class="form-group">		    
                            <label for="dataFinal" class="control-label">Data Final</label>		    
                            <input type="text" name="dataFinal" class="form-control campoData"  title="INFORME A DATA FINAL"required placeholder="Data">		    		  
                        </div>                         
                        <div class="form-group">		    
                            <button type="submit" class="btn btn-primary">Consultar</button>		  
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


