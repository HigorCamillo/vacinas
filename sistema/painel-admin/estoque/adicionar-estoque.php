<?php
require_once("../../../conexao.php");

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados enviados pelo formulário
    $vacina = $_POST["vacina"];
    $lote = $_POST["lote"];
    $quantidade = $_POST["quantidade"];
    $validade = $_POST["validade"];
    $ubs = $_POST["ubs"];

    // Insere os dados na tabela estoque_vacinas
    $query = $pdo->prepare("INSERT INTO estoque_vacinas (vacina, lote, qtd, data_vencimento, ubs) VALUES (:vacina, :lote, :quantidade, :validade, :ubs)");

    // Bind dos parâmetros
    $query->bindParam(":vacina", $vacina);
    $query->bindParam(":lote", $lote);
    $query->bindParam(":quantidade", $quantidade);
    $query->bindParam(":validade", $validade);
    $query->bindParam(":ubs", $ubs);

    // Executa a query
    if ($query->execute()) {
        echo "Salvo com Sucesso!!";
    }
} 
?>
