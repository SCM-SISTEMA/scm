<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\components\MenuLateralModuloWidget;
/* @var $this yii\web\View */
/* @var $model app\models\TabEndereco */


?>

<div class="tab-endereco-view box box-default">

    <div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools">
        <?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar dados', ['update', 'id' => $model->cod_municipio_fk], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-remove"></i> Excluir registro', ['delete', 'id' => $model->cod_municipio_fk], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Confirma a exclusão permanente deste registro?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Voltar', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
    	</div>
    </div>    
	
	<div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cod_endereco',
            'logradouro',
            'numero',
            'complemento',
            'cep',
            'correspondencia:boolean',
            'cod_municipio_fk',
            'chave_fk',
            'tipo_usuario',
            'dt_inclusao',
            'ativo:boolean',
        ],
    ]) ?>
	</div>    
	<div class="box-footer">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
		<?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar dados', ['update', 'id' => $model->cod_municipio_fk], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-remove"></i> Excluir registro', ['delete', 'id' => $model->cod_municipio_fk], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Confirma a exclusão permanente deste registro?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Voltar', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
		</div>
    </div>
</div>
