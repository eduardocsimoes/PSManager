<?php
    require('./Classes/Config.inc.php');  
    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    $dados['submitPeladeiro'] = 'Cadastrar';
    
    if($dados['submitPeladeiro'] == 'Cadastrar'):
        $peladeiro = array(
            'nome' => $dados['nome'],
            'sobrenome' => $dados['sobrenome'],
            'nome_peladeiro' => $dados['nome'] . ' ' . $dados['sobrenome'],
            'apelido' => $dados['apelido'],
            'email' => $dados['email'],
            'data_nascimento' => $dados['data_nascimento'],
            'posicao_predominante' => $dados['posicao_predominante'],
            'pass' => $dados['pass'],
            'lembrete' => $dados['lembrete'],
            'data_cadastro' => date('Y-m-d')
        );
        
        $cadastro = new Read();
        $cadastro->ExeRead('peladeiro', 'WHERE email = :email', 'email='.$peladeiro['email']);
        if($cadastro->getResult()):
            WSErro('Já existe um usuário cadastrado com este E-mail!', WS_ERROR);           
        else:
            $create = new Create();
            $create->ExeCreate('peladeiro', $peladeiro);
            if($create->getResult()):                
                WSErro('Peladeiro cadatrado com sucesso! Favor verificar o seu e-mail.', WS_ACCEPT);
            else:
                WSErro('Peladeiro não cadatrado!', WS_ERROR);
            endif;
        endif;
    endif;         
?>