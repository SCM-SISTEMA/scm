<div class='row'>

    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_planta')->textInput(['disabled' => true]);
        ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_marketing_propaganda')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'aplicacao_equipamento')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'aplicacao_software')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'total_pesquisa_desenvolvimento')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'aplicacao_servico')->textInput()->widget(\kartik\money\MaskMoney::className(), [
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
    <div class='col-lg-6'>
        <?=
        $form->field($sici, 'aplicacao_callcenter')->textInput()->widget(\kartik\money\MaskMoney::className(), [
            'pluginOptions' => [
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2,
                'allowZero' => false,]
        ]);
        ?>
    </div>

</div>