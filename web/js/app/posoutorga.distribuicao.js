Projeto.prototype.distribuicao = new (Projeto.extend({
    init: function () {
        this.totaisAcessoFisico();
        // this.addAcesso();
        //this.editAcesso();
        this.carregaMunicipio();
        this.salvar();

    },
//    addAcesso: function () {
//        $('#addAcesso').click(function () {
//
//            Projeto.prototype.distribuicao.limpaForm();
//            Projeto.prototype.distribuicao.openModal();
//
//        });
//
//    },
//    editAcesso: function () {
//        $("button[id^='bt_editar']").click(function () {
//            var result = $(this).attr('id').split('-');
//            var post = {'cod': result[1]};
//            var urlInclusao = $('base').attr('href') + 'posoutorga/sici/carregar-acesso';
//
//            projeto.ajax.post(urlInclusao, post, function (response) {
//
//                var dados = $.parseJSON(response);
//                Projeto.prototype.distribuicao.limpaForm();
//                Projeto.prototype.distribuicao.preencheForm(dados);
//
//
//            });
//
//            Projeto.prototype.distribuicao.openModal();
//
//        });
//
//    },

    totaisAcessoFisico: function () {

        $("input[id^='tabplanossearchm']").change(function () {

            var result = $(this).attr('id').split('-');


            if ((result[0] == 'tabplanossearchmf')) {
                var nome_total = '-total_fisica';
                var nome_outro = 'tabplanossearchmj-';
            } else {
                var nome_total = '-total_juridica';
                var nome_outro = 'tabplanossearchmf-';
            }

            var valorThis = (!$(this).val()) ? 0.00 : parseFloat($(this).val());
            var totalOutro = (!$('#' + nome_outro + result[1]).val()) ? 0.00 : parseFloat($('#' + nome_outro + result[1]).val());
            var total = valorThis + totalOutro;

            $('#tabempresamunicipiosearch-' + result[1].replace('valor', 'total')).html(
                    '<b>' +
                    total
                    + '</b>'
                    );

            var total_outro = 0;
            $.each($("input[id^='" + result[0] + "']"), function () {
                if ($(this).attr('id').indexOf("tipo_plano_fk") < 0) {

                    var valorThis = (!$(this).val()) ? 0.00 : parseFloat($(this).val());
                    total_outro = parseFloat(total_outro) + valorThis;
                }
            });

            $("#tabempresamunicipiosearch" + nome_total).html(
                    '<b>' +
                    total_outro
                    + '</b>'
                    );


            $("#tabempresamunicipiosearch-total").html(
                    '<b>' +
                    Projeto.prototype.util.colocaFormatoMoeda(
                            parseFloat(
                                    $("#tabempresamunicipiosearch-total_fisica").html().replace('<b>', '').replace('<b/>', '')
                                    ) +
                            parseFloat(
                                    $("#tabempresamunicipiosearch-total_juridica").html().replace('<b>', '').replace('<b/>', '')
                                    )

                            )
                    + '</b>'
                    )


        });
    },

    salvar: function () {
        $('#botaoSalvarAcessoFisico').click(function ( ) {

            var form = $('form');
            var formAuxiliar = $('#formAcessoFisico');
            if (formAuxiliar.find('.has-error').length) {
                return false;
            }

            var urlInclusao = $('base').attr('href') + 'posoutorga/sici/incluir-acesso';

            projeto.ajax.post(urlInclusao, form.serialize( ), function (response) {

                var dados = $.parseJSON(response);
                var atual = $("#acessoFisico").html();


                $('#errorAuxiliares').hide();
                $("#acessoFisicoAll").html(dados);
                $('#modalAcessoFisico').modal('hide');
                
                $('#acessos-fisicos .checado_vermelho a,#acessos-fisicos  checado_verde a').click(function ( ) {
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

            });



        });

    },
    openModal: function (valor) {
        setTimeout(function () {
            $('#tabempresamunicipiosearch-uf').focus();
        }, 750);



        $('#modalAcessoFisico').modal('show').find('#modalContent').load( );
    },

    limpaForm: function () {

        $.each($("#formAcessoFisico input, #formAcessoFisico select"), function () {
            $(this).val('');

        });
    },
    carregaMunicipio: function () {
        $('#tabempresamunicipiosearch-uf').change(function ( ) {

            Projeto.prototype.distribuicao.buscaMunicipio($(this).val());


        });
    },
    buscaMunicipio: function (ufs) {
        var urlInclusao = $('base').attr('href') + 'municipios/lista';

        var selecao = {uf: ufs};

        projeto.ajax.post(urlInclusao, selecao, function (response) {
            $('#tabempresamunicipiosearch-cod_municipio_fk').html(response);
        });
    },

    preencheForm: function (dados) {

        Projeto.prototype.distribuicao.buscaMunicipio(dados[0].uf);
        $('#tabempresamunicipiosearch-uf').val(dados[0].uf);
        $('#tabempresamunicipiosearch-cod_empresa_municipio').val(dados[0].cod_empresa_municipio);

        $('#tabempresamunicipiosearch-tecnologia_fk').val(dados[0].tecnologia_fk);
        $('#tabplanossearchmf-valor_512').val(dados[1].valor_512).change();
        $('#tabplanossearchmf-valor_512k_2m').val(dados[1].valor_512k_2m).change();
        $('#tabplanossearchmf-valor_2m_12m').val(dados[1].valor_2m_12m).change();
        $('#tabplanossearchmf-valor_12m_34m').val(dados[1].valor_12m_34m).change();
        $('#tabplanossearchmf-valor_34m').val(dados[1].valor_34m).change();
        $('#tabplanossearchmf-tipo_plano_fk').val(dados[1].tipo_plano_fk).change();
        $('#tabplanossearchmf-cod_plano').val(dados[1].cod_plano);

        $('#tabplanossearchmj-valor_512').val(dados[2].valor_512).change();
        $('#tabplanossearchmj-valor_512k_2m').val(dados[2].valor_512k_2m).change();
        $('#tabplanossearchmj-valor_2m_12m').val(dados[2].valor_2m_12m).change();
        $('#tabplanossearchmj-valor_12m_34m').val(dados[2].valor_12m_34m).change();
        $('#tabplanossearchmj-valor_34m').val(dados[2].valor_34m).change();
        $('#tabplanossearchmj-tipo_plano_fk').val(dados[1].tipo_plano_fk).change();
        $('#tabplanossearchmj-cod_plano').val(dados[2].cod_plano);

        $('#tabempresamunicipiosearch-capacidade_servico').val(dados[0].capacidade_servico);
        $('#tabempresamunicipiosearch-capacidade_municipio  ').val(dados[0].capacidade_municipio);

        setTimeout(function () {
            $('#tabempresamunicipiosearch-cod_municipio_fk').val(dados[0].cod_municipio_fk);

        }, 300);

    },
}));

function editar(result) {

    var post = {'cod': result}
    var urlInclusao = $('base').attr('href') + 'posoutorga/sici/carregar-acesso';

    projeto.ajax.post(urlInclusao, post, function (response) {

        var dados = $.parseJSON(response);

        Projeto.prototype.distribuicao.limpaForm();
        Projeto.prototype.distribuicao.preencheForm(dados);

    });

    Projeto.prototype.distribuicao.openModal();


    return false;
}


function adicionar() {

    Projeto.prototype.distribuicao.limpaForm();
    Projeto.prototype.distribuicao.openModal();



    return false;
}


function excluir(result) {

    var post = {'cod': result}
    var urlInclusao = $('base').attr('href') + 'posoutorga/sici/excluir-acesso';

    projeto.ajax.post(urlInclusao, post, function (response) {

        var dados = $.parseJSON(response);

        $('#errorAuxiliares').hide();
        $("#acessoFisicoAll").html(dados);



    });

    return false;
}