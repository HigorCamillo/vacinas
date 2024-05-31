<?php
$pag = "carteira-digital";
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
  <title>Carteira Digital</title>
</head>

<body>

  <h2 style="text-align: center">Carteira Digital</h2>

  <!-- Combobox para selecionar a opção -->
  <div style="text-align: center; margin-bottom: 20px;">
  <select id="opcaoSelect" class="custom-select w-50" onchange="filtrarDados()">
      <option value="1">Vacinas Covid</option>
      <option value="2">Vacinas Gerais</option>
      <option value="3">Vacinas Campanhas</option>
    </select>
  </div>

  <!--<h4 style="text-align: center" id="tituloOpcao">Vacinas Covid</h4>-->

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Vacina</th>
              <th>Local</th>
              <th>Data</th>
              <th>Cod. Aplicador</th>
            </tr>
          </thead>
          <tbody id="dataBody">

          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function () {
      // Chama filtrarDados() quando a página for carregada
      filtrarDados();
    });

    function filtrarDados() {
      var opcao = $('#opcaoSelect').val();
      var titulo = $('#opcaoSelect option:selected').text();
      $('#tituloOpcao').text(titulo);
      carregarDados(opcao);
    }

    function carregarDados(opcao) {
      $.ajax({
        url: 'carteira-digital/buscar_dados.php',
        method: 'POST',
        data: { opcao: opcao },
        success: function (data) {
          $('#dataBody').html(data);
          $('#dataTable').DataTable();
        }
      });
    }
  </script>
</body>

</html>