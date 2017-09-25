<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\TabContato */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'header' => '<h3><div id="tituloTipoContrato">Incluir Contrato</div></h3>',
    'id' => 'modalContrato',
    'closeButton' => false,
    'size' => 'modal-md',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Incluir Contrato', [
        'id' => 'botaoSalvarContrato',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);



$contrato = new \app\modules\comercial\models\TabContratoSearch();

$tipo_contrato = new \app\modules\comercial\models\TabTipoContratoSearch();
?>

<div id="formContrato">
    <div class='row'>
        <div class='col-lg-4'>
            <?=
            $form->field($contrato, 'tipo_contrato_fk')->dropDownList(
                    yii\helpers\ArrayHelper::map(
                            app\models\TabAtributosValoresSearch::find()->where(['fk_atributos_valores_atributos_id' =>
                                app\models\TabAtributosSearch::find()->where(['sgl_chave' => 'tipo-contrato'])->one()['cod_atributos']
                            ])->orderBy('dsc_descricao')->all(), 'cod_atributos_valores', 'dsc_descricao'
                    ), ['prompt' => $this->app->params['txt-prompt-select']
            ]);
            ?>
        </div>
        <div class='col-lg-4'>
            <?=
            $form->field($contrato, 'valor_contrato')->textInput(
            )->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control',
                ],
            ]);
            ?>
        </div>
        <div class='col-lg-4'>
            <?=
            $form->field($contrato, 'dt_prazo')->textInput()->widget(
                    \dosamigos\datepicker\DatePicker::className(), [
                'language' => 'pt-BR',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy'
                ]
            ]);
            ?>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-4'>
            <?=
            $form->field($contrato, 'qnt_parcelas')->textInput(['class' => 'form-control somenteNumero']);
            ?>
        </div>
        <div class='col-lg-4'>
             
            <?=
            $form->field($contrato, 'dt_vencimento')->textInput()->widget(
                    \dosamigos\datepicker\DatePicker::className(), [
                'language' => 'pt-BR',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy'
                ]
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
                    ), ['prompt' => $this->app->params['txt-prompt-select'], 'id' => 'tabtipo-contratosearch-cod_usuario_fk', 'name' => 'TabTipoContratoSearch[cod_usuario_fk]'
            ]);
            ?>
        </div>   
    </div>

</div>
<?php Modal::end(); ?>