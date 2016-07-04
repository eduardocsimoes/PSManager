<?php
class Algoritmo {
    private $algoritmo;
    private $qtdEquipes;
    private $maxEquipes;
    private $idAgendamento;
    private $idPeladeiro;
    private $qtdPeladeiros;
    private $totaldePontos;
    private $mediaporEquipe;
    private $pontuacaodaEquipe;
    private $informacaoPeladeiro;
    private $informacaoPelada;
    private $informacaoHabilidade;
    private $qtdPeladeirosporEquipe;
    private $qtdTotalJogadoresEquipes;
    private $incluirGoleiro;
    private $equipes;
    
    public function escolhaAlgoritmo($Algoritmo){        
        $this->algoritmo = $Algoritmo;        
        $this->qtdEquipes = 3;
        $this->idAgendamento = 1;
        $this->maxEquipes = 3;
        $this->qtdPeladeirosporEquipe = 6;
        $this->incluirGoleiro = 'S';
        
        $this->informacoesJogadores();
        $this->informacoesHabilidades();
        $this->executaAlgoritmo();       
    }
        
    public function getInformacaoPeladeiro(){
        return $this->informacaoPeladeiro;
    }    

    public function getInformacaoHabilidade(){
        return $this->informacaoHabilidade;
    }             
    
    public function getQtdJogadores(){        
        return $this->qtdPeladeiros;
    }

    public function getQtdEquipes(){        
        return $this->qtdEquipes;
    }
    
    public function getMediaEquipes(){        
        return $this->mediaporEquipe;
    }

    public function getEquipes(){        
        return $this->equipes;
    }
    
    private function informacoesJogadores(){
        $agendamento_peladeiro = new Read();
        $agendamento_peladeiro->ExeRead("pelada_agendamento_peladeiro", "WHERE id_agendamento = :idAgendamento", "idAgendamento=".$this->idAgendamento);
        $this->qtdPeladeiros = $agendamento_peladeiro->getRowCount();
        
        foreach ($agendamento_peladeiro->getResult() as $agendamento):
            extract($agendamento);            
        
            $peladeiro = new Read();
            $peladeiro->ExeRead("peladeiro", "WHERE id_peladeiro = :idPeladeiro", "idPeladeiro=".$id_peladeiro);
            
            foreach ($peladeiro->getResult() as $Indice1):                
                extract($Indice1);                                
                $this->informacaoPeladeiro[] = array(
                    'id' => $id_peladeiro,
                    'nome' => $nome_peladeiro,
                    'posicao' => $posicao_predominante
                );                
            endforeach;
        endforeach;
        
        $conjuntoHabilidade = new Read();
        
        for($i=0;$i<count($this->informacaoPeladeiro);$i++):
            $idPeladeiro = $this->informacaoPeladeiro[$i]['id'];
        
            $conjuntoHabilidade->ExeRead("peladeiro_habilidade", "WHERE id_peladeiro = :idPeladeiro ORDER BY id_habilidade", "idPeladeiro=".$idPeladeiro);
            foreach($conjuntoHabilidade->getResult() as $Indice1):
                extract($Indice1);
            
                $this->informacaoPeladeiro[$i]['habilidade'][$id_habilidade] = $nivel;
            endforeach;
        endfor;          
    }  
    
    private function informacoesHabilidades(){          
        $this->informacaoHabilidade = null;
        
        foreach($this->informacaoPeladeiro as $Indice1):
            foreach($Indice1['habilidade'] as $Indice2 => $valueIndice2):
                if(isset($this->informacaoHabilidade[$Indice2])):
                    $this->informacaoHabilidade[$Indice2] += (float) $valueIndice2;
                else:
                    $this->informacaoHabilidade[$Indice2] = (float) $valueIndice2;
                endif;                
            endforeach;
        endforeach;
    }     
    
    private function setTotaldePontos(){
        if($this->algoritmo == 1):
            $this->totaldePontos = $this->informacaoHabilidade[1];
        endif;        
    }

    private function setQtdEquipes(){                
        if(($this->qtdPeladeiros/$this->qtdPeladeirosporEquipe) <= $this->maxEquipes):
            $this->qtdEquipes = ceil($this->qtdPeladeiros/$this->qtdPeladeirosporEquipe);
        else:
            $this->qtdEquipes = $this->maxEquipes;
        endif;
    }
    
    private function setMediaporEquipe(){
        $this->setTotaldePontos();
        $this->setQtdEquipes();
        
        if($this->algoritmo == 1):
            $this->mediaporEquipe = $this->totaldePontos/$this->qtdEquipes;
        endif;  
    }

    private function definirRegrasFormacao(){
        if (($this->qtdPeladeiros / $this->qtdEquipes) > $this->maxEquipes):
            $this->temRevesamento = 'S';
        else:
            $this->temRevesamento = 'N';
        endif;
        
        if ($this->incluirGoleiro == 'S'):
            //Desenvolver regra para distribuir primeiramente os goleiros
        else:
            //Desenvolver regra para distribuir primeiramente os goleiros
        endif;        
    }

    private function somaJogadoresEquipe(){
        for($e=0;$e<count($this->equipes);$e++):
            $this->$qtdTotalJogadoresEquipes += count($this->equipes[$e]);
        endfor;                
    }
    
    private function executaAlgoritmo(){        
        $this->setMediaporEquipe();
        $this->definirRegrasFormacao();
        $this->somaJogadoresEquipe();
        
        if($this->algoritmo == 1):
            for($e=0;$e<$this->qtdEquipes;$e++):
                $this->equipes[] = array(
                    'id' => $e
                );
            endfor;
            
            $arrayC = $this->informacaoPeladeiro;
            for($i=0;$i<count($arrayC);$i++):
                for($j=$i;$j<count($arrayC);$j++):
                    if($arrayC[$j]['habilidade'][1] < $arrayC[$i]['habilidade'][1]):
                        $arrayAux = $arrayC[$i];
                        $arrayC[$i] = $arrayC[$j];                        
                        $arrayC[$j] = $arrayAux;
                    endif;
                endfor;
            endfor;

            $arrayD = $this->informacaoPeladeiro;
            for($i=0;$i<count($arrayD);$i++):
                for($j=$i;$j<count($arrayD);$j++):
                    if($arrayD[$j]['habilidade'][1] > $arrayD[$i]['habilidade'][1]):
                        $arrayAux = $arrayD[$i];
                        $arrayD[$i] = $arrayD[$j];                        
                        $arrayD[$j] = $arrayAux;
                    endif;
                endfor;
            endfor;    
            
            while($this->$qtdTotalJogadoresEquipes < count($this->informacaoPeladeiro)):
                
                
                $this->somaJogadoresEquipe();
            endwhile;
            /*for($i=0;$i<count($this->informacaoPeladeiro);$i++):
                
                $this->$qtdTotalJogadoresEquipes;
            endfor;*/
            
            if(isset($arrayD)):
                $this->informacaoPeladeiro = $arrayD;
            endif;  
            
            
/*
            // Compara se $a é maior que $b
            function cmp($a, $b) {
                return $a['habilidade'] > $b['nome'];
            }
 
            // Ordena
            usort($this->informacaoPeladeiro, 'cmp');
*/                     

        endif;
    }
}
?>
