<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TabTipoContratoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-tipo-contrato-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_tipo_contrato') ?>

    <?= $form->field($model, 'cod_usuario_fk') ?>

    <?= $form->field($model, 'cod_contrato_fk') ?>


    <?php ActiveForm::end(); ?>

</div>
