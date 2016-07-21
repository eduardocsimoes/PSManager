<?php
    require('./Classes/Config.inc.php');
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    if($data['submitPeladeiro'] == 'cadastrar'):
        $dados['data_cadastro'] = date('Y-m-d');
        $cadastro = new Read();
    
        $cadastro->ExeRead('peladeiro', 'WHERE email = :email', 'email='.$data['email']);
        if($cadastro->getResult()):
            WS_ERROR('Já existe um usuário cadastrado com este E-mail!', WS_ERROR);
        else:
            $create = new Create();
            $create->ExeCreate('peladeiro', $dados);
        endif;
    endif;
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
/*            $login = new Login(3);

            if ($login->CheckLogin()):
                header('Location: painel.php');
            endif;
            
            if (!empty($data['AdminLogin'])):

                $login->ExeLogin($data);
                if (!$login->getResult()):
                    WSErro($login->getError()[0], $login->getError()[1]);
                else:
                    header('Location: painel.php');
                endif;
            endif;

            $get = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
            if (!empty($get)):
                if ($get == 'restrito'):
                    WSErro('<b>Oppsss:</b> Acesso negado. Favor efetue login para acessar o painel!', WS_ALERT);
                elseif ($get == 'logoff'):
                    WSErro('<b>Sucesso ao deslogar:</b> Sua sessão foi finalizada. Volte sempre!', WS_ACCEPT);
                endif;
            endif;
*/        ?>

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