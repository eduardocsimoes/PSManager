<?php
    require('./Classes/Config.inc.php');
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
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
    <body class="body_home no-select">

        <?php
            if($data['submitPeladeiro'] == 'cadastrar'):
                $dados['data_cadastro'] = date('Y-m-d');
                $dados['nome_peladeiro'] = $dados['nome'] . ' ' . $dados['sobrenome'];

                $cadastro = new Read();

                $cadastro->ExeRead('peladeiro', 'WHERE email = :email', 'email='.$data['email']);
                echo 'teste';
                if($cadastro->getResult()):
                    WS_ERROR('Já existe um usuário cadastrado com este E-mail!', WS_ERROR);
                else:
                    $create = new Create();
                    $create->ExeCreate('peladeiro', $dados);
                    if($create->getResult()):
                        echo 'true';
                        WS_ERROR('Peladeiro cadatrado com sucesso! Favor verificar o seu e-mail.', WS_INFOR);
                    else:
                        echo 'false';
                        WS_ERROR('Peladeiro não cadatrado!', WS_ERROR);
                    endif;
                endif;
            endif;        
        ?>
        
        <div class="controleusuario">
            <form class="formcontroleusuario" method="POST" action="">
                <input type="email" name="email" class="inputs" placeholder="E-Mail" />
                <input type="password" name="pass" class="inputs" placeholder="Senha" />
                <input type="submit" name="logar" class="btnentrar" value="Entrar">
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