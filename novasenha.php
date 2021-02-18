<?php

include("conexao.php");

  if (isset($_GET['key']))
      $chave = $_GET['key'];
  else
      $chave = null;

      $dataatual = date('Y-m-d');
      $buscar = mysqli_query($conexao, "SELECT * From recuperar_senha where chave = '$chave'");
      $dados = mysqli_fetch_array($buscar);
      $row = mysqli_num_rows($buscar);
      $data = $dados['data'];

      if($dataatual > $data){
        ?> <script>
            alert("Esse link já expirou. Por favor solicite um novo!");
            window.location.href="index.php";
          </script> <?php
        //header("Location: index.php");
      }
?>

<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Intranet</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body style="">

<div class="box">
	<center><h3> Inserir nova senha </h3></center><br><br>
  A senha deve possuir de 8 à 20 caracteres!
	<form class="form-auth-small" method="POST" id="alterar_senha_form">
	<br>
    <div class="form-group">
			<label for="signin-email" class="control-label sr-only">Email</label>
			<input type="password" class="form-control" id="senha" name="senha" placeholder="Nova senha"><br>
      <input type="password" class="form-control" id="repetirsenha" name="repetirsenha" placeholder="Repetir Senha">
      <input type="hidden" name="funcao" value="alter_senha">
      <input type="hidden" name="chave" value="<?php echo''.$chave; ?>">
		</div>

		<button type="button" class="btn btn-primary btn-lg btn-block" id="alterar_senha_button">ALTERAR SENHA</button><br>
	</form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="assets/js/functions.js"></script>

<script>

	jQuery("#alterar_senha_button").click(function(){
		var data = $("#alterar_senha_form").serialize();

		$.ajax({
			type : 'POST',
			url  : 'functions.php',
			data : data,
			dataType: 'json',
			beforeSend: function()
			{
				$("#recuperar").html('Alterando...');
			},
			success :  function(response){
				if($.trim(response) == 'chave-invalid'){

        } else if($.trim(response) == 'senha-invalid'){
          swal("Opa!", "As senhas digitadas não coincidem!", {
            icon: "error",
          });
        } else if($.trim(response) == 'senha-pequena'){
          swal("Opa!", "A senha deve possuir de 8 à 20 caracteres!", {
            icon: "error",
          });
        } else if($.trim(response) == 'alterado'){
          swal("Perfeito!", "A senha foi alterada com sucesso. Você sera redirecionado à página de login...", {
            icon: "success",
          });
          setTimeout(function(){
            window.location.href="index.php";
          }, 4000);
        }
      }
		});
	});


</script>

<style>

.box{
	width: 35%;
	left: 50%;
	top: 50%;
	padding: 3%;
	position: absolute;
	background-color: white;
	transform: translate(-50%, -50%);
	box-shadow: 1px 2px 10px 0 rgba(0, 0, 0, 0.1);
	border-radius: 5px;
}

</style>



	<!-- WRAPPER -->
	<!--<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<p class="lead" style="font-size: 35px;">Contém</p>
							</div>
							<form class="form-auth-small" action="index.php">
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="email" class="form-control" id="signin-email" value="samuel.gold@domain.com" placeholder="Email">
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="password" class="form-control" id="signin-password" value="thisisthepassword" placeholder="Password">
								</div>
								<div class="form-group clearfix">
									<label class="fancy-checkbox element-left">
										<input type="checkbox">
										<span>Remember me</span>
									</label>
								</div>
								<button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
								<div class="bottom">
									<span class="helper-text"><i class="fa fa-lock"></i> <a href="#">Forgot password?</a></span>
								</div>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading">Free Bootstrap dashboard template</h1>
							<p>by The Develovers</p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>
