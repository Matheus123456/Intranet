<!doctype html>
<html lang="en">

<?php

session_start();
include("conexao.php");
include("verifica_login.php");

mysqli_set_charset($conexao, "utf8");

$cpf = $_SESSION['cpf'];
$sql = mysqli_query($conexao, "SELECT foto, nome, cargo_atual, tipo_usuario, senhacpf, CPF FROM funcionario where cpf = '$cpf'");
$dado = mysqli_fetch_array($sql);

$tipo_usuario = $dado['tipo_usuario'];

if($tipo_usuario != 'rh'){
	header('location: home.php');
}

$sql_setores = mysqli_query($conexao, "SELECT * FROM setores");

$fotoperfil = $dado['foto'];
$nome = $dado['nome'];
$arr = explode(' ', $nome);

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
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
							<li><a href="folhadomes.php" class=""><i class="fa fa-calendar"></i> <span>Folha do Mês</span></a></li>
							<li><a href="funcionarios.php" class="active"><i class="lnr lnr-users"></i> <span>Funcionários</span></a></li>
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
								<a href="#" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#exampleModal"> + Adicionar</a>
									<h1 class="panel-title" style="margin-bottom: 25px; font-size: 30px;"> FUNCIONÁRIOS</h1>
									<div class="right">
									</div>

								<div class="panel-body no-padding">
									<table class="table table-hover" style="text-align: center;">
										<thead>
											<tr>
												<th width="25px"><center>Matricula</th>
												<th width="400px"><center>Nome</th>
												<th width="200px"><center>Nascimento</th>
												<th width="200px"><center>Status</th>
											</tr>
										</thead>
										<tbody id="func">

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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Cadastrar Funcionário</h2>
      </div>
      <div class="modal-body">
				<form method="POST" id="cad_func">

					<div class="form-group error0">
	        	<input type="text" class="form-control" name="cpf" id="cpf" onkeyup="validar_cpf()" placeholder="CPF">
						<label id="erro-label" style="margin-top: 8px; margin-left: 4px; font-size: 12px; color:red; display: none;"> CPF já cadastrado! </label>
					</div>

					<div class="form-group error1">
						<input type="text" class="form-control" name="nome" placeholder="Nome Completo" onkeyup="convertToUppercase(this)">
					</div>
					<div class="form-group error2">
						<input type="date" class="form-control" name="nascimento" placeholder="Data de Nascimento">
					</div>
					<div class="form-group error3">
						<input type="text" class="form-control" name="matricula" id="matricula" placeholder="Matrícula">
					</div>
					<div class="form-group error4">
						<input type="text" class="form-control" name="email" placeholder="Email">
					</div>
					<div class="form-group error5">
						<input type="text" class="form-control" name="cargo" placeholder="Cargo Atual" onkeyup="convertToUppercase(this)">
					</div>
					<div class="form-group error5">
						<select class="form-control" name="setor">
							<option value="">Setor</option>
							<option value="1">Atendimento</option>
							<option value="2">Cobrança</option>
							<option value="3">Comercial</option>
							<option value="4">Financeiro</option>
							<option value="5">HC Broker</option>
							<option value="6">Jurídico</option>
							<option value="7">Logística</option>
							<option value="8">Marketing</option>
							<option value="9">Pós Venda</option>
							<option value="10">RH</option>
							<option value="11">TI</option>
						</select>
					</div>

					<input type="hidden" class="form-control" name="funcao" value="cad_func">

					<div class="form-group error6">
						<select class="form-control" name="sexo">
							<option value="">Sexo</option>
							<option value="M">MASCULINO</option>
							<option value="F">FEMININO</option>
						</select>
					</div>
				</form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="button_cadastrar_func" onclick="cadastrar_func()" disabled>Cadastrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="func_editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Editar Funcionário</h2>
      </div>
      <div class="modal-body">
				<form method="POST" id="editar_func">

					<div class="form-group error0">
	        	<input type="text" class="form-control" name="cpf_editar" id="cpf_editar" placeholder="CPF" readonly>
					</div>

					<div class="form-group error1">
						<input type="text" class="form-control" name="nome_editar" id="nome_editar" placeholder="Nome Completo" onkeyup="convertToUppercase(this)">
					</div>
					<div class="form-group error2">
						<input type="date" class="form-control" name="nascimento_editar" id="nascimento_editar" placeholder="Data de Nascimento">
					</div>
					<div class="form-group error3">
						<input type="text" class="form-control" name="matricula_editar" id="matricula_editar" placeholder="Matrícula" readonly>
					</div>
					<div class="form-group error4">
						<input type="text" class="form-control" name="email_editar" id="email_editar" placeholder="Email">
					</div>
					<div class="form-group error5">
						<input type="text" class="form-control" name="cargo_editar" id="cargo_atual_editar" placeholder="Cargo Atual" onkeyup="convertToUppercase(this)">
					</div>
					<div class="form-group error5">
						<select class="form-control" name="setor_editar" id="setor_editar">
							<?php
							while($busca_setores = mysqli_fetch_array($sql_setores)) {
								$id = $busca_setores['id'];
								$nome_setor = $busca_setores['nome_setor'];
							?>
							<option value="<?php echo''.$id; ?>"> <?php echo''.$nome_setor ?></option>
						<?php } ?>
						</select>
					</div>

					<input type="hidden" class="form-control" name="funcao" value="editar_func">

					<div class="form-group error6">
						<select class="form-control" name="sexo_editar" id="sexo_editar">
							<option value="">Sexo</option>
							<option value="M">MASCULINO</option>
							<option value="F">FEMININO</option>
						</select>
					</div>
				</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="" onclick="editar_func()">Editar</button>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</body>


<script>

listar_func();
jQuery('#cpf').mask('999.999.999-99');
jQuery('#nascimento').mask('99/99/9999');

</script>

<style>

.panel .panel-heading button {
  background-color:#00AAFF;
	border-color: #00a0f0;
	float: right;
	padding: 10px;
	border-color: #00a0f0;
}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>
</html>
