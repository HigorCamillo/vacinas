<?php
require_once("../../../conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vacina = $_POST['vacina'];
    $anos_minimos = $_POST['anos_minimos'];
    $meses_minimos = $_POST['meses_minimos'];

    // Atualizar os dados no banco de dados
    $query = $pdo->prepare("UPDATE vacinas SET anos_minimo = :anos_minimos, meses_minimo = :meses_minimos WHERE nome = :nome");
    $query->bindParam(':nome', $vacina);
    $query->bindParam(':anos_minimos', $anos_minimos, PDO::PARAM_INT);
    $query->bindParam(':meses_minimos', $meses_minimos, PDO::PARAM_INT);

    if ($query->execute()) {
        echo "Salvo com Sucesso!!";
    } else {
        echo "Erro ao atualizar a vacina.";
    }
}
?>
