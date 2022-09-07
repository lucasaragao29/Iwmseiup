
//Tratando os Selects
$('#regiao').select2({ width: '100%', language: 'pt-BR'});
$('#distrito').select2({ width: '100%', language: 'pt-BR'});
$('#igreja').select2({ width: '100%', language: 'pt-BR'});
$('#categoria').select2({ width: '100%', language: 'pt-BR'});
$('#subcategoria').select2({ width: '100%', language: 'pt-BR'});

//Props default Select2
$("#distrito").prop("disabled", true);
$("#igreja").prop("disabled", true);
$("#subcategoria").prop("disabled", true);

$('#regiao').change(function(){
        $("#igreja").prop("disabled", true);
        $('#distrito').empty();
        $('#igreja').empty();
        let regiao = $("#regiao option:selected").val();
        regiao == '' ?  '' : swal("Aguarde ...", {icon: "info", buttons: false});
        regiao == '' ? $("#distrito").prop("disabled", true) : $("#distrito").prop("disabled", false);
        $('#distrito').append("<option value=''> Selecione o distrito </option>");
               $.getJSON(`busca_distrito.php/?id_categoria=${regiao}`, function(data){	
                        for (var i = 0; i < data.length; i++) {
                                $('#distrito').append("<option value='" + (data[i].id) + "'>" + (data[i].nome) + "</option>");
                            }	
                    swal.close();
                });
      
    });


$('#distrito').change(function(){
    $("#igreja").prop("disabled", false);
    $('#igreja').empty();
    
    let distrito = $("#distrito option:selected").val();
    distrito == '' ?  '' : swal("Aguarde ...", {icon: "info", buttons: false});
    $('#igreja').append("<option value=''> Selecione a igreja </option>");
           $.getJSON(`busca_igreja.php/?id_categoria=${distrito}`, function(data){	
                for (var i = 0; i < data.length; i++) {
                    $('#igreja').append("<option value='" + (data[i].id) + "'>" + (data[i].nome) + "</option>");
                }	
                swal.close();
            });
});

$('#categoria').change(function(){
    $("#subcategoria").empty();
    $("#subcategoria").prop("disabled", false);
    let categoria = $("#categoria option:selected").val();
    categoria == '' ?  '' : swal("Aguarde ...", {icon: "info", buttons: false});
    $('#subcategoria').append("<option value=''> Selecione a subcategoria </option>");
           $.getJSON(`busca_subcategoria.php/?id_subcategoria=${categoria}`, function(data){	
                for (var i = 0; i < data.length; i++) {
                    $('#subcategoria').append("<option value='" + (data[i].id) + "'>" + (data[i].nome) + "</option>");
                }	
                swal.close();
            });
});

$('#formSearch').submit(function(data){
    event.preventDefault(); 
    let id_regiao = $("#regiao option:selected").val();
    let id_distrito = $("#distrito option:selected").val();
    let id_igreja = $("#igreja option:selected").val();
    let id_categoria = $("#categoria option:selected").val();
    let id_subcategoria = $("#subcategoria option:selected").val();
    
    swal("Pesquisando Aguarde...", {
        icon: "info",
        buttons: false,
        
      });

    $.ajax({
        type:'POST',
        url:'busca_arquivos.php',
        data: {
            id_regiao, id_distrito, id_igreja, id_categoria, id_subcategoria
        }
        ,success:function(data){
            swal.close();
            exibirReg(data);
        }
      });
});


$("#formulario").submit(function(event){
    event.preventDefault(); 
    var frm = new FormData();
    //CAMPOS
    let regiao = $("#regiao option:selected").val();
    let distrito = $("#distrito option:selected").val();
    let igreja = $("#igreja option:selected").val();
    let categoria = $("#categoria option:selected").val();
    let subcategoria = $("#subcategoria option:selected").val();
    let titulo = $("#titulo").val();
    let descricao = $("#descricao").val();
    var file_data = $("#arquivo").prop("files"); 
    frm.append('regiao',"Teste");
    // frm.append('distrito', distrito);
    // frm.append('igreja', igreja);
    // frm.append('categoria', categoria);
    // frm.append('subcategoria', subcategoria);
    // frm.append('titulo', titulo);
    // frm.append('descricao', descricao);

    //Alteração para upload multipo com array- 
    // frm.append("arquivo", file_data);
    
    // for(let i= 0;i<file_data.length;i++){
    //     const arquivoNome = `arquivo${i}`
    //     frm.append(arquivoNome, file_data[i]);
    // }
    //console.log(file_data);
 /*    $("#salvar").prop("disabled", true);
    swal("Realizando upload ...", {
        icon: "info",
        buttons: false,
        
      }); */
    $.ajax({
        type:'POST',
        enctype: 'multipart/form-data',
        url:'upload.php',
        data: frm,
        processData: false,
        contentType: false,
        cache: false,
        success:function(data){
            console.log({data});

            if(!data.length) return
            const resposta = jQuery.parseJSON(data);
            if(resposta.falhou) {
            swal({
                title: "Falhou!",
                text: resposta.falhou,
                icon: "error"
              });
           } else {
                swal({
                    title: "Sucesso!",
                    text: "Seu arquivo foi salvo com sucesso!",
                    icon: "success"
                });
                limpaCampos(); 
           }   
        }
      });
});

function limpaCampos() {
  
              $("#salvar").prop("disabled", false);
              $("#distrito").prop("disabled", true);
              $("#subcategoria").prop("disabled", true);
              $("#igreja").prop("disabled", true);
              $('#igreja').empty();
              $('#subcategoria').empty();
              $('#titulo').val('');
              $('#descricao').val('');
              $('#arquivo').empty();
              $('#regiao').val('');
              $('#regiao').select2().trigger('change');
              $('#categoria').val('');
              $('#categoria').select2().trigger('change');
              $('#distrito').empty();  $('#distrito').empty();
}


function exibirReg(data) {
    $("#result-search").hide();
    data = JSON.parse(data);
    if(data == null) {
        swal({
            title: "Ops",
            text: "Nenhum arquivo encontrado!",
            icon: "warning",
            dangerMode: true,
          });
      return;
    } 
    $("#result-search").show();
    $("#tbPesquisar tbody tr td").remove();
    for (var i = 0; i < data.length; i++) {
        let arrArq = data[i].nome.split('.');
        let extensao = arrArq[arrArq.length -1];

        $('#tbPesquisar').find('tbody').append("<tr id='linha-"+ data[i].id +"' ><td>" + data[i].titulo + "</td><td>" + extensao + "</td><td>" + data[i].distrito + "</td><td>" + data[i].igreja + "</td><td>" + data[i].descricao + "</td><td class='align-center'><a href='docs/" + data[i].nome + "' class='download'> <i class='fa fa-download'></i> </a> <a href='#' onclick='deleteArq("+ data[i].id + ")' class='delete'> <i class='fa fa-trash'></i> </a></td></tr>");
    }	

}

function deleteArq(id) {
   event.preventDefault();
   $.get("deletar_arquivos.php?arq="+id, function(data){
       //let d = JSON.parse(data);
       data == null;
       console.log(d.msg);
       if(d.msg == 'sucesso') {
        swal("Arquivo deletado com sucesso!");
        $(`#linha-${id}`).fadeOut();
        $(`#linha-${id}`).remove();
       }
   });
} 

//Regras de acesso 
const permissions = (params) => {
  
   switch (params.nivel) {
        case '3':
            nivel3();
            break;
         case '4':
           nivel4();
         break;
         case '5':
           nivel5(params);
            break;
         case '6':
            nivel6(params);
         break;
         case '7':
            nivel7(params);
            break;
         case '8':
            nivel8(params);
         break;
        default:
           niveldefault(params);
        break;
   }
   
}


//SECRETARIA GERAL DE FINANCIAS
const nivel3 = () => {
    /*  
      params.id;
      params.login;
      params.nivel;
      params.distrito;
      params.regiao; 
  */
    //Troca para Financias
    $("#categoria").prop("disabled", true);
    $("#categoria").val(1).change();
    
}

//SECRETARIA GERAL DE ADMINISTRAÇÂO
const nivel4 = () => {
    /*  
      params.id;
      params.login;
      params.nivel;
      params.distrito;
      params.regiao; 
  */
    //Troca para Administração
    $("#categoria").prop("disabled", true);
    $("#categoria").val(2).change();
    
}

//SECRETARIO REGIONAL ADMINISTRAÇÃO
const nivel5 = (params) => {
    /*  
      params.id;
      params.login;
      params.nivel;
      params.distrito;
      params.regiao; 
  */
     //Desabilita todos exceto sua regiao
     $("#regiao").prop("disabled", true);
     $("#regiao").val(params.regiao).change();

    //Troca para Administração
    $("#categoria").prop("disabled", true);
    $("#categoria").val(2).change();
    
}


//SECRETARIO REGIONAL DE FINANCAS
const nivel6 = (params) => {
    /*  
      params.id;
      params.login;
      params.nivel;
      params.distrito;
      params.regiao; 
  */
    //Desabilita todos exceto sua regiao
    $("#regiao").prop("disabled", true);
    $("#regiao").val(params.regiao).change();

    //Troca para Financeiro
    $("#categoria").prop("disabled", true);
    $("#categoria").val(1).change();
}

//BISPO REGIONAL
const nivel7 = (params) => {
    /*  
      params.id;
      params.login;
      params.nivel;
      params.distrito;
      params.regiao; 
  */
    //Desabilita todos exceto sua regiao
    $("#regiao").prop("disabled", true);
    $("#regiao").val(params.regiao).change();
}

//SUPERINTENDENTE DISTRITAL
const nivel8 = (params) => {
    /*  
      params.id;
      params.login;
      params.nivel;
      params.distrito;
      params.regiao; 
  */
    //Desabilita todos exceto sua regiao
    $("#regiao").prop("disabled", true);
    $("#regiao").val(params.regiao).change();

}

const niveldefault = (params) => {
    $("#btnsearchFiles").hide();
}