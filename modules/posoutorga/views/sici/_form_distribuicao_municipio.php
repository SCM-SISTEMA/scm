<?php

use yii\helpers\ArrayHelper; ?>
<div class='row'>
    <div class='col-lg-12'>
        <div class="box-tools pull-right">
            <?=
            \projeto\helpers\Html::button('<i class="glyphicon glyphicon-edit"></i>', [
                'class' => 'btn btn-primary btn-sm',
                'onclick' => 'editar("' . $empresa->cod_empresa_municipio . '")',
            ])
            ?>
            <?=
            \projeto\helpers\Html::button('<i class="glyphicon glyphicon-trash"></i>', [
                'class' => 'btn btn-danger btn-sm',
                'data-pjax' => '0',
                'onclick' => "if (!confirm('Deseja realmente excluir o Acesso Físico.')){
                                return
                            }else{
                                 excluir(" . $empresa->cod_empresa_municipio . ");
                            }",
            ])
            ?> 
        </div> 
    </div>
</div>
<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($empresa, 'cod_municipio_fk')->dropDownList(
                ArrayHelper::map(
                        app\models\TabMunicipiosSearch::find()->where(['sgl_estado_fk' => strtoupper($empresa->uf)])->all(), 'cod_municipio', 'txt_nome'
                ), ['prompt' => $this->app->params['txt-prompt-select'], 'disabled' => true,
            'id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-cod_municipio_fk', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][cod_municipio_fk]']);
        ?>
    </div>
    <div class='col-lg-6'>

        <?=
        $form->field($empresa, 'tecnologia_fk')->dropDownList(
                ArrayHelper::map(
                        app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                            app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tecnologia'])->one()['cod_atributos']
                        ])->all(), 'cod_atributos_valores', 'dsc_descricao'
                ), ['prompt' => $this->app->params['txt-prompt-select'], 'disabled' => true, 'id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-tecnologia_fk', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][tecnologia_fk]'
        ]);
        ?>


    </div>

</div>
<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($empresa, 'uf')->dropDownList(
                ArrayHelper::map(
                        app\models\TabEstadosSearch::find()->all(), 'sgl_estado', 'txt_nome'
                ), ['prompt' => $this->app->params['txt-prompt-select'],
            'id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-uf', 'disabled' => true, 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][uf]'
        ]);
        ?>

    </div>
</div>


<?=
yii\grid\GridView::widget([
    'dataProvider' => $empresa->gridMunicipios,
    'summary' => false,
    'columns' => [
        [
            'attribute' => 'tipo_pessoa',
            'label' => '',
            'contentOptions' => ['style' => 'font-weight:bold'],
        ],
        [
            'attribute' => 'valor_512',
            'label' => 'até 512 Kbps',
            'content' => function ($model, $key, $index) {
                if ($key == 2) {
                    return '<b>' . projeto\Util::decimalFormatToBank($model['valor_512']) . '</b>';
                }
                return projeto\Util::decimalFormatToBank($model['valor_512']);
            },
        ],
        [
            'attribute' => 'valor_512k_2m',
            'label' => '512 Kbps à 2 Mbps',
            'content' => function ($model, $key, $index) {
                if ($key == 2) {
                    return '<b>' . projeto\Util::decimalFormatToBank($model['valor_512k_2m']) . '</b>';
                }
                return projeto\Util::decimalFormatToBank($model['valor_512k_2m']);
            },
        ],
        [
            'attribute' => 'valor_2m_12m',
            'label' => '2 Mbps à 12 Mbps',
            'content' => function ($model, $key, $index) {
                if ($key == 2) {
                    return '<b>' . projeto\Util::decimalFormatToBank($model['valor_2m_12m']) . '</b>';
                }
                return projeto\Util::decimalFormatToBank($model['valor_2m_12m']);
            },
        ],
        [
            'attribute' => 'valor_12m_34m',
            'label' => '12 Mbps à 34 Mbps',
            'content' => function ($model, $key, $index) {
                if ($key == 2) {
                    return '<b>' . projeto\Util::decimalFormatToBank($model['valor_12m_34m']) . '</b>';
                }
                return projeto\Util::decimalFormatToBank($model['valor_12m_34m']);
            },
        ],
        [
            'attribute' => 'valor_34m',
            'label' => 'ACIMA DE 34 Mbps',
            'content' => function ($model, $key, $index) {
                if ($key == 2) {
                    return '<b>' . projeto\Util::decimalFormatToBank($model['valor_34m']) . '</b>';
                }
                return projeto\Util::decimalFormatToBank($model['valor_34m']);
            },
        ],
        [
            'attribute' => 'total',
            'label' => 'Total',
            'contentOptions' => ['style' => 'font-weight:bold'],
            'content' => function ($model, $key, $index) {

                return projeto\Util::decimalFormatToBank($model['total']);
            },
        ],
    ],
]);
?>

<br>
<div class='row'>

    <div class='col-lg-6'>
        <?=
        $form->field($empresa, 'capacidade_municipio')->textInput(['disabled' => true, 'id' => 'tabempresamunicipiosearch-' . $empresa->cod_empresa_municipio . '-capacidade_municipio', 'name' => 'TabEmpresaMunicipioSearch[' . $key . '][capacidade_municipio]']);
        ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($empresa, 'capacidade_servico')->textInput(['disabled' => true, 'id' => 'tabempresamunicipiosearch-' . $empresa->cod_empresa_municipio . '-capacidade_servico', 'name' => 'TabEmpresaMunicipioSearch[' . $key . '][capacidade_servico]']);
        ?>
    </div>
</div>