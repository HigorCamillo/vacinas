<?php
require_once("../../../conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $vacina = $_POST['vacina'];
    $ubs = $_POST['ubs'];
    $lote = $_POST['lote'];
    $data_aplicacao = $_POST['data_aplicacao'];
    $cod_aplicador = $_POST['cod_aplicador'];

    try {
        // Inicia uma transação
        $pdo->beginTransaction();

        // Insere o registro de aplicação da vacina
        $sql = "INSERT INTO vacinas_aplicadas (cpf, vacina, ubs, lote, data_aplicacao, cod_aplicador) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cpf, $vacina, $ubs, $lote, $data_aplicacao, $cod_aplicador]);

        // Atualiza a quantidade da vacina no estoque
        $updateSql = "UPDATE estoque_vacinas 
                      SET qtd = qtd - 1 
                      WHERE vacina = ? AND ubs = ? AND lote = ? AND qtd > 0";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([$vacina, $ubs, $lote]);

        if ($updateStmt->rowCount() > 0) {
            // Confirma a transação se a atualização foi bem-sucedida
            $pdo->commit();
            echo "Distribuição registrada com sucesso.";
        } else {
            // Reverte a transação se a quantidade não foi atualizada
            $pdo->rollBack();
            echo "Erro: a quantidade disponível da vacina não foi atualizada.";
        }
    } catch (PDOException $e) {
        // Reverte a transação em caso de erro
        $pdo->rollBack();
        echo "Erro ao registrar a distribuição: " . $e->getMessage();
    }
}
?>

<script>
    // Redirecionar para a página anterior
    window.history.back();
</script>
