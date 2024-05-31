<?php
require_once("../../../conexao.php");

@session_start();
$cpf_usuario = @$_SESSION['cpf_usuario']; // Certifique-se de que o CPF do usuário está armazenado na sessão

// Verificar se o usuário está autenticado
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Cliente') {
  echo "<script language='javascript'> window.location='../index.php' </script>";
  exit();
}

// Receber a opção selecionada
$opcao = isset($_POST['opcao']) ? $_POST['opcao'] : 1;

// Preparar a consulta SQL com base na opção selecionada
if ($opcao == 1) {
  $query_ped = $pdo->query("
    SELECT va.*, v.grupo 
    FROM vacinas_aplicadas va 
    INNER JOIN vacinas v ON va.vacina = v.nome 
    WHERE va.cpf = '$cpf_usuario' AND v.grupo = 'Covid' 
    ORDER BY va.id ASC");
} else if ($opcao == 2) {
  $query_ped = $pdo->query("
    SELECT va.*, v.grupo 
    FROM vacinas_aplicadas va 
    INNER JOIN vacinas v ON va.vacina = v.nome 
    WHERE va.cpf = '$cpf_usuario' AND v.grupo = 'Gerais' 
    ORDER BY va.id ASC");
} else if ($opcao == 3) {
  $query_ped = $pdo->query("
    SELECT va.*, v.grupo 
    FROM vacinas_aplicadas va 
    INNER JOIN vacinas v ON va.vacina = v.nome 
    WHERE va.cpf = '$cpf_usuario' AND v.grupo = 'Campanhas' 
    ORDER BY va.id ASC");
}

// Verificar se a consulta retornou resultados
if ($query_ped) {
  $res_ped = $query_ped->fetchAll(PDO::FETCH_ASSOC);

  // Iterar sobre os resultados e retornar em formato HTML
  foreach ($res_ped as $row) {
    $vacina = $row['vacina'];
    $local = $row['ubs'];
    $data_aplicacao = $row['data_aplicacao']; 
    $cod_aplicador = $row['cod_aplicador'];

    // Formatar a data
    $data_aplicacao = implode('/', array_reverse(explode('-', $data_aplicacao)));
    echo "
    <tr>
      <td>{$vacina}</td>
      <td>{$local}</td>
      <td>{$data_aplicacao}</td>
      <td>{$cod_aplicador}</td>
    </tr>";
  }
} else {
  // Se não houver resultados, retornar uma mensagem
  echo "
  <tr>
    <td colspan='3'>Nenhum resultado encontrado</td>
  </tr>";
}
?>
