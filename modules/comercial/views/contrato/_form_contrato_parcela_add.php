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
    'header' => '<h3><div id="tituloFormaPagamentoContrato">Incluir forma de pagamento</div></h3>',
    'id' => 'modalFormaPagamentoContrato',
    'closeButton' => false,
    'size' => 'modal-md',
    'footer' =>
    Html::a('Fechar', '#', ['class' => 'btn btn-default', 'id' => 'botaoFechar', 'data-dismiss' => 'modal'])
    . PHP_EOL .
    Html::button('Gerar Pagamento', [
        'id' => 'botaoSalvarFormaPagamentoContrato',
        'class' => 'btn btn-primary',
    ]),
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => FALSE
    ]
]);

$contrato = new \app\modules\comercial\models\TabContratoSearch();
?>

<div id="formFormaPagamentoContrato">
    <?= $form->field($contrato, 'cod_contrato')->hiddenInput(['id' => 'tabcontratopsearch-cod_contrato', 'name' => 'TabContratoPSearch[cod_contrato]'])->label(false); ?>

    <div class='row'>
        <div class='col-lg-4'>

            <?=
            $form->field($contrato, 'valor_contrato')->textInput(['id' => 'tabcontratopsearch-valor_contrato', 'name' => 'TabContratoPSearch[valor_contrato]']
            )->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'id' => 'tabcontratopsearch-valor_contrato',
                    'name' => 'TabContratoPSearch[valor_contrato]',
                    'class' => 'form-control',
                ],
            ]);
            ?>
        </div>

        <div class='col-lg-4'>
            <?=
            $form->field($contrato, 'qnt_parcelas')->textInput(['id' => 'tabcontratopsearch-qnt_parcelas', 'name' => 'TabContratoPSearch[qnt_parcelas]', 'class' => 'form-control somenteNumero']);
            ?>
        </div>


        <div class='col-lg-4'>
            <?=
            $form->field($contrato, 'dt_vencimento')->textInput(['id' => 'tabcontratopsearch-dt_vencimento', 'name' => 'TabContratoPSearch[dt_vencimento]'])->widget(
                    \dosamigos\datepicker\DatePicker::className(), [
                'language' => 'pt-BR',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy'
                ], 'options' => [
                    'id' => 'tabcontratopsearch-dt_vencimento',
                    'name' => 'TabContratoPSearch[dt_vencimento]',
                ],
            ]);
            ?>
        </div>
    </div>
</div>
<?php Modal::end(); ?>