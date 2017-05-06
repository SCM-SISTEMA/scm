
<div class='row'  style='margin-top: 74px;'>
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'despesa_operacao_manutencao')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>

</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'despesa_publicidade')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>

</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'despesa_vendas')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>

</div>
<div class='row'>
    <div class='col-lg-12' style="height: 147px;">
        <?=
        $form->field($sici, 'despesa_link')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>

</div>
<div class='row'  style="margin-top: 76px;">
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'total_despesa')->textInput(['disabled' => true]);
        ?>
    </div>

</div>
<div class='row'>
    <div class='col-lg-12'>
        <?= $form->field($sici, 'obs_despesa')->textarea(['rows' => 6]) ?>
    </div>
</div>