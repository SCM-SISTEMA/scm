<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabAtributosValores */
/* @var $form yii\widgets\ActiveForm */

$infoModulo = $this->context->module->info;

?>

<div class="tab-atributos-valores-form box box-default">
	<?php $form = ActiveForm::begin(); ?>

	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools">
			<?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> '. ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
			<?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar', $linkBack, ['class' => 'btn btn-default btn-sm']) ?>
		</div>
	</div>
	
	<div class="box-body">
		<?= $form->field($model, 'sgl_valor')->textInput() ?>
		<?= $form->field($model, 'dsc_descricao')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="box-footer">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
			<?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> '. ($model->isNewRecord ? 'Incluir registro' : 'Alterar registro'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm')]) ?>
			<?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Cancelar',  $linkBack, ['class' => 'btn btn-default btn-sm']) ?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>
