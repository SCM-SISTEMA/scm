<?php
$context = $this->context->module->getInfo();

use projeto\helpers\Html;

$conts = \app\modules\comercial\models\ViewContratosSearch::find()->where("
    cod_cliente_fk = {$cod_cliente} AND 
    atributos_setor = " . \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('setores', '1') . " AND 
    atributos_tipo_contrato IN (" . \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contrato', 'proposta') . ")")->asArray()->orderBy('cod_contrato desc');

$provider = new \yii\data\ActiveDataProvider([
    'query' => $conts,
    'sort' => [
        'attributes' => ['cod_cliente'],
    ],
    'pagination' => [
        'pageSize' => 10,
    ],
        ]);

?>

<div class='row'>
    <?php if (isset($msg)) { ?>
        <div class="col-md-12">
            <div class="alert-<?= $msg['tipo'] ?> alert fade in">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <i class="icon fa fa-<?= $msg['icon'] ?>"></i>
                <?= $msg['msg'] ?>
            </div>
        </div>
    <?php } ?>
</div>
<div class='row'>
    <div class='col-md-12'>
        <?=
        \projeto\helpers\Html::button('<i class="glyphicon glyphicon-plus"></i> Nova proposta', [
            'class' => 'btn btn-success btn-sm',
            'id' => 'addProposta',
            'onclick' => 'openProposta()',
        ])
        ?>
    </div>
</div> 

<br/>


<?php if ($conts) : ?>

    <div class='row'>

        <div class='col-md-12'>
            <?=
            yii\grid\GridView::widget([
                'dataProvider' => $provider,
                'columns' => [
                    'cod_contrato',
                    [
                        'attribute' => 'dsc_tipo_produto',
                        'label' => 'Serviço'
                    ],
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
                        }
                    ],
                    'txt_login',
                    'dt_inclusao_contrato',
                    'txt_notificacao_res',
                    'dt_inclusao_andamento',
                    'txt_login_andamento',
                    [
                        'attribute' => 'dt_retorno',
                        'content' => function($data) {
                            switch ($data['status_andamento_retorno']) {
                                case 1: $cor = '#FF0000';
                                    break;
                                case 2: $cor = '#DAA520';
                                    break;
                                case 3: $cor = '#000';
                                    break;
                            }

                            return "<div style='color:{$cor}'><b>" . $data['dt_retorno'] . '</b></div>';
                        }
                    ],
//                [
//                    'attribute' => 'numero',
//                    'label' => 'Número',
//                ],
//                [
//                    'attribute' => 'valor',
//                    'content' => function($data) {
//
//                        return \projeto\Util::decimalFormatToBank($data['valor']);
//                    },
//                ],
//                array(
//                    'attribute' => 'dt_vencimento',
//                    'label' => 'Vencimento',
//                    'content' => function($data) {
//
//
//                        return date('d/m/Y H:i:s', strtotime($data['dt_vencimento']));
//                    },
//                ),
                    ['class' => 'projeto\grid\ActionColumn',
                        'template' => '{andamento} {fechar} {recusar}',
                        'buttons' => [
                            'andamento' => function ($action, $model, $key) {


                                return Html::a('<span class="fa  fa-commenting-o"></span>', '#', [
                                            'arialabel' => 'Andamento',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Andamento',
                                            'onclick' => "return adicionarAndamentoContrato('" . $model['cod_setor'] . "', '" . $model['cod_contrato'] . "', 1)",
                                ]);
                            },
                            'fechar' => function ($action, $model, $key) {

                                if ($model['sgl_status'] == '1') {
                                    return Html::a('<span class="fa fa-check"></span>', '#', [
                                                'arialabel' => 'Fechar Contrato',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Fechar Contrato',
                                                'onclick' => "return openGerarContrato('" . $model['cod_contrato'] . "', '3', '" . $model['cod_setor'] . "',  '" . $model['cod_tipo_contrato'] . "')",
                                    ]);
                                }
                            },
                            'recusar' => function ($action, $model, $key) {
                                if ($model['sgl_status'] == '1') {
                                    return Html::a('<span class="fa fa-close"></span>', '#', [
                                                'arialabel' => 'Recusar Proposta',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Recusar Proposta',
                                                'onclick' => "return mudarStatus('" . $model['cod_contrato'] . "', '2', '" . $model['cod_setor'] . "',  '" . $model['cod_tipo_contrato'] . "')",
                                    ]);
                                }
                            },
                        ]
                    ],
                ],
            ]);
            ?>
        </div>
    </div> 

<?php endif; ?>
