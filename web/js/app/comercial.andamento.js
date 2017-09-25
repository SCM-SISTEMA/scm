Projeto.prototype.andamento = new (Projeto.extend({
    init: function () {

        //this.incluirAndamento();
        this.salvarAndamento();
    },

    openModalAndamento: function (cod_contrato) {
        
        $('#tabandamentosearch-cod_contrato_fk').val(cod_contrato);
        $('#tabandamentosearch-cod_modulo_fk').val('1');
        $('#modalAndamento').modal('show').find('#modalContent').load( );
    },

    limpaFormAndamento: function () {
        $('#tabandamentosearch-cod_contrato_fk').val('');
        $('#tabandamentosearch-cod_assunto_fk').val('');
        $('#tabandamentosearch-txt_notificacao').val('');
        $('#tabandamentosearch-dt_retorno').val('');
    },

    incluirAndamento: function (valor) {
        $('#incluir' + valor).click(function () {
            $(this).attr('contrato');

            Projeto.prototype.andamento.limpaFormTipoContrato(valor);
            Projeto.prototype.andamento.openModalTipoContrato(valor, $(this).attr('contrato'));
        });
    },

    salvarAndamento: function () {
        $('#botaoSalvarAndamento').click(function ( ) {

            var form = $('#formCliente');
            var formAuxiliar = $('#formAndamento');
            if (formAuxiliar.find('.has-error').length) {
                return false;
            }

            var urlInclusao = $('base').attr('href') + 'andamento/incluir-andamento';

            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
                var dados = $.parseJSON(response);
                
                if (!dados.lista)
                {
                    $.each(dados, function (index, value) {
                        var obj = form.find('.field-tabandamentosearch-' + index);
                        obj.removeClass('has-success');
                        obj.addClass('has-error');
                        var msgBlock = obj.find('.help-block');
                        msgBlock.html(value);
                    });
                } else {

                    $('#divGuiaAndamento').html(dados.lista);
                    //$('#errorAuxiliares').hide();
                    $('#modalAndamento').modal('hide');

                }
            });



            return false;
        });

    },

}));

function adicionarAndamentoContrato(contrato) {

    Projeto.prototype.andamento.limpaFormAndamento();
    Projeto.prototype.andamento.openModalAndamento(contrato);


    return false;
}