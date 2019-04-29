<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cidade
 *
 * @author Renan
 */
class ProdutoEncomendaParceiro {

    public $id;
    public $nome;
    public $categoria;
    public $ativo;
    public $unidade;
    public $fabricante;
    public $imagem;
    public $valor_base_inicial;
    public $valor_base_final;
    public $empresa;
    public $grade;
    public $valor_base;
    public $custo_atualizado;
    public $ofertas;
    public $disponivel;
    public $estoque;
    public $transito;
    public $imagem_padrao;

    function __construct() {

        $this->id = 0;
        $this->nome = "";
        $this->disponivel = 0;
        $this->estoque = 0;
        $this->transito = 0;
        $this->categoria = null;
        $this->ativo = "";
        $this->fabricante = "";
        $this->unidade = "";
        $this->valor_base = 0;
        $this->valor_base_inicial = 0;
        $this->valor_base_final = 0;
        $this->empresa = "";
        $this->imagem = "";
        $this->grade = "";
        $this->custo_atualizado = false;
        $this->ofertas = 0;
        $this->imagem_padrao = "";
    }

    public function setImagemPadrao() {

        if ($this->unidade === "Frc") {

            $this->imagem_padrao = "assets/images/img_emb_padrao_FRC_1L.png";
        } else if ($this->unidade === "Pct") {

            $this->imagem_padrao = "assets/images/img_emb_padrao_PCT.png";
        } else if ($this->unidade === "Gl") {

            $this->imagem_padrao = "assets/images/img_emb_padrao_GL_5L.png";
        } else if ($this->unidade === "Bd") {

            $this->imagem_padrao = "assets/images/img_emb_padrao_BD_20L.png";
        } else if ($this->unidade === "Sc") {

            $this->imagem_padrao = "assets/images/img_emb_padrao_SC.png";
        } else if ($this->unidade === "Env") {

            $this->imagem_padrao = "assets/images/img_emb_padrao_ENV.png";
        } else if ($this->unidade === "Ob") {

            $this->imagem_padrao = "assets/images/img_emb_padrao_ENV.png";
        } else if ($this->unidade === "Amp") {

            $this->imagem_padrao = "";
        }
    }

}
