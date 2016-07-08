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
    private $informacaoPeladeiroD;
    private $informacaoPelada;
    private $informacaoHabilidade;
    private $qtdPeladeirosporEquipe;
    private $qtdTotalJogadoresEquipes;
    private $incluirGoleiro;
    private $equipes;
    private $jogadoresExcedentes;
    private $qtdJogadoresExcedentes;
    private $temRevesamento;
    public $msg1;
    
    public function escolhaAlgoritmo($Algoritmo){        
        $this->algoritmo = $Algoritmo;        
        $this->qtdEquipes = 3;
        $this->idAgendamento = 1;
        $this->maxEquipes = 3;
        $this->qtdPeladeirosporEquipe = 6;
        $this->incluirGoleiro = 'S';
        $this->qtdTotalJogadoresEquipes = 0;
        
        $this->informacoesJogadores();
        $this->informacoesHabilidades();
        $this->executaAlgoritmo();       
    }
        
    public function getInformacaoPeladeiro(){
        return $this->informacaoPeladeiro;
    }    

    public function getInformacaoPeladeiroD(){
        return $this->informacaoPeladeiroD;
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
    
    public function getJogadoresExcedentes() {
        return $this->jogadoresExcedentes;
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
            $this->qtdJogadoresExcedentes = $this->qtdPeladeiros - ($this->maxEquipes * $this->qtdPeladeirosporEquipe);
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
            $this->qtdTotalJogadoresEquipes += count($this->equipes[$e]);
        endfor;                
    }
/*    
    public function getMsg(){
        return $this->msg;
    }
*/
    private function executaAlgoritmo(){        
        $this->setMediaporEquipe();
        $this->definirRegrasFormacao();
        $this->somaJogadoresEquipe();
        
        $this->informacaoPeladeiroD = $this->informacaoPeladeiro;
        
        if($this->temRevesamento == 'S'):
            $this->jogadoresExcedentes = array_rand($this->informacaoPeladeiroD, $this->qtdJogadoresExcedentes);
            if(is_array($this->jogadoresExcedentes)):
                for($j=0;$j<count($this->jogadoresExcedentes);$j++):
                    unset($this->informacaoPeladeiroD[$this->jogadoresExcedentes[$j]]);
                endfor;                
            else:
                unset($this->informacaoPeladeiroD[$this->jogadoresExcedentes]);            
            endif;
            
            /*if(!isset($this->informacaoPeladeiroD[0])):
                $this->informacaoPeladeiroD[0][0] = null;
            endif;*/
            
            for($i=0;$i<=max(array_keys($this->informacaoPeladeiroD));$i++):                
                $isEmpty = null;
                //$this->msg[$i] = $i;
                if(isset($this->informacaoPeladeiroD[$i])):
                    for($l=$i;$l>=0;$l--):
                        //$this->msg[$i][$l] = 'erro';
                        if(!isset($this->informacaoPeladeiroD[$l])):
                            $isEmpty = $l;
                            //$this->msg[$i][$l] = $l;
                        endif;                        
                    endfor;
                endif;
                
                if(isset($isEmpty)):
                    //$this->informacaoPeladeiroD = $hasEmpty;
                    $this->informacaoPeladeiroD[$isEmpty] = $this->informacaoPeladeiroD[$i];
                    unset($this->informacaoPeladeiroD[$i]);
                endif;
            endfor;
        endif;    

        //$this->informacaoPeladeiroD = array_filter($this->informacaoPeladeiroD);        
        
        if($this->algoritmo == 1):
            for($e=0;$e<$this->qtdEquipes;$e++):
                $this->equipes[] = array(
                    'id' => $e
                );
            endfor;            
                        
            for($i=0;$i<count($this->informacaoPeladeiroD);$i++):                
                for($j=$i+1;$j<count($this->informacaoPeladeiroD);$j++):
                    if(($this->informacaoPeladeiroD[$j]['habilidade'][1] > $this->informacaoPeladeiroD[$i]['habilidade'][1])):
                        $arrayAux = $this->informacaoPeladeiroD[$i];
                        $this->informacaoPeladeiroD[$i] = $this->informacaoPeladeiroD[$j];
                        $this->informacaoPeladeiroD[$j] = $arrayAux;
                    endif;
                    //$this->informacaoPeladeiroD[$i][$j] = 'teste';
                endfor;
            endfor;
/*

            while($this->qtdTotalJogadoresEquipes < count($this->informacaoPeladeiro)):
                for($i=0;$i<$this->qtdEquipes;$i++):
                    $this->equipes[$i] = array (
                        'jogador' => $this->informacaoPeladeiroD[0]
                    );
                    array_shift($this->informacaoPeladeiroD);                    
                endfor;
                    
                array_reverse($this->informacaoPeladeiroD);
                
                $this->somaJogadoresEquipe();                
            endwhile;*/
        endif;
    }
}
/*
SAIMON
ALVIN
TEODOR
BRITANI
JANETE
ELEONOR*/
?>