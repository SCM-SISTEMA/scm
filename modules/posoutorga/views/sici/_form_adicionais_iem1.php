<div class='row'>

    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_planta')->textInput(['disabled' => true]);
        ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_marketing_propaganda', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'total_marketing_propaganda_check')->hiddenInput()->label(false); ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'aplicacao_equipamento', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'aplicacao_equipamento_check')->hiddenInput()->label(false); ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'aplicacao_software', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'aplicacao_software_check')->hiddenInput()->label(false); ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_pesquisa_desenvolvimento', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'total_pesquisa_desenvolvimento_check')->hiddenInput()->label(false); ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'aplicacao_servico', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'aplicacao_servico_check')->hiddenInput()->label(false); ?>
    </div>
</div>
<div class='row'>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'aplicacao_callcenter', $addon)->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
        <?= $form->field($sici, 'aplicacao_callcenter_check')->hiddenInput()->label(false); ?>
    </div>

</div>