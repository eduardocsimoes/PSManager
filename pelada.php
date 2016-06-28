<?php
require('Classes/Config.inc.php');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$excluirId = filter_input(INPUT_GET, 'excluir',FILTER_VALIDATE_INT);

if(isset($dados) && $dados['submitPelada']):
    unset($dados['submitPelada']);
    $dados['data_cadastro'] = date('Y-m-d');
    $dados['id_peladeiro'] = 1;

    $create = new Create();
    $create->ExeCreate('pelada', $dados);
    
    if($create->getResult()):
        echo 'Cadastro da pelada realizada com sucesso!';
    else:
        WSErro('O Registro da Pelada não pode ser inserido.', WS_ERROR);
    endif;
endif;

if($excluirId):
    $deleta = new Delete();
    $deleta->ExeDelete('pelada', 'WHERE id_pelada=:pelada', 'pelada='.$excluirId);
    if($deleta->getResult()):
        echo "{$deleta->getRowCount()} registro(s) removidos com sucesso!<hr>";
    endif;
    header("Location:http://localhost:8080/psmanager/pelada.php");
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
        
        <h1>Cadastro da Pelada</h1>
 
        <form name="cadastropelada" method="post" action="">
            <label>Nome da Pelada</label>
            <input type="text" name="nome_pelada" value="" />
                        
            <input type="submit" name="submitPelada" value="Cadastrar" />
            
        </form>        
        
        <hr />
        
        <table width="625" border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nome da Pelada</th>                    
                    <th>Data do Cadastro</th>
                    <th>Usuário de registro</th>
                    <th>Excluir Pelada</th>
                </tr>    
            </thead>
            <tbody>
                <?php
                    $pelada = new Read();
                    $pelada->ExeRead('pelada', 'ORDER BY id_pelada');
                    if ($pelada->getResult()):                                                
                        foreach ($pelada->getResult() as $resultPelada):                                                    
                            extract($resultPelada);
                            echo '<tr>';
                            echo '<td>' . $id_pelada . '</td>';
                            echo '<td>' . $nome_pelada . '</td>';
                            echo '<td>' . $data_cadastro . '</td>';
                            echo '<td>' . $id_peladeiro . '</td>';
                            echo '<td><a href="http://localhost:8080/psmanager/pelada.php?excluir='.$id_pelada.'"><img src="img/delete1.png" '
                                        . 'alt="Excluir pelada" width=25 height=25></a></td>';
                            echo '</tr>';
                        endforeach;                        
                    else:
                        WSErro('Desculpe, Ainda não existe pelada cadastrada!', WS_INFOR);
                    endif;                       
                ?>
            </tbody>
        </table>
        
        <br /><hr><br />       
    </body>
</html>
