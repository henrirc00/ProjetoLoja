<?php

/*
Esse cabeçalho permite o acesso a listagem de usuário
com diversas origens. Por isso estamos usando o * (asterisco)
para essa permissão que será para http,https,file,ftp 
*/
header("Access-Control-Allow-Origin:*");

/* 
vamos definir qual será o formato de dados que o usuário
irá enviar a api. Este formato será do tipo JSON(Javascript On Noytation)
*/
header("Content-Type: application/json;charset=utf-8");


/*
Abaixo estamos incluindo o arquivo database.php que possui a 
classe Database com a conexão com o banco de dados
*/ 

include_once "../../config/database.php";

/*
O arquivo endereco.php foi incluido para que a classe endereco fosse 
utilizada. Vale Lembrar que esta classe possui o CRUD para o usuário.
*/ 
include_once "../../domain/endereco.php";

/*
Criamos um objetos chamado #database. É uma instacia da Database.
Quando usamos o termo new, estamos criando um instancia, ou seja,
um objeto da classe Database. Isso nos dará acesso a todos os dados 
da classe Database. 
*/

$database = new Database();
/*
Executamos a função getConnection que estabelece a conexao com o banco de 
dados. E retorna essa conexao realizada para a variavel $db 
*/ 
$db = $database->getConnection();

/*
Instancia da classe endereco e, portanto, criação do objeto chamado $endereco.
Isso fará com que todas as funcoes que estão dentro da classe endereco sejam 
transferidas para o objeto $endereco.
Durante a instancia foi passada como parametro a variavel $db que possui
o comunicação com o banco de dados e também a variavel conexao. Utilizada 
para o uso do comandos de CRUD 
*/

$endereco = new Endereco($db);

/* 
A variavel stmt(Statement->sentença) foi criada para guardar o retorno 
da consulta que está na funcao listra. Dentro da funcao listar() temos 
uma consulta no formato sql que selecionada todos os usuário("Select * from endereco")  
*/


$stmt = $endereco->listar();
/* 
Se a consuta retorna uma quantidade de linhas maior que 0(Zero), então será
construido um array com os dados dos endereco.
Caso contrário será exibido uma mensagem que não endereco cadastrados 
*/ 

if($stmt->rowCount() > 0){

 /* 
Para organizar os endereco cadastrados em banco e exibi-los em tela, foi 
criada uma array com o nome de saida e assim guardar todos endereco.  
 */ 

$endereco_arr = array();
/* 
A estrutura while(enquanto) realizar a busca e todos os endereco 
cadastrados até chegar ao final da tabela e tras os dados 
para fetch array organizar em formato de array. 
Assim será mais facil da adicionar no array de usurarios para ser 
apresentados ao endereco.
*/ 
$endereco_arr["saida"]=array();
/* 
O comando extract é capaz de saparar de forma mais simples 
os campos da tabela endereco.
*/ 
while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($linha);
    /* 
    Pegar um campo por vez do comando extract e adicionar em um 
    array de itens, pois será assim que os endereco serão tratado,
    um usarios por vez com seus respectivos dados. 
    */ 
    $array_item = array(
        "id"=>$id,
        "logradouro"=>utf8_encode($logradouro),
        "numero"=>$numero,
        "complemento"=>$complemento,
        "bairro"=>utf8_encode($bairro),
        "cep"=>$cep,
        
        
    );
    /* 
    Pegar um item gerado pelo array_item e adicionar a saida, que 
    também é um array. 
    array_push é um comando em que voce pode adicionar algo em um array.
    Assim estamos adicionando ao endereco_arr[saido] um item
    que é um endereco com seus respectivo dados.  
    */ 
    array_push($endereco_arr["saida"],$array_item);
    }
    /* 
    O comando header(cabeçalho) responde via HTTP o status cade 200 que 
    representa sucesso na consulta de dados.
    */ 
    header("HTTP/1.0 200");
    /* 
    Pegamos o array endereco_arr que foi construido em php com os dados 
    dos endereco e convertemos para o formato json para exibir ao 
    cliente requisitante.
    */ 
    echo json_encode($endereco_arr);
}
else{
    /* 
    O comando header(cabeçalho)responde ao cliente o status code 400(badrequest)
    caso não haja enderecos cadastrados no banco. Junto ao status code será exibida 
    a mensagem "mensagem: Não há endereco cadastrados " que será mostrada por meio 
    de jason_encode 
    */ 
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Não há enderecos cadastrados"));
}


?>