<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabContato */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloInfra">Incluir Acesso Físico</div><h3>',
    'id' => 'modalAcessoFisico',
    'closeButton' => false,
    'size' => 'modal-lg',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir registro', [
        'id' => 'botaoSalvarAcessoFisico',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);


$empresaMunicF = new \app\modules\posoutorga\models\TabPlanosSearch();
$empresaMunicJ = new \app\modules\posoutorga\models\TabPlanosSearch();

$empresa = new \app\modules\posoutorga\models\TabEmpresaMunicipioSearch();
$empresa->calculaTotais($empresaMunicF, $empresaMunicJ);
?>

<div id="formAcessoFisico">
    <div class='row'>
        <div class='col-sm-4'>
            <?=
            $form->field($empresa, 'uf')->dropDownList(
                    ArrayHelper::map(
                            app\models\TabEstadosSearch::find()->all(), 'sgl_estado', 'txt_nome'
                    ), ['prompt' => $this->app->params['txt-prompt-select'],
                'id' => 'tabempresamunicipiosearch-uf', 'name' => 'TabEmpresaMunicipioSearch[0][uf]'
            ]);
            ?>
        </div>
        <div class='col-sm-4'>
            <?=
            $form->field($empresa, 'cod_municipio_fk')->dropDownList(
                    ArrayHelper::map(
                            app\models\TabMunicipiosSearch::find()->where(['sgl_estado_fk' => strtoupper($empresa->uf)])->all(), 'cod_municipio', 'txt_nome'
                    ), ['prompt' => $this->app->params['txt-prompt-select'],
                'id' => 'tabempresamunicipiosearch-cod_municipio_fk', 'name' => 'TabEmpresaMunicipioSearch[0][cod_municipio_fk]']);
            ?>

        </div>
        <div class='col-sm-4'>

            <?=
            $form->field($empresa, 'tecnologia_fk')->dropDownList(
                    ArrayHelper::map(
                            app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                                app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tecnologia'])->one()['cod_atributos']
                            ])->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select'], 'id' => 'tabempresamunicipiosearch-tecnologia_fk', 'name' => 'TabEmpresaMunicipioSearch[0][tecnologia_fk]'
            ]);
            ?>


        </div>

    </div>
    <br>
    <div class='row'>
        <div class='col-sm-1'>
            <p></p>
        </div>
        <div class='col-sm-2'>
            <p><b>até 512 Kbps</b></p>
        </div>
        <div class='col-sm-2'>
            <p><b>512 Kbps à 2 Mbps</b></p>
        </div>
        <div class='col-sm-2'>
            <p><b>2 Mbps à 12 Mbps</b></p>
        </div>
        <div class='col-sm-2'>
            <p><b>12 Mbps à 34 Mbps</b></p>
        </div>
        <div class='col-sm-2'>
            <p><b>ACIMA DE 34 Mbps</b></p>
        </div>
        <div class='col-sm-1'>
            <p><b>Total</b></p>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-1'>
            <p><b>FÍSICA</b></p>
            <?= $form->field($empresaMunicF, 'tipo_plano_fk')->hiddenInput(['id' => 'tabplanossearchmf-tipo_plano_fk', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][tipo_plano_fk]'])->label(false) ?>
        </div>
        <div class='col-sm-2'>
            <?=
            $form->field($empresaMunicF, 'valor_512')->textInput(['id' => 'tabplanossearchmf-valor_512', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][valor_512]]'])->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control', 'id' => 'tabplanossearchmf-valor_512', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][valor_512]]'
                ],
            ])->label(false);
            ?>
        </div>
        <div class='col-sm-2'>
            <?=
            $form->field($empresaMunicF, 'valor_512k_2m')->textInput(['id' => 'tabplanossearchmf-valor_512k_2m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][valor_512k_2m]]'])->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control', 'id' => 'tabplanossearchmf-valor_512k_2m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][valor_512k_2m]]'
                ],
            ])->label(false);
            ?>
        </div>
        <div class='col-sm-2'>
            <?=
            $form->field($empresaMunicF, 'valor_2m_12m')->textInput(['id' => 'tabplanossearchmf-valor_2m_12m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][valor_2m_12m]]'])->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control', 'id' => 'tabplanossearchmf-valor_2m_12m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][valor_2m_12m]]'
                ],
            ])->label(false);
            ?>
        </div>
        <div class='col-sm-2'>
            <?=
            $form->field($empresaMunicF, 'valor_12m_34m')->textInput(['id' => 'tabplanossearchmf-valor_12m_34m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][valor_12m_34m]]'])->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control', 'id' => 'tabplanossearchmf-valor_12m_34m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][valor_12m_34m]]'
                ],
            ])->label(false);
            ?>
        </div>
        <div class='col-sm-2'>
            <?=
            $form->field($empresaMunicF, 'valor_34m')->textInput(['id' => 'tabplanossearchmf-valor_34m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][valor_34m]]'])->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control', 'id' => 'tabplanossearchmf-valor_34m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][valor_34m]]'
                ],
            ])->label(false);
            ?>
        </div>
        <div class='col-sm-1' id='tabempresamunicipiosearch-total_fisica'><b>
                <?= $empresa->total_fisica;
                ?></b>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-1'>
            <p><b>JURÍDICO</b></p>
            <?= $form->field($empresaMunicJ, 'tipo_plano_fk')->hiddenInput(['id' => 'tabplanossearchmj-tipo_plano_fk', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][tipo_plano_fk]'])->label(false) ?>
        </div>
        <div class='col-sm-2'>
            <?=
            $form->field($empresaMunicJ, 'valor_512')->textInput(['id' => 'tabplanossearchmj-valor_512', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][valor_512]]'])->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control', 'id' => 'tabplanossearchmj-valor_512', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][valor_512]]'
                ],
            ])->label(false);
            ?>
        </div>
        <div class='col-sm-2'>
            <?=
            $form->field($empresaMunicJ, 'valor_512k_2m')->textInput(['id' => 'tabplanossearchmj-valor_512k_2m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][valor_512k_2m]]'])->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control', 'id' => 'tabplanossearchmj-valor_512k_2m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][valor_512k_2m]]'
                ],
            ])->label(false);
            ?>
        </div>
        <div class='col-sm-2'>
            <?=
            $form->field($empresaMunicJ, 'valor_2m_12m')->textInput(['id' => 'tabplanossearchmj-valor_2m_12m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][valor_2m_12m]]'])->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control', 'id' => 'tabplanossearchmj-valor_2m_12m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][valor_2m_12m]]'
                ],
            ])->label(false);
            ?>
        </div>
        <div class='col-sm-2'>
            <?=
            $form->field($empresaMunicJ, 'valor_12m_34m')->textInput(['id' => 'tabplanossearchmj-valor_12m_34m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][valor_12m_34m]]'])->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control', 'id' => 'tabplanossearchmj-valor_12m_34m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][valor_12m_34m]]'
                ],
            ])->label(false);
            ?>
        </div>
        <div class='col-sm-2'>
            <?=
            $form->field($empresaMunicJ, 'valor_34m')->textInput(['id' => 'tabplanossearchmj-valor_34m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][valor_34m]]'])->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control', 'id' => 'tabplanossearchmj-valor_34m', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][valor_34m]]'
                ],
            ])->label(false);
            ?>
        </div>
        <div class='col-sm-1' id='tabempresamunicipiosearch-total_juridica'>
            <b><?= $empresa->total_juridica ?></b>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-1'>
            <p><b>Total</b></p>
        </div>
        <div class='col-sm-2' id='tabempresamunicipiosearch-total_512'><b>
                <?= $empresa->total_512 ?>
            </b>
        </div>
        <div class='col-sm-2' id='tabempresamunicipiosearch-total_512k_2m'><b>
                <?= $empresa->total_512k_2m ?>
            </b>
        </div>
        <div class='col-sm-2' id='tabempresamunicipiosearch-total_2m_12m'><b>
                <?= $empresa->total_2m_12m ?>
            </b>
        </div>
        <div class='col-sm-2' id='tabempresamunicipiosearch-total_12m_34m'><b>
                <?= $empresa->total_12m_34m ?>
            </b>
        </div>
        <div class='col-sm-2' id='tabempresamunicipiosearch-total_34m'><b>
                <?= $empresa->total_34m ?>
            </b>
        </div>
        <div class='col-sm-1' id='tabempresamunicipiosearch-total'><b>
                <?= $empresa->total ?>
            </b>
        </div>
    </div>
    <br>
    <?php if($anual) : ?>
    <div class='row'>

        <div class='col-sm-6'>
            <?=
            $form->field($empresa, 'capacidade_municipio')->textInput(['id' => 'tabempresamunicipiosearch-capacidade_municipio', 'name' => 'TabEmpresaMunicipioSearch[0][capacidade_municipio]']);
            ?>
        </div>
        <div class='col-sm-6'>
            <?=
            $form->field($empresa, 'capacidade_servico')->textInput(['id' => 'tabempresamunicipiosearch-capacidade_servico', 'name' => 'TabEmpresaMunicipioSearch[0][capacidade_servico]']);
            ?>
        </div>
    </div>
    <?php endif; ?>
    <?= $form->field($empresa, 'cod_empresa_municipio')->hiddenInput(['id' => 'tabplanossearchmj-cod_plano', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMF][cod_plano]]'])->label(false); ?>
    <?= $form->field($empresa, 'cod_empresa_municipio')->hiddenInput(['id' => 'tabplanossearchmj-cod_plano', 'name' => 'TabEmpresaMunicipioSearch[0][TabEmpresaMunicipioSearchMJ][cod_plano]]'])->label(false); ?>
    <?= $form->field($empresa, 'cod_empresa_municipio')->hiddenInput(['id' => 'tabempresamunicipiosearch-cod_empresa_municipio', 'name' => 'TabEmpresaMunicipioSearch[0][cod_empresa_municipio]]'])->label(false); ?>
</div>

<?php Modal::end(); ?>