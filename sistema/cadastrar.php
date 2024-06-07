<?php 

require_once("../conexao.php");

// Retrieve POST data
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];
$nome_mae = $_POST['nome_mae'];
$cartao_sus = $_POST['cartao_sus'];
$municipio_nascimento = $_POST['municipio_nascimento'];
$municipio_residencia = $_POST['municipio_residencia'];
$cor_autodeclarada = $_POST['cor_autodeclarada'];
$numero_celular = $_POST['numero_celular'];
$dt_nasc = $_POST['data_nascimento'];
$senha_crip = md5($senha);

// Validate required fields
if (empty($nome)) {
    echo 'Preencha o Campo nome!';
    exit();
}

if (empty($cpf)) {
    echo 'Preencha o Campo cpf!';
    exit();
}

if (empty($email)) {
    echo 'Preencha o Campo email!';
    exit();
}

if (empty($senha) || strlen($senha) < 8) {
    echo 'A senha deve conter pelo menos 8 caracteres!';
    exit();
}

if ($senha != $confirmar_senha) {
    echo 'As senhas não coincidem!';
    exit();
}

// Check if CPF already exists in the database
$res = $pdo->prepare("SELECT * FROM usuarios WHERE cpf = :cpf");
$res->bindValue(":cpf", $cpf);
$res->execute();
$dados = $res->fetchAll(PDO::FETCH_ASSOC);

if (count($dados) == 0) {
    // CPF does not exist, proceed with insert
    $res = $pdo->prepare("INSERT INTO usuarios (nome, cpf, email, senha, senha_crip, nome_mae, cartao_sus, municipio_nascimento, municipio_residencia, cor_autodeclarada, numero_celular, dt_nasc, nivel) 
                          VALUES (:nome, :cpf, :email, :senha, :senha_crip, :nome_mae, :cartao_sus, :municipio_nascimento, :municipio_residencia, :cor_autodeclarada, :numero_celular, :dt_nasc, :nivel)");
    $res->bindValue(":nome", $nome);
    $res->bindValue(":cpf", $cpf);
    $res->bindValue(":email", $email);
    $res->bindValue(":senha", $senha);
    $res->bindValue(":senha_crip", $senha_crip);
    $res->bindValue(":nome_mae", $nome_mae);
    $res->bindValue(":cartao_sus", $cartao_sus);
    $res->bindValue(":municipio_nascimento", $municipio_nascimento);
    $res->bindValue(":municipio_residencia", $municipio_residencia);
    $res->bindValue(":cor_autodeclarada", $cor_autodeclarada);
    $res->bindValue(":numero_celular", $numero_celular);
    $res->bindValue(":dt_nasc", $dt_nasc);
    $res->bindValue(":nivel", 'Cliente');

    if ($res->execute()) {
        echo 'Cadastrado com Sucesso!';
    } else {
        echo 'Erro ao cadastrar!';
    }
} else {
    echo 'CPF já Cadastrado!';
}

?>
