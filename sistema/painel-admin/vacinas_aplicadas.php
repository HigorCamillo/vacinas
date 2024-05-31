<?php 
$pag = "vacinas_aplicadas";
require_once("../../conexao.php"); 
@session_start();
// Verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
    echo "<script language='javascript'> window.location='../index.php' </script>";
}
?>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>CPF</th>
                        <th>Vacina</th>
                        <th>Lote</th>
                        <th>Ubs</th>
                        <th>Ações</th> <!-- Nova coluna para ações -->
                    </tr>
                </thead>
                <tbody id="tabela-dados">
                 <?php 
                 $query = $pdo->query("SELECT * FROM vacinas_aplicadas ORDER BY data_aplicacao DESC");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                    foreach ($res[$i] as $key => $value) {
                    }

                    $cpf = $res[$i]['cpf'];
                    $vacina = $res[$i]['vacina'];
                    $lote = $res[$i]['lote'];
                    $ubs = $res[$i]['ubs'];
                    $id = $res[$i]['id'];
                 ?>
                  <tr id="row-<?php echo $id ?>">
                    <td><?php echo $cpf ?></td>
                    <td><?php echo $vacina ?></td>
                    <td><?php echo $lote ?></td>
                    <td><?php echo $ubs ?></td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('<?php echo $id ?>')">Excluir</button>
                    </td>
                  </tr>
                 <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmação de Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja excluir esta aplicação de vacina?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Excluir</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTable').dataTable({
            "ordering": false
        });
    });

    var deleteId;

    function confirmDelete(id) {
        deleteId = id;
        $('#confirmDeleteModal').modal('show');
    }

    $('#confirmDeleteButton').click(function() {
        $.ajax({
            url: "estoque/excluir_vacina.php",
            method: "GET",
            data: { id: deleteId },
            success: function(response) {
                if (response.trim() == "Exclusão realizada com sucesso.") {
                    $('#row-' + deleteId).remove();
                    $('#confirmDeleteModal').modal('hide');
                } else {
                    alert(response);
                }
            }
        });
    });
</script>
