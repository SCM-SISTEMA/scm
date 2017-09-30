<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TabAtributosValoresSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-atributos-valores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_atributos_valores') ?>

    <?= $form->field($model, 'fk_atributos_valores_atributos_id') ?>

    <?= $form->field($model, 'sgl_valor') ?>

    <?= $form->field($model, 'dsc_descricao') ?>


    <?php ActiveForm::end(); ?>

</div>
