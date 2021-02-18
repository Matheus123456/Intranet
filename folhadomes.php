<!doctype html>
<html lang="en">

<?php

session_start();
include("conexao.php");
include("verifica_login.php");

$cpf = $_SESSION['cpf'];
$sql = mysqli_query($conexao, "SELECT foto, nome, cargo_atual, tipo_usuario, senhacpf, CPF FROM funcionario where cpf = '$cpf'");
$dado = mysqli_fetch_array($sql);

$fotoperfil = $dado['foto'];
$nome = $dado['nome'];
$arr = explode(' ', $nome);

$qryLista = "SELECT matricula, nome, nascimento from funcionario where status = '1' order by nome asc";
$exec = mysqli_query($conexao, $qryLista);

$tipo_usuario = $dado['tipo_usuario'];

if($tipo_usuario != 'rh'){
	header('location: home.php');
}

?>

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
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="index.html"><img src="assets/img/contem-logo.png" alt="Klorofil Logo" class="img-responsive logo"></a>
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
							<li><a href="folhadomes.php" class="active"><i class="fa fa-calendar"></i> <span>Folha do Mês</span></a></li>
							<li><a href="funcionarios.php" class=""><i class="lnr lnr-users"></i> <span>Funcionários</span></a></li>
							<li><a href="galeria.php" class=""><i class="fa fa-picture-o" aria-hidden="true"></i> <span>Galeria</span></a></li>
						<?php } ?>
						<li><a href="colaboradores.php" class=""><i class="lnr lnr-users"></i> <span>Colaboradores</span></a></li>
						<li><a href="configs.php" class=""><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
						<li><a href="logout.php" class=""><i class="lnr lnr-exit"></i> <span>Sair</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">
							<!-- RECENT PURCHASES -->
							<div class="panel">
								<div class="panel-heading">
									<h1 class="panel-title" style="margin-bottom: 25px; font-size: 30px;"> FOLHA DO MÊS</h1>
									<div class="right">

									</div>
								</div>

								<div class="panel-body no-padding">
									<table class="table table-striped" style="text-align: center">
										<thead>
											<tr>
												<th width="25px"><center>Matricula</th>
												<th width="200px"><center>Nome</th>
												<th width="500px"><center>Ações</th>
											</tr>
										</thead>

										<?php
										while($busca = mysqli_fetch_array($exec)) {
											$matricula_funcionario = $busca['matricula'];
											$nome = $busca['nome'];
											$nascimento = $busca['nascimento'];
											$indice++;
										?>
											<tr>
												<td style="vertical-align: middle;"><center><?php echo''.$matricula_funcionario; ?></td>
												<td style="vertical-align: middle;"><center><?php echo''.$nome; ?></td>
												<!--<td style="vertical-align: middle;"><center><?php echo''.$nascimento; ?></td>-->
												<td style="vertical-align: middle;"> <center>
													<form method="POST" id="<?php echo'anexar_cc'.$indice; ?>" enctype="multipart/form-data">
													<div class="input-group">
							              <input type="text" class="form-control" id="" readonly>
							                <label class="input-group-btn">
							                 <span class="btn btn-primary">
							                   Escolher&hellip;
																 	<input type="file" name="file[]" style="display: none;"/>
																 	<input type="hidden" name="matricula" value="<?php echo''.$matricula_funcionario; ?>">
																	<input type="hidden" name="funcao" value="anexar_cc">
							                 </span>
							               </label>
														 <label class="input-group-btn">
															 <span class="btn btn-primary" id="<?php echo'btn-enviar'.$indice;?>" style="margin-left: 5px;">
																 <div id="<?php echo'enviarmsg'.$indice; ?>"> <span class="lnr lnr-upload"></span> &nbsp&nbspEnviar </div>
																 <div id="<?php echo'spin'.$indice; ?>" style="display: none"><i class="fa fa-spinner fa-spin"></i> Carregando...</div>
																 <div id="<?php echo'enviado'.$indice; ?>" style="display: none"><i class="fa fa-check-circle"></i> Enviado</div>
																 <div id="<?php echo'erro'.$indice; ?>" style="display: none"><i class="fa fa-warning"></i> Erro</div>

																 <button type="button" class="<?php echo'enviar'.$indice; ?>" onclick="anexar_cc(<?php echo''.$indice; ?>)" style="display: none;"/>
															 </span>
														 </form>
														 </label>
							             </div>
												</td>
											</tr>
										<?php } ?>

										<tbody id="funcionarios">

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script src="assets/vendor/toastr/toastr.min.js"></script>
	<script src="assets/js/functions.js"></script>
</body>

<script>

listar_func();

</script>

</html>
