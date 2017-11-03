<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TabContatoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-contato-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_contato') ?>

    <?= $form->field($model, 'contato') ?>

    <?= $form->field($model, 'ramal') ?>

    <?= $form->field($model, 'ativo')->checkbox() ?>

    <?= $form->field($model, 'dt_inclusao') ?>

    <?php // echo $form->field($model, 'tipo') ?>

    <?php // echo $form->field($model, 'tipo_usuario') ?>

    <?php // echo $form->field($model, 'chave_fk') ?>


    <?php ActiveForm::end(); ?>

</div>
