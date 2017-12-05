<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TabContato */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloProposta">Incluir proposta</div></h3>',
    'id' => 'modalProposta',
    'closeButton' => false,
    'size' => 'modal-sm',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir proposta', [
        'id' => 'botaoSalvarProposta',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);


$tipo_contrato = new \app\modules\comercial\models\TabTipoContratoSearch();
$tipo_contrato->cod_usuario_fk = \Yii::$app->user->id;

?>

<div id="formProposta">
    <div class='row'>
        <div class='col-lg-12'>
            <?=
            $form->field($tipo_contrato, 'tipo_produto_fk')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                            app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                                app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-produto'])->one()['cod_atributos']
                            ])->orderBy('dsc_descricao')->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select'], 'id' => 'tabpropostasearch-tipo_produto_fk', 'name' => 'TabPropostaSearch[tipo_produto_fk]'
            ]);
            ?>
        </div>
    </div>

    <div class='row'>
        <div class='col-lg-12'>

            <?=
            $form->field($tipo_contrato, 'cod_usuario_fk')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                            app\modules\admin\models\VisUsuariosPerfisSearch::find()->where(['modulo_id' => 'comercial'])->all(), 'cod_usuario_fk', 'txt_login'
                    ), ['prompt' => $this->app->params['txt-prompt-select'], 'id' => 'tabpropostasearch-cod_usuario_fk', 'name' => 'TabPropostaSearch[cod_usuario_fk]'
            ]);
            ?>
        </div>   
    </div>

</div>

<?php Modal::end(); ?>