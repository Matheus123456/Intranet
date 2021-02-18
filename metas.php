<!doctype html>
<html lang="en">

<?php

session_start();
include("conexao.php");
include("verifica_login.php");

$cpf = $_SESSION['cpf'];
$sql = mysqli_query($conexao, "SELECT foto, nome, cargo_atual, tipo_usuario, senhacpf, foto, empresa, CPF, setor FROM funcionario where cpf = '$cpf'");
$dado = mysqli_fetch_array($sql);

$fotoperfil = $dado['foto'];
$nome = $dado['nome'];
$arr = explode(' ', $nome);

$tipo_usuario = $dado['tipo_usuario'];

if($tipo_usuario != 'sv'){
	header('location: home.php');
}

$setor = $dado['setor'];

?>

<script> var tipo_usuario = '<?php echo''.$dado['tipo_usuario']; ?>'; </script>

<head>
	<title>Inicio</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
	<link rel="stylesheet" href="assets/vendor/toastr/toastr.min.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<?php if($dado['empresa'] == "contem") { ?>
					<a href="index.html"><img src="assets/img/contem-logo.png" alt="Klorofil Logo" class="img-responsive logo"></a>
				<?php } else if($dado['empresa'] == "hc") { ?>
					<a href="index.html"><img src="assets/img/logo_hc.png" alt="Klorofil Logo" style="width: 91px; height: 21px;" class="img-responsive logo"></a>
				<?php
				} else {

				}
				?>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>

				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<!--<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">5</span>
							</a>-->
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="https://conexao.grupocontem.com.br/assets/img/<?php echo ''.$fotoperfil ?>" class="img-circle" alt="Avatar"> <span><?php echo''.$arr[0] ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<!--<li><a href="#"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
								<li><a href="#"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li>
								<li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>-->
								<li><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Deslogar</span></a></li>
							</ul>
						</li>
						<!-- <li>
							<a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
						</li> -->
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="home.php" class=""><i class="lnr lnr-home"></i> <span>Início</span></a></li>
						<li><a href="contracheques.php" class=""><i class="lnr lnr-map"></i> <span>Contracheques</span></a></li>
						<?php if($dado['tipo_usuario'] == 'rh'){ ?>
							<li><a href="folhadomes.php" class=""><i class="fa fa-calendar"></i> <span>Folha do Mês</span></a></li>
							<li><a href="funcionarios.php" class=""><i class="lnr lnr-users"></i> <span>Funcionários</span></a></li>
						<?php } ?>
						<?php if($dado['tipo_usuario'] == 'sv'){ ?>
							<li><a href="metas.php" class="active"><i class="fa fa-line-chart"></i> <span>Metas</span></a></li>
						<?php } ?>
						<li><a href="colaboradores.php" class=""><i class="lnr lnr-users"></i> <span>Colaboradores</span></a></li>
						<li><a href="configs.php" class=""><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
						<li><a href="logout.php" class=""><i class="lnr lnr-exit"></i> <span>Sair</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title text-center" style="">METAS DO MÊS</h3>
							<hr style="border: #00AAFF solid 1px;">
						</div>

						<center>
							<div class="card" style="margin-left: 25%; margin-right: 25%; margin-bottom: 40px; border: 1px solid rgba(0,0,0,.125); border-radius: 5px;">
							  <div class="card-header"><br>
							    <h4> <b>Meta do mês de ???</b></h4>
							  </div>
								<br><br>
							  <div class="card-body">
									<label>Valor da meta: </label>
									<form method="POST" id="dados_meta">
										<div class="input-group" style="width: 60%;">
											<span class="input-group-addon">R$</span>
											<input class="form-control" type="text" id="meta" name="meta">
										</div>
										<br>
										<label>Valor alcançado: </label>
										<div class="input-group" style="width: 60%;">
											<span class="input-group-addon">R$</span>
											<input class="form-control" type="text" id="meta_alcancada" name="meta_alcancada">
										</div>
										<br>
										<input type="hidden" name="funcao" value="alterar_dados_meta">
										<div class="progress" style="width: 60%;">
											<div class="progress-bar progress-bar-danger" role="progressbar" id="barra_meta" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">

											</div>
										</div>
									</form>
									<button type="button" class="btn btn-primary btn-block" style="width: 60%;" onclick="alterar_meta(); att_percent_meta();">ATUALIZAR</button>
									<br><br>
							  </div>
							</div>
						</center>
					</div>
				</div>

		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2017 <a href="https://www.themeineed.com" target="_blank">Theme I Need</a>. All Rights Reserved.</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="assets/vendor/chartist/js/chartist.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script src="assets/js/functions.js"></script>
	<script src="assets/js/maskMoney.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</body>

<script>

$('#meta').mask('#.##0,00', {reverse: true});
$('#meta_alcancada').mask('#.##0,00', {reverse: true});
listar_dados_meta();

</script>

</html>
