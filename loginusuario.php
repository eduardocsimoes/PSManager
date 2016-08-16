<?php
    session_start();
    require('./Classes/Config.inc.php');

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dados['submitLogar'] = 'Entrar';
    $lembrete = (isset($dados['lembrete'])) ? $dados['lembrete'] : '';
    setcookie('teste', '');
    
    if(($dados['submitLogar'] == 'Entrar') and (!empty($dados['email']))):
        $cadastro = new Read();
        $cadastro->ExeRead('peladeiro', 'WHERE email = :email', 'email='.$dados['email']);
        if($cadastro->getResult()):
            foreach($cadastro->getResult() as $infoCadastro):
                if(password_verify($dados['pass'], $infoCadastro['pass'])):
                    WSErro('Login Aceito', WS_ACCEPT);

                    $_SESSION["id_peladeiro"] = $infoCadastro["id_peladeiro"];
                    $_SESSION["nivel"] = $infoCadastro["nivel"];
                    $_SESSION["nome_peladeiro"] = $infoCadastro["nome_peladeiro"];
                    
                    if($lembrete == 1):
                        $expira = 60*60*24*30;
                        setcookie('CookieLembrete', base64_encode(1));
                        setcookie('CookieEmail', base64_encode($dados['email']));
                        setcookie('CookieSenha', base64_encode($dados['pass']));
                    else:
                        setCookie('CookieLembrete');
                        setCookie('CookieEmail');
                        setCookie('CookieSenha');
                    endif;
                    
                    echo "<script type='text/javascript'>setTimeout( function() {window.open( 'home.php', '_top' ) }, 1000);</script>";
                else:
                    WSErro('Senha inválida para este e-mail!', WS_ERROR);
                endif;
            endforeach;
        else:
            WSErro('E-mail não cadastrado!', WS_ERROR);
        endif;
    else:
        WSErro('Favor informar usuário e senha!', WS_INFOR);
    endif;
?>