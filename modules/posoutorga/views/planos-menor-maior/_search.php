<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\posoutorga\models\TabPlanosMenorMaiorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-planos-menor-maior-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_plano_menor_maior') ?>

    <?= $form->field($model, 'valor_menos_1m_ded') ?>

    <?= $form->field($model, 'valor_menos_1m') ?>

    <?= $form->field($model, 'valor_maior_1m_ded') ?>

    <?= $form->field($model, 'valor_maior_1m') ?>

    <?php // echo $form->field($model, 'cod_plano_fk') ?>


    <?php ActiveForm::end(); ?>

</div>
