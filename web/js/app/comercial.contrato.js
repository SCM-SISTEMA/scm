Projeto.prototype.contrato = new (Projeto.extend({
    init: function () {
        this.abrirFormaPagamentoParcelas();
        this.openRefazerFormaPagamento();
        this.salvarParcelas();
        this.salvarTipoContrato();
        this.salvarProposta();
        this.salvarContrato();
        this.salvarImportacao();
        this.gerarContratoProposta();
    },

    incluirTipoContrato: function (valor) {
        $('#incluir' + valor).click(function () {
            $(this).attr('contrato');

            Projeto.prototype.comercial.openModalTipoContrato(valor, $(this).attr('contrato'));
            Projeto.prototype.comercial.limpaFormTipoContrato(valor);
        });
    },

    abrirFormaPagamentoParcelas: function () {
        $('#botaoSalvarFormaPagamentoContrato').click(function ( ) {

            var form = $('#formCliente');

            var urlInclusao = $('base').attr('href') + 'comercial/contrato-parcelas/buscar-parcelas-contato';

            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {

                var dados = $.parseJSON(response);

                $('#divFormaPagamento').html(dados);
                $('#modalFormaPagamento').modal('show').find('#modalContent').load( );

            });

            return false;
        });

    },

    salvarTipoContrato: function () {
        $('#botaoSalvarTipoContrato').click(function ( ) {

            var form = $('#formCliente');
            var formAuxiliar = $('#formTipoContrato');
            if (formAuxiliar.find('.has-error').length) {
                return false;
            }

            var urlInclusao = $('base').attr('href') + 'comercial/cliente/incluir-tipo-contrato';

            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
                var dados = $.parseJSON(response);

                if (!dados)
                {
                    $.each(dados, function (index, value) {
                        var obj = form.find('.field-tabtipocontratosearch-' + index);
                        obj.removeClass('has-success');
                        obj.addClass('has-error');
                        var msgBlock = obj.find('.help-block');
                        msgBlock.html(value);
                    });
                } else {

                    $('#divGuiaTipoContrato-' + dados.cod_contrato).html(dados.html);
                    //$('#errorAuxiliares').hide();
                    $('#modalTipoContrato').modal('hide');

                }
            });



            return false;
        });

    },

    salvarParcelas: function () {
        $('#botaoSalvarFormaPagamento').click(function ( ) {

            var form = $('#formCliente');
//            var formAuxiliar = $('#formTipoContrato');
//            if (formAuxiliar.find('.has-error').length) {
//                return false;
//            }

            var urlInclusao = $('base').attr('href') + 'comercial/contrato-parcelas/incluir-parcelas';

            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
                var dados = $.parseJSON(response);

                if (!dados)
                {
                    $.each(dados, function (index, value) {
                        var obj = form.find('.field-tabtipocontratosearch-' + index);
                        obj.removeClass('has-success');
                        obj.addClass('has-error');
                        var msgBlock = obj.find('.help-block');
                        msgBlock.html(value);
                    });
                } else {
                    $('#divGuiaContrato').html(dados);
                    $('#modalFormaPagamentoContrato').modal('hide');
                    $('#modalFormaPagamento').modal('hide');

                }
            });



            return false;
        });

    },
    salvarContrato: function () {
        $('#botaoSalvarContrato').click(function ( ) {

            var form = $('#formCliente');
            var formAuxiliar = $('#formContrato');
            if (formAuxiliar.find('.has-error').length) {
                return false;
            }

            var urlInclusao = $('base').attr('href') + 'comercial/cliente/incluir-contrato';

            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
                var dados = $.parseJSON(response);
                if (!dados)
                {
                    $.each(dados, function (index, value) {
                        var obj = form.find('.field-tabtipocontratosearch-' + index);
                        obj.removeClass('has-success');
                        obj.addClass('has-error');
                        var msgBlock = obj.find('.help-block');
                        msgBlock.html(value);
                    });
                } else {

                    $('#divGuiaContrato').html(dados);
                    //$('#errorAuxiliares').hide();
                    $('#modalContrato').modal('hide');

                }
            });



            return false;
        });

    },

    salvarProposta: function () {
        $('#botaoSalvarProposta').click(function ( ) {

            var form = $('#formCliente').serialize( );

            var series = '&TabPropostaSearch[tipo_produto_fk]=' + $('#tabpropostasearch-tipo_produto_fk').val() +
                    '&TabPropostaSearch[cod_usuario_fk]=' + $('#tabpropostasearch-cod_usuario_fk').val();


            form = form + series;

            var urlInclusao = $('base').attr('href') + 'comercial/contrato/incluir-proposta';

            projeto.ajax.post(urlInclusao, form, function (response) {
                var dados = $.parseJSON(response);


                $('#divGuiaProposta').html(dados);
                //$('#errorAuxiliares').hide();
                $('#modalProposta').modal('hide');

            });



            return false;
        });

    },
    salvarImportacao: function () {
        $('#botaoSalvarImportacao').click(function ( ) {

          $(this).submit();



            return false;
        });

    },

    gerarContratoProposta: function () {
        $('#botaoSalvarContratoProposta').click(function ( ) {

            var cod_contrato = $('#viewclientecontratosearch-cod_contrato').val();
            var setor = $('#viewclientecontratosearch-cod_setor').val();
            var cod_tipo_contrato = $('#viewclientecontratosearch-cod_tipo_contrato').val();


            mudarStatus(cod_contrato, '3', setor, cod_tipo_contrato);


            return false;
        });

    },

    openRefazerFormaPagamento: function (valor) {

        $('#botaoRefazerFormaPagamento').click(function ( ) {


            $('#modalFormaPagamentoContrato').modal('hide');
            $('#modalFormaPagamento').modal('hide');

            setTimeout(function () {
                adicionarFormaPagamentoContrato($('#tabcontratopsearch-cod_contrato').val());

            }, 750);



        });

    },

    openModalTipoContrato: function (valor, cod_contrato) {

        setTimeout(function () {
            if (valor == 'ContratoProposta') {
                $('#tabcontratosearch-cod_contrato').val(cod_contrato);
                $('#tabcontratosearch-tipo_contrato_fk').focus();

            } else {
                $('#tabtipocontratosearch-cod_contrato_fk').focus();

            }

        }, 750);


        $('#modal' + valor).modal('show').find('#modalContent').load( );
    },
    openModalFormaPagamentoContrato: function (cod_contrato) {

        $('#modalFormaPagamento').modal('hide');
        $('#modalFormaPagamentoContrato').modal('hide');
        $('#modalFormaPagamentoContrato').modal('show').find('#modalContent').load( );
    },
    openModalFormaPagamento: function (cod_contrato) {

        var urlInclusao = $('base').attr('href') + 'comercial/contrato-parcelas/carregar-parcelas';
        var selecao = {cod_contrato: cod_contrato};
        projeto.ajax.post(urlInclusao, selecao, function (response) {
            var dados = $.parseJSON(response);

            $('#divFormaPagamento').html(dados);
            $('#modalFormaPagamentoContrato').modal('hide');
            $('#modalFormaPagamento').modal('show').find('#modalContent').load( );

        });

        return false;

    },

    limpaFormFormaPagamentoContrato: function () {
        $('#tabcontratopsearch-cod_contrato').val('');
        $('#tabcontratopsearch-qnt_parcelas').val('');
        $('#tabcontratopsearch-valor_contrato').val('');
        $('#tabcontratopsearch-valor_contrato-disp').val('');
        $('#tabcontratopsearch-dt_vencimento').val('');

    },

    limpaFormTipoContrato: function (valor) {
        if (valor == 'TipoContrato') {
            $('#tabtipocontratosearchservico-cod_usuario_fk').val('');
            $('#tabtipocontratosearchservico-tipo_produto_fk').val('');

        } else {
            $('#tabcontratosearch-tipo_contrato_fk').val('');
            $('#tabtipo-contratosearch-cod_usuario_fk').val('');
            $('#tabtipo-contratosearch-tipo_produto_fk').val('');
        }

    },

    preencheFormContrato: function (dados) {

        $('#tabcontratosearch-cod_contrato').val(dados[0]['cod_contrato']);
        $('#tabcontratosearch-tipo_contrato_fk').val(dados[0]['tipo_contrato_fk']);
        $('#tabcontratosearch-status').val(dados[0]['atributos_status']);
        $('#tabtipo-contratosearch-cod_usuario_fk').val(dados[0]['cod_usuario_responsavel_fk']);

    },

}));

function adicionarTipoContrato(contrato) {

    Projeto.prototype.comercial.openModalTipoContrato('TipoContrato', contrato);
    Projeto.prototype.comercial.limpaFormTipoContrato('TipoContrato');


    return false;
}

function openContrato(contrato) {

    Projeto.prototype.comercial.openModalTipoContrato('Proposta', contrato);
    Projeto.prototype.comercial.limpaFormTipoContrato('Proposta');


    return false;
}


function openGerarContrato(result, status, setor, tipo_contrato) {
    $('#viewclientecontratosearch-cod_contrato').val(result);
    $('#viewclientecontratosearch-cod_setor').val(setor);

    Projeto.prototype.contrato.openModalTipoContrato('ContratoProposta', result);
    //Projeto.prototype.comercial.limpaFormTipoContrato('Proposta');


    return false;
}



function adicionarContrato(contrato) {

    Projeto.prototype.comercial.openModalTipoContrato('Contrato', contrato);
    Projeto.prototype.comercial.limpaFormTipoContrato('Contrato');


    return false;
}


function editarContrato(result) {

    var post = {'cod': result}
    var urlInclusao = $('base').attr('href') + 'comercial/contrato/carregar-contrato';

    projeto.ajax.post(urlInclusao, post, function (response) {

        var dados = $.parseJSON(response);

        Projeto.prototype.comercial.openModalTipoContrato('Contrato', result);
        $('#div-status').show();

        $('#tabcontratosearch-tipo_contrato_fk').attr('disabled', 'disabled');
        Projeto.prototype.comercial.limpaFormTipoContrato('Contrato');
        Projeto.prototype.comercial.preencheFormContrato(dados);

    });

//    Projeto.prototype.comercial.openModal();


    return false;
}


function excluirContrato(result, setor) {

    var post = {'id': result, 'setor': setor}
    var urlInclusao = $('base').attr('href') + 'comercial/contrato/excluir-contrato';


    projeto.confirm('<div align="center"><h2>Deseja cancelar contrato?</h2></div>', function () {
        projeto.ajax.defaultBlockUI();
        projeto.ajax.post(urlInclusao, post, function (response) {

            var dados = $.parseJSON(response);


            $('#divGuiaContrato').html(dados);

        });
        return false;
    }, function () {
        return false;
    })


//    Projeto.prototype.comercial.openModal();


    return false;
}


function formaPagamento(result) {

    var post = {'id': result}
    var urlInclusao = $('base').attr('href') + 'comercial/contrato/forma-pagamento';

    projeto.ajax.post(urlInclusao, post, function (response) {

        var dados = $.parseJSON(response);


        $('#divGuiaContrato').html(dados);

        return false;
    }, function () {
        return false;
    })


//    Projeto.prototype.comercial.openModal();


    return false;
}
function mudarStatus(result, status, setor, tipo_contrato) {

    var post = {'id': result, 'status': status, 'setor': setor, 'tipo_contrato': tipo_contrato}
    var urlInclusao = $('base').attr('href') + 'comercial/contrato/mudar-status';

    var msg = null;
    if (status == '3') {
        msg = 'Deseja realmente fechar a proposta?';
    } else if(status == '1'){
         msg = 'Deseja realmente ativar proposta?';
    } else {
        msg = 'Deseja realmente recusar a proposta?';

    }
    projeto.confirm('<div align="center"><h2>' + msg + '</h2></div>', function () {
        projeto.ajax.defaultBlockUI();
        projeto.ajax.post(urlInclusao, post, function (response) {

            var dados = $.parseJSON(response);


            setTimeout(function () {
                projeto.ajax.defaultBlockUI();

            }, 300);

            if ($('#divGuiaProposta').html()) {
                $('#divGuiaProposta').html(dados.proposta);
                $('#divGuiaContrato').html(dados.contrato);
                $('#modalContratoProposta').modal('hide');
                setTimeout(function () {
                    projeto.ajax.defaultUnblockUI();

                }, 300);
            } else {
                location.reload();
            }


        });
        return false;
    }, function () {
        return false;
    })


//    Projeto.prototype.comercial.openModal();


    return false;
}

function adicionarFormaPagamentoContrato(contrato, valor) {
    if (valor) {
        $('#tabcontratopsearch-cod_contrato').val(contrato);
        Projeto.prototype.contrato.openModalFormaPagamento(contrato);
    } else {

        Projeto.prototype.contrato.limpaFormFormaPagamentoContrato(contrato);
        Projeto.prototype.contrato.openModalFormaPagamentoContrato(contrato);
        $('#tabcontratopsearch-cod_contrato').val(contrato);
    }
    return false;
}

function openProposta() {

    $('#tabpropostasearch-cod_usuario_fk').val('');
    $('#tabpropostasearch-tipo_produto_fk').val('');

    $('#modalProposta').modal('show').find('#modalContent').load( );

    return false;

}

function abrirImportacao(cod_contrato) {

    $('#tabimportacaosearch-cod_contrato').val(cod_contrato);

    $('#modalImportacao').modal('show').find('#modalContent').load( );

    return false;

}




