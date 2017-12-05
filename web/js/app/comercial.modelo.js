Projeto.prototype.modelo = new (Projeto.extend({
    init: function () {
        this.imprimirContrato();
    },
    imprimirContrato: function () {
        $('#botaoSalvarModelo').click(function ( ) {

            var cod_contrato = $('#tabmodelocontratosearch-cod_contrato_fk').val();
            var html_contrato = tinymce.activeEditor.getContent();
            var selecao = {cod_contrato: cod_contrato, html_contrato: html_contrato};
            var urlInclusao = $('base').attr('href') + 'comercial/contrato/imprimir-contrato';
            projeto.ajax.post(urlInclusao, selecao, function (response) {

               
                $('#modalModelo').modal('hide');

            });
            
             var urlInclusao = $('base').attr('href') + 'comercial/contrato/impressao?cod_contrato='+$('#tabmodelocontratosearch-cod_contrato_fk').val();
                
                window.open(urlInclusao);


            return false;
        });

    },

}));
//
//
//function abrirImpressao(contrato) {
//
//    var url = $('base').attr('href') + 'comercial/contrato/imprimir-contrato?id=' + contrato;
//    $('#tabmodelocontratosearch-txt_modelo').val(url);
//
//    $('#modalModelo').modal('show').find('#modalContent').load( );
//    return false;
//}
function abrirImpressao(cod_contrato) {

    var urlInclusao = $('base').attr('href') + 'comercial/contrato/abrir-impressao';
    var selecao = {cod_contrato: cod_contrato};

    $('#tabmodelocontratosearch-cod_contrato_fk').val('');

    projeto.ajax.post(urlInclusao, selecao, function (response) {
//
        var dados = $.parseJSON(response);

        tinymce.activeEditor.setContent(dados);
       $('#tabmodelocontratosearch-cod_contrato_fk').val(cod_contrato);
        $('#modalModelo').modal('show').find('#modalContent').load( );

    });

    return false;

}
;


