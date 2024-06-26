<?php
require_once ("../conexao.php");

//VERIFICAR SE EXISTE ALGUM CADASTRO NO BANCO, SE NÃO TIVER CADASTRAR O USUÁRIO ADMINISTRADOR
$res = $pdo->query("SELECT * FROM usuarios");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$senha_crip = md5('123');
if (@count($dados) == 0) {
   $res = $pdo->query("INSERT into usuarios (nome, cpf, email, senha, senha_crip, nivel, imagem) values ('Administrador', '000.000.000-00', '$email', '123', '$senha_crip', 'Admin', 'sem-foto.jpg')");
}



?>

<!DOCTYPE html>
<html>

<head>
   <title>Login - <?php echo $nome_loja ?></title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
   <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
   <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
      integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
      crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
      integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
      crossorigin="anonymous"></script>
   <!------ Include the above in your HEAD tag ---------->

   <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
   <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
   <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

   <link href="../css/login.css" rel="stylesheet">
   <script src="../js/login.js"></script>

   <link rel="shortcut icon" href="../img/logoicone1.ico" type="image/x-icon">
   <link rel="icon" href="../img/logoicone2.ico" type="image/x-icon">


</head>



<body>
   <div class="container">
      <div class="row">
         <div class="col-md-5 mx-auto">
            <div id="first">
               <div class="myform form ">
                  <div class="logo mb-3">
                     <div class="col-md-12 text-center">
                        <h1>Login</h1>
                     </div>
                  </div>
                  <form action="autenticar.php" method="post" name="login">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Email ou CPF</label>
                        <input type="text" name="email_login" class="form-control" id="email_login"
                           aria-describedby="emailHelp" placeholder="Insira seu Email ou CPF" value="">
                     </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Senha</label>
                        <input type="password" name="senha_login" id="senha_login" class="form-control"
                           aria-describedby="emailHelp" placeholder="Senha" value="">
                     </div>


                     <div class="col-md-12 text-center mt-4">
                        <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
                     </div>




                     <div class="form-group mt-4">
                        <small>
                           <p class="text-center">Não possui Cadastro? <a href="#" data-toggle="modal"
                                 data-target="#modalCadastro">Cadastre-se</a></p>
                           <p class="text-center"><a class="text-danger" href="#" data-toggle="modal"
                                 data-target="#modalRecuperar">Recuperar Senha?</a></p>
                        </small>
                     </div>
                  </form>

               </div>
            </div>

         </div>
      </div>
   </div>

</body>


</html>




<!-- Modal -->
<div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastre-se</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">

                    <div class="form-group">
                        <label for="nome">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Insira o nome e Sobrenome">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="<?php echo @$_GET['email_rodape'] ?>" type="email" class="form-control" id="email" name="email" placeholder="Seu Email">
                    </div>

                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Insira seu CPF">
                    </div>

                    <div class="form-group">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento">
                    </div>

                    <div class="form-group">
                        <label for="nome_mae">Nome da Mãe</label>
                        <input type="text" class="form-control" id="nome_mae" name="nome_mae" placeholder="Nome completo da mãe">
                    </div>

                    <div class="form-group">
                        <label for="cartao_sus">Número do Cartão SUS</label>
                        <input type="text" class="form-control" id="cartao_sus" name="cartao_sus" placeholder="Número do Cartão SUS">
                    </div>

                    <div class="form-group">
                        <label for="municipio_nascimento">Município de Nascimento</label>
                        <input type="text" class="form-control" id="municipio_nascimento" name="municipio_nascimento" placeholder="Município de nascimento">
                    </div>

                    <div class="form-group">
                        <label for="municipio_residencia">Município de Residência</label>
                        <input type="text" class="form-control" id="municipio_residencia" name="municipio_residencia" placeholder="Município de residência">
                    </div>

                    <div class="form-group">
                        <label for="cor_autodeclarada">Cor Autodeclarada</label>
                        <select class="form-control" id="cor_autodeclarada" name="cor_autodeclarada">
                            <option value="Branca">Branca</option>
                            <option value="Preta">Preta</option>
                            <option value="Parda">Parda</option>
                            <option value="Amarela">Amarela</option>
                            <option value="Indígena">Indígena</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="numero_celular">Número de Celular</label>
                        <input type="text" class="form-control" id="numero_celular" name="numero_celular" placeholder="Número de celular">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Inserir Senha">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="confirmar_senha">Confirmar Senha</label>
                                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" placeholder="Confirmar Senha">
                            </div>
                        </div>
                    </div>

                    <small>
                        <div id="div-mensagem"></div>
                    </small>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-fechar-cadastrar" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" id="btn-cadastrar" class="btn btn-info">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- Modal Recuperar -->
<div class="modal fade" id="modalRecuperar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Recuperar Senha</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form method="post">



               <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="email" class="form-control" id="email-recuperar" name="email-recuperar"
                     placeholder="Seu Email">

               </div>


               <small>
                  <div id="div-mensagem-rec"></div>
               </small>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

            <button type="button" id="btn-recuperar" class="btn btn-info">Recuperar</button>

            </form>

         </div>
      </div>
   </div>
</div>



<?php

if (@$_GET["email_rodape"] != null) {
   echo "<script>$('#modalCadastro').modal('show');</script>";
}

?>


<script type="text/javascript">
   $('#btn-cadastrar').click(function (event) {
      var cpf = $('#cpf').val();

      //validação de cpf
      cpf = cpf.replace('-', '');
      cpf = cpf.replace('-', '.');
      cpf = cpf.replace(/\D/g, '');

      if (cpf.toString().length != 11 || /^(\d)\1{10}$/.test(cpf)) {
         alert('CPF Inválido!');
         return;
      }



      var result = true;
      [9, 10].forEach(function (j) {
         var soma = 0, r;
         cpf.split(/(?=)/).splice(0, j).forEach(function (e, i) {
            soma += parseInt(e) * ((j + 2) - (i + 1));
         });
         r = soma % 11;
         r = (r < 2) ? 0 : 11 - r;
         if (r != cpf.substring(j, j + 1)) result = false;
      });

      if (result != true) {
         alert('CPF Inválido!');
         return;
      }

      $.ajax({
         url: "cadastrar.php",
         method: "post",
         data: $('form').serialize(),
         dataType: "text",
         success: function (msg) {
            if (msg.trim() === 'Cadastrado com Sucesso!') {

               $('#div-mensagem').addClass('text-success')
               $('#div-mensagem').text(msg);
               $('#btn-fechar-cadastrar').click();
               $('#email_login').val(document.getElementById('email').value);
               $('#senha_login').val(document.getElementById('senha').value);
            }
            else {
               $('#div-mensagem').addClass('text-danger')
               $('#div-mensagem').text(msg);


            }
         }
      })
   })
</script>



<script type="text/javascript">
   $('#btn-recuperar').click(function (event) {
      event.preventDefault();

      $.ajax({
         url: "recuperar.php",
         method: "post",
         data: $('form').serialize(),
         dataType: "text",
         success: function (msg) {
            if (msg.trim() === 'Senha Enviada para o Email!') {

               $('#div-mensagem-rec').addClass('text-success')
               $('#div-mensagem-rec').text(msg);

            } else if (msg.trim() === 'Preencha o Campo Email!') {
               $('#div-mensagem-rec').addClass('text-success')
               $('#div-mensagem-rec').text(msg);

            } else if (msg.trim() === 'Este email não está cadastrado!') {
               $('#div-mensagem-rec').addClass('text-success')
               $('#div-mensagem-rec').text(msg);
            }



            else {
               $('#div-mensagem-rec').addClass('text-danger')
               $('#div-mensagem-rec').text('Deu erro ao Enviar o Formulário! Provavelmente seu servidor de hospedagem não está com permissão de envio habilitada ou você está em um servidor local');


            }
         }
      })
   })
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<script src="../js/mascara.js"></script>