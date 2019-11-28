<?php

class Estoque{
    public $id;
    public $id_produto;
    public $quantidade;
    public $alterado;

    


    public function __construct($db){
        $this->conexao = $db;
    }



    /*
    Função listar para selecionar todos os estoque cadastrados no banco de dados. 
    Essa função retorna uma lista com todos os dados.
    */
    public function listar(){
        #Seleciona todos os campos da tabela estoque
        $query = "select * from estoque";
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
    Função para cadastrar os estoques no banco de dados 
    */
    public function cadastro(){
        $query = "insert into estoque set id_produto=:p, quantidade=:q, alterado=:a ";

        $stmt = $this->conexao->prepare($query);

        /*
        Foi utilizada 2 funçoes para tratar os dados que estao vindo do usuario 
        para api.
        strip_tags-> trata os dados em seus formatos inteiro, double ou decimal 
        htmlspecialchar-> retira as aspas e os 2 pontos que vem do formato 
        json para cadastrar em banco. 
        */

        $this->id_produto = htmlspecialchars(strip_tags($this->id_produto));
        $this->quantidade = htmlspecialchars(strip_tags($this->quantidade));
        $this->alterado = htmlspecialchars(strip_tags($this->alterado));
        

        

    
        $stmt->bindParam(":p",$this->id_produto);
        $stmt->bindParam(":q",$this->quantidade);
        $stmt->bindParam(":a",$this->alterado);

        

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }

    }

    public function alterarestoque(){

        $query = "update estoque set id_produto=:p, quantidade=:q, alterado=:a  where id=:i";

        $stmt= $this->conexao->prepare($query);

        $stmt->bindParam(":i",$this->id);
        $stmt->bindParam(":p",$this->id_produto);
        $stmt->bindParam(":q",$this->quantidade);
        $stmt->bindParam(":a",$this->alterado);


        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function apagar(){
        $query = "delete from estoque where id=?";

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