<?php
/* @var $this yii\web\View */
/* @var $searchModel app\modules\comercial\models\TabContratoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\components\MenuLateralModuloWidget;


?>

<div class="contrato-index box box-default">

	<div class="box-header with-border">
		<h3 class="box-title">Consulta</h3>
		<div class="box-tools pull-right">
			 <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Incluir novo registro', ['admin'], ['class' => 'btn btn-success btn-sm']) ?>
		</div>
	</div>

	<div class="box-body with-border">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'tipo_contrato_fk',
            'valor_contrato',
            'dia_vencimento',
            'qnt_parcelas',
            'dt_prazo',
            ['class' => 'projeto\grid\ActionColumn'],
        ],
    ]); ?>
	</div>
	
	<div class="box-footer">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
			 <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Incluir novo registro', ['admin'], ['class' => 'btn btn-success btn-sm']) ?>
		</div>
	</div>
</div>


