<?php
require('Classes/Config.inc.php');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$excluirId = filter_input(INPUT_GET, 'excluir',FILTER_VALIDATE_INT);

if(isset($dados) && $dados['submitPosicao']):
    unset($dados['submitPosicao']);
    $dados['data_cadastro'] = date('Y-m-d');

    $create = new Create();
    $create->ExeCreate('posicao', $dados);
    
    if($create->getResult()):
        echo 'Cadastro da posição realizada com sucesso!';
    else:
        WSErro('O Registro da Pelada não pode ser inserido.', WS_ERROR);
    endif;
endif;

if($excluirId):
    $deleta = new Delete();
    $deleta->ExeDelete('posicao', 'WHERE id_posicao=:posicao', 'posicao='.$excluirId);
    if($deleta->getResult()):
        echo "{$deleta->getRowCount()} registro(s) removidos com sucesso!<hr>";
    endif;
    header("Location:http://localhost:8080/psmanager/posicao.php");
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
        
        <h1>Cadastro da Posição</h1>
 
        <form name="cadastroposicao" method="post" action="">
            <label>Nome da Posição</label>
            <input type="text" name="nome_posicao" value="" />
                        
            <input type="submit" name="submitPosicao" value="Cadastrar" />
            
        </form>        
        
        <hr />
        
        <table width="625" border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nome da Posição</th>                    
                    <th>Data do Cadastro</th>
                    <th>Excluir</th>
                </tr>    
            </thead>
            <tbody>
                <?php
                    $posicao = new Read();
                    $posicao->ExeRead('posicao', 'ORDER BY id_posicao');
                    if ($posicao->getResult()):                                                
                        foreach ($posicao->getResult() as $resultPosicao):
                            extract($resultPosicao);
                            echo '<tr>';
                            echo '<td>' . $id_posicao . '</td>';
                            echo '<td>' . $nome_posicao . '</td>';
                            echo '<td>' . $data_cadastro . '</td>'; 
                            echo '<td><a href="http://localhost:8080/psmanager/posicao.php?excluir='.$id_posicao.'"><img src="img/delete1.png" '
                                        . 'alt="Excluir pelada" width=25 height=25></a></td>';                            
                            echo '</tr>';
                        endforeach;                        
                    else:
                        WSErro('Desculpe, ainda não existe posição cadastrada!', WS_INFOR);
                    endif;                       
                ?>
            </tbody>
        </table>
        
        <br /><hr><br />       
    </body>
</html>
