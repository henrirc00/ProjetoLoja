<?php

/* 
Vamos construir os cabeçalhos para o trabalho com a api
*/
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=utf-8");

#Esse cabeçalho define o metodo de envio como DELETE, ou seja, como deletar 
header("Access-Control-Allow-Methods:DELETE");

#Define o tempo de espera da api. Neste caso é 1 minuto
header("Access-Control-Max-Age:3600");

include_once "../../config/database.php";

include_once "../../domain/endereco.php";

$database = new Database();
$db = $database->getConnection();

$endereco = new Endereco($db);

/* 
O cliente  irá enviar os dados no formato json. Porém nós precisamos dos dados
no formato php para deletar em banco de dados. Para realizar esssa conversão
iremos usar o comando json_decode . Asimm que o cliente enviar os dados, estes são 
lidos pela entrada php: e seu conteúdo é capturado e convertido para o formato php   
*/ 

$data = json_decode(file_get_contents("php://input"));

#Verificar se os campos estão com dados.

if(!empty($data->id)){
    $endereco->id= $data->id;

    if($endereco->Apagar()){
        header("HTTP/1.0 200");
        echo json_encode(array("mensagem"=>"endereco apagado com sucesso!"));
    }
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possivel apagar endereco."));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Voce precisa passar todos os dados para apagar o endereco"));
}



?>