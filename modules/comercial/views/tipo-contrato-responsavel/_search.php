<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\comercial\models\TabTipoContratoResponsavelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-tipo-contrato-responsavel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="barra-de-acoes-crud">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-refresh"></i> Resetar', ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?= $form->field($model, 'cod_responsavel_tipo_contrato') ?>

    <?= $form->field($model, 'cod_usuario_perfil_fk') ?>

    <?= $form->field($model, 'cod_tipo_contrato_fk') ?>

    <?= $form->field($model, 'dt_inclusao') ?>

    <?= $form->field($model, 'dt_exclusao') ?>

    <?php // echo $form->field($model, 'txt_login_inclusao') ?>

    <?php // echo $form->field($model, 'txt_login_alteracao') ?>

    <?php // echo $form->field($model, 'dt_alteracao') ?>


    <?php ActiveForm::end(); ?>

</div>
