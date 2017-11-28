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
    'header' => '<h3><div id="tituloTipoCliente">Incluir Cliente</div></h3>',
    'id' => 'modalCliente',
    'closeButton' => false,
    'size' => 'modal-md',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir Cliente', [
        'id' => 'botaoSalvarCliente',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);



$contrato = new \app\modules\comercial\models\TabContratoSearch();
$tipo_contrato = new \app\modules\comercial\models\TabTipoContratoSearch();
$tipo_contrato->cod_usuario_fk = \Yii::$app->user->id;
$model = new \app\models\TabContatoSearch();
$cliente = new app\models\TabClienteSearch();
?>

<div id="formCliente">
    <div class='row'>
        <div class='col-lg-6'>
            <?=
            $form->field($tipo_contrato, 'tipo_produto_fk')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                            app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                                app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-produto'])->one()['cod_atributos']
                            ])->orderBy('dsc_descricao')->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select']
            ]);
            ?>
         </div>
        <div class='col-lg-6'>
        <?= $form->field($cliente, 'responsavel')->textInput(['maxlength' => true]) ?>
            </div>
    </div>
     <div class='row'>
        <div class='col-sm-6'>
            <?=
            $form->field($model, 'tipo')->dropDownList(
                    ArrayHelper::map(
                            app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                                app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-contato'])->one()['cod_atributos']
                            ])->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select'],
            ]);
            ?>
        </div>

        <div class='col-sm-6' style="display:none" id="divContatoEmail">>
            <?= $form->field($model, 'contato_email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-sm-6' style="display:block" id="divContatoTelefone">
            <?=
            $form->field($model, 'contato')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
                'options' => [
                    'class' => 'form-control',
                ],
            ])->textInput(['maxlength' => true])
            ?>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-6'>

            <?=
            $form->field($tipo_contrato, 'cod_usuario_fk')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                            app\modules\admin\models\VisUsuariosPerfisSearch::find()->where(['modulo_id' => 'comercial'])->all(), 'cod_usuario_fk', 'txt_login'
                    ), ['prompt' => $this->app->params['txt-prompt-select'], 'id' => 'tabtipo-contratosearch-cod_usuario_fk', 'name' => 'TabTipoClienteSearch[cod_usuario_fk]'
            ]);
            ?>
        </div>   
    </div>
    
</div>

<?php Modal::end(); ?>