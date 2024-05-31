<?php 

$url_loja = "http://$_SERVER[HTTP_HOST]/";
$url = explode("//", $url_loja);
if($url[1] == 'localhost/'){
	$url_loja = "http://$_SERVER[HTTP_HOST]/loja/";
}


//VARIAVEIS DO BANCO DE DADOS
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'vacinas';




 ?>