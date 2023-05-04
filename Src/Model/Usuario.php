<?php

/**
 * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
 * ║                                               CONTROLE FINANCEIRO                                                 ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ @description: Class model of Usuario                                                                        │  ║
 * ║  | @dir: Model                                                                                                 │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 09/03/23                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 */

namespace model;



class Usuario {

    private int $id;

    private string $nome;

    private string $email;

    private string $status;

    private string $created;

    private string $updated;


    public function __construct()
    {
        
    }

    public function getId() : int {
        return $this->id;
    }

    public function getNome() : string {
        return $this->nome;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function getStatus() : string {
        return $this->status;
    }

    public function getCreated() : string {
        return $this->created;
    }

    public function getUpdated() : string {
        return $this->updated;
    }


    
    public function setId (int $id){
        $this->id = $id;
    }

    public function setNome (string $nome){
        $this->nome = $nome;
    }

    public function setEmail (string $email){
        $this->email = $email;
    }

    public function setStatus (string $status){
        $this->status = $status;
    }

    public function setCreated (string $Created){
        $this->created = $Created;
    }

    public function setUpdated (string $updated){
        $this->updated = $updated;
    }


}