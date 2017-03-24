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
    private $jogadoresExcedentesAux;
    private $qtdJogadoresExcedentes;
    private $temRevesamento;
    private $valorExcedente;
    private $selecaoEquipe;
    private $mediaJogadoresEquipes;
    private $informacaoGoleiros;
    
    public function escolhaAlgoritmo($Algoritmo){        
        $this->algoritmo = $Algoritmo;        
        $this->qtdEquipes = 4;
        $this->idAgendamento = 1;
        $this->maxEquipes = 4;
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

    public function getInformacaoGoleiros() {
        return $this->informacaoGoleiros;
    }
    
    public function getMediaJogadoresEquipe(){
        for($i=0;$i<$this->qtdEquipes;$i++):
            for($j=0;$j<count($this->equipes[$i]);$j++):
                if(isset($this->mediaJogadoresEquipes[$i]['valor'])):
                    if(isset($this->equipes[$i][$j])):
                        $this->mediaJogadoresEquipes[$i]['valor'] = (float) $this->mediaJogadoresEquipes[$i]['valor'] + (float) $this->equipes[$i][$j]['habilidade'][1];
                    endif;
                else:
                    if(isset($this->equipes[$i][$j])):
                        $this->mediaJogadoresEquipes[$i]['valor'] = (float) $this->equipes[$i][$j]['habilidade'][1];
                    endif;
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

    private function somaJogadoresEquipe(){
        for($e=0;$e<count($this->equipes);$e++):
            $this->qtdTotalJogadoresEquipes += count($this->equipes[$e]);
        endfor;                  
    }
    
    private function executaAlgoritmo(){
        $this->informacaoPeladeiroD = $this->informacaoPeladeiro;
        
        if($this->incluirGoleiro != 'S'):
            foreach($this->informacaoPeladeiroD as $retirarGoleiros):
                if($retirarGoleiros['posicao'] == 1):
                    $this->informacaoGoleiros[] = $retirarGoleiros;
                    unset($this->informacaoPeladeiroD[array_search($retirarGoleiros, $this->informacaoPeladeiroD)]);
                endif;
            endforeach;
        endif;
        
        //if (($this->qtdPeladeiros / $this->qtdEquipes) > $this->maxEquipes):
        if((count($this->informacaoPeladeiroD) / $this->qtdEquipes) > $this->maxEquipes):
            $this->temRevesamento = 'S';
            //$this->qtdJogadoresExcedentes = $this->qtdPeladeiros - ($this->maxEquipes * $this->qtdPeladeirosporEquipe);
            $this->qtdJogadoresExcedentes = count($this->informacaoPeladeiroD) - ($this->maxEquipes * $this->qtdPeladeirosporEquipe);
        
            $this->jogadoresExcedentesAux = array_rand($this->informacaoPeladeiroD, $this->qtdJogadoresExcedentes);

            if(is_array($this->jogadoresExcedentesAux)):
                for($j=0;$j<count($this->jogadoresExcedentesAux);$j++):
                    $this->jogadoresExcedentes[] = $this->informacaoPeladeiroD[$this->jogadoresExcedentesAux[$j]];
                    unset($this->informacaoPeladeiroD[$this->jogadoresExcedentesAux[$j]]);
                endfor;                
            else:
                $this->jogadoresExcedentes[] = $this->informacaoPeladeiroD[$this->jogadoresExcedentesAux];
                unset($this->informacaoPeladeiroD[$this->jogadoresExcedentesAux]);            
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
        else:
            $this->temRevesamento = 'N';
            $this->qtdJogadoresExcedentes = 0;
            $this->jogadoresExcedentes = null;            
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

            while(!empty($this->informacaoPeladeiroE)):                            
                if(empty($this->equipes)):
                    for($i=0;$i<$this->qtdEquipes;$i++):
                        $jogador = $this->maxValorArray($this->informacaoPeladeiroE);
                        $this->equipes[$i][] = $jogador;
                        unset($this->informacaoPeladeiroE[array_search($jogador, $this->informacaoPeladeiroE)]);
                        $this->informacaoPeladeiroE = array_filter($this->informacaoPeladeiroE);
                    endfor;
                    
                    $ultFuncao = "max";
                else:                    
                    if($ultFuncao == "max"):
                        for($i=0;$i<$this->qtdEquipes;$i++):
                            if (isset($this->informacaoPeladeiroE)):
                                $jogador = $this->minValorArray($this->informacaoPeladeiroE);
                                $this->equipes[$i][] = $jogador;
                                unset($this->informacaoPeladeiroE[array_search($jogador, $this->informacaoPeladeiroE)]);                                
                                $this->informacaoPeladeiroE = array_filter($this->informacaoPeladeiroE);
                            endif;                            
                        endfor;
                        
                        $ultFuncao = "min";
                    else:
                        for($i=0;$i<$this->qtdEquipes;$i++):
                            if (isset($this->informacaoPeladeiroE)):
                                $jogador = $this->maxValorArray($this->informacaoPeladeiroE);
                                $this->equipes[$i][] = $jogador;
                                unset($this->informacaoPeladeiroE[array_search($jogador, $this->informacaoPeladeiroE)]);
                                $this->informacaoPeladeiroE = array_filter($this->informacaoPeladeiroE);
                            endif;
                        endfor;

                        $ultFuncao = "max";
                    endif;
                endif;
            endwhile;
            //endfor;
        endif;
    }

    private function maxValorArray($array){
        $valor = 0;
        $maiorValor = 0;

        foreach($array as $Indice1):
            $valor = $Indice1['habilidade'][1];

            if(($valor > $maiorValor)):
                $maiorValor = $valor;
                $arrayFinal = $Indice1;
            endif;
        endforeach;
        
        return $arrayFinal;
    }     
    
    private function minValorArray($array){
        $valor = 0;
        $menorValor = -1;

        foreach($array as $Indice1):
            $valor = $Indice1['habilidade'][1];

            if(($valor <= $menorValor) || $menorValor = -1):
                $menorValor = $valor;
                $arrayFinal = $Indice1;                
            endif;
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