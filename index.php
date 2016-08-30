<?php
    session_start();
    require('./Classes/Config.inc.php');
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);    
     
    $email = (isset($_COOKIE['CookieEmail'])) ? base64_decode($_COOKIE['CookieEmail']) : '';
    $senha = (isset($_COOKIE['CookieSenha'])) ? base64_decode($_COOKIE['CookieSenha']) : '';
    $lembrete = (isset($_COOKIE['CookieLembrete'])) ? base64_decode($_COOKIE['CookieLembrete']) : '';
    $checked = ($lembrete == 1) ? 'checked' : '';
    
    if(isset($_SESSION["id_peladeiro"])){
        header("Location: home.php");
        exit;
    }        
?>

<!DOCTYPE Html>
<html lang="pt_br">
    <?php 
        require('inc/head.php')
    ?>
    
    <body class="body_home no-select">
        
        <div class="controleusuario">
            <form class="formcontroleusuario" method="POST" action="">
                <input type="email" name="email" class="inputs" placeholder="E-Mail" value="<?= $email ?>" required="required" />
                <input type="password" name="pass" class="inputs" placeholder="Senha" value="<?= $senha ?>" required="required" />                
                <input type="submit" name="submitLogar" class="btnentrar" value="Entrar" />
                <div class="auxiliar">
                    <input type="checkbox" class="lembrete" name="lembrete" value="1" <?= $checked ?> /><label>Lembrar Usuário</label>
                    <a href="#">Lembrar Senha</a>
                </div>
            </form>
            
            <div class="cadastro">
                <button name="cadastre" class="btncadastrarusuario">CADASTRE-SE</button>
                <div class="controleusuario-form-msg"></div>                 
                    
                <div class="modalcadastro">
                    <!-- Modal content -->    
                </div>
                <div class="modal_cadastro">
                    <div class="btnfecharcadastro">
                        <img src="ico/close1.png" width="20px" height="20px">
                    </div>    
                    <div class="modal-head">
                        <label>CRIE SUA CONTA</label>                        
                    </div>                    
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
                            <input type="password" name="pass" placeholder="Digite sua Senha" required="required" /><br />
                            <input type="text" name="lembrete" placeholder="Lembrete da Senha" required="required" /><br />
                            <input type="checkbox" name="terms" value="1" /><label>Eu aceito os <a href="#" class="terms">Termos e Condições</a> e as <a href="#" class="terms">Políticas de Privacidade</a></label>
                            

                            <div class="modal-head-msg"></div>
                            
                            <input type="submit" name="submitPeladeiro" value="Cadastrar" />
                            
                        </form>
                    </div>                   
                </div>
            </div>
        </div>
    </body>
</html>