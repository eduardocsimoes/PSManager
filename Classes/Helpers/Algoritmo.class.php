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
    private $incluirGoleiro;
    
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
    
    private function getTotaldePontos(){
        if($this->algoritmo == 1):
            $this->totaldePontos = $this->informacaoHabilidade[1];
        endif;        
    }
    
    private function getMediaporEquipe(){
        $this->getTotaldePontos();
        

        if($this->algoritmo == 1):
            $this->mediaporEquipe = $this->totaldePontos/$this->qtdEquipes;
        endif;  
    }

    private function definirRegraFormacao(){
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
    
    private function executaAlgoritmo(){        
        $this->getMediaporEquipe();
        $this->definirRegrasFormacao();
        
        if($this->algoritmo == 1):

        endif;
    }
}
?>
