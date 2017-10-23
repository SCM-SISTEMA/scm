Projeto.prototype.andamento = new (Projeto.extend({
    init: function () {

        //this.incluirAndamento();
        this.salvarAndamento();
    },

    openModalAndamento: function (cod_setor, cod_contrato) {

        var urlInclusao = $('base').attr('href') + 'andamento/carregar-andamento';
        var selecao = {cod_setor_fk: cod_setor};
        $('#tabandamentosearch-cod_setor_fk').val(cod_setor);
        $('#tabandamentosearch-cod_contrato').val(cod_contrato);
        projeto.ajax.post(urlInclusao, selecao, function (response) {
            var dados = $.parseJSON(response);

            $('#gridModalAndamento').html(dados);
            //$('#errorAuxiliares').hide();

        });

        $('#modalAndamento').modal('show').find('#modalContent').load( );

        $('#divGuiaAndamento').html();
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

            var urlInclusao = $('base').attr('href') + 'comercial/andamento/incluir-andamento';

            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
                var dados = $.parseJSON(response);
                
                $('#divGuiaContrato').html(dados);

            });

            $('#modalAndamento').modal('hide');

            return false;
        });

    },

}));

function adicionarAndamentoContrato(setor, contrato) {
    $('#divGuiaAndamento').html();
    Projeto.prototype.andamento.limpaFormAndamento();
    Projeto.prototype.andamento.openModalAndamento(setor, contrato);


    return false;
}


function excluirAndamento(result) {

    var post = {'id': result}
    var urlInclusao = $('base').attr('href') + 'comercial/andamento/excluir-andamentos';


    projeto.confirm('<div align="center"><h2>Deseja excluir andamento?</h2></div>', function () {
        projeto.ajax.defaultBlockUI();
        projeto.ajax.post(urlInclusao, post, function (response) {

            var dados = $.parseJSON(response);


            $('#gridModalAndamento').html(dados);

        });
        return false;
    }, function () {
        return false;
    })


//    Projeto.prototype.cliente.openModal();


    return false;
}
