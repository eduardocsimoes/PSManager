<?php
    include('verificasecao.php');
    require('Classes/Config.inc.php');
?>

<html>
    <?php 
        require('inc/head.php')
    ?> 
    
    <body>
        <?php
            require('inc/nav.php');
        ?>
        
        <?php 
            $algoritmo = new Algoritmo();
            
            $algoritmo->EscolhaAlgoritmo(1);            
            /*$peladeiro = $algoritmo->getInformacaoPeladeiro();
            var_dump($peladeiro);*/

            /*$peladeiroD = $algoritmo->getInformacaoPeladeiroD();
            var_dump($peladeiroD);*/

            /*$peladeiroE = $algoritmo->getInformacaoPeladeiroE();
            var_dump($peladeiroE);*/
            
            $equipes = $algoritmo->getEquipes();
            var_dump($equipes);            
                                 
            /*$qtdEquipes = $algoritmo->getQtdEquipes();
            var_dump($qtdEquipes);*/
            /*$qtdJogadores = $algoritmo->getQtdJogadores();
            var_dump($qtdJogadores);*/
            $jogadoresExcedentes = $algoritmo->getJogadoresExcedentes();
            var_dump($jogadoresExcedentes);
            $informacaoGoleiros = $algoritmo->getInformacaoGoleiros();
            var_dump($informacaoGoleiros);
            $habilidade = $algoritmo->getInformacaoHabilidade();
            var_dump($habilidade);
            $mediaTotalEquipes = $algoritmo->getMediaTotalEquipes();            
            var_dump($mediaTotalEquipes);                    
            $mediaEquipes = $algoritmo->getMediaJogadoresEquipe();
            var_dump($mediaEquipes);
        ?>
    </body>
</html>
