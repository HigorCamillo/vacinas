<?php
$pag = "historico";
require_once ("../../conexao.php");

@session_start();
$cpf_usuario = @$_SESSION['cpf_usuario']; // Certifique-se de que o CPF do usuário está armazenado na sessão
// Verificar se o usuário está autenticado
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Cliente') {
  echo "<script language='javascript'> window.location='../index.php' </script>";
}
?>

<h2 style="text-align: center">Histórico Geral</h2>

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
        <tbody>
          <?php
          $query_ped = $pdo->query("SELECT * FROM vacinas_aplicadas WHERE cpf = '$cpf_usuario' ORDER BY id ASC");
          $res_ped = $query_ped->fetchAll(PDO::FETCH_ASSOC);

          for ($i = 0; $i < @count($res_ped); $i++) {
            foreach ($res_ped[$i] as $key => $value) {
            }

            $vacina = $res_ped[$i]['vacina'];
            $local = $res_ped[$i]['ubs'];
            $data_aplicacao = $res_ped[$i]['data_aplicacao'];
            $id_vacina = $res_ped[$i]['id'];
            $cod_aplicador = $res_ped[$i]['cod_aplicador'];

            // Formatar a data
            $data_aplicacao = implode('/', array_reverse(explode('-', $data_aplicacao)));

            ?>

            <tr>
              <td><?php echo $vacina ?></td>
              <td><?php echo $local ?></td>
              <td><?php echo $data_aplicacao ?></td>
              <td><?php echo $cod_aplicador ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form").submit(function () {
    var pag = "<?= $pag ?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/inserir.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {
        $('#mensagem').removeClass();

        if (mensagem.trim() == "Salvo com Sucesso!!") {
          //$('#nome').val('');
          //$('#cpf').val('');
          $('#btn-fechar').click();
          window.location = "index.php?pag=" + pag;
        } else {
          $('#mensagem').addClass('text-danger');
        }

        $('#mensagem').text(mensagem);
      },

      cache: false,
      contentType: false,
      processData: false,
      xhr: function () {  // Custom XMLHttpRequest
        var myXhr = $.ajaxSettings.xhr();
        if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
          myXhr.upload.addEventListener('progress', function () {
            /* faz alguma coisa durante o progresso do upload */
          }, false);
        }
        return myXhr;
      }
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function () {
    $('#dataTable').dataTable({
      "ordering": false
    });
  });
</script>
