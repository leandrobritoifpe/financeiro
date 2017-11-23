<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Cadastro de Usuário</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../bootstrap/dist/css/bootstrap.min.css">
        <script src="../../js/jquery-2.1.4.js"></script>
        <script src="../../bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../../js/efeitoFormUser.js_1"></script>
        <link rel="stylesheet" href="../../css/styleCadastraUser_1.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <form action="../../controller/UsuarioController.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="salvarUsuario" name="funcao" >
                        <div id="contact-form" class="form-container" data-form-container>
                            <div class="row">
                                <div class="form-title">
                                    <span>Cadastre o Usuario</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <div class="row">
                                    <span class="req-input" >
                                        <span class="input-status" data-toggle="tooltip" data-placement="top" title="Descreva seu nome"> </span>
                                        <input type="text" data-min-length="8" placeholder="Nome" required="required" name="nome">
                                    </span>
                                </div>
                                <div class="row">
                                    <span class="req-input">
                                        <span class="input-status" data-toggle="tooltip" data-placement="top" title="Descreva seu login"> </span>
                                        <input type="text" data-min-length="4" placeholder="Login" required="required" name="login">
                                    </span>
                                </div>
                                <div class="row">
                                    <span class="req-input">
                                        <span class="input-status" data-toggle="tooltip" data-placement="top" title="Digite uma Senha"> </span>
                                        <input type="password" data-min-length="4" placeholder="Senha" required="required" name="senha">
                                    </span>
                                </div>
                                <div class="row">
                                    <span class="req-input">
                                        <h4 style="color: black">Selecione uma foto</h4>
                                    </span>
                                     <input type="file" name="foto[]" id="foto" >
                                </div>
                                <div class="row submit-row">
                                    <button type="submit" class="btn btn-block submit-form">Cadastrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
