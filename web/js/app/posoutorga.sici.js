Projeto.prototype.sici = new (Projeto.extend({
    init: function () {
        this.totaisReceitas();
        this.totaisDespesas();
        this.mudaTipoSici();

        this.mudaBotaoImportacao();
        this.validaAjaxImportacao();
        this.verificaCnpj();
        this.somenteNumero();
        this.totaisPlanos();

    },
    verificaCnpj: function () {
        $('#tabclientesearch-cnpj').blur(function ( ) {

            var urlInclusao = $('base').attr('href') + 'posoutorga/sici/verifica-cnpj';

            var selecao = {dados: $('#tabclientesearch-cnpj').val()};

            projeto.ajax.post(urlInclusao, selecao, function (response) {
                var ds = $.parseJSON(response);
                $('#tabclientesearch-razao_social').val(ds.razao_social);
                $('#tabclientesearch-fistel').val(ds.fistel);
                $('#tabcontatosearcht-contato').val(ds.contatoT);
                $('#tabcontatosearchc-contato').val(ds.contatoC);
            });


        });
    },
    somenteNumero: function () {

        $(".somenteNumero").keyup(function (e) {
            e.preventDefault();
            var expre = /[^\d]/g;
            $(this).val($(this).val().replace(expre, ''));
        });
    },

    mudaBotaoImportacao: function () {
        $("#tabsicisearch-file").change(function () {
            $("#importacao").hide();
            $("button.import.btn.btn-primary").show();
            $("button.import.btn.btn-success").hide();
        });
    },
    mudaTipoSici: function () {
        $("#tabsicisearch-tipo_sici_fk").change(function () {
            $('#siciTab a[href="#informacoes-adicionais"]').hide();
            $('#siciTab a[href="#funcionarios"]').hide();
            if ($("#tabsicisearch-tipo_sici_fk  :selected").text() == 'Anual' || $("#tabsicisearch-tipo_sici_fk  :selected").text() == 'Semestral') {

                if ($("#tabsicisearch-tipo_sici_fk  :selected").text() == 'Anual') {
                    $('#siciTab a[href="#informacoes-adicionais"]').show();

                }

                $('#siciTab a[href="#funcionarios"]').show();
            } else {
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

            var total = $('#tabsicisearch-receita_bruta').val() - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_aliquota').val())
            $('#tabsicisearch-receita_liquida').val(Projeto.prototype.util.colocaFormatoMoeda(total));

        });

        $('#tabsicisearch-receita_icms').change(function () {

            var total = (($('#tabsicisearch-receita_bruta').val() * $('#tabsicisearch-receita_icms').val()) / 100) / 100;
            $('#tabsicisearch-total_icms').val(Projeto.prototype.util.colocaFormatoMoeda(total));
        });

        $('#tabsicisearch-receita_pis').change(function () {

            var total = (($('#tabsicisearch-receita_bruta').val() * $('#tabsicisearch-receita_pis').val()) / 100) / 100;
            $('#tabsicisearch-total_pis').val(Projeto.prototype.util.colocaFormatoMoeda(total));
        });

        $('#tabsicisearch-receita_confins').change(function () {

            var total = (($('#tabsicisearch-receita_bruta').val() * $('#tabsicisearch-receita_confins').val()) / 100) / 100;
            $('#tabsicisearch-total_confins').val(Projeto.prototype.util.colocaFormatoMoeda(total));
        });

        $('#tabsicisearch-receita_bruta').change(function () {
            $('#tabsicisearch-aliquota_nacional').change();
            $('#tabsicisearch-receita_icms').change();
            $('#tabsicisearch-receita_pis').change();
            $('#tabsicisearch-receita_confins').change();
            var total = $('#tabsicisearch-receita_bruta').val() - Projeto.prototype.util.retiraFormatoMoeda($('#tabsicisearch-total_aliquota').val())
            $('#tabsicisearch-receita_liquida').val(Projeto.prototype.util.colocaFormatoMoeda(total));
        });
    },
}));
