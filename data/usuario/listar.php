<?php

/*
Esse cabeçalho permite o acesso a listagem de usuário
com diversas origens. Por isso estamos usando o * (asterisco)
para essa permissão que será para http,https,file,ftp 
*/
heater("Access-Control-Allow-Origin:*");

/* 
vamos definir qual será o formato de dados que o usuário
irá enviar a api. Este formato será do tipo JSON(Javascript On Noytation)
*/
header("Content-Type: application/json;charset=utf-8");

include_once "../../config/database.php";
include_once "../../domain/usuario.php";

$database = new Database();
$db = $database-getConnection();

$usuario = new Usaurio($db);

?>