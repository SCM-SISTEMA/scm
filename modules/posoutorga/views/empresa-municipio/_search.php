<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\posoutorga\models\TabEmpresaMunicipioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-empresa-municipio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_empresa_municipio') ?>

    <?= $form->field($model, 'tecnologia') ?>

    <?= $form->field($model, 'cod_municipio_fk') ?>

    <?= $form->field($model, 'municipio') ?>

    <?= $form->field($model, 'uf') ?>

    <?php // echo $form->field($model, 'capacidade_municipio') ?>

    <?php // echo $form->field($model, 'capacidade_servico') ?>


    <?php ActiveForm::end(); ?>

</div>
