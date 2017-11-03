<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\posoutorga\models\TabPlanosMenorMaior */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-planos-menor-maior-form box box-default">
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
                <?=
                $form->field($model, 'valor_menos_1m_ded')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
                $form->field($model, 'valor_menos_1m')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
                $form->field($model, 'valor_maior_1m_ded')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
                $form->field($model, 'valor_maior_1m')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
                $form->field($model, 'cod_plano_fk')->dropDownList(
                        ArrayHelper::map(
                                app\modules\posoutorga\models\TabPlanos::find()->all(), 'cod_plano', 'txt_nome'
                        ), ['prompt' => $this->app->params['txt-prompt-select'],
                    'class' => 'chosen-select'
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
