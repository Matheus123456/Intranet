<!doctype html>
<html lang="en">

<?php

session_start();
include("conexao.php");
include("verifica_login.php");

$cpf = $_SESSION['cpf'];
$sql = mysqli_query($conexao, "SELECT foto, nome, cargo_atual, tipo_usuario, senhacpf, CPF, empresa FROM funcionario where cpf = '$cpf'");
$dado = mysqli_fetch_array($sql);

$fotoperfil = $dado['foto'];
$nome = $dado['nome'];
$arr = explode(' ', $nome);

?>
<script>

var nome_user = '<?php echo $arr[0].' '.$arr[1];?>';
var foto_user = '<?php echo $fotoperfil; ?>';

</script>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
							<li><a href="galeria.php" class=""><i class="fa fa-picture-o" aria-hidden="true"></i> <span>Galeria</span></a></li>

						<?php } ?>
						<?php if($dado['tipo_usuario'] == 'sv'){ ?>
							<li><a href="metas.php" class=""><i class="fa fa-line-chart"></i> <span>Metas</span></a></li>
						<?php } ?>
						<li><a href="colaboradores.php" class="active"><i class="lnr lnr-users"></i> <span>Colaboradores</span></a></li>
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
					<!-- OVERVIEW -->
              <div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title" style="font-size: 30px; margin-bottom: 25px;">Colaboradores</h3>
									<div class="right">
										<!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#filtros"><span class="lnr lnr-funnel"></span> FILTROS</button>-->
									</div>
								</div>
                <form method="POST" id="buscar_nome_colaborador">
									<div class="form-inline" style="width: 100%; margin-left: 2%; margin-bottom: 45px;">
								    <label for="exampleInputEmail1">Nome do colaborador: </label>&nbsp&nbsp&nbsp
								    <input type="text" class="form-control" id="" name="nome_busca" onkeypress="buscar_colaborador_nome()" style="width: 400px;" aria-describedby="emailHelp">
										<input type="hidden" class="form-control" name="funcao" value="buscar_nome_colaborador">
									</div>
								</form>
								<div class="panel-body no-padding">
									<table class="table table-striped">
										<thead>
											<tr>
												<th width="">Funcionário</th>
												<th width="">Email</th>
												<th>Ramal</th>
                        <th>Setor</th>
											</tr>
										</thead>
										<tbody id="listar_col">

										</tbody>
									</table>
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
	<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="assets/vendor/chartist/js/chartist.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script src="assets/js/functions.js"></script>

  <script> listar_colaboradores(); </script>

<style>
	/* Flex */
.flex {
	display: flex;
}

.flex-wrap {
	flex-wrap: wrap;
}

.flex-item-1 {
	flex: 1;
}

/* Flex Item */
.item {
	margin: 20px;
	//background: tomato;
	text-align: center;
	font-size: 1.5em;
}

.container {
	max-width: 95%;
	justify-content: center;
	margin: 0 auto;
}

.panel .panel-heading button {
		width: 100px;
    padding: 7px;
    margin-left: 0px;
    background-color: ;
    border: none;
    outline: none;
}

</style>

</body>

</html>
