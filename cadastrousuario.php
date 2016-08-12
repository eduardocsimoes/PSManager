<?php
    require('./Classes/Config.inc.php');  
    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    $dados['submitPeladeiro'] = 'Cadastrar';   
    
    if(($dados['submitPeladeiro'] == 'Cadastrar') and (isset($dados['terms']))):
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
        
/*        $peladeiro = array(
            'nome' => 'Nilton',
            'sobrenome' => 'Simões',
            'nome_peladeiro' => 'Nilton Simões',
            'apelido' => 'Niltinho',
            'email' => 'niltinhosf@gmail.com',
            'data_nascimento' => date('Y-m-d'),
            'posicao_predominante' => 1,
            'pass' => '1234',
            'lembrete' => '1234',
            'data_cadastro' => date('Y-m-d')
        );
*/
    
        $cadastro = new Read();
        $cadastro->ExeRead('peladeiro', 'WHERE email = :email', 'email='.$peladeiro['email']);
        if($cadastro->getResult()):
            WSErro('Peladeiro já cadastrado com este E-mail!', WS_ERROR);           
        else:
            $create = new Create();
            $create->ExeCreate('peladeiro', $peladeiro);
            if($create->getResult()):                
                WSErro('Peladeiro cadatrado com sucesso! Favor verificar o seu e-mail.', WS_ACCEPT);
            else:
                WSErro('Peladeiro não cadatrado!', WS_ERROR);
            endif;
        endif;
    else:
        WSErro('Os termos, condições e políticas não foram aceitos!', WS_ALERT);
    endif;         
?>