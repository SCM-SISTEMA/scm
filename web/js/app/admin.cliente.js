Projeto.prototype.cliente = new (Projeto.extend({
    init: function () {
        this.salvarEndereco();
        this.salvarContato();
        this.incluirNovo('Endereco');
        this.incluirNovo('Contato');
       // this.incluirTipoContrato('TipoContrato');
        this.salvarTipoContrato();
        //this.incluirTipoContrato('Contrato');
        this.carregaMunicipio();
        this.alterarContato();
        this.verificaCnpj();
    },
    verificaCnpj: function () {
        $('#tabclientesearch-cnpj').blur(function ( ) {

            var urlInclusao = $('base').attr('href') + 'admin/cliente/verifica-cnpj';

            var selecao = {dados: $('#tabclientesearch-cnpj').val()};

            projeto.ajax.post(urlInclusao, selecao, function (response) {
                var ds = $.parseJSON(response);
                if (ds.cliente.razao_social) {

                    $('#tabclientesearch-razao_social').val(ds.cliente.razao_social);
                    if (!$('#tabclientesearch-fistel').val()) {
                        $('#tabclientesearch-fistel').val(ds.cliente.fistel);
                    }
                    $('#tabclientesearch-fantasia').val(ds.cliente.fantasia);
                    $('#divGridEndereco').html(ds.gridEnd.grid);
                    $('#divGridContato').html(ds.gridCont.grid);
                } else {
                    $('#tabclientesearch-razao_social').val('');

                    $('#tabclientesearch-fistel').val('');

                    $('#tabclientesearch-fantasia').val('');
                    $('#divGridEndereco').html('');
                    $('#divGridContato').html('');
                }
            });


        });
    },

    incluirNovo: function (valor) {
        $('#incluir' + valor).click(function () {

            Projeto.prototype.cliente.openModal(valor);
            Projeto.prototype.cliente.limpaForm(valor);
        });
    },
    incluirTipoContrato: function (valor) {
        $('#incluir' + valor).click(function () {
            $(this).attr( 'contrato' );
            
            Projeto.prototype.cliente.openModalTipoContrato(valor,  $(this).attr( 'contrato' ));
            Projeto.prototype.cliente.limpaFormTipoContrato(valor);
        });
    },
    salvarEndereco: function () {
        $('#botaoSalvarEndereco').click(function ( ) {

            var form = $('#formCliente');
            var formAuxiliar = $('#formEndereco');
            if (formAuxiliar.find('.has-error').length) {
                return false;
            }

            var urlInclusao = $('base').attr('href') + 'admin/cliente/incluir-endereco';

            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
                var dados = $.parseJSON(response);

                if (!dados.grid)
                {
                    $.each(dados, function (index, value) {
                        var obj = form.find('.field-tabenderecosearch-' + index);
                        obj.removeClass('has-success');
                        obj.addClass('has-error');
                        var msgBlock = obj.find('.help-block');
                        msgBlock.html(value);
                    });
                } else {

                    $('#divGridEndereco').html(dados.grid);
                    $('#errorAuxiliares').hide();
                    $('#modalEndereco').modal('hide');

                }
            });



            return false;
        });

    },
    salvarContato: function () {
        $('#botaoSalvarContato').click(function ( ) {

            var form = $('#formCliente');
            var formAuxiliar = $('#formContato');
            if (formAuxiliar.find('.has-error').length) {
                return false;
            }

            var urlInclusao = $('base').attr('href') + 'admin/cliente/incluir-contato';

            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
                var dados = $.parseJSON(response);

                if (!dados.grid)
                {
                    $.each(dados, function (index, value) {
                        var obj = form.find('.field-tabcontatosearch-' + index);
                        obj.removeClass('has-success');
                        obj.addClass('has-error');
                        var msgBlock = obj.find('.help-block');
                        msgBlock.html(value);
                    });
                } else {

                    $('#divGridContato').html(dados.grid);
                    $('#errorAuxiliares').hide();
                    $('#modalContato').modal('hide');

                }
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

            var urlInclusao = $('base').attr('href') + 'admin/cliente/incluir-tipo-contrato';

            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
                var dados = $.parseJSON(response);

                if (!dados)
                {
                    $.each(dados, function (index, value) {
                        var obj = form.find('.field-tabcontatosearch-' + index);
                        obj.removeClass('has-success');
                        obj.addClass('has-error');
                        var msgBlock = obj.find('.help-block');
                        msgBlock.html(value);
                    });
                } else {

                    $('#divGuiaTipoContrato').html(dados);
                    //$('#errorAuxiliares').hide();
                    $('#modalTipoContrato').modal('hide');

                }
            });



            return false;
        });

    },
    openModal: function (valor) {
        setTimeout(function () {
            if (valor == 'Endereco') {

                $('#tabenderecosearch-logradouro').focus();
            } else {

                $('#tabcontatosearch-tipo').focus();
            }

        }, 750);

        if (valor == 'Endereco') {

            $('#ativo-check').hide();
        } else {

            $('#divContatoAtivo').hide();


        }

        $('#modal' + valor).modal('show').find('#modalContent').load( );
    },
    openModalTipoContrato: function (valor, cod_contrato) {
        setTimeout(function () {
            if (valor == 'TipoContrato') {
                $('#tabtipocontratosearch-cod_contrato_fk').val(cod_contrato);
                $('#tabtipocontratosearch-cod_usuario_fk').focus();
            } else {

                $('#tabtipocontratosearch-cod_contrato_fk').focus();
            }

        }, 750);

//        if (valor == 'Endereco') {
//
//            $('#ativo-check').hide();
//        } else {
//
//            $('#divContatoAtivo').hide();
//
//
//        }

        $('#modal' + valor).modal('show').find('#modalContent').load( );
    },
    limpaFormTipoContrato: function (valor) {
        if (valor == 'TipoContrato') {
            $('#tabtipocontratosearch-cod_usuario_fk').val('');
            $('#tabtipocontratosearch-tipo_produto_fk').val('');

        } else {
            $('#tabcontratosearch-tipo_contrato_fk').val('');
            $('#tabcontratosearch-valor_contrato-disp').val('');
            $('#tabcontratosearch-dt_prazo').val('');
            $('#tabcontratosearch-qnt_parcelas-disp').val('');
            $('#tabcontratosearch-dia_vencimento-disp').val('');
            $('#tabtipo-contratosearch-cod_usuario_fk').val('');
            $('#tabtipo-contratosearch-tipo_produto_fk').val('');
        }

    },
    bloqueaForm: function (valor) {
        $('input[id^=\"itensmovimentacaosearch\"]').attr('disabled', valor);
        $('select[id^=\"itensmovimentacaosearch\"]').attr('disabled', valor);
        if (valor == true) {
            $('#botaoSalvar').hide( );
        } else {
            $('#botaoSalvar').show( );
        }
    },
    limpaForm: function (valor) {
        if (valor == 'Endereco') {
            $('#tabenderecosearch-cod_endereco').val('');
            $('#tabenderecosearch-logradouro').val('');
            $('#tabenderecosearch-numero').val('');
            $('#tabenderecosearch-complemento').val('');
            $('#tabenderecosearch-cep').val('');
            $('#tabenderecosearch-correspondencia').val('');
            $('#tabenderecosearch-cod_municipio_fk').val('');
            $('#tabenderecosearch-uf').val('');
            $('#tabenderecosearch-bairro').val('');
        } else {
            $('#tabcontatosearch-cod_contato').val('');
            $('#tabcontatosearch-contato').val('');
            $('#tabcontatosearch-ramal').val('');
            $('#tabcontatosearch-complemento').val('');
            $('#tabcontatosearch-ativo').val('');
            $('#tabcontatosearch-tipo').val('');
        }

    }
    ,
    preencheForm: function (dados, acao) {
        if (acao == 'Endereco') {

            $("#tabenderecosearch-ativo").prop("checked", dados.ativo);
            $('#tabenderecosearch-uf').val(dados.uf);
            $('#tabenderecosearch-cod_endereco').val(dados.cod_endereco);
            $('#tabenderecosearch-logradouro').val(dados.logradouro);
            $('#tabenderecosearch-numero').val(dados.numero);
            $('#tabenderecosearch-complemento').val(dados.complemento);
            $('#tabenderecosearch-cep').val(dados.cep);
            $('#tabenderecosearch-correspondencia').val(dados.correspondencia);
            $('#tabenderecosearch-bairro').val(dados.bairro);
            Projeto.prototype.cliente.buscaMunicipio(dados.uf);

            setTimeout(function () {
                $('#tabenderecosearch-cod_municipio_fk').val(dados.cod_municipio_fk);

                $('#ativo-check').show();
            }, 300);


        } else {
            $('#tabcontatosearch-cod_contato').val(dados.cod_contato);
            $('#tabcontatosearch-contato').val(dados.contato);
            $('#tabcontatosearch-contato_email').val(dados.contato_email);
            $('#tabcontatosearch-ramal').val(dados.ramal);
            $('#tabcontatosearch-complemento').val(dados.complemento);
            $('#tabcontatosearch-tipo').val(dados.tipo);
            $("#tabcontatosearch-ativo").prop("checked", dados.ativo);

            Projeto.prototype.cliente.mudarInputContato();
            setTimeout(function () {
                $('#divContatoAtivo').show();
            }, 300);


        }
        $('#botaoSalvar' + acao).html('Alterar registro');

    },
    verificaCpf: function () {
        $('#tabusuariossearch-num_cpf').blur(function ( ) {

            if ($('#tabusuariossearch-num_cpf').val() && ($('#tabusuariossearch-num_cpf').val().replace('_', '').length == 14)) {
                var urlInclusao = $('base').attr('href') + 'admin/usuarios/verifica-cpf';

                var selecao = {dados: $('#tabusuariossearch-num_cpf').val()};

                projeto.ajax.post(urlInclusao, selecao, function (response) {

                    setTimeout(function () {

                        if (response != 0) {

                            if (!$('.field-tabusuariossearch-num_cpf').hasClass("has-error")) {
                                $('.field-tabusuariossearch-num_cpf').removeClass("has-success");
                                $('.field-tabusuariossearch-num_cpf').addClass("has-error");
                                $('.field-tabusuariossearch-num_cpf .help-block').html('CPF "' + $('#tabusuariossearch-num_cpf').val() + '" já foi utilizado.');
                            } else {

                                $('.field-tabusuariossearch-num_cpf .help-block').html('CPF "' + $('#tabusuariossearch-num_cpf').val() + '" já foi utilizado.');
                            }
                        }
                    }, 600);
                });
            }

        });
    },
    adicionaPerfil: function () {
        $('#adicionarPerfil').click(function ( ) {

            var urlInclusao = $('base').attr('href') + 'admin/perfis/adiciona-perfis-modulo';

            var selecao = {cod_modulo: $('#tabusuariossearch-cod_modulo').val(), cod_perfil: $('#tabusuariossearch-cod_perfil').val()};

            projeto.ajax.post(urlInclusao, selecao, function (response) {
                $('#tabusuariossearch-cod_modulo').val(null);
                $('#tabusuariossearch-cod_perfil').html('<option value=""> -- selecione -- </option>');
                $('#tabusuariossearch-cod_perfil').val(null);
                var dados = $.parseJSON(response);
                $('#grid-perfil-modulos').html(dados.form);
            });

        });
    },
    carregaMunicipio: function () {
        $('#tabenderecosearch-uf').change(function ( ) {

            Projeto.prototype.cliente.buscaMunicipio($(this).val());


        });
    },
    buscaMunicipio: function (ufs) {
        var urlInclusao = $('base').attr('href') + 'municipios/lista';

        var selecao = {uf: ufs};

        projeto.ajax.post(urlInclusao, selecao, function (response) {
            $('#tabenderecosearch-cod_municipio_fk').html(response);
        });
    },
    alterarContato: function () {
        $('#tabcontatosearch-tipo').change(function ( ) {

            Projeto.prototype.cliente.mudarInputContato();

        });
    },

    mudarInputContato: function () {
        if ($('#tabcontatosearch-tipo').find('option:selected').text() == 'E-mail') {
            $('#divContatoEmail').show();
            $('#divContatoTelefone').hide();
            $('#tabcontatosearch-contato').val('');
            $('#tabcontatosearch-ramail').val('');
            $('#divContatoRamal').hide();
        } else if ($('#tabcontatosearch-tipo').find('option:selected').text() == 'Telefone') {
            $('#divContatoRamal').show();
            $('#divContatoTelefone').show();
            $('#divContatoEmail').hide();
            $('#tabcontatosearch-contato_email').val('');
        } else {
            $('#divContatoTelefone').show();
            $('#divContatoEmail').hide();
            $('#divContatoRamal').hide();
            $('#tabcontatosearch-contato_email').val('');
            $('#tabcontatosearch-ramail').val('');
        }
    }

}));

function adicionarTipoContrato(contrato) {

        Projeto.prototype.cliente.openModalTipoContrato('TipoContrato',  contrato);
            Projeto.prototype.cliente.limpaFormTipoContrato('TipoContrato');


    return false;
}


function adicionarContrato(contrato) {

        Projeto.prototype.cliente.openModalTipoContrato('Contrato',  contrato);
            Projeto.prototype.cliente.limpaFormTipoContrato('Contrato');


    return false;
}