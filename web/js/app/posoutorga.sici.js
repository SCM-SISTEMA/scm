Projeto.prototype.sici = new (Projeto.extend({
    init: function () {
        this.totaisReceitas();
        this.totaisDespesas();
        // this.totaisAcessoFisico();
        // this.addAcesso();

        this.mudaBotaoImportacao();
        this.validaAjaxImportacao();
        this.verificaCnpj();

    },
    verificaCnpj: function () {
        $('#tabclientesearch-cnpj').blur(function ( ) {

            var urlInclusao = $('base').attr('href') + 'posoutorga/sici/verifica-cnpj';

            var selecao = {dados: $('#tabclientesearch-cnpj').val()};

            projeto.ajax.post(urlInclusao, selecao, function (response) {
                var ds = $.parseJSON(response);
                $('#tabclientesearch-razao_social').val(ds.razao_social);
                $('#tabcontatosearcht-contato').val(ds.contatoT);
                $('#tabcontatosearchc-contato').val(ds.contatoC);
            });


        });
    },
    mudaBotaoImportacao: function () {
        $("#tabsicisearch-file").change(function () {
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
