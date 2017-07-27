<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabContato */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloTipoContrato">Incluir Serviço</div><h3>',
    'id' => 'modalTipoContrato',
    'closeButton' => false,
    'size' => 'modal-sm',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir Tipo Contrato', [
        'id' => 'botaoSalvarTipoContrato',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);
$tipo_contrato = new \app\modules\comercial\models\TabTipoContratoSearch();
?>

<div id="formTipoContrato">
    <div class='row'>
        <div class='col-lg-12'>
            <?= $form->field($tipo_contrato, 'cod_contrato_fk')->hiddenInput(['id' => 'tabtipocontratosearchservico-cod_contrato_fk', 'name' => 'TabTipoContratoSearchServico[cod_contrato_fk]'])->label(false); ?>
            <?=
            $form->field($tipo_contrato, 'cod_usuario_fk')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                            app\modules\admin\models\VisUsuariosPerfisSearch::find()->where(['modulo_id' => 'comercial'])->all(), 'cod_usuario_fk', 'txt_login'
                    ), ['prompt' => $this->app->params['txt-prompt-select'], 'id' => 'tabtipocontratosearchservico-cod_usuario_fk', 'name' => 'TabTipoContratoSearchServico[cod_usuario_fk]'
            ]);
            ?>
        </div>    </div>
    <div class='row'>
        <div class='col-lg-12'>

            <?=
            $form->field($tipo_contrato, 'tipo_produto_fk')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                            app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                                app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-produto'])->one()['cod_atributos']
                            ])->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select'], 'id' => 'tabtipocontratosearchservico-tipo_produto_fk', 'name' => 'TabTipoContratoSearchServico[tipo_produto_fk]'
            ]);
            ?>


        </div>
    </div>
</div>

<?php Modal::end(); ?>