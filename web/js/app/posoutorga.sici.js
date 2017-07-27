Projeto.prototype.sici = new (Projeto.extend({
    init: function () {
        this.totaisReceitas();
        this.totaisDespesas();
        this.mudaTipoSici();

        this.mudaBotaoImportacao();
        this.validaAjaxImportacao();
        this.verificaCnpj();
 
        this.totaisPlanos();
        this.submitCheck();
        this.clickCheck();
        this.checkInicial();
        

    }, checkInicial: function () {
        if (location.href.indexOf('importar') >= 0 || document.location.search) {

            if ($("#tabsicisearch-tipo_sici_fk  :selected").text() == 'Mensal' || $("#tabsicisearch-tipo_sici_fk  :selected").text() == 'Semestral') {

                if ($("#tabsicisearch-tipo_sici_fk  :selected").text() == 'Mensal') {

                    $.each($("#funcionarios [id*=_check]"), function () {

                        var divs = $(this).parent().parent().find("span");
                        divs.removeClass('checado_vermelho').addClass('checado_verde');
                    });

                }

                $.each($("#informacoes-adicionais [id*=_check]"), function () {

                    $.each($("#informacoes-adicionais [id*=_check]"), function () {

                        var divs = $(this).parent().parent().find("span");
                        divs.removeClass('checado_vermelho').addClass('checado_verde');
                    });

                });
            }
            ;


            $.each($("[id*=_check]"), function () {
                if ($(this).val()) {

                    var divs = $(this).parent().parent().find("span");
                    if (divs.length == 1) {
                        divs.removeClass('checado_vermelho').addClass('checado_verde');
                    } else {
                        var text = $(this).attr("id").replace('_check', "");
                        var divs = $('.field-' + text).find("span");
                        divs.removeClass('checado_vermelho').addClass('checado_verde');

                    }

                }
            });
        } else {
            $.each($("[id*=_check]"), function () {

                var divs = $(this).parent().parent().find("span");

                divs.removeClass('checado_vermelho').addClass('checado_verde');


            });
        }

    }
    , submitCheck: function () {
        $('#salvarSici, #salvarSici2').click(function (e) {

            var $form = $('form');

            if ($form.find("span[class*='checado_vermelho']").length > 0) {
                projeto.confirm('<div align="justify">O dados não estão totalmente checados, não será permitido imprimir o XML!<br />Deseja realmente salvar?</div>', function () {
                    projeto.ajax.defaultBlockUI();
                    $form.submit();
                }, function () {
                    return false;
                });

            } else {
                projeto.ajax.defaultBlockUI();
                $form.submit();
            }

            return false;
        });


    }
    , clickCheck: function () {

        $('.checado_vermelho a, checado_verde a').click(function ( ) {
            var classes = $(this).parent().parent().parent().attr('class').split(' ');

            var cl = classes[1].split('-');
            if ($(this).parent().attr('class').indexOf('checado_vermelho') >= 0) {
                $(this).parent().removeClass('checado_vermelho').addClass('checado_verde');
                $('#' + cl[1] + '-' + cl[2] + '_check').val(1);

            } else {
                $('#' + cl[1] + '-' + cl[2] + '_check').val(0);
                $(this).parent().removeClass('checado_verde').addClass('checado_vermelho');
            }


        });
    },
    verificaCnpj: function () {
        $('#tabclientesearch-cnpj').blur(function ( ) {

            var urlInclusao = $('base').attr('href') + 'posoutorga/sici/verifica-cnpj';

            var selecao = {dados: $('#tabclientesearch-cnpj').val()};

            projeto.ajax.post(urlInclusao, selecao, function (response) {
                var ds = $.parseJSON(response);
                $('#tabclientesearch-razao_social').val(ds.razao_social);
                if (!$('#tabclientesearch-fistel').val()) {
                    $('#tabclientesearch-fistel').val(ds.fistel);
                    $('#tabclientesearch-fistel').val(ds.responsavel);
                }
                $('#tabcontatosearcht-contato').val(ds.contatoT);
                $('#tabcontatosearchc-contato').val(ds.contatoC);
            });


        });
    },
    

    mudaBotaoImportacao: function () {
        $("#tabsicisearch-file").change(function () {
            $("#importacao").hide();
            $(".import.btn.btn-primary.btn-sm").show();
            $(".import.btn.btn-success.btn-sm").hide();
        });
    },
    mudaTipoSici: function () {
        $("#tabsicisearch-tipo_sici_fk").change(function () {
            $('#siciTab a[href="#informacoes-adicionais"]').hide();
            $('#siciTab a[href="#funcionarios"]').hide();

            if ($("#tabsicisearch-tipo_sici_fk  :selected").text() == 'Anual' || $("#tabsicisearch-tipo_sici_fk  :selected").text() == 'Semestral') {

                if ($("#tabsicisearch-tipo_sici_fk  :selected").text() == 'Anual') {
                    $('#siciTab a[href="#informacoes-adicionais"]').show();

                    $.each($("#informacoes-adicionais [id*=_check]"), function () {

                        var divs = $(this).parent().parent().find("span");
                        divs.removeClass('checado_verde').addClass('checado_vermelho');
                    });

                }

                $.each($("#funcionarios [id*=_check]"), function () {

                    var divs = $(this).parent().parent().find("span");
                    divs.removeClass('checado_verde').addClass('checado_vermelho');
                });
                $('#siciTab a[href="#funcionarios"]').show();


            } else {

                $.each($("#informacoes-adicionais [id*=_check]"), function () {

                    var divs = $(this).parent().parent().find("span");
                    divs.removeClass('checado_vermelho').addClass('checado_verde');
                });

                $.each($("#funcionarios [id*=_check]"), function () {

                    var divs = $(this).parent().parent().find("span");
                    divs.removeClass('checado_vermelho').addClass('checado_verde');
                });


                $('#siciTab a[href="#informacoes-adicionais"]').hide();
                $('#siciTab a[href="#funcionarios"]').hide();

            }
            $("#importacao").hide();
            $("button.import.btn.btn-primary").show();
            $("button.import.btn.btn-success").hide();
        });
    },
    validaAjaxImportacao: function () {
        $("button.import.btn.btn-primary, button.import.btn.btn-success").click(function () {
            setTimeout(function () {
                var form = $("form");
                if (!form.find(".has-error").length) {
                    projeto.ajax.defaultBlockUI();
                }
            }, 300);
        });
    },
    totaisDespesas: function () {
        $('#tabsicisearch-despesa_operacao_manutencao, #tabsicisearch-despesa_publicidade, #tabsicisearch-despesa_vendas, #tabsicisearch-despesa_link').change(function () {

            var total = (
                    parseFloat($('#tabsicisearch-despesa_operacao_manutencao').val()) + parseFloat($('#tabsicisearch-despesa_publicidade').val()) +
                    parseFloat($('#tabsicisearch-despesa_vendas').val()) + parseFloat($('#tabsicisearch-despesa_link').val())
                    );
            $('#tabsicisearch-total_despesa').val(Projeto.prototype.util.colocaFormatoMoeda(total));

        });


    },
    totaisPlanos: function () {
        $('#tabsicisearch-total_marketing_propaganda, #tabsicisearch-aplicacao_equipamento, #tabsicisearch-aplicacao_software, #tabsicisearch-total_pesquisa_desenvolvimento, #tabsicisearch-aplicacao_servico, #tabsicisearch-aplicacao_callcenter').change(function () {

            var total = (
                    parseFloat($('#tabsicisearch-total_marketing_propaganda').val()) + parseFloat($('#tabsicisearch-aplicacao_equipamento').val()) +
                    parseFloat($('#tabsicisearch-aplicacao_software').val()) + parseFloat($('#tabsicisearch-total_pesquisa_desenvolvimento').val()) +
                    parseFloat($('#tabsicisearch-aplicacao_servico').val()) + parseFloat($('#tabsicisearch-aplicacao_callcenter').val())
                    );
            $('#tabsicisearch-total_planta').val(Projeto.prototype.util.colocaFormatoMoeda(total));

        });


    },
    totaisReceitas: function () {
        $('#tabsicisearch-aliquota_nacional').change(function () {

            var total = ($('#tabsicisearch-receita_bruta').val() * $('#tabsicisearch-aliquota_nacional').val()) / 100;
            $('#tabsicisearch-total_aliquota').val(Projeto.prototype.util.colocaFormatoMoeda(total));

            if ($('#tabsicisearch-aliquota_nacional').val() > 0) {
                var total = $('#tabsicisearch-receita_bruta').val() - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_aliquota').val())
            } else {

                var total = $('#tabsicisearch-receita_bruta').val() - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_pis').val())
                        - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_icms').val()) - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_confins').val())
            }
            $('#tabsicisearch-receita_liquida').val(Projeto.prototype.util.colocaFormatoMoeda(total));

        });

        $('#tabsicisearch-receita_icms').change(function () {

            var total = (($('#tabsicisearch-receita_bruta').val() * $('#tabsicisearch-receita_icms').val()) / 100) / 100;
            $('#tabsicisearch-total_icms').val(Projeto.prototype.util.colocaFormatoMoeda(total));
            if (!$('#tabsicisearch-aliquota_nacional').val() || $('#tabsicisearch-aliquota_nacional').val() <= 0) {
                var total = $('#tabsicisearch-receita_bruta').val() - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_pis').val())
                        - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_icms').val()) - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_confins').val())
                $('#tabsicisearch-receita_liquida').val(Projeto.prototype.util.colocaFormatoMoeda(total));
            }
        });

        $('#tabsicisearch-receita_pis').change(function () {

            var total = (($('#tabsicisearch-receita_bruta').val() * $('#tabsicisearch-receita_pis').val()) / 100) / 100;
            $('#tabsicisearch-total_pis').val(Projeto.prototype.util.colocaFormatoMoeda(total));
            if (!$('#tabsicisearch-aliquota_nacional').val() || $('#tabsicisearch-aliquota_nacional').val() <= 0) {
                var total = $('#tabsicisearch-receita_bruta').val() - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_pis').val())
                        - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_icms').val()) - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_confins').val())

                $('#tabsicisearch-receita_liquida').val(Projeto.prototype.util.colocaFormatoMoeda(total));
            }
        });

        $('#tabsicisearch-receita_confins').change(function () {

            var total = (($('#tabsicisearch-receita_bruta').val() * $('#tabsicisearch-receita_confins').val()) / 100) / 100;
            $('#tabsicisearch-total_confins').val(Projeto.prototype.util.colocaFormatoMoeda(total));

            if (!$('#tabsicisearch-aliquota_nacional').val() || $('#tabsicisearch-aliquota_nacional').val() <= 0) {
                var total = $('#tabsicisearch-receita_bruta').val() - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_pis').val())
                        - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_icms').val()) - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_confins').val())

                $('#tabsicisearch-receita_liquida').val(Projeto.prototype.util.colocaFormatoMoeda(total));
            }
        });

        $('#tabsicisearch-receita_bruta').change(function () {
            $('#tabsicisearch-aliquota_nacional').change();
            $('#tabsicisearch-receita_icms').change();
            $('#tabsicisearch-receita_pis').change();
            $('#tabsicisearch-receita_confins').change();
            if ($('#tabsicisearch-aliquota_nacional').val() > 0) {
                var total = $('#tabsicisearch-receita_bruta').val() - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_aliquota').val())
            } else {
                var total = $('#tabsicisearch-receita_bruta').val() - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_pis').val())
                        - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_icms').val()) - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_confins').val())
            }
            $('#tabsicisearch-receita_liquida').val(Projeto.prototype.util.colocaFormatoMoeda(total));
        });
    },
}));
