<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TabAndamentoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-andamento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_andamento') ?>

    <?= $form->field($model, 'cod_assunto_fk') ?>

    <?= $form->field($model, 'dt_inclusao') ?>

    <?= $form->field($model, 'dt_exclusao') ?>

    <?= $form->field($model, 'cod_tipo_contrato_responsavel_fk') ?>

    <?php // echo $form->field($model, 'txt_notificacao') ?>

    <?php // echo $form->field($model, 'dt_retorno') ?>

    <?php // echo $form->field($model, 'cod_modulo_fk') ?>


    <?php ActiveForm::end(); ?>

</div>
