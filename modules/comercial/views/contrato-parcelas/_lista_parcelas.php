<?php
/* @var $this yii\web\View */
/* @var $searchModel app\modules\comercial\models\TabContratoParcelasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;

$dados = new \yii\data\ArrayDataProvider([
            'id' => 'lista-parcelas',
            'allModels' => $contrato['parcelas'],
            'sort' => false,
            'pagination' => ['pageSize' => false],
        ]);


?>
<div class='row'>

    <div class='col-lg-12'  style="text-align:right">
            <?=
            \projeto\helpers\Html::button('<i class="glyphicon glyphicon-trash"></i> Excluir Todos', [
                'class' => 'btn btn-danger btn-sm',
                'onclick' => "excluirContratoParcelas('{$contrato['attributes']['cod_contrato']}')",
            ])
            ?>
    </div>
</div> 
<div class='row'>

    <div class='col-lg-12'>
        <b>TOTAL: <?= number_format($contrato['attributes']['valor_contrato'], 2, ",", ".");?></b>   
    </div>
</div> 
<br />
<div class='row'>

    <div class='col-lg-12'>
            <?= GridView::widget([
        'dataProvider' => $dados,
        'columns' => [
            'numero',
            'valor',
            'dt_vencimento',
            'cod_usuario_inclusao_fk',
            ['class' => 'projeto\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
</div> 
   




