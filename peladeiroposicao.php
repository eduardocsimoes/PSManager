<?php
session_start();
require('Classes/Config.inc.php');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$excluirId = filter_input(INPUT_GET, 'excluir',FILTER_VALIDATE_INT);

//$nomePelada = 'Escolha uma Pelada';
$_SESSION['nomePeladeiro'] = 'Escolha um Peladeiro';
$idPeladeiro = null;
$idPosicao = null;

if(isset($dados['selecaoPeladeiro']) && $dados['selecaoPeladeiro'] == 0):
    //$_SESSION['idPelada'] = null;
    $_SESSION['nomePeladeiro'] = 'Escolha um Peladeiro'; 
endif;

if(!isset($_SESSION['idPeladeiro'])):    
    $_SESSION['idPeladeiro'] = null;
endif;

if (isset($dados) && $dados['submitPeladeiro']=='Selecionar'):
    //unset($dados['submitPelada']);
    $nomePeladeiro = $dados['selecaoPeladeiro'];

    $peladeiro = new Read;

    $peladeiro->ExeRead('peladeiro', 'WHERE nome_peladeiro = :nome_peladeiro', 'nome_peladeiro='.$nomePeladeiro);
    if ($peladeiro->getResult()):
        foreach($peladeiro->getResult() as $resultPeladeiro):            
            extract($resultPeladeiro);                  
            $_SESSION['idPeladeiro'] = $id_peladeiro;
            $_SESSION['nomePeladeiro'] = $nome_peladeiro;            
        endforeach;        
    else:
        WSErro('Nenhum peladeiro selecionado', WS_INFOR);        
    endif;
endif;

if (isset($dados) && $dados['submitPeladeiro']=='Vincular'):
    //unset($dados['submitPeladeiro']);
    $nomePosicao = $dados['selecaoPosicao'];
    $dataCadastro = date('Y-m-d');

    $posicao = new Read();
    $criarVinculo = new Create();    

    $posicao->ExeRead('posicao', 'WHERE nome_posicao = :nome_posicao', 'nome_posicao='.$nomePosicao);
    if ($posicao->getResult()):
        foreach($posicao->getResult() as $resultPosicao):            
            extract($resultPosicao);
            $idPosicao = $id_posicao;
            
            $dadosPosicao = ['id_peladeiro' => $_SESSION['idPeladeiro'], 'id_posicao' => $idPosicao, 'data_cadastro' => $dataCadastro];            
            $criarVinculo->ExeCreate('peladeiro_posicao', $dadosPosicao);  

            if($criarVinculo->getResult()==0):
                //WSErro('Cadastro realizado com sucesso!', WS_INFOR);
                echo 'Cadastro realizado com sucesso!';
            else:
                WSErro('Desculpe, Não foi possível vincular o peladeiro à pelada!', WS_ERROR);
            endif;
        endforeach;  
    else:
        WSErro('Nenhum peladeiro selecionado', WS_INFOR);        
    endif;
endif;

if($excluirId):
    $deleta = new Delete();
    $deleta->ExeDelete('peladeiro_posicao', 'WHERE id_posicao=:posicao AND id_peladeiro=:peladeiro', 'peladeiro='.$_SESSION['idPeladeiro'].'&posicao='.$excluirId);
    if($deleta->getResult()):
        echo "{$deleta->getRowCount()} registro(s) removidos com sucesso!<hr>";
    endif;
    header("Location:http://localhost:8080/psmanager/peladeiroposicao.php");
endif;
?>

<!DOCTYPE Html>
<html lang="pt_br">
    <head>
        <title>Pelada Soccer Manager</title>
        <meta charset="utf-8">
    </head>    
    <body>
        <?php
        require('inc/nav.php');
        ?>    

        <h1>Registro de Posições do Peladeiro</h1>

        <form name="escolhaopeladeiro" method="post" action="">
            <label>Escolha o Peladeiro</label>
            <select name="selecaoPeladeiro">
                <option value="0" <?php if(!$idPeladeiro): echo 'selected="selected"'; endif; ?>>Nenhuma Selecionada</option>
                <?php
                $peladeiro = new Read();

                $peladeiro->ExeRead('peladeiro', 'ORDER BY id_peladeiro');
                if ($peladeiro->getResult()):
                    foreach ($peladeiro->getResult() as $dadosPeladeiro):
                        extract($dadosPeladeiro);                        
                        echo "<option values='" . $id_peladeiro . "'";
                        if($id_peladeiro == $_SESSION['idPeladeiro']):
                            echo " selected = 'selected'>" . $nome_peladeiro . "</option>";
                        else:
                            echo ">" . $nome_peladeiro . "</option>";
                        endif;
                    endforeach;
                else:
                    WSErro('Nenhuma pelada selecionada', WS_INFOR);                    
                endif;
                ?>    
            </select>
            <input name="submitPeladeiro" type="submit" value="Selecionar" />
        </form>

        <h1>Posições do Peladeiro: <?php echo $_SESSION['nomePeladeiro']; ?> </h1>

        <form name="escolhaaposicao" method="POST" action="">            
            <label>
                <span>Escolha a Posicao</span>
                <select name="selecaoPosicao">
                    <option value="0" <?php if(!$idPosicao): echo "selected=selected"; endif; ?>>Nenhuma Selecionada</option>
                    <?php
                        $posicao = new Read();
                        
                        $posicao->ExeRead('posicao', 'ORDER BY id_posicao');
                        if($posicao->getResult()):
                            foreach($posicao->getResult() as $dadosPosicao):
                                extract($dadosPosicao);
                                echo '<option values="' . $id_posicao . '">' . $nome_posicao . '</option>';
                            endforeach;
                        else:
                            WSErro('Nenhuma pelada selecionada', WS_INFOR);
                        endif;
                    ?>
                </select>    
            </label>
            
            <input name="submitPeladeiro" type="submit" value="Vincular" />
        </form>
        
        <table width="625" border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nome da Posição</th>                    
                    <th>Excluir</th>
                </tr>    
            </thead>
            
            <tbody>
                <?php
                $peladeironaposicao = new Read();
                $peladeironaposicao->ExeRead('peladeiro_posicao', 'WHERE id_peladeiro = :idPeladeiro ORDER BY id_posicao', 'idPeladeiro='. $_SESSION['idPeladeiro']);
                if($peladeironaposicao->getResult()):
                    foreach ($peladeironaposicao->getResult() as $resultPeladeiro):
                        extract($resultPeladeiro);                        

                        $posicao = new Read();
                        $posicao->ExeRead('posicao', 'WHERE id_posicao = :idPosicao', 'idPosicao=' . $id_posicao);
                        if ($posicao->getResult()):
                            foreach ($posicao->getResult() as $dadosPosicao):                            
                                $nomePosicao = $dadosPosicao['nome_posicao'];
                            endforeach;
                        else:
                            WSErro('Desculpe, não existem posições cadastradas!', WS_INFOR);
                        endif;

                        echo '<tr>';
                        echo '<td>' . $id_posicao . '</td>';
                        echo '<td>' . $nomePosicao . '</td>';
                        echo '<td><a href="http://localhost:8080/psmanager/peladeiroposicao.php?excluir=' . $id_posicao . '"><img src="img/delete1.png" '
                        . 'alt="Excluir peladeiro_posicao" width=25 height=25></a></td>';
                        echo '</tr>';
                    endforeach;
                else:
                    WSErro('Não existem posições vinculados a este peladeiro!', WS_INFOR);
                endif;                
                ?>
            </tbody>
        </table>           
    </body>
</html>
