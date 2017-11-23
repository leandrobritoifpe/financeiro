
<?php
session_start();
if ($_SESSION["TIPO"] != 1) {
    echo "<script>window.location='home.php';alert('DESCULPE, VOCÊ NÃO TEM ACESSO A ESSA PÁGINA, POR FAVOR CONTACTE O ADM');</script>";
}
?>
<html>
    <head>
        <title>Cadastro de Usuário</title>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel = "stylesheet" href = "../../bootstrap/dist/css/bootstrap.min.css">
        <script src = "../../js/jquery-2.1.4.js"></script>
        <script src="../../bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../../js/validator.min.js"></script>
    </head>
    <body>
        <div class="container" style="width: 50%; margin-bottom: 5%; margin-top: 5%;">
            <h1> Cadastro de Usuário</h1>
            <form id="formExemplo" data-toggle="validator" role="form">		  
                <div class="form-group">		    
                    <label for="textNome" class="control-label">Nome</label>		    
                    <input id="textNome" class="form-control" placeholder="Digite seu Nome..." type="text" required>		  
                </div>		  		  
                <div class="form-group">		    
                    <label for="inputEmail" class="control-label">Email</label>		    
                    <input id="inputEmail" class="form-control" placeholder="Digite seu E-mail" type="email" data-error="Por favor, informe um e-mail correto." required>		    
                    <div class="help-block with-errors"></div>		  
                </div>		  		  
                <div class="form-group">		    
                    <label for="inputPassword" class="control-label">Senha</label>		    
                    <input type="password" class="form-control" id="inputPassword" placeholder="Digite sua Senha..." data-minlength="6" required>		    
                    <span class="help-block">Mínimo de seis (6) digitos</span>		  
                </div>		  		  
                <div class="form-group">		    
                    <label for="inputConfirm" class="control-label">Confirme a Senha</label>		    
                    <input type="password" class="form-control" id="inputConfirm" placeholder="Confirme sua Senha..." 	data-match="#inputPassword" data-match-error="Atenção! As senhas não estão iguais." required>		    
                    <div class="help-block with-errors"></div>		  </div>		  		  
                    <div class="form-group">		    
                        <div class="checkbox">		      
                            <label>		        
                                <input type="checkbox" data-error="Você deve marcar este campo!" required> Marque este item.		      
                            </label>		      
                            <div class="help-block with-errors"></div>		    
                        </div>		  
                    </div>		  		  
                <div class="form-group">		    
                    <button type="submit" class="btn btn-primary">Enviar</button>		  
                </div>		
            </form>
        </div>

    </body>
</html>
