<?php
 header('Access-Control-Allow-Origin: *');

 $con = new mysqli("grupocontem.com.br", "grupocon_conexao", "c0Nt3m#2@1p", "grupocon_bd");
 if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

if (isset($_GET['proposta']))
    $proposta = $_GET['proposta'];
else
    $proposta = null;

if (isset($_GET['pergunta']))
    $pergunta = $_GET['pergunta'];
else
    $pergunta = null;

    $data = $_POST['data'];
    $ocorrido = $_POST['ocorrido'];
    $pergunta_fim = $_POST['pergunta_fim'];
    $resposta = $_POST['resposta'];
    $tipo = $_POST['tipo'];

    /*echo'<br>$Pergunta: '.$pergunta;
    echo'<br>$resposta: '.$resposta;
    echo'<br>$proposta: '.$proposta;
    echo'<br>$tipo: '.$tipo;
    echo'<br>$data: '.$data;
    echo'<br>$ocorrido: '.$ocorrido;
    echo'<br>$pergunta_fim: '.$pergunta_fim;
*/

    $sql1 = "SELECT * FROM wp_respostas where proposta = '$proposta' and pergunta = '$pergunta'";
    $exec = mysqli_query($con, $sql1);
    $row = mysqli_num_rows($exec);

    if($row > 0) {
      $sql = "UPDATE wp_respostas set resposta = 'Sim', data = '$data', ocorrido = '$ocorrido', titulo_pergunta = '$pergunta_fim'
      where proposta = '$proposta' and pergunta = '$pergunta' limit 1";
    } else {
      $sql = "INSERT into wp_respostas (pergunta, resposta, proposta, tipo, data, ocorrido, titulo_pergunta)
      VALUES ('$pergunta', '$resposta', '$proposta', '$tipo', '$data', '$ocorrido', '$pergunta_fim')";
    }


    if(empty($data) or empty($ocorrido)){
      echo json_encode("error");
    } else{
      mysqli_query($con, $sql);
      echo json_encode("success");
  }

?>
