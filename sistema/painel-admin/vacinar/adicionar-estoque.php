<?php

require_once("../../../conexao.php"); 

echo "<script>alert('Entrou no adicionar-estoque.php');</script>";

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados enviados pelo formulário
    $vacina = $_POST["vacina"];
    $lote = $_POST["lote"];
    $quantidade = $_POST["quantidade"];
    $validade = $_POST["validade"];
    $ubs = $_POST["ubs"];

    // Insere os dados na tabela estoque_vacinas
    $query = "INSERT INTO estoque_vacinas (vacina, lote, qtd, data_vencimento, ubs) VALUES (:vacina, :lote, :quantidade, :validade, :ubs)";
    $stmt = $pdo->prepare($query);

    // Bind dos parâmetros
    $stmt->bindParam(":vacina", $vacina);
    $stmt->bindParam(":lote", $lote);
    $stmt->bindParam(":quantidade", $quantidade);
    $stmt->bindParam(":validade", $validade);
    $stmt->bindParam(":ubs", $ubs);

    // Executa a query
    if ($stmt->execute()) {
        echo "Salvo com Sucesso!!";
    } else {
        echo "Erro ao salvar.";
    }
} else {
    echo "Requisição inválida.";
}
?>
