<?php
require('Classes/Config.inc.php');
?>

<html>
    <body>
        <?php 
            $algoritmo = new Algoritmo();
            
            $algoritmo->EscolhaAlgoritmo(1);            
            $peladeiro = $algoritmo->getInformacaoPeladeiro();
            var_dump($peladeiro);

            $peladeiroD = $algoritmo->getInformacaoPeladeiroD();
            var_dump($peladeiroD);
            
            $habilidade = $algoritmo->getInformacaoHabilidade();
            var_dump($habilidade);
                        
            $qtdJogadores = $algoritmo->getQtdJogadores();
            var_dump($qtdJogadores);
            $jogadoresExcedentes = $algoritmo->getJogadoresExcedentes();
            var_dump($jogadoresExcedentes);            
            $mediaEquipes = $algoritmo->getMediaEquipes();
            var_dump($mediaEquipes);
            $qtdEquipes = $algoritmo->getQtdEquipes();
            var_dump($qtdEquipes);            
            $equipes = $algoritmo->getEquipes();
            var_dump($equipes);
        ?>
    </body>
</html>
