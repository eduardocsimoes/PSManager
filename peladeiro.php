<?php
include('verificasecao.php');

require('Classes/Config.inc.php');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$excluirId = filter_input(INPUT_GET, 'excluir',FILTER_VALIDATE_INT);
$pagina = filter_input(INPUT_GET, 'pagina',FILTER_VALIDATE_INT);
$nomePesquisado = filter_input(INPUT_GET, 'nomePeladeiro',FILTER_SANITIZE_STRING);
$pesquisarNome = filter_input(INPUT_GET, 'pesquisarNome',FILTER_SANITIZE_STRING);

if(!isset($pagina)):
    $pagina = 1;
endif;

if(!isset($pesquisarNome)):
    $pesquisarNome = '';
endif;

if(!isset($nomePesquisado)):
    $nomePesquisado = '';
endif;

if(isset($dados) && isset($dados['submitPeladeiro'])):
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
    <?php 
        require('inc/head.php')
    ?>
    
    <body>
        <?php
            require('inc/nav.php');
        ?>              
        
        <div class="cabecalhoAreaTabela">
            <h1 class="tituloCadastroTabela">Cadastro de Peladeiro</h1>
            
            <div class="detalheAreaTabela">
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
            </div>    

            <hr>  
        
            <div id="pager" class="pager">
                <div class="page">
                    <form>
                        <img src="ico/first.png" class="first" title="Primeiro"/>
                        <img src="ico/prev.png" class="prev" title="Anterior"/>
                        <input type="text" class="pagedisplay" value="<?php echo $pagina; ?>"/>
                        <img src="ico/next.png" class="next" title="Próximo"/>
                        <img src="ico/last.png" class="last" title="Último"/>
                    </form>
                </div>
                
                <div class="search">
                    <form name="pesquisaPeladeiro" method="POST" action="">
                        <label for="pesquisarPeladeiro">Pesquisar</label>
                        <input type="text" class="pesquisarTabela" name="pesquisarPeladeiro" value="" />
                    </form> 
                </div>    
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th class="header">id</th>
                        <th class="header">Peladeiro</th>                    
                        <th class="header">Posição</th>
                        <th class="header">E-Mail</th>
                        <th class="header">Nascimento</th>
                        <th class="header">Altura</th>
                        <th class="header">Peso</th>                    
                        <th class="header">Cadastro</th>
                        <th>Ações</th>
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

                        if($pesquisarNome != 'Pesquisar'):
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
                                    echo '<td><a href="http://localhost:8080/psmanager/peladeiro.php?editar='.$id_peladeiro.'"><img src="ico/edit.png" '
                                                . 'alt="Editar peladeiro"  width="16" height="16"></a>'.'&nbsp&nbsp&nbsp'.
                                            '<a href="http://localhost:8080/psmanager/peladeiro.php?excluir='.$id_peladeiro.'"><img src="ico/delete.png" '
                                                . 'alt="Excluir peladeiro"  width="16" height="16"></a></td>';
                                    echo '</tr>';
                                endforeach;                        
                            else:
                                WSErro('Desculpe, Ainda não existe peladeiro cadastrado!', WS_INFOR);
                            endif;  
                        else:
                            $pelada = new Read();
                            $pelada->ExeRead('peladeiro', "WHERE nome_peladeiro LIKE '".$nomePesquisado."%'");

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
                                    echo '<td>' . $id_paeladeiro . '</td>';
                                    echo '<td>' . $nome_peladeiro . '</td>';
                                    echo '<td>' . $nomePosicao . '</td>';
                                    echo '<td>' . $email . '</td>';
                                    echo '<td>' . $data_nascimento . '</td>';
                                    echo '<td>' . $altura . '</td>';
                                    echo '<td>' . $peso . '</td>';
                                    echo '<td>' . $data_cadastro . '</td>';
                                    echo '<td><a href="http://localhost:8080/psmanager/peladeiro.php?editar='.$id_peladeiro.'"><img src="ico/edit.png" '
                                                . 'alt="Editar peladeiro"  width="16" height="16"></a>'.'&nbsp&nbsp&nbsp'.
                                            '<a href="http://localhost:8080/psmanager/peladeiro.php?excluir='.$id_peladeiro.'"><img src="ico/delete.png" '
                                                . 'alt="Excluir peladeiro"  width="16" height="16"></a></td>';
                                    echo '</tr>';
                                endforeach;                        
                            else:
                                WSErro('Desculpe, Ainda não existe peladeiro cadastrado!', WS_INFOR);
                            endif;                          
                        endif;
                        /*
                        echo '<a href="http://localhost:8080/psmanager/peladeiro.php?pagina=1">First</a>';
                        for($i = 1; $i <= $numPaginas; $i++):
                            echo '<a href="http://localhost:8080/psmanager/peladeiro.php?pagina='.$i.'">'.$i.'</a>';
                        endfor;
                        echo '<a href="http://localhost:8080/psmanager/peladeiro.php?pagina='.$numPaginas.'">Last</a>';
                        */
                    ?>
                </tbody>
            </table>    
        </div>
    </body>
</html>
