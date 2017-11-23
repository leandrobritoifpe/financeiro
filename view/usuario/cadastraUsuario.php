<!-- #### MODAL CADASTRA USUÁRIO #### -->
<div class="modal fade bs-example-modal-lg" id="cadastraUsuario" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>              
                <div class="container" style="width: 50%; margin-bottom: 3%; margin-top: 2%;">
                    <h1> Cadastro de Usuário</h1>
                    <form id="formExemplo" data-toggle="validator" role="form" enctype="multipart/form-data" method="post" action="controller/UsuarioController.php">	  
                        <input type="hidden" value="salvarUsuario" name="funcao" >
                        <div class="form-group">		    
                            <label for="textNome" class="control-label">Nome</label>		    
                            <input id="textNome" name="nome" title="ESCREVA NOME E SOBRE NOME" minlength="4" maxlength="50" 
                                   class="form-control" placeholder="Digite seu Nome..." type="text" required>		  
                        </div>		  		  
                        <div class="form-group">		    
                            <label for="inputEmail" class="control-label">Email</label>		    
                            <input id="inputEmail" name="login" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" 
                                   title="DIGITE UM E-MAIL VÁLIDO, POIS ESSE SERÁ SEU LOGIN" class="form-control" placeholder="Digite seu E-mail" 
                                   type="email" data-error="Por favor, informe um e-mail correto." required>		    
                            <span class="help-block">
                                Lembre-çe, seu e-mail será seu login
                            </span>
                            <div class="help-block with-errors"></div>		  
                        </div>		  		  
                        <div class="form-group">		    
                            <label for="inputPassword" class="control-label">Senha</label>		    
                            <input type="password" name="senha" minlength="6" maxlength="16" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" 
                                   title="DIGITE UMA SENHA COM NUMEROS E LETRAS MENÚSCULAS E MAIÚSCULAS" class="form-control" id="inputPassword" 
                                   placeholder="Digite sua Senha..." data-minlength="6" required>		    
                            <span class="help-block">
                                Mínimo de seis (6) digitos com letras maiuscula / menuscula e numeros
                            </span>		  
                        </div>
                        <div class="form-group">		    
                            <label for="foto" class="control-label">Foto</label>		    
                            <input type="file" class="form-control" name="foto[]" id="foto" accept="image/*">		    
                            <span class="help-block">
                                Opcional
                            </span>		   
                        </div>
                        <div class="form-group">		    
                            <div class="form-group">		      
                                <label for="tipo" class="control-label">
                                    Selecione o tipo de Usuário
                                    <select id="tipo" name="tipo" required="required" class="form-control">
                                        <option></option>
                                        <option value="0">Comum</option>
                                        <option value="1">Adm</option>
                                    </select>		      
                                </label>		      
                                <div class="help-block with-errors"></div>		    
                            </div>		  
                        </div>		  		  
                        <div class="form-group">		    
                            <button type="submit" class="btn btn-primary">Cadastrar</button>		  
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


