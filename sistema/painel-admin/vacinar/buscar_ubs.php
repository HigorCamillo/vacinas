<?php

require_once("../../../conexao.php"); 

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $stmt = $pdo->prepare("SELECT nome_ubs FROM ubs_vacinas WHERE nome_ubs LIKE :query LIMIT 5");
    $stmt->bindValue(':query', '%' . $query . '%');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        foreach ($result as $row) {
            echo '<li class="list-group-item">' . $row['nome_ubs'] . '</li>';
        }
    } else {
        echo '<li class="list-group-item">Nenhuma UBS encontrada</li>';
    }
}

?>
