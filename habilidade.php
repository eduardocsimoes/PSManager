<?php
include('verificasecao.php');
require('Classes/Config.inc.php');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$excluirId = filter_input(INPUT_GET, 'excluir',FILTER_VALIDATE_INT);

if(isset($dados) && $dados['submitHabilidade']):
    unset($dados['submitHabilidade']);
    $dados['data_cadastro'] = date('Y-m-d');

    $create = new Create();
    $create->ExeCreate('habilidade', $dados);
    
    if($create->getResult()):
        echo 'Cadastro da habilidade realizada com sucesso!';
    else:
        WSErro('O Registro de habilidade não pode ser inserido.', WS_ERROR);
    endif;
endif;

if($excluirId):
    $deleta = new Delete();
    $deleta->ExeDelete('habilidade', 'WHERE id_habilidade=:habilidade', 'habilidade='.$excluirId);
    if($deleta->getResult()):
        echo "{$deleta->getRowCount()} registro(s) removidos com sucesso!<hr>";
    endif;
    header("Location:http://localhost:8080/psmanager/habilidade.php");
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
        
        <h1>Cadastro da Habilidades</h1>
 
        <form name="cadastrohabilidade" method="post" action="">
            <label>Nome da Habilidade</label>
            <input type="text" name="nome_habilidade" value="" />
                        
            <input type="submit" name="submitHabilidade" value="Cadastrar" />
            
        </form>        
        
        <hr />
        
        <table width="625" border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nome da Habilidade</th>                    
                    <th>Data do Cadastro</th>
                    <th>Excluir</th>
                </tr>    
            </thead>
            <tbody>
                <?php
                    $habilidade = new Read();
                    $habilidade->ExeRead('habilidade', 'ORDER BY id_habilidade');
                    if ($habilidade->getResult()):                                                
                        foreach ($habilidade->getResult() as $resulthabilidade):
                            extract($resulthabilidade);
                            echo '<tr>';
                            echo '<td>' . $id_habilidade . '</td>';
                            echo '<td>' . $nome_habilidade . '</td>';
                            echo '<td>' . $data_cadastro . '</td>';     
                            echo '<td><a href="http://localhost:8080/psmanager/habilidade.php?excluir='.$id_habilidade.'"><img src="img/delete1.png" '
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
