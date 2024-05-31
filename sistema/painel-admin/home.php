<?php 
$res_todos = $pdo->query("SELECT SUM(qtd) as total_quantidade FROM estoque_vacinas WHERE data_vencimento < CURDATE()");
$dados_total = $res_todos->fetch(PDO::FETCH_ASSOC);
$totalvencidas = $dados_total['total_quantidade'];

$res_todos = $pdo->query("SELECT * FROM vacinas_aplicadas WHERE MONTH(data_aplicacao) = MONTH(CURDATE()) AND YEAR(data_aplicacao) = YEAR(CURDATE())");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$totalaplicadasmes = count($dados_total);

$res_todos = $pdo->query("SELECT * FROM vacinas_aplicadas group by cpf");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$qtdcpf = @count($dados_total);

$res_todos = $pdo->query("SELECT * FROM estoque_vacinas group by vacina");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$qtd_vacinas = @count($dados_total);

?>


<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Vacinas Vencidas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalvencidas ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-coins fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Vacinas aplicadas mês</div>
                        <div class="h5 mb-0 font-weight-bold text-success-800"><?php echo @$totalaplicadasmes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-coins fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Quantidade vacinas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$qtd_vacinas ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pacientes Vacinados</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$qtdcpf ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
