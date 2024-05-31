<?php

require_once("../../../conexao.php"); 

if (isset($_POST['vacina']) && isset($_POST['ubs'])) {
    $vacina = $_POST['vacina'];
    $ubs = $_POST['ubs'];

    // Query para buscar o lote e a data de validade mais recente (>= hoje)
    $result = $pdo->prepare("SELECT lote, data_vencimento 
                             FROM estoque_vacinas 
                             WHERE vacina = ? AND ubs = ? AND data_vencimento >= CURDATE() 
                             ORDER BY data_vencimento ASC 
                             LIMIT 1");
    $result->execute([$vacina, $ubs]);

    $data = $result->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(['lote' => '', 'data_vencimento' => '']);
    }
} else {
    echo json_encode(['lote' => '', 'data_vencimento' => '']);
}

?>
