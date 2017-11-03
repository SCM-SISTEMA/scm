<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TabAtividadeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-atividade-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_atividade') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'primario')->checkbox() ?>

    <?= $form->field($model, 'cod_cliente_fk') ?>


    <?php ActiveForm::end(); ?>

</div>
