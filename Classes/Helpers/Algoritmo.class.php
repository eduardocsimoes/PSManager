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
    private $informacaoPeladeiroE;
    private $informacaoPelada;
    private $informacaoHabilidade;
    private $qtdPeladeirosporEquipe;
    private $qtdTotalJogadoresEquipes;
    private $incluirGoleiro;
    private $equipes;
    private $jogadoresExcedentes;
    private $qtdJogadoresExcedentes;
    private $temRevesamento;
    private $valorExcedente;
    private $selecaoEquipe;
    private $mediaJogadoresEquipes;
    
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

    public function getInformacaoPeladeiroE(){
        return $this->informacaoPeladeiroE;
    } 
    
    public function getInformacaoHabilidade(){
        return $this->informacaoHabilidade;
    }             

    public function getInformacaoHabilidadeFinal(){
        return $this->informacaoHabilidadeD;
    }    
    
    public function getQtdJogadores(){        
        return $this->qtdPeladeiros;
    }

    public function getQtdEquipes(){        
        return $this->qtdEquipes;
    }
    
    public function getMediaTotalEquipes(){        
        return $this->mediaporEquipe;
    }

    public function getEquipes(){        
        return $this->equipes;
    }
    
    public function getJogadoresExcedentes() {
        return $this->jogadoresExcedentes;
    }
    
    public function getMediaJogadoresEquipe(){
        for($i=0;$i<$this->qtdEquipes;$i++):
            for($j=0;$j<count($this->equipes[$i]);$j++):
                if(isset($this->mediaJogadoresEquipes[$i]['valor'])):
                    $this->mediaJogadoresEquipes[$i]['valor'] = (float) $this->mediaJogadoresEquipes[$i]['valor'] + (float) $this->equipes[$i][$j]['habilidade'][1];
                else:
                    $this->mediaJogadoresEquipes[$i]['valor'] = (float) $this->equipes[$i][$j]['habilidade'][1];
                endif;
            endfor;            
        endfor;
        
        return $this->mediaJogadoresEquipes;
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
            foreach($conjuntoHabilidade->getResult() as $Indice2):
                extract($Indice2);
            
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
        $this->valorExcedente = 0;
        
        if($this->algoritmo == 1):
            if(is_array($this->jogadoresExcedentes)):
                foreach($this->jogadoresExcedentes as $jogExcedentes):
                    $this->valorExcedente += $this->informacaoPeladeiro[$jogExcedentes]['habilidade'][1];
                endforeach;
            else:
                $this->valorExcedente += $this->informacaoPeladeiro[$this->jogadoresExcedentes]['habilidade'][1];
            endif;
            
            $this->totaldePontos = $this->informacaoHabilidade[1] - $this->valorExcedente;
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
    
    private function executaAlgoritmo(){        
        $this->definirRegrasFormacao();
        
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
            
            for($i=0;$i<=max(array_keys($this->informacaoPeladeiroD));$i++):                
                $isEmpty = null;
            
                if(isset($this->informacaoPeladeiroD[$i])):
                    for($l=$i;$l>=0;$l--):                        
                        if(!isset($this->informacaoPeladeiroD[$l])):
                            $isEmpty = $l;
                        endif;                        
                    endfor;
                endif;
                
                if(isset($isEmpty)):
                    $this->informacaoPeladeiroD[$isEmpty] = $this->informacaoPeladeiroD[$i];
                    unset($this->informacaoPeladeiroD[$i]);
                endif;
            endfor;
        endif;    

        $this->setMediaporEquipe();
        $this->somaJogadoresEquipe(); 
        
        if($this->algoritmo == 1):
            /*for($i=0;$i<count($this->informacaoPeladeiroD);$i++):                
                for($j=$i+1;$j<count($this->informacaoPeladeiroD);$j++):
                    if(($this->informacaoPeladeiroD[$j]['habilidade'][1] > $this->informacaoPeladeiroD[$i]['habilidade'][1])):
                        $arrayAux = $this->informacaoPeladeiroD[$i];
                        $this->informacaoPeladeiroD[$i] = $this->informacaoPeladeiroD[$j];
                        $this->informacaoPeladeiroD[$j] = $arrayAux;
                    endif;
                endfor;
            endfor;*/
            
            $this->informacaoPeladeiroE = $this->informacaoPeladeiroD;            
            
            $this->selecaoEquipe = 0;
/*            for($i=0;$i<count($this->informacaoPeladeiroE);$i++):
                $this->equipes[$this->selecaoEquipe][] = array (
                    'id' => $this->informacaoPeladeiroE[$i]['id'],
                    'nome' => $this->informacaoPeladeiroE[$i]['nome'],
                    'posicao' => $this->informacaoPeladeiroE[$i]['posicao'],
                    'habilidade' => $this->informacaoPeladeiroE[$i]['habilidade']
                );
            
                array_shift($this->informacaoPeladeiroE);

                if($this->selecaoEquipe < ($this->qtdEquipes - 1)):
                    $this->selecaoEquipe++;
                else:
                    $this->selecaoEquipe = 0;
                    array_reverse($this->informacaoPeladeiroE);
                endif;

                //$this->somaJogadoresEquipe();
            endfor;
*/
/*
            $aux = current($this->informacaoPeladeiroE);
            for($i=0;$i<18;$i++):            
                $this->equipes[$this->selecaoEquipe][] = array (
                    'id' => $aux['id'],
                    'nome' => $aux['nome'],
                    'posicao' => $aux['posicao'],
                    'habilidade' => $aux['habilidade']
                );

                array_shift($this->informacaoPeladeiroE);                

                if($this->selecaoEquipe < ($this->qtdEquipes - 1)):
                    $this->selecaoEquipe++;
                    $aux = current($this->informacaoPeladeiroE);
                else:
                    $this->selecaoEquipe = 0;
                    $this->informacaoPeladeiroE = array_reverse($this->informacaoPeladeiroE);
                    $aux = current($this->informacaoPeladeiroE);
                endif;
            endfor;
 */
//            sort($this->informacaoPeladeiroE[]['habilidade'][1], SORT_NUMERIC);
            for($i=0;$i<18;$i++): 
                if(!isset($this->equipes)):
                    for($i=0;$i<$this->qtdEquipes;$i++):
                        $jogador = $this->maxValorArray($this->informacaoPeladeiroE);
                        $this->equipes[$i][] = $jogador;                        
                        unset($this->informacaoPeladeiroE[array_search($jogador, $this->informacaoPeladeiroE)]);
                    endfor;
                else:
                    
                endif;
            endfor;    
        endif;
    }
    
    private function minValorArray($array){
        $valor = 0;
        $valorAnt = 0;
        $valorFinal = 0;

        foreach($array as $Indice1):
            $valor = $Indice1['habilidade'][1];

            if($valor <= $valorAnt):
                $arrayFinal = $Indice1;
            endif;

            $valorAnt = $valor;
        endforeach;
        
        return $arrayFinal;
    }

    private function maxValorArray($array){
        $valor = 0;
        $valorAnt = 0;
        $valorFinal = 0;

        foreach($array as $Indice1):
            $valor = $Indice1['habilidade'][1];

            if($valor > $valorAnt):
                $arrayFinal[] = array('valor' => $valor, 'valorant' => $valorAnt);
            endif;

            $valorAnt = $valor;
        endforeach;
        
        return $arrayFinal;
    }    
}
/*SAIMON
ALVIN
TEODOR
BRITANI
JANETE
ELEONOR*/
?>