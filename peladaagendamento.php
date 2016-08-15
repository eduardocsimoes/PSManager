<?php
include('verificasecao.php');

require('Classes/Config.inc.php');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$excluirData = filter_input(INPUT_GET, 'excluirdata');
$excluirHora = filter_input(INPUT_GET, 'excluirhora');

$nomePelada = 'Escolha uma Pelada';
//$nomePeladeiro = 'Escolha um Peladeiro';

if(!isset($_SESSION['idPelada'])):
    $_SESSION['idPelada'] = null;
endif;

if(isset($dados['selecaoPelada']) && $dados['selecaoPelada'] == 0):    
    $_SESSION['nomePelada'] = 'Escolha uma Pelada'; 
endif;

if(!isset($idPelada)):
    $idPelada = null;
endif;

if(!isset($dados['submitPelada'])):
    $dados['submitPelada'] = null;
endif;

if(!isset($_SESSION['nomePelada'])):    
    $_SESSION['nomePelada'] = 'Escolha uma Pelada';
endif;

if(!isset($dados['selecaoagendamento'])):
    $dados['selecaoagendamento'] = null;
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
    $data = $dados['data'];
    $hora = $dados['hora'];
    $local = $dados['local'];
    $qtd = $dados['qtd'];
    $situacao = 'A Confirmar';
    $dataCadastro = date('Y-m-d');

    $criarVinculo = new Create();    

    $dadosAgendamento = ['id_pelada' => $_SESSION['idPelada'], 'data_agendamento' => $data, 'hora_agendamento' => $hora, 
                       'nome_local' => $local, 'qtd_peladeiro_time' => $qtd, 'situacao_pelada' => $situacao, 'data_cadastro' => $dataCadastro];            
    $criarVinculo->ExeCreate('pelada_agendamento', $dadosAgendamento);  

    if($criarVinculo->getResult()==0):
        //WSErro('Cadastro realizado com sucesso!', WS_INFOR);
        echo 'Cadastro realizado com sucesso!';
    else:
        WSErro('Desculpe, Não foi possível agendar à pelada!', WS_ERROR);
    endif;
endif;

if($excluirData):  
    $deleta = new Delete();
    $deleta->ExeDelete('pelada_agendamento', 'WHERE id_pelada=":pelada" AND data_agendamento=":data" AND hora_agendamento=:hora',
                       'pelada='.$_SESSION['idPelada'].'&data='.$excluirData.'&hora='.$excluirHora);
    if($deleta->getResult()):
        echo "{$deleta->getRowCount()} registro(s) removidos com sucesso!<hr>";
    endif;
    header("Location:http://localhost:8080/psmanager/peladaagendamento.php");
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

        <h1>Agendamento da Pelada</h1>

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

        <h1>Pelada Selecionada: <?php echo $_SESSION['nomePelada']; ?> </h1>

        <form name="selecaoagendamento" method="POST" action="">
            <label>Escolha o Data</label>
            <input name="data" type="date" />
            <label>Escolha a Hora</label>
            <input name="hora" type="time" />
            <label>Informe o Local</label>
            <input name="local" type="text" />
            <label>Informe a Quantidade de Peladeiros por Time</label>
            <input name="qtd" type="number" />
            <input name="submitPelada" type="submit" value="Vincular" />
        </form>            

        <br /><hr />        
        
        <table width="625" border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nome da Pelada</th>                    
                    <th>Data da Pelada</th>
                    <th>Hora da Pelada</th>
                    <th>Nome do Local</th>
                    <th>Qtd de Peladeiro por Time</th>
                    <th>Situação da Pelada</th>
                    <th>Data de Cadastro</th>
                    <th>Excluir</th>
                </tr>    
            </thead>
            
            <tbody>
                <?php
                $peladaagendamento = new Read();
                $peladaagendamento->ExeRead('pelada_agendamento', 'WHERE id_pelada = :idPelada ORDER BY id_pelada', 'idPelada='. $_SESSION['idPelada']);
                if($peladaagendamento->getResult()):
                    foreach ($peladaagendamento->getResult() as $resultPelada):
                        extract($resultPelada); 
                
                        echo '<tr>';
                        echo '<td>' . $id_pelada . '</td>';
                        echo '<td>' . $nome_pelada . '</td>';
                        echo '<td>' . $data_agendamento . '</td>';
                        echo '<td>' . $hora_agendamento . '</td>';
                        echo '<td>' . $nome_local . '</td>';
                        echo '<td>' . $qtd_peladeiro_time . '</td>';
                        echo '<td>' . $situacao_pelada . '</td>';
                        echo '<td>' . $data_cadastro . '</td>';
                        echo '<td><a href="http://localhost:8080/psmanager/peladaagendamento.php?excluirdata='.$data_agendamento.
                                  '&excluirhora='.$hora_agendamento.'"><img src="img/delete1.png"'
                                . 'alt="Excluir peladeiro" width=25 height=25></a></td>';
                        echo '</tr>';
                    endforeach;
                else:
                    WSErro('Não existem agendamentos vinculados a esta pelada!', WS_INFOR);
                endif;                
                ?>
            </tbody>
        </table>   
    </body>
</html>
