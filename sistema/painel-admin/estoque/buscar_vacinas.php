<?php

require_once("../../../conexao.php"); 

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $stmt = $pdo->prepare("SELECT nome FROM vacinas WHERE nome LIKE :query LIMIT 5");
    $stmt->bindValue(':query', '%' . $query . '%');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        foreach ($result as $row) {
            echo '<li class="list-group-item">' . htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') . '</li>';
        }
    } else {
        echo '<li class="list-group-item">Nenhuma vacina encontrada</li>';
    }
}

?>
