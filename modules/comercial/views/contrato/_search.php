<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TabContratoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-contrato-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_contrato') ?>

    <?= $form->field($model, 'tipo_contrato_fk') ?>

    <?= $form->field($model, 'valor_contrato') ?>

    <?= $form->field($model, 'dia_vencimento') ?>

    <?= $form->field($model, 'qnt_parcelas') ?>

    <?php // echo $form->field($model, 'dt_prazo') ?>

    <?php // echo $form->field($model, 'dt_inclusao') ?>

    <?php // echo $form->field($model, 'dt_vencimento') ?>

    <?php // echo $form->field($model, 'contador') ?>

    <?php // echo $form->field($model, 'responsavel_fk') ?>

    <?php // echo $form->field($model, 'operando')->checkbox() ?>

    <?php // echo $form->field($model, 'qnt_clientes') ?>

    <?php // echo $form->field($model, 'link')->checkbox() ?>

    <?php // echo $form->field($model, 'zero800')->checkbox() ?>

    <?php // echo $form->field($model, 'parceiria')->checkbox() ?>

    <?php // echo $form->field($model, 'consultoria_scm')->checkbox() ?>

    <?php // echo $form->field($model, 'engenheiro_tecnico')->checkbox() ?>

    <?php // echo $form->field($model, 'cod_cliente_fk') ?>

    <?php // echo $form->field($model, 'ativo')->checkbox() ?>


    <?php ActiveForm::end(); ?>

</div>
