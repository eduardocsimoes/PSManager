<?php
class Algoritmo {
    private $Algoritmo;
    private $QtdEquipes;
    private $id_agendamento;
    private $idPeladeiro;
    private $QtdPeladeiros;
    private $TotaldePontos;
    private $MediaporEquipe;
    private $PontuacaodaEquipe;
    
    public function EscolhaAlgoritmo($Algoritmo){        
        $this->Algoritmo = $Algoritmo;        
        $this->QtdEquipes = 3;
        $id_agendamento = 1;
        
        $this->InformacoesJogadores();
        $this->ExecutaAlgoritmo();       
    }

    private function InformacoesJogadores(){
        $agendamento_peladeiro = new Read();
        $agendamento_peladeiro->ExeRead("pelada_agendamento_peladeiro", "WHERE id_agendamento = :idAgendamento", "idAgendamento=".$id_agendamento);
        $qtdPeladeiros = $agendamento_peladeiro->getRowCount();
                
        foreach ($agendamento_peladeiro->getResult() as $agendamento):
            $idPeladeiro -> $agendamento["id_peladeiro"];
            
            $peladeiro = new Read();
            $peladeiro->ExeRead("peladeiro", "WHERE id_peladeiro = idPeladeiro", "idPeladeiro=".$id_peladeiro);
            
            foreach ($peladeiro->getResult() as $player):
                extract($player);
            
                
            endforeach;
        endforeach;
    }
    
    private function ExecutaAlgoritmo(){
        if($this->Algoritmo == 1):
            $this->MediaporEquipe = $this->TotaldePontos/$this->QtdEquipes; 
        endif;
    }
}
?>
