<?php
require_once ("../../../conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $vacina_nome = $_POST['vacina_nome'];

  $query = $pdo->prepare("
    SELECT e.ubs, e.qtd, e.data_vencimento
    FROM estoque_vacinas e
    WHERE e.vacina = :vacina_nome
      AND e.qtd > 0
      AND e.data_vencimento >= CURDATE()
  ");
  $query->bindParam(':vacina_nome', $vacina_nome);
  $query->execute();

  $res = $query->fetchAll(PDO::FETCH_ASSOC);

  if (@count($res) > 0) {
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>UBS</th></thead>';
    echo '<tbody>';
    foreach ($res as $row) {
      echo '<tr>';
      echo '<td>' . $row['ubs'] . '</td>';
      echo '</tr>';
    }
    echo '</tbody></table>';
  } else {
    echo 'Nenhuma UBS encontrada com a vacina disponível.';
  }
}
?>
