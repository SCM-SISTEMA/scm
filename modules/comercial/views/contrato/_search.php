<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TabContratoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-contrato-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_contrato') ?>

    <?= $form->field($model, 'tipo_contrato_fk') ?>

    <?= $form->field($model, 'valor_contrato') ?>

    <?= $form->field($model, 'dia_vencimento') ?>

    <?= $form->field($model, 'qnt_parcelas') ?>

    <?php // echo $form->field($model, 'dt_prazo') ?>


    <?php ActiveForm::end(); ?>

</div>
