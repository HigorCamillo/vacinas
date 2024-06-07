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
    <a type="button" class="btn-primary btn-sm ml-2" href="index.php?pag=<?php echo $pag ?>&funcao=idade-vacina">Alterar
        Idade Mínima</a>
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
                        <th>Validade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $pdo->query("SELECT vacina, ubs, SUM(qtd) AS qtd_total, data_vencimento FROM estoque_vacinas GROUP BY vacina, ubs");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }

                        $nome = $res[$i]['vacina'];
                        $estoque = $res[$i]['qtd_total'];
                        $ubs = $res[$i]['ubs'];
                        $data_vencimento = $res[$i]['data_vencimento'];
                        ?>
                        <tr>
                            <td><?php echo $nome ?></td>
                            <td><?php echo $estoque ?></td>
                            <td><?php echo $ubs ?></td>
                            <td><?php echo $data_vencimento ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm"
                                    onclick="confirmDelete('<?php echo $nome ?>', '<?php echo $ubs ?>')">Excluir</button>
                            </td>
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
                <form method="post" id="form-add-vacina">
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
                                <input value="" type="number" class="form-control" id="meses_minimos"
                                    name="meses_minimos" placeholder="Meses">
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

<!-- Modal para adicionar estoque -->
<div class="modal" id="modalAddItem" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Estoque</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form-adicionar-vacina">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="vacina-modal">Vacina</label>
                                <input type="text" class="form-control" id="vacina-modal" name="vacina"
                                    placeholder="Nome da vacina" value="">
                                <div id="vacina-list-modal"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="lote">Lote</label>
                                <input type="text" class="form-control" id="lote" name="lote"
                                    placeholder="Número do lote" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="quantidade">Quantidade</label>
                                <input type="number" class="form-control" id="quantidade" name="quantidade"
                                    placeholder="Quantidade" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="validade">Data de Validade</label>
                                <input type="date" class="form-control" id="validade" name="validade" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ubs">UBS</label>
                                <input type="text" class="form-control" id="ubs" name="ubs" placeholder="Nome da UBS"
                                    value="">
                                <div id="ubs-list"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="listar-itens"></div>
                    <div align="center" id="mensagem-adicionar-estoque" class=""></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="btn-cancelar-estoque">Cancelar</button>
                        <button type="submit" class="btn btn-info">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal para alterar idade mínima -->
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
                <form method="post" id="form-alterar-idade">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Vacina</label>
                                <input value="" type="text" class="form-control" id="busca-vacina" name="vacina"
                                    placeholder="Nome da vacina">
                                <div id="busca-vacina-modal"></div>
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
                                <input value="" type="number" class="form-control" id="meses_minimos"
                                    name="meses_minimos" placeholder="Meses">
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

<!-- Modal de Confirmação -->
<div class="modal" id="modalConfirmacao" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Tem certeza de que deseja adicionar este item?</p>
                <div id="mensagemSucesso" style="display: none;" class="alert alert-success" role="alert">
                    Item adicionado com sucesso!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-info" id="confirmarAdicao">Confirmar</button>
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
        let currentForm;
        let currentAction;

        // Função para exibir a modal de confirmação
        function showConfirmationModal(form, action) {
            currentForm = form;
            currentAction = action;
            $('#modalConfirmacao').modal('show');
        }

        // Função para submeter o formulário após a confirmação
        $('#confirmarAdicao').click(function () {
            // Chama a função para tratar a confirmação
            handleConfirmation();
        });

        // Função para tratar a confirmação
        function handleConfirmation() {
            var formData = $(currentForm).serialize(); // Serializa os dados do formulário

            $.ajax({
                url: currentAction,
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#mensagemSucesso').fadeIn().text(response);
                    setTimeout(function () {
                        $('#mensagemSucesso').fadeOut();
                        $('#modalConfirmacao').modal('hide');
                        if (response.trim() === 'Estoque Adicionado com Sucesso!') {
                            $(currentForm)[0].reset();
                            window.location = "index.php?pag=estoque";
                        }
                    }, 2000);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Manipulador de evento para o formulário de adicionar estoque
        $('#form-adicionar-vacina').submit(function (event) {
            event.preventDefault();
            $('#modalAddItem').modal('hide');
            showConfirmationModal(this, 'estoque/adicionar-estoque.php');
        });

        // Manipulador de evento para o formulário de adicionar vacina
        $('#form-add-vacina').submit(function (event) {
            event.preventDefault();
            $('#modalAddVacina').modal('hide');
            showConfirmationModal(this, 'estoque/adicionar-vacina.php');
        });

        // Manipulador de evento para o formulário de alterar idade mínima
        $('#form-alterar-idade').submit(function (event) {
            event.preventDefault();
            $('#modalAddIdade').modal('hide');
            showConfirmationModal(this, 'estoque/alterar-idade.php');
        });
        // Funções para buscar e selecionar vacinas e UBS
        $('#busca-vacina').on('keyup', function () {
            var query = $(this).val();
            if (query.length >= 3) {
                $.ajax({
                    url: "estoque/buscar_vacinas.php",
                    method: "POST",
                    data: { query: query },
                    success: function (data) {
                        $('#busca-vacina-modal').fadeIn();
                        $('#busca-vacina-modal').html(data);
                    }
                });
            } else {
                $('#busca-vacina-modal').fadeOut();
                $('#busca-vacina-modal').html("");
            }
        });

        $(document).on('click', '#busca-vacina-modal li', function () {
            $('#busca-vacina').val($(this).text());
            $('#busca-vacina-modal').fadeOut();
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
    });
</script>