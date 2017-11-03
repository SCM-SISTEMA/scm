<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\posoutorga\models\TabSiciSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-sici-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_sici') ?>

    <?= $form->field($model, 'cod_tipo_contrato_fk') ?>

    <?= $form->field($model, 'mes_ano_referencia') ?>

    <?= $form->field($model, 'fust') ?>

    <?= $form->field($model, 'receita_bruta') ?>

    <?php // echo $form->field($model, 'despesa_operacao_manutencao') ?>

    <?php // echo $form->field($model, 'despesa_publicidade') ?>

    <?php // echo $form->field($model, 'despesa_vendas') ?>

    <?php // echo $form->field($model, 'despesa_link') ?>

    <?php // echo $form->field($model, 'aliquota_nacional') ?>

    <?php // echo $form->field($model, 'receita_icms') ?>

    <?php // echo $form->field($model, 'receita_pis') ?>

    <?php // echo $form->field($model, 'receita_confins') ?>

    <?php // echo $form->field($model, 'receita_liquida') ?>

    <?php // echo $form->field($model, 'obs_receita') ?>

    <?php // echo $form->field($model, 'obs_despesa') ?>


    <?php ActiveForm::end(); ?>

</div>
