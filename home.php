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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
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
						<li><a href="home.php" class="active"><i class="lnr lnr-home"></i> <span>Início</span></a></li>
						<li><a href="contracheques.php" class=""><i class="lnr lnr-map"></i> <span>Contracheques</span></a></li>
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
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title text-center">COMUNICADOS</h3>
							<hr style="border: #FE642E solid 1px;">

						<div id="myCarousel" class="carousel slide" data-ride="carousel">

								<ol class="carousel-indicators">
									<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
									<!--<li data-target="#myCarousel" data-slide-to="1"></li>
									<li data-target="#myCarousel" data-slide-to="2"></li>-->
								</ol>

							<div class="carousel-inner" role="listbox">
								<div class="item active">
									<img src="assets/img/Banner-Máscara.jpg" width="100%">
									<div class="carousel-caption">

									</div>
								</div>

								<!--<div class="item">
									<img src="assets/img/Banner-Máscara.jpg" width="100%">
									<div class="carousel-caption">

									</div>
								</div>

								<div class="item">
									<img src="assets/img/FERIAS_banner.jpg" width="100%">
									<div class="carousel-caption">

									</div>
								</div>-->
							</div>

							<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<!-- TASKS -->
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">METAS</h3>
							<div class="right">
								<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
							</div>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled task-list" id="metas_ul">

								<!--<li>
									<p>Cobrança Cancelada <span class="label-percent">80%</span></p>
									<div class="progress progress-xs">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
											<span class="sr-only">80% Complete</span>
										</div>
									</div>
								</li>
								<li>
									<p>Comercial <span class="label-percent">100%</span></p>
									<div class="progress progress-xs">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
											<span class="sr-only">Success</span>
										</div>
									</div>
								</li>
								<li>
									<p>HC Broker <span class="label-percent">45%</span></p>
									<div class="progress progress-xs">
										<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
											<span class="sr-only">45% Complete</span>
										</div>
									</div>
								</li>-->

							</ul>
						</div>
					</div>
					<!-- END TASKS -->
				</div>
				<div class="col-md-6">
					<div class="panel">
						<div class="panel-heading">
							<img src="assets/img/meta.jpg" width="470px" height="315px"/>
						</div>
					</div>
				</div>
			</div>

					<div class="row">
						<div class="col-md-7">
							<!-- TODO LIST -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title text-center" style="font-weight: bold;">ANIVERSARIANTES DO DIA</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<!--<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>-->
									</div>
								</div>
								<div class="panel-body">
									<div class="niver-vazio" style="text-align: center; margin-top: 25%; margin-bottom: 32%;"> Não há aniversariantes hoje! </div>
									<section class="container flex flex-wrap nivers">

									</section>
								</div>
							</div>
							<!-- END TODO LIST -->
						</div>
						<div class="col-md-5">
							<!-- TIMELINE -->
							<div class="panel panel-scrolling">
								<div class="panel-heading">
									<h3 class="panel-title text-center" style="font-weight: bold;">Deixe uma mensagem de aniversário!</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<!--<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>-->
									</div>
								</div>
								<div class="tab-content" id="teste" style="overflow: scroll; height: 400px; overflow-x: hidden;">
									<ul class="list-unstyled activity-list" id="scroll">


									</ul>
								</div>

								<div style="padding-bottom: 5px;">
									<!--<center><input class="form-control input-lg" placeholder="Mande seu parabéns!" type="text" style="width: 50%; border-radius: 20px;">
									<input type="button" class="btn btn-primary btn-lg" style=""><b><span class="icon"><i class="fa fa-shopping-bag"></i></span>-->
									<form method="POST" id="parabens">
										<div class="input-group" style="height: 100%; padding: 8px; margin-top: 25px; box-shadow: 0px 0px 0px 0 rgba(0, 0, 0, 0.1);">
											<input class="form-control input-lg" type="text" placeholder="Mande seu parabéns!" onkeyup="parabens()" maxlength="100" id="comentario" name="comentario"></input>
											<input type="hidden" name="funcao" value="enviar_parabens">
											<span class="input-group-btn">
												<button class="btn btn-primary" type="button" style="height: 100%;" onclick="enviar_parabens()">
													<span class="lnr lnr-arrow-right-circle"></span>
												</button>
											</span>
										</div>
									</form>
									<label style="margin-left: 15px;"> <div id="caracteres" style="float: left;">100</div> <div style="float: left;">&nbspcaracteres restantes!</div></label>
								</div>
							</div>
						</div>
					</div>

				<div class="col-md-12">
					<div class="panel">
						<div class="panel-heading">
							<center><h3 class="panel-title" style="font-weight: bold; font-size: 20px; margin-top: 30px; margin-bottom: 10px;">Compartilhe conosco sua recordação com a contém!<br></h1><small>Clique no espaço abaixo para selecionar suas fotos</small></center>
						</div>
						<div class="container" style="margin-top: 40px; margin-bottom: 50px;">

						 <form action="upload_image.php" class="dropzone" id="dropzoneFrom">
							 <center><div class="dz-message" data-dz-message style="margin-top: 42px;"><span>Selecione as imagens</span></div></center>
						 </form>

						</div>
					</div>
				</div>


	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="assets/vendor/chartist/js/chartist.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script src="assets/js/functions.js"></script>

	<script>

	//listar_msg_parabens();
	listar_mensagens_parabens();
	aniversariantes();
	atualizar_parabens();
	listar_metas_home();


	</script>

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

</style>

</body>
</html>
