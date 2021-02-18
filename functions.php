<?php

session_start();
include("conexao.php");

$cpf = $_SESSION['cpf'];
$funcao = $_POST['funcao'];

$sql = mysqli_query($conexao, "SELECT foto, nome, cargo_atual, tipo_usuario, senhacpf, CPF, setor, email FROM funcionario where cpf = '$cpf'");
$dado = mysqli_fetch_array($sql);

if($funcao == 'niver'){
  $data_atual = date('d/m/y');
  $data_explode = explode('/', $data_atual);
  $mes = $data_explode[1];
  $dia = $data_explode[0];

  $qryLista = mysqli_query($conexao, "SELECT nome, setor, nascimento, foto from funcionario where day(nascimento) = '$dia' and month(nascimento) = '$mes' and status = '1'");

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }
  echo json_encode($vetor);
}

if($funcao == 'listar_dados_meta'){
  $setor = $dado['setor'];

  $setor_query = mysqli_query($conexao, "SELECT * FROM setores where id = '$setor'");
  $setor_exec = mysqli_fetch_array($setor_query);

  $qryLista = mysqli_query($conexao, "SELECT * FROM metas where setor = '$setor'");

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }

  echo json_encode($vetor);
}

if($funcao == 'listar_metas_home'){
  $qryLista = mysqli_query($conexao, "SELECT * FROM metas as m inner join setores as s where s.id = m.setor;");

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }

  echo json_encode($vetor);
}

if($funcao == 'alterar_dados_meta'){
  $setor = $dado['setor'];

  $meta = $_POST['meta'];
  $meta = str_replace("." , "" , $meta);
  $meta = str_replace("," , "" , $meta);

  $meta_alcancada = $_POST['meta_alcancada'];
  $meta_alcancada = str_replace("." , "" , $meta_alcancada);
  $meta_alcancada = str_replace("," , "" , $meta_alcancada);

  if($meta == 0){
    echo json_encode ("metazero");
  } else if($meta_alcancada == 0){
    echo json_encode ("alcancadazero");
  } else {
    $altera_meta = "UPDATE metas set meta = '$meta', valor_alcancado = '$meta_alcancada' where setor = '$setor' limit 1";
    $exec = mysqli_query($conexao, $altera_meta);
    if($exec){
      echo json_encode("alterado");
    }
  }
}

if($funcao == 'redefinir_senha'){
  $cpf_recuperar = $_POST['cpf'];
  $cpf_final_recuperar = preg_replace('/[^0-9]/', '', $cpf_recuperar);

  function randString($size){

    $basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

     $return= "";

     for($count= 0; $size > $count; $count++)
     {
         $return.= $basic[rand(0, strlen($basic) - 1)];
     }
     return $return;
   }

   $chave = randString(60);

   $query_redefinir = mysqli_query($conexao, "SELECT email FROM funcionario where CPF = '$cpf_final_recuperar'");
   $result = mysqli_fetch_array($query_redefinir);
   $email = $result['email'];

   require 'contem/PHPMailer/PHPMailerAutoload.php';

   $mail = new PHPMailer();
   $mail->IsSMTP();

   $mail->From = "nao-responda@grupocontem.com.br"; //remitente
   $mail->SMTPAuth = true;
   $mail->SMTPSecure = 'tls'; //seguridad
   $mail->Host = "smtp.office365.com"; // servidor smtp
   $mail->Port = 587; //puerto
   $mail->Username ='naoresponda@grupocontem.com.br'; //nombre usuario
   $mail->setFrom('naoresponda@grupocontem.com.br', 'Nao Responda');
   $mail->Password = 'Bav22911'; //contraseña

   $msg = utf8_decode("Olá, Você solicitou a redefinição da sua senha.\r\n\r\nAcesse o link abaixo para redefinir sua senha: \r\n\r\n https://conexao.grupocontem.com.br/novasenha.php?key=$chave");

   $mail->AddAddress($email);
   $mail->Subject = utf8_decode("Redefinição de senha");
   $mail->Body = $msg;
   $mail->Send();

   if($email != ''){
     $sql = "INSERT into recuperar_senha (chave, email, cpf, data) Values ('$chave', '$email', '$cpf_final_recuperar', NOW())";
     $exec = mysqli_query($conexao, $sql);
   }

   if($email == ''){
     echo json_encode ('email-vazio');
   } else if($exec){
     echo json_encode ('enviado');
   }
}

if($funcao == 'alter_senha'){
  $senha = $_POST['senha'];
  $repetir_senha = $_POST['repetirsenha'];
  $chave = $_POST['chave'];

  //echo''.$senha;
  //echo'<br>'.$repetir_senha;
  //echo'<br>'.$chave;

  $buscar = mysqli_query($conexao, "SELECT * From recuperar_senha where chave = '$chave'");
  $dados = mysqli_fetch_array($buscar);
  $row = mysqli_num_rows($buscar);

  $cpf = $dados['cpf'];

  if($row == 0) {
    echo json_encode ("chave-invalid");
  } elseif($senha != $repetir_senha){
    echo json_encode ("senha-invalid");
  } elseif(strlen($repetir_senha) < 8) {
    echo json_encode ("senha-pequena");
  } else{
    $novasenha = hash('sha512', $repetir_senha);
    $altera_senha = "UPDATE funcionario set senhacpf = '$novasenha' where cpf = '$cpf' limit 1";
    $exec = mysqli_query($conexao, $altera_senha);

    if($exec) {
      echo json_encode("alterado");
    }
  }

}

if($funcao == 'enviar_parabens'){
  mysqli_set_charset($conexao, "utf8");

  $comentario = $_POST['comentario'];

  $now = new DateTime();
  $datetime = $now->format('Y-m-d H:i:s');

  $query = "INSERT into comen_niver (comentario, cpf, data) Values ('$comentario', '$cpf', '$datetime')";
  $exec = mysqli_query($conexao, $query);

  if($exec){
    echo json_encode("inserido");
  } else {
    echo json_encode("error");
  }
}

if($funcao == 'enviar_mensagem'){
  mysqli_set_charset($conexao, "utf8");

  $mensagem = $_POST['mensagem'];
  $setor = $dado['setor'];

  $now = new DateTime();
  $datetime = $now->format('Y-m-d H:i:s');

  $query = "INSERT into chat_setor (mensagem, data, cpf, setor) Values ('$mensagem', '$datetime', '$cpf', '$setor')";
  $exec = mysqli_query($conexao, $query);

  if($exec){
    echo json_encode("inserido");
  } else {
    echo json_encode("error");
  }
}

if($funcao == 'listar_msg_parabens'){
  $qryLista = mysqli_query($conexao, "SELECT * FROM `comen_niver` as n Inner Join funcionario as f Where f.cpf = n.cpf order by data DESC");

  while($resultado = mysqli_fetch_assoc($qryLista)){
  $vetor[] = array_map('utf8_encode', $resultado);
  }

  echo json_encode($vetor);
}

if($funcao == 'puxar_dados_colaborador'){
  $cpf_col = $_POST['cpf'];
  $qryLista = mysqli_query($conexao, "SELECT * FROM funcionario where CPF = '$cpf_col'");

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }

  echo json_encode($vetor);
}

if($funcao == 'listar_mensagens'){
  $setor = $dado['setor'];

  $qryLista = mysqli_query($conexao, "SELECT n.mensagem, n.data, n.cpf, n.setor, f.nome, f.foto, f.cpf FROM chat_setor as n Inner Join funcionario as f Where f.cpf = n.cpf and n.setor = '$setor' order by data ASC");

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }

  echo json_encode($vetor);
}

if($funcao == 'att_mensagens'){
  $setor = $dado['setor'];
  $qtd_msg = $_POST['qtd'];

  $query = mysqli_query($conexao, "SELECT * FROM chat_setor where setor = '$setor'");
  $qtd_query = mysqli_num_rows($query);

  $total = $qtd_query - $qtd_msg;

  $qryLista = mysqli_query($conexao, "SELECT n.mensagem, n.data, n.cpf, n.setor, f.nome, f.foto, f.cpf FROM chat_setor as n Inner Join funcionario as f Where f.cpf = n.cpf and n.setor = '$setor' order by data DESC limit $total");

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }

  echo json_encode($vetor);
}

if($funcao == 'cad_func'){
  $matricula = $_POST['matricula'];
  $nome = $_POST['nome'];
  $nascimento = $_POST['nascimento'];
  $cpf = $_POST['cpf'];
  $email = $_POST['email'];
  $cargo_atual = $_POST['cargo'];
  $setor = $_POST['setor'];
  $sexo = $_POST['sexo'];
  $cpf_final = preg_replace('/[^0-9]/', '', $cpf);

  $sql_mat = mysqli_query($conexao, "SELECT * FROM funcionario where matricula = '$matricula'");
  $qtd_mat_exec = mysqli_num_rows($sql_mat);

  $sql_email = mysqli_query($conexao, "SELECT * FROM funcionario where email = '$email'");
  $qtd_email_exec = mysqli_num_rows($sql_email);

  /*$dados_array = [];
  $dados_array[0] = $_POST['matricula'];
  $dados_array[1] = $_POST['nome'];
  $dados_array[2] = $_POST['nascimento'];
  $dados_array[3] = $cpf_final;
  $dados_array[4] = $_POST['email'];
  $dados_array[5] = $_POST['setor'];*/

  function randString($size){

    $basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

     $return= "";

     for($count= 0; $size > $count; $count++)
     {
         $return.= $basic[rand(0, strlen($basic) - 1)];
     }
     return $return;
   }

   $senha_random = randString(16);
   $senha_random_cript = hash('sha512', $senha_random);

   if($cpf < 14){
     echo json_encode("cpf-invalid");
   } else if($nome == ""){
     echo json_encode("nome-invalid");
   } else if($nascimento == ""){
     echo json_encode("nascimento-invalid");
   } else if($matricula == ""){
     echo json_encode("matricula-invalid");
   } else if($qtd_mat_exec > 0){
     echo json_encode("matricula-existe");
   } else if($email == ""){
     echo json_encode("email-invalid");
   } else if($qtd_email_exec > 0){
     echo json_encode("email-existe");
   } else if($cargo_atual == ""){
      echo json_encode("cargo-invalid");
   } else if($setor == ""){
     echo json_encode("setor-invalid");
   } else if($sexo == ""){
     echo json_encode("sexo-invalid");
   } else {
     $query = "INSERT into funcionario (matricula, email, nome, nascimento, sexo, senhacpf, tipo_usuario, cargo_atual, CPF, status)
     Values ('$matricula', '$email', '$nome','$nascimento', '$sexo', '$senha_random_cript', 'func', '$cargo_atual', '$cpf_final', 1)";
     $exec = mysqli_query($conexao, $query);

     if($exec){
       require 'contem/PHPMailer/PHPMailerAutoload.php';

       $mail = new PHPMailer();
       $mail->IsSMTP();

       $mail->From = "nao-responda@grupocontem.com.br"; //remitente
       $mail->SMTPAuth = true;
       $mail->SMTPSecure = 'tls'; //seguridad
       $mail->Host = "smtp.office365.com"; // servidor smtp
       $mail->Port = 587; //puerto
       $mail->Username ='nao-responda@grupocontem.com.br'; //nombre usuario
       $mail->Password = 'c0Nt3m#2@1p'; //contraseña

       $msg = utf8_decode("<h2>Grupo Contém</h2> Olá, seja bem vindo ao grupo contém! Você já foi cadastrado no sistema da contém e a partir dele você poderá:<br><br>
       <li> Saber novidades </li>
       <li> Consultar Contracheques</li>
       <li> Ver Comunicados </li>
       <li> Consultar informações sobre outros colaboradores</li>
       <li> E muito mais! </li><br><br>
       Para acessar entre em: <a href='https://conexao.grupocontem.com.br'>conexao.grupocontem.com.br</a> e digite as informações:<br><br>
       CPF: $cpf<br>
       Senha: $senha_random");

       $mail->AddAddress($email);
       $mail->Subject = utf8_decode("Seja bem vindo!");
       $mail->IsHTML(true);
       $mail->Body = $msg;
       $mail->Send();

       echo json_encode("cadastrado");
     } else {
       echo json_encode("error");
     }
   }
}

if($funcao == 'editar_func'){
  $matricula = $_POST['matricula_editar'];
  $nome = $_POST['nome_editar'];
  $nascimento = $_POST['nascimento_editar'];
  $cpf = $_POST['cpf_editar'];
  $email = $_POST['email_editar'];
  $cargo_atual = $_POST['cargo_editar'];
  $setor = $_POST['setor_editar'];
  $sexo = $_POST['sexo_editar'];
  $cpf_final = preg_replace('/[^0-9]/', '', $cpf);

  if($nome == ""){
    echo json_encode("nome-invalid");
  } else if($nascimento == ""){
    echo json_encode("nascimento-invalid");
  } else if($cargo_atual == ""){
     echo json_encode("cargo-invalid");
  } else if($setor == ""){
    echo json_encode("setor-invalid");
  } else if($sexo == ""){
    echo json_encode("sexo-invalid");
  } else {
    $query = "UPDATE funcionario set nome = '$nome', nascimento = '$nascimento', email = '$email', cargo_atual = '$cargo_atual', setor = '$setor', sexo = '$sexo'
    where cpf = '$cpf_final' limit 1";
    $exec = mysqli_query($conexao, $query);
    echo json_encode("editado");
  }

}

if($funcao == 'validar_cpf'){
  $cpf_digitado = $_POST['cpf'];
  $cpf_final = preg_replace('/[^0-9]/', '', $cpf_digitado);

  $sql = mysqli_query($conexao, "SELECT matricula FROM funcionario where cpf = '$cpf_final'");
  $qtd_func = mysqli_num_rows($sql);

  if($qtd_func > 0){
    echo json_encode("cpf-existe");
  } else {
    echo json_encode("cpf-nao-existe");
  }
}

if($funcao == 'listar_func'){

  if($dado['tipo_usuario'] == 'rh') {
    $qryLista = mysqli_query($conexao, "SELECT matricula, nome, nascimento, status, CPF from funcionario order by status desc, nome asc");
  } else{

  }

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }

  echo json_encode($vetor);
}

if($funcao == 'listar_colaboradores'){
  $qryLista = mysqli_query($conexao, "SELECT * from funcionario as f Inner Join setores as s where f.setor = s.id and status = '1' order by nome asc");

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }

  echo json_encode($vetor);
}

if($funcao == 'buscar_nome_colaborador'){
  $nome = $_POST['nome_busca'];

  $qryLista = mysqli_query($conexao, "SELECT * from funcionario where nome like '%$nome%'");

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }
  echo json_encode($vetor);
}

if($funcao == "alterar_dados"){
  $email = $_POST['email'];
  $nascimento = $_POST['nascimento'];
  $cpf = $_POST['cpf'];
  $ramal = $_POST['ramal'];

  if($email == ""){
    echo json_encode("email-invalid");
  } else if($nascimento == ""){
    echo json_encode("nascimento-invalid");
  } else if($ramal == ""){
    echo json_encode("ramal-invalid");
  } else {
    $query = "UPDATE funcionario SET email = '$email', nascimento = '$nascimento', ramal = '$ramal' where cpf = '$cpf'";
    $exec = mysqli_query($conexao, $query);
  }

  if($exec){
    echo json_encode("alterado");
  }
}

if($funcao == 'listar_cc'){

  if($dado['tipo_usuario'] == 'rh') {
    $qryLista = mysqli_query($conexao, "SELECT f.matricula, f.nome, cc.data_cadastro, cc.titulo, cc.id from contracheques as cc inner join funcionario as f where cc.matricula_funcionario = f.matricula order by data_cadastro desc");
  } else{
    $qryLista = mysqli_query($conexao, "SELECT f.matricula, f.nome, cc.data_cadastro, cc.titulo, cc.id from contracheques as cc inner join funcionario as f where cpf = '$cpf' and cc.matricula_funcionario = f.matricula order by data_cadastro");
  }

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }
  echo json_encode($vetor);
}

if($funcao == 'listar_cc_filtro'){
  $mes = $_POST['mes_filter'];
  $ano = $_POST['ano_filter'];

  if($dado['tipo_usuario'] == 'rh') {
    $qryLista = mysqli_query($conexao, "SELECT f.matricula, f.nome, cc.data_cadastro, cc.titulo from contracheques as cc inner join funcionario as f where cc.matricula_funcionario = f.matricula and cc.data_cadastro like '$ano-$mes-%'");
  }

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }
  echo json_encode($vetor);
}

if($funcao == 'buscar_nome'){

  $nome = $_POST['busca_nome'];

  if($dado['tipo_usuario'] == 'rh') {
    $qryLista = mysqli_query($conexao, "SELECT f.matricula, f.nome, cc.data_cadastro, cc.titulo, cc.id from contracheques as cc inner join
      funcionario as f where cc.matricula_funcionario = f.matricula and f.nome like '%$nome%' order by cc.data_cadastro");
  }

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }
  echo json_encode($vetor);
}

if($funcao == 'remover_cc'){
  $id = $_POST['id'];
  $delete_cc = "DELETE FROM contracheques where id = $id limit 1";
  $delete_cc_exec = mysqli_query($conexao, $delete_cc);

  if($delete_cc_exec){
    echo json_encode("removido");
  }
}

if($funcao == 'altera_status'){
  $matricula_func = $_POST['matricula'];
  $status_novo = $_POST['novo_status'];

  $query = "UPDATE funcionario SET status = '$status_novo' where matricula = '$matricula_func'";
  $exec = mysqli_query($conexao, $query);

  if($exec){
    echo json_encode("alterado");
  }
}

if($funcao == "anexar_cc"){
  $matricula_funcionario = $_POST['matricula'];
  //$indice = $_POST['indice'];

  function randString($size){

    $basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

     $return= "";

     for($count= 0; $size > $count; $count++)
     {
         $return.= $basic[rand(0, strlen($basic) - 1)];
     }
     return $return;
   }

  $target_dir = 'assets/contracheques/';

  if( isset($_FILES['file']['name'])) {

    $total_files = count($_FILES['file']['name']);

    for($key = 0; $key < $total_files; $key++) {

      $hash_random = randString(60);

      if(isset($_FILES['file']['name'][$key])
                                && $_FILES['file']['size'][$key] > 0) {

        $original_filename = $_FILES['file']['name'][$key];
        $ext = substr($original_filename, -4);

        if($ext == '.pdf'){
          $novo_nome = $hash_random.$ext;
          $target = $target_dir . basename($novo_nome);
          $tmp  = $_FILES['file']['tmp_name'][$key];
          move_uploaded_file($tmp, $target);

          $sql = "INSERT into contracheques (matricula_funcionario, titulo, data_cadastro) Values ('$matricula_funcionario', '$novo_nome', NOW())";
    			$insert = mysqli_query($conexao,$sql);
          echo json_encode("success");
        } else {
          echo json_encode("naopdf");
        }
      } else {
        echo json_encode("vazio");
      }
    }
  }
}

if($funcao == 'listar_mensagens_parabens'){
  $qryLista = mysqli_query($conexao, "SELECT * FROM comen_niver as n Inner Join funcionario as f Where f.cpf = n.cpf order by data ASC");

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }

  echo json_encode($vetor);
}

if($funcao == 'att_parabens'){
  //$setor = $dado['setor'];
  $qtd_msg = $_POST['qtd'];

  $query = mysqli_query($conexao, "SELECT * FROM comen_niver");
  $qtd_query = mysqli_num_rows($query);

  $total = $qtd_query - $qtd_msg;

  $qryLista = mysqli_query($conexao, "SELECT n.comentario, n.data, n.cpf, f.nome, f.foto, f.cpf FROM comen_niver as n Inner Join funcionario as f Where f.cpf = n.cpf order by data DESC limit $total");

  while($resultado = mysqli_fetch_assoc($qryLista)){
    $vetor[] = array_map('utf8_encode', $resultado);
  }

  echo json_encode($vetor);
}
