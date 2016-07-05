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
            $qtdEquipes = $algoritmo->getQtdEquipes();
            var_dump($qtdEquipes);
            $mediaEquipes = $algoritmo->getMediaEquipes();
            var_dump($mediaEquipes);
            $equipes = $algoritmo->getEquipes();
            var_dump($equipes);
            $jogadoresExcedentes = $algoritmo->getJogadoresExcedentes();
            var_dump($jogadoresExcedentes);
        ?>
    </body>
</html>
