<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TabEnderecoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-endereco-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_endereco') ?>

    <?= $form->field($model, 'logradouro') ?>

    <?= $form->field($model, 'numero') ?>

    <?= $form->field($model, 'complemento') ?>

    <?= $form->field($model, 'cep') ?>

    <?php // echo $form->field($model, 'correspondencia')->checkbox() ?>

    <?php // echo $form->field($model, 'cod_municipio_fk') ?>

    <?php // echo $form->field($model, 'chave_fk') ?>

    <?php // echo $form->field($model, 'tipo_usuario') ?>

    <?php // echo $form->field($model, 'dt_inclusao') ?>

    <?php // echo $form->field($model, 'ativo')->checkbox() ?>


    <?php ActiveForm::end(); ?>

</div>
