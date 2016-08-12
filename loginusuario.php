<?php
    require('./Classes/Config.inc.php');  
    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    $dados['submitLogar'] = 'Entrar';   
    
    if(($dados['submitLogar'] == 'Entrar') and (!empty($dados['email']))):  
        $cadastro = new Read();
        $cadastro->ExeRead('peladeiro', 'WHERE email = :email and pass = :senha', 'email='.$dados['email'].'&senha='.$dados['pass']);
        if($cadastro->getResult()):
            WSErro('Login Aceito', WS_ACCEPT);
        else:
            WSErro('Login Inválido!', WS_ERROR);
        endif;
    else:
        WSErro('Favor informar usuário e senha!', WS_INFOR);
    endif;         
?>