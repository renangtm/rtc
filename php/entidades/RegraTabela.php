<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegraTabela
 *
 * @author Renan
 */
class RegraTabela {

    public $id;
    public $condicional;
    public $resultante;
    public $interpretadorNumerico;
    public $interpretadorBooleano;

    function __construct() {

        $this->id = 0;
        $this->interpretadorBooleano = new InterpretadorBooleano();
        $this->interpretadorNumerico = new InterpretadorNumerico();
    }

    public function atende($cidade, $peso, $valor) {
        
        $obj = new stdClass();
        
        $obj->cliente = new stdClass();
        
        $obj->cliente->cidade = $cidade->nome;
        
        $obj->cliente->estado = $cidade->estado->sigla;
        
        $obj->peso = $peso;
        
        $obj->valor = $valor;
        
        $obj->icms = (100-Sistema::getIcmsEstado($cidade->estado))/100;
        
        $this->interpretadorBooleano->setVariaveis($obj);
        
        return $this->interpretadorBooleano->interpretar($this->condicional);
        
    }

    public function valor($cidade,$peso,$valor) {
        
        $obj = new stdClass();
        
        $obj->cliente = new stdClass();
        
        $obj->cliente->cidade = $cidade->nome;
        
        $obj->peso = $peso;
        
        $obj->valor = $valor;
        
        $obj->icms = (100-Sistema::getIcmsEstado($cidade->estado))/100;
        
        $this->interpretadorNumerico->setVariaveis($obj);
        
        return $this->interpretadorNumerico->interpretar($this->resultante);
        
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO regra_tabela(condicional,resultante) VALUES('" . addslashes($this->condicional) . "','" . addslashes($this->resultante) . "')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE regra_tabela SET condicional = '" . addslashes($this->condicional) . "', resultante = '" . addslashes($this->resultante) . "' WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("DELETE FROM regra_tabela WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }

}
