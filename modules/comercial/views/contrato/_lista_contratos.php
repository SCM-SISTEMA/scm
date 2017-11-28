<?php
$context = $this->context->module->getInfo();

use projeto\helpers\Html;

$conts = \app\modules\comercial\models\ViewContratosSearch::find()->where("
    cod_cliente_fk = {$cod_cliente} AND 
    atributos_setor = ".\app\models\TabAtributosValoresSearch::getAtributoValorAtributo('setores', '1')." AND 
    atributos_tipo_contrato NOT IN (".\app\models\TabAtributosValoresSearch::getAtributoValorAtributo('tipo-contrato', 'proposta').")")->asArray()->orderBy('cod_contrato desc');

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


<!--<div class='row'>
    <?php //if (isset($msg)) { ?>
        <div class="col-md-12">
            <div class="alert-<?php//= $msg['tipo'] ?> alert fade in">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <i class="icon fa fa-<?php //=$msg['icon'] ?>"></i>
                <?php //=['msg'] ?>
            </div>
        </div>
    <?php //} ?>
</div>-->
<!--<div class='row'>
    <div class='col-md-12'>
        <?php
//        \projeto\helpers\Html::button('<i class="glyphicon glyphicon-plus"></i> Novo Contrato', [
//            'class' => 'btn btn-success btn-sm',
//            'id' => 'addContrato',
//            'onclick' => 'adicionarProposta()',
//        ])
        ?>
    </div>
</div> -->

<br/>


<?php if ($conts) : ?>

    <div class='row'>

        <div class='col-md-12'>
            <?=
            yii\grid\GridView::widget([
                'dataProvider' => $provider,
                'columns' => [
                    'cod_contrato',
                    'dsc_tipo_contrato',
                    [
                        'attribute' => 'valor_contrato',
                        'content' => function($data) {

                            return projeto\Util::decimalFormatToBank($data['valor_contrato']);
                        },
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
                    'qnt_parcelas',
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
                        'template' => '{update}  {cancelar}  {andamento}  {formaPagamento} {upload} {imprimir}',
                        'buttons' => [

                            'update' => function ($action, $model, $key) {

                                if ($model['sgl_status'] == '1' || strpos($this->context->module->getInfo()['usuario-perfil']['txt_login'], 'administrador') !== false) {
                                    return Html::a('<span class="fa fa-edit"></span>', '#', [
                                                'title' => 'Alterar',
                                                'aria-label' => 'Alterar',
                                                'data-toggle' => 'tooltip',
                                                'onclick' => "return editarContrato('" . $model['cod_contrato'] . "')",
                                    ]);
                                }
                            },
                            'cancelar' => function ($action, $model, $key) {
                                if ($model['sgl_status'] == '1' || strpos($this->context->module->getInfo()['usuario-perfil']['txt_login'], 'administrador') !== false) {
                                    return Html::a('<span class="fa fa-trash"></span>', '#', [
                                                'title' => 'Cancelar',
                                                'data-toggle' => 'tooltip',
                                                'onclick' => "return excluirContrato('" . $model['cod_contrato'] . "')",
                                    ]);
                                }
                            },
                            'andamento' => function ($action, $model, $key) {
                                if ($model['sgl_status'] == '1' || strpos($this->context->module->getInfo()['usuario-perfil']['txt_login'], 'administrador') !== false) {
                                    return Html::a('<span class="fa  fa-commenting-o"></span>', '#', [
                                                'arialabel' => 'Andamento',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Andamento',
                                                'onclick' => "return adicionarAndamentoContrato('" . $model['cod_setor'] . "', '" . $model['cod_contrato'] . "', 2)",
                                    ]);
                                }
                            },
                            'formaPagamento' => function ($action, $model, $key) {
                                if ($model['sgl_status'] == '1' || strpos($this->context->module->getInfo()['usuario-perfil']['txt_login'], 'administrador') !== false) {
                                    return Html::a('<span class="fa fa-dollar"></span>', '#', [
                                                'arialabel' => 'Forma de pagamento',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Forma de pagamento',
                                                'onclick' => "return adicionarFormaPagamentoContrato('" . $model['cod_contrato'] . "', '".$model['valor_contrato']."')",
                                    ]);
                                }
                            },
                           'upload' => function ($action, $model, $key) {
                                if ($model['sgl_status'] == '1' || strpos($this->context->module->getInfo()['usuario-perfil']['txt_login'], 'administrador') !== false) {
                                    return Html::a('<span class="fa fa-download"></span>', '#', [
                                                'arialabel' => 'Importar Contrato',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'importar Contrato',
                                                'onclick' => "return abrirImportacao('" . $model['cod_contrato'] . "')",
                                    ]);
                                }
                            },
                                    
                            'imprimir' => function ($action, $model, $key) {
                                if ($model['sgl_status'] == '1' || strpos($this->context->module->getInfo()['usuario-perfil']['txt_login'], 'administrador') !== false) {
                                    return Html::a('<span class="fa fa-print"></span>', '#', [
                                                'arialabel' => 'Imprimir Contrato',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Imprimir Contrato',
                                                'onclick' => "return abrirImpressao('" . $model['cod_contrato'] . "')",
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
