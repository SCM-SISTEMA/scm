
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'despesa_operacao_manutencao', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
         <?= $form->field($sici, 'despesa_operacao_manutencao_check')->hiddenInput(['maxlength' => true])->label(false); ?>
    </div>

</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'despesa_publicidade', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
         <?= $form->field($sici, 'despesa_publicidade_check')->hiddenInput(['maxlength' => true])->label(false); ?>
    </div>

</div>
<div class='row'>
    <div class='col-lg-12'>
        <?=
        $form->field($sici, 'despesa_vendas', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?> <?= $form->field($sici, 'despesa_vendas_check')->hiddenInput(['maxlength' => true])->label(false); ?>
    </div>

</div>
<div class='row'>
    <div class='col-lg-12' style="height: 147px;">
        <?=
        $form->field($sici, 'despesa_link', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?> <?= $form->field($sici, 'despesa_link_check')->hiddenInput(['maxlength' => true])->label(false); ?>
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