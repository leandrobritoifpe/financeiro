
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
        <div class="container" style="width: 50%; margin-bottom: 3%; margin-top: 2%;">
            <h1> Cadastro de Usuário</h1>
            <form id="formExemplo" data-toggle="validator" role="form" enctype="multipart/form-data" method="post" action="controller/UsuarioController.php">		  
                <input type="hidden" value="salvarUsuario" name="funcao" >
                <div class="form-group">		    
                    <label for="textNome" class="control-label">Nome</label>		    
                    <input id="textNome" name="nome" title="ESCREVA NOME E SOBRE NOME" minlength="4" maxlength="50" class="form-control" placeholder="Digite seu Nome..." type="text" required>		  
                </div>		  		  
                <div class="form-group">		    
                    <label for="inputEmail" class="control-label">Email</label>		    
                    <input id="inputEmail" name="login" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="DIGITE UM E-MAIL VÁLIDO, POIS ESSE SERÁ SEU LOGIN" class="form-control" placeholder="Digite seu E-mail" type="email" data-error="Por favor, informe um e-mail correto." required>		    
                    <span class="help-block">Lembre-çe, seu e-mail será seu login</span>
                    <div class="help-block with-errors"></div>		  
                </div>		  		  
                <div class="form-group">		    
                    <label for="inputPassword" class="control-label">Senha</label>		    
                    <input type="password" name="senha" minlength="6" maxlength="16" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="DIGITE UMA SENHA COM NUMEROS E LETRAS MENÚSCULAS E MAIÚSCULAS" class="form-control" id="inputPassword" placeholder="Digite sua Senha..." data-minlength="6" required>		    
                    <span class="help-block">Mínimo de seis (6) digitos</span>		  
                </div>
                <div class="form-group">		    
                    <label for="foto" class="control-label">Foto</label>		    
                    <input type="file" class="form-control" name="foto[]" id="foto" accept="image/*">		    
                    <span class="help-block">Opcional</span>		   
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
                    <button type="submit" class="btn btn-primary">Enviar</button>		  
                </div>		
            </form>
        </div>

    </body>
</html>
