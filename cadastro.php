<div class="modalcadastro">
    <!-- Modal content -->    
</div>
    <div class="modal_cadastro">
        <div class="btnfecharcadastro">X</div>
        <div class="modal-head">
            <label>Crie sua Conta</label>
        </div>
        <div class="modal-body">
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

            <input type="submit" name="submitPeladeiro" value="Cadastrar" />
        </div>
    </div>