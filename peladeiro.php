<?php
include('verificasecao.php');

require('Classes/Config.inc.php');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$excluirId = filter_input(INPUT_GET, 'excluir',FILTER_VALIDATE_INT);
$pagina = filter_input(INPUT_GET, 'pagina',FILTER_VALIDATE_INT);

if(!isset($pagina)):
    $pagina = 1;
endif;

if(isset($dados) && $dados['submitPeladeiro']):
    unset($dados['submitPeladeiro']);
    $dados['data_cadastro'] = date('Y-m-d');

    $create = new Create();
    $create->ExeCreate('peladeiro', $dados);
    
    if($create->getResult()):
        echo 'Cadastro do peladeiro realizado com sucesso!';
    else:
        WSErro('O Registro do Peladeiro não pode ser inserido.', WS_ERROR);
    endif;
endif;

if($excluirId):
    $deleta = new Delete();
    $deleta->ExeDelete('peladeiro', 'WHERE id_peladeiro=:peladeiro', 'peladeiro='.$excluirId);
    if($deleta->getResult()):
        echo "{$deleta->getRowCount()} registro(s) removidos com sucesso!<hr>";
    endif;
    header("Location:http://localhost:8080/psmanager/peladeiro.php");
endif;
?>

<!DOCTYPE Html>
<html lang="pt_br">
    <head>
        <title>Pelada Soccer Manager</title>
        <meta charset="UTF-8">
    </head>    
    <body>
        <?php
            require('inc/nav.php');
        ?>              
        
        <h1>Cadastro do Peladeiro</h1>
        
        <form name="cadastropeladeiro" method="post" action="">
            <label>
                <span>Nome do Peladeiro</span>
                <input type="text" name="nome_peladeiro" value="" /><br />
            </label>
            <label>
                <span>Posição Predominante</span>
                <select name="posicao_predominante">
                    <option value="-1" selected="selected" disabled="disabled">Selecione</option>
                    <?php 
                        $posicao = new Read();
                        $posicao->ExeRead('posicao','ORDER BY id_posicao');
                        if($posicao->getResult()):
                            foreach($posicao->getResult() as $dadosPosicao):
                                extract($dadosPosicao);
                                echo '<option value="'.$id_posicao.'">'.$nome_posicao.'</option>';                             
                            endforeach;
                        else:    
                            WSErro('Desculpe, não existem posições cadastradas!', WS_INFOR);
                        endif;
                    ?>
                </select>    
            </label><br />
            <label>
                <span>E-mail</span>
                <input type="email" name="email" value="" /><br />
            </label>
            <label>
                <span>Data de Nascimento</span>
                <input type="date" name="data_nascimento" value="" /><br />
            </label>
            <label>
                <span>Altura</span>
                <input type="number" step="any" name="altura" value="" /><br />
            </label>
            <label>
                <span>Peso</span>
                <input type="number" step="any" name="peso" value="" /><br />
            </label>    
                        
            <input type="submit" name="submitPeladeiro" value="Cadastrar" />            
        </form>        

        <hr>  
        
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
                    $peladaQtd = new Read();
                    $peladaQtd->ExeRead('peladeiro', 'ORDER BY id_peladeiro');                  
                    
                    $qtdRegistrosPeladeiros = $peladaQtd->getRowCount();
                    $qtdRegistrosPagina = 10;
                    $numPaginas = ceil($qtdRegistrosPeladeiros/$qtdRegistrosPagina);
                    $registroInicial = ($pagina * $qtdRegistrosPagina) - $qtdRegistrosPagina;

                    $pelada = new Read();
                    $pelada->ExeRead('peladeiro', 'LIMIT :limit OFFSET :offset', 'limit='.$qtdRegistrosPagina.'&offset='.$registroInicial);
                    
                    if ($pelada->getResult()):                                                
                        foreach ($pelada->getResult() as $resultPelada):                                                    
                            extract($resultPelada);
                    
                            $posicao = new Read();
                            $posicao->ExeRead('posicao','WHERE id_posicao = :idPosicao', 'idPosicao='.$posicao_predominante);
                            if($posicao->getResult()):
                                foreach($posicao->getResult() as $dadosPosicao):
                                    $nomePosicao = $dadosPosicao['nome_posicao'];
                                endforeach;
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
                            echo '<td><a href="http://localhost:8080/psmanager/peladeiro.php?excluir='.$id_peladeiro.'"><img src="img/delete1.png" '
                                        . 'alt="Excluir peladeiro" width=25 height=25></a></td>';
                            echo '</tr>';
                        endforeach;                        
                    else:
                        WSErro('Desculpe, Ainda não existe peladeiro cadastrado!', WS_INFOR);
                    endif;  
                    
                    echo '<a href="http://localhost:8080/psmanager/peladeiro.php?pagina=1">First</a>';
                    for($i = 1; $i <= $numPaginas; $i++):
                        echo '<a href="http://localhost:8080/psmanager/peladeiro.php?pagina='.$i.'">'.$i.'</a>';
                    endfor;
                    echo '<a href="http://localhost:8080/psmanager/peladeiro.php?pagina='.$numPaginas.'">Last</a>';
                ?>
            </tbody>
            <form name="pesquisaPeladeiro" method="GET" action="">
                <label>
                    <span>Nome do Peladeiro</span>
                    <input type="text" name="nomePeladeiro" value="" />
                </label>
                
                <input type="submit" name="pesquisarNome" value="Pesquisar" />
            </form>
        </table>    
    </body>
</html>
