<?php
require_once("config.php");

date_default_timezone_set('America/Sao_Paulo');

try {
	$pdo = new PDO("mysql:dbname=$banco;host=$servidor;charset=utf8", "$usuario", "$senha");

	//CONEXAO MYSQLI PARA O BACKUP
	$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

} catch (Exception $e) {
	echo "Erro ao conectar com o banco de dados! " . $e;
}



//verificar config
 $res = $pdo->query("SELECT * FROM config where id = 0"); 
    $dados_res = $res->fetchAll(PDO::FETCH_ASSOC);    
    if(@count($dados_res) == 0){
       $pdo->query("INSERT into config SET id = '0', nome_loja = 'Controle Vacinas ', email_loja = 'admin@gmail.com',  logo = 'logoo.png', favicon = 'favicon.png'");
    }else{
    	$nome_loja = $dados_res[0]['nome_loja'];
    	$email_loja = $dados_res[0]['email_loja'];
    	$logo = $dados_res[0]['logo'];
    	$favicon = $dados_res[0]['favicon'];
    	$email_adm = $email_loja;
    	$email = $email_loja;
    }

?>