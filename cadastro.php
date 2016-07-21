<div class="modalcadastro">
    <!-- Modal content -->    
</div>
    <div class="modal_cadastro">
        <img src="ico/close1.png" class="btnfecharcadastro" width="20px" height="20px">
        <div class="modal-head">
            <label>CRIE SUA CONTA</label>
        </div>
        <div class="modal-body">
            <form method="POST" class="formcadastrousuario" action="">
                <input type="text" name="firstname" placeholder="Primeiro Nome" required="required" /><br />
                <input type="text" name="secondname" placeholder="Segundo Nome" required="required" /><br />
                <input type="text" name="nickname" placeholder="Apelido" required="required" /><br />
                <input type="email" name="email" value="" placeholder="E-mail" required="required" /><br />
                <input type="date" name="data_nascimento" value="" placeholder="Data de Nascimento" required="required" /><br />            
                <select name="position" required="required">
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
                <input type="checkbox" name="terms" value="1" /><label>Eu aceito os <a href="#" class="terms">Termos e Condições</a> e as <a href="#" class="terms">Políticas de Privacidade</a></label>

                <input type="submit" name="submitPeladeiro" value="Cadastrar" />
            </form>
        </div>
    </div>