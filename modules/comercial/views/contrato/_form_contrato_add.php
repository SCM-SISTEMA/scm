<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TabContrato */
/* @var $form yii\widgets\ActiveForm */
?>

<div class='row'>
    <div class='col-lg-6'>
        <?= $form->field($model, 'tipo_contrato_fk')->textInput() ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($model, 'valor_contrato')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
        $form->field($model, 'dia_vencimento')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
        $form->field($model, 'qnt_parcelas')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
        $form->field($model, 'dt_prazo')->widget(
                \dosamigos\datepicker\DatePicker::className(), [
            'language' => 'pt-BR',
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy'
            ]
        ]);
        ?>
    </div>
</div>
