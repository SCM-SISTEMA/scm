<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\posoutorga\models\TabPlanosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-planos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_plano') ?>

    <?= $form->field($model, 'valor_512') ?>

    <?= $form->field($model, 'valor_512k_2m') ?>

    <?= $form->field($model, 'valor_2m_12m') ?>

    <?= $form->field($model, 'valor_12m_34m') ?>

    <?php // echo $form->field($model, 'valor_34m') ?>

    <?php // echo $form->field($model, 'tipo_plano_fk') ?>

    <?php // echo $form->field($model, 'cod_chave') ?>

    <?php // echo $form->field($model, 'tipo_tabela_fk') ?>

    <?php // echo $form->field($model, 'obs') ?>


    <?php ActiveForm::end(); ?>

</div>
