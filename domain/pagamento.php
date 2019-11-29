<?php

class Pagamento{
    public $id;
    public $id_pedido;
    public $valor;
    public $formapagamento;
    public $descricao;
    public $numeroparcela;
    public $valorparcela;
    


    public function __construct($db){
        $this->conexao = $db;
    }



    /*
    Função listar para selecionar todos os contato cadastrados no banco de dados. 
    Essa função retorna uma lista com todos os dados.
    */
    public function listar(){
        #Seleciona todos os campos da tabela contato
        $query = "select * from pagamento";
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
    Função para cadastrar os contatos no banco de dados 
    */
    public function cadastro(){
        $query = "insert into pagamento set id_pedido=:p, valor=:v, formapagamento=:f, descricao=:d, numeroparcela=:n, valorparcela=:vp";

        $stmt = $this->conexao->prepare($query);

        /*
        Foi utilizada 2 funçoes para tratar os dados que estao vindo do usuario 
        para api.
        strip_tags-> trata os dados em seus formatos inteiro, double ou decimal 
        htmlspecialchar-> retira as aspas e os 2 pontos que vem do formato 
        json para cadastrar em banco. 
        */

        $this->id_pedido = htmlspecialchars(strip_tags($this->id_pedido));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->formapagamento = htmlspecialchars(strip_tags($this->formapagamento));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->numeroparcela = htmlspecialchars(strip_tags($this->numeroparcela));
        $this->valorparcela = htmlspecialchars(strip_tags($this->valorparcela));
        
        

    

        $stmt->bindParam(":p",$this->id_pedido);
        $stmt->bindParam(":v",$this->valor);
        $stmt->bindParam(":f",$this->formapagamento);
        $stmt->bindParam(":d",$this->descricao);
        $stmt->bindParam(":n",$this->numeroparcela);
        $stmt->bindParam(":vp",$this->valorparcela);
        

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }

    }

    public function alterarpagamento(){

        $query = "update pagamento set id_pedido=:p, valor=:v, formapagamento=:f, descricao=:d, numeroparcela=:n, valorparcela=:vp where id=:i";

        $stmt= $this->conexao->prepare($query);

        $stmt->bindParam(":i",$this->id);
        $stmt->bindParam(":p",$this->id_pedido);
        $stmt->bindParam(":v",$this->valor);
        $stmt->bindParam(":f",$this->formapagamento);
        $stmt->bindParam(":d",$this->descricao);
        $stmt->bindParam(":n",$this->numeroparcela);
        $stmt->bindParam(":vp",$this->valorparcela);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function apagar(){
        $query = "delete from pagamento where id=?";

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