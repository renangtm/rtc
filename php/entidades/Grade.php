<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grade
 *
 * @author Renan
 */
class Grade {
    
    public $gr;
    public $str;
    
    function __construct($str="1") {
        
        $this->str = $str;
        $this->gr = array();
        
        $ex = explode(',',$str);
        
        foreach($ex as $key=>$value){
            
            $ex = intval($value);
            
            if($ex < 1)break;
            
            $this->gr[] = $ex;
            
        }
        
    }
    
    public function fractalizar($quantidade, $retiradas){
        
        return $this->gerar($quantidade,$retiradas,null, array(0));
        
    }
    
    private function gerar($quantidade, $retiradas, $pai, $k){
        
        foreach ($retiradas as $key=>$value){
            
            if(count($value)==count($k)){
                
                for($i=0;$i<count($value);$i++){
                    
                    if($k[$i]!=$value[$i])
                        continue 2;
                    
                }
                
                return null;
                
            }
            
        }
        
        $clone_k = array();
        
        foreach($k as $key=>$value){
            $clone_k[] = $value;
        }
        
        if((count($k)-1) == count($this->gr)){
            
            $it = new Item();
            $it->quantidade = $quantidade;
            $it->quantidade_filhos = 0;
            $it->removivel = true;
            $it->pai = $pai;
            $it->numero = $clone_k;
            
            return $it;
            
        }
        
        $it = new Item();
        $it->quantidade = 0;
        $it->pai = $pai;
        $it->numero = $clone_k;
        
        $q = $this->gr[count($k)-1];
        
        $z = count($k);
        
        $y = 0;
        $i = 0;
        while($quantidade>0){
            
            $quantidade -= $q;
            
            if($quantidade<0){
                
                $q += $quantidade;
                
            }
            
            $k[$z] = $i;
            
            $f = $this->gerar($q, $retiradas, $it, $k);
            
            unset($k[$z]);
            
            $it->filhos[] = $f;
            
            if($f != null){
                
                $it->quantidade += $f->quantidade;
                $y++;
                
            }
            
            $i++;
        }
        
        $it->quantidade_filhos = $y;
        
        if($y==1){
            
            foreach($it->filhos as $key=>$value){
                
                if($value!=null){
                    
                    if($value->removivel){
                        
                        $it->removivel = true;
                        
                        $it->filhos[$key] = null;
                        
                        $it->quantidade_filhos = 0;
                        
                    }
                    
                    break;
                    
                }
                
            }
            
            
        }
        
        return $it;
        
    }
    
}
