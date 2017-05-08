Projeto.prototype.sici = new (Projeto.extend({
    init: function () {
        this.totais();

    },
    totais: function (valor) {
        $('#tabsicisearch-aliquota_nacional').change(function () {

            var total = ($('#tabsicisearch-receita_bruta').val() * $('#tabsicisearch-aliquota_nacional').val()) / 100;
            $('#tabsicisearch-receita_bruta').val(total)
        });

        $('#tabsicisearch-aliquota_nacional').change(function () {

            var total = ($('#tabsicisearch-receita_bruta').val() * $('#tabsicisearch-aliquota_nacional').val()) / 100;
            $('#tabsicisearch-receita_bruta').val(total)
        });
    },

}));
