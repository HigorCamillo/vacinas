<?php

require_once("../../../conexao.php"); 

if (isset($_POST['query']) && isset($_POST['vacina'])) {
    $query = $_POST['query'];
    $vacina = $_POST['vacina'];
    
    $stmt = $pdo->prepare("SELECT uv.ubs 
                           FROM estoque_vacinas uv 
                           INNER JOIN vacinas v ON uv.vacina = v.nome 
                           WHERE uv.ubs LIKE :query 
                           AND v.nome = :vacina
                           ORDER BY uv.data_vencimento ASC
                           LIMIT 1");
    
    $stmt->bindValue(':query', '%' . $query . '%');
    $stmt->bindValue(':vacina', $vacina);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        foreach ($result as $row) {
            echo '<li class="list-group-item">' . $row['ubs'] . '</li>';
        }
    } else {
        echo '<li class="list-group-item">Nenhuma UBS encontrada</li>';
    }
}

?>
