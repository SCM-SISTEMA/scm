<?php
/* @var $this yii\web\View */
/* @var $searchModel app\modules\comercial\models\TabContratoParcelasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;

$dados = new \yii\data\ArrayDataProvider([
    'id' => 'lista-andamento',
    'allModels' => $contrato['andamentos']['contrato'],
    'sort' => false,
    'pagination' => ['pageSize' => false],
        ]);
?>
<div class='row'>

    <div class='col-lg-12'  style="text-align:right">
        <?=
        \projeto\helpers\Html::button('<i class="glyphicon glyphicon-plus"></i> Incluir Andamento', [
            'class' => 'btn btn-success btn-sm',
            'onclick' => "adicionarAndamentoContrato('{$contrato['attributes']['cod_contrato']}')",
        ])
        ?>
    </div>
</div> 
<br/>
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
<br />
<div class='row'>

    <div class='col-lg-12'>
        <?=
        GridView::widget([
            'dataProvider' => $dados,
            'columns' => [
                [
                    'attribute' => 'cod_assunto_fk',
                    'label' => 'Assunto',
                    'content' => function($data) {
                        $assunto = \app\models\TabAtributosValoresSearch::findOne(['cod_atributos_valores' => $data['cod_assunto_fk']]);


                        return $assunto->dsc_descricao;
                    },
                ],
                [
                    'attribute' => 'txt_notificacao',
                    'label' => 'Andamento',
                ],
                array(
                    'label' => 'Retorno',
                    'attribute' => 'dt_retorno',
                    'content' => function($data) {


                        return date('d/m/Y', strtotime($data['dt_retorno']));
                    }
                ),
                array(
                    'label' => 'Inclusão',
                    'attribute' => 'dt_inclusao',
                    'content' => function($data) {


                        return date('d/m/Y H:i:s', strtotime($data['dt_inclusao']));
                    },
                ),
                [
                    'label' => 'Usuário',
                    'attribute' => 'cod_usuario_inclusao_fk',
                    'content' => function($data) {

                        $user = app\modules\admin\models\TabUsuariosSearch::find()->where(['cod_usuario' => $data['cod_usuario_inclusao_fk']])->one();

                        return $user->txt_login;
                    },
                ],
            ],
        ]);
        ?>
    </div>
</div> 





