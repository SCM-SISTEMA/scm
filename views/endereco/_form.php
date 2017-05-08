<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabEndereco */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-endereco-form box box-default">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools">
			<?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> '. ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
			<?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar',  Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
		</div>
    </div>
	
	<div class="box-body">
    <div class='row'>
<div class='col-lg-6'>
    <?= $form->field($model, 'logradouro')->textInput(['maxlength' => true]) ?>
    </div>
</div>
    <div class='row'>
<div class='col-lg-6'>
    <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>
    </div>
</div>
    <div class='row'>
<div class='col-lg-6'>
    <?= $form->field($model, 'complemento')->textInput(['maxlength' => true]) ?>
    </div>
</div>
    <div class='row'>
<div class='col-lg-6'>
    <?= $form->field($model, 'cep')->textInput(['maxlength' => true]) ?>
    </div>
</div>
    <div class='row'>
<div class='col-lg-6'>
    <?= $form->field($model, 'correspondencia')->checkbox() ?>
    </div>
</div>
    <div class='row'>
<div class='col-lg-6'>
    <?= $form->field($model, 'cod_municipio_fk')->dropDownList(
								ArrayHelper::map(
												app\models\TabMunicipios::find()->all(), 
												'cod_municipio', 
												'txt_nome'
												),
								['prompt' => $this->app->params['txt-prompt-select'], 
								'class' => 'chosen-select'
							]); ?>
    </div>
</div>
    <div class='row'>
<div class='col-lg-6'>
    <?= $form->field($model, 'chave_fk')->textInput() ?>
    </div>
</div>
    <div class='row'>
<div class='col-lg-6'>
    <?= $form->field($model, 'tipo_usuario')->textInput()->widget(\kartik\money\MaskMoney::className(), [
																			'pluginOptions' => [
																			'thousands' => '.',
																			'decimal' => ',',
																			'precision' => 0,
																			'allowZero' => false,]
																			]); ?>
    </div>
</div>
    <div class='row'>
<div class='col-lg-6'>
    <?= $form->field($model, 'dt_inclusao')->widget(
						\dosamigos\datepicker\DatePicker::className(), [
						'language' => 'pt-BR',
						'clientOptions' => [
						'autoclose' => true,
						'format' => 'dd/mm/yyyy'
					]
				]); ?>
    </div>
</div>
    <div class='row'>
<div class='col-lg-6'>
    <?= $form->field($model, 'ativo')->checkbox() ?>
    </div>
</div>
    </div>

	<div class="box-footer">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
			<?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> '. ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
			<?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar',  Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
		</div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
