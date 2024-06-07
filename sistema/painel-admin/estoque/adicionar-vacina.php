<?php
require_once("../../../conexao.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vacina = $_POST['vacina'];
    $grupo = $_POST['grupo']; 
    $anos_minimos = $_POST['anos_minimos'];
    $meses_minimos = $_POST['meses_minimos'];
    // Validação e processamento dos dados
    if (empty($vacina)) {
        echo "Por favor, preencha o nome da vacina.";
        exit;
    }

    $query = $pdo->prepare("INSERT INTO vacinas (nome,grupo,anos_minimo,meses_minimo) VALUES (:nome,:grupo,:anos_minimos,:meses_minimos)");
    $query->bindParam(':nome', $vacina);
    $query->bindParam(':grupo', $grupo);
    $query->bindParam(':anos_minimos', $anos_minimos);
    $query->bindParam(':meses_minimos', $meses_minimos);

    if ($query->execute()) {
        echo "Salvo com Sucesso!!";
    } else {
        echo "Erro ao salvar a vacina.";
    }
}
?>