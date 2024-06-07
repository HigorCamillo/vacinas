<?php

require_once("../../conexao.php");

// Verifica se todos os campos obrigatórios foram preenchidos
if (
    !isset($_POST['nome-usuario']) || 
    !isset($_POST['email-usuario']) || 
    !isset($_POST['cpf-usuario']) || 
    !isset($_POST['senha']) || 
    !isset($_POST['nome_mae']) || 
    !isset($_POST['cartao_sus']) || 
    !isset($_POST['municipio_nascimento']) || 
    !isset($_POST['municipio_residencia']) || 
    !isset($_POST['cor_autodeclarada']) || 
    !isset($_POST['numero_celular']) || 
    !isset($_POST['dt_nasc'])
) {
    echo 'Todos os campos devem ser preenchidos!';
    exit();
}

$nome = $_POST['nome-usuario'];
$email = $_POST['email-usuario'];
$cpf = $_POST['cpf-usuario'];
$senha = $_POST['senha'];
$nome_mae = $_POST['nome_mae'];
$cartao_sus = $_POST['cartao_sus'];
$municipio_nascimento = $_POST['municipio_nascimento'];
$municipio_residencia = $_POST['municipio_residencia'];
$cor_autodeclarada = $_POST['cor_autodeclarada'];
$numero_celular = $_POST['numero_celular'];
$dt_nasc = $_POST['dt_nasc'];

$senha_crip = md5($senha);

$antigo = $_POST['antigo'];
$id_usuario = $_POST['txtid'];



// Verifica se o e-mail é válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Email inválido!';
    exit();
}

// Verifica se as senhas coincidem
if ($senha != $_POST['conf-senha']) {
    echo 'As senhas não coincidem!';
    exit();
}

// Verifica se o CPF já está cadastrado no banco
if ($cpf != $antigo) {
    $res = $pdo->prepare("SELECT * FROM usuarios WHERE cpf = :cpf");
    $res->bindValue(":cpf", $cpf);
    $res->execute();
    if ($res->rowCount() > 0) {
        echo 'CPF já cadastrado no banco!';
        exit();
    }
}

// Atualiza os dados do usuário no banco de dados
$res = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, senha_crip = :senha_crip, dt_nasc = :dt_nasc, nome_mae = :nome_mae, cartao_sus = :cartao_sus, municipio_nascimento = :municipio_nascimento, municipio_residencia = :municipio_residencia, cor_autodeclarada = :cor_autodeclarada, numero_celular = :numero_celular WHERE id = :id");
$res->bindValue(":nome", $nome);
$res->bindValue(":email", $email);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":senha", $senha);
$res->bindValue(":senha_crip", $senha_crip);
$res->bindValue(":dt_nasc", $dt_nasc);
$res->bindValue(":nome_mae", $nome_mae);
$res->bindValue(":cartao_sus", $cartao_sus);
$res->bindValue(":municipio_nascimento", $municipio_nascimento);
$res->bindValue(":municipio_residencia", $municipio_residencia);
$res->bindValue(":cor_autodeclarada", $cor_autodeclarada);
$res->bindValue(":numero_celular", $numero_celular);
$res->bindValue(":id", $id_usuario);

$res->execute();

echo 'Salvo com Sucesso!';
