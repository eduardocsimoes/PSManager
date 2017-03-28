<?php
include('verificasecao.php');

require('Classes/Config.inc.php');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$excluirId = filter_input(INPUT_GET, 'excluir',FILTER_VALIDATE_INT);

//$nomePelada = 'Escolha uma Pelada';
$nomePeladeiro = 'Escolha um Peladeiro';

if(!isset($_SESSION['idPelada'])):
    $_SESSION['idPelada'] = null;
endif;

if(isset($dados['selecaoPelada']) && $dados['selecaoPelada'] == 0):    
    $_SESSION['nomePelada'] = 'Escolha uma Pelada'; 
endif;

if(!isset($idPelada)):
    $idPelada = null;
endif;

if(!isset($_SESSION['nomePelada'])):    
    $_SESSION['nomePelada'] = 'Escolha uma Pelada';
endif;

if (isset($dados) && $dados['submitPelada']=='Selecionar'):
    //unset($dados['submitPelada']);
    $nomePelada = $dados['selecaoPelada'];

    $pelada = new Read;

    $pelada->ExeRead('pelada', 'WHERE nome_pelada = :nome_pelada', 'nome_pelada='.$nomePelada);
    if ($pelada->getResult()):
        foreach($pelada->getResult() as $resultPelada):            
            extract($resultPelada);                  
            $_SESSION['idPelada'] = $id_pelada;
            $_SESSION['nomePelada'] = $nome_pelada;            
        endforeach;        
    else:
        WSErro('Nenhuma pelada selecionada', WS_INFOR);        
    endif;
endif;

if (isset($dados) && $dados['submitPelada']=='Vincular'):
    //unset($dados['submitPeladeiro']);
    $nomePeladeiro = $dados['selecaoPeladeiro'];
    $dataCadastro = date('Y-m-d');

    $peladeiro = new Read();
    $criarVinculo = new Create();    

    $peladeiro->ExeRead('peladeiro', 'WHERE nome_peladeiro = :nome_peladeiro', 'nome_peladeiro='.$nomePeladeiro);
    if ($peladeiro->getResult()):
        foreach($peladeiro->getResult() as $resultPeladeiro):            
            extract($resultPeladeiro);
            $idPeladeiro = $id_peladeiro;
            
            $dadosPeladeiro = ['id_pelada' => $_SESSION['idPelada'], 'id_peladeiro' => $idPeladeiro, 'data_cadastro' => $dataCadastro];            
            $criarVinculo->ExeCreate('pelada_peladeiro', $dadosPeladeiro);  

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
    $deleta->ExeDelete('pelada_peladeiro', 'WHERE id_pelada=:pelada AND id_peladeiro=:peladeiro', 'pelada='.$_SESSION['idPelada'].'&peladeiro='.$excluirId);
    if($deleta->getResult()):
        echo "{$deleta->getRowCount()} registro(s) removidos com sucesso!<hr>";
    endif;
    header("Location:http://localhost:8080/psmanager/peladapeladeiro.php");
endif;
?>

<!DOCTYPE Html>
<html lang="pt_br">
    <?php 
        require('inc/head.php')
    ?>  
    <body>
        <?php
        require('inc/nav.php');
        ?>    

        <h1>Registro de Peladeiros na Pelada.</h1>

        <form name="escolhaapelada" method="post" action="">
            <label>Escolha a Pelada</label>
            <select name="selecaoPelada">
                <option value="0" <?php if(!$idPelada): echo 'selected="selected"'; endif; ?>>Nenhuma Selecionada</option>
                <?php
                $pelada = new Read;

                $pelada->ExeRead('pelada', 'ORDER BY id_pelada');
                if ($pelada->getResult()):
                    foreach ($pelada->getResult() as $dadosPelada):
                        extract($dadosPelada);                        
                        echo "<option values='" . $id_pelada . "'";
                        if($id_pelada == $_SESSION['idPelada']):
                            echo " selected = 'selected'>" . $nome_pelada . "</option>";
                        else:
                            echo ">" . $nome_pelada . "</option>";
                        endif;
                    endforeach;
                else:
                    //WSErro('Nenhuma pelada selecionada', WS_INFOR);
                    echo '<option value="">Nenhuma selecionada</option>';
                endif;
                ?>    
            </select>
            <input name="submitPelada" type="submit" value="Selecionar" />
        </form>

        <h1>Peladeiros da Pelada: <?php echo $_SESSION['nomePelada']; ?> </h1>

        <form name="escolhaopeladeiro" method="post" action="">
            <label>Escolha o Peladeiro</label>
            <select name="selecaoPeladeiro">
                <option value="0">Nenhuma Selecionada</option>
                <?php
                $peladeiro = new Read;

                $peladeiro->ExeRead('peladeiro', 'ORDER BY id_peladeiro');
                if ($peladeiro->getResult()):
                    foreach ($peladeiro->getResult() as $dadosPeladeiro):
                        extract($dadosPeladeiro);
                        echo "<option values='" . $id_peladeiro . "'>" . $nome_peladeiro . "</option>";
                    endforeach;
                else:
                    //WSErro('Nenhuma pelada selecionada', WS_INFOR);
                    echo '<option value="">Nenhuma selecionada</option>';
                endif;
                ?>    
            </select>
            <input name="submitPelada" type="submit" value="Vincular" />
        </form>            

        <br /><hr />        
        
        <table width="625" border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nome do Peladeiro</th>                    
                    <th>Posição Predominante</th>
                    <th>E-Mail</th>
                    <th>Data de Nascimento</th>
                    <th>Altura</th>
                    <th>Peso</th>
                    <th>Data de Cadastro</th>
                    <th>Excluir</th>
                </tr>    
            </thead>
            
            <tbody>
                <?php
                $peladeironapelada = new Read();
                $peladeironapelada->ExeRead('pelada_peladeiro', 'WHERE id_pelada = :idPelada ORDER BY id_pelada', 'idPelada='. $_SESSION['idPelada']);
                if($peladeironapelada->getResult()):
                    foreach ($peladeironapelada->getResult() as $resultPelada):
                        extract($resultPelada);                        

                        $readPeladeiro = new Read();
                        $readPeladeiro->ExeRead('peladeiro', 'WHERE id_peladeiro=:idPeladeiro', 'idPeladeiro='.$id_peladeiro);
                        if ($readPeladeiro->getResult()):
                            foreach ($readPeladeiro->getResult() as $resultPeladeiro):
                                extract($resultPeladeiro);
                        
                                $posicao = new Read();
                                $posicao->ExeRead('posicao','WHERE id_posicao = :idPosicao', 'idPosicao='.$posicao_predominante);
                                if($posicao->getResult()):
                                    foreach($posicao->getResult() as $dadosPosicao):
                                        $nomePosicao = $dadosPosicao['nome_posicao'];
                                    endforeach;
                                else:    
                                    WSErro('Desculpe, não existem posições cadastradas!', WS_INFOR);
                                endif;                           
                        
                                echo '<tr>';
                                echo '<td>' . $id_peladeiro . '</td>';
                                echo '<td>' . $nome_peladeiro . '</td>';
                                echo '<td>' . $nomePosicao . '</td>';
                                echo '<td>' . $email . '</td>';
                                echo '<td>' . $data_nascimento . '</td>';
                                echo '<td>' . $altura . '</td>';
                                echo '<td>' . $peso . '</td>';
                                echo '<td>' . $data_cadastro . '</td>';
                                echo '<td><a href="http://localhost:8080/psmanager/peladapeladeiro.php?excluir='.$id_peladeiro.'"><img src="img/delete1.png" '
                                        . 'alt="Excluir peladeiro" width=25 height=25></a></td>';
                                echo '</tr>';
                            endforeach;
                        else:
                            WSErro('Desculpe, Erro ao buscar peladeiro!', WS_ERROR);
                        endif;
                    endforeach;
                else:
                    WSErro('Não existem peladeiros vinculados a esta pelada!', WS_INFOR);
                endif;                
                ?>
            </tbody>
        </table>   
    </body>
</html>
