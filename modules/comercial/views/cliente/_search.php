<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TabClienteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cliente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cnpj') ?>

    <?= $form->field($model, 'ie') ?>

    <?= $form->field($model, 'fantasia') ?>

    <?= $form->field($model, 'razao_social') ?>

    <?= $form->field($model, 'dt_inclusao') ?>

    <?php // echo $form->field($model, 'dt_exclusao') ?>

    <?php // echo $form->field($model, 'cod_cliente') ?>

    <?php // echo $form->field($model, 'situacao')->checkbox() ?>


    <?php ActiveForm::end(); ?>

</div>
