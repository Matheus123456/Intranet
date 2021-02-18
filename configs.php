<!doctype html>
<html lang="en">

<?php

session_start();
include("conexao.php");
include("verifica_login.php");

$cpf = $_SESSION['cpf'];
$sql = mysqli_query($conexao, "SELECT * FROM funcionario where cpf = '$cpf'");
$dado = mysqli_fetch_array($sql);

$fotoperfil = $dado['foto'];
$nome = $dado['nome'];
$arr = explode(' ', $nome);

$nascimento = explode('-', $dado['nascimento']);

if($dado['sexo'] == 'F'){
	$sexo = "FEMININO";
} else {
	$sexo = "MASCULINO";
}

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
						<li><a href="colaboradores.php" class=""><i class="lnr lnr-users"></i> <span>Colaboradores</span></a></li>
						<li><a href="configs.php" class="active"><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
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
					<div class="panel panel-profile">
						<div class="clearfix">
							<!-- LEFT COLUMN -->
							<div class="profile-left">
								<!-- PROFILE HEADER -->
								<div class="profile-header">
									<div class="overlay"></div>
									<div class="profile-main">
										<img src="assets/img/<?php echo''.$fotoperfil ?>" class="img-circle" alt="Avatar">
										<h3 class="name"><?php echo''.$arr[0].' '.$arr[1]; ?></h3>
										<!--<span class="online-status status-available">Available</span>-->
									</div>
									<!--<div class="profile-stat">
										<div class="row">
											<div class="col-md-4 stat-item">
												45 <span>Projects</span>
											</div>
											<div class="col-md-4 stat-item">
												15 <span>Awards</span>
											</div>
											<div class="col-md-4 stat-item">
												2174 <span>Points</span>
											</div>
										</div>
									</div>-->
								</div>
								<!-- END PROFILE HEADER -->
								<!-- PROFILE DETAIL -->
								<div class="profile-detail">
									<div class="profile-info">
										<h4 class="heading">Informações Pessoais</h4>
										<ul class="list-unstyled list-justify">
											<li>Data de Nascimento <span><?php echo''.$nascimento[2].'/'.$nascimento[1].'/'.$nascimento[0]; ?></span></li>
											<li>Email <span><a href="mailto:<?php echo''.$dado['email']; ?>"><?php echo''.$dado['email']; ?></a></span></li>
											<li>Cargo Atual <span><?php echo''.$dado['cargo_atual']; ?></a></span></li>
											<li>Setor <span><?php echo''.$dado['setor']; ?></a></span></li>
										</ul>
									</div>
									<div class="profile-info">
										<ul class="list-inline">
											<h4 class="heading">Social Contém</h4>
											<li><a href="https://www.facebook.com/grupocontem/" target="_blank" class=""><i class=""><img src="assets/img/facebook.png" width="40px"></i></a></li>
											<li><a href="https://www.instagram.com/grupocontem/" target="_blank" class=""><i class=""><img src="assets/img/instagram.png" width="40px"></i></a></li>
											<li><a href="https://www.linkedin.com/company/grupocontem/" target="_blank" class=""><i class=""><img src="assets/img/linkedin.png" width="40px"></i></a></li>
											<li><a href="https://www.youtube.com/channel/UCM0hzn9m8puHZaoqpQQ9vdw" target="_blank" class=""><i class=""><img src="assets/img/youtube.png" width="50px"></i></a></li>
										</ul>
										<ul class="list-inline">
											<h4 class="heading">Social HC</h4>
											<li><a href="https://www.facebook.com/HCBROKERCORRETORA/" target="_blank" class=""><i class=""><img src="assets/img/facebook.png" width="40px"></i></a></li>
											<li><a href="https://www.instagram.com/hcbroker/" target="_blank" class=""><i class=""><img src="assets/img/instagram.png" width="40px"></i></a></li>
											<li><a href="https://www.linkedin.com/company/51682994/admin/" target="_blank" class=""><i class=""><img src="assets/img/linkedin.png" width="40px"></i></a></li>
										</ul>

										<!--<ul class="list-inline">
											<?php if($dado['empresa'] == 'contem') { ?>
											<li><a href="https://www.facebook.com/grupocontem/" target="_blank" class=""><i class=""><img src="assets/img/facebook.png" width="40px"></i></a></li>
											<li><a href="https://www.instagram.com/grupocontem/" target="_blank" class=""><i class=""><img src="assets/img/instagram.png" width="40px"></i></a></li>
											<li><a href="https://www.linkedin.com/company/grupocontem/" target="_blank" class=""><i class=""><img src="assets/img/linkedin.png" width="40px"></i></a></li>
											<li><a href="https://www.youtube.com/channel/UCM0hzn9m8puHZaoqpQQ9vdw" target="_blank" class=""><i class=""><img src="assets/img/youtube.png" width="50px"></i></a></li>
										<?php } else if ($dado['empresa'] == 'hc') { ?>
											<li><a href="https://www.facebook.com/HCBROKERCORRETORA/" target="_blank" class=""><i class=""><img src="assets/img/facebook.png" width="40px"></i></a></li>
											<li><a href="https://www.instagram.com/hcbroker/" target="_blank" class=""><i class=""><img src="assets/img/instagram.png" width="40px"></i></a></li>
											<li><a href="https://www.linkedin.com/company/51682994/admin/" target="_blank" class=""><i class=""><img src="assets/img/linkedin.png" width="40px"></i></a></li>
											<li><a href="https://www.youtube.com/channel/UCM0hzn9m8puHZaoqpQQ9vdw" target="_blank" class=""><i class=""><img src="assets/img/youtube.png" width="50px"></i></a></li>
										<?php } ?>
									</ul>-->
									</div>
									<!--<div class="profile-info">
										<h4 class="heading">About</h4>
										<p>Interactively fashion excellent information after distinctive outsourcing.</p>
									</div>
									<div class="text-center"><a href="#" class="btn btn-primary">Edit Profile</a></div>-->
								</div>
								<!-- END PROFILE DETAIL -->
							</div>
							<!-- END LEFT COLUMN -->
							<!-- RIGHT COLUMN -->
							<div class="profile-right" style="margin-bottom:0px;">
								<h4 class="heading" style="margin-bottom: 15px;">Editar Dados</h4>
								<!-- AWARDS -->
								<form method="POST" id="dados_perfil">
								<div class="awards">
									<div class="row" style="width: 100%; text-align:center;">
										<div class="form-group col-md-6">
											<input class="form-control input-lg" type="text" value="<?php echo''.$dado['nome']; ?>" readonly>
										</div>

										<div class="form-group col-md-6">
											<input class="form-control input-lg" type="text" name="email" value="<?php echo''.$dado['email']; ?>" placeholder="Email">
										</div>

										<div class="form-group col-md-6">
											<input class="form-control input-lg" type="date" name="nascimento" value="<?php echo''.$dado['nascimento']; ?>">
										</div>

										<div class="form-group col-md-6">
											<input class="form-control input-lg" type="text" value="<?php echo''.$sexo; ?>" readonly>
										</div>

										<div class="form-group col-md-6">
											<input class="form-control input-lg" type="text" name="cpf" value="<?php echo''.$dado['CPF']; ?>" readonly>
										</div>

										<div class="form-group col-md-6">
											<input class="form-control input-lg" type="text" name="ramal" value="<?php echo''.$dado['ramal']; ?>" placeholder="Ramal">
										</div>

										<input class="hidden" name="funcao" value="alterar_dados" readonly>

										<div class="form-group col-md-6" style="text-align: left;">
										 	<button type="button" class="btn btn-primary btn-lg" onclick="alterar_dados()">Atualizar dados</button>
										</div>
									</div>
								</form>
								</div>
								<!-- END AWARDS -->
								<!-- TABBED CONTENT -->
								<div class="custom-tabs-line tabs-line-bottom left-aligned">
									<ul class="nav" role="tablist">
										<li class="active"><a href="#tab-bottom-left1" role="tab" data-toggle="tab">Chat</a></li>
									</ul>
								</div>
								<div class="tab-content" id="teste" style="overflow: scroll; height: 400px; overflow-x: hidden;">
									<ul class="list-unstyled activity-list" id="scroll">


									</ul>
								</div>
								<div style="padding-bottom: 0px;">
		              <!--<center><input class="form-control input-lg" placeholder="Mande seu parabéns!" type="text" style="width: 50%; border-radius: 20px;">
		              <input type="button" class="btn btn-primary btn-lg" style=""><b><span class="icon"><i class="fa fa-shopping-bag"></i></span>-->
		              <form method="POST" id="mensagem_form">
		                <div class="input-group" style="height: 100%; padding: 8px; margin-top: 25px; box-shadow: 0px 0px 0px 0 rgba(0, 0, 0, 0.1);">
		                  <input class="form-control input-lg" type="text" placeholder="Escreva uma mensagem!" onkeyup="contar_caracteres()" maxlength="100" id="comentario" name="mensagem"></input>
		                  <input type="hidden" name="funcao" value="enviar_mensagem">
		                  <span class="input-group-btn">
		                    <button class="btn btn-primary" type="button" style="height: 100%;" onclick="enviar_mensagem()">
		                      <span class="lnr lnr-arrow-right-circle"></span>
		                    </button>
		                  </span>
		                </div>
		              </form>
		              <label style="margin-left: 15px;"> <div id="caracteres" style="float: left;">100</div> <div style="float: left;">&nbspcaracteres restantes!</div></label>
		            </div>
		          </div>
								<!-- END TABBED CONTENT -->
							</div>
							<!-- END RIGHT COLUMN -->
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
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
	<script src="assets/vendor/toastr/toastr.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script src="assets/js/functions.js"></script>
</body>

<script>

listar_mensagens();
atualizar_msg();

</script>

</html>
