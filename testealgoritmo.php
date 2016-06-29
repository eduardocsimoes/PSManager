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
            $habilidade = $algoritmo->getInformacaoHabilidade();
            var_dump($habilidade);
        ?>
    </body>
</html>
