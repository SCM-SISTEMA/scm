<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\TabClienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->registerJsFile("@web/js/app/comercial.andamento.js?{$this->app->version}", ['position' => $this::POS_END, 'depends' => [\app\assets\ProjetoAsset::className()]]);
$this->registerJsFile('@web/js/app/admin.cliente.js', ['position' => $this::POS_END, 'depends' => [\app\assets\ProjetoAsset::className()]]);
$this->registerJsFile('@web/js/app/comercial.contrato.js', ['position' => $this::POS_END, 'depends' => [\app\assets\ProjetoAsset::className()]]);
?>

<div class="cliente-index box box-default">

    <div class="box-header with-border">
        <h3 class="box-title">Consulta</h3>
        <div class="box-tools pull-right">
            <?=
            Html::button('Incluir Cliente', [
                'id' => 'botaoOpenCliente',
                'class' => 'btn btn-success btn-sm',
            ]);
            ?>
        </div>
    </div>

    <div class="box-body with-border">
        <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'cnpj',
                'razao_social',
                'responsavel',
                'contato',
                'dsc_tipo_produto',
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
                'txt_notificacao_res',
                'txt_login',
                [
                    'attribute' => 'dt_retorno',
                    'content' => function($data) {

                        $cor = ($data['status_andamento_retorno'] == 2) ? '#DAA520' : (($data['status_andamento_retorno'] == 1) ? '#FF0000' : '#000');

                        return "<div style='color:{$cor}'><b>" . $data['dt_retorno'] . '</b></div>';
                    }
                ],
                ['class' => 'projeto\grid\ActionColumn',
                    'template' => '{admin} {andamento} {fechar} {recusar}',
                    'buttons' => [
                        'admin' => function ($action, $model, $key) {

                            return Html::a('<span class="fa fa-edit"></span>', Url::to(['cliente/admin', 'id' => $model->cod_cliente]), [
                                        'title' => 'Alterar',
                                        'aria-label' => 'Alterar',
                                        'data-toggle' => 'tooltip',
                                        'data-pjax' => '0',
                            ]);
                        },
                        'andamento' => function ($action, $model, $key) {

                            if ($model['sgl_status'] == '1') {
                                return Html::a('<span class="fa  fa-commenting-o"></span>', '#', [
                                            'arialabel' => 'Andamento',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Andamento',
                                            'onclick' => "return adicionarAndamentoContrato('" . $model->cod_setor . "', '" . $model->cod_contrato . "', 1)",
                                ]);
                            }
                        },
                        'fechar' => function ($action, $model, $key) {

                            if ($model['sgl_status'] == '1') {
                                return Html::a('<span class="fa fa-check"></span>', '#', [
                                            'arialabel' => 'Fechar Contrato',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Fechar Contrato',
                                            'onclick' => "return openGerarContrato('" . $model->cod_contrato . "', '3', '" . $model->cod_setor . "',  '" . $model->cod_tipo_contrato . "')",
                                ]);
                            }
                        },
                        'recusar' => function ($action, $model, $key) {
                            if ($model['sgl_status'] == '1') {
                                return Html::a('<span class="fa fa-close"></span>', '#', [
                                            'arialabel' => 'Recusar Proposta',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Recusar Proposta',
                                            'onclick' => "return mudarStatus('" . $model->cod_contrato . "', '2', '" . $model->cod_setor . "',  '" . $model->cod_tipo_contrato . "')",
                                ]);
                            }
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

<?php $form = ActiveForm::begin(['id'=>'formCliente']); ?>
<?php echo $this->render('@app/modules/comercial/views/contrato/_form_proposta_add', ['form' => $form]); ?> 
<?php echo $this->render('@app/modules/comercial/views/contrato/_form_pre_contrato_add', ['form' => $form]); ?> 
<?php echo $this->render('@app/views/andamento/_form_andamento_add', ['form' => $form]); ?> 

<?php ActiveForm::end(); ?>