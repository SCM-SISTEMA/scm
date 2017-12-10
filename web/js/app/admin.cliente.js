Projeto.prototype.cliente = new (Projeto.extend({
    init: function () {
        // this.abrirFormaPagamentoParcelas();
        //    this.openRefazerFormaPagamento();
        this.salvarCliente();
        this.salvarEndereco();
        //this.salvarParcelas();
        this.salvarContato();
        this.salvarSocios();
        this.incluirNovo('Endereco');
        this.incluirSocios();
        this.incluirNovo('Contato');
        //  this.salvarTipoContrato();
        //   this.salvarContrato();
        this.carregaMunicipio();
        this.alterarContato();
        this.verificaCnpj();
        this.openCliente();
        this.verificaCep();
    },
    verificaCep: function () {
        $('#tabenderecosearch-cep').blur(function ( ) {

            var urlInclusao = $('base').attr('href') + 'endereco/verifica-cep';

            var selecao = {dados: $('#tabenderecosearch-cep').val()};

            projeto.ajax.post(urlInclusao, selecao, function (response) {
                var ds = $.parseJSON(response);
            });


        });
    },

    verificaCnpj: function () {

        $('#tabclientesearch-cnpj').blur(function ( ) {
            if ($('#tabclientesearch-cnpj').val()) {
                var urlInclusao = $('base').attr('href') + 'admin/cliente/verifica-cnpj';

                var selecao = {dados: $('#tabclientesearch-cnpj').val(), cliente: $('#tabclientesearch-cod_cliente').val()};

                projeto.ajax.post(urlInclusao, selecao, function (response) {

                    var ds = $.parseJSON(response);

                    if (ds.existe) {

                        var msg = ($('#tabclientesearch-cod_cliente').val())
                                ? "CNPJ já cadastrado! Deseja carregar/migrar os dados existentes?" :
                                "CNPJ já cadastrato! Deseja carragar dados existentes?"


                        projeto.confirm('<div align="justify">' + msg + '</div>', function () {
                            projeto.ajax.defaultBlockUI();
                            var urlInclusao = $('base').attr('href') + 'comercial/cliente/migrar?id=' + ds.cliente.cod_cliente + '&migrar=' + $('#tabclientesearch-cod_cliente').val();

                            $(location).attr('href', urlInclusao);

                            return false;
                        }, function () {
                            return false;
                        });
                    } else {
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
                    }
                });

            }
        });

    },

    incluirNovo: function (valor) {
        $('#incluir' + valor).click(function () {
            Projeto.prototype.cliente.openModal(valor);
            Projeto.prototype.cliente.limpaForm(valor);
        });
    },
    incluirSocios: function () {
        $('#incluirSocios').click(function () {

            Projeto.prototype.cliente.openModalSocios();
            Projeto.prototype.cliente.limpaFormSocios();
        });
    },
//    incluirTipoContrato: function (valor) {
//        $('#incluir' + valor).click(function () {
//            $(this).attr('contrato');
//
//            Projeto.prototype.cliente.openModalTipoContrato(valor, $(this).attr('contrato'));
//            Projeto.prototype.cliente.limpaFormTipoContrato(valor);
//        });
//    },
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

//    abrirFormaPagamentoParcelas: function () {
//        $('#botaoSalvarFormaPagamentoContrato').click(function ( ) {
//
//            var form = $('#formCliente');
//
//            var urlInclusao = $('base').attr('href') + 'comercial/contrato-parcelas/buscar-parcelas-contato';
//
//            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
//
//                var dados = $.parseJSON(response);
//
//                $('#divFormaPagamento').html(dados);
//                $('#modalFormaPagamento').modal('show').find('#modalContent').load( );
//
//            });
//
//            return false;
//        });
//
//    },
//
//    salvarTipoContrato: function () {
//        $('#botaoSalvarTipoContrato').click(function ( ) {
//
//            var form = $('#formCliente');
//            var formAuxiliar = $('#formTipoContrato');
//            if (formAuxiliar.find('.has-error').length) {
//                return false;
//            }
//
//            var urlInclusao = $('base').attr('href') + 'comercial/cliente/incluir-tipo-contrato';
//
//            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
//                var dados = $.parseJSON(response);
//
//                if (!dados)
//                {
//                    $.each(dados, function (index, value) {
//                        var obj = form.find('.field-tabtipocontratosearch-' + index);
//                        obj.removeClass('has-success');
//                        obj.addClass('has-error');
//                        var msgBlock = obj.find('.help-block');
//                        msgBlock.html(value);
//                    });
//                } else {
//
//                    $('#divGuiaTipoContrato-' + dados.cod_contrato).html(dados.html);
//                    //$('#errorAuxiliares').hide();
//                    $('#modalTipoContrato').modal('hide');
//
//                }
//            });
//
//
//
//            return false;
//        });
//
//    },
    salvarCliente: function () {
        $('#botaoSalvarCliente').click(function ( ) {

            var form = $('#formCliente');

            var urlInclusao = $('base').attr('href') + 'comercial/cliente/incluir-cliente';

            $('#modalCliente').modal('hide');
            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
                var dados = $.parseJSON(response);

                setTimeout(function () {
                    projeto.ajax.defaultBlockUI();

                }, 300);
                location.reload();

            });



            return false;
        });

    },
//    salvarParcelas: function () {
//        $('#botaoSalvarFormaPagamento').click(function ( ) {
//
//            var form = $('#formCliente');
////            var formAuxiliar = $('#formTipoContrato');
////            if (formAuxiliar.find('.has-error').length) {
////                return false;
////            }
//
//            var urlInclusao = $('base').attr('href') + 'comercial/contrato-parcelas/incluir-parcelas';
//
//            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
//                var dados = $.parseJSON(response);
//
//                if (!dados)
//                {
//                    $.each(dados, function (index, value) {
//                        var obj = form.find('.field-tabtipocontratosearch-' + index);
//                        obj.removeClass('has-success');
//                        obj.addClass('has-error');
//                        var msgBlock = obj.find('.help-block');
//                        msgBlock.html(value);
//                    });
//                } else {
//                    $('#divGuiaContrato').html(dados);
//                    $('#modalFormaPagamentoContrato').modal('hide');
//                    $('#modalFormaPagamento').modal('hide');
//
//                }
//            });
//
//
//
//            return false;
//        });
//
//    },
//    salvarContrato: function () {
//        $('#botaoSalvarContrato').click(function ( ) {
//
//            var form = $('#formCliente');
//            var formAuxiliar = $('#formContrato');
//            if (formAuxiliar.find('.has-error').length) {
//                return false;
//            }
//
//            var urlInclusao = $('base').attr('href') + 'comercial/cliente/incluir-contrato';
//
//            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
//                var dados = $.parseJSON(response);
//                if (!dados)
//                {
//                    $.each(dados, function (index, value) {
//                        var obj = form.find('.field-tabtipocontratosearch-' + index);
//                        obj.removeClass('has-success');
//                        obj.addClass('has-error');
//                        var msgBlock = obj.find('.help-block');
//                        msgBlock.html(value);
//                    });
//                } else {
//
//                    $('#divGuiaContrato').html(dados);
//                    //$('#errorAuxiliares').hide();
//                    $('#modalContrato').modal('hide');
//
//                }
//            });
//
//
//
//            return false;
//        });
//
//    },
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

    openModalSocios: function () {

        $('#modalSocios').modal('show').find('#modalContent').load( );
    },

//    openRefazerFormaPagamento: function (valor) {
//
//        $('#botaoRefazerFormaPagamento').click(function ( ) {
//
//
//            $('#modalFormaPagamentoContrato').modal('hide');
//            $('#modalFormaPagamento').modal('hide');
//
//            setTimeout(function () {
//                adicionarFormaPagamentoContrato($('#tabcontratopsearch-cod_contrato').val());
//
//            }, 750);
//
//
//
//        });
//
//    },
    openCliente: function (valor) {

        $('#botaoOpenCliente').click(function ( ) {


            $('#modalCliente').modal('show').find('#modalContent').load( );

        });

    },

//    openModalTipoContrato: function (valor, cod_contrato) {
//        $('#tabcontratosearch-tipo_contrato_fk').removeAttr('disabled');
//        setTimeout(function () {
//            if (valor == 'TipoContrato') {
//                $('#tabtipocontratosearchservico-cod_contrato_fk').val(cod_contrato);
//                $('#tabtipocontratosearchservico-cod_usuario_fk').focus();
//
//            } else {
//                $('#tabtipocontratosearch-cod_contrato_fk').focus();
//                $('#div-status').hide();
//            }
//
//        }, 750);
//
//
//        $('#modal' + valor).modal('show').find('#modalContent').load( );
//    },
//    openModalFormaPagamentoContrato: function (cod_contrato) {
//
//        $('#modalFormaPagamento').modal('hide');
//        $('#modalFormaPagamentoContrato').modal('hide');
//        $('#modalFormaPagamentoContrato').modal('show').find('#modalContent').load( );
//    },
//    openModalFormaPagamento: function (cod_contrato) {
//
//        var urlInclusao = $('base').attr('href') + 'comercial/contrato-parcelas/carregar-parcelas';
//        var selecao = {cod_contrato: cod_contrato};
//        projeto.ajax.post(urlInclusao, selecao, function (response) {
//            var dados = $.parseJSON(response);
//
//            $('#divFormaPagamento').html(dados);
//            $('#modalFormaPagamentoContrato').modal('hide');
//            $('#modalFormaPagamento').modal('show').find('#modalContent').load( );
//
//        });
//
//        return false;
//
//    },
//
//    limpaFormFormaPagamentoContrato: function () {
//        $('#tabcontratopsearch-cod_contrato').val('');
//        $('#tabcontratopsearch-qnt_parcelas').val('');
//        $('#tabcontratopsearch-valor_contrato').val('');
//        $('#tabcontratopsearch-valor_contrato-disp').val('');
//        $('#tabcontratopsearch-dt_vencimento').val('');
//
//    },
    limpaFormSocios: function () {
        $('#tabsociossearch-nome').val('');
        $('#tabsociossearch-nacionalidade').val('');
        $('#tabsociossearch-estado_civil_fk').val('');
        $('#tabsociossearch-profissao').val('');
        $('#tabsociossearch-rg').val('');
        $('#tabsociossearch-orgao_uf').val('');
        $('#tabsociossearch-cpf').val('');
        $('#tabsociossearch-nacimento').val('');
        $('#tabsociossearch-telefone').val('');
        $('#tabsociossearch-skype').val('');
        $('#tabsociossearch-email').val('');
        $('#tabsociossearch-representante_comercial').val('');
        $('#tabsociossearch-cod_socio').val('');


        $('#tabenderecosocios-cod_endereco').val('');
        $('#tabenderecosocios-logradouro').val('');
        $('#tabenderecosocios-numero').val('');
        $('#tabenderecosocios-complemento').val('');
        $('#tabenderecosocios-cep').val('');
        $('#tabenderecosocios-correspondencia').val('');
        $('#tabenderecosocios-cod_municipio_fk').val('');
        $('#tabenderecosocios-uf').val('');
        $('#tabenderecosocios-bairro').val('');


    },
//    limpaFormTipoContrato: function (valor) {
//        if (valor == 'TipoContrato') {
//            $('#tabtipocontratosearchservico-cod_usuario_fk').val('');
//            $('#tabtipocontratosearchservico-tipo_produto_fk').val('');
//
//        } else {
//            $('#tabcontratosearch-tipo_contrato_fk').val('');
//            $('#tabtipo-contratosearch-cod_usuario_fk').val('');
//            $('#tabtipo-contratosearch-tipo_produto_fk').val('');
//        }
//
//    },
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

            Projeto.prototype.cliente.buscaMunicipio($(this).val(), '#tabenderecosearch-cod_municipio_fk');


        });
        $('#tabenderecosocios-uf').change(function ( ) {

            Projeto.prototype.cliente.buscaMunicipio($(this).val(), '#tabenderecosocios-cod_municipio_fk');


        });
    },
    buscaMunicipio: function (ufs, id) {
        var urlInclusao = $('base').attr('href') + 'municipios/lista';

        var selecao = {uf: ufs};

        projeto.ajax.post(urlInclusao, selecao, function (response) {
            $(id).html(response);
        });
    },
    alterarContato: function () {
        $('#tabcontatosearch-tipo').change(function ( ) {

            Projeto.prototype.cliente.mudarInputContato();

        });
    },

//    preencheFormContrato: function (dados) {
//
//        $('#tabcontratosearch-cod_contrato').val(dados[0]['cod_contrato']);
//        $('#tabcontratosearch-tipo_contrato_fk').val(dados[0]['tipo_contrato_fk']);
//        $('#tabcontratosearch-status').val(dados[0]['atributos_status']);
//        $('#tabtipo-contratosearch-cod_usuario_fk').val(dados[0]['cod_usuario_responsavel_fk']);
//
//    },

    preencheFormSocios: function (dados) {

        $('#tabsociossearch-nome').val(dados['nome']);
        $('#tabsociossearch-nacionalidade').val(dados['nacionalidade']);
        $('#tabsociossearch-estado_civil_fk').val(dados['estado_civil_fk']);
        $('#tabsociossearch-profissao').val(dados['profissao']);
        $('#tabsociossearch-rg').val(dados['rg']);
        $('#tabsociossearch-orgao_uf').val(dados['orgao_uf']);
        $('#tabsociossearch-cpf').val(dados['cpf']);
        $('#tabsociossearch-nacimento').val(dados['nacimento']);
        $('#tabsociossearch-telefone').val(dados['telefone']);
        $('#tabsociossearch-skype').val(dados['skype']);
        $('#tabsociossearch-email').val(dados['email']);
        $('#tabsociossearch-representante_comercial').val(dados['representante_comercial']);
        $('#tabsociossearch-cod_socio').val(dados['cod_socio']);
        $('#tabsociossearch-cod_cliente_fk').val(dados['cod_cliente_fk']);

        $('#tabenderecosocios-cod_endereco').val(dados['endereco']['cod_endereco']);
        $('#tabenderecosocios-logradouro').val(dados['endereco']['logradouro']);
        $('#tabenderecosocios-numero').val(dados['endereco']['numero']);
        $('#tabenderecosocios-complemento').val(dados['endereco']['complemento']);
        $('#tabenderecosocios-cep').val(dados['endereco']['cep']);
        $('#tabenderecosocios-correspondencia').val(dados['endereco']['correspondencia']);
        $('#tabenderecosocios-bairro').val(dados['endereco']['bairro']);
        $('#tabenderecosocios-uf').val(dados['endereco']['uf']).change();
        setTimeout(function () {
            $('#tabenderecosocios-cod_municipio_fk').val(dados['endereco']['cod_municipio_fk']);
        }, 300);

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
    },

    salvarSocios: function () {
        $('#botaoSalvarSocios').click(function ( ) {

            var form = $('#formCliente');
            var formAuxiliar = $('#formSocios');
            if (formAuxiliar.find('.has-error').length) {
                return false;
            }

            var urlInclusao = $('base').attr('href') + 'comercial/socios/incluir-socios';

            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {
                var dados = $.parseJSON(response);

                if (!dados.grid)
                {
                    $.each(dados, function (index, value) {
                        var obj = form.find('.field-tabsociossearch-' + index);
                        obj.removeClass('has-success');
                        obj.addClass('has-error');
                        var msgBlock = obj.find('.help-block');
                        msgBlock.html(value);
                    });
                } else {

                    $('#divGridSocios').html(dados.grid);
                    $('#errorAuxiliares').hide();
                    $('#modalSocios').modal('hide');

                }
            });



            return false;
        });

    },
}));
//
//function adicionarTipoContrato(contrato) {
//
//    Projeto.prototype.cliente.openModalTipoContrato('TipoContrato', contrato);
//    Projeto.prototype.cliente.limpaFormTipoContrato('TipoContrato');
//
//
//    return false;
//}
//
//
//
//
//function adicionarContrato(contrato) {
//
//    Projeto.prototype.cliente.openModalTipoContrato('Contrato', contrato);
//    Projeto.prototype.cliente.limpaFormTipoContrato('Contrato');
//
//
//    return false;
//}
//
//
//function editarContrato(result) {
//
//    var post = {'cod': result}
//    var urlInclusao = $('base').attr('href') + 'comercial/contrato/carregar-contrato';
//
//    projeto.ajax.post(urlInclusao, post, function (response) {
//
//        var dados = $.parseJSON(response);
//
//        Projeto.prototype.cliente.openModalTipoContrato('Contrato', result);
//        $('#div-status').show();
//
//        $('#tabcontratosearch-tipo_contrato_fk').attr('disabled', 'disabled');
//        Projeto.prototype.cliente.limpaFormTipoContrato('Contrato');
//        Projeto.prototype.cliente.preencheFormContrato(dados);
//
//    });
//
////    Projeto.prototype.cliente.openModal();
//
//
//    return false;
//}
//
//
//function excluirContrato(result) {
//
//    var post = {'id': result}
//    var urlInclusao = $('base').attr('href') + 'comercial/contrato/excluir-contrato';
//
//
//    projeto.confirm('<div align="center"><h2>Deseja excluir contrato?</h2></div>', function () {
//        projeto.ajax.defaultBlockUI();
//        projeto.ajax.post(urlInclusao, post, function (response) {
//
//            var dados = $.parseJSON(response);
//
//
//            $('#divGuiaContrato').html(dados);
//
//        });
//        return false;
//    }, function () {
//        return false;
//    })
//
//
////    Projeto.prototype.cliente.openModal();
//
//
//    return false;
//}

function excluirSocios(result) {

    var post = {'id': result}
    var urlInclusao = $('base').attr('href') + 'comercial/contrato/excluir-contrato';


    projeto.confirm('<div align="center"><h2>Deseja excluir contrato?</h2></div>', function () {
        projeto.ajax.defaultBlockUI();
        projeto.ajax.post(urlInclusao, post, function (response) {

            var dados = $.parseJSON(response);


            $('#divGuiaContrato').html(dados);

        });
        return false;
    }, function () {
        return false;
    })


//    Projeto.prototype.cliente.openModal();


    return false;
}


//
//function formaPagamento(result) {
//
//    var post = {'id': result}
//    var urlInclusao = $('base').attr('href') + 'comercial/contrato/forma-pagamento';
//
//    projeto.ajax.post(urlInclusao, post, function (response) {
//
//        var dados = $.parseJSON(response);
//
//
//        $('#divGuiaContrato').html(dados);
//
//        return false;
//    }, function () {
//        return false;
//    })
//
//
////    Projeto.prototype.cliente.openModal();
//
//
//    return false;
//}
//function mudarStatus(result, status, setor, tipo_contrato) {
//
//    var post = {'id': result, 'status': status, 'setor': setor, 'tipo_contrato': tipo_contrato}
//    var urlInclusao = $('base').attr('href') + 'comercial/contrato/mudar-status';
//
//    var msg = null;
//    if (status == '3') {
//        msg = 'Deseja realmente fechar a proposta?';
//    } else {
//        msg = 'Deseja realmente recusar a proposta?';
//
//    }
//    projeto.confirm('<div align="center"><h2>' + msg + '</h2></div>', function () {
//        projeto.ajax.defaultBlockUI();
//        projeto.ajax.post(urlInclusao, post, function (response) {
//
//            var dados = $.parseJSON(response);
//
//
//             setTimeout(function () {
//                     projeto.ajax.defaultBlockUI();
//                   
//                }, 300);
//                 location.reload();
//
//        });
//        return false;
//    }, function () {
//        return false;
//    })
//
//
////    Projeto.prototype.cliente.openModal();
//
//
//    return false;
//}
//
//function adicionarFormaPagamentoContrato(contrato, valor) {
//    if (valor) {
//        $('#tabcontratopsearch-cod_contrato').val(contrato);
//        Projeto.prototype.cliente.openModalFormaPagamento(contrato);
//    } else {
//
//        Projeto.prototype.cliente.limpaFormFormaPagamentoContrato(contrato);
//        Projeto.prototype.cliente.openModalFormaPagamentoContrato(contrato);
//        $('#tabcontratopsearch-cod_contrato').val(contrato);
//    }
//    return false;
//}

