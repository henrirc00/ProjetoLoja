<?php

class endereco{
    public $id;
    public $logradouro;
    public $numero;
    public $complemento;
    public $bairro;
    public $cep;
    


    public function __construct($db){
        $this->conexao = $db;
    }



    /*
    Função listar para selecionar todos os endereco cadastrados no banco de dados. 
    Essa função retorna uma lista com todos os dados.
    */
    public function listar(){
        #Seleciona todos os campos da tabela endereco
        $query = "select * from endereco";
        /*
         Foi criada a variavel stmt(Statment -> Sentença) para guardar a preparacao da consulta 
         select que será executada posteriomente.
         */
        $stmt = $this->conexao->prepare($query);
        #execução da consulta e guarda de dados na variavel stmt 

        $stmt->execute();
        #retorna os dados do usuário a camada data.

        return $stmt;
    }

 

    /*
    Função para cadastrar os enderecos no banco de dados 
    */
    public function cadastro(){
        $query = "insert into endereco set logradouro=:l, numero=:n, complemento=:c, bairro=:b, cep=:p";

        $stmt = $this->conexao->prepare($query);

        /*
        Foi utilizada 2 funçoes para tratar os dados que estao vindo do usuario 
        para api.
        strip_tags-> trata os dados em seus formatos inteiro, double ou decimal 
        htmlspecialchar-> retira as aspas e os 2 pontos que vem do formato 
        json para cadastrar em banco. 
        */

        $this->logradouro = htmlspecialchars(strip_tags($this->logradouro));
        $this->numero = htmlspecialchars(strip_tags($this->numero));
        $this->complemento = htmlspecialchars(strip_tags($this->complemento));
        $this->bairro = htmlspecialchars(strip_tags($this->bairro));
        $this->cep = htmlspecialchars(strip_tags($this->cep));
        

    

        $stmt->bindParam(":l",$this->logradouro);
        $stmt->bindParam(":n",$this->numero);
        $stmt->bindParam(":c",$this->complemento);
        $stmt->bindParam(":b",$this->bairro);
        $stmt->bindParam(":p",$this->cep);
        

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }

    }

    public function alterarendereco(){

        $query = "update endereco set logradouro=:l, numero=:n, complemento=:c, bairro=:b, cep=:p where id=:i";

        $stmt= $this->conexao->prepare($query);
        
        $stmt->bindParam(":l",$this->logradouro);
        $stmt->bindParam(":n",$this->numero);
        $stmt->bindParam(":c",$this->complemento);
        $stmt->bindParam(":b",$this->bairro);
        $stmt->bindParam(":p",$this->cep);
        $stmt->bindParam(":i",$this->id);


        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function apagar(){
        $query = "delete from endereco where id=?";

        $stmt=$this->conexao->prepare($query);

        $stmt->bindParam(1,$this->id);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }



}

?>