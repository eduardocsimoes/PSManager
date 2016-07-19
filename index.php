<?php
require('./Classes/Config.inc.php');
?>

<!DOCTYPE Html>
<html lang="pt_br">
    <head>
        <title>Pelada Soccer Manager</title>
        <meta charset="UTF-8">
        
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
        <script type="text/javascript" src="<?= INCLUDE_PATH; ?>/js/scriptjs.js"></script>
    </head>    
    <body class="body_home">
        <?php
            require('inc/nav.php');
        ?>

        <div class="controleusuario">
            <form class="formcontroleusuario" method="POST" action="">
                <input type="email" name="email" placeholder="Digite seu E-Mail" />
                <input type="password" name="pass" placeholder="Digite sua Senha" />
                <input type="submit" name="logar" value="Entrar">
            </form>
            
            <div class="auxiliar">
                <input type="checkbox" class="manterlogado" value="1" /><label>Manter Logado</label>
                <a href="#">Lembrar Senha</a>
            </div>  
            
            <div class="cadastro">
                <button name="cadastre" class="btncadastrarusuario">CADASTRE-SE</button>
                <div class="formcadastro">                  
                    <?php
                        require('cadastro.php');
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>