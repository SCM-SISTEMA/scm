<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabBlocoInfo */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="tab-bloco-info-form box box-default">
	<?php $form = ActiveForm::begin(); ?>

	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools">
			<?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> '. ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
			<?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar',  Url::toRoute($infoModulo['menu-item']['txt_url'] . "?TabBlocoInfoSearch[fk_form]={$model->fk_form}"), ['class' => 'btn btn-default btn-sm']) ?>
		</div>
	</div>
	
	<div class="box-body">
		<?= $form->field($model, 'servico_fk')->hiddenInput()->label(false) ?>
		<?= $form->field($model, 'fk_form')->hiddenInput()->label(false) ?>
		<?= $form->field($model, 'dsc_titulo_bloco')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'num_ordem_bloco')->textInput() ?>
		<?= $form->field($model, 'sgl_id')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="box-footer">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
			<?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> '. ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
			<?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar',  Url::toRoute($infoModulo['menu-item']['txt_url'] . "?TabBlocoInfoSearch[fk_form]={$model->fk_form}"), ['class' => 'btn btn-default btn-sm']) ?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>
