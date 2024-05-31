<?php
$pag = "estoque";
require_once ("../../conexao.php");
@session_start();
// verificar se o usuário está autenticado
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin') {
    echo "<script language='javascript'> window.location='../index.php' </script>";
}
?>

<div class="row mt-4 mb-4">
    <a type="button" class="btn-primary btn-sm ml-2" href="index.php?pag=<?php echo $pag ?>&funcao=vacina">Adicionar
        Vacina</a>
    <a type="button" class="btn-primary btn-sm ml-2" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Adicionar
        Estoque</a>
    <a type="button" class="btn-primary btn-sm ml-2" href="index.php?pag=<?php echo $pag ?>&funcao=idade-vacina">Alterar Idade Mínima</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Vacina</th>
                        <th>Estoque</th>
                        <th>UBS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $pdo->query("SELECT vacina, ubs, SUM(qtd) AS qtd_total FROM estoque_vacinas GROUP BY vacina, ubs");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }

                        $nome = $res[$i]['vacina'];
                        $estoque = $res[$i]['qtd_total'];
                        $ubs = $res[$i]['ubs'];
                        ?>
                        <tr>
                            <td><?php echo $nome ?></td>
                            <td><?php echo $estoque ?></td>
                            <td><?php echo $ubs ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para adicionar vacina -->
<div class="modal" id="modalAddVacina" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Vacina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form-add-vacina" action="estoque/adicionar-vacina.php">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Vacina</label>
                                <input value="" type="text" class="form-control" id="vacina" name="vacina"
                                    placeholder="Nome da vacina">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="grupo">Grupo</label>
                                <select class="form-control" id="grupo" name="grupo">
                                    <option value="Covid">Vacinas Covid</option>
                                    <option value="Gerais">Vacinas Gerais</option>
                                    <option value="Campanhas">Vacinas Campanhas</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Idade mínima (Anos)</label>
                                <input value="" type="number" class="form-control" id="anos_minimos" name="anos_minimos"
                                    placeholder="Anos">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Idade mínima (Meses)</label>
                                <input value="" type="number" class="form-control" id="meses_minimos" name="meses_minimos"
                                    placeholder="Meses">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="listar-itens"></div>
                    <div align="center" id="mensagem-adicionar-vacina" class=""></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="btn-cancelar-vacina">Cancelar</button>
                        <button type="submit" class="btn btn-info">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para adicionar Idade -->
<div class="modal" id="modalAddIdade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar Idade Mínima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form-add-vacina" action="estoque/alterar-idade.php">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Vacina</label>
                                <input value="" type="text" class="form-control" id="vacina-modal" name="vacina"
                                    placeholder="Nome da vacina">
                                <div id="vacina-list-modal"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Idade mínima (Anos)</label>
                                <input value="" type="number" class="form-control" id="anos_minimos" name="anos_minimos"
                                    placeholder="Anos">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Idade mínima (Meses)</label>
                                <input value="" type="number" class="form-control" id="meses_minimos" name="meses_minimos"
                                    placeholder="Meses">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="listar-itens"></div>
                    <div align="center" id="mensagem-adicionar-vacina" class=""></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="btn-cancelar-vacina">Cancelar</button>
                        <button type="submit" class="btn btn-info">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalAddItem" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Vacina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form-adicionar-vacina">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Vacina</label>
                                <input value="" type="text" class="form-control" id="vacina-modal" name="vacina"
                                    placeholder="Nome da vacina">
                                <div id="vacina-list-modal"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lote</label>
                                <input value="" type="text" class="form-control" id="lote" name="lote"
                                    placeholder="Número do lote">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Quantidade</label>
                                <input value="" type="number" class="form-control" id="quantidade" name="quantidade"
                                    placeholder="Quantidade">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Data de Validade</label>
                                <input value="" type="date" class="form-control" id="validade" name="validade">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>UBS</label>
                                <input value="" type="text" class="form-control" id="ubs" name="ubs"
                                    placeholder="Nome da UBS">
                                <div id="ubs-list"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="listar-itens"></div>
                    <div align="center" id="mensagem-adicionar-vacina" class=""></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btn-cancelar-vacina">Cancelar</button>
                <input type="hidden" name="id_vacina" id="id_vacina">
                <button type="submit" id="btn-adicionar-estoque" name="btn-adicionar-estoque"
                    class="btn btn-info">Adicionar</button>
            </div>
        </div>
    </div>
</div>

<?php
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "vacina") {
    echo "<script>$('#modalAddVacina').modal('show');</script>";
}
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novo") {
    echo "<script>$('#modalAddItem').modal('show');</script>";
}
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "idade-vacina") {
    echo "<script>$('#modalAddIdade').modal('show');</script>";
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#vacina').on('keyup', function () {
            var query = $(this).val();
            if (query.length >= 3) {
                $.ajax({
                    url: "estoque/buscar_vacinas.php",
                    method: "POST",
                    data: { query: query },
                    success: function (data) {
                        $('#vacina-list').fadeIn();
                        $('#vacina-list').html(data);
                    }
                });
            } else {
                $('#vacina-list').fadeOut();
                $('#vacina-list').html("");
            }
        });

        $(document).on('click', '#vacina-list li', function () {
            $('#vacina').val($(this).text());
            $('#vacina-list').fadeOut();
        });

        $('#vacina-modal').on('keyup', function () {
            var query = $(this).val();
            if (query.length >= 3) {
                $.ajax({
                    url: "estoque/buscar_vacinas.php",
                    method: "POST",
                    data: { query: query },
                    success: function (data) {
                        $('#vacina-list-modal').fadeIn();
                        $('#vacina-list-modal').html(data);
                    }
                });
            } else {
                $('#vacina-list-modal').fadeOut();
                $('#vacina-list-modal').html("");
            }
        });

        $(document).on('click', '#vacina-list-modal li', function () {
            $('#vacina-modal').val($(this).text());
            $('#vacina-list-modal').fadeOut();
        });

        $('#ubs').on('keyup', function () {
            var query = $(this).val();
            if (query.length >= 3) {
                $.ajax({
                    url: "estoque/buscar_ubs.php",
                    method: "POST",
                    data: { query: query },
                    success: function (data) {
                        $('#ubs-list').fadeIn();
                        $('#ubs-list').html(data);
                    }
                });
            } else {
                $('#ubs-list').fadeOut();
                $('#ubs-list').html("");
            }
        });

        $(document).on('click', '#ubs-list li', function () {
            $('#ubs').val($(this).text());
            $('#ubs-list').fadeOut();
        });

        $('#form-add-vacina').submit(function (event) {
            event.preventDefault(); // Evita o comportamento padrão do formulário de ser enviado
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'), // Pega o URL de ação do formulário
                type: 'POST',
                data: formData,
                success: function (mensagem) {
                    $('#mensagem-adicionar-vacina').removeClass();
                    if (mensagem.trim() == "Salvo com Sucesso!!") {
                        $('#btn-cancelar-vacina').click();
                        window.location = "index.php?pag=estoque";
                    } else {
                        $('#mensagem-adicionar-vacina').addClass('text-danger');
                    }
                    $('#mensagem-adicionar-vacina').text(mensagem);
                },
                cache: false,
                contentType: false,
                processData: false,
                xhr: function () {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', function () {
                            // Faz alguma coisa durante o progresso do upload
                        }, false);
                    }
                    return myXhr;
                }
            });
        });

        $('#btn-adicionar-estoque').click(function (event) {
            var pag = "<?= $pag ?>";
            var formData = new FormData($('#form-adicionar-vacina')[0]);

            $.ajax({
                url: "estoque/adicionar-estoque.php",
                type: 'POST',
                data: formData,
                success: function (mensagem) {
                    $('#mensagem-adicionar-vacina').removeClass();
                    if (mensagem.trim() == "Salvo com Sucesso!!") {
                        $('#btn-cancelar-vacina').click();
                        window.location = "index.php?pag=" + pag;
                    } else {
                        $('#mensagem-adicionar-vacina').addClass('text-danger');
                    }
                    $('#mensagem-adicionar-vacina').text(mensagem);
                },
                cache: false,
                contentType: false,
                processData: false,
                xhr: function () {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', function () {
                            /* faz alguma coisa durante o progresso do upload */
                        }, false);
                    }
                    return myXhr;
                }
            });

            event.preventDefault(); // Evita o comportamento padrão do formulário de ser enviado
        });

        $('#dataTable').dataTable({
            "ordering": false
        });
    });
</script>