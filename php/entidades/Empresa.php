<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fornecedor
 *
 * @author Renan
 */
class Empresa {

    public $id;
    public $nome;
    public $email;
    public $telefone;
    public $endereco;
    public $cnpj;
    public $excluida;
    public $consigna;
    public $aceitou_contrato;
    public $juros_mensal;
    public $inscricao_estadual;
    
    function __construct() {

        $this->id = 0;
        $this->email = null;
        $this->telefone = null;
        $this->endereco = null;
        $this->email = null;
        $this->excluida = false;
        $this->cnpj = new CNPJ("");
        $this->aceitou_contrato = false;
        $this->consigna = false;
        $this->juros_mensal = 0;
  
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO empresa(nome,excluida,inscricao_estadual,consigna,aceitou_contrato,juros_mensal,cnpj) VALUES('" . addslashes($this->nome) . "',false,'" . $this->inscricao_estadual . "'," . ($this->consigna?"true":"false") . ",".($this->aceitou_contrato?"true":"false").",$this->juros_mensal,'".$this->cnpj->valor."')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE empresa SET nome='" . addslashes($this->nome) . "',excluida=false,inscricao_estadual = '" . addslashes($this->inscricao_estadual) . "', consigna=".($this->consigna?"true":"false").",aceitou_contrato=".($this->aceitou_contrato?"true":"false").", juros_mensal=" . $this->juros_mensal . ", cnpj='".$this->cnpj->valor."' WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }
        
        $this->email->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE email SET id_entidade=" . $this->id . ", tipo_entidade='EMP' WHERE id = " . $this->email->id);
        $ps->execute();
        $ps->close();

        $this->endereco->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE endereco SET id_entidade=" . $this->id . ", tipo_entidade='EMP' WHERE id = " . $this->endereco->id);
        $ps->execute();
        $ps->close();
        
        $this->telefone->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE telefone SET id_entidade=" . $this->id . ", tipo_entidade='EMP' WHERE id = " . $this->telefone->id);
        $ps->execute();
        $ps->close();

        
    }

    
    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE empresa SET excluida = true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }
    
    public function getFiliais($con){
        
        $ids = $this->id;
        
        for($i=0;$i<count(explode(',', $ids));$i++){
            
            $id = explode(',',$ids);
            $id = $id[$i];
            
            $ps = $con->getConexao()->prepare("SELECT CASE WHEN id_empresa1 <> $id THEN id_empresa1 ELSE id_empresa2 END FROM filial WHERE (id_empresa1=$id OR id_empresa2=$id) AND (CASE WHEN id_empresa1 <> $id THEN id_empresa1 ELSE id_empresa2 END) NOT IN ($ids)");
            $ps->execute();
            $ps->bind_result($id_filial);
            while($ps->fetch()){
                $ids .= ",$id_filial";
            }
            $ps->close();
            
        }
   
        $ps = $con->getConexao()->prepare("SELECT "
                . "empresa.id,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco.numero,"
                . "endereco.id,"
                . "endereco.rua,"
                . "endereco.bairro,"
                . "endereco.cep,"
                . "cidade.id,"
                . "cidade.nome,"
                . "estado.id,"
                . "estado.sigla,"
                . "email.id,"
                . "email.endereco,"
                . "email.senha,"
                . "telefone.id,"
                . "telefone.numero "
                . "FROM empresa "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE empresa.id IN ($ids) AND empresa.id <> $this->id");
        $ps->execute();
        $filiais = array();
        $ps->bind_result($id_empresa,$nome_empresa,$inscricao_empresa,$consigna,$aceitou_contrato,$juros_mensal,$cnpj,$numero_endereco,$id_endereco,$rua,$bairro,$cep,$id_cidade,$nome_cidade,$id_estado,$nome_estado,$id_email,$endereco_email,$senha_email,$id_telefone,$numero_telefone);
        
        while($ps->fetch()){
            
            $empresa = new Empresa();
            $empresa->id = $id_empresa;
            $empresa->cnpj = new CNPJ($cnpj);
            $empresa->inscricao_estadual = $inscricao_empresa;
            $empresa->nome = $nome_empresa;
            $empresa->aceitou_contrato = $aceitou_contrato;
            $empresa->juros_mensal = $juros_mensal;
            $empresa->consigna = $consigna;
            
            $endereco = new Endereco();
            $endereco->id = $id_endereco;
            $endereco->rua = $rua;
            $endereco->bairro = $bairro;
            $endereco->cep = new CEP($cep);
            $endereco->numero = $numero_endereco;
            
            $cidade = new Cidade();
            $cidade->id = $id_cidade;
            $cidade->nome = $nome_cidade;
            
            $estado = new Estado();
            $estado->id = $id_estado;
            $estado->sigla = $nome_estado;
            
            $cidade->estado = $estado;
            
            $endereco->cidade = $cidade;
            
            $empresa->endereco = $endereco;
            
            $email = new Email($endereco_email);
            $email->id = $id_email;
            $email->senha = $senha_email;
            
            $empresa->email = $email;
            
            $telefone = new Telefone($numero_telefone);
            $telefone->id = $id_telefone;

            $empresa->telefone = $telefone;
            
            $filiais[] = $empresa;
            
        }
        
        return $filiais;
        
    }
    

}
