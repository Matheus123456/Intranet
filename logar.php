<?php
session_start();
include("conexao.php");
/*if(empty($_POST['matricula']) || empty($_POST['senhacpf'])){
	header('Location: home.php');
	exit();
}*/

$cpf_limpo = preg_replace('/[^0-9]/', '', $_POST['cpf']);
//Dados para realização do login\\
$cpf = mysqli_real_escape_string($conexao, $cpf_limpo);
$senha = mysqli_real_escape_string($conexao, hash('sha512', $_POST['senhacpf']));

//echo''.$cpf;
//echo'<br>'.$senha;

//Dado para definição do tipo do usuario\\

//Busca matricula e senha no banco de dados e verifica se o usuario existe ou nao\\
$query = "select cpf, senhacpf from funcionario where CPF = '{$cpf}' and senhacpf = '{$senha}'";
$result = mysqli_query($conexao, $query);
$row = mysqli_num_rows($result);


if($row == 1){ // Se o usuario existir o row retorna 1, senão retorna 0\\
		//$query2 = "Insert into registro_login (matricula, data_hora) Values ('$matricula', NOW())";
		//$insert = mysqli_query($conexao,$query2);
		$_SESSION['cpf'] = $cpf;
    echo json_encode("logou");
		//header('Location: index.php');
		exit();
}else{
	$_SESSION['senha_incorreta'] = true;
	//header('Location: login.php');
  echo json_encode("nao-logou");
	exit();
}

?>
