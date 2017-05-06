<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\posoutorga\models\TabSici */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-sici-form box box-default">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools">
            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
            <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
        </div>
    </div>
                        
    <div class="box-body">
        <div class='row'>
            <div class='col-lg-6'>
                <?= $form->field($model, 'cod_tipo_contrato_fk')->textInput() ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?= $form->field($model, 'mes_ano_referencia')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?= $form->field($model, 'fust')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'receita_bruta')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'despesa_operacao_manutencao')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'despesa_publicidade')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'despesa_vendas')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'despesa_link')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'aliquota_nacional')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'receita_icms')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'receita_pis')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'receita_confins')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'receita_liquida')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?= $form->field($model, 'obs_receita')->textarea(['rows' => 6]) ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?= $form->field($model, 'obs_despesa')->textarea(['rows' => 6]) ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?= $form->field($model, 'responsavel')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'valor_consolidado')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'qtd_funcionarios_fichados')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'qtd_funcionarios_terceirizados')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'num_central_atendimento')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'total_fibra_prestadora')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'total_fibra_terceiros')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'total_crescimento_prestadora')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'total_crescimento_terceiros')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'total_fibra_implantada_prestadora')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'total_fibra_implantada_terceiros')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'total_fibra_crescimento_prop_prestadora')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'total_fibra_crescimento_prop_terceiros')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 0,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'total_planta')->textInput(['disabled'=>true]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                    <?=
                    $form->field($model, 'total_marketing_propaganda')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                        'pluginOptions' => [
                            'thousands' => '.',
                            'decimal' => ',',
                            'precision' => 2,
                            'allowZero' => false,]
                    ]);
                    ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                    <?=
                    $form->field($model, 'aplicacao_software')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                        'pluginOptions' => [
                            'thousands' => '.',
                            'decimal' => ',',
                            'precision' => 2,
                            'allowZero' => false,]
                    ]);
                    ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'total_pesquisa_desenvolvimento')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'aplicacao_servico')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                    <?=
                    $form->field($model, 'aplicacao_callcenter')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                        'pluginOptions' => [
                            'thousands' => '.',
                            'decimal' => ',',
                            'precision' => 2,
                            'allowZero' => false,]
                    ]);
                    ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'faturamento_de')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'faturamento_industrial')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-6'>
                <?=
                $form->field($model, 'faturamento_adicionado')->textInput()->widget(\kartik\money\MaskMoney::className(), [
                    'pluginOptions' => [
                        'thousands' => '.',
                        'decimal' => ',',
                        'precision' => 2,
                        'allowZero' => false,]
                ]);
                ?>
            </div>
        </div>
    </div>

    <div class="box-footer">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
            <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
