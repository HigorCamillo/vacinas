<?php
require_once("../../../conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vacina = $_POST['vacina'];
    $anos_minimos = $_POST['anos_minimos'];
    $meses_minimos = $_POST['meses_minimos'];

    // Validação dos dados
    if (empty($vacina)) {
        echo "Por favor, preencha o nome da vacina.";
        exit;
    }
    if (empty($anos_minimos) && $anos_minimos !== '0') {
        echo "Por favor, preencha a idade mínima em anos.";
        exit;
    }
    if (empty($meses_minimos) && $meses_minimos !== '0') {
        echo "Por favor, preencha a idade mínima em meses.";
        exit;
    }

    // Atualizar os dados no banco de dados
    $query = $pdo->prepare("UPDATE vacinas SET anos_minimo = :anos_minimos, meses_minimo = :meses_minimos WHERE nome = :nome");
    $query->bindParam(':nome', $vacina);
    $query->bindParam(':anos_minimos', $anos_minimos, PDO::PARAM_INT);
    $query->bindParam(':meses_minimos', $meses_minimos, PDO::PARAM_INT);

    if ($query->execute()) {
        echo "Atualizado com Sucesso!!";
    } else {
        echo "Erro ao atualizar a vacina.";
    }
}
?>
