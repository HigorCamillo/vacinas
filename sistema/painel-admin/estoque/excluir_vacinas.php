<?php
require_once("../../../conexao.php");

$vacina = $_GET['vacina'];
$ubs = $_GET['ubs'];

$query = $pdo->prepare("DELETE FROM estoque_vacinas WHERE vacina = :vacina AND ubs = :ubs");
$query->bindParam(':vacina', $vacina);
$query->bindParam(':ubs', $ubs);

if ($query->execute()) {
    echo "Exclusão realizada com sucesso.";
} else {
    echo "Erro ao excluir.";
}
?>