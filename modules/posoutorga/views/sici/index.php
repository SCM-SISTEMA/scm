<?php
/* @var $this yii\web\View */
/* @var $searchModel app\modules\posoutorga\models\TabSiciSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\components\MenuLateralModuloWidget;


?>

<div class="sici-index box box-default">

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
            'cod_tipo_contrato_fk',
            'mes_ano_referencia',
            'fust',
            'receita_bruta',
            'despesa_operacao_manutencao',
            'despesa_publicidade',
            'despesa_vendas',
            'despesa_link',
            'aliquota_nacional',
            // 'receita_icms',
            // 'receita_pis',
            // 'receita_confins',
            // 'receita_liquida',
            // 'obs_receita:ntext',
            // 'obs_despesa:ntext',
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


