<?php

require_once("../../conexao.php"); 

// Recupere os dados enviados pela requisição AJAX
$idCliente = $_POST['idCliente'];
$idVenda = $_POST['idVenda'];

// Atualize o ID do cliente na tabela de vendas
$query = $pdo->prepare("UPDATE vendas SET id_usuario = :idCliente WHERE id = :idVenda");
$query->bindValue(':idCliente', $idCliente);
$query->bindValue(':idVenda', $idVenda);
$query->execute();

// Verifique se a atualização foi bem-sucedida e retorne uma resposta adequada
if ($query) {
    echo 'success';
} else {
    echo 'error';
}

?>
