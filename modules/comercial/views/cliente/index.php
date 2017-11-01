<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\TabClienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\components\MenuLateralModuloWidget;
?>

<div class="cliente-index box box-default">

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
                'responsavel',
                'dsc_tipo_contrato',
                [
                    'attribute' => 'dsc_status',
                    'content' => function($data) {
                        switch ($data['sgl_status']) {
                            case 1: $cor = '#DAA520';
                                break;
                            case 2: $cor = '#FF0000';
                                break;
                            case 3: $cor = '#228B22';
                                break;
                            case 4: $cor = '#000';
                                break;
                        }


                        return "<div style='color:{$cor}'><b>" . $data['dsc_status'] . '</b></div>';
                    },
                    'filter' => app\models\TabAtributosValoresSearch::getAtributoValor(\app\models\TabAtributosSearch::findOne(['sgl_chave' => 'status-contrato'])->cod_atributos, true, true),
                ],
                'txt_login',
                [
                    'attribute' => 'dt_retorno',
                    'content' => function($data) {

                        $cor = ($data['status_andamento_retorno'] == 2) ? '#DAA520' : (($data['status_andamento_retorno'] == 1) ? '#FF0000' : '#000');

                        return "<div style='color:{$cor}'><b>" . $data['dt_retorno'] . '</b></div>';
                    }
                ],
                ['class' => 'projeto\grid\ActionColumn',
                    'template' => '{view} {admin} {delete}',
                    'buttons' => [
                        'view' => function ($action, $model, $key) {

                            return Html::a('<span class="fa fa-search-plus"></span>', Url::to(['cliente/view', 'id' => $model->cod_cliente]), [
                                        'title' => 'Exibir',
                                        'data-toggle' => 'tooltip',
                                        'aria-label' => Yii::t('yii', 'View'),
                                        'data-pjax' => '0',
                            ]);
                        },
                        'admin' => function ($action, $model, $key) {

                            return Html::a('<span class="fa fa-edit"></span>', Url::to(['cliente/admin', 'id' => $model->cod_cliente]), [
                                        'title' => 'Alterar',
                                        'aria-label' => 'Alterar',
                                        'data-toggle' => 'tooltip',
                                        'data-pjax' => '0',
                            ]);
                        },
                        'delete' => function ($action, $model, $key) {

                            return Html::a('<span class="fa fa-trash"></span>', Url::to(['delete', 'id' => $model->cod_cliente]), [
                                        'title' => 'Excluir',
                                        'aria-label' => 'Excluir',
                                        'data-confirm' => 'Confirma a exclusão do cliente?',
                                        'data-method' => 'post',
                                        'data-toggle' => 'tooltip',
                                        'data-pjax' => '0',
                            ]);
                        },
                    ],
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


