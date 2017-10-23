<?php
/* @var $this yii\web\View */
/* @var $searchModel app\modules\comercial\models\TabContratoParcelasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;

$provider = new \yii\data\ActiveDataProvider([
    'query' => $andamento,
    'sort' => [
        'attributes' => ['cod_cliente'],
    ],
    'pagination' => [
        'pageSize' => 100,
    ],
        ]);
?>
<div class='row'>


    <div class='col-lg-12'>
        <?=
        GridView::widget([
            'dataProvider' => $provider,
            'columns' => [
                array(
                    'label' => 'Inclusão',
                    'attribute' => 'dt_inclusao',
                    'content' => function($data) {


                        return date('d/m/Y H:i:s', strtotime($data->dt_inclusao));
                    },
                ),
                [
                    'attribute' => 'txt_notificacao',
                    'label' => 'Andamento',
                ],
                array(
                    'label' => 'Retorno',
                    'attribute' => 'dt_retorno',
                ),
                [
                    'label' => 'Usuário',
                    'attribute' => 'cod_usuario_inclusao_fk',
                    'content' => function($data) {

                        $user = app\modules\admin\models\TabUsuariosSearch::find()->where(['cod_usuario' => $data->cod_usuario_inclusao_fk])->one();

                        return $user->txt_login;
                    },
                ],
                ['class' => 'projeto\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($action, $model, $key) {

                            return \projeto\helpers\Html::a('<span class="fa fa-trash"></span>', '#', [
                                        'title' => 'Excluir',
                                        'data-toggle' => 'tooltip',
                                        'onclick' => "return excluirAndamento('" . $model->cod_andamento . "')",
                            ]);
                        },
                    ],
                ],
            ],
        ]);
        ?>
    </div>

</div> 





