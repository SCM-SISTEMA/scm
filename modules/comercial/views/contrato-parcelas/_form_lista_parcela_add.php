<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

$labelNum = $labelVal = $labelVen = false;
if ($i == 0) {
    $labelNum = $parcela->getAttributeLabel('numero');
    $labelVal = $parcela->getAttributeLabel('valor');
    $labelVen = $parcela->getAttributeLabel('dt_vencimento');
}
?>



<div id="formFormaPagamento<?= $i; ?>">

    <?= $form->field($parcela, 'cod_contrato_fk')->hiddenInput(['id' => 'tabcontratoparcelassearch-' . $i . '-cod_contrato_fk', 'name' => 'TabContratoParcelasSearch[' . $i . '][cod_contrato_fk]'])->label(false); ?>

    <div class='row'>
        <div class='col-lg-4'>
            <?=
            $form->field($parcela, 'numero')->textInput(['class' => 'form-control somenteNumero', 'id' => 'tabcontratoparcelassearch-' . $i . '-numero', 'name' => 'TabContratoParcelasSearch[' . $i . '][numero]', 'disabled' => 'disabled'])->label($labelNum);
            ?>
        </div>

        <div class='col-lg-4'>

            <?=
            $form->field($parcela, 'valor')->textInput(['id' => 'tabcontratoparcelassearch-' . $i . '-valor', 'name' => 'TabContratoParcelasSearch[' . $i . '][valor]']
            )->widget(\kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'thousands' => '.',
                    'decimal' => ',',
                    'precision' => 2,
                    'allowZero' => false,],
                'options' => [
                    'class' => 'form-control',
                    'id' => 'tabcontratoparcelassearch-' . $i . '-valor',
                    'name' => 'TabContratoParcelasSearch[' . $i . '][valor]'
                ],
            ])->label($labelVal);
            ?>
        </div>

        <div class='col-lg-4'>
            <?=
            $form->field($parcela, 'dt_vencimento')->textInput([
                    'id' => 'tabcontratoparcelassearch-' . $i . '-dt_vencimento',
                    'name' => 'TabContratoParcelasSearch[' . $i . '][dt_vencimento]'
                ])->widget(
                    \dosamigos\datepicker\DatePicker::className(), [
                'language' => 'pt-BR',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy'
                ],
                'options' => [
                    'id' => 'tabcontratoparcelassearch-' . $i . '-dt_vencimento',
                    'name' => 'TabContratoParcelasSearch[' . $i . '][dt_vencimento]'
                ],
            ])->label($labelVen);
            ?>
        </div>
    </div>
</div>

