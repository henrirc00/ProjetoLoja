<?php

class CadGeral{
    public $usuario;
    public $senha;
    public $foto;
    public $nome;
    public $cpf;
    public $id_usuario;
    public $id_contato;
    public $id_endereco;
    public $telefone;
    public $email;
    public $logradouro;
    public $numero;
    public $complemento;
    public $bairro;
    public $cep;


public function__construct($db){
    $this->conexao = $db;
}

public function cadastro{
    $queryUsuario = "insert into usuario set nomeusuario=:nu, senha=:sh, foto=:ft";

    $stmt = this->conexao->prepare($queryUsuario);

    $this->senha = md5(this->senha);

    $stmt->bindParam(":nu", $this->usuario);
    $stmt->bindParam(":sh", $this->senha);
    $stmt->bindParam(":ft", $this->foto);

    $stmt->execute();
    //Vamos capturar o id do usuario gerado neste instante
    $this->id_usuario = $this->conexao->lastInsertId();

    if($this->id_usuario > 0) {
        //podemos para a proxima inserção.
        $queryContato = "insert into contato set telefone=:te, email=:em";

        $stmt = $this=>conexao->prepare($queryContato);

        $stmt->bindParam(":te",$this->telefone);
        $stmt->bindParam(":em",$this->email);
        
        $stmt->execute();

        $this->id_contato = $this->conexao->lastInsertId();


        if($this->id_contato > 0) {
            $query = "insert into endereco set logradouro=:lo, numero=:nr, complemento=:co, bairro=:br, cep=:ce";

            $stmt = $this=>conexao->prepare($queryEnd);

            $this->bundParam(":lo",$this->logradouro);
            $this->bindParam(":nr",$this->numero);
            $this->bindParam(":co",$this->complemento);
            $this->bindParam(":br",$this->bairro);
            $this->bindParam(":ce",$this->cep);

            $stmt->execute();

            $this->id_endereco = $this->conexao->lastInsertId();

            if($this->id_endereco > 0) {
                $queryCliente = "insert into cliente set nome=no, cpf=:cp, id_usuario=:idu, id_contato=:idc, id_endereco=:ide";

                $stmt = $this=>conexao->prepare($queryCliente);

                $this->bindParam(":no",$this->nome);
                $this->bindParam(":cp",$this->cpf);
                $this->bindParam(":idu",$this->id_usuario);
                $this->bindParam(":idc",$this->id_contato);
                $this->bindParam(":ide",$this->id_endereco);

                if($stmt->execute()){
                    return true;    
                }
                else{
                    return false;
                }
            } 

        }

    }
    else{
        echo json_encode(array("mensagem"=>"Erro ao tentar cadastrar"));
    }

}


}
?>