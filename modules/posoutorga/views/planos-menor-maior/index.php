<?php
/* @var $this yii\web\View */
/* @var $searchModel app\modules\posoutorga\models\TabPlanosMenorMaiorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\components\MenuLateralModuloWidget;


?>

<div class="planos-menor-maior-index box box-default">

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
            'valor_menos_1m_ded',
            'valor_menos_1m',
            'valor_maior_1m_ded',
            'valor_maior_1m',
            'cod_plano_fk',
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


