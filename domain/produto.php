<?php

class Produto{
    public $id;
    public $nome;
    public $descricao;
    public $preco;
    public $imagem1;
    public $imagem2;
    public $imagem3;
    public $imagem4;
    


    public function __construct($db){
        $this->conexao = $db;
    }



    /*
    Função listar para selecionar todos os produto cadastrados no banco de dados. 
    Essa função retorna uma lista com todos os dados.
    */
    public function listar(){
        #Seleciona todos os campos da tabela produto
        $query = "select * from produto";
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




    public function pesquisar_id($idproduto){
        #Seleciona todos os campos da tabela produto
        $query = "select * from produto where id=?";
        /*
         Foi criada a variavel stmt(Statment -> Sentença) para guardar a preparacao da consulta 
         select que será executada posteriomente.
         */
        $stmt = $this->conexao->prepare($query);

        $stmt->bindParam(1,$idproduto);
        #execução da consulta e guarda de dados na variavel stmt 

        $stmt->execute();
        #retorna os dados do usuário a camada data.

        return $stmt;
    }


    public function pesquisar_nome(){
        #Seleciona todos os campos da tabela produto
        $query = "select * from produto where nome like ?";
        /*
         Foi criada a variavel stmt(Statment -> Sentença) para guardar a preparacao da consulta 
         select que será executada posteriomente.
         */
        $stmt = $this->conexao->prepare($query);

        $stmt->bindParam(1,$this->nome);
        #execução da consulta e guarda de dados na variavel stmt 

        $stmt->execute();
        #retorna os dados do usuário a camada data.

        return $stmt;
    }

 

    /*
    Função para cadastrar os produtos no banco de dados 
    */
    public function cadastro(){
        $query = "insert into produto set nome=:n, descricao=:d, preco=:p, imagem1=:i1, imagem2=:i2, imagem3=:i3, imagem4=:i4";

        $stmt = $this->conexao->prepare($query);

        /*
        Foi utilizada 2 funçoes para tratar os dados que estao vindo do usuario 
        para api.
        strip_tags-> trata os dados em seus formatos inteiro, double ou decimal 
        htmlspecialchar-> retira as aspas e os 2 pontos que vem do formato 
        json para cadastrar em banco. 
        */

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->imagem1 = htmlspecialchars(strip_tags($this->imagem1));
        $this->imagem2 = htmlspecialchars(strip_tags($this->imagem2));
        $this->imagem3 = htmlspecialchars(strip_tags($this->imagem3));
        $this->imagem4 = htmlspecialchars(strip_tags($this->imagem4));
        

    
        $stmt->bindParam(":n",$this->nome);
        $stmt->bindParam(":d",$this->descricao);
        $stmt->bindParam(":p",$this->preco);
        $stmt->bindParam(":i1",$this->imagem1);
        $stmt->bindParam(":i2",$this->imagem2);
        $stmt->bindParam(":i3",$this->imagem3);
        $stmt->bindParam(":i4",$this->imagem4);
        

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }

    }

    public function alterarproduto(){

        $query = "update produto set nome=:n, descricao=:d, preco=:p, imagem1=:i1, imagem2=:i2, imagem3=:i3, imagem4=:i4 where id=:i";

        $stmt= $this->conexao->prepare($query);

        $stmt->bindParam(":i",$this->id);
        $stmt->bindParam(":n",$this->nome);
        $stmt->bindParam(":d",$this->descricao);
        $stmt->bindParam(":p",$this->preco);
        $stmt->bindParam(":i1",$this->imagem1);
        $stmt->bindParam(":i2",$this->imagem2);
        $stmt->bindParam(":i3",$this->imagem3);
        $stmt->bindParam(":i4",$this->imagem4);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function apagar(){
        $query = "delete from produto where id=?";

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