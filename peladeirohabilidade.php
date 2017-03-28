<?php
include('verificasecao.php');

require('Classes/Config.inc.php');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$excluirId = filter_input(INPUT_GET, 'excluir',FILTER_VALIDATE_INT);

//$nomePelada = 'Escolha uma Pelada';
$_SESSION['nomePeladeiro'] = 'Escolha um Peladeiro';
$idPeladeiro = null;
$idHabilidade = null;

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
    $nomeHabilidade = $dados['selecaoHabilidade'];
    $nivel = $dados['selecaoNivel'];
    $dataCadastro = date('Y-m-d');

    $habilidade = new Read();
    $criarVinculo = new Create();    

    $habilidade->ExeRead('habilidade', 'WHERE nome_habilidade = :nome_habilidade', 'nome_habilidade='.$nomeHabilidade);
    if ($habilidade->getResult()):
        foreach($habilidade->getResult() as $resultHabilidade):            
            extract($resultHabilidade);
            $idHabilidade = $id_habilidade;
            
            $dadosHabilidade = ['id_peladeiro' => $_SESSION['idPeladeiro'], 'id_habilidade' => $idHabilidade, 'nivel' => $nivel, 'data_cadastro' => $dataCadastro];            
            $criarVinculo->ExeCreate('peladeiro_habilidade', $dadosHabilidade);  

            if($criarVinculo->getResult()==0):
                //WSErro('Cadastro realizado com sucesso!', WS_INFOR);
                echo 'Cadastro realizado com sucesso!';
            else:
                WSErro('Desculpe, Não foi possível vincular o peladeiro à habilidade!', WS_ERROR);
            endif;
        endforeach;  
    else:
        WSErro('Nenhuma habilidade selecionada', WS_INFOR);        
    endif;
endif;

if($excluirId):
    $deleta = new Delete();
    $deleta->ExeDelete('peladeiro_habilidade', 'WHERE id_habilidade=:habilidade AND id_peladeiro=:peladeiro', 'peladeiro='.$_SESSION['idPeladeiro'].'&habilidade='.$excluirId);
    if($deleta->getResult()):
        echo "{$deleta->getRowCount()} registro(s) removidos com sucesso!<hr>";
    endif;
    header("Location:http://localhost:8080/psmanager/peladeirohabilidade.php");
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

        <h1>Registro de Habilidades do Peladeiro</h1>

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

        <h1>Habilidades do Peladeiro: <?php echo $_SESSION['nomePeladeiro']; ?> </h1>

        <form name="escolhahabilidade" method="POST" action="">            
            <label>
                <span>Escolha a Posicao/Nível</span>
                <select name="selecaoHabilidade">
                    <option value="0" <?php if(!$idHabilidade): echo "selected=selected"; endif; ?>>Nenhuma Selecionada</option>
                    <?php
                        $habilidade = new Read();
                        
                        $habilidade->ExeRead('habilidade', 'ORDER BY id_habilidade');
                        if($habilidade->getResult()):
                            foreach($habilidade->getResult() as $dadosHabilidade):
                                extract($dadosHabilidade);
                                echo '<option values="' . $id_habilidade . '">' . $nome_habilidade . '</option>';
                            endforeach;
                        else:
                            WSErro('Nenhuma habilidade selecionada', WS_INFOR);
                        endif;
                    ?>
                </select> 
                
                <select name="selecaoNivel">
                    <option value="0.0">0.0</option>
                    <option value="0.5">0.5</option>
                    <option value="1.0">1.0</option>
                    <option value="1.5">1.5</option>
                    <option value="2.0">2.0</option>
                    <option value="2.5" selected="selected">2.5</option>
                    <option value="3.0">3.0</option>
                    <option value="3.5">3.5</option>
                    <option value="4.0">4.0</option>
                    <option value="4.5">4.5</option>
                    <option value="5.0">5.0</option>
                </select>            
            </label>
            
            <input name="submitPeladeiro" type="submit" value="Vincular" />
        </form>
        
        <table width="625" border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nome da Habilidade</th> 
                    <th>Nível</th>
                    <th>Excluir</th>
                </tr>    
            </thead>
            
            <tbody>
                <?php
                $peladeirohabilidade = new Read();
                $peladeirohabilidade->ExeRead('peladeiro_habilidade', 'WHERE id_peladeiro = :idPeladeiro ORDER BY id_habilidade', 'idPeladeiro='. $_SESSION['idPeladeiro']);
                if($peladeirohabilidade->getResult()):
                    foreach ($peladeirohabilidade->getResult() as $resultPeladeiro):
                        extract($resultPeladeiro);                        

                        $habilidade = new Read();
                        $habilidade->ExeRead('habilidade', 'WHERE id_habilidade = :idHabilidade', 'idHabilidade=' . $id_habilidade);
                        if ($habilidade->getResult()):
                            foreach ($habilidade->getResult() as $dadosHabilidade):                            
                                $nomeHabilidade = $dadosHabilidade['nome_habilidade'];
                            endforeach;
                        else:
                            WSErro('Desculpe, não existem habilidades cadastradas!', WS_INFOR);
                        endif;

                        echo '<tr>';
                        echo '<td>' . $id_habilidade . '</td>';
                        echo '<td>' . $nomeHabilidade . '</td>';
                        echo '<td>' . $nivel . '</td>';
                        echo '<td><a href="http://localhost:8080/psmanager/peladeirohabilidade.php?excluir=' . $id_habilidade . '"><img src="img/delete1.png" '
                        . 'alt="Excluir peladeiro_posicao" width=25 height=25></a></td>';
                        echo '</tr>';
                    endforeach;
                else:
                    WSErro('Não existem habilidades vinculadas a este peladeiro!', WS_INFOR);
                endif;                
                ?>
            </tbody>
        </table>  
        
        <script>
            $(document).ready(function(){
                $('.nivel').html( $('.selecaoNivel').val() );
                $('.selecaoNivel').change(function(){
                    $('.nivel').html( $('.selecaoNivel').val() );
                });                
            });
        </script>          
    </body>
</html>
