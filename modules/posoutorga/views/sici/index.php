<?php
/* @var $this yii\web\View */
/* @var $searchModel app\modules\posoutorga\models\TabSiciSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

?>

<div class="sici-index box box-default">

    <div class="box-header with-border">
        <h3 class="box-title">Consulta</h3>
        <div class="box-tools pull-right">
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Incluir novo registro', ['admin'], ['class' => 'btn btn-success btn-sm']) ?>
        </div>
    </div>

    <div class="box-body with-border">
        <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'cnpj',
                'razao_social',
                'fistel',
                'mes_ano_referencia',
                ['class' => 'projeto\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {gerar}',
                    'buttons' => [
                        'view' => function ($action, $model, $key) {

                            return Html::a('<span class="fa fa-search-plus"></span>', Url::to(['view', 'id' => $model->cod_sici]), [
                                        'title' => 'Exibir',
                                        'aria-label' => Yii::t('yii', 'View'),
                                        'data-pjax' => '0',
                            ]);
                        },
                        'update' => function ($action, $model, $key) {

                            return Html::a('<span class="fa fa-edit"></span>', Url::to(['update', 'id' => $model->cod_sici]), [
                                        'title' => 'Alterar',
                                        'aria-label' => 'Alterar',
                                        'data-pjax' => '0',
                               
                            ]);
                        },
                        'delete' => function ($action, $model, $key) {

                            return Html::a('<span class="fa fa-trash"></span>', Url::to(['delete', 'id' => $model->cod_sici]), [
                                        'title' => 'Excluir',
                                        'aria-label' => 'Excluir',
                                        'data-confirm' => 'Confirma a exclusão do registro?',
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                            ]);
                        },
                        'gerar' => function ($action, $model, $key) {

                            return Html::a('<span class="fa fa-file-excel-o"></span>', Url::to(['sici/gerar', 'cod_sici' => $model->cod_sici]), [
                                        'data-method' => 'post',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Gerar XML',
                            ]);
                        },
                    ]
                ],
            ],
        ]);
        ?>
    </div>

    <div class="box-footer">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Incluir novo registro', ['admin'], ['class' => 'btn btn-success btn-sm']) ?>
        </div>
    </div>
</div>


