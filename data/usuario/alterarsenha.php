<?php

/* 
Vamos construir os cabeçalhos para o trabalho com a api
*/
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=utf-8");

#Esse cabeçalho define o metodo de envio com PUT, ou seja, como atualizar 
header("Access-Control-Allow-Methods:PUT");

#DEfine o tempo de espera da api. Neste caso é 1 minuto
header("Access-Control-Max-Age:3600");

include_once "../../config/database.php";

include_once "../../domain/usuario.php";

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

/* 
O cliente  irá enviar os dados no formato json. Porém nós precisamos dos dados
no formato php para atualizar em banco de dados. Para realizar esssa conversão
iremos usar o comando json_decode . Asimm que o cliente enviar os dados, estes são 
lidos pela entrada php: e seu conteúdo é capturado e convertido para o formato php   
*/ 

$data = json_decode(file_get_contents("php://input"));

#Verificar se os campos estão com dados.

if(!empty($data->senha) && !empty($data->id)){
    $usuario->id= $data->id;
    $usuario->senha = $data->senha;

    if($usuario->alterarSenha()){
        header("HTTP/1.0 200");
        echo json_encode(array("mensagem"=>"Senha do usuario atualizada com sucesso!"));
    }
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possivel atualizar Senha."));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Voce precisa passar todos os dados para alterarSenha"));
}



?>