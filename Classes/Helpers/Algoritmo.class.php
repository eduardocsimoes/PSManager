<?php
class Algoritmo {
    private $algoritmo;
    private $qtdEquipes;
    private $idAgendamento;
    private $idPeladeiro;
    private $qtdPeladeiros;
    private $totaldePontos;
    private $mediaporEquipe;
    private $pontuacaodaEquipe;
    private $informacaoPeladeiro;
    private $informacaoPelada;
    private $informacaoHabilidade;
        
    public function escolhaAlgoritmo($Algoritmo){        
        $this->algoritmo = $Algoritmo;        
        $this->qtdEquipes = 3;
        $this->idAgendamento = 1;
        
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
    
    private function informacoesJogadores(){
        $agendamento_peladeiro = new Read();
        $agendamento_peladeiro->ExeRead("pelada_agendamento_peladeiro", "WHERE id_agendamento = :idAgendamento", "idAgendamento=".$this->idAgendamento);
        $this->qtdPeladeiros = $agendamento_peladeiro->getRowCount();
        
        foreach ($agendamento_peladeiro->getResult() as $agendamento):
            extract($agendamento);
            
            $peladeiro = new Read();
            $peladeiro->ExeRead("peladeiro_habilidade", "WHERE id_peladeiro = :idPeladeiro", "idPeladeiro=".$id_peladeiro);
            
            foreach ($peladeiro->getResult() as $player):
                extract($player);
                
                if(in_array($id_peladeiro, $this->informacaoPeladeiro)):
                    $this->informacaoPeladeiro['Peladeiro'][$id_peladeiro] = array(
                        'Habilidade' => array(
                            'id' => $id_habilidade,
                            'Nivel' => array(
                                'valor' => $nivel
                            )
                        )
                    );                   
                else:
                    $this->informacaoPeladeiro[] = array(
                        'Peladeiro' => array(
                            'id' => $id_peladeiro,
                            'Habilidade' => array(
                                'id' => $id_habilidade,
                                'Nivel' => array(
                                    'valor' => $nivel
                                )
                            )
                        )                   
                    );                    
                endif;                
            endforeach;
        endforeach;
    }  
    
    private function informacoesHabilidades(){                       
        foreach ($this->informacaoPeladeiro as $peladeiro => $valuePeladeiro): 
            foreach ($valuePeladeiro as $habilidade => $valueHabilidade):
                $this->informacaoHabilidade[] = $valueHabilidade['Habilidade']['id'];
                /*if(!in_array($habilidade[$id_habilidade], $this->informacaoHabilidades[$id_habilidade])):
                    $this->informacaoHabilidades[$id_habilidade];
                endif;*/
            endforeach;
        endforeach;
    }     
    
    private function getQtdJogadores(){        
        return $this->qtdPeladeiros;
    }
        
    private function getValorHabilidades(){
        return $this->informacaoHabilidades;
    }
    
    private function executaAlgoritmo(){
        if($this->algoritmo == 1):
            $this->mediaporEquipe = $this->totaldePontos/$this->qtdEquipes; 
        endif;
    }
}
?>
