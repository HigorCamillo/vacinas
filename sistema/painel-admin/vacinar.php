<?php

require_once("../../conexao.php"); 
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Vacina e UBS</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form id="form-selecionar-vacina">
        <label for="vacina">Vacina:</label>
        <input type="text" id="vacina" name="vacina" placeholder="Nome da vacina" required>
        <div id="vacina-list"></div>
        <br>

        <label for="ubs">UBS:</label>
        <input type="text" id="ubs" name="ubs" placeholder="Nome da UBS" required>
        <div id="ubs-list"></div>
        <br>

        <label for="lote">Lote:</label>
        <input type="text" id="lote" name="lote" placeholder="Número do lote" readonly>
        <br>

        <label for="validade">Data de Validade:</label>
        <input type="date" id="validade" name="validade" readonly>
        <br>

        <button type="submit">Enviar</button>
    </form>

    <script type="text/javascript">
        $(document).ready(function () {
            // Buscar vacinas
            $('#vacina').on('keyup', function () {
                var query = $(this).val();
                if (query.length >= 3) {
                    $.ajax({
                        url: "buscar_vacinas.php",
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
                fetchLoteAndValidade();
            });

            // Buscar UBS
            $('#ubs').on('keyup', function () {
                var query = $(this).val();
                if (query.length >= 3) {
                    $.ajax({
                        url: "buscar_ubs.php",
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
                fetchLoteAndValidade();
            });

            function fetchLoteAndValidade() {
                var vacina = $('#vacina').val();
                var ubs = $('#ubs').val();
                if (vacina && ubs) {
                    $.ajax({
                        url: "buscar_lote_validade.php",
                        method: "POST",
                        data: { vacina: vacina, ubs: ubs },
                        success: function (data) {
                            var result = JSON.parse(data);
                            $('#lote').val(result.lote);
                            $('#validade').val(result.validade);
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>
