<?php
    require('./Classes/Config.inc.php');
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
?>

<!DOCTYPE Html>
<html lang="pt_br">
    <head>
        <title>Pelada Soccer Manager</title>
        <meta charset="UTF-8">
        
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
        <script type="text/javascript" src="<?= INCLUDE_PATH; ?>/js/scriptjs.js"></script>
    </head>    
    <body class="body_home no-select">
        
        <div class="controleusuario">
            <form class="formcontroleusuario" method="POST" action="">
                <input type="email" name="email" class="inputs" placeholder="E-Mail" />
                <input type="password" name="pass" class="inputs" placeholder="Senha" />
                <input type="submit" name="logar" class="btnentrar" value="Entrar">
            </form>
            
            <div class="auxiliar">
                <input type="checkbox" class="manterlogado" value="1" /><label>Manter Logado</label>
                <a href="#">Lembrar Senha</a>
            </div>  
            
            <div class="cadastro">
                <button name="cadastre" class="btncadastrarusuario">CADASTRE-SE</button>
                <div class="formcadastro">                  
                    
                <div class="modalcadastro">
                    <!-- Modal content -->    
                </div>
                <div class="modal_cadastro">
                    <img src="ico/close1.png" class="btnfecharcadastro" width="20px" height="20px">                    
                    <div class="modal-head">
                        <label>CRIE SUA CONTA</label>                        
                    </div>                    
                    <div class="modal-head-box"></div>
                    <div class="modal-head-msg"></div>
                    <div class="modal-body">
                        <form method="POST" class="formcadastrousuario" action="">
                            <input type="text" name="nome" placeholder="Primeiro Nome" required="required" /><br />
                            <input type="text" name="sobrenome" placeholder="Segundo Nome" required="required" /><br />
                            <input type="text" name="apelido" placeholder="Apelido" required="required" /><br />
                            <input type="email" name="email" value="" placeholder="E-mail" required="required" /><br />
                            <input type="date" name="data_nascimento" value="" placeholder="Data de Nascimento" required="required" /><br />            
                            <select name="posicao_predominante" required="required">
                                <option value="-1" selected="selected" disabled="disabled">Selecione Posição</option>
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
                            </select><br />
                            <input type="password" name="pass" placeholder="Digite sua Senha" /><br />
                            <input type="text" name="lembrete" placeholder="Lembrete da Senha" required="required" /><br />
                            <input type="checkbox" name="terms" value="1" /><label>Eu aceito os <a href="#" class="terms">Termos e Condições</a> e as <a href="#" class="terms">Políticas de Privacidade</a></label>

                            <input type="submit" name="submitPeladeiro" value="Cadastrar" />
                            <div><?php echo $dados['submitPeladeiro']; ?></div>
                        </form>
                    </div>                   
                </div>
            </div>
        </div>
    </body>
</html>