<!doctype html>
<html lang="en">

<?php

session_start();
include("conexao.php");
include("verifica_login.php");

$cpf = $_SESSION['cpf'];
$sql = mysqli_query($conexao, "SELECT foto, nome, cargo_atual, tipo_usuario, senhacpf, foto, empresa, CPF FROM funcionario where cpf = '$cpf'");
$dado = mysqli_fetch_array($sql);

$fotoperfil = $dado['foto'];
$nome = $dado['nome'];
$arr = explode(' ', $nome);

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
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
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
						<li><a href="contracheques.php" class="active"><i class="lnr lnr-map"></i> <span>Contracheques</span></a></li>
						<?php if($dado['tipo_usuario'] == 'rh'){ ?>
							<li><a href="folhadomes.php" class=""><i class="fa fa-calendar"></i> <span>Folha do Mês</span></a></li>
							<li><a href="funcionarios.php" class=""><i class="lnr lnr-users"></i> <span>Funcionários</span></a></li>
							<li><a href="galeria.php" class=""><i class="fa fa-picture-o" aria-hidden="true"></i> <span>Galeria</span></a></li>
						<?php } ?>
						<?php if($dado['tipo_usuario'] == 'sv'){ ?>
							<li><a href="metas.php" class=""><i class="fa fa-line-chart"></i> <span>Metas</span></a></li>
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
									<h1 class="panel-title" style="margin-bottom: 25px; font-size: 20px;"> CONTRACHEQUES</h1>
									<div class="right" style="margin-top: -10px;">
										<?php if($dado['tipo_usuario'] == 'rh') { ?>
										<button type="button" class="btn btn-default" data-toggle="modal" data-target="#filtros"><span class="lnr lnr-funnel"></span> FILTROS</button>
										<?php } ?>
									</div>
								</div>
								<hr style="margin-top: -25px;"> </hr>

							<?php if($dado['tipo_usuario'] == 'rh') { ?>
								<form method="POST" id="buscar_nome">
									<div class="form-inline" style="width: 100%; margin-left: 2%; margin-bottom: 25px;">
								    <label for="exampleInputEmail1">Nome do funcionario: </label>&nbsp&nbsp&nbsp
								    <input type="text" class="form-control" id="busca_nome" name="busca_nome" onkeypress="buscar_por_nome()" style="width: 400px;" aria-describedby="emailHelp">
										<input type="hidden" class="form-control" name="funcao" value="buscar_nome">
									</div>
								</form>

							<?php } ?>

								<div class="panel-body no-padding" style="border-top: 1px solid; border-color: #ddd">
									<table class="table table-striped" style="text-align: center">
										<thead>
											<tr>
												<th width="25px"><center>Matricula</th>
												<th width="400px"><center>Nome</th>
												<th width="200px"><center>Data</th>
												<th width="200px"><center>Ações</th>
											</tr>
										</thead>
										<tbody id="contracheques">

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

<div class="modal fade" id="filtros" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Filtros</h2>
      </div>
      <div class="modal-body">

				<form method="POST" id="filtros_form">

				<select class="form-control" name="mes_filter" id="mes_filter">
					<option value="">MÊS</option>
					<option value="01">JANEIRO</option>
					<option value="02">FEVEREIRO</option>
					<option value="03">MARÇO</option>
					<option value="04">ABRIL</option>
					<option value="05">MAIO</option>
					<option value="06">JUNHO</option>
					<option value="07">JULHO</option>
					<option value="08">AGOSTO</option>
					<option value="09">SETEMBRO</option>
					<option value="10">OUTUBRO</option>
					<option value="11">NOVEMBRO</option>
					<option value="12">DEZEMBRO</option>
				</select>
				<br>
				<select class="form-control" name="ano_filter" id="ano_filter">
					<option value="2020">2020</option>
					<option value="2019">2019</option>
				</select>
				<input type="hidden" name="funcao" value="listar_cc_filtro">
			</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
        <button type="button" class="btn btn-primary" onclick="listar_cc_filtros()">FILTRAR</button>
      </div>
    </div>
  </div>
</div>


	<!-- Javascript -->
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script src="assets/vendor/toastr/toastr.min.js"></script>
	<script src="assets/js/functions.js"></script>
</body>

<style>

.modal{
	 top: 50%;
	 transform: translateY(-50%);
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

<script>

listar_cc();

</script>
</html>
