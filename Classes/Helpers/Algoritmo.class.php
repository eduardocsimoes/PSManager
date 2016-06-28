<?php
class Algoritmo {
    private $Algoritmo;
    private $QtdEquipes;
    
    public function EscolhaAlgoritmo($Algoritmo){
        $this->Algoritmo = $Algoritmo;
        $this->QtdEquipes = 3;
        $this->InformacoesJogadores();
        $this->ExecutaAlgoritmo();       
    }

    private function InformacoesJogadores(){
        $peladeiros = new Read();
        $peladeiros->ExeRead("", $Termos)
    }
    
    private function ExecutaAlgoritmo(){
        if($this->Algoritmo == 1):
            
        endif;
    }
}
?>
