<?php
$pag = "pendentes";
require_once ("../../conexao.php");

@session_start();
$cpf_usuario = @$_SESSION['cpf_usuario']; // Certifique-se de que o CPF do usuário está armazenado na sessão
// Verificar se o usuário está autenticado
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Cliente') {
  echo "<script language='javascript'> window.location='../index.php' </script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Vacinas Pendentes</title>
</head>

<body>

  <h2 style="text-align: center">Vacinas Pendentes</h2>


  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th style="width: 70%; text-align: center">Vacina</th>
      <th style="width: 30%; text-align: center;">Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $query_ped = $pdo->query("
    SELECT v.*
    FROM vacinas v
    JOIN usuarios u ON u.cpf = '$cpf_usuario'
    LEFT JOIN vacinas_aplicadas ua ON u.cpf = ua.cpf AND v.nome = ua.vacina
    WHERE 
    (
        TIMESTAMPDIFF(YEAR, u.dt_nasc, CURDATE()) > v.anos_minimo
        OR (
        TIMESTAMPDIFF(YEAR, u.dt_nasc, CURDATE()) = v.anos_minimo
        AND TIMESTAMPDIFF(MONTH, u.dt_nasc, CURDATE()) % 12 >= v.meses_minimo
        )
    )
    AND ua.vacina IS NULL
    ORDER BY v.id ASC"
    );
    $res_ped = $query_ped->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res_ped as $row) {
      $vacina = $row['nome'];
      $vacina_id = $row['id'];
      ?>

      <tr>
        <td style="width: 70%; text-align: center;text-align: center;"><?php echo $vacina ?></td>
        <td style="width: 30%; text-align: center;"><button class="btn btn-info" onclick="openModal('<?php echo $vacina; ?>')">Encontrar Vacina</button></td>
      </tr>

    <?php } ?>
  </tbody>
</table>


  <!-- Modal para listar UBS com vacina disponível -->
  <div class="modal fade" id="modalUBS" tabindex="-1" role="dialog" aria-labelledby="modalUBSLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUBSLabel">UBS com Vacina Disponível</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="ubsContent"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function openModal(vacinaNome) {
      $.ajax({
        url: 'pendentes/buscar_ubs.php',
        type: 'POST',
        data: { vacina_nome: vacinaNome },
        success: function (response) {
          $('#ubsContent').html(response);
          $('#modalUBS').modal('show');
        }
      });
    }

    $(document).ready(function () {
      $('#dataTable').DataTable({
        "ordering": false
      });
    });
  </script>
</body>

</html>