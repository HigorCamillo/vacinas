<?php
require_once ("../../conexao.php");
@session_start();
//verificar se o usuário está autenticado
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Cliente') {
    echo "<script language='javascript'> window.location='../index.php' </script>";
}


$agora = date('Y-m-d');

//variaveis para o menu
$pag = @$_GET["pag"];
$menu2 = "historico";
$menu3 = "carteira-digital";
$menu4 = "pendentes";

//CONSULTAR O BANCO DE DADOS E TRAZER OS DADOS DO USUÁRIO
$res = $pdo->query("SELECT * FROM usuarios where id = '$_SESSION[id_usuario]'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome_usu = @$dados[0]['nome'];
$email_usu = @$dados[0]['email'];
$cpf_usu = @$dados[0]['cpf'];
$nome_mae = @$dados[0]['nome_mae'];
$cartao_sus = @$dados[0]['cartao_sus'];
$municipio_nascimento = @$dados[0]['municipio_nascimento'];
$municipio_residencia = @$dados[0]['municipio_residencia'];
$cor_autodeclarada =@$dados[0]['cor_autodeclarada'];
$numero_celular = @$dados[0]['numero_celular'];
$dt_nasc = @$dados[0]['dt_nasc'];
?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Hugo Vasconcelos">

    <title>Painel Cliente</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="shortcut icon" href="../../img/logoicone2.ico" type="image/x-icon">
    <link rel="icon" href="../../img/logoicone2.ico" type="image/x-icon">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #4E73DF;" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">PACIENTE</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Consultas
            </div>




            <!-- Nav Item - Charts -->

            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-home fa-chart-area"></i>
                    <span>Home</span></a>
            </li>




            <li class="nav-item">
                <a class="nav-link" href="index.php?pag=<?php echo $menu2 ?>">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Historico geral</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="index.php?pag=<?php echo $menu3 ?>">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Carteira Digital</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="index.php?pag=<?php echo $menu4 ?>">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Vacinas Pendentes</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">



                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo @$nome_usu ?></span>
                                <img class="img-profile rounded-circle" src="../../img/sem-foto.jpg">

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalPerfil">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-primary"></i>
                                    Editar Perfil
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                                    Sair
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php if ($pag == null) {
                        include_once ("home.php");

                    } else if ($pag == $menu2) {
                        include_once ($menu2 . ".php");
                    } else if ($pag == $menu3) {
                        include_once ($menu3 . ".php");
                    } else if ($pag == $menu4) {
                        include_once ($menu4 . ".php");
                    } else {
                        include_once ("home.php");
                    }
                    ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!--  Modal Perfil-->
    <div class="modal fade" id="ModalPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form id="form-perfil" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nome</label>
                            <input value="<?php echo @$nome_usu ?>" type="text" class="form-control" id="nome-usuario"
                                name="nome-usuario" placeholder="Nome">
                        </div>

                        <div class="form-group">
                            <label>CPF</label>
                            <input value="<?php echo @$cpf_usu ?>" type="text" class="form-control" id="cpf-usuario"
                                name="cpf-usuario" placeholder="CPF">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input value="<?php echo @$email_usu ?>" type="email" class="form-control"
                                id="email-usuario" name="email-usuario" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input value="<?php echo @$dt_nasc ?>" type="date" class="form-control" id="dt_nasc" name="dt_nasc">
                        </div>

                        <div class="form-group">
                            <label for="nome_mae">Nome da Mãe</label>
                            <input value="<?php echo @$nome_mae ?>" type="text" class="form-control" id="nome_mae" name="nome_mae"
                                placeholder="Nome completo da mãe">
                        </div>

                        <div class="form-group">
                            <label for="cartao_sus">Número do Cartão SUS</label>
                            <input value="<?php echo @$cartao_sus ?>" type="text" class="form-control" id="cartao_sus" name="cartao_sus"
                                placeholder="Número do Cartão SUS">
                        </div>

                        <div class="form-group">
                            <label for="municipio_nascimento">Município de Nascimento</label>
                            <input value="<?php echo @$municipio_nascimento ?>" type="text" class="form-control" id="municipio_nascimento"
                                name="municipio_nascimento" placeholder="Município de nascimento">
                        </div>

                        <div class="form-group">
                            <label for="municipio_residencia">Município de Residência</label>
                            <input value="<?php echo @$municipio_residencia?>" type="text" class="form-control" id="municipio_residencia"
                                name="municipio_residencia" placeholder="Município de residência">
                        </div>

                        <div class="form-group">
                        <label for="cor_autodeclarada">Cor Autodeclarada</label>
                        <select class="form-control" id="cor_autodeclarada" name="cor_autodeclarada">
                            <option value="Branca" <?php echo @$cor_autodeclarada == 'Branca' ? 'selected' : ''; ?>>Branca</option>
                            <option value="Preta" <?php echo @$cor_autodeclarada == 'Preta' ? 'selected' : ''; ?>>Preta</option>
                            <option value="Parda" <?php echo @$cor_autodeclarada == 'Parda' ? 'selected' : ''; ?>>Parda</option>
                            <option value="Amarela" <?php echo @$cor_autodeclarada == 'Amarela' ? 'selected' : ''; ?>>Amarela</option>
                            <option value="Indígena" <?php echo @$cor_autodeclarada == 'Indígena' ? 'selected' : ''; ?>>Indígena</option>
                        </select>
                    </div>
                        <div class="form-group">
                            <label for="numero_celular">Número de Celular</label>
                            <input value="<?php echo @$numero_celular ?>" type="text" class="form-control" id="numero_celular" name="numero_celular"
                                placeholder="Número de celular">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Senha</label>
                                    <input value="" type="password" class="form-control" id="senha" name="senha"
                                        placeholder="Senha">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirmar Senha</label>
                                    <input value="" type="password" class="form-control" id="conf-senha"
                                        name="conf-senha" placeholder="Senha">
                                </div>
                            </div>
                        </div>


                        <small>
                            <div id="mensagem-perfil" class="mr-4">

                            </div>
                        </small>



                    </div>
                    <div class="modal-footer">



                        <input value="<?php echo $_SESSION['id_usuario'] ?>" type="hidden" name="txtid" id="txtid">
                        <input value="<?php echo $_SESSION['cpf_usuario'] ?>" type="hidden" name="antigo" id="antigo">

                        <button type="button" id="btn-fechar-perfil" class="btn btn-secondary"
                            data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-salvar-perfil" id="btn-salvar-perfil"
                            class="btn btn-primary">Salvar</button>
                    </div>
                </form>


            </div>
        </div>
    </div>






    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

</body>

</html>






<script type="text/javascript">
    $('#btn-salvar-perfil').click(function (event) {
        event.preventDefault();

        $.ajax({
            url: "editar-perfil.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === 'Salvo com Sucesso!') {

                    $('#btn-fechar-perfil').click();
                    window.location = 'index.php';

                }
                else {
                    $('#mensagem-perfil').addClass('text-danger')
                    $('#mensagem-perfil').text(msg);


                }
            }
        })
    })
</script>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<script src="../../js/mascara.js"></script>