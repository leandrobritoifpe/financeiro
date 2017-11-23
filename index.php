<?php
    ob_start(); 
    session_start();
        if (isset($_SESSION["ID"])) {
            header("Location: home.php");
    }
?>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Login</title>
        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
        <script src="js/jquery-2.1.4.js"></script>
        <script src="bootstrap/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/login.css" />
    </head>
    <body>
        <div class="container">  
            <header>
                <h1>Login</h1>
            </header>
            <section>       
                <div id="container_demo" >
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  action="controller/UsuarioController.php" autocomplete="on" method="post">
                                <input type="hidden" name="funcao" value="validaLogin" id="funcao">
                                <?php
                                  
                                   if (isset($_SESSION["msg"]) && ($_SESSION["msg"] != null || $_SESSION["msg"] != '')) {          
                                ?>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <div class="alert alert-danger">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                                        ×
                                                    </button>
                                                    <span class="glyphicon glyphicon-hand-right"></span> <strong>ATENÇÃO</strong>
                                                    <hr class="message-inner-separator">
                                                    <p style="font-weight: bold">
                                                        <?php
                                                            echo $_SESSION["msg"];
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                       
                                <?php                                      
                                    }
                                    $_SESSION["msg"] = null;
                                ?>
                                <h1>Login</h1> 
                                <p> 
                                    <label for="login" class="uname" >Login </label>
                                    <input id="username" name="login" required="required" type="text" placeholder="Login"/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd"> Senha</label>
                                    <input id="password" name="senha" required="required" type="password" placeholder="Senha" /> 
                                </p
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-default btn-lg btn-block btn-huge">Entrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </section>
    </body>
</html>

