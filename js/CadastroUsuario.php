<?php    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
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

        $peladeiro1 = array(
            'nome' => getPost('nome'),
            'sobrenome' => getPost('sobrenome'),
            'nome_peladeiro' => getPost('nome') . ' ' . getPost('sobrenome'),
            'apelido' => getPost('apelido'),
            'email' => getPost('email'),
            'data_nascimento' => getPost('data_nascimento'),
            'posicao_predominante' => getPost('posicao_predominante'),
            'pass' => getPost('pass'),
            'lembrete' => getPost('lembrete'),
            'data_cadastro' => date('Y-m-d')
        );        
    
        $cadastro = new Read();

        $cadastro->ExeRead('peladeiro', 'WHERE email = :email', 'email='.$peladeiro1['email']);
        if($cadastro->getResult()):
            WS_ERROR('Já existe um usuário cadastrado com este E-mail!', WS_ERROR);
        else:
            $create = new Create();
            $create->ExeCreate('peladeiro', $peladeiro1);
            if($create->getResult()):
                echo 'true';
                WS_ERROR('Peladeiro cadatrado com sucesso! Favor verificar o seu e-mail.', WS_INFOR);
            else:
                echo 'false';
                WS_ERROR('Peladeiro não cadatrado!', WS_ERROR);
            endif;
        endif;
    endif;  
