<?php 

require_once("../conexao.php");

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$senha_crip = md5($senha);

if($nome == ""){
	echo 'Preencha o Campo nome!';
	exit();
}

if($cpf == ""){
	echo 'Preencha o Campo cpf!';
	exit();
}

if($email == ""){
	echo 'Preencha o Campo email!';
	exit();
}

if ($senha == "" || strlen($senha) < 8) {
    echo 'A senha deve conter pelo menos 8 caracteres!';
    exit();
}

if($senha != $_POST['confirmar-senha']){
	echo 'As senhas não coincidem!';
	exit();
}



$res = $pdo->query("SELECT * FROM usuarios where cpf = '$_POST[cpf]'"); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados) == 0){

	$res = $pdo->prepare("INSERT into usuarios (nome, cpf, email, senha, senha_crip, nivel) values (:nome, :cpf, :email, :senha, :senha_crip, :nivel)");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":email", $email);
	$res->bindValue(":cpf", $cpf);
	$res->bindValue(":senha", $senha);
	$res->bindValue(":senha_crip", $senha_crip);
	$res->bindValue(":nivel", 'Cliente');

	$res->execute();


	echo 'Cadastrado com Sucesso!';
}else{
	echo 'CPF já Cadastrado!';
}


?>