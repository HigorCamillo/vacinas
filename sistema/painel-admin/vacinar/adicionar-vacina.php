<?php
require_once("../../../conexao.php"); 
echo "<script>alert('Entrou no aaaaa.php');</script>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vacina = $_POST['vacina'];

    // Validação e processamento dos dados
    if (empty($vacina)) {
        echo "Por favor, preencha o nome da vacina.";
        exit;
    }

    $query = $pdo->prepare("INSERT INTO vacinas (nome) VALUES (:nome)");
    $query->bindParam(':nome', $vacina);

    if ($query->execute()) {
        echo "Salvo com Sucesso!!";
    } else {
        echo "Erro ao salvar a vacina.";
    }
}
?>

