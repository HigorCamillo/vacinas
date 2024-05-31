<?php 

$id_usuario = $_SESSION['id_usuario'];
$cpf_usuario = $_SESSION['cpf_usuario'];

//Trazer vacinas covid
$res_todos = $pdo->query("SELECT va.*, v.grupo 
FROM vacinas_aplicadas va 
INNER JOIN vacinas v ON va.vacina = v.nome 
WHERE va.cpf = '$cpf_usuario' AND v.grupo = 'Covid' 
ORDER BY va.id ASC");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$vacinasCovid = count($dados_total);


//Trazer vacinas gerais
$res_todos = $pdo->query("
SELECT va.*, v.grupo 
FROM vacinas_aplicadas va 
INNER JOIN vacinas v ON va.vacina = v.nome 
WHERE va.cpf = '$cpf_usuario' AND v.grupo = 'Gerais' 
ORDER BY va.id ASC");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$vacinasGerais = count($dados_total);

//Trazer total de pedidos pendentes
$res_todos = $pdo->query("SELECT v.*
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
ORDER BY v.id ASC");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$vacinasPendentes = count($dados_total);


//Trazer vacinas campanha
$res_todos = $pdo->query("
SELECT va.*, v.grupo 
FROM vacinas_aplicadas va 
INNER JOIN vacinas v ON va.vacina = v.nome 
WHERE va.cpf = '$cpf_usuario' AND v.grupo = 'Campanhas' 
ORDER BY va.id ASC");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$vacinasCampanha = count($dados_total);

 ?>



<div class="row">

    <!-- Earnings (Monthly) Card Example -->
     <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Vacinas Covid</div>
                        <div class="h5 mb-0 font-weight-bold text-success-800"><?php echo @$vacinasCovid ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Vacinas Gerais</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$vacinasGerais ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-home fa-2x text-warning"></i>
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
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Vacinas Campanhas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$vacinasCampanha ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Vacinas Pendentes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$vacinasPendentes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    
</div>

