
jQuery(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  jQuery(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  jQuery(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
});

function convertToUppercase(el) {
  if(!el || !el.value) return;
  el.value = el.value.toUpperCase();
}

function aniversariantes (){
//  $('#contracheques').empty(); //Limpando a tabela
  var funcao = "niver";

  $.ajax({
    type:'post', //Definimos o método HTTP usado
    dataType: 'json',	//Definimos o tipo de retorno
    url: 'functions.php',
    data: {'funcao': funcao},
    error: function() {
      alert("Error");
    },
    success: function(dados)
    {
      for(var i=0; i<=dados.length; i++){
        var nome = dados[i].nome;
        var primeiro_nome = nome.split(" ");
        var nascimento = dados[i].nascimento;
        var ano = nascimento.split('-')[0];
        var mes = nascimento.split('-')[1];
        var dia = nascimento.split('-')[2];
        var setor = dados[i].setor;
        var foto = dados[i].foto;
        $('.niver-vazio').css("display", 'none');

        $('.nivers').append('\
          <div class="item">\
            <div class="card" style="width: 18rem; border: 1px solid #ccc; border-radius: 3px;">\
              <img src="assets/img/'+foto+'" style="width: 178px" class="card-img-top" alt="...">\
              <div class="card-body">\
                <h4 class="card-title" style="font-weight: bold;">'+primeiro_nome[0]+' '+primeiro_nome[1]+'</h4>\
                <h5 class="card-title">'+dia+'/'+mes+'</h5>\
                <p class="card-text"></p>\
              </div>\
            </div>\
          </div>');
      }
    }
  });
}

function listar_cc (){
  $('#contracheques').empty(); //Limpando a tabela
  var listar_cc = "listar_cc";

  $.ajax({
    type:'post', //Definimos o método HTTP usado
    dataType: 'json',	//Definimos o tipo de retorno
    url: 'functions.php',
    data: {'funcao': listar_cc},
    success: function(dados){
      for(var i=0; i<dados.length; i++){
        var matricula = dados[i].matricula;
        var nome = dados[i].nome;
        var data_cadastro = dados[i].data_cadastro;
        var ano = data_cadastro.split('-')[0];
        var mes = data_cadastro.split('-')[1];
        var dia = data_cadastro.split('-')[2];
        var titulo = dados[i].titulo;
        var id = dados[i].id;
        var button_remover = null;

        if(tipo_usuario == 'func'){
          button_remover = 'none';
        } else if (tipo_usuario == 'rh'){
          button_remover = 'inline-block';
        }

        $('#contracheques').append('\
          <tr">\
            <td style="vertical-align: middle;">'+matricula+'</td>\
            <td style="vertical-align: middle;">'+nome+'</td>\
            <td style="vertical-align: middle;">'+dia+'/'+mes+'/'+ano+'</td>\
            <td style="vertical-align: middle;"><a href="https://conexao.grupocontem.com.br/assets/contracheques/'+titulo+'" target="_blank"><button type="button" class="btn btn-primary"><i class="lnr lnr-download"></i></button></a>\
            <button type="button" style="display: '+button_remover+'" class="btn btn-danger" onclick="remover_cc(\'' + matricula + '\', '+id+')"><i class="lnr lnr-trash"></i></button></td>\
          </tr>');
        }
      }
    });
  }

function listar_colaboradores (){
  var funcao = "listar_colaboradores";

  $.ajax({
    type:'post', //Definimos o método HTTP usado
    dataType: 'json',	//Definimos o tipo de retorno
    url: 'functions.php',
    data: {'funcao': funcao},
    success: function(dados){
      for(var i=0; i<dados.length; i++){
        var matricula = dados[i].matricula;
        var foto = dados[i].foto;
        var nome = dados[i].nome;
        var nome_split = nome.split(" ");
        var email = dados[i].email;
        var ramal = dados[i].ramal;
        var nascimento = dados[i].nascimento;
        var setor = dados[i].nome_setor;
        var empresa = dados[i].empresa;

        if (empresa == "contem"){
          var nome_empresa = 'Contém';
        } else if (empresa == "hc"){
          var nome_empresa = 'HC Broker';
        }

        $('#listar_col').append('\
        <tr>\
          <td style="line-height: 5"><a href="#"><img src="assets/img/'+foto+'" width="60" style="border-radius: 70px; margin-right: 10px;"> '+nome+'</a></td>\
          <td style="line-height: 5"> <a href="mailto:'+email+'">'+email+'</td>\
          <td style="line-height: 5">'+ramal+'</td>\
          <td style="line-height: 5">'+setor+'</td>\
        </tr>');
      }
    }
  });
}

function alterar_dados (){
  var dados = $('#dados_perfil').serialize();

  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: 'functions.php',
    async: true,
    data: dados,
    error: function() {
      alert("Error");
    },
    success: function(result)
    {
      if($.trim(result) == "alterado"){
        swal("Perfeito", "Seus dados foram alterados com sucesso!", "success", {
          button: "OK",
        });
      }
    }
  });
}

function listar_cc_filtros (){
  jQuery(document).ready(function(){
    $('#contracheques').empty();
    var dados = $('#filtros_form').serialize();

    $.ajax({
      type:'post',
      dataType: 'json',
      url: 'functions.php',
      data: dados,
      success: function(dados){
        	if($.trim(dados) == ''){
          $('#contracheques').append('\
          <tr><td colspan="4"> Nenhum arquivo encontrado! </td></tr>');
          $('#filtros').modal('hide');
        }

        for(var i=0; i<dados.length; i++){
          var matricula = dados[i].matricula;
          var nome = dados[i].nome;
          var data_cadastro = dados[i].data_cadastro;
          var ano = data_cadastro.split('-')[0];
          var mes = data_cadastro.split('-')[1];
          var dia = data_cadastro.split('-')[2];
          var titulo = dados[i].titulo;

          $('#contracheques').append('\
            <tr">\
              <td style="vertical-align: middle;">'+matricula+'</td>\
              <td style="vertical-align: middle;">'+nome+'</td>\
              <td style="vertical-align: middle;">'+dia+'/'+mes+'/'+ano+'</td>\
              <td style="vertical-align: middle;"><a href="https://conexao.grupocontem.com.br/assets/contracheques/'+titulo+'" target="_blank"><button type="button" class="btn btn-primary"><i class="lnr lnr-download"></i></button></a>\
              <button type="button" class="btn btn-danger"><i class="lnr lnr-trash"></i></button></td>\
            </tr>');
          }
          $('#filtros').modal('hide');
        }
      });
    });
  }

function remover_cc (matricula, id){
  var x;
  var id_proposta = id;
  //var r=confirm("Tem certeza que deseja remover o contracheque de matrícula: "+matricula);

swal({
  title: "Atenção!",
  text: "Deseja remover o contracheque de matrícula: "+matricula+"?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal("Perfeito", "Contracheque removido com sucesso!", "success", {
      button: "OK",
    });

    jQuery(document).ready(function(){
      var funcao = "remover_cc";
      $('#contracheques').empty();

      $.ajax({
        type:'post',
        dataType: 'json',
        url: 'functions.php',
        data: {'id': id, 'funcao': funcao},
        success: function(dados)
        {
          listar_cc();
        }
      });
    });
    }
  });
}

function buscar_por_nome(){
  jQuery(document).ready(function(){
    $('#contracheques').empty();
    var dados = $('#buscar_nome').serialize();

    $.ajax({
      type:'post',
      dataType: 'json',
      url: 'functions.php',
      data: dados,
      success: function(dados){

        if($.trim(dados) == ''){
          $('#contracheques').append('<tr><td colspan="4"> Nenhum arquivo encontrado! </td></tr>');
          $('#filtros').modal('hide');
        }

        for(var i=0; i<dados.length; i++){
          var id = dados[i].id;
          var matricula = dados[i].matricula;
          var nome = dados[i].nome;
          var data_cadastro = dados[i].data_cadastro;
          var ano = data_cadastro.split('-')[0];
          var mes = data_cadastro.split('-')[1];
          var dia = data_cadastro.split('-')[2];
          var titulo = dados[i].titulo;

          $('#contracheques').append('\
            <tr">\
              <td style="vertical-align: middle;">'+matricula+'</td>\
              <td style="vertical-align: middle;">'+nome+'</td>\
              <td style="vertical-align: middle;">'+dia+'/'+mes+'/'+ano+'</td>\
              <td style="vertical-align: middle;"><a href="https://conexao.grupocontem.com.br/assets/contracheques/'+titulo+'" target="_blank"><button type="button" class="btn btn-primary"><i class="lnr lnr-download"></i></button></a>\
              <button type="button" class="btn btn-danger" onclick="remover_cc(\'' + matricula + '\', '+id+')"><i class="lnr lnr-trash"></i></button></td>\
            </tr>');
          }
          $('#filtros').modal('hide');
        }
      });
    });
}

function buscar_colaborador_nome(){
    $('#listar_col').empty();
    var dados = $('#buscar_nome_colaborador').serialize();

    $.ajax({
      type:'post',
      dataType: 'json',
      url: 'functions.php',
      data: dados,
      success: function(dados){
        if($.trim(dados) == ''){
          $('#listar_col').append('<tr><td colspan="5"> <center>Nenhum colaborador encontrado! </td></tr>');
        }

        for(var i=0; i<dados.length; i++){
          var matricula = dados[i].matricula;
          var foto = dados[i].foto;
          var nome = dados[i].nome;
          var nome_split = nome.split(" ");
          var email = dados[i].email;
          var ramal = dados[i].ramal;
          var nascimento = dados[i].nascimento;
          var setor = dados[i].setor;
          var empresa = dados[i].empresa;

          if (empresa == "contem"){
            var nome_empresa = 'Contém';
          } else if (empresa == "hc"){
            var nome_empresa = 'HC Broker';
          }

          $('#listar_col').append('\
          <tr>\
            <td style="line-height: 5"><a href="#"><img src="assets/img/'+foto+'" width="60" style="border-radius: 70px; margin-right: 10px;"> '+nome+'</a></td>\
            <td style="line-height: 5">'+email+'</td>\
            <td style="line-height: 5">'+ramal+'</td>\
            <td style="line-height: 5">'+setor+'</td>\
          </tr>');
        }
      }
    });
}

function listar_func (){
    $('#func').empty(); //Limpando a tabela
    var funcao = "listar_func";

    $.ajax({
      type:'post', //Definimos o método HTTP usado
      dataType: 'json',	//Definimos o tipo de retorno
      url: 'functions.php',
      data: {'funcao': funcao},
      success: function(dados){
        for(var i=0; i<dados.length; i++){
          var matricula = dados[i].matricula;
          var nome = dados[i].nome;
          var nascimento = dados[i].nascimento;
          var cpf = dados[i].CPF;
          var ano = nascimento.split('-')[0];
          var mes = nascimento.split('-')[1];
          var dia = nascimento.split('-')[2];
          var status = dados[i].status;
          var status_final = null;
          var novo_status = null;

          if(status == 1){
            status_final = 'checked';
            novo_status = 0;
          } else {
            status_final = '';
            novo_status = 1;
          }

          $('#func').append('\
          <tr class="func_teste" style="cursor:pointer" onclick="editar_func_modal(\'' + cpf + '\')">\
            <td style="vertical-align: middle;">'+matricula+'</td>\
            <td style="vertical-align: middle;">'+nome+'</td>\
            <td style="vertical-align: middle;">'+dia+'/'+mes+'/'+ano+'</td>\
            <td style="vertical-align: middle;">\
             <label class="switch">\
              <input type="checkbox" '+status_final+' class="status_check'+matricula+'" onclick="alterar_status(\'' + matricula + '\','+novo_status+')" />\
              <span class="slider round"></span>\
            </label>\
            \
            <label class="switch" style="display: none;">\
              <input type="checkbox" '+status_final+' class="status_check'+matricula+'"  onclick="alterar_status(\'' + matricula + '\','+status+')" />\
            <span class="slider round"></span>\
            </label>\
          </td>\
        </tr>');

      }
    }
  });
}

function editar_func_modal(cpf){
  $('#func_editar').modal('show');
  var funcao = 'puxar_dados_colaborador';

  $.ajax({
    type:'post', //Definimos o método HTTP usado
    dataType: 'json',	//Definimos o tipo de retorno
    url: 'functions.php',
    data: {'funcao': funcao, 'cpf':cpf},
    success: function(dados){
      for(var i=0; i<dados.length; i++){
        var matricula = dados[i].matricula;
        var nome = dados[i].nome;
        var nascimento = dados[i].nascimento;
        var cpf = dados[i].CPF;
        var email = dados[i].email;
        var cargo_atual = dados[i].cargo_atual;
        var setor = dados[i].setor;
        var sexo = dados[i].sexo;
        var cpf_final = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");

        $('#cpf_editar').val(cpf_final);
        $('#nome_editar').val(nome);
        $('#nascimento_editar').val(nascimento);
        $('#matricula_editar').val(matricula);
        $('#email_editar').val(email);
        $('#cargo_atual_editar').val(cargo_atual);
        $('#setor_editar').val(setor);
        $('#sexo_editar').val(sexo);
    }
  }
});
}

function anexar_cc(indice){
  jQuery(document).ready(function(){
    var myForm = document.getElementById('anexar_cc'+indice);
    formData = new FormData(myForm);

    $.ajax({
      type:'post',
      dataType: 'json',
      url: 'functions.php',
      async: true,
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function()
			{
			  $("#enviarmsg"+indice).css("display", "none");
        $("#spin"+indice).css("display", "block");
			},
      success: function(result){
        if($.trim(result) == 'success'){
          $("#enviado"+indice).css("display", "block");
          $("#spin"+indice).css("display", "none");

          $("#btn-enviar"+indice).addClass("btn-success");
          $(".enviar"+indice).prop("disabled", true);

        } else if($.trim(result) == 'vazio'){
          $("#erro"+indice).css("display", "block");
          $("#spin"+indice).css("display", "none");

          $("#btn-enviar"+indice).removeClass("btn-primary");
          $("#btn-enviar"+indice).addClass("btn-danger");
          $(".enviar"+indice).prop("disabled", true);

          toast_msg('error', 'Nenhum arquivo selecionado!');

          setTimeout(function(){
            $("#erro"+indice).css("display", "none");
            $("#enviarmsg"+indice).css("display", "block");

            $("#btn-enviar"+indice).removeClass("btn-danger");
            $("#btn-enviar"+indice).addClass("btn-primary");
            $(".enviar"+indice).prop("disabled", false);
          }, 4000);
        } else if($.trim(result) == 'naopdf'){
          $("#erro"+indice).css("display", "block");
          $("#spin"+indice).css("display", "none");

          $("#btn-enviar"+indice).removeClass("btn-primary");
          $("#btn-enviar"+indice).addClass("btn-danger");
          $(".enviar"+indice).prop("disabled", true);

          toast_msg ('error','O formato do arquivo deve ser .pdf!');

          setTimeout(function(){
            $("#erro"+indice).css("display", "none");
            $("#enviarmsg"+indice).css("display", "block");

            $("#btn-enviar"+indice).removeClass("btn-danger");
            $("#btn-enviar"+indice).addClass("btn-primary");
            $(".enviar"+indice).prop("disabled", false);
          }, 4000);
        }
      },
    });
  });
}

function alterar_status (matricula, novo_status){
  jQuery(document).ready(function(){

    console.log(matricula, novo_status);
    var funcao = "altera_status";

    $.ajax({
      type:'post',
      dataType: 'json',
      url: 'functions.php',
      data: {'matricula': matricula, 'funcao': funcao, 'novo_status': novo_status},
      success: function(dados)
      {
        toast_msg ('success','Alterado com sucesso!');
        $('.status_check'+matricula).removeAttr("onclick");
        $('.status_check'+matricula).attr("checked");
        listar_func();
      }
    });
  });
}

function toast_msg (type, message){

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
	toastr[type](message);
}

function validar_cpf (){
  jQuery(document).ready(function(){
    var cpf = $('#cpf').val();
    var funcao = 'validar_cpf';
    $.ajax({
      type:'post',
      dataType: 'json',
      url: 'functions.php',
      data: {'funcao': funcao, 'cpf':cpf},
      success: function(result){
        if($.trim(result) == 'cpf-existe'){
          $('.error0').removeClass("has-success");
          $('.error0').addClass("has-error");
          $('#button_cadastrar_func').prop('disabled',true);
          $('#erro-label').css("display", "block");
        } else {
          $('#button_cadastrar_func').prop('disabled',false);
          $('.error0').addClass("has-success");
          $('.error0').removeClass("has-error");
          $('#erro-label').css("display", "none");
        }
      }
    });
  });
}

function cadastrar_func (){
  jQuery(document).ready(function(){
    var dados = $('#cad_func').serialize();

    $.ajax({
      type:'post',
      dataType: 'json',
      url: 'functions.php',
      data: dados,
      success: function(dados){
        if($.trim(dados) == 'cpf-invalid'){

        } else if($.trim(dados) == 'nome-invalid'){
          swal("Opa!", "Digite o nome completo do funcionário!", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'nascimento-invalid'){
          swal("Opa!", "Informe a data de nascimento do funcionário", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'matricula-invalid'){
          swal("Opa!", "Informe a matrícula do funcionário", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'matricula-existe'){
          swal("Opa!", "A matrícula digitada já está cadastrada!", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'email-invalid'){
          swal("Opa!", "Por favor informe o email do funcionário!", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'email-existe'){
          swal("Opa!", "O email digitado já está cadastrado!", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'cargo-invalid'){
          swal("Opa!", "Informe o cargo do funcionário!", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'setor-invalid'){
          swal("Opa!", "Informe o setor do funcionário!", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'sexo-invalid'){
          swal("Opa!", "Informe o sexo do funcionário!", "error", {
            button: "OK",
          });
        } else {
          listar_func();
          $('#exampleModal').modal('hide');
          swal("Perfeito", "O funcionário foi cadastrado com sucesso!", "success", {
            button: "OK",
          });
        }
      }
    });
  });
}

function editar_func (){
  jQuery(document).ready(function(){
    var dados = $('#editar_func').serialize();
    console.log(dados);

    $.ajax({
      type:'post',
      dataType: 'json',
      url: 'functions.php',
      data: dados,
      success: function(dados){

        if($.trim(dados) == 'nome-invalid'){
          swal("Opa!", "Digite o nome completo do funcionário!", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'nascimento-invalid'){
          swal("Opa!", "Informe a data de nascimento do funcionário", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'cargo-invalid'){
          swal("Opa!", "Informe o cargo do funcionário!", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'setor-invalid'){
          swal("Opa!", "Informe o setor do funcionário!", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'sexo-invalid'){
          swal("Opa!", "Informe o sexo do funcionário!", "error", {
            button: "OK",
          });
        } else if($.trim(dados) == 'editado') {
          listar_func();
          $('#func_editar').modal('hide');
          swal("Perfeito", "O funcionário foi editado com sucesso!", "success", {
            button: "OK",
          });
        }
      }
    });
  });
}

function enviar_parabens (){
  var dados = $('#parabens').serialize();
  var coment = $('#comentario').val();

  if(coment == ""){
    swal("Opa!", "Você não digitou nada!", {
      icon: "error",
    });
  } else {
    $.ajax({
      type:'post',
      dataType: 'json',
      url: 'functions.php',
      data: dados,
      success: function(dados){
        if($.trim(dados) == "inserido"){
          //$('.postar_comentario').empty();
          //listar_msg_parabens();

          $('#scroll').append('\
            <li class="msgs_parabens" style="margin-left: 15px;">\
              <img src="assets/img/'+foto_user+'" alt="Avatar" class="img-circle pull-left avatar">\
              <p><a href="#">'+nome_user+'</a> comentou: '+coment+'<span class="timestamp">Agora</span></p>\
            </li>');

          $('#comentario').val("");
          var log = $('.tab-content');
          log.animate({ scrollTop: log.prop('scrollHeight')}, 1);
          console.log(count);
        }
      }
    });
  }
}

function listar_mensagens_parabens (){
  var funcao = 'listar_mensagens_parabens';
  $('#scroll').empty();
  var count = 0;

  $.ajax({
    type:'post',
    dataType: 'json',
    url: 'functions.php',
    data: {'funcao': funcao},
    success: function(dados){
      for(var i=0; i<=dados.length; i++){
        var nome = dados[i].nome;
        var foto = dados[i].foto;
        var comentario = dados[i].comentario;
        var data = dados[i].data;
        var nome_split = nome.split(" ");
        var data_split = data.split(" ");
        var hora = data_split[1];
        var hora_split = hora.split(":");

        var hour = hora_split[0];
        var minute = hora_split[1];
        var second = hora_split[2];

        var hora_atual = new Date();
        var hora_atual_hour = hora_atual.getHours();
        var hora_atual_minute = hora_atual.getMinutes();
        var hora_atual_second = hora_atual.getSeconds();

        var diferenca_hora = hora_atual_hour-hour;
        var diferenca_minutos = hora_atual_minute - minute;

        const now = new Date(); // Data de hoje
        const past = new Date(data); // Outra data no passado
        const diff = Math.abs(now.getTime() - past.getTime()); // Subtrai uma data pela outra
        const days = Math.ceil(diff / (1000 * 60 * 60 * 24) -1);


        if (days == 0 && diferenca_hora == 0){
          resultado_tempo = 'Menos de uma hora atrás';
        } else if (days == 0 && diferenca_hora > 0){
          for(x=1; x<60;x++){
            switch(diferenca_hora) {
              case x:
                resultado_tempo = x+' hora atrás';
            }
          }
        } else if (days > 0 && days < 7){
          for(x=1; x<31;x++){
            switch(days) {
              case x:
                resultado_tempo = x+' dias atrás';
            }
          }
        } else if (days >= 7 && days <= 31){
          for(x=1; x<=31;x++){
            switch(days) {
              case x:
                resultado_tempo = x+' dias atrás';
            }
          }
        } else if (days >= 30 && days < 60){
          resultado_tempo = '1 mês atrás';
        } else if (days >= 60 && days < 90){
          resultado_tempo = '2 mêses atrás';
        } else if (days >= 90 && days < 120){
          resultado_tempo = '3 mêses atrás';
        } else if (days >= 120 && days < 150){
          resultado_tempo = '4 mêses atrás';
        } else if (days >= 150 && days < 180){
          resultado_tempo = '5 mêses atrás';
        } else if (days >= 180 && days < 210){
          resultado_tempo = '6 mêses atrás';
        } else if (days >= 210 && days < 240){
          resultado_tempo = '7 mêses atrás';
        } else if (days >= 240 && days < 270){
          resultado_tempo = '8 mêses atrás';
        } else if (days >= 270 && days < 300){
          resultado_tempo = '9 mêses atrás';
        } else if (days >= 300 && days < 330){
          resultado_tempo = '10 mêses atrás';
        } else if (days >= 330 && days < 365){
          resultado_tempo = '11 mêses atrás';
        } else if (days > 365){
          resultado_tempo = '1 ano atrás';
        }

        //console.log('diferenca'+diferenca_hora);

        $('.slimScrollBar').css("top", "10000px");

        $('#scroll').append('\
          <li class="msgs_parabens" style="margin-left: 15px;">\
            <img src="assets/img/'+foto+'" alt="Avatar" class="img-circle pull-left avatar">\
            <p><a href="#">'+nome_split[0]+' '+nome_split[1]+'</a> comentou: '+comentario+'<span class="timestamp" >'+resultado_tempo+'</span></p>\
          </li>');
        }
        var log = $('.tab-content');
        log.animate({ scrollTop: log.prop('scrollHeight')}, 1);
      }
  });
}

function atualizar_parabens(){
	setTimeout(function()
  {
		atualizar_parabens();
    var count3 = $('.msgs_parabens').length;
    att_parabens(count3);
  }, 1000);
}

function att_parabens (qtd_parabens){
  var funcao = 'att_parabens';
  var qtd_msg = qtd_parabens;
  console.log(qtd_msg);

  $.ajax({
    type:'post',
    dataType: 'json',
    url: 'functions.php',
    data: {'funcao': funcao, 'qtd': qtd_msg},
    success: function(dados){
      for(var i=0; i<dados.length; i++){
        var nome = dados[i].nome;
        var foto = dados[i].foto;
        var comentario = dados[i].comentario;
        var data = dados[i].data;
        var nome_split = nome.split(" ");
        var setor = dados[i].setor;

        $('#scroll').append('\
          <li class="msgs_parabens" style="margin-left: 15px;">\
            <img src="assets/img/'+foto+'" alt="Avatar" class="img-circle pull-left avatar">\
            <p><a href="#">'+nome_split[0]+' '+nome_split[1]+'</a> comentou: '+comentario+'<span class="timestamp" style="display: none;">20 minutes ago</span></p>\
          </li>');
        }
        var log = $('.tab-content');
        log.animate({ scrollTop: log.prop('scrollHeight')}, 1);
    }
  });
}

function enviar_mensagem (){
  var dados = $('#mensagem_form').serialize();
  var coment = $('#comentario').val();

  if(coment == ""){
    swal("Opa!", "Você não digitou nada!", { icon: "error",});
  } else {
    $.ajax({
      type:'post',
      dataType: 'json',
      url: 'functions.php',
      data: dados,
      success: function(dados){
        if($.trim(dados) == "inserido"){
          //$('.postar_comentario').empty();
          //listar_msg_parabens();

          var log2 = $('.tab-content');
          log2.animate({ scrollTop: log2.prop('scrollHeight')}, 1);

          $('#scroll').append('\
          <li class="teste">\
            <img src="assets/img/'+foto_user+'" alt="Avatar" class="img-circle pull-left avatar">\
            <p><a href="#">'+nome_user+'</a> comentou: '+coment+'<span class="timestamp">Agora</span></p>\
          </li>');

          $('#comentario').val("");
        }
      }
    });
  }
}

function listar_mensagens (){
  var funcao = 'listar_mensagens';
  $('#scroll').empty();
  var count = 0;

  $.ajax({
    type:'post',
    dataType: 'json',
    url: 'functions.php',
    data: {'funcao': funcao},
    success: function(dados){
      for(var i=0; i<dados.length; i++){
        var nome = dados[i].nome;
        var foto = dados[i].foto;
        var mensagem = dados[i].mensagem;
        var data = dados[i].data;
        var nome_split = nome.split(" ");
        var setor = dados[i].setor;

        var data_split = data.split(" ");
        var hora = data_split[1];
        var hora_split = hora.split(":");

        var hour = hora_split[0];
        var minute = hora_split[1];
        var second = hora_split[2];

        var hora_atual = new Date();
        var hora_atual_hour = hora_atual.getHours();
        var hora_atual_minute = hora_atual.getMinutes();
        var hora_atual_second = hora_atual.getSeconds();

        var diferenca_hora = hora_atual_hour-hour;
        var diferenca_minutos = hora_atual_minute - minute;

        const now = new Date(); // Data de hoje
        const past = new Date(data); // Outra data no passado
        const diff = Math.abs(now.getTime() - past.getTime()); // Subtrai uma data pela outra
        const days = Math.ceil(diff / (1000 * 60 * 60 * 24) -1);


        if (days == 0 && diferenca_hora == 0){
          resultado_tempo = 'Menos de uma hora atrás';
        } else if (days == 0 && diferenca_hora > 0){
          for(x=1; x<60;x++){
            switch(diferenca_hora) {
              case x:
                resultado_tempo = x+' hora atrás';
            }
          }
        } else if (days > 0 && days < 7){
          for(x=1; x<31;x++){
            switch(days) {
              case x:
                resultado_tempo = x+' dias atrás';
            }
          }
        } else if (days >= 7 && days <= 31){
          for(x=1; x<=31;x++){
            switch(days) {
              case x:
                resultado_tempo = x+' dias atrás';
            }
          }
        } else if (days >= 30 && days < 60){
          resultado_tempo = '1 mês atrás';
        } else if (days >= 60 && days < 90){
          resultado_tempo = '2 mêses atrás';
        } else if (days >= 90 && days < 120){
          resultado_tempo = '3 mêses atrás';
        } else if (days >= 120 && days < 150){
          resultado_tempo = '4 mêses atrás';
        } else if (days >= 150 && days < 180){
          resultado_tempo = '5 mêses atrás';
        } else if (days >= 180 && days < 210){
          resultado_tempo = '6 mêses atrás';
        } else if (days >= 210 && days < 240){
          resultado_tempo = '7 mêses atrás';
        } else if (days >= 240 && days < 270){
          resultado_tempo = '8 mêses atrás';
        } else if (days >= 270 && days < 300){
          resultado_tempo = '9 mêses atrás';
        } else if (days >= 300 && days < 330){
          resultado_tempo = '10 mêses atrás';
        } else if (days >= 330 && days < 365){
          resultado_tempo = '11 mêses atrás';
        } else if (days > 365){
          resultado_tempo = '1 ano atrás';
        }


        $('#scroll').append('\
          <li class="teste">\
            <img src="assets/img/'+foto+'" alt="Avatar" class="img-circle pull-left avatar">\
            <p><a href="#">'+nome_split[0]+' '+nome_split[1]+'</a> comentou: '+mensagem+'<span class="timestamp">'+resultado_tempo+'</span></p>\
          </li>');
          count++;
        }
        var log = $('.tab-content');
        log.animate({ scrollTop: log.prop('scrollHeight')}, 1);
        console.log(count);
      }
  });
}

function att_mensagens (qtd_mensagens){
  var funcao = 'att_mensagens';
  var qtd_msg = qtd_mensagens;
  console.log(qtd_msg);

  $.ajax({
    type:'post',
    dataType: 'json',
    url: 'functions.php',
    data: {'funcao': funcao, 'qtd': qtd_msg},
    success: function(dados){
      for(var i=0; i<dados.length; i++){
        var nome = dados[i].nome;
        var foto = dados[i].foto;
        var mensagem = dados[i].mensagem;
        var data = dados[i].data;
        var nome_split = nome.split(" ");
        var setor = dados[i].setor;

        $('#scroll').append('\
          <li class="teste">\
            <img src="assets/img/'+foto+'" alt="Avatar" class="img-circle pull-left avatar">\
            <p><a href="#">'+nome_split[0]+' '+nome_split[1]+'</a> comentou: '+mensagem+'<span class="timestamp" style="display: none;">20 minutes ago</span></p>\
          </li>');
        }
        var log = $('.tab-content');
        log.animate({ scrollTop: log.prop('scrollHeight')}, 1);
        //console.log(count);
      }
  });
}

function atualizar_msg(){
	setTimeout(function()
  {
		atualizar_msg();
    var count2 = $('.teste').length;
    att_mensagens(count2);
  }, 1000);
}

function parabens (){
    var limite_caracteres = 100;
    var comentario = $('#comentario').val();
    var qtd_caracteres = comentario.length;
    var qtd_caracter_atual = limite_caracteres - qtd_caracteres;
    $('#caracteres').html(qtd_caracter_atual);
}

function contar_caracteres (){
    var limite_caracteres = 100;
    var comentario = $('#comentario').val();
    var qtd_caracteres = comentario.length;
    var qtd_caracter_atual = limite_caracteres - qtd_caracteres;
    $('#caracteres').html(qtd_caracter_atual);
}

function listar_dados_meta (local){
  var funcao = 'listar_dados_meta';

  $.ajax({
    type:'post',
    dataType: 'json',
    url: 'functions.php',
    data: {'funcao': funcao},
    success: function(dados){
      for(var i=0; i<dados.length; i++){
        var val_meta = dados[i].meta;
        var val_alcancado = dados[i].valor_alcancado;

        var meta_split = val_meta.split("");
        var valor_alcancado_split = val_alcancado.split("");

        if(meta_split.length == 3){
          meta_final = meta_split[0]+','+meta_split[1]+meta_split[2];
        } else if(meta_split.length == 4){
          meta_final = meta_split[0]+meta_split[1]+','+meta_split[2]+meta_split[3];
        } else if(meta_split.length == 5){
          meta_final = meta_split[0]+meta_split[1]+meta_split[2]+','+meta_split[3]+meta_split[4];
        } else if(meta_split.length == 6){
          meta_final = meta_split[0]+'.'+meta_split[1]+meta_split[2]+meta_split[3]+','+meta_split[4]+meta_split[5];
        } else if(meta_split.length == 7){
          meta_final = meta_split[0]+meta_split[1]+'.'+meta_split[2]+meta_split[3]+meta_split[4]+','+meta_split[5]+meta_split[6];
        } else if(meta_split.length == 8){
          meta_final = meta_split[0]+meta_split[1]+meta_split[2]+'.'+meta_split[3]+meta_split[4]+meta_split[5]+','+meta_split[6]+meta_split[7];
        }

        if(valor_alcancado_split.length == 3){
          valor_alcancado_split = valor_alcancado_split[0]+','+valor_alcancado_split[1]+valor_alcancado_split[2];
        } else if(valor_alcancado_split.length == 4){
          valor_alcancado_split = valor_alcancado_split[0]+valor_alcancado_split[1]+','+valor_alcancado_split[2]+valor_alcancado_split[3];
        } else if(valor_alcancado_split.length == 5){
          valor_alcancado_split = valor_alcancado_split[0]+valor_alcancado_split[1]+valor_alcancado_split[2]+','+valor_alcancado_split[3]+valor_alcancado_split[4];
        } else if(valor_alcancado_split.length == 6){
          valor_alcancado_split = valor_alcancado_split[0]+'.'+valor_alcancado_split[1]+valor_alcancado_split[2]+valor_alcancado_split[3]+','+valor_alcancado_split[4]+valor_alcancado_split[5];
        } else if(valor_alcancado_split.length == 7){valor_alcancado_split
          valor_alcancado_split = valor_alcancado_split[0]+valor_alcancado_split[1]+'.'+valor_alcancado_split[2]+valor_alcancado_split[3]+valor_alcancado_split[4]+','+valor_alcancado_split[5]+valor_alcancado_split[6];
        } else if(valor_alcancado_split.length == 8){
          valor_alcancado_split = valor_alcancado_split[0]+valor_alcancado_split[1]+valor_alcancado_split[2]+'.'+valor_alcancado_split[3]+valor_alcancado_split[4]+valor_alcancado_split[5]+','+valor_alcancado_split[6]+valor_alcancado_split[7];
        }

        var percent = (val_alcancado / val_meta) * 100;

        $('#meta').val(meta_final);
        $('#meta_alcancada').val(valor_alcancado_split);
        $('#barra_meta').width(percent+'%');
        $('#barra_meta').html(percent.toFixed(0)+'%');
      }
    }
  });
}

function listar_metas_home (){
  var funcao = 'listar_metas_home';

  $.ajax({
    type:'post',
    dataType: 'json',
    url: 'functions.php',
    data: {'funcao': funcao},
    success: function(dados){
      for(var i=0; i<dados.length; i++){
        var setor = dados[i].nome_setor;
        var val_meta = dados[i].meta;
        var valor_alcancado = dados[i].valor_alcancado;

        var val_meta = val_meta.replace('.','');
        var val_meta = val_meta.replace(',','');

        var valor_alcancado = valor_alcancado.replace('.','');
        var valor_alcancado = valor_alcancado.replace(',','');

        var percent = (valor_alcancado / val_meta) * 100;

        var cores = ['danger', 'success', 'warning', 'primary'];

      $('#metas_ul').append('<li>\
        <p>'+setor+' <span class="label-percent">'+percent.toFixed(0)+'%</span></p>\
        <div class="progress progress-xs">\
          <div class="progress-bar progress-bar-'+cores[i]+'" role="progressbar" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100" style="width:'+percent+'%">\
            <span class="sr-only">23% Complete</span>\
          </div>\
        </div>\
      </li>');
      }
    }
  });
}

function att_percent_meta() {
  var val_meta = $('#meta').val();
  var val_alcancado = $('#meta_alcancada').val();

  var val_meta = val_meta.replace('.','');
  var val_meta = val_meta.replace(',','');

  var val_alcancado = val_alcancado.replace('.','');
  var val_alcancado = val_alcancado.replace(',','');

  var percent = (val_alcancado / val_meta) * 100;
  $('#barra_meta').width(percent+'%');
  $('#barra_meta').html(percent.toFixed(0)+'%');
}

function alterar_meta (){
  var dados = $('#dados_meta').serialize();

  $.ajax({
    type:'post',
    dataType: 'json',
    url: 'functions.php',
    data: dados,
    success: function(dados){
      swal("Perfeito", "Dados alterados com sucesso!", "success", {
        button: "OK",
      });
    }
  });
}

/*function listar_msg_parabens (){
  var funcao = 'listar_msg_parabens';
  $('.postar_comentario').empty();

  $.ajax({
    type:'post',
    dataType: 'json',
    url: 'functions.php',
    data: {'funcao': funcao},
    success: function(dados){
      for(var i=0; i<dados.length; i++){
        var nome = dados[i].nome;
        var foto = dados[i].foto;
        var comentario = dados[i].comentario;
        var data = dados[i].data;
        var nome_split = nome.split(" ");

        $('.slimScrollBar').css("top", "10000px");

        $('.postar_comentario').append('\
          <li>\
            <img src="assets/img/'+foto+'" alt="Avatar" class="img-circle pull-left avatar">\
            <p><a href="#">'+nome_split[0]+' '+nome_split[1]+'</a> comentou: '+comentario+'<span class="timestamp" style="display: none;">20 minutes ago</span></p>\
          </li>');
        }
    }
  });
}*/
