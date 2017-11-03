<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TabContratoParcelasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-contrato-parcelas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_contrato_parcelas') ?>

    <?= $form->field($model, 'cod_contrato_fk') ?>

    <?= $form->field($model, 'numero') ?>

    <?= $form->field($model, 'valor') ?>

    <?= $form->field($model, 'dt_inclusao') ?>

    <?php // echo $form->field($model, 'dt_vencimento') ?>

    <?php // echo $form->field($model, 'txt_login_inclusao') ?>

    <?php // echo $form->field($model, 'txt_login_alteracao') ?>

    <?php // echo $form->field($model, 'dt_alteracao') ?>


    <?php ActiveForm::end(); ?>

</div>
