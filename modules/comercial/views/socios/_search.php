<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TabSociosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-socios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_socio') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'nacionalidade') ?>

    <?= $form->field($model, 'estado_civil_fk') ?>

    <?= $form->field($model, 'profissao') ?>

    <?php // echo $form->field($model, 'rg') ?>

    <?php // echo $form->field($model, 'orgao_uf') ?>

    <?php // echo $form->field($model, 'cpf') ?>

    <?php // echo $form->field($model, 'cod_cliente_fk') ?>

    <?php // echo $form->field($model, 'qual') ?>

    <?php // echo $form->field($model, 'txt_login_inclusao') ?>

    <?php // echo $form->field($model, 'txt_login_alteracao') ?>

    <?php // echo $form->field($model, 'dt_inclusao') ?>

    <?php // echo $form->field($model, 'dt_alteracao') ?>

    <?php // echo $form->field($model, 'representante_comercial')->checkbox() ?>

    <?php // echo $form->field($model, 'nacimento') ?>


    <?php ActiveForm::end(); ?>

</div>
