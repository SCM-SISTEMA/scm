<?php
$labelAddon[] = "
            <div class='input-group'>
                  <span class='checado_vermelho'>
                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                        <i class='fa fa-check-circle'></i>
                    </a>
                  </span>
            </div>";

$labelAddon[] = $empresa->cod_empresa_municipio;
\Yii::$app->session->set('addon', $labelAddon);



$addon = (Yii::$app->request->get() || $this->context->module->module->controller->action->id == 'importar') ? ["template" => "{label}\n
                <div class='input-group'>
                  <span class='input-group-addon checado_vermelho'>
                   
        <a href='#' class='addonlink dropdown-toggle' data-toggle='dropdown'>
                   
                        <i class='fa fa-check-circle'></i>
                   
                  
                  </a>
                  </span>
                {input}
            </div>
            \n{hint}
            \n{error}"] : ["template" => "{label}\n{input}\n{hint}\n{error}"];

use yii\helpers\ArrayHelper;
?>
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
$form->field($empresa, 'cod_municipio_fk', $addon)->dropDownList(
        ArrayHelper::map(
                app\models\TabMunicipiosSearch::find()->where(['sgl_estado_fk' => strtoupper($empresa->uf)])->all(), 'cod_municipio', 'txt_nome'
        ), ['prompt' => $this->app->params['txt-prompt-select'], 'disabled' => true,
    'id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-cod_municipio_fk', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][cod_municipio_fk]']);
?>
        <?= $form->field($empresa, 'cod_municipio_fk_check')->hiddenInput(['id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-cod_municipio_fk_check', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][cod_municipio_fk_check]'])->label(false); ?>    
    </div>
    <div class='col-lg-6'>

        <?=
        $form->field($empresa, 'tecnologia_fk', $addon)->dropDownList(
                ArrayHelper::map(
                        app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                            app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tecnologia'])->one()['cod_atributos']
                        ])->all(), 'cod_atributos_valores', 'dsc_descricao'
                ), ['prompt' => $this->app->params['txt-prompt-select'], 'disabled' => true, 'id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-tecnologia_fk', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][tecnologia_fk]'
        ]);
        ?>
        <?= $form->field($empresa, 'tecnologia_fk_check')->hiddenInput(['id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-tecnologia_fk_check', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][tecnologia_fk_check]'])->label(false); ?>

    </div>

</div>
<div class='row'>
    <div class='col-lg-6'>
<?=
$form->field($empresa, 'uf', $addon)->dropDownList(
        ArrayHelper::map(
                app\models\TabEstadosSearch::find()->all(), 'sgl_estado', 'txt_nome'
        ), ['prompt' => $this->app->params['txt-prompt-select'],
    'id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-uf', 'disabled' => true, 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][uf]'
]);
?>
        <?= $form->field($empresa, 'uf_check')->hiddenInput(['id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-uf_check', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][uf_check]'])->label(false); ?>

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
                    return '<b>' . $model['valor_512'] . '</b>';
                }
                return $model['valor_512'];
            },
        ],
        [
            'attribute' => 'valor_512k_2m',
            'label' => '512 Kbps à 2 Mbps',
            'content' => function ($model, $key, $index) {
                if ($key == 2) {
                    return '<b>' . $model['valor_512k_2m'] . '</b>';
                }
                return $model['valor_512k_2m'];
            },
        ],
        [
            'attribute' => 'valor_2m_12m',
            'label' => '2 Mbps à 12 Mbps',
            'content' => function ($model, $key, $index) {
                if ($key == 2) {
                    return '<b>' . $model['valor_2m_12m'] . '</b>';
                }
                return $model['valor_2m_12m'];
            },
        ],
        [
            'attribute' => 'valor_12m_34m',
            'label' => '12 Mbps à 34 Mbps',
            'content' => function ($model, $key, $index) {
                if ($key == 2) {
                    return '<b>' . $model['valor_12m_34m'] . '</b>';
                }
                return $model['valor_12m_34m'];
            },
        ],
        [
            'attribute' => 'valor_34m',
            'label' => 'ACIMA DE 34 Mbps',
            'content' => function ($model, $key, $index) {
                if ($key == 2) {
                    return '<b>' . $model['valor_34m'] . '</b>';
                }
                return $model['valor_34m'];
            },
        ],
        [
            'attribute' => 'total',
            'label' => 'Total',
            'contentOptions' => ['style' => 'font-weight:bold'],
            'content' => function ($model, $key, $index) {

                return $model['total'];
            },
        ],
        [
            'attribute' => 'tipo_pessoa',
            'label' => '',
            'visible' => (Yii::$app->request->get() || $this->context->module->module->controller->action->id == 'importar') ? true : false,
            'content' => function ($model, $key, $index) {
                $nome = ( (strtolower($model['tipo_pessoa']) == 'totais') ? '' : '_' . strtolower(projeto\Util::tirarAcentos($model['tipo_pessoa'])) );
                $addon = \Yii::$app->session->get('addon');
                return "<div class='campo field-tabempresamunicipiosearch" . $addon[1] . "-total{$nome}'>" . $addon[0] . '</div>';
            },
        ],
    ],
]);
?>

<?= $form->field($empresa, 'total_fisica_check')->hiddenInput(['id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-total_fisica_check', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][total_fisica_check]'])->label(false); ?>
<?= $form->field($empresa, 'total_juridica_check')->hiddenInput(['id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-total_juridica_check', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][total_juridica_check]'])->label(false); ?>
<?= $form->field($empresa, 'total_check')->hiddenInput(['id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-total_check', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][total_check]'])->label(false); ?>
<br>
<div class='row'>

    <div class='col-lg-6'>
<?=
$form->field($empresa, 'capacidade_municipio', $addon)->textInput(['disabled' => true, 'id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-capacidade_municipio', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][capacidade_municipio]']);
?>
<?= $form->field($empresa, 'capacidade_municipio_check')->hiddenInput(['id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-capacidade_municipio_check', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][capacidade_municipio_check]'])->label(false); ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($empresa, 'capacidade_servico', $addon)->textInput(['disabled' => true, 'id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-capacidade_servico', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][capacidade_servico]']);
        ?>
<?= $form->field($empresa, 'capacidade_servico_check')->hiddenInput(['id' => 'tabempresamunicipiosearch' . $empresa->cod_empresa_municipio . '-capacidade_servico_check', 'name' => 'TabEmpresaMunicipioSearch[' . $empresa->cod_empresa_municipio . '][capacidade_servico_check]'])->label(false); ?>
    </div>
</div>

