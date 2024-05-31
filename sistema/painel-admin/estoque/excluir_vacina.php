<?php
require_once("../../../conexao.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Iniciar uma transação
        $pdo->beginTransaction();

        // Obter os detalhes da vacina aplicada antes de deletar
        $query = $pdo->prepare("SELECT vacina, ubs, lote FROM vacinas_aplicadas WHERE id = ?");
        $query->execute([$id]);
        $vacina_aplicada = $query->fetch(PDO::FETCH_ASSOC);

        if ($vacina_aplicada) {
            $vacina = $vacina_aplicada['vacina'];
            $ubs = $vacina_aplicada['ubs'];
            $lote = $vacina_aplicada['lote'];

            // Deletar a vacina aplicada
            $delete = $pdo->prepare("DELETE FROM vacinas_aplicadas WHERE id = ?");
            $delete->execute([$id]);

            // Atualizar a quantidade no estoque
            $update = $pdo->prepare("UPDATE estoque_vacinas SET qtd = qtd + 1 WHERE vacina = ? AND ubs = ? AND lote = ?");
            $update->execute([$vacina, $ubs, $lote]);

            // Confirmar a transação
            $pdo->commit();

            echo "Exclusão realizada com sucesso.";
        } else {
            echo "Registro de vacina não encontrado.";
        }
    } catch (PDOException $e) {
        // Reverter a transação em caso de erro
        $pdo->rollBack();
        echo "Erro ao excluir a vacina aplicada: " . $e->getMessage();
    }
} else {
    echo "ID inválido.";
}
?>
