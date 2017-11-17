Projeto.prototype.modelo = new (Projeto.extend({
    init: function () {
 CKEDITOR.config.extraPlugins = 'justify';
    },

}));
//
//
//function abrirImpressao(contrato) {
//
//    var url = $('base').attr('href') + 'comercial/contrato/imprimir-contrato?id=' + contrato;
//    $('#tabmodelocontrato-txt_modelo').val(url);
//
//    $('#modalModelo').modal('show').find('#modalContent').load( );
//    return false;
//}
function abrirImpressao(cod_contrato) {

    var urlInclusao = $('base').attr('href') + 'comercial/contrato/imprimir-contrato';
    var selecao = {cod_contrato: cod_contrato};
    projeto.ajax.post(urlInclusao, selecao, function (response) {
        
        var dados = $.parseJSON(response);
    CKEDITOR.instances['tabmodelocontrato-txt_modelo'].setData(dados);
        

        $('#modalModelo').modal('show').find('#modalContent').load( );

    });

    return false;

}
;

//function abrirImpressao(contrato) {
//
//    
//    var url = $('base').attr('href') + 'comercial/contrato/imprimir-contrato?id=' + contrato;
//    window.open(url);
//
//    return false;
//}

