<?php

/**
 * Classe: Despensa
 * Data: 27/02/23
 */

 namespace model;

 Class Despensas{

    private string $descricao;

    private float $valor;
    
    private string $data;
    
    private string $ano;
    
    private string $quinzena;
    
    private string $status;


    public function __construct()
    {
        
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function getValor(){
        return $this->valor;
    }

    public function getData(){
        return $this->data;
    }

    public function getAno(){
        return $this->ano;
    }

    public function getQuinzena(){
        return $this->quinzena;
    }

    public function getStatus(){
        return $this->status;
    }



    public function setDescricao(string $descricao){
        $this->descricao = $descricao;
    }

    public function setValor(float $valor){
        $this->valor = $valor;
    }

    public function setData(string $data){
        $this->data = $data;
    }

    public function setAno(string $ano){
        $this->ano = $ano;
    }

    public function setQuinzena(string $quinzena){
        $this->quinzena = $quinzena;
    }

    public function setStatus(string $status){
        $this->status = $status;
    }
 }